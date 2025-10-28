<?php

use App\Http\Controllers\InicioController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LaboralController;
use App\Http\Controllers\FormacionController;
use App\Http\Controllers\BienestarController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Livewire\Admin\Laboral\LaboralPanel;
use App\Livewire\Admin\Formacion\FormacionPanel;
use App\Livewire\Admin\Bienestar\Habilidades\HabilidadesPanel;
use App\Livewire\Admin\Bienestar\Servicios\ServiciosPanel;
use App\Livewire\Admin\Bienestar\Eventos\EventosPanel;
use App\Livewire\Admin\Bienestar\Mentorias\MentoriasPanel;

//provisional
use Illuminate\Support\Facades\Auth;

use App\Models\Formacion;
use App\Models\OfertaLaboral;
use App\Models\BienestarHabilidad;
use App\Models\PerfilEgresado;
use App\Models\Interaccion;
use App\Models\VisitaDiaria;

// Exportaciones
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Sheets\VisitasSheet;
use App\Exports\Sheets\InteraccionesSheet;
use App\Exports\Sheets\EgresadosSheet;
use App\Exports\Sheets\OfertasSheet;
use App\Exports\Sheets\FormacionesSheet;
use App\Exports\Sheets\EmpresasSheet;
use App\Exports\Sheets\ServiciosSheet;
use App\Exports\Sheets\HabilidadesSheet;
use App\Exports\Sheets\EventosSheet;

// Página de inicio
Route::get('/', [InicioController::class, 'index'])->name('inicio');

// Ofertas Laborales
Route::get('/laboral', [LaboralController::class, 'index'])->name('laboral.index');

Route::get('/api/oferta/{id}', function ($id) {
    return OfertaLaboral::with('empresa')->findOrFail($id);
});

// Formación
Route::get('/formacion', [FormacionController::class, 'index'])->name('formacion.index');

Route::get('/api/formacion/{id}', function ($id) {
    return Formacion::with('empresa')->findOrFail($id);
});

// Bienestar
Route::get('/bienestar', [BienestarController::class, 'index'])->name('bienestar.index');

Route::get('/bienestar/habilidad/{id}', [App\Http\Controllers\BienestarController::class, 'show'])->name('bienestar.habilidad.show');

Route::get('/bienestar/servicio/{id}', [App\Http\Controllers\BienestarController::class, 'showServicio'])->name('bienestar.servicio.show');

Route::get('/bienestar/evento/{id}', [App\Http\Controllers\BienestarController::class, 'showEvento'])->name('bienestar.evento.show');




// Dashboard (solo para usuarios autenticados y verificados)
Route::get('/dashboard', \App\Livewire\Admin\Dashboard\DashboardPanel::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


//Salir provisional
Route::get('/salir', function () {
    Auth::logout();
    return redirect('/login');
});

// Perfil de usuario (ejemplo que Breeze trae por defecto)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


// Rutas para el panel administrativo de ofertas laborales
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/laboral', LaboralPanel::class)->name('laboral.panel');
});



// Rutas para el panel administrativo de formación
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/formacion', FormacionPanel::class)->name('formacion.panel');
});



// Rutas para el panel administrativo de Bienestar

// Panel administrativo de habilidades
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/bienestar/habilidades', HabilidadesPanel::class)->name('bienestar.habilidades.panel');
});

// Panel administrativo de servicios
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/bienestar/servicios', ServiciosPanel::class)->name('bienestar.servicios.panel');
});

// Panel administrativo de Eventos
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/bienestar/eventos', EventosPanel::class)->name('bienestar.eventos.panel');
});


// Panel administrativo de Mentorías
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/bienestar/mentorias', MentoriasPanel::class)->name('bienestar.mentorias.panel');
});



// API interna para el dashboard de metricas de egresados

Route::post('/api/profile/upsert', function (Request $request) {
    $validated = $request->validate([
        'nombre' => 'required|string|max:255',
        'correo' => 'required|email',
        'celular' => 'nullable|string|max:20',
        'programa' => 'nullable|string|max:255',
        'anio_egreso' => 'nullable|digits:4',
    ]);

    // Si ya existe un perfil con ese correo, lo actualiza.
    $perfil = PerfilEgresado::updateOrCreate(
        ['correo' => $validated['correo']],
        $validated
    );

    return response()->json([
        'success' => true,
        'perfil_id' => $perfil->id,
    ]);
});


Route::post('/api/track/interaction', function (Request $request) {
    $validated = $request->validate([
        'module' => 'required|string|max:50',
        'action' => 'required|string|max:50',
        'item_type' => 'nullable|string|max:50',
        'item_id' => 'nullable|integer',
        'item_title' => 'nullable|string|max:255',
        'perfil_id' => 'nullable|integer|exists:perfiles_egresado,id',
    ]);

    $interaccion = Interaccion::create([
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

    return response()->json(['success' => true, 'id' => $interaccion->id]);
});


// API para registrar visitas diarias
Route::post('/api/registrar-visita', function () {
    VisitaDiaria::registrarVisita();
    return response()->json(['success' => true]);
});


// Rutas para exportar métricas del dashboard 
Route::get('/exportar-visitas', function () {
    return Excel::download(new VisitasSheet, 'visitas_diarias.xlsx', \Maatwebsite\Excel\Excel::XLSX
);
})->name('exportar.visitas');

Route::get('/exportar-interacciones', function () {
    return Excel::download(new InteraccionesSheet, 'interacciones.xlsx', \Maatwebsite\Excel\Excel::XLSX
);
})->name('exportar.interacciones');

Route::get('/exportar-egresados', function () {
    return Excel::download(new EgresadosSheet, 'egresados.xlsx', \Maatwebsite\Excel\Excel::XLSX
);
})->name('exportar.egresados');


Route::get('/exportar-ofertas', function () {
    return Excel::download(new OfertasSheet, 'ofertas.xlsx');
})->name('exportar.ofertas');


Route::get('/exportar-formaciones', function () {
    return Excel::download(new FormacionesSheet, 'formaciones.xlsx');
})->name('exportar.formaciones');

Route::get('/exportar-empresas', function () {
    return Excel::download(new EmpresasSheet, 'empresas.xlsx');
})->name('exportar.empresas');

Route::get('/exportar-servicios', function () {
    return Excel::download(new ServiciosSheet, 'servicios.xlsx');
})->name('exportar.servicios');

Route::get('/exportar-habilidades', function () {
    return Excel::download(new HabilidadesSheet, 'habilidades.xlsx');
})->name('exportar.habilidades');

Route::get('/exportar-eventos', function () {
    return Excel::download(new EventosSheet, 'eventos.xlsx');
})->name('exportar.eventos');









Route::view('/politica-datos', 'politica-datos')->name('politica-datos');
