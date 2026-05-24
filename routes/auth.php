<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\TwoFactorChallenge;

Route::middleware('guest')->group(function () {
    Route::get('login', Login::class)->name('login');
    Route::get('register', Register::class)->name('register');
    Route::get('two-factor-challenge', TwoFactorChallenge::class)->name('two-factor.challenge');

    Route::get('forgot-password', \App\Livewire\Auth\ForgotPassword::class)->name('password.request');
    Route::get('reset-password/{token}', \App\Livewire\Auth\ResetPassword::class)->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', function () {
        auth()->logout();
        return redirect()->route('login');
    })->name('logout');
});
