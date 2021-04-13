<table border="1">
    <!-- CABECALHO -->
    <tr>
        <td>Atendido</td>
        <td>Denunciante</td>
        <td>Nome da vítima</td>
        <td>CPF da vítima</td>
        <td>Data de nascimento</td>
        <td>Gênero</td> 
        <td>Telefone</td>
        <td>Email</td> 
        <td>Há uso de drogas na família</td>
        <td>Quem usa drogas na família/td> 
        <td>Recebe benefício:</td>
        <td>Qual benefício?</td>
        <td>A denuncia foi formalizada</td>
        <td>Já havia sofrido de abuso antes</td>
        <td>Quem foi o abusador anterior</td>
        <td>Gestante:</td> 
        <td>Escolaridade:</td> 
        <td>Zona Residêncial:</td> 
        <td>Estado Cívil:</td> 
        <td>Orientação Sexual:</td> 
        <td>Identidade de Gênero:</td> 
        <td>Possui algum transtorno/deficiência</td>
        <td>Quais Transtornos</td>
        <!-- --------------------------- DADOS DA OCORRÊNCIA ----------------------- -->
        <td>Dia da ocorrência:</td> 
        <td>Hora da ocorrência:</td> 
        <td>Local da ocorrência:</td>
        <td>Ocorreu outras vezes: </td>
        <td>A lesão foi auto provocada: </td>
        <!-- --------------------------- VIOLÊNCIA ----------------------- -->
        <td>Essa violência foi motivada por?</td>
        <td>Tipo de violência:</td>
        <td>Meio de agressão:</td>
        <td>Em caso de violência sexual, o tipo foi:</td>
        <td>Violência relacionada ao trabalho:</td> 
        <!-- --------------------------- DADOS AGRESSOR ----------------------- -->
        <td>Número de envolvidos:</td>
        <td>Quem eram os agressores:</td>   
        <td>Sexo do provável agressor:</td>
        <td>Suspeita de álcool:</td>
        <td>Idade do provável agressor:</td>
        <!-- --------------------------- EXTRA ----------------------- -->
        <td>Observação:</td>
    </tr>

    @foreach ($questionarios as $dados)
    <tr>
        <!-- DADOS DA VITIMA -->
        <td>{{$dados->atendido ? 'SIM' : 'NÃO'}}</td>
        <td>{{$dados->anonimo ? 'Anônimo' : $dados->autor->nome}}</td>
        <td>{{$dados->nome}}</td>
        <td>{{$dados->cpf}}</td>
        <td>{{date('d/m/Y', strtotime($dados->data_nascimento))}}</td>
        <td>{{$dados->genero}}</td>
        <td>{{$dados->telefone}}</td>
        <td>{{$dados->email}}</td>
        <td>{{$dados->drogas_familia ? 'SIM' : 'NÃO'}}</td>
        <td>{{$dados->usuario_droga_familia}}</td>
        <td>{{$dados->tem_beneficio ? 'SIM' : 'NÃO'}}</td>
        <td>{{$dados->beneficio}}</td>
        <td>{{$dados->denunciado ? 'SIM' : 'NÃO'}}</td>
        <td>{{$dados->abuso_anterior ? 'SIM' : 'NÃO'}}</td>
        <td>{{$dados->abusador_anterior}}</td>
        <td>{{$dados->gestante['descricao']}} (Cod. {{$dados->gestante['id']}})</td>
        <td>{{$dados->escolaridade['descricao']}} (Cod. {{$dados->escolaridade['id']}})</td>
        <td>{{$dados->zona['descricao']}} (Cod. {{$dados->zona['id']}})</td>
        <td>{{$dados->estado_civil['descricao']}} (Cod. {{$dados->estado_civil['id']}})</td>
        <td>{{$dados->orientacao_sexual['descricao']}} (Cod. {{$dados->orientacao_sexual['id']}})</td>
        <td>{{$dados->identidade_genero['descricao']}} (Cod. {{$dados->identidade_genero['id']}})</td>
        <td>{{$dados->tem_transtorno ? 'SIM' : 'NÃO'}}</td>
        <td>
            @foreach($dados->transtornos as $transtorno)
            {{$transtorno->descricao}} (Cod. {{$transtorno->id}}) |
            @endforeach
        </td>
        <!-- --------------------------- DADOS DA OCORRÊNCIA ----------------------- -->
        <td>{{date('d/m/Y', strtotime($dados->dia_ocorrencia))}}</td>
        <td>{{date('H:i', strtotime($dados->hora_ocorrencia))}}</td>
        <td>
            @foreach($dados->local as $local)
            {{$local->descricao}} (Cod. {{$local->id}})
            @endforeach
        </td>
        <td>{{$dados->ocorreu_outras_vezes['descricao']}} (Cod. {{$dados->ocorreu_outras_vezes['id']}})</td>
        <td>{{$dados->lesao_autoprovocada['descricao']}} (Cod. {{$dados->lesao_autoprovocada['id']}})</td>
        <!-- --------------------------- VIOLÊNCIA ----------------------- -->
        <td>{{$dados->motivo_violencia['descricao']}} (Cod. {{$dados->motivo_violencia['id']}})</td>
        <td>
            @foreach($dados->tipo_violencia as $tv)
            {{$tv->descricao}} (Cod. {{$tv->id}})
            @endforeach
        </td>
        <td>
            @foreach($dados->meio_violencia as $mv)
            {{$mv->descricao}} (Cod. {{$mv->id}})
            @endforeach
        </td>
        <td>
            @foreach($dados->violencia_sexual as $vs)
            {{$vs->descricao}} (Cod. {{$vs->id}})
            @endforeach
        </td>
        <td>{{$dados->violencia_trabalho['descricao']}} (Cod. {{$dados->violencia_trabalho['id']}})</td>
        <!-- --------------------------- VIOLÊNCIA ----------------------- -->
        <td>{{$dados->numero_envolvidos['descricao']}} (Cod. {{$dados->numero_envolvidos['id']}})</td>
        <td>
            @foreach($dados->vinculo_agressor as $va)
            {{$va->descricao}} (Cod. {{$va->id}})
            @endforeach
        </td>
        <td>{{$dados->sexo_agressor['descricao']}} (Cod. {{$dados->sexo_agressor['id']}})</td>
        <td>{{$dados->uso_alcool['descricao']}} (Cod. {{$dados->uso_alcool['id']}})</td>
        <td>{{$dados->idade_agressor['descricao']}} (Cod. {{$dados->idade_agressor['id']}})</td>
        <!-- --------------------------- EXTRA ----------------------- -->
        <td>{{$dados->observacao}}</td>
    </tr>
    @endforeach
</table>