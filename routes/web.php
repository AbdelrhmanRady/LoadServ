<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
// Route::get('/', function () {
//     return view('welcome');
// });









Auth::routes();



Route::get('/mainCategories',[CategoryController::class,"mainIndex"])->name('category.mainIndex'); //checked
Route::get('/mainCategories/{category}',[CategoryController::class,"mainShow"])->name('category.mainShow'); //checked
Route::get('/mainCategories/{category}/{subcategory}',[CategoryController::class,"subShow"])->name('category.subShow'); //checked



Route::get('/cart', [CartController::class, 'index'])->name('cart.index'); //checked
Route::delete('/cart', [CartController::class, 'delete'])->name('cart.delete'); //checked

Route::middleware(['auth'])->group(function () {
    //Admin roles//
    Route::get('/create',[HomeController::class,"create"])->name('home.create');  // checked
    Route::put('/editProduct/{product}', [HomeController::class, 'update'])->name('home.update');// checked
    Route::get('/editProduct/{product}/edit', [HomeController::class, 'edit'])->name('home.edit'); // checked
    Route::post('/',[HomeController::class,"store"])->name('home.store');  // checked


    Route::get('/addCategory',[CategoryController::class,"create"])->name('categories.create'); //checked
    Route::post('/addCategory',[CategoryController::class,"store"])->name('categories.store');  //checked

    Route::get('/admin', [ProfileController::class, 'adminIndex'])->name('profile.adminIndex'); //checked

    //Admin roles//


    Route::get('/cart/{itemToBeDestroyed}', [CartController::class, 'destroy'])->name('cart.destroy'); //checked
    Route::post('cart/confirm', [CartController::class, 'confirm'])->name('cart.confirm'); //checked
    Route::post('cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout'); //checked
    
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index'); //checked
    Route::get('/profile/orders', [ProfileController::class, 'ordersIndex'])->name('profile.ordersIndex'); //checked
    Route::get('/profile/orders/{order}', [ProfileController::class, 'ordersShow'])->name('profile.ordersShow'); //checked
    
    
    
    Route::put('/update/address/{id}', [ProfileController::class, 'updateAddress'])->name('update.address'); //checked
    Route::put('/add/address', [ProfileController::class, 'addAddress'])->name('add.address'); //checked
    Route::delete('/remove/address/{id}', [ProfileController::class, 'removeAddress'])->name('remove.address'); //checked
    Route::put('/update/name', [ProfileController::class, 'updateName'])->name('update.name'); //checked
    Route::put('/update/email', [ProfileController::class, 'updateEmail'])->name('update.email'); //checked
    Route::put('/update/phone', [ProfileController::class, 'updatePhone'])->name('update.phone');//checked
    
    Route::put('/update/birthday', [ProfileController::class, 'updateBirthday'])->name('update.birthday'); //checked
    Route::put('/update/gender', [ProfileController::class, 'updateGender'])->name('update.gender'); //checked

    
});
Route::get('/', [HomeController::class, 'index'])->name('home.index'); //checked
Route::post('/search', [HomeController::class, 'search'])->name('home.search'); //checked
Route::post('/cart/create', [CartController::class, 'store'])->name('cart.store'); //checked
Route::get('/{product}',[HomeController::class,"show"])->name('home.show'); //checked



