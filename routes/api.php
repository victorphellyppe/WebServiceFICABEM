<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
*/
Route::post('/login', 'Api\UsuariosController@logar');
Route::put('/senha', 'Api\UsuariosController@recuperarSenha');

Route::group(['prefix' => 'usuarios'], function () {
    Route::post('/', 'Api\UsuariosController@registrar');
    Route::get('/{id}', 'Api\UsuariosController@buscar');    
});

//Necessário estar autenticado
Route::group(['middleware' => ['jwt']], function () {   
   
    Route::group(['prefix' => 'ravvs'], function () {
        Route::get('quem-somos', 'Api\RAVVSController@quemSomos');
        Route::get('contato', 'Api\RAVVSController@contato');
        Route::get('grupos', 'Api\RAVVSController@grupos');
    });
    
    Route::group(['prefix' => 'duvidas'], function () {
        Route::post('/', 'Api\DuvidasController@cadastrar');
        Route::delete('/{id}', 'Api\DuvidasController@remover');
        Route::post('/comentario/{id}', 'Api\DuvidasController@responder');

        Route::get('/', 'Api\DuvidasController@todas');
        Route::get('/busca/{texto}', 'Api\DuvidasController@buscar');
        Route::get('/minhas', 'Api\DuvidasController@minhas');
        Route::get('/{id}', 'Api\DuvidasController@abrir');
    }); 

    Route::group(['prefix' => 'usuarios'], function () {
        Route::put('senha', 'Api\UsuariosController@atualizarSenha');
        Route::put('dados', 'Api\UsuariosController@atualizarDados');
    }); 

    Route::group(['prefix' => 'questionario'], function () {
        Route::post('/', 'Api\QuestionarioController@cadastrar');
    });

    Route::group(['prefix' => 'contatos'], function () {
        Route::get('/', 'Api\ContatosController@listar');
        Route::post('/', 'Api\ContatosController@cadastrar');
        Route::put('/{id}/{ativo}', 'Api\ContatosController@ativar');
        Route::delete('/{id}', 'Api\ContatosController@excluir');
    });
});