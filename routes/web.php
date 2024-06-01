<?php

use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\EncryptionController;
use  App\Http\Controllers\DecryptionController;

Route::get('/', function () {
    return view('welcome');
});



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::post('/xchacha', [EncryptionController::class, 'index'])->name('encrypt');
    Route::post('/xchacha/decrypt', [DecryptionController::class, 'index'])->name('decrypt');
});

