<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;

// CSRF
Route::get('/csrf-cookie', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});

// Guest routes
Route::get('products', [ProductController::class, 'index']);
Route::get('products/{id}', [ProductController::class, 'show']);

// Authentication routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Authenticated routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('change-password', [AuthController::class, 'changePassword']);

    // Customer routes
    Route::middleware(['customer'])->prefix('customer')->group(function () {
        Route::get('profile/{id}', [UserController::class, 'show']);
        Route::put('profile/{id}', [UserController::class, 'update']);

        Route::prefix('cart')->group(function () {
            Route::get('/', [CartController::class, 'index']);
            Route::post('/', [CartController::class, 'addToCart']);
            Route::put('/{id}', [CartController::class, 'updateCartItem']);
            Route::delete('/{id}', [CartController::class, 'removeFromCart']);
            Route::delete('/', [CartController::class, 'clearCart']);
        });
    });

    // Admin routes
    Route::middleware(['admin'])->prefix('admin')->group(function () {
        Route::get('users', [UserController::class, 'index']);
        Route::get('users/{id}', [UserController::class, 'show']);
        Route::put('users/{id}', [UserController::class, 'update']);
        Route::delete('users/{id}', [UserController::class, 'destroy']);

        Route::post('products', [ProductController::class, 'store']);
        Route::put('products/{id}', [ProductController::class, 'update']);
        Route::delete('products/{id}', [ProductController::class, 'destroy']);

        Route::resource('categories', CategoryController::class)->except(['store', 'update']);
        Route::resource('orders', OrderController::class)->except(['store', 'update']);
        Route::resource('payments', PaymentController::class)->except(['store', 'update']);
    });

    // Super Admin routes
    Route::middleware(['super_admin'])->prefix('super_admin')->group(function () {
        // Get Data
        Route::get('profile', function () {
            $user = auth()->user();
            return [
                'AdminID' => $user->AdminID,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'username' => $user->username,
                'email' => $user->email,
                'role' => $user->role,
            ];
        });

        // User management
        Route::resource('users', UserController::class)->only(['index', 'show', 'store', 'update', 'destroy']);

        // Product management
        Route::resource('products', ProductController::class)->only(['index', 'show', 'store', 'update', 'destroy']);

        // Categories management
        Route::resource('categories', CategoryController::class)->only(['index', 'show', 'store', 'update', 'destroy']);

        // Do not use, needs improvements
        Route::resource('admins', AdminController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
        Route::resource('logs', LogController::class)->except(['store', 'update']);
        Route::resource('orders', OrderController::class);
        Route::resource('payments', PaymentController::class);
    });
});
