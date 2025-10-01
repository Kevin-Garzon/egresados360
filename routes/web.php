<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LaboralController;
use Illuminate\Support\Facades\Route;

//provisional
use Illuminate\Support\Facades\Auth;


// Página de inicio
Route::get('/', function () {
    return view('inicio'); 
})->name('inicio');

// Ofertas Laborales
Route::get('/laboral', [LaboralController::class, 'index'])->name('laboral.index');

// Formación
Route::view('/formacion', 'formacion.index')->name('formacion.index');

// Bienestar
Route::view('/bienestar', 'bienestar.index')->name('bienestar.index');


// Dashboard (solo para usuarios autenticados y verificados)
Route::get('/dashboard', function () {
    return view('dashboard'); //  vista Breeze por defecto
})->middleware(['auth', 'verified'])->name('dashboard');

//provisional
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
