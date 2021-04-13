<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Duvida;
use App\Models\Comentario;

/**
 * @package API
 * Classe responsável por Controlar as requisições da API envolvendo Comunidade
 */
class DuvidasController extends ApiController {
    
    /**
     * [Necessário estar autenticado]
     * Cadastra uma nova dúvida
     * @api 
     */
    public function cadastrar(Request $request) {
        $usuarioID = $this->getUsuarioID($request);
        $validation = Validator::make($request->duvida, [
            'titulo'    => 'required',
            'descricao' => 'required',
            'anonimo'   => 'required'
        ]);

        if ($validation->fails()) return response()->json($validation->errors(), 400);

        //Inicio cadastro da duvida
        $duvida = $request->duvida;
        unset($duvida['comentarios'], $duvida['autor'], $duvida['data'], $duvida['id']);
        $duvida['usuario_id'] = $usuarioID;
        $duvida = Duvida::create($duvida);
        
        return response()->json($duvida, 200);
    }

    /**
     * Recupera os dados de uma duvida existente
     * @api 
     * @param $id ID da duvida
     * @info: 
     */
    public function abrir(Request $request, int $id) {
        $duvida = Duvida::findOrFail($id);
        $duvida->load('comentarios');
        return response()->json($duvida, 200);
    }

    /**
     * [Necessário estar autenticado]
     * Responde uma duvida
     * @api 
     * @param $id ID da duvida
    */
    public function responder(Request $request, int $id) {
        $usuarioID = $this->getUsuarioID($request);
        $validation = Validator::make($request->comentario, [
            'comentario'    => 'required'
        ]);

        if ($validation->fails()) return response()->json($validation->errors(), 400);

        //Responde a pergunta
        $comentario = [
            'comentario'    => $request->comentario['comentario'],
            'usuario_id'    => $usuarioID,
            'duvida_id'     => $id
        ];

        $comentario = Comentario::create($comentario);
        $comentario->load('autor');        
        return response()->json($comentario, 200);
    }

    /**
     * Cadastra uma nova dúvida
     * @api
     */
    public function todas(Request $request) {
        $duvidas = Duvida::orderBy('id', 'desc')->limit(20)->get();
        
        foreach ($duvidas as $key => $duvida) {
            if ($duvida->anonimo) $duvida->unsetRelation('autor');
        }

        $duvidas->load('comentarios');

        return response()->json($duvidas, 200);
    } 

    /**
     * [Necessário estar autenticado]
     * Recupera duvidas do usuário autenticado
     */
    public function minhas(Request $request) {
        $usuarioID = $this->getUsuarioID($request);
        if (!$usuarioID) return response()->json([], 200);

        $duvidas = Duvida::where('usuario_id', $usuarioID)->orderBy('id', 'desc')->get();
        
        foreach ($duvidas as $key => $duvida) {
            if ($duvida->anonimo) $duvida->unsetRelation('autor');
        }

        $duvidas->load('comentarios');
        
        return response()->json($duvidas, 200);
    }

    /**
    * Buscar Uma mensagem baseado em um texto
    */
    public function buscar(Request $request, string $texto) {
        
        $duvidas = Duvida::where('titulo', 'like', '%'.$texto.'%')
                        ->orWhere('descricao', 'like', '%'.$texto.'%')
                        ->orderBy('id', 'desc')->get();
        
        foreach ($duvidas as $key => $duvida) {
            if ($duvida->anonimo) $duvida->unsetRelation('autor');
        }

        $duvidas->load('comentarios');
        
        return response()->json($duvidas, 200);
    }

    /** Remove a dúvida */
    public function remover(Request $request, int $duvidaID) {
        $usuarioID = $this->getUsuarioID($request);
        Duvida::where('usuario_id', $usuarioID)->where('id', $duvidaID)->delete();
        return response()->json(['sucesso' => true], 200);
    }
 }
