<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Interaccion;
use App\Models\PerfilEgresado;
use App\Models\Formacion;
use App\Models\OfertaLaboral;

class TrackingController extends Controller
{
    public function registrarInteraccion(Request $request)
    {
        $validated = $request->validate([
            'module'     => 'required|string|max:50',
            'action'     => 'required|string|max:50',
            'item_type'  => 'nullable|string|max:50',
            'item_id'    => 'nullable|integer',
            'item_title' => 'nullable|string|max:255',
            'perfil_id'  => 'nullable|integer|exists:perfiles_egresado,id',
            'url'        => 'nullable|string|max:255',
        ]);

        // 1) Crear interacción
        $interaccion = Interaccion::create([
            'module'       => $validated['module'],
            'action'       => $validated['action'],
            'item_type'    => $validated['item_type'] ?? null,
            'item_id'      => $validated['item_id'] ?? null,
            'item_title'   => $validated['item_title'] ?? null,
            'perfil_id'    => $validated['perfil_id'] ?? null,
            'is_anonymous' => empty($validated['perfil_id']),
            'ip'           => $request->ip(),
            'user_agent'   => substr($request->userAgent(), 0, 250),
        ]);

        // 2) Reglas de redirección especiales → WhatsApp Business
        if (!empty($validated['perfil_id'])) {
            $perfil  = PerfilEgresado::find($validated['perfil_id']);
            $tipo    = strtolower($validated['item_type'] ?? '');
            $titulo  = $validated['item_title'] ?? '';
            $itemId  = $validated['item_id'] ?? null;

            if ($perfil) {
                $nombre   = $perfil->nombre   ?? 'un egresado';
                $programa = $perfil->programa ?? 'su programa';
                $anio     = $perfil->anio_egreso ?? 'su año de egreso';


                // Número por defecto (general)
                $numero_general = '573224650595';

                // Números específicos por área
                $numero_bienestar = '573173684913';
                $numero_formacion = '573223042498';
                $numero_laboral   = '573224650595';

                $mensaje = null;
                $numero  = $numero_general; // valor por defecto


                switch ($tipo) {
                    case 'mentoria':
                        $mensaje = "Buen día, soy {$nombre}, egresado de {$programa} en el año {$anio}, y me interesa la mentoría \"{$titulo}\".";
                        $numero  = $numero_bienestar; // redirige al número de Bienestar
                        break;

                    case 'atencion':
                        $mensaje = "Buen día, soy {$nombre}, egresado de {$programa} en el año {$anio}, y deseo solicitar un espacio de escucha con Bienestar Institucional.";
                        $numero  = $numero_bienestar; // redirige al número de Bienestar
                        break;

                    case 'habilidad':
                        $mensaje = "Buen día, soy {$nombre}, egresado de {$programa} en el año {$anio}, y deseo inscribirme en el taller \"{$titulo}\".";
                        $numero  = $numero_bienestar; // redirige al número de Bienestar
                        break;

                    // Formación continua (si la empresa es FET)
                    case 'curso':
                        $formacion = Formacion::with('empresa')->find($itemId);
                        if ($formacion && $formacion->empresa && strtolower(trim($formacion->empresa->nombre)) === 'fet') {
                            $mensaje = "Buen día, soy {$nombre}, egresado de {$programa} en el año {$anio}, y deseo inscribirme en la oferta de formación \"{$titulo}\" organizada por la FET.";
                            $numero  = $numero_formacion; // redirige al número de Formación Continua
                        }
                        break;

                    // Ofertas laborales (si la empresa es FET)
                    case 'oferta':
                        $oferta = OfertaLaboral::with('empresa')->find($itemId);
                        if ($oferta && $oferta->empresa && strtolower(trim($oferta->empresa->nombre)) === 'fet') {
                            $mensaje = "Buen día, soy {$nombre}, egresado de {$programa} en el año {$anio}, y me interesa postularme a la oferta laboral \"{$titulo}\" publicada por la FET.";
                            $numero  = $numero_laboral; // redirige al número de Empleabilidad
                        }
                        break;
                }

                if ($mensaje) {
                    $mensaje   = urlencode($mensaje);
                    $ua        = strtolower($request->userAgent());
                    $isMobile  = str_contains($ua, 'mobile') || str_contains($ua, 'android') || str_contains($ua, 'iphone');

                    $enlace = $isMobile
                        ? "https://api.whatsapp.com/send?phone={$numero}&text={$mensaje}"
                        : "https://web.whatsapp.com/send?phone={$numero}&text={$mensaje}";

                    return response()->json([
                        'success'  => true,
                        'id'       => $interaccion->id,
                        'redirect' => $enlace,
                    ]);
                }
            }
        }

        // 3) Si no aplica caso especial → devolver URL normal (si viene)
        return response()->json([
            'success'  => true,
            'id'       => $interaccion->id,
            'redirect' => $validated['url'] ?? null,
        ]);
    }
}
