<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Shop\CartController;
use App\Http\Controllers\Shop\AboutController;
use App\Http\Controllers\Shop\HomeController;
use App\Http\Controllers\Shop\ProductController;
use App\Http\Controllers\User\OrderController as UserOrderController;
use App\Http\Controllers\User\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/hakkimizda', [AboutController::class, 'index'])->name('about');

Route::get('/urunler', [ProductController::class, 'index'])->name('products.index');
Route::get('/urunler/{product:slug}', [ProductController::class, 'show'])->name('products.show');

Route::middleware('guest')->group(function () {
    Route::get('/giris', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/giris', [LoginController::class, 'login']);
    Route::get('/kayit', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/kayit', [RegisterController::class, 'register']);
});

Route::post('/cikis', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth', 'active'])->group(function () {
    Route::get('/sepet', [CartController::class, 'index'])->name('cart.index');
    Route::post('/sepet/ekle/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/sepet/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/sepet/{item}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/odeme', [CartController::class, 'checkout'])->name('checkout');
    Route::post('/odeme', [CartController::class, 'placeOrder'])->name('checkout.place');

    Route::prefix('hesabim')->name('user.')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('profile');
        Route::get('/duzenle', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/duzenle', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/sifre', [ProfileController::class, 'passwordForm'])->name('profile.password');
        Route::put('/sifre', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
        Route::post('/pasif', [ProfileController::class, 'deactivate'])->name('profile.deactivate');

        Route::get('/siparisler', [UserOrderController::class, 'index'])->name('orders.index');
        Route::get('/siparisler/{order}', [UserOrderController::class, 'show'])->name('orders.show');
        Route::post('/siparisler/{order}/iptal', [UserOrderController::class, 'cancel'])->name('orders.cancel');
        Route::post('/siparisler/{order}/teslim', [UserOrderController::class, 'confirmReceipt'])->name('orders.confirm');
    });
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/profil', [AdminController::class, 'profile'])->name('profile');
    Route::put('/profil', [AdminController::class, 'updateProfile'])->name('profile.update');
    Route::put('/sifre', [AdminController::class, 'updatePassword'])->name('password.update');

    Route::resource('products', AdminProductController::class)->except(['show']);
    Route::post('products/{product}/publish', [AdminProductController::class, 'togglePublish'])->name('products.publish');
    Route::delete('product-images/{image}', [AdminProductController::class, 'deleteImage'])->name('products.image.delete');

    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::post('orders/{order}/approve', [AdminOrderController::class, 'approve'])->name('orders.approve');
    Route::post('orders/{order}/advance', [AdminOrderController::class, 'advance'])->name('orders.advance');
    Route::put('orders/{order}/note', [AdminOrderController::class, 'updateNote'])->name('orders.note');

    Route::resource('users', AdminUserController::class)->except(['create', 'store']);
    Route::post('users/{user}/freeze', [AdminUserController::class, 'freeze'])->name('users.freeze');
    Route::post('users/{user}/activate', [AdminUserController::class, 'activate'])->name('users.activate');
});
