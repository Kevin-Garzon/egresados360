<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LaboralController;
use App\Http\Controllers\FormacionController;
use Illuminate\Support\Facades\Route;

use App\Livewire\Admin\Laboral\LaboralPanel;
use App\Livewire\Admin\Formacion\FormacionPanel;
use App\Livewire\Admin\Bienestar\HabilidadesPanel;

//provisional
use Illuminate\Support\Facades\Auth;

use App\Models\Formacion;
use App\Models\OfertaLaboral;

// Página de inicio
Route::get('/', function () {
    return view('inicio'); 
})->name('inicio');

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
Route::view('/bienestar', 'bienestar.index')->name('bienestar.index');


// Dashboard (solo para usuarios autenticados y verificados)
Route::get('/dashboard', function () {
    return view('admin.dashboard'); 
})->middleware(['auth', 'verified'])->name('dashboard');

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

Route::post('/ofertas/{id}/interaccion', [App\Http\Controllers\InteraccionController::class, 'registrarOferta'])
    ->name('ofertas.interaccion');


// Rutas para el panel administrativo de formación
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/formacion', FormacionPanel::class)->name('formacion.panel');
});

Route::post('/formaciones/{id}/interaccion', [App\Http\Controllers\InteraccionController::class, 'registrarFormacion'])
    ->name('formaciones.interaccion');


// Rutas para el panel administrativo de Bienestar
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/bienestar/habilidades', HabilidadesPanel::class)->name('bienestar.habilidades.panel');
});