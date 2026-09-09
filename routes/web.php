<?php
use App\Http\Controllers\FoodController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;

// 1. Halaman Landing Page langsung diarahkan ke Login
Route::redirect('/', '/login');
Route::get('/terms-and-conditions', [LegalController::class, 'terms'])->name('terms.show');
Route::get('/terms-and-conditions/customer', [LegalController::class, 'customerTerms'])->name('terms.customer');
Route::get('/terms-and-conditions/seller', [LegalController::class, 'sellerTerms'])->name('terms.seller');

// ==== RUTE UNTUK CUSTOMER (AGUS) ====
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/katalog', [FoodController::class, 'index'])->name('katalog.index');
    Route::post('/order/{food_id}', [OrderController::class, 'store'])->name('order.store');
    Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('order.history');
    Route::get('/toko/{id}', [FoodController::class, 'storeProfile'])->name('toko.show');
    Route::post('/orders/{order}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

// ==== RUTE UNTUK SELLER (PAK BUDI) ====
Route::middleware(['auth', 'role:seller'])->prefix('seller')->group(function () {
    Route::get('/dashboard', [FoodController::class, 'sellerDashboard'])->name('seller.dashboard');
    Route::post('/withdraw', [FoodController::class, 'withdraw'])->name('seller.withdraw');
    Route::get('/inventory', [FoodController::class, 'inventory'])->name('seller.inventory');
    Route::get('/donations', [FoodController::class, 'donations'])->name('seller.donations');
    Route::get('/donations/create', [FoodController::class, 'createDonation'])->name('seller.donations.create');
    Route::post('/donations', [FoodController::class, 'storeDonation'])->name('seller.donations.store');
    Route::delete('/donations/{id}', [FoodController::class, 'destroyDonation'])->name('seller.donations.destroy');
    Route::get('/food/create', [FoodController::class, 'create'])->name('food.create');
    Route::post('/food', [FoodController::class, 'store'])->name('food.store');
    Route::get('/orders', [OrderController::class, 'sellerOrders'])->name('seller.orders');
    Route::patch('/orders/{id}/complete', [OrderController::class, 'complete'])->name('order.complete');
    Route::delete('/food/{id}', [FoodController::class, 'destroy'])->name('food.destroy');
});

// ==== RUTE UNTUK ADMIN ====
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

// ==== REDIRECT SETELAH LOGIN BREEZE ====
Route::get('/dashboard', function () {
    $role = auth()->user()->role;
    if ($role === 'admin') return redirect()->route('admin.dashboard');
    if ($role === 'seller') return redirect()->route('seller.dashboard');
    return redirect()->route('katalog.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// ==== RUTE PROFIL BAWAAN BREEZE ====
Route::middleware('auth')->group(function () {
    Route::get('/pnc', [LegalController::class, 'pnc'])->name('pnc.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
