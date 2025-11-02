<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

use App\Http\Controllers\{
    InicioController,
    ProfileController,
    LaboralController,
    FormacionController,
    BienestarController,
};

use App\Livewire\Admin\{
    Laboral\LaboralPanel,
    Formacion\FormacionPanel,
    Bienestar\Habilidades\HabilidadesPanel,
    Bienestar\Servicios\ServiciosPanel,
    Bienestar\Eventos\EventosPanel,
    Bienestar\Mentorias\MentoriasPanel
};

use App\Models\{
    Formacion,
    OfertaLaboral,
    PerfilEgresado,
    Interaccion,
    VisitaDiaria
};

use App\Exports\Sheets\{
    VisitasSheet,
    InteraccionesSheet,
    EgresadosSheet,
    OfertasSheet,
    FormacionesSheet,
    EmpresasSheet,
    ServiciosSheet,
    HabilidadesSheet,
    EventosSheet
};





/* ============================================================
|  PÁGINAS PÚBLICAS
|============================================================ */

Route::get('/', [InicioController::class, 'index'])->name('inicio');


// --- Ofertas Laborales ---
Route::get('/laboral', [LaboralController::class, 'index'])->name('laboral.index');
Route::get('/api/oferta/{id}', fn($id) => OfertaLaboral::with('empresa')->findOrFail($id));


// --- Formación Continua ---
Route::get('/formacion', [FormacionController::class, 'index'])->name('formacion.index');
Route::get('/api/formacion/{id}', fn($id) => Formacion::with('empresa')->findOrFail($id));


// --- Bienestar Institucional ---
Route::get('/bienestar', [BienestarController::class, 'index'])->name('bienestar.index');
Route::get('/bienestar/habilidad/{id}', [BienestarController::class, 'show'])->name('bienestar.habilidad.show');
Route::get('/bienestar/servicio/{id}', [BienestarController::class, 'showServicio'])->name('bienestar.servicio.show');
Route::get('/bienestar/evento/{id}', [BienestarController::class, 'showEvento'])->name('bienestar.evento.show');


// --- Política de Tratamiento de Datos ---
Route::view('/politica-datos', 'politica-datos')->name('politica-datos');





/* ============================================================
|  AUTENTICACIÓN Y PERFIL ADMINISTRADOR
|============================================================ */

// Panel principal (Dashboard)
Route::get('/dashboard', \App\Livewire\Admin\Dashboard\DashboardPanel::class)
    ->middleware(['auth'])
    ->name('dashboard');

// Perfil de usuario administrador
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Archivo de rutas base de Breeze (mantiene login funcional)
require __DIR__ . '/auth.php';





/* ============================================================
|  PANELES ADMINISTRATIVOS (PROTEGIDOS)
|============================================================ */

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // Ofertas laborales
    Route::get('/laboral', LaboralPanel::class)->name('laboral.panel');

    // Formación continua
    Route::get('/formacion', FormacionPanel::class)->name('formacion.panel');

    // Bienestar institucional
    Route::get('/bienestar/habilidades', HabilidadesPanel::class)->name('bienestar.habilidades.panel');
    Route::get('/bienestar/servicios', ServiciosPanel::class)->name('bienestar.servicios.panel');
    Route::get('/bienestar/eventos', EventosPanel::class)->name('bienestar.eventos.panel');
    Route::get('/bienestar/mentorias', MentoriasPanel::class)->name('bienestar.mentorias.panel');
});





/* ============================================================
|  API INTERNA PARA MÉTRICAS E INTERACCIONES
|============================================================ */

// Registrar o actualizar perfil de egresado
Route::post('/api/profile/upsert', function (Request $request) {
    $validated = $request->validate([
        'nombre' => 'required|string|max:255',
        'correo' => 'required|email',
        'celular' => 'nullable|string|max:20',
        'programa' => 'nullable|string|max:255',
        'anio_egreso' => 'nullable|digits:4',
    ]);

    $perfil = PerfilEgresado::updateOrCreate(
        ['correo' => $validated['correo']],
        $validated
    );

    return response()->json([
        'success' => true,
        'perfil_id' => $perfil->id,
    ]);
});


// Registrar interacciones de usuario
Route::post('/api/track/interaction', function (Request $request) {
    $validated = $request->validate([
        'module' => 'required|string|max:50',
        'action' => 'required|string|max:50',
        'item_type' => 'nullable|string|max:50',
        'item_id' => 'nullable|integer',
        'item_title' => 'nullable|string|max:255',
        'perfil_id' => 'nullable|integer|exists:perfiles_egresado,id',
        'url' => 'nullable|string|max:255',
    ]);

    // Crear la interacción normalmente
    $interaccion = \App\Models\Interaccion::create([
        'module' => $validated['module'],
        'action' => $validated['action'],
        'item_type' => $validated['item_type'] ?? null,
        'item_id' => $validated['item_id'] ?? null,
        'item_title' => $validated['item_title'] ?? null,
        'perfil_id' => $validated['perfil_id'] ?? null,
        'is_anonymous' => empty($validated['perfil_id']),
        'ip' => $request->ip(),
        'user_agent' => substr($request->userAgent(), 0, 250),
    ]);

    // ==================================================
    // Redirecciones especiales hacia WhatsApp Business
    // ==================================================
    if (!empty($validated['perfil_id'])) {
        $perfil = PerfilEgresado::find($validated['perfil_id']);
        $tipo = strtolower($validated['item_type'] ?? '');
        $titulo = $validated['item_title'] ?? '';
        $itemId = $validated['item_id'] ?? null;

        if ($perfil) {
            $nombre = $perfil->nombre ?? 'un egresado';
            $programa = $perfil->programa ?? 'su programa';
            $anio = $perfil->anio_egreso ?? 'su año de egreso';
            $numero = '573224650595'; // WhatsApp Business oficial FET
            $mensaje = null;

            switch ($tipo) {
                case 'mentoria':
                    $mensaje = "Buen día, soy {$nombre}, egresado de {$programa} en el año {$anio}, y me interesa la mentoría \"{$titulo}\".";
                    break;

                case 'atencion':
                    $mensaje = "Buen día, soy {$nombre}, egresado de {$programa} en el año {$anio}, y deseo solicitar un espacio de escucha con Bienestar Institucional.";
                    break;

                case 'habilidad':
                    $mensaje = "Buen día, soy {$nombre}, egresado de {$programa} en el año {$anio}, y deseo inscribirme en el taller \"{$titulo}\".";
                    break;

                case 'curso': // Formación continua (si la empresa es FET)
                    $formacion = Formacion::with('empresa')->find($itemId);
                    if ($formacion && $formacion->empresa && strtolower(trim($formacion->empresa->nombre)) === 'fet') {
                        $mensaje = "Buen día, soy {$nombre}, egresado de {$programa} en el año {$anio}, y deseo inscribirme en la oferta de formación \"{$titulo}\" organizada por la FET.";
                    }
                    break;

                case 'oferta': // Ofertas laborales de la FET
                    $oferta = OfertaLaboral::with('empresa')->find($itemId);
                    if ($oferta && $oferta->empresa && strtolower(trim($oferta->empresa->nombre)) === 'fet') {
                        $mensaje = "Buen día, soy {$nombre}, egresado de {$programa} en el año {$anio}, y me interesa postularme a la oferta laboral \"{$titulo}\" publicada por la FET.";
                    }
                    break;
            }

            // Si se construyó mensaje → redirigir a WhatsApp
            if ($mensaje) {
                $mensaje = urlencode($mensaje);

                $userAgent = strtolower($request->userAgent());
                $isMobile = str_contains($userAgent, 'mobile') || str_contains($userAgent, 'android') || str_contains($userAgent, 'iphone');

                $enlace = $isMobile
                    ? "https://api.whatsapp.com/send?phone={$numero}&text={$mensaje}"
                    : "https://web.whatsapp.com/send?phone={$numero}&text={$mensaje}";

                return response()->json([
                    'success' => true,
                    'id' => $interaccion->id,
                    'redirect' => $enlace
                ]);
            }
        }
    }

    // =============================================
    // Si no aplica redirección especial → URL normal
    // =============================================
    return response()->json([
        'success' => true,
        'id' => $interaccion->id,
        'redirect' => $validated['url'] ?? null
    ]);
});



// Registrar visitas diarias
Route::post('/api/registrar-visita', function () {
    VisitaDiaria::registrarVisita();
    return response()->json(['success' => true]);
});





/* ============================================================
|  EXPORTACIONES DE MÉTRICAS A EXCEL
|============================================================ */

Route::prefix('exportar')->group(function () {
    Route::get('/visitas', fn() => Excel::download(new VisitasSheet, 'visitas_diarias.xlsx'))->name('exportar.visitas');
    Route::get('/interacciones', fn() => Excel::download(new InteraccionesSheet, 'interacciones.xlsx'))->name('exportar.interacciones');
    Route::get('/egresados', fn() => Excel::download(new EgresadosSheet, 'egresados.xlsx'))->name('exportar.egresados');
    Route::get('/ofertas', fn() => Excel::download(new OfertasSheet, 'ofertas.xlsx'))->name('exportar.ofertas');
    Route::get('/formaciones', fn() => Excel::download(new FormacionesSheet, 'formaciones.xlsx'))->name('exportar.formaciones');
    Route::get('/empresas', fn() => Excel::download(new EmpresasSheet, 'empresas.xlsx'))->name('exportar.empresas');
    Route::get('/servicios', fn() => Excel::download(new ServiciosSheet, 'servicios.xlsx'))->name('exportar.servicios');
    Route::get('/habilidades', fn() => Excel::download(new HabilidadesSheet, 'habilidades.xlsx'))->name('exportar.habilidades');
    Route::get('/eventos', fn() => Excel::download(new EventosSheet, 'eventos.xlsx'))->name('exportar.eventos');
});
