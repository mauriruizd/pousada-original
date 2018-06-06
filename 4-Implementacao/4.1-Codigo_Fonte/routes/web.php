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
    Route::get('tipos-quartos/{id}/recuperar', ['as' => 'tipos-quartos.recuperar', 'uses' => 'TiposQuartosController@recuperar']);
    Route::resource('tipos-quartos', 'TiposQuartosController');
    Route::resource('tipos-quartos.excecoes-precos', 'ExcecoesPrecoController', ['except' => 'show']);

    Route::get('quartos/arquivados', ['as' => 'quartos.arquivados', 'uses' => 'QuartosController@arquivados']);
    Route::get('quartos/{id}/recuperar', ['as' => 'quartos.recuperar', 'uses' => 'QuartosController@recuperar']);
    Route::resource('quartos', 'QuartosController');
    Route::get('quartos/{id}/manutencao', ['as' => 'quartos.manutencao.create', 'uses' => 'QuartosController@createManutencao']);
    Route::post('quartos/{id}/manutencao', ['as' => 'quartos.manutencao.store', 'uses' => 'QuartosController@storeManutencao']);
    Route::delete('quartos/{id}/manutencao', ['as' => 'quartos.manutencao.destroy', 'uses' => 'QuartosController@deleteManutencao']);

    Route::get('fornecedores/relatorio-compras', ['as' => 'fornecedores.relatorio', 'uses' => 'FornecedoresController@relatorio']);
    Route::get('fornecedores/arquivados', ['as' => 'fornecedores.arquivados', 'uses' => 'FornecedoresController@arquivados']);
    Route::get('fornecedores/{id}/recuperar', ['as' => 'fornecedores.recuperar', 'uses' => 'FornecedoresController@recuperar']);
    Route::resource('fornecedores', 'FornecedoresController');
    Route::get('fornecedores/select/{endpoint}/{id}', 'FornecedoresController@selectEndpoint');

    Route::get('produtos/consultar-estoque', ['as' => 'produtos.consultar-estoque', 'uses' => 'ProdutosController@consultarEstoque']);
    Route::get('produtos/listagem', ['as' => 'produtos.listagem', 'uses' => 'ProdutosController@listagem']);
    Route::get('produtos/arquivados', ['as' => 'produtos.arquivados', 'uses' => 'ProdutosController@arquivados']);
    Route::get('produtos/{id}/recuperar', ['as' => 'produtos.recuperar', 'uses' => 'ProdutosController@recuperar']);
    Route::get('produtos/relatorios/estoque', ['as' => 'produtos.relatorios.estoque', 'uses' => 'ProdutosController@relatoriosEstoque']);
    Route::get('produtos/relatorios/entrada', ['as' => 'produtos.relatorios.entrada', 'uses' => 'ProdutosController@relatoriosEntrada']);
    Route::get('produtos/relatorios/saida', ['as' => 'produtos.relatorios.saida', 'ProdutosController@relatorioSaida']);
    Route::resource('produtos', 'ProdutosController');

    Route::get('categorias-produtos/arquivados', ['as' => 'categorias-produtos.arquivados', 'uses' => 'CategoriasProdutosController@arquivados']);
    Route::get('categorias-produtos/{id}/recuperar', ['as' => 'categorias-produtos.recuperar', 'uses' => 'CategoriasProdutosController@recuperar']);
    Route::resource('categorias-produtos', 'CategoriasProdutosController', ['except' => 'show']);

    Route::get('categorias-comissionistas/arquivados', ['as' => 'categorias-comissionistas.arquivados', 'uses' => 'CategoriasComissionistasController@arquivados']);
    Route::get('categorias-comissionistas/{id}/recuperar', ['as' => 'categorias-comissionistas.recuperar', 'uses' => 'CategoriasComissionistasController@recuperar']);
    Route::resource('categorias-comissionistas', 'CategoriasComissionistasController', ['except' => 'show']);

    Route::get('souvenirs/arquivados', ['as' => 'souvenirs.arquivados', 'uses' => 'SouvenirsController@arquivados']);
    Route::get('souvenirs/{id}/recuperar', ['as' => 'souvenirs.recuperar', 'uses' => 'SouvenirsController@recuperar']);
    Route::resource('souvenirs', 'SouvenirsController');

    Route::get('comissionistas/arquivados', ['as' => 'comissionistas.arquivados', 'uses' => 'ComissionistasController@arquivados']);
    Route::get('comissionistas/{id}/recuperar', ['as' => 'comissionistas.recuperar', 'uses' => 'ComissionistasController@recuperar']);
    Route::get('comissionistas/{id}/modificar-percentagem-comissao', ['as' => 'comissionistas.form-percentagem', 'uses' => 'ComissionistasController@formModificarPercentagem']);
    Route::put('comissionistas/{id}/modificar-percentagem-comissao', ['as' => 'comissionistas.modificar-percentagem', 'uses' => 'ComissionistasController@modificarPercentagem']);
    Route::resource('comissionistas', 'ComissionistasController');

    Route::get('fontes-reservas/arquivados', ['as' => 'fontes-reservas.arquivados', 'uses' => 'FontesReservasController@arquivados']);
    Route::get('fontes-reservas/{id}/recuperar', ['as' => 'fontes-reservas.recuperar', 'uses' => 'FontesReservasController@recuperar']);
    Route::resource('fontes-reservas', 'FontesReservasController', ['except' => 'show']);

    Route::get('reservas/relatorio', ['as' => 'reservas.relatorio', 'uses' => 'ReservasController@relatorio']);
    Route::post('reservas/{reserva}/estado-comissao', ['as' => 'reservas.confirmar-comissao', 'uses' => 'ReservasController@confirmarComissao']);
    Route::get('reservas/{reserva}/estado-comissao', ['as' => 'reservas.estado-comissao', 'uses' => 'ReservasController@estadoComissaoReserva']);
    Route::get('reservas/{reserva}/saldo', ['as' => 'reservas.saldo', 'uses' => 'ReservasController@saldoReserva']);
    Route::get('reservas/consultar-disponibilidade', ['as' => 'reservas.consultar-disponibilidade', 'uses' => 'ReservasController@consultarDisponibilidade']);
    Route::get('reservas/consultar-tipos-pagamento', ['as' => 'reservas.consultar-tipos-pagamentos', 'uses' => 'ReservasController@consultarTiposPagamento']);
    Route::get('reservas/{reserva}/registrar-pagamento', ['as' => 'reservas.pagamento-form', 'uses' => 'ReservasController@pagamentoForm']);
    Route::post('reservas/{reserva}/registrar-pagamento', ['as' => 'reservas.pagamento', 'uses' => 'ReservasController@pagamento']);
    Route::resource('reservas', 'ReservasController');

    Route::get('estadas', ['as' => 'estadas.index', 'uses' => 'EstadasController@index']);
    Route::get('estadas/{reserva}/checkin', ['as' => 'estadas.checkin-form', 'uses' => 'EstadasController@checkinForm']);
    Route::post('estadas/{reserva}/checkin', ['as' => 'estadas.checkin', 'uses' => 'EstadasController@checkin']);
    Route::post('estadas/{reserva}/checkout', ['as' => 'estadas.checkout', 'uses' => 'EstadasController@checkout']);
    Route::get('estadas/{estada}/hospedes', ['as' => 'estadas.edit-hospedes', 'uses' => 'EstadasController@editHospedes']);
    Route::put('estadas/{estada}/hospedes', ['as' => 'estadas.update-hospedes', 'uses' => 'EstadasController@updateHospedes']);
    Route::get('estadas/{estada}/quarto', ['as' => 'estadas.edit-quarto', 'uses' => 'EstadasController@editQuarto']);
    Route::put('estadas/{estada}/quarto', ['as' => 'estadas.update-quarto', 'uses' => 'EstadasController@updateQuarto']);
    Route::get('estadas/{estada}/frigobar', ['as' => 'estadas.create-frigobar', 'uses' => 'EstadasController@createFrigobar']);
    Route::post('estadas/{estada}/frigobar', ['as' => 'estadas.store-frigobar', 'uses' => 'EstadasController@storeFrigobar']);
    Route::get('estadas/{estada}/estado-conta', ['as' => 'estadas.estado-conta', 'uses' => 'EstadasController@estadoConta']);
    Route::get('estadas/{estada}/pagamento', ['as' => 'estadas.create-pagamento', 'uses' => 'EstadasController@createPagamento']);
    Route::post('estadas/{estada}/pagamento', ['as' => 'estadas.store-pagamento', 'uses' => 'EstadasController@storePagamento']);
    Route::get('estadas/{estada}/dano', ['as' => 'estadas.create-dano', 'uses' => 'EstadasController@createDano']);
    Route::post('estadas/{estada}/dano', ['as' => 'estadas.store-dano', 'uses' => 'EstadasController@storeDano']);
    Route::get('estadas/{estada}/extender', ['as' => 'estadas.create-extender', 'uses' => 'EstadasController@createExtender']);
    Route::post('estadas/{estada}/extender', ['as' => 'estadas.store-extender', 'uses' => 'EstadasController@storeExtender']);
    Route::get('estadas/{estada}', ['as' => 'estadas.show', 'uses' => 'EstadasController@show']);

    Route::get('caixa/historico', ['as' => 'caixas.index', 'uses' => 'CaixasController@index']);
    Route::get('caixa', ['as' => 'caixas.aberto', 'uses' => 'CaixasController@aberto']);
    Route::get('caixa/abrir', ['as' => 'caixas.create-abrir', 'uses' => 'CaixasController@createAbrir']);
    Route::post('caixa/abrir', ['as' => 'caixas.abrir', 'uses' => 'CaixasController@abrir']);
    Route::delete('caixa', ['as' => 'caixas.fechar', 'uses' => 'CaixasController@fechar']);
    Route::get('caixa/deposito', ['as' => 'caixas.create-deposito', 'uses' => 'CaixasController@createDeposito']);
    Route::post('caixa/deposito', ['as' => 'caixas.deposito', 'uses' => 'CaixasController@deposito']);
    Route::get('caixa/saque', ['as' => 'caixas.create-saque', 'uses' => 'CaixasController@createSaque']);
    Route::post('caixa/saque', ['as' => 'caixas.saque', 'uses' => 'CaixasController@saque']);
});

Route::get('/home', 'HomeController@index');
