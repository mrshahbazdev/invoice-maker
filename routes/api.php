<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\BusinessController;

/*
|--------------------------------------------------------------------------
| Mobile App API Routes
|--------------------------------------------------------------------------
*/

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']); // Can be added later if needed

Route::middleware('auth:sanctum')->group(function () {
    // Auth User Profile
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Dashboard Stats
    Route::get('/dashboard/stats', [DashboardController::class, 'stats']);

    // Business Profile
    Route::get('/business', [BusinessController::class, 'show']);
    Route::post('/business/update', [BusinessController::class, 'update']); // Using POST to handle multipart/form-data for Logo

    // Clients
    Route::apiResource('clients', ClientController::class);

    // Products / Services
    Route::apiResource('products', ProductController::class);

    // Invoices
    Route::apiResource('invoices', InvoiceController::class);
    Route::put('/invoices/{invoice}/status', [InvoiceController::class, 'updateStatus']);
});
