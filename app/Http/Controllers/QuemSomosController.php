<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuemSomos;

class QuemSomosController extends Controller {
    //
    private $dados = ['menu' => 'ravvs'];

    /** Lista o usuários */
    public function index() {
        $this->dados['abas'] = QuemSomos::orderBy('posicao')->get();
        return view('quem-somos.listar', $this->dados);
    }

    /** 
     * Abre a tela cadastrar nova aba
     */
    public function novo() {
        $this->dados['aba'] = new QuemSomos;
        $this->dados['aba']->posicao = QuemSomos::count() + 1;

        return view('quem-somos.novo', $this->dados);
    }

    /** 
     * Tenta salvar uma nova aba
     */
    public function cadastrar(Request $request) {
        $request->validate([
            'descricao' => 'required',
            'posicao'   => 'required|integer'
        ]);
        
        $dados = $request->all();

        //Ajusta posicao
        $total = QuemSomos::count();
        $dados['posicao'] = ($dados['posicao'] <= 0 ? 1 : $dados['posicao']);
        $dados['posicao'] = ($dados['posicao'] > $total ? $total+1 : $dados['posicao']); 
        
        $aba = QuemSomos::create($dados);
        //Ajusta a posição das demais abas
        if ($aba->posicao != $total+1) $this->ajustarPosicoes($aba->posicao, $aba->id);
        


        return redirect()->route('quem-somos.listar')->with(['sucesso' => 'Aba cadastrada com sucesso']);
    }

    /** 
     * Abre a tela de editar aba
     * @param $id id da aba
     */
    public function edicao(int $id) {
        $this->dados['aba'] = QuemSomos::findOrFail($id);
        return view('quem-somos.edicao', $this->dados);
    }
    
    /** Tenta editar uma aba e salvar no banco
     * @param $id id da aba
     */
    public function editar(Request $request, int $id) {
        $request->validate([
            'descricao' => 'required',
            'posicao'   => 'required|integer'
        ]);
        $aba = QuemSomos::findOrFail($id);
        $dados = $request->except(['_token']);

        //Ajusta posição
        $total = QuemSomos::count();
        $dados['posicao'] = ($dados['posicao'] <= 0 ? 1 : $dados['posicao']);
        $dados['posicao'] = ($dados['posicao'] > $total ? $total : $dados['posicao']); 
        QuemSomos::where('id', $id)->update($dados);
        
        if ($dados['posicao'] != $aba->posicao) 
            $this->ajustarPosicoes($dados['posicao'], $id);

        return redirect()->route('quem-somos.listar')->with(['sucesso' => 'Aba editada com sucesso']);
    }
    
    /** Remove uma aba
     * @param $id id da aba
     */
    public function excluir(int $id) {
        QuemSomos::destroy($id);
        $this->reajustarPosicoes();
        return redirect()->route('quem-somos.listar')->with('sucesso', 'Aba excluida');
    }

    public function posicao(Request $request) {
        $aba = QuemSomos::findOrFail($request->id);
        $aba->posicao += ($request->sobe == 'true'? -1 : 1);
        //Ajusta posição
        $total = QuemSomos::count();
        $aba->posicao = ($aba->posicao <= 0 ? 1 : $aba->posicao);
        $aba->posicao = ($aba->posicao > $total ? $total : $aba->posicao); 
        $aba->save();
        echo $aba->posicao;
        
        $this->ajustarPosicoes($aba->posicao, $aba->id, $request->sobe == 'false');
    }

    /**
     * Atualiza a posição de todos os itens, para evitar posições vazias
     */
    private function reajustarPosicoes() {
        $abas = QuemSomos::orderBy('posicao')->get();
        //ajusta a posição dos itens
        foreach ($abas as $key => $aba) {
            $aba->posicao = $key+1;
            $aba->save();
        }
    }
 
    /**
     * Empurra todos os itens para baixo a partir de uma posição
     * @param $posicao posições que serão empurradas
     * @param $excetoID id que não irá sofrer ajuste
     * @param $descer quem ocupada a posição anterior deve descer
     */
    private function ajustarPosicoes(int $posicao, int $excetoID, bool $descer = false) {
        if ($descer) {
            $aba = QuemSomos::where('posicao', '=', $posicao)->where('id', '!=', $excetoID)->first();
            $aba->posicao--;
            $aba->save();
        }
        $abas = QuemSomos::where('posicao', '>=', $posicao)->where('id', '!=', $excetoID)->orderBy('posicao')->get();
        
        if ($posicao) {
            foreach ($abas as $key => $aba) {    
                $aba->posicao++;
                $aba->save();
            }
        }

        $this->reajustarPosicoes();
    }
}
