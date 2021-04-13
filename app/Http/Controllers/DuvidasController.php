<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Duvida;
use App\Models\Comentario;
class DuvidasController extends Controller {
    //
    private $dados = ['menu' => 'comunidade'];

    /** Lista o conteúdo */
    public function index() {
        $this->dados['duvidas'] = Duvida::paginate(10);
        return view('duvidas.listar', $this->dados);
    }

    /** Exibe os comentários da dúvida */
    public function comentarios(int $duvidaID) {
        $this->dados['duvida'] = Duvida::find($duvidaID);
        $this->dados['comentarios'] = Comentario::where('duvida_id', $duvidaID)->paginate(10);
        return view('duvidas.comentarios.listar', $this->dados);
    }

    /** 
     * Abre a tela de cadastro de comentário
     */
    public function novoComentario(int $duvidaID) {
        $this->dados['comentario'] = new Comentario;
        $this->dados['duvida'] = Duvida::findOrFail($duvidaID);
        return view('duvidas.comentarios.novo', $this->dados);
    }

    /** 
     * Tenta salvar o comentário
     */
    public function cadastrarComentario(Request $request, int $duvidaID) {
        $request->validate([
            'comentario' => 'required'
        ]);
        
        $comentario = [
            'comentario'    => $request->comentario,
            'usuario_id'    => session('usuario')->id,
            'duvida_id'     => $duvidaID
        ];
        Comentario::create($comentario);
        
        return redirect()->route('duvidas.comentarios', ['duvidaID' => $duvidaID])->with(['sucesso' => 'Comentário cadastrado com sucesso']);
    }
 
    /** Remove um conteúdo
     * @param $duvidaID id do conteúdo
     */
    public function excluir(int $duvidaID) {
        Duvida::destroy($duvidaID);
        return redirect()->route('duvidas.listar')->with('sucesso', 'Dúvida excluida');
    }

    /** Remove um conteúdo
     * @param $duvidaID id do conteúdo
     */
    public function excluirComentario(int $comentarioID) {
        $comentario = Comentario::findOrFail($comentarioID);
        $duvidaID = $comentario->duvida_id;
        $comentario->delete();
        return redirect()->route('duvidas.comentarios', ['duvidaID' => $duvidaID])->with('sucesso', 'Dúvida excluida');
    }
}
