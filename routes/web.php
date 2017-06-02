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

Route::get('/categories/{category}/documents/{id}', 'DocumentController@show')->where(['id' => '[0-9]+', 'category' => '[0-9]+'])->name('categories.documents.show');


// Admin Routes
Route::group(['middleware' => 'auth', 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::resource('users', 'UserController', [
        'only' => [
            'index', 'create', 'store', 'edit', 'update', 'destroy'
        ]
    ]);
    Route::resource('pages', 'PageController', [
        'only' => [
            'index', 'create', 'store', 'edit', 'update', 'destroy'
        ]
    ]);
    Route::resource('categories', 'CategoryController', [
        'only' => [
            'index', 'create', 'store', 'show', 'edit', 'update', 'destroy'
        ]
    ]);
    Route::resource('categories.documents', 'DocumentController', [
        'only' => [
            'create', 'store', 'destroy'
        ]
    ]);
    Route::resource('surveys', 'SurveyController', [
        'only' => [
            'index', 'create', 'store', 'show', 'edit', 'update', 'destroy'
        ]
    ]);
    // SurveyOptions
    Route::get('/surveys/{survey}/options/create', 'SurveyController@createOption')->where('survey', '[0-9]+')->name('surveys.options.create');
    Route::post('/surveys/{survey}/options', 'SurveyController@storeOption')->where('survey', '[0-9]+')->name('surveys.options.store');
    Route::delete('/surveys/{survey}/options/{id}', 'SurveyController@destroyOption')->where(['id' => '[0-9]+', 'survey' => '[0-9]+'])->name('surveys.options.destroy');
});

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

// New User's Set Password Routes ...
Route::get('password/set/{token}', 'UserController@showPasswordForm')->name('password.setform');
Route::post('password/set', 'UserController@setPassword')->name('password.set');

/*
// Catch all
Route::get('{any}', function () {
    abort(404);
})->where('any', '(?!public).*');
*/
