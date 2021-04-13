<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContatoRAVVS;

class ContatoController extends Controller
{
     /** Abre Configurações de Contato da RAVVS */
     public function index() {
        $this->dados['ravvs'] = ContatoRAVVS::first();
        return view('contato.edicao', $this->dados);
    }
    
    /** Tenta editar um conteúdo e salvar no banco
     * @param $id id do contéudo
     */
    public function editar(Request $request) {
        $request->validate([
            'telefone'  => 'required',
            'endereco'  => 'required',
            'email'  => 'required|email'
        ]);
        ContatoRAVVS::first()->update($request->except(['_token']));

        return redirect()->route('contato-ravvs')->with(['sucesso' => 'Contato atualizado com sucesso']);
    }
}
