<?php

use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Home route with name
Route::get('/', function () {
    return view('home');
})->name('home');

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



// Customer routes
Route::middleware(['auth', 'customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', function () {
        return view('customer.dashboard');
    })->name('dashboard');
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
