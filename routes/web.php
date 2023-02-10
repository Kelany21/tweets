<?php

use Illuminate\Support\Facades\Route;

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


Route::namespace('\\App\\Http\\Controllers\\DashBoard\\')->group(function () {
    Route::group([
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ], function () {
        Route::group(['prefix' => 'dashboard'], function () {
            include __DIR__ . DIRECTORY_SEPARATOR . 'admin.php';
        });
    });
});

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {
    Route::get('logout', function ()
    {
        auth()->logout();
        return redirect('/');
    })->name('logout');
    Route::middleware(['guest'])->namespace('\\App\\Http\\Controllers\\Auth\\')->group(function () {
        // Route::post('login', 'Auth\LoginController@login')->name('login');
        // Route::post('logout', 'Auth\LoginController@logout')->name('logout');;
        // Route::post('register', 'Auth\RegisterController@register')->name('register');
        // Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        // Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

        Route::get('login', 'LoginController@showLoginForm')->name('showLoginForm');
        Route::post('login', 'LoginController@login')->name('login');
        Route::get('register', 'RegisterController@showRegistrationForm')->name('showRegistrationForm');
        Route::post('register', 'RegisterController@register')->name('register');
        Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::post('password/reset', 'ResetPasswordController@reset')->name('password.update');

    });

    Route::namespace('\\App\\Http\\Controllers\\FrontEnd\\')->group(function () {
        include __DIR__ . DIRECTORY_SEPARATOR . 'frontend.php';
        Route::middleware(['auth'])->group(function () {
            include __DIR__ . DIRECTORY_SEPARATOR . 'auth.php';
        });
    });



});
