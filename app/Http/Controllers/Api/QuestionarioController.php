<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Questionario;
use App\Models\Questionario\Local;
use App\Models\Questionario\MeioViolencia;
use App\Models\Questionario\MotivoNaoDenunciar;
use App\Models\Questionario\TipoViolencia;
use App\Models\Questionario\Transtorno;
use App\Models\Questionario\VinculoAgressor;
use App\Models\Questionario\ViolenciaSexual;
use App\Rules\Cpf;

/**
 * Controller das requisições a API da aba Fui Violentada
 * @author Carlos W. Gama
 * @api
 */
class QuestionarioController extends ApiController {
    
    public function cadastrar(Request $request) {
        $usuarioID = $this->getUsuarioID($request);
        $validation = Validator::make($request->all(), [
            //Dados da Vitima
            'genero'                => 'required',
            'raca'                  => 'required',
            'cpf'                   => ['nullable', new Cpf],

            'drogas_familia'        => 'required|boolean',
            'tem_beneficio'         => 'required|boolean',
            'denunciado'            => 'required|boolean',
            'abuso_anterior'        => 'required|boolean',
            'gestante'              => 'required|integer',
            'escolaridade'          => 'required|integer',
            'zona'                  => 'required|integer',
            'estado_civil'          => 'required|integer',
            'orientacao_sexual'     => 'required|integer',
            'identidade_genero'     => 'required|integer',
            'tem_transtorno'        => 'required|boolean',
            //Dados da ocorrência
            'local'                 => 'required',
            'ocorreu_outras_vezes'  => 'required|integer',
            'lesao_autoprovocada'   => 'required|integer',
            //Violencia
            'motivo_violencia'      => 'required|integer',
            //Autor da violência
            'numero_envolvidos'     => 'required|integer',
            'sexo_agressor'         => 'required|integer',
            'uso_alcool'            => 'required|integer',
            'idade_agressor'        => 'required|integer'
        ]);

        if ($validation->fails()) return response()->json($validation->errors(), 400);

        $questionario = $request->except(['local', 'meio_violencia', 'motivo_nao_denunciar', 'tipo_violencia', 'transtornos', 'vinculo_agressor', 'violencia_sexual']);
        $questionario['autor_id'] = $usuarioID; 
        $questionario['data_nascimento'] = date('Y-m-d', strtotime($questionario['data_nascimento']));
        $questionario['dia_ocorrencia'] = date('Y-m-d', strtotime($questionario['dia_ocorrencia']));
        $questionario['hora_ocorrencia'] = date('H:i:00', strtotime($questionario['hora_ocorrencia']));

        //Cria o questionário
        $questionario = Questionario::create($questionario);
        
        //Adiciona os vinculados
        foreach ((array)$request->local as $conteudoID) {
            $dado = Local::find($conteudoID);
            $questionario->local()->attach($dado);
        }
        //Adiciona os vinculados
        foreach ((array)$request->meio_violencia as $conteudoID) {
            $dado = MeioViolencia::find($conteudoID);
            $questionario->meio_violencia()->attach($dado);
        }
        //Adiciona os vinculados
        foreach ((array)$request->motivo_nao_denunciar as $conteudoID) {
            $dado = MotivoNaoDenunciar::find($conteudoID);
            $questionario->motivo_nao_denunciar()->attach($dado);
        }
        //Adiciona os vinculados
        foreach ((array)$request->tipo_violencia as $conteudoID) {
            $dado = TipoViolencia::find($conteudoID);
            $questionario->tipo_violencia()->attach($dado);
        }
        //Adiciona os vinculados
        foreach ((array)$request->transtornos as $conteudoID) {
            $dado = Transtorno::find($conteudoID);
            $questionario->transtornos()->attach($dado);
        }
        //Adiciona os vinculados
        foreach ((array)$request->vinculo_agressor as $conteudoID) {
            $dado = VinculoAgressor::find($conteudoID);
            $questionario->vinculo_agressor()->attach($dado);
        }
        //Adiciona os vinculados
        foreach ((array)$request->violencia_sexual as $conteudoID) {
            $dado = ViolenciaSexual::find($conteudoID);
            $questionario->violencia_sexual()->attach($dado);
        }

        $questionario->save();
        
        return response()->json(['sucesso' => true], 200);
    }
}
