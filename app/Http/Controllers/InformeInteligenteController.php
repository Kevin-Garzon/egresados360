<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Interaccion;
use App\Models\PerfilEgresado;
use App\Models\VisitaDiaria;
use OpenAI;
use Carbon\Carbon;
use League\CommonMark\CommonMarkConverter;

class InformeInteligenteController extends Controller
{
    public function generar(Request $request)
    {
        try {
            $periodo = $request->get('periodo', 'general');

            // ===========================
            // Filtrado por periodo
            // ===========================
            $fechaInicio = match ($periodo) {
                'dia' => now()->subDay(),
                'semana' => now()->subWeek(),
                'mes' => now()->subMonth(),
                default => null
            };

            $visitasQuery = VisitaDiaria::query();
            $interaccionesQuery = Interaccion::query();
            $egresadosQuery = PerfilEgresado::query();

            if ($fechaInicio) {
                $visitasQuery->where('fecha', '>=', $fechaInicio);
                $interaccionesQuery->where('interacciones.created_at', '>=', $fechaInicio);
                $egresadosQuery->where('perfiles_egresado.created_at', '>=', $fechaInicio);
            }

            // ===========================
            // Métricas principales
            // ===========================
            $totalVisitas = $visitasQuery->sum('total');
            $totalInteracciones = $interaccionesQuery->count();
            $totalEgresados = $egresadosQuery->count();

            // ===========================
            // Distribución de interacciones
            // ===========================
            $porModulo = (clone $interaccionesQuery)
                ->selectRaw('module, COUNT(*) as cantidad')
                ->groupBy('module')
                ->orderByDesc('cantidad')
                ->pluck('cantidad', 'module')
                ->toArray();

            // ===========================
            // Programas más activos
            // ===========================
            $porPrograma = Interaccion::join('perfiles_egresado', 'interacciones.perfil_id', '=', 'perfiles_egresado.id')
                ->when($fechaInicio, fn($q) => $q->where('interacciones.created_at', '>=', $fechaInicio))
                ->selectRaw('perfiles_egresado.programa, COUNT(*) as cantidad')
                ->groupBy('perfiles_egresado.programa')
                ->orderByDesc('cantidad')
                ->limit(5)
                ->pluck('cantidad', 'programa')
                ->toArray();

            // ===========================
            // Preparar contexto y continuar igual...
            // ===========================

            $contexto = [
                'periodo' => $periodo,
                'visitas' => $totalVisitas,
                'interacciones' => $totalInteracciones,
                'egresados' => $totalEgresados,
                'por_modulo' => $porModulo,
                'por_programa' => $porPrograma,
            ];

            // ===========================
            // Prompt profesional
            // ===========================
            $prompt = <<<EOT
                Eres un **analista institucional experto en educación superior**, especializado en la redacción de **informes ejecutivos y de gestión académica**.

                Tu tarea es generar un **informe profesional completo y detallado** sobre la actividad del **Portal Egresados 360** de la Fundación Escuela Tecnológica de Neiva “Jesús Oviedo Pérez” (FET), usando el conjunto de datos proporcionado en formato JSON.

                ** Instrucciones de redacción:**
                - Usa un **tono institucional, técnico y formal**, como si el informe estuviera dirigido a la coordinación de Egresados y a la Dirección Académica.  
                - Usa redacción fluida, con conectores y lenguaje de gestión.  
                - Evita repetir datos sin analizarlos: interpreta lo que significan.  
                - Usa subtítulos claros y consistentes (nivel 2 o 3 de encabezado).  
                - Agrega conclusiones interpretativas, no solo descripciones.  
                - Sé extenso: entre **700 y 1000 palabras**.  
                - Utiliza una **estructura jerárquica con numeración** y formato ordenado.

                ---

                ### ESTRUCTURA DEL INFORME:

                1. **Introducción institucional**  
                Explica el propósito del informe, el periodo analizado (general, mes, semana o día), y la relevancia del portal Egresados 360 dentro de la estrategia de vinculación de egresados FET.

                2. **Resumen general de actividad**  
                Expón las cifras globales (visitas, interacciones, egresados registrados).  
                Interpreta qué representan en términos de participación o crecimiento.  
                Si los valores son bajos, señala posibles causas institucionales.

                3. **Análisis de comportamiento y uso del portal**  
                Examina las dinámicas de acceso, participación y comportamiento.  
                Analiza la proporción entre egresados identificados y anónimos.  
                Describe los picos o descensos según los módulos o acciones.

                4. **Desglose por módulos del portal**  
                Detalla la actividad registrada en los módulos principales:  
                - **Laboral**: ofertas consultadas o aplicaciones realizadas.  
                - **Formación Continua**: cursos o diplomados con mayor interés.  
                - **Bienestar Institucional**: mentorías, talleres o espacios de escucha.  
                Describe tendencias, participación y posibles áreas de mejora.

                5. **Participación académica (por programa y año de egreso)**  
                Resume cuántos egresados participaron por programa académico.  
                Identifica los programas más activos y los menos representados.  
                Menciona los rangos de año de egreso con mayor interacción.

                6. **Análisis interpretativo y tendencias institucionales**  
                Explica qué comportamientos son más notables o inusuales.  
                Si hay disminución o crecimiento, plantea causas (comunicación, visibilidad, actividades).  
                Incluye una lectura cualitativa: qué podría estar motivando esas cifras.

                7. **Recomendaciones estratégicas**  
                Propón acciones concretas y justificadas con base en los datos.  
                Ejemplo: campañas de divulgación, actualización de contenido, incentivos para registro, alianzas con bienestar o empleabilidad, etc.  
                Incluye entre 3 y 5 recomendaciones.

                8. **Conclusión institucional**  
                Cierra el informe con una síntesis clara del impacto del portal, su importancia dentro del ecosistema FET y una reflexión sobre la mejora continua del vínculo con los egresados.

                ---

                ### DATOS DISPONIBLES:
            EOT;


            // ===========================
            // Llamada a OpenAI
            // ===========================
            $client = OpenAI::client(env('OPENAI_API_KEY'));

            $response = $client->chat()->create([
                'model' => 'gpt-4o-mini',
                'messages' => [
                    ['role' => 'system', 'content' => 'Eres un analista institucional experto en educación superior.'],
                    ['role' => 'user', 'content' => $prompt . json_encode($contexto, JSON_PRETTY_PRINT)],
                ],
            ]);

            $informe = $response->choices[0]->message->content ?? 'No se pudo generar el informe.';

            return response()->json([
                'success' => true,
                'informe' => $informe,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'informe' => 'Error generando informe: ' . $e->getMessage(),
            ]);
        }
    }

    //Descargar PDF
    public function descargarPDF(Request $request)
    {
        try {
            $contenidoCodificado = $request->get('contenido', '');
            $contenido = urldecode($contenidoCodificado);

            // Convertir Markdown a HTML profesional
            $converter = new CommonMarkConverter([
                'html_input' => 'strip',
                'allow_unsafe_links' => false,
            ]);
            $contenidoHtml = $converter->convert($contenido)->getContent();

            $fecha = now()->format('d/m/Y H:i');

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.informe-inteligente', [
                'contenido' => $contenidoHtml,
                'fecha' => $fecha,
            ]);

            return $pdf->stream('informe_inteligente_' . now()->format('Ymd_His') . '.pdf');
        } catch (\Exception $e) {
            return response('Error generando PDF: ' . $e->getMessage());
        }
    }
}
