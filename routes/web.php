<?php

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

Auth::routes();
Route::get('/', 'HomeController@index')->name('home');

Route::post('/profile-update', 'HomeController@updateProfile')->name('profile.update');
Route::post('/add-course-to-cart', 'HomeController@addCourseToCart')->name('add-course-to-cart');
Route::view('/cart', 'cart')->name('cart');
Route::post('/remove-course-from-cart', 'HomeController@removeCourseFromCart')->name('remove-course-from-cart');
Route::post('/prepare-payment', 'HomeController@preparePayment')->name('prepare-payment');
Route::get('/payment/{checkoutId}', 'HomeController@showPaymentForm')->name('payment-form');
Route::get('/receipt', 'HomeController@paymentStatus')->name('receipt');