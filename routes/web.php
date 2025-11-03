<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

/*
|--------------------------------------------------------------------------
| Controladores Principales
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\{
    InicioController,
    ProfileController,
    LaboralController,
    FormacionController,
    BienestarController,
    TrackingController,
    MetricsController,
    EgresadoProfileController,
};

/*
|--------------------------------------------------------------------------
| Componentes Livewire (Paneles Administrativos)
|--------------------------------------------------------------------------
*/
use App\Livewire\Admin\{
    Laboral\LaboralPanel,
    Formacion\FormacionPanel,
    Bienestar\Habilidades\HabilidadesPanel,
    Bienestar\Servicios\ServiciosPanel,
    Bienestar\Eventos\EventosPanel,
    Bienestar\Mentorias\MentoriasPanel,
    Dashboard\DashboardPanel
};

/*
|--------------------------------------------------------------------------
| Modelos
|--------------------------------------------------------------------------
*/
use App\Models\{
    Formacion,
    OfertaLaboral
};

/*
|--------------------------------------------------------------------------
| Exportaciones (Métricas a Excel)
|--------------------------------------------------------------------------
*/
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
Route::get('/dashboard', DashboardPanel::class)
    ->middleware(['auth'])
    ->name('dashboard');

// Perfil de usuario administrador (auth Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas Breeze (login / registro / logout)
require __DIR__ . '/auth.php';



/* ============================================================
|  PANELES ADMINISTRATIVOS (PROTEGIDOS)
|============================================================ */
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Laboral
    Route::get('/laboral', LaboralPanel::class)->name('laboral.panel');

    // Formación Continua
    Route::get('/formacion', FormacionPanel::class)->name('formacion.panel');

    // Bienestar Institucional
    Route::prefix('bienestar')->name('bienestar.')->group(function () {
        Route::get('/habilidades', HabilidadesPanel::class)->name('habilidades.panel');
        Route::get('/servicios', ServiciosPanel::class)->name('servicios.panel');
        Route::get('/eventos', EventosPanel::class)->name('eventos.panel');
        Route::get('/mentorias', MentoriasPanel::class)->name('mentorias.panel');
    });
});



/* ============================================================
|  API INTERNA (Egresados, Métricas, Interacciones)
|============================================================ */
Route::prefix('api')->group(function () {
    Route::post('/profile/upsert', [EgresadoProfileController::class, 'upsert'])->name('api.profile.upsert');
    Route::post('/track/interaction', [TrackingController::class, 'registrarInteraccion'])->name('api.track.interaction');
    Route::post('/registrar-visita', [MetricsController::class, 'registrarVisita'])->name('api.metrics.visita');
});



/* ============================================================
|  EXPORTACIONES A EXCEL (Métricas y Registros)
|============================================================ */
Route::prefix('exportar')->name('exportar.')->group(function () {
    Route::get('/visitas', fn() => Excel::download(new VisitasSheet, 'visitas_diarias.xlsx'))->name('visitas');
    Route::get('/interacciones', fn() => Excel::download(new InteraccionesSheet, 'interacciones.xlsx'))->name('interacciones');
    Route::get('/egresados', fn() => Excel::download(new EgresadosSheet, 'egresados.xlsx'))->name('egresados');
    Route::get('/ofertas', fn() => Excel::download(new OfertasSheet, 'ofertas.xlsx'))->name('ofertas');
    Route::get('/formaciones', fn() => Excel::download(new FormacionesSheet, 'formaciones.xlsx'))->name('formaciones');
    Route::get('/empresas', fn() => Excel::download(new EmpresasSheet, 'empresas.xlsx'))->name('empresas');
    Route::get('/servicios', fn() => Excel::download(new ServiciosSheet, 'servicios.xlsx'))->name('servicios');
    Route::get('/habilidades', fn() => Excel::download(new HabilidadesSheet, 'habilidades.xlsx'))->name('habilidades');
    Route::get('/eventos', fn() => Excel::download(new EventosSheet, 'eventos.xlsx'))->name('eventos');
});
