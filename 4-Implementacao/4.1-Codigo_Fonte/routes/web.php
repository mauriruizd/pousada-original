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

    Route::get('usuarios/arquivados', ['as' => 'usuarios.arquivados', 'uses' => 'UsuariosController@arquivados']);
    Route::resource('usuarios', 'UsuariosController');
    Route::get('usuarios/{usuario}/acessos', ['as' => 'usuarios.historico', 'uses' => 'UsuariosController@historico']);
    Route::get('usuarios/{id}/recuperar', ['as' => 'usuarios.recuperar', 'uses' => 'UsuariosController@recuperar']);
    Route::get('usuarios/{id}/alterar-senha', ['as' => 'usuarios.form-alterar-senha', 'uses' => 'UsuariosController@alterarSenhaForm']);
    Route::put('usuarios/{id}/alterar-senha', ['as' => 'usuarios.alterar-senha', 'uses' => 'UsuariosController@alterarSenha']);

    Route::get('clientes/arquivados', ['as' => 'clientes.arquivados', 'uses' => 'ClientesController@arquivados']);
    Route::resource('clientes', 'ClientesController');
    Route::get('clientes/{id}/ficha', ['as' => 'clientes.ficha', 'uses' => 'ClientesController@ficha']);
    Route::get('clientes/{id}/recuperar', ['as' => 'clientes.recuperar', 'uses' => 'ClientesController@recuperar']);
    Route::get('clientes/select/{endpoint}/{id}', 'ClientesController@selectEndpoint');

    Route::get('tipos-quartos/arquivados', ['as' => 'tipos-quartos.arquivados', 'uses' => 'TiposQuartosController@arquivados']);
    Route::resource('tipos-quartos', 'TiposQuartosController');
    Route::resource('tipos-quartos.excecoes-precos', 'ExcecoesPrecoController', ['except' => 'show']);
    Route::get('tipos-quartos/{id}/recuperar', ['as' => 'tipos-quartos.recuperar', 'uses' => 'TiposQuartosController@recuperar']);

    Route::resource('quartos', 'QuartosController', ['except' => ['destroy']]);
    Route::get('quartos/{id}/promocao', ['as' => 'quartos.promocao.create', 'uses' => 'QuartosController@createPromocao']);
    Route::post('quartos/{id}/promocao', ['as' => 'quartos.promocao.store', 'uses' => 'QuartosController@storePromocao']);
    Route::get('quartos/{id}/promocao/edit', ['as' => 'quartos.promocao.store', 'uses' => 'QuartosController@editPromocao']);
    Route::put('quartos/{id}/promocao', ['as' => 'quartos.promocao.store', 'uses' => 'QuartosController@updatePromocao']);
    Route::delete('quartos/{id}/promocao', ['as' => 'quartos.promocao.destroy', 'uses' => 'QuartosController@deletePromocao']);

    Route::get('quartos/{id}/manutencao', ['as' => 'quartos.manutencao.create', 'uses' => 'QuartosController@createManutencao']);
    Route::post('quartos/{id}/manutencao', ['as' => 'quartos.manutencao.store', 'uses' => 'QuartosController@storeManutencao']);
    Route::delete('quartos/{id}/manutencao', ['as' => 'quartos.manutencao.destroy', 'uses' => 'QuartosController@deleteManutencao']);
});

Route::get('/home', 'HomeController@index');
