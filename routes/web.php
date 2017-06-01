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
Route::get('/{id?}', 'PageController@show')->where('id', '[0-9]*')->name('pages.show');

Route::post('/survey/{id}', 'SurveyController@submit')->where('id', '[0-9]+')->name('surveys.submit');

Route::get('/document/{id}', 'DocumentController@show')->where('id', '[0-9]+')->name('documents.show');


// Admin Routes
Route::group(['middleware' => 'auth', 'prefix' => 'admin', 'as' => 'admin.'], function (){
    Route::resource('users', 'UserController');
    Route::resource('pages', 'PageController');
    Route::resource('categories', 'CategoryController');
    Route::resource('documents', 'DocumentController');
    Route::resource('surveys', 'SurveyController');
    Route::resource('surveys', 'SurveyController');

});

// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset');

// New User's Set Password Routes ...
$this->get('password/set/{token}', 'UserController@showPasswordForm')->name('password.setform');
$this->post('password/set', 'UserController@setPassword')->name('password.set');

