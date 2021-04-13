<?php

namespace App\Http\Controllers;

use App\Models\Denuncia;
use Illuminate\Http\Request;
use App\Models\Questionario;
use App\Models\Questionario\MeioViolencia;
use App\Models\Questionario\Local;
use App\Models\Questionario\MotivoNaoDenunciar;
use App\Models\Questionario\TipoViolencia;
use App\Models\Questionario\VinculoAgressor;
use App\Models\Questionario\ViolenciaSexual;
use PDF;

class RelatorioController extends Controller {
    
    private $dados = ['menu' => 'relatorio'];

    // ================================= QUESTIONARIO ======================================//

    /**
     * Lista os dados dos pacientes atendidos nos questionários
     */
    public function questionarios(Request $request) {
        $this->dados['questionarios'] = Questionario::paginate(10);
        return view('relatorio.questionarios', $this->dados);
    }

    /**
     * Marca se a vitima foi atendida ou não
     */
    public function atendido(Request $request, int $id, bool $atendido) {
        Questionario::where('id', $id)->update(['atendido' => $atendido]);
        return redirect()->route('relatorio.dados')->with('sucesso', 'Ocorrência atualizada com sucesso');
    }

    /** Remove um conteúdo
     * @param $duvidaID id do conteúdo
     */
    public function excluir(int $questionarioID) {
        Questionario::destroy($questionarioID);
        return redirect()->route('relatorio.dados')->with('sucesso', 'Ocorrência excluída com sucesso');
    }

    /**
     * Baixa em PDF os dados do questionário respondido
     */
    public function baixarQuestionario(Request $request, int $id) {
        $dados['dados'] = Questionario::findOrFail($id);
        $pdf = PDF::loadView('relatorio.pdf_questionario', $dados);
        //return $pdf->download('invoice.pdf');
        return $pdf->stream();
    }
    
    
    /**
     * Baixa em CSV todos os dados coletados
     */
    public function baixarTodos(Request $request) {
        $dados['questionarios'] = Questionario::all();
        
        $html = view('relatorio.xls', $dados);
        $arquivo = "ravvs_ocorrencias.xls";  
        // Configurações header para forçar o download  
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$arquivo.'"');
        header('Cache-Control: max-age=0');
        // Se for o IE9, isso talvez seja necessário
        header('Cache-Control: max-age=1');
        
        // Envia o conteúdo do arquivo  
        echo $html;  
    }

    // ============================================= ESTATISTICA ========================================= //
    /** 
    * Gera relatórios estatísticos
    */
    public function estatistica(Request $request) {

        //BUSCANDO
        $questionarioModel = Questionario::where('id', '>', '0');

        //Filtros
        if ($request->filtrar) {
            $dataInicio = $request->data_inicio;
            $dataFim = $request->data_fim;
            if ($dataInicio) $questionarioModel->where('dia_ocorrencia', '>=', $dataInicio);
            if ($dataFim) $questionarioModel->where('dia_ocorrencia', '<=', $dataFim);
        }
        $questionarios = $questionarioModel->get();

        //Organizando
        $this->dados= [
            'dataInicio'    => $dataInicio ?? '',
            'dataFim'       => $dataFim ?? '',
            'total' => count($questionarios),
            'drogasFamilia' => 0,
            'beneficios' => 0,
            'abusoAnterior' => 0,
            'gestantes' => 0,
            'analfabetos' => 0,
            'sofreTranstornos' => 0,
            'gestacao' => [
                'opcoes'  => ['"1º Trimestre"', '"2º Trimestre"', '"3º Trimestre"', '"Idade gestacional ignorada"'],
                1 => 0, 2 => 0, 3 => 0, 4 => 0,
            ],
            'escolaridade' => [
                'opcoes' => ['"Analfabeto"', '"1ª a 4ª série incompleta"', '"4ª série completa"', '"5ª a 8ª série incompleta"', '"Ensino Fundamental completo"', '"Ensino médio incompleto"', '"Ensino médio completo"', '"Educação superior incompleta"', '"Educação superior completa"', '"Ignorar"'],
                0 => 0, 1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0, 9 => 0
            ],
            'zonas' => [
                'opcoes'    => ['"Urbana"', '"Rural"', '"Periurbana"', '"Ignorar"'],
                1 => 0, 2 => 0, 3 => 0, 9 => 0
            ],
            'orientacaoSexual' => [
                'opcoes'    => ['"Heterossexual"', '"Homossexual (gay/lésbica)"', '"Bissexual"'],
                1 => 0, 2 => 0, 3 => 0
            ],
            'idadeVitima' => [
                'opcoes'   => ['"0-9"', '"10-19"', '"20-29"', '"30-39"', '"40-49"', '"50-59"', '"60-69"', '"70-79"', '"80-89"', '"90-99"'],
                0 => 0, 1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0, 9 => 0
            ],
            'idadeAgressor' => [
                'opcoes'   => ['"Criança (0 a 9 anos)"', '"Adolescente (10 a 19 anos)"', '"Jovem (20 a 24 anos)"', '"Pessoa Adulta (25 a 59 anos)"', '"Pessoa Idosa (60 anos ou mais)"'],
                1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0
            ],
            'motivoViolencia' => [
                'opcoes'   => [1 => '"Sexismo"', '"Homofobia/Lesbofobia/Bifobia/Transfobia"', '"Racismo"', '"Intolerância Religiosa"', '"Xenofobia"', '"Conflito geracional"', '"Situação de rua"', '"Deficiência"', '"Outro"', 88 => '"Não se aplica"', 99 => '"Ignorado"'],
                1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0, 9 => 0, 88 => 0, 99 => 0
            ],
        ];

        //Estrutura de Elementos com Multiplas Escolhas
        $meioViolencia = MeioViolencia::orderBy('id')->get();
        foreach ($meioViolencia as $mv) {
            $this->dados['meio_violencia']['opcoes'][$mv->id] = '"'.$mv->descricao.'"';
            $this->dados['meio_violencia'][$mv->id] = 0;
        }

        $locais = Local::orderBy('id')->get();
        foreach ($locais as $l) {
            $this->dados['local']['opcoes'][$l->id] = '"'.$l->descricao.'"';
            $this->dados['local'][$l->id] = 0;
        }

        $motivo = MotivoNaoDenunciar::orderBy('id')->get();
        foreach ($motivo as $m) {
            $this->dados['motivo_nao_denunciar']['opcoes'][$m->id] = '"'.$m->descricao.'"';
            $this->dados['motivo_nao_denunciar'][$m->id] = 0;
        }

        $tipo = TipoViolencia::orderBy('id')->get();
        foreach ($tipo as $t) {
            $this->dados['tipo_violencia']['opcoes'][$t->id] = '"'.$t->descricao.'"';
            $this->dados['tipo_violencia'][$t->id] = 0;
        }

        $vinculo = VinculoAgressor::orderBy('id')->get();
        foreach ($vinculo as $v) {
            $this->dados['vinculo_agressor']['opcoes'][$v->id] = '"'.$v->descricao.'"';
            $this->dados['vinculo_agressor'][$v->id] = 0;
        }
        
        $violencia = ViolenciaSexual::orderBy('id')->get();
        foreach ($violencia as $v) {
            $this->dados['violencia_sexual']['opcoes'][$v->id] = '"'.$v->descricao.'"';
            $this->dados['violencia_sexual'][$v->id] = 0;
        }

        foreach ($questionarios as $q) {
            if ($q->drogas_familia) $this->dados['drogasFamilia']++;
            if ($q->tem_beneficio) $this->dados['beneficios']++;
            if ($q->abuso_anterior) $this->dados['abusoAnterior']++;
            if (!in_array($q->gestante['id'], [5, 6, 9])) {
                $this->dados['gestantes']++;
                $this->dados['gestacao'][$q->gestante['id']]++;  
            } 
            if ($q->escolaridade['id'] == 0) $this->dados['analfabetos']++;
            $this->dados['escolaridade'][$q->escolaridade['id']]++;
            if ($q->tem_transtorno) $this->dados['sofreTranstornos']++;
            $this->dados['zonas'][$q->zona['id']]++;
            if ($q->orientacao_sexual['descricao'] != 'Ignorado') $this->dados['orientacaoSexual'][$q->orientacao_sexual['id']]++;
            
            if ($q->data_nascimento != '1970-01-01' && $q->dia_ocorrencia != '1970-01-01') {
                $anos = (new \DateTime($q->dia_ocorrencia))->diff(new \DateTime($q->data_nascimento))->y;
                $this->dados['idadeVitima'][floor($anos/10)]++;
            }
            
            foreach ($q->meio_violencia as $mv)  
            $this->dados['meio_violencia'][$mv->id]++;
            
            foreach ($q->local as $l) {
                $this->dados['local'][$l->id]++;
            }
            
            foreach ($q->motivo_nao_denunciar as $m)  
            $this->dados['motivo_nao_denunciar'][$m->id]++;
            
            foreach ($q->tipo_violencia as $t)  
            $this->dados['tipo_violencia'][$t->id]++;
            
            foreach ($q->vinculo_agressor as $v)  
            $this->dados['vinculo_agressor'][$v->id]++;
            
            foreach ($q->violencia_sexual as $v)  
            $this->dados['violencia_sexual'][$v->id]++;
            
            if (!in_array($q->idade_agressor['id'], [9])) {
                $this->dados['idadeAgressor']++;
                $this->dados['idadeAgressor'][$q->idade_agressor['id']]++;  
            } 
            
            if (!in_array($q->motivo_violencia['id'], [9])) {
                $this->dados['motivoViolencia']++;
                $this->dados['motivoViolencia'][$q->motivo_violencia['id']]++;  
            } 
        }
        return view('relatorio.estatistica', $this->dados);


    }
}
