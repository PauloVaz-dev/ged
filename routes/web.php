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

Route::get('/', 'DigitalizacaoController@index')
    ->name('digitalizacao.index');
/*
Route::get('/error', 'ClienteController@index')
    ->name('cliente.cliente.index');
*/



Route::post('/consultaCpfCnpf', 'UtilController@consultaCpfCnpf')
    ->name('cliente.consultaCpfCnpf');

Route::get('criarProjeto/{id}', 'UtilController@criarProjeto')
    ->name('criarProjeto.criarProjeto');

Route::post('criarContrato/', 'UtilController@criarContrato')
    ->name('criarContrato.criarContrato');

Route::post('deletaContratoConcercionaria/', 'UtilController@deletaContratoConcercionaria')
    ->name('deletaContratoConcercionaria');

Route::post('arquivarProposta/', 'UtilController@arquivarProposta')
    ->name('arquivarProposta.arquivarProposta');

Route::post('simular/', 'UtilController@simular')
    ->name('simular.simular');

Route::post('arquivarProjeto/', 'UtilController@arquivarProjeto')
    ->name('arquivarProjeto.arquivarProjeto');

Route::get('/consultaCidades/{id}', 'UtilController@getCidades')
    ->name('getEstado');

Route::post('/getclientes/', 'UtilController@getClientes')
    ->name('getclientes');

//Route::any('/simulador', ['middleware' => 'cors' , 'simulador'=> 'UtilController@simulador']);
Route::any('/simulador', 'UtilController@simulador')->name('simulador')->middleware('cors');
//Route::get('myRoute', ['middleware' => 'cors' , 'uses'=> 'MyController@Action']

//Route::get('/home', 'HomeController@index')->name('home');

//Url para receber reuqest do boletofacil
Route::any('/notificationUrl', 'NotificationUrl@notificationUrl')->name('notificationUrl');

Route::any('/report/{id}/FichaElaboracaoProjeto', 'ReportController@reportPdfFichaElaboracaoProjeto')->name('reportIndex');
Route::any('/report/{id}/Procuracao', 'ReportController@reportPdfProcuracao')->name('reportIndexProcuracao');
Route::any('/report/{id}/Contrato', 'ReportController@reportPdfContrato')->name('reportIndexContrato');
Route::any('/report/{id}/Declaracao', 'ReportController@reportPdfDeclaracao')->name('reportIndexDeclaracao');
Route::any('/report/{id}/proposta', 'ReportController@reportPdfProposta')->name('reportIndexProposta');
Route::get('/report/reportPdf', 'ReportController@reportPdf')->name('reportPdf');
Route::any('/report/ProjetosParecerAcesso', 'ReportController@reportPdfParecerAcesso')->name('reportPdfParecerAcesso');

Route::any('/report/reportProjetos', 'ReportController@reportProjeto')->name('reportProjeto');

Route::any('/report/lerArquivo', 'ReportController@lerArquivo')->name('lerArquivo');


//Route::any('/enableDisableSecret', 'NotificationUrl@notificationUrl')->name('notificationUrl');



Route::group(
    [
        'prefix' => 'report',
    ], function () {

    Route::get('/financeiro', 'ReportController@reportPdfFinanceiro')
        ->name('report.financeiro');

    Route::get('/financeiroCliente', 'ReportController@reportPdfFinanceiroCliente')
        ->name('report.financeiroCliente');
});







Route::group(
    [
        'prefix' => 'digitalizacao-file',
    ], function () {

    Route::post('/','DigitalizacaoFileController@findAllDigitalizacao')
        ->where('id', '[0-9]+');

});

Route::group(
    [
        'prefix' => 'digitalizacao',
    ], function () {

    Route::get('/edit','DigitalizacaoController@edit')
        ->name('digitalizacao.edit')
        ->where('id', '[0-9]+');

    Route::get('/', 'DigitalizacaoController@index')
        ->name('digitalizacao.index');

    Route::get('/grid', 'DigitalizacaoController@grid')
        ->name('digitalizacao.grid');

    Route::get('/create/{despesa_tipo}', 'DigitalizacaoController@create')
        ->name('digitalizacao.create');

    Route::get('/{id}/edit','DigitalizacaoController@edit')
        ->name('digitalizacao.edit');

    Route::put('/update/{id}', 'DigitalizacaoController@update')
        ->name('digitalizacao.update');

    Route::post('/', 'DigitalizacaoController@store')
        ->name('digitalizacao.store');
});

Route::group(
    [
        'prefix' => 'modalidade',
    ], function () {

    Route::get('/edit','ModalidadeController@edit')
        ->name('modalidade.edit')
        ->where('id', '[0-9]+');

    Route::get('/', 'ModalidadeController@index')
        ->name('modalidade.index');

    Route::get('/grid', 'ModalidadeController@grid')
        ->name('modalidade.grid');

    Route::get('/create', 'ModalidadeController@create')
        ->name('modalidade.create');

    Route::get('/{id}/edit','ModalidadeController@edit')
        ->name('modalidade.edit');

    Route::put('/update/{id}', 'ModalidadeController@update')
        ->name('modalidade.update');

    Route::post('/', 'ModalidadeController@store')
        ->name('modalidade.store');
});


Route::group(
    [
        'prefix' => 'secretaria',
    ], function () {

    Route::get('/edit','SecretariaController@edit')
        ->name('modalidade.edit')
        ->where('id', '[0-9]+');

    Route::get('/', 'SecretariaController@index')
        ->name('secretaria.index');

    Route::get('/grid', 'SecretariaController@grid')
        ->name('secretaria.grid');

    Route::get('/create', 'SecretariaController@create')
        ->name('secretaria.create');

    Route::get('/{id}/edit','SecretariaController@edit')
        ->name('secretaria.edit');

    Route::put('/update/{id}', 'SecretariaController@update')
        ->name('secretaria.update');

    Route::post('/', 'SecretariaController@store')
        ->name('secretaria.store');
});

Route::group(
[
    'prefix' => 'users',
], function () {

    Route::get('/', 'UsersController@index')
         ->name('users.user.index');

    Route::get('/create','UsersController@create')
         ->name('users.user.create');

    Route::get('/show/{user}','UsersController@show')
         ->name('users.user.show')
         ->where('id', '[0-9]+');

    Route::get('/grid', 'UsersController@grid')
        ->name('users.user.grid');


    Route::get('/{user}/edit','UsersController@edit')
         ->name('users.user.edit')
         ->where('id', '[0-9]+');

    Route::post('/', 'UsersController@store')
         ->name('users.user.store');
               
    Route::put('user/{user}', 'UsersController@update')
         ->name('users.user.update')
         ->where('id', '[0-9]+');

    Route::delete('/{user}/destroy','UsersController@destroy')
         ->name('users.user.destroy')
         ->where('id', '[0-9]+');

});



Route::group(
[
    'prefix' => 'franquia',
], function () {

    Route::get('/', 'FranquiaController@index')
         ->name('franquia.franquia.index');

    Route::get('/create','FranquiaController@create')
         ->name('franquia.franquia.create');

    Route::get('/grid', 'FranquiaController@grid')
         ->name('franquia');

    Route::get('/show/{franquia}','FranquiaController@show')
         ->name('franquia.franquia.show')
         ->where('id', '[0-9]+');

    Route::get('/{franquia}/edit','FranquiaController@edit')
         ->name('franquia.franquia.edit')
         ->where('id', '[0-9]+');

    Route::post('/', 'FranquiaController@store')
         ->name('franquia.franquia.store');
               
    Route::put('franquia/{franquia}', 'FranquiaController@update')
         ->name('franquia.franquia.update')
         ->where('id', '[0-9]+');

    Route::delete('/{franquia}/destroy','FranquiaController@destroy')
         ->name('franquia.franquia.destroy')
         ->where('id', '[0-9]+');

});

Route::group(
[
    'prefix' => 'parametro',
], function () {

    Route::get('/', 'ParametroController@index')
         ->name('parametro.parametro.index');

    Route::get('/create','ParametroController@create')
         ->name('parametro.parametro.create');

    Route::get('/grid', 'ParametroController@grid')
         ->name('[% grid_route_name %]');

    Route::get('/show/{parametro}','ParametroController@show')
         ->name('parametro.parametro.show')
         ->where('id', '[0-9]+');

    Route::get('/{parametro}/edit','ParametroController@edit')
         ->name('parametro.parametro.edit')
         ->where('id', '[0-9]+');

    Route::post('/', 'ParametroController@store')
         ->name('parametro.parametro.store');
               
    Route::put('parametro/{parametro}', 'ParametroController@update')
         ->name('parametro.parametro.update')
         ->where('id', '[0-9]+');

    Route::delete('/{parametro}/destroy','ParametroController@destroy')
         ->name('parametro.parametro.destroy')
         ->where('id', '[0-9]+');

});

Route::group(
[
    'prefix' => 'contrato',
], function () {

    Route::get('/', 'ContratoController@index')
         ->name('contrato.contrato.index');

    Route::get('/create','ContratoController@create')
         ->name('contrato.contrato.create');

    Route::get('/grid', 'ContratoController@grid')
         ->name('[% grid_route_name %]');

    Route::get('/show/{contrato}','ContratoController@show')
         ->name('contrato.contrato.show')
         ->where('id', '[0-9]+');

    Route::get('/{contrato}/edit','ContratoController@edit')
         ->name('contrato.contrato.edit')
         ->where('id', '[0-9]+');

    Route::post('/', 'ContratoController@store')
         ->name('contrato.contrato.store');
               
    Route::put('contrato/{contrato}', 'ContratoController@update')
         ->name('contrato.contrato.update')
         ->where('id', '[0-9]+');

    Route::delete('/{contrato}/destroy','ContratoController@destroy')
         ->name('contrato.contrato.destroy')
         ->where('id', '[0-9]+');

});


Route::group(
[
    'prefix' => 'projetov2',
], function () {

    Route::get('/', 'Projetov2Controller@index')
         ->name('projetov2.projetov2.index');

    Route::get('/create','Projetov2Controller@create')
         ->name('projetov2.projetov2.create');

    Route::get('/grid', 'Projetov2Controller@grid')
         ->name('projetov2.index');

    Route::get('/show/{projetov2}','Projetov2Controller@show')
         ->name('projetov2.projetov2.show')
         ->where('id', '[0-9]+');

    Route::get('/{projetov2}/edit','Projetov2Controller@edit')
         ->name('projetov2.projetov2.edit')
         ->where('id', '[0-9]+');

    Route::post('/', 'Projetov2Controller@store')
         ->name('projetov2.projetov2.store');
               
    Route::put('projetov2/{projetov2}', 'Projetov2Controller@update')
         ->name('projetov2.projetov2.update')
         ->where('id', '[0-9]+');

    Route::delete('/{projetov2}/destroy','Projetov2Controller@destroy')
         ->name('projetov2.projetov2.destroy')
         ->where('id', '[0-9]+');

    Route::get('/arquivadas/index', 'ProjetoArquivadoController@index')
        ->name('projetov2.arquivados.index');

    Route::get('/arquivadas/grid', 'ProjetoArquivadoController@grid')
        ->name('projetov2.arquivados.grid');

});

Route::group(
    [
        'prefix' => 'produto',
    ], function () {

    Route::get('/', 'ProdutoController@index')
        ->name('produto.index');

    Route::get('/create','ProdutoController@create')
        ->name('produto.create');

    Route::get('/grid', 'ProdutoController@grid')
        ->name('produto.grid');

    Route::get('/{produto}/edit','ProdutoController@edit')
        ->name('produto.edit')
        ->where('id', '[0-9]+');

    Route::post('/', 'ProdutoController@store')
        ->name('produto.store');

    Route::put('produto/{id}', 'ProdutoController@update')
        ->name('produto.update')
        ->where('id', '[0-9]+');

    Route::delete('/{produto}/destroy','ProdutoController@destroy')
        ->name('produto.destroy')
        ->where('id', '[0-9]+');

    Route::get('/arquivadas/index', 'ProjetoArquivadoController@index')
        ->name('projetov2.arquivados.index');

    Route::get('/arquivadas/grid', 'ProjetoArquivadoController@grid')
        ->name('projetov2.arquivados.grid');

});


Route::group(
    [
        'prefix' => 'financeiro',
    ], function () {

    Route::get('/', 'Financeiro\ContasPagarReceberController@index')
        ->name('financeiro.index');

    Route::get('/create','Financeiro\ContasPagarReceberController@create')
        ->name('financeiro.create');

    Route::get('/grid', 'Financeiro\ContasPagarReceberController@grid')
        ->name('financeiro.grid');

    Route::get('/{produto}/edit','Financeiro\ContasPagarReceberController@edit')
        ->name('financeiro.edit')
        ->where('id', '[0-9]+');

    Route::post('/', 'Financeiro\ContasPagarReceberController@store')
        ->name('financeiro.store');

    Route::put('produto/{id}', 'Financeiro\ContasPagarReceberController@update')
        ->name('financeiro.update')
        ->where('id', '[0-9]+');

    Route::delete('/{produto}/destroy','Financeiro\ContasPagarReceberController@destroy')
        ->name('financeiro.destroy')
        ->where('id', '[0-9]+');

    Route::get('/paramsdefault','Financeiro\ContasPagarReceberController@paramsDefault')
        ->name('financeiro.paramsdefault')
        ->where('id', '[0-9]+');

});

Route::group(
    [
        'prefix' => 'alert',
    ], function () {

    Route::get('/', 'AlertController@index')
        ->name('alert.index');

    Route::get('/create','AlertController@create')
        ->name('alert.create');

    Route::get('/grid', 'AlertController@grid')
        ->name('alert.grid');

    Route::get('/{produto}/edit','AlertController@edit')
        ->name('alert.edit')
        ->where('id', '[0-9]+');

    Route::post('/', 'AlertController@store')
        ->name('alert.store');

    Route::put('produto/{id}', 'AlertController@update')
        ->name('alert.update')
        ->where('id', '[0-9]+');

    Route::delete('/{id}/destroy','AlertController@destroy')
        ->name('alert.destroy')
        ->where('id', '[0-9]+');

    Route::get('/lastForAlerts', 'AlertController@lastForAlerts')
        ->name('alert.grid');

});