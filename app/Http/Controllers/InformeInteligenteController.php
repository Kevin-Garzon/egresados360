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
            $tipoInforme = $request->get('tipo_informe', 'institucional'); // institucional, comparativo, predictivo, modulo, express
            $periodo     = $request->get('periodo', 'general');           // dia, semana, mes, general
            $comparativo = $request->get('comparativo', 'mes_vs_mes_anterior');

            // ============================
            //  Módulo: solo válido para
            //  informe por módulo específico
            // ============================
            $modulosValidos = ['laboral', 'formacion', 'bienestar'];
            $moduloInput    = $request->get('modulo');
            $modulo         = in_array($moduloInput, $modulosValidos) ? $moduloInput : null;

            if ($tipoInforme !== 'modulo') {
                // Para todos los demás tipos, el análisis es del portal completo
                $modulo = null;
            }

            /* ============================================================
               1. INFORME COMPARATIVO (portal completo, sin filtro por módulo)
            ============================================================ */
            if ($tipoInforme === 'comparativo') {

                switch ($comparativo) {
                    case 'dia_vs_dia_semana_pasada':
                        $inicioActual   = now()->startOfDay();
                        $finActual      = now()->endOfDay();
                        $inicioAnterior = now()->subWeek()->startOfDay();
                        $finAnterior    = now()->subWeek()->endOfDay();
                        break;

                    case 'semana_vs_semana_anterior':
                        $inicioActual   = now()->startOfWeek();
                        $finActual      = now()->endOfWeek();
                        $inicioAnterior = now()->subWeek()->startOfWeek();
                        $finAnterior    = now()->subWeek()->endOfWeek();
                        break;

                    case 'mes_vs_mes_anterior':
                    default:
                        $inicioActual   = now()->startOfMonth();
                        $finActual      = now()->endOfMonth();
                        $inicioAnterior = now()->subMonth()->startOfMonth();
                        $finAnterior    = now()->subMonth()->endOfMonth();
                        break;
                }

                $buildContextRange = function (Carbon $inicio, Carbon $fin) {
                    // Visitas del dashboard
                    $visitasQuery = VisitaDiaria::query()
                        ->whereBetween('fecha', [
                            $inicio->toDateString(),
                            $fin->toDateString()
                        ]);

                    // Interacciones del portal (TODOS los módulos)
                    $interaccionesQuery = Interaccion::query()
                        ->whereBetween('created_at', [$inicio, $fin]);

                    // Egresados registrados en ese rango
                    $egresadosQuery = PerfilEgresado::query()
                        ->whereBetween('created_at', [$inicio, $fin]);

                    $totalVisitas       = $visitasQuery->sum('total');
                    $totalInteracciones = $interaccionesQuery->count();
                    $egresadosRegistrados = $egresadosQuery->count();

                    // Egresados activos: perfiles con interacciones no anónimas
                    $egresadosActivos = (clone $interaccionesQuery)
                        ->where('is_anonymous', false)
                        ->whereNotNull('perfil_id')
                        ->distinct('perfil_id')
                        ->count('perfil_id');

                    // Distribución por módulo
                    $porModulo = (clone $interaccionesQuery)
                        ->selectRaw('module, COUNT(*) as cantidad')
                        ->groupBy('module')
                        ->orderByDesc('cantidad')
                        ->pluck('cantidad', 'module')
                        ->toArray();

                    // Programas más activos
                    $porPrograma = Interaccion::join(
                            'perfiles_egresado',
                            'interacciones.perfil_id',
                            '=',
                            'perfiles_egresado.id'
                        )
                        ->whereBetween('interacciones.created_at', [$inicio, $fin])
                        ->selectRaw('perfiles_egresado.programa, COUNT(*) as cantidad')
                        ->groupBy('perfiles_egresado.programa')
                        ->orderByDesc('cantidad')
                        ->limit(10)
                        ->pluck('cantidad', 'programa')
                        ->toArray();

                    return [
                        'rango'                => [
                            'inicio' => $inicio->toDateTimeString(),
                            'fin'    => $fin->toDateTimeString(),
                        ],
                        'visitas'              => $totalVisitas,
                        'interacciones'        => $totalInteracciones,
                        'egresados_registrados'=> $egresadosRegistrados,
                        'egresados_activos'    => $egresadosActivos,
                        'por_modulo'           => $porModulo,
                        'por_programa'         => $porPrograma,
                    ];
                };

                $contexto = [
                    'tipo_informe' => 'comparativo',
                    'comparativo'  => $comparativo,
                    'actual'       => $buildContextRange($inicioActual, $finActual),
                    'anterior'     => $buildContextRange($inicioAnterior, $finAnterior),
                ];

                $prompt = <<<EOT
Eres un analista institucional experto en educación superior.

Debes generar un **INFORME COMPARATIVO** sobre el uso del portal Egresados 360 de la FET, comparando dos periodos del portal completo (módulos laboral, formación y bienestar en conjunto).

Utiliza las métricas entregadas (visitas, interacciones, egresados activos, distribución por módulos y por programas) para identificar aumentos, disminuciones o estabilidad.

Incluye las tablas en formato Markdown. Las tablas deben tener encabezados y mostrar:

- Comparativo general (Visitas, Interacciones, Egresados Registrados, Egresados Activos)
- Comparativo por módulos (formación, laboral, bienestar)
- Comparativo por programas (los más activos)

Asegúrate de que las tablas estén completas, sean claras y no contengan texto dentro de celdas con saltos de línea.


Extensión sugerida: 700–1000 palabras.
EOT;

                $client   = OpenAI::client(env('OPENAI_API_KEY'));
                $response = $client->chat()->create([
                    'model'    => 'gpt-4.1',
                    'messages' => [
                        ['role' => 'system', 'content' => 'Eres un analista institucional experto en educación superior.'],
                        ['role' => 'user',   'content' => $prompt . "\n\nDATOS EN JSON:\n" . json_encode($contexto, JSON_PRETTY_PRINT)],
                    ],
                ]);

                $informe = $response->choices[0]->message->content ?? 'No se pudo generar el informe comparativo.';

                return response()->json([
                    'success' => true,
                    'informe' => $informe,
                ]);
            }

            /* ============================================================
            2. INFORMES NO COMPARATIVOS
            (institucional, predictivo, módulo, express)
            ============================================================ */

            $fechaInicio = null;
            $fechaFin    = null;

            if ($tipoInforme !== 'predictivo') {
                switch ($periodo) {
                    case 'dia':
                        $fechaInicio = now()->startOfDay();
                        $fechaFin    = now()->endOfDay();
                        break;
                    case 'semana':
                        $fechaInicio = now()->startOfWeek();
                        $fechaFin    = now()->endOfWeek();
                        break;
                    case 'mes':
                        $fechaInicio = now()->startOfMonth();
                        $fechaFin    = now()->endOfMonth();
                        break;
                    default:
                        $fechaInicio = null;
                        $fechaFin    = null;
                }
            }

            // Consultas base (portal completo o módulo específico sólo si tipo = modulo)
            $visitasQuery       = VisitaDiaria::query();
            $interaccionesQuery = Interaccion::query();
            $egresadosQuery     = PerfilEgresado::query();

            if ($fechaInicio && $fechaFin) {
                $visitasQuery->whereBetween('fecha', [
                    $fechaInicio->toDateString(),
                    $fechaFin->toDateString()
                ]);

                $interaccionesQuery->whereBetween('created_at', [$fechaInicio, $fechaFin]);
                $egresadosQuery->whereBetween('created_at', [$fechaInicio, $fechaFin]);
            }

            if ($tipoInforme === 'modulo' && $modulo) {
                $interaccionesQuery->where('module', $modulo);
            }

            $totalVisitas          = $visitasQuery->sum('total');

            $baseInteracciones     = clone $interaccionesQuery;

            $totalInteracciones    = $baseInteracciones->count();
            $egresadosRegistrados  = $egresadosQuery->count();

            $egresadosActivos      = (clone $baseInteracciones)
                ->where('is_anonymous', false)
                ->whereNotNull('perfil_id')
                ->distinct('perfil_id')
                ->count('perfil_id');

            $porModulo = (clone $baseInteracciones)
                ->selectRaw('module, COUNT(*) as cantidad')
                ->groupBy('module')
                ->orderByDesc('cantidad')
                ->pluck('cantidad', 'module')
                ->toArray();

            $porProgramaQuery = Interaccion::join(
                    'perfiles_egresado',
                    'interacciones.perfil_id',
                    '=',
                    'perfiles_egresado.id'
                );

            if ($fechaInicio && $fechaFin) {
                $porProgramaQuery->whereBetween('interacciones.created_at', [$fechaInicio, $fechaFin]);
            }

            if ($tipoInforme === 'modulo' && $modulo) {
                $porProgramaQuery->where('interacciones.module', $modulo);
            }

            $porPrograma = $porProgramaQuery
                ->selectRaw('perfiles_egresado.programa, COUNT(*) as cantidad')
                ->groupBy('perfiles_egresado.programa')
                ->orderByDesc('cantidad')
                ->limit(10)
                ->pluck('cantidad', 'programa')
                ->toArray();

            $contexto = [
                'tipo_informe'          => $tipoInforme,
                'periodo'               => $periodo,
                'modulo'                => $modulo,
                'visitas'               => $totalVisitas,
                'interacciones'         => $totalInteracciones,
                'egresados_registrados' => $egresadosRegistrados,
                'egresados_activos'     => $egresadosActivos,
                // Por compatibilidad, "egresados" será egresados activos
                'egresados'             => $egresadosActivos,
                'por_modulo'            => $porModulo,
                'por_programa'          => $porPrograma,
            ];

            // ============================
            //  Prompts específicos
            // ============================

            $promptInstitucional = <<<EOT
Eres un analista institucional experto en educación superior.

Debes generar un **INFORME INSTITUCIONAL** sobre el uso del portal Egresados 360 de la FET.

El análisis se basa en:
- visitas totales al portal
- interacciones registradas
- egresados activos (perfiles que han interactuado en el periodo)
- egresados registrados
- distribución de uso por módulos (laboral, formación, bienestar)
- participación por programas académicos

Solo analiza los módulos "laboral", "formación" y "bienestar". No menciones otros módulos que no generan interacciones.

Extensión: 700–1000 palabras.
EOT;

            $promptPredictivo = <<<EOT
Eres un analista de datos institucional experto en educación superior.

Debes generar un **INFORME PREDICTIVO** sobre el comportamiento futuro del portal Egresados 360, considerando en conjunto los módulos laboral, formación y bienestar.

Utiliza las métricas actuales (visitas, interacciones, egresados activos, distribución por módulos y programas) para:
- identificar tendencias
- proyectar escenarios a corto plazo (3–6 meses)
- señalar riesgos y oportunidades
- proponer acciones preventivas y de mejora

Extensión: 700–1000 palabras.
EOT;

            $promptModulo = <<<EOT
Eres un analista institucional especializado en evaluación de servicios.

Debes generar un **INFORME POR MÓDULO ESPECÍFICO** del portal Egresados 360. En los datos JSON se indica cuál módulo se está analizando (laboral, formación o bienestar).

Analiza:
- actividad y uso del módulo
- egresados activos en el módulo
- comparación del módulo frente al resto del portal
- fortalezas y debilidades
- recomendaciones específicas para fortalecer ese módulo

Extensión: 600–900 palabras.
EOT;

            $promptExpress = <<<EOT
Debes generar un **INFORME EXPRESS RESUMIDO** sobre el estado actual del portal Egresados 360.

Máximo 10–15 líneas.

Incluye:
- 3 a 5 cifras clave (visitas, interacciones, egresados activos, módulo más usado o programa más activo)
- una frase corta de diagnóstico general
- 3 recomendaciones concretas en formato de lista o viñetas
EOT;

            $prompt = match ($tipoInforme) {
                'predictivo' => $promptPredictivo,
                'modulo'     => $promptModulo,
                'express'    => $promptExpress,
                default      => $promptInstitucional,
            };

            $client   = OpenAI::client(env('OPENAI_API_KEY'));
            $response = $client->chat()->create([
                'model'    => 'gpt-4.1',
                'messages' => [
                    ['role' => 'system', 'content' => 'Eres un analista institucional experto en educación superior.'],
                    ['role' => 'user',   'content' => $prompt . "\n\nDATOS EN JSON:\n" . json_encode($contexto, JSON_PRETTY_PRINT)],
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

    // ============================================================
    // DESCARGA PDF
    // ============================================================
    public function descargarPDF(Request $request)
    {
        try {
            $contenidoCodificado = $request->get('contenido', '');
            $contenido = urldecode($contenidoCodificado);

            $converter = new CommonMarkConverter([
                'html_input' => 'strip',
                'allow_unsafe_links' => false,
            ]);
            $contenidoHtml = $converter->convert($contenido)->getContent();

            $fecha = now()->format('d/m/Y H:i');

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.informe-inteligente', [
                'contenido' => $contenidoHtml,
                'fecha'     => $fecha,
            ]);

            return $pdf->stream('informe_inteligente_' . now()->format('Ymd_His') . '.pdf');

        } catch (\Exception $e) {
            return response('Error generando PDF: ' . $e->getMessage());
        }
    }
}
