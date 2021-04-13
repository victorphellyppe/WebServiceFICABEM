<?php

namespace App\Http\Controllers\Api;

use App\Mail\RecuperarSenha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Usuario;
use App\Rules\Cpf;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Mail;

/**
 * @package API
 * Classe responsável por Controlar as requisições da API envolvendo usuário
 */
class UsuariosController extends ApiController {
    
    /** Loga o usuário */
    public function logar(Request $request) {
        $usuario = Usuario::where('email', $request->email)
                            ->where('senha', md5($request->senha))
                            ->firstOrFail(); //Senão achar retorna 404

        $jwt = JWT::encode(['id' => $usuario->id], config('jwt.senha'));
        return response()->json(['usuario' => $usuario, 'jwt' => $jwt], 200);
    }


    /** Cadastra um novo usuário */
    public function registrar(Request $request) {

        $validation = Validator::make($request->usuario, [
            'nome'  => 'required',
            'email' => 'required|email|unique:usuarios,email',
            'senha' => 'required|min:6'
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 400);
        } else {
            $usuario = $request->usuario;
            $usuario['data_nascimento'] = substr($usuario['data_nascimento'], 0, 10); //Recupera apenas 0000-00-00 

            $usuario['senha'] = md5($usuario['senha']);
            $usuario = Usuario::create($usuario);

            $jwt = JWT::encode(['id' => $usuario->id], config('jwt.senha'));
            return response()->json([
                'usuario'   => $usuario,
                'jwt'       => $jwt
            ], 201);
        }
    }

    /** Atualiza senha */
    public function atualizarSenha(Request $request) {
        //Busca o usuário pelo JWT
        $usuarioID = $this->getUsuarioID($request);
        $usuario = Usuario::findOrFail($usuarioID);

        //Cria validação  
        $validation = Validator::make($request->usuario, [
            'senha' => 'required|min:6'
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 400);
        } else {
            //Atualiza a senha
            $usuario->senha = md5($request->usuario['senha']);
            $usuario->save();
            return response()->json(['sucesso'=> true], 200);
        }
    }

    /** Atualiza senha */
    public function atualizarDados(Request $request) {
        //Busca o usuário pelo JWT
        $usuarioID = $this->getUsuarioID($request);
        $usuario = Usuario::findOrFail($usuarioID);

        //Cria validação  
        $validation = Validator::make($request->usuario, [
            'nome'  => 'required',
            'email' => 'required|email|unique:usuarios,email,'.$usuarioID,
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 400);
        } else {
            //Atualiza a senha
            $dados = $request->usuario;
            $dados['data_nascimento'] = substr($dados['data_nascimento'], 0, 10); //Recupera apenas 0000-00-00 

            Usuario::where('id', $usuarioID)->update($dados);
            return response()->json(['sucesso'=> true], 200);
        }
    }

    /**
     * Busca um usuário do sistema
     * @param $id ID do usuário
     */
    public function buscar($id) {
        $usuario = Usuario::findOrFail($id);
        return response()->json(['usuario'=> $usuario], 200);
    }

     /** Recupera a senha do usuário */
     public function recuperarSenha(Request $request) {
        
        $usuario = Usuario::where('email', $request->email)->firstOrFail();

        $token = JWT::encode([
            'id'    => $usuario->id,
            'exp'   => time() + (60*60*2) //Link expira em 2h
        ], config('jwt.senha'));
        //echo $usuario->email;die;
        Mail::to($usuario->email)->send(new RecuperarSenha($usuario, $token));

        return response()->json(['sucesso' => true], 200);
    }
}
