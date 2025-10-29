<?php

use App\Http\Controllers\Auth\{
    AuthenticatedSessionController,
    //RegisteredUserController,
    //PasswordController,
    // ConfirmablePasswordController,
    // EmailVerificationNotificationController,
    // EmailVerificationPromptController,
    // NewPasswordController,
    // PasswordResetLinkController,
    // VerifyEmailController
};
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Rutas de Autenticación
|--------------------------------------------------------------------------
|
| Este archivo define las rutas principales de autenticación del sistema.
| Actualmente, el portal Egresados 360 usa solo el inicio y cierre de sesión
| para usuarios administradores. El registro público, recuperación de clave
| y verificación de correo fueron deshabilitados al no ser requeridos.
|
*/


// ============================================================
// AUTENTICACIÓN (Login)
// ============================================================

Route::middleware('guest')->group(function () {

    // --- Mostrar formulario de inicio de sesión ---
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    // --- Procesar el login ---
    Route::post('login', [AuthenticatedSessionController::class, 'store'])
        ->name('login.store');



    /* ------------------------------------------------------------
    | Registro de nuevos usuarios (DESHABILITADO)
    | ------------------------------------------------------------
    |
    | Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    | Route::post('register', [RegisteredUserController::class, 'store']);
    |
    ------------------------------------------------------------ */


    /* ------------------------------------------------------------
    | Recuperación y restablecimiento de contraseña (DESHABILITADO)
    | ------------------------------------------------------------
    |
    | Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    | Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    | Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    | Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
    |
    ------------------------------------------------------------ */
});



// ============================================================
// SESIONES AUTENTICADAS
// ============================================================

Route::middleware('auth')->group(function () {

    // --- Cerrar sesión ---
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');



    /* ------------------------------------------------------------
    | Verificación de correo electrónico (DESHABILITADO)
    | ------------------------------------------------------------
    |
    | Route::get('verify-email', EmailVerificationPromptController::class)->name('verification.notice');
    | Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
    |     ->middleware(['signed', 'throttle:6,1'])
    |     ->name('verification.verify');
    | Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    |     ->middleware('throttle:6,1')
    |     ->name('verification.send');
    |
    ------------------------------------------------------------ */


    /* ------------------------------------------------------------
    | Confirmación de contraseña y actualización (OPCIONAL)
    | ------------------------------------------------------------
    |
    | Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    | Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
    | Route::put('password', [PasswordController::class, 'update'])->name('password.update');
    |
    ------------------------------------------------------------ */
});
