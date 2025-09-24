<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

// Ruta de Inicio
Route::get('/', function () {
    return view('inicio'); 
})->name('inicio');

// Ruta Ofertas Laborales
Route::get('/laboral', function () {
    return view('laboral.index'); 
})->name('laboral.index');

// Ruta Formación
Route::get('/formacion', function () {
    return view('formacion.index'); 
})->name('formacion.index');

// Ruta Bienestar
Route::get('/bienestar', function () {
    return view('bienestar.index'); 
})->name('bienestar.index');

// Ruta Panel Administrador 
Route::get('/admin', function () {
    return view('admin.dashboard'); 
})->name('admin.dashboard');
