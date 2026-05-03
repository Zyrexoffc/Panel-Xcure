<?php

use Illuminate\Support\Facades\Route;
use Xcure\Http\Controllers\Base;
use Xcure\Http\Middleware\RequireTwoFactorAuthentication;

Route::get('/server/{identifier}', [Base\IndexController::class, 'server'])->name('server.show')->middleware('panel.protect');
Route::get('/', [Base\IndexController::class, 'index'])->name('index')->fallback();
Route::get('/account', [Base\IndexController::class, 'index'])
    ->withoutMiddleware(RequireTwoFactorAuthentication::class)
    ->name('account');

Route::get('/locales/locale.json', Base\LocaleController::class)
    ->withoutMiddleware(['auth', RequireTwoFactorAuthentication::class])
    ->where('namespace', '.*');

Route::middleware('auth')->group(function () {
    // User-level Protect routes (original toggle)
    Route::get('/protect/settings', [Base\ProtectController::class, 'index'])->name('protect.settings');
    Route::post('/protect/toggle', [Base\ProtectController::class, 'toggle'])->name('protect.toggle');
    
    // Server Protect routes (per-server)
    Route::get('/server/{identifier}/protect/settings', [Base\ServerProtectController::class, 'index'])->name('server.protect.settings');
    Route::post('/server/{identifier}/protect/toggle', [Base\ServerProtectController::class, 'toggle'])->name('server.protect.toggle');
});

Route::get('/{react}', [Base\IndexController::class, 'index'])
    ->where('react', '^(?!(\/)?(api|auth|admin|daemon)).+');
