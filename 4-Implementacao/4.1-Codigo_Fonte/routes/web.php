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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//Route::group(['namespace' => 'Auth'], function() {
//    /*
//     * Login
//     */
//    Route::get('login', [
//        'as' => 'login',
//        'uses' => 'LoginController@showLoginForm'
//    ]);
//    Route::post('login', [
//        'as' => 'login',
//        'uses' => 'LoginController@login'
//    ]);
//
//    Route::get('logout', [
//        'as' => 'logout',
//        'uses' => 'LoginController@logout'
//    ]);
//
//    /*
//     * Forgot password
//     */
//    Route::get('forgot/form', [
//        'as' => 'forgot.form',
//        'uses' => 'ForgotPasswordController@showLinkRequestForm'
//    ]);
//    Route::get('forgot/send', [
//        'as' => 'forgot.send',
//        'uses' => 'ForgotPasswordController@showLinkRequestForm'
//    ]);
//    Route::post('reset/email-step', [
//        'as' => 'reset.email',
//        'uses' => 'ForgotPasswordController@sendResetLinkEmail'
//    ]);
//});

Route::get('logout', 'Auth\LoginController@logout');

Route::group(['middleware' => ['auth']], function() {
    Route::get('/', ['as' => 'dashboard', 'uses' => 'ClientesController@index']);
    Route::resource('clientes', 'ClientesController');
    Route::resource('usuarios', 'UsuariosController');
    Route::get('usuarios/{usuario}/acessos', ['as' => 'usuarios.historico', 'uses' => 'UsuariosController@historico']);
});

Route::get('/home', 'HomeController@index');
