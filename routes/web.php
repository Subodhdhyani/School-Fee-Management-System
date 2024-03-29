<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\displayController;
use App\Http\Controllers\admincontroller;
Route::get('/', function () {
    return view('welcome');
});
//Generate Order id and store form record and then return order id to welcome
Route::post('/order', [FormController::class, 'order'])->name('order');
//after successful payment store payment id related data into db
Route::post('/paymentstore', [FormController::class, 'paymentstore'])->name('paymentstore');
//Receipt Download data send 
Route::post('/receipt', [displayController::class, 'receipt'])->name('receipt');
Route::get('/receipt_download', [displayController::class, 'receipt_download'])->name('receipt_download');

// All Admin Route
Route::group(['prefix'=>'admin'],function(){
    Route::get('/login', [admincontroller::class, 'signin'])->name('login');
    Route::post('/signin', [admincontroller::class, 'signinreq'])->name('signinreq');
    Route::get('/signout',[admincontroller::class,'signout'])->name('signout');
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [admincontroller::class, 'dashboard'])->name('dashboard');
    Route::get('/allrecord', [admincontroller::class, 'allrecord'])->name('allrecord');
    Route::post('/specificrecord', [admincontroller::class, 'specificrecord'])->name('specificrecord');
    Route::delete('/delete/{id?}', [admincontroller::class, 'delete'])->name('delete');
    Route::get('/print/{id?}', [admincontroller::class, 'print'])->name('print');
    Route::get('/refund/{id?}', [admincontroller::class, 'refund'])->name('refund');
    });
});