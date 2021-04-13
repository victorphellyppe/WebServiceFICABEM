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

Route::get('/', function() { return redirect()->route('login'); });

Route::get('/login', 'LoginController@index')->name('login');
Route::post('/logar', 'LoginController@logar')->name('logar');
Route::get('/logout', 'LoginController@logout')->name('logout');
Route::get('/nova-senha', 'LoginController@recuperarSenha')->name('senha.recuperar');
Route::post('/nova-senha', 'LoginController@salvarNovaSenha')->name('senha.nova');

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    //================ USUARIOS ============================//
    Route::group(['prefix' => 'usuarios'], function () {
        Route::get('/', 'UsuariosController@index')->name('usuarios.listar');
        Route::get('/novo', 'UsuariosController@novo')->name('usuarios.novo');
        Route::post('/cadastrar', 'UsuariosController@cadastrar')->name('usuarios.cadastrar');
        Route::get('/edicao/{id}', 'UsuariosController@edicao')->name('usuarios.edicao');
        Route::post('/editar/{id}', 'UsuariosController@editar')->name('usuarios.editar');
        Route::get('/excluir/{id?}', 'UsuariosController@excluir')->name('usuarios.excluir');
    });
    //================== QUEM SOMOS ==========================//
    Route::group(['prefix' => 'quem-somos'], function () {
        Route::get('/', 'QuemSomosController@index')->name('quem-somos.listar');
        Route::get('/nova', 'QuemSomosController@novo')->name('quem-somos.nova');
        Route::post('/cadastrar', 'QuemSomosController@cadastrar')->name('quem-somos.cadastrar');
        Route::get('/edicao/{id}', 'QuemSomosController@edicao')->name('quem-somos.edicao');
        Route::post('/editar/{id}', 'QuemSomosController@editar')->name('quem-somos.editar');
        Route::get('/excluir/{id?}', 'QuemSomosController@excluir')->name('quem-somos.excluir');
        Route::post('/posicao', 'QuemSomosController@posicao')->name('quem-somos.posicao');
    });
    // ==================  CONTATO RAVVS =======================//
    Route::group(['prefix' => 'contato-ravvs'], function () {
        Route::get('/', 'ContatoController@index')->name('contato-ravvs');
        Route::post('/editar', 'ContatoController@editar')->name('contato-ravvs.editar');
    });
    // =====================  GRUPOS =========================//
    Route::group(['prefix' => 'grupos'], function () {
        Route::get('/', 'GruposController@index')->name('grupos.listar');
        Route::get('/novo', 'GruposController@novo')->name('grupos.novo');
        Route::post('/cadastrar', 'GruposController@cadastrar')->name('grupos.cadastrar');
        Route::get('/edicao/{id}', 'GruposController@edicao')->name('grupos.edicao');
        Route::post('/editar/{id}', 'GruposController@editar')->name('grupos.editar');
        Route::get('/excluir/{id?}', 'GruposController@excluir')->name('grupos.excluir');
    });
    // =============== DUVIDAS/COMUNIDADE ================== //
    Route::group(['prefix' => 'duvidas'], function () {
        Route::get('/', 'DuvidasController@index')->name('duvidas.listar');
        Route::get('/comentarios/{duvidaID}', 'DuvidasController@comentarios')->name('duvidas.comentarios');
        Route::get('/comentarios/novo/{duvidaID}', 'DuvidasController@novoComentario')->name('duvidas.comentarios.novo');
        Route::post('/comentarios/{duvidaID}', 'DuvidasController@cadastrarComentario')->name('duvidas.comentarios.cadastrar');
        Route::get('/excluir/{id?}', 'DuvidasController@excluir')->name('duvidas.excluir');
        Route::get('/comentarios/excluir/{comentarioID?}', 'DuvidasController@excluirComentario')->name('duvidas.comentarios.excluir');
    });

    Route::group(['prefix' => 'relatorio'], function () {
        Route::group(['prefix' => 'questionario'], function () {
            Route::get('/', 'RelatorioController@questionarios')->name('relatorio.dados');
            Route::get('/excluir/{id?}', 'RelatorioController@excluir')->name('relatorio.excluir');
            Route::get('/download/{id}', 'RelatorioController@baixarQuestionario')->name('relatorio.dados.ocorrencia');
            Route::get('/{id}/{atendido}', 'RelatorioController@atendido')->name('relatorio.dados.atendido');
            Route::get('/download', 'RelatorioController@baixarTodos')->name('relatorio.dados.todos');
        });

        Route::get('/estatistica', 'RelatorioController@estatistica')->name('relatorio.estatistica');
    });
});

