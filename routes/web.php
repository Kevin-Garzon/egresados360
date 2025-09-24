<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

// Ruta de Inicio
Route::get('/', function () {
    return view('home'); // más adelante creamos esta vista
})->name('home');

// Ruta Ofertas Laborales
Route::get('/laboral', function () {
    return view('laboral.index'); // vista temporal
})->name('laboral.index');

// Ruta Formación
Route::get('/formacion', function () {
    return view('formacion.index'); // vista temporal
})->name('formacion.index');

// Ruta Bienestar
Route::get('/bienestar', function () {
    return view('bienestar.index'); // vista temporal
})->name('bienestar.index');

// Ruta Panel Administrador 
Route::get('/admin', function () {
    return view('admin.dashboard'); // vista temporal
})->name('admin.dashboard');
