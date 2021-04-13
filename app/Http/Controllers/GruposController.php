<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GrupoApoio;

class GruposController extends Controller {
    //
    private $dados = ['menu' => 'ravvs'];

    /** Lista o conteúdo */
    public function index() {
        $this->dados['grupos'] = GrupoApoio::paginate(10);
        return view('grupos.listar', $this->dados);
    }

    /** 
     * Abre a tela de cadastro
     */
    public function novo() {
        $this->dados['grupo'] = new GrupoApoio;
        return view('grupos.novo', $this->dados);
    }

    /** 
     * Tenta salvar o conteúdo
     */
    public function cadastrar(Request $request) {
        $request->validate([
            'nome'      => 'required',
            'endereco'  => 'required'
        ]);
        
        GrupoApoio::create($request->all());
        
        return redirect()->route('grupos.listar')->with(['sucesso' => 'Grupo cadastrado com sucesso']);
    }

    /** 
     * Abre a tela de edição
     * @param $id id do conteúdo
     */
    public function edicao(int $id) {
        $this->dados['grupo'] = GrupoApoio::findOrFail($id);
        return view('grupos.edicao', $this->dados);
    }
    
    /** Tenta editar um conteúdo e salvar no banco
     * @param $id id do contéudo
     */
    public function editar(Request $request, int $id) {
        $request->validate([
            'nome'      => 'required',
            'endereco'  => 'required'
        ]);
        GrupoApoio::where('id', $id)->update($request->except(['_token']));

        return redirect()->route('grupos.listar')->with(['sucesso' => 'Grupo editado com sucesso']);
    }
    
    /** Remove um conteúdo
     * @param $id id do conteúdo
     */
    public function excluir(int $id) {
        GrupoApoio::destroy($id);
        return redirect()->route('grupos.listar')->with('sucesso', 'Grupo excluido');
    }
}
