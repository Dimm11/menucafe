<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WorkOrderController;
use App\Http\Controllers\StaffOrderController;
use App\Http\Controllers\StaffAuthController;
use App\Http\Controllers\StaffDashboardController;
use App\Http\Controllers\StaffUserController;
use App\Http\Controllers\StaffProductController; // Import StaffProductController
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| ... (rest of your web routes file) ...
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::post('/orders', [WorkOrderController::class, 'store'])->name('orders.store');

// Staff Routes - Authentication, Dashboard, Orders, and Staff User & Product Management
Route::prefix('staff')->group(function () {
    // Staff Authentication Routes
    Route::get('/login', [StaffAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [StaffAuthController::class, 'login']);
    Route::post('/logout', [StaffAuthController::class, 'logout'])->name('staff.logout');

    // Staff Dashboard and Management Routes - Protected by auth:staff middleware
    Route::middleware(['auth:staff'])->group(function () {
        Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('staff.dashboard');
        Route::get('/orders', [StaffOrderController::class, 'index'])->name('staff.orders.index');
        Route::get('/orders/{order}', [StaffOrderController::class, 'show'])->name('staff.orders.show');
        Route::patch('/orders/{order}/status', [StaffOrderController::class, 'updateStatus'])->name('staff.orders.status.update');
        Route::get('/users', [StaffUserController::class, 'index'])->name('staff.users.index');
        Route::get('/users/create', [StaffUserController::class, 'create'])->name('staff.users.create');
        Route::post('/users', [StaffUserController::class, 'store'])->name('staff.users.store');
        Route::get('/users/{user}/edit', [StaffUserController::class, 'edit'])->name('staff.users.edit');
        Route::patch('/users/{user}', [StaffUserController::class, 'update'])->name('staff.users.update');
        Route::delete('/users/{user}', [StaffUserController::class, 'destroy'])->name('staff.users.destroy');

        // Staff Product Management Routes (New Routes Added Here - also protected by auth:staff)
        Route::get('/products', [StaffProductController::class, 'index'])->name('staff.products.index'); // List products
        Route::get('/products/create', [StaffProductController::class, 'create'])->name('staff.products.create'); // Create product form
        Route::post('/products', [StaffProductController::class, 'store'])->name('staff.products.store'); // Store new product
        Route::get('/products/{product}/edit', [StaffProductController::class, 'edit'])->name('staff.products.edit'); // Edit product form
        Route::patch('/products/{product}', [StaffProductController::class, 'update'])->name('staff.products.update'); // Update product
        Route::delete('/products/{product}', [StaffProductController::class, 'destroy'])->name('staff.products.destroy'); // Delete product
    });
});