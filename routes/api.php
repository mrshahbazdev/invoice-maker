<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\BusinessController;
use App\Http\Controllers\Api\BlogCategoryController;
use App\Http\Controllers\Api\BlogPostController;

/*
|--------------------------------------------------------------------------
| Mobile App API Routes
|--------------------------------------------------------------------------
*/

// Public Blog APIs (No Auth Required for Reading)
Route::get('/blog/categories', [BlogCategoryController::class, 'index']);
Route::get('/blog/categories/{category}', [BlogCategoryController::class, 'show']);
Route::get('/blog/posts', [BlogPostController::class, 'index']);
Route::get('/blog/posts/{post}', [BlogPostController::class, 'show']);

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

    // Admin/Global: Blog Management
    // Note: If you want these strictly limited to Super Admins, you would apply the 'is_super_admin' middleware here.
    Route::post('/blog/categories', [BlogCategoryController::class, 'store']);
    Route::put('/blog/categories/{category}', [BlogCategoryController::class, 'update']);
    Route::delete('/blog/categories/{category}', [BlogCategoryController::class, 'destroy']);

    Route::post('/blog/posts', [BlogPostController::class, 'store']);
    Route::post('/blog/posts/{post}', [BlogPostController::class, 'update']); // Use POST to support FormData image uploads
    Route::delete('/blog/posts/{post}', [BlogPostController::class, 'destroy']);
});
