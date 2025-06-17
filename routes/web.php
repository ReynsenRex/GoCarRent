<?php

use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\CarController as CustomerCarController;

// Home route with name
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/', [CustomerCarController::class, 'showPopularCars'])->name('home');

// Main dashboard route - redirects based on user role
Route::middleware('auth')->get('/dashboard', function () {
    $user = auth()->user();
    
    // Debug: Let's see what's happening
    if (!$user) {
        return redirect()->route('login')->with('error', 'Please log in first');
    }
    
    // Load the role relationship
    $user->load('role');
    
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->isCustomer()) {
        return redirect()->route('customer.dashboard');
    } elseif ($user->isStaff()) {
        return redirect()->route('staff.dashboard');
    }
    
    // Debug fallback
    return response()->json([
        'user' => $user->name,
        'role' => $user->role->name ?? 'No role',
        'message' => 'Role not recognized'
    ]);
})->name('dashboard');

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
});

// Admin CRUD Car
Route::get('/admin/create', [CarController::class, 'create'])->name('admin.create');;
Route::post('/admin/store', [CarController::class, 'store'])->name('admin.store');
Route::get('/admin/manage', [CarController::class, 'index'])->name('admin.index');
Route::get('/admin/edit/{id}', [CarController::class, 'edit'])->name('admin.edit');
Route::delete('/admin/destroy/{id}', [CarController::class, 'destroy'])->name('admin.destroy');
Route::put('/cars/{car}', [CarController::class, 'update'])->name('cars.update');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Standard resource routes
    Route::resource('bookings', BookingController::class);

    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    
    // Additional booking management routes
    Route::patch('bookings/{booking}/approve', [BookingController::class, 'approve'])
        ->name('bookings.approve');
        
    Route::patch('bookings/{booking}/reject', [BookingController::class, 'reject'])
        ->name('bookings.reject');
        
    Route::patch('bookings/{booking}/complete', [BookingController::class, 'complete'])
        ->name('bookings.complete');
        
    Route::patch('bookings/{booking}/cancel', [BookingController::class, 'cancel'])
        ->name('bookings.cancel');
        
    // Statistics route
    Route::get('/statistics', [BookingController::class, 'statistics'])->name('statistics');
});


// Customer Routes
Route::middleware(['auth'])->prefix('customer')->name('customer.')->group(function () {
    // Add customer dashboard route
    Route::get('/dashboard', function () {
        return view('customer.dashboard');
    })->name('dashboard');
    
    // Car browsing and booking
    Route::get('/cars', [App\Http\Controllers\Customer\CarController::class, 'index'])->name('cars.index');
    Route::get('/cars/{car}', [App\Http\Controllers\Customer\CarController::class, 'show'])->name('cars.show');
    Route::post('/cars/calculate-price', [App\Http\Controllers\Customer\CarController::class, 'calculatePrice'])->name('cars.calculate-price');

    // Bookings
    Route::get('/bookings', [App\Http\Controllers\Customer\BookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings', [App\Http\Controllers\Customer\BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [App\Http\Controllers\Customer\BookingController::class, 'show'])->name('bookings.show');
    Route::patch('/bookings/{booking}/cancel', [App\Http\Controllers\Customer\BookingController::class, 'cancel'])->name('bookings.cancel');
    
    // Payments
    Route::get('/bookings/{booking}/payment', [App\Http\Controllers\Customer\PaymentController::class, 'create'])->name('payments.create');
    Route::post('/bookings/{booking}/payment', [App\Http\Controllers\Customer\PaymentController::class, 'store'])->name('payments.store');
    Route::get('/bookings/{booking}/payment/details', [App\Http\Controllers\Customer\PaymentController::class, 'show'])->name('payments.show');
});

// Staff routes
Route::middleware(['auth', 'staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', function () {
        return view('staff.dashboard');
    })->name('dashboard');
});

// Using the flexible role middleware
Route::middleware(['auth', 'role:Admin,Staff'])->group(function () {
    Route::get('/management', function () {
        return 'Management Area (Admin and Staff only)';
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Add this temporary route for testing
Route::get('/test-auth', function () {
    if (auth()->check()) {
        $user = auth()->user();
        $user->load('role');
        return response()->json([
            'authenticated' => true,
            'user' => $user->name,
            'email' => $user->email,
            'role' => $user->role->name ?? 'No role'
        ]);
    } else {
        return response()->json(['authenticated' => false]);
    }
});

require __DIR__.'/auth.php';
