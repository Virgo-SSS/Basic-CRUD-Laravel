<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::middleware(['admin'])->group(function (){
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products/create', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::patch('/products/{product}/edit', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}/delete', [ProductController::class, 'delete'])->name('products.delete');
        Route::get('/orders/{order}/confirm', [OrderController::class, 'confirm_payment'])->name('order.confirm_payment');

    });
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/edit/{user}/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/update/{user}/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // product
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
 
    
    // cart
    Route::post('/cart/{products}', [CartController::class, 'store'])->name('cart.store');
    Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
    Route::put('/carts/{carts}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/carts/{carts}', [CartController::class, 'delete'])->name('cart.delete');
    
    
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('order.checkout');
    Route::get('/orders', [OrderController::class, 'index'])->name('order.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('order.show');
    Route::post('/orders/{order}/payment', [OrderController::class, 'payment'])->name('order.payment');
});
