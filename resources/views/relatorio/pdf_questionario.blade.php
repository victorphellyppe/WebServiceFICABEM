<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ocorrência - Cod. {{$dados->id}}</title>
    <style>
        .secao {
            text-align: center;
            font-size: 20px
        }
        .principal {
            text-align: center;
            text-transform: uppercase;
        }
    </style>
</head>
<body>

    <h1 class="principal">Relatório da Ocorrência (Cod. {{$dados->id}})</h1>
    
    <h2 class="secao">Denunciante</h2>
    @if($dados->anonimo)
    <p><b>Anônimo</b></p>
    @else
    <p><b>Denunciante:</b> {{$dados->denunciante}}</p>
    <p><b>Nome:</b> {{$dados->autor->nome}}</p>
    <p><b>Telefone:</b> {{$dados->autor->telefone}}</p>
    <p><b>E-mail:</b> {{$dados->autor->email}}</p>
    @endif

    <!-- DADOS DA VITIMA -->
    <h2 class="secao">Dados da Vítima</h2>
    <p><b>Atendido:</b> {{$dados->atendido ? 'SIM' : 'NÃO'}}</p>
    <p><b>Nome da vítima:</b> {{$dados->nome}}</p>
    <p><b>CPF da vítima:</b> {{$dados->cpf}}</p>
    <p><b>Data de nascimento:</b> {{date('d/m/Y', strtotime($dados->data_nascimento))}}</p>
    <p><b>Gênero:</b> {{$dados->genero}}</p>
    <p><b>Telefone:</b> {{$dados->telefone}}</p>
    
    <p><b>Há uso de drogas na família:</b> {{$dados->drogas_familia ? 'SIM' : 'NÃO'}}</p>
    @if($dados->drogas_familia)
    <p><b>Por quem:</b> {{$dados->usuario_droga_familia}}</p>
    @endif

    <p><b>Recebe benefício:</b> {{$dados->tem_beneficio ? 'SIM' : 'NÃO'}}</p>
    @if($dados->tem_beneficio)
    <p><b>Por quem:</b> {{$dados->beneficio}}</p>
    @endif
    
    <p><b>A denuncia foi formalizada?</b> {{$dados->denunciado ? 'SIM' : 'NÃO'}}</p>
    <p><b>Já havia sofrido de abuso antes?</b> {{$dados->abuso_anterior ? 'SIM' : 'NÃO'}}</p>
    @if($dados->abuso_anterior)
    <p><b>Por quem:</b> {{$dados->abusador_anterior}}</p>
    @endif
    
    <p><b>Gestante:</b> {{$dados->gestante['descricao']}} (Cod. {{$dados->gestante['id']}})</p>
    <p><b>Escolaridade:</b> {{$dados->escolaridade['descricao']}} (Cod. {{$dados->escolaridade['id']}})</p>
    <p><b>Zona Residêncial:</b> {{$dados->zona['descricao']}} (Cod. {{$dados->zona['id']}})</p>
    <p><b>Estado Cívil:</b> {{$dados->estado_civil['descricao']}} (Cod. {{$dados->estado_civil['id']}})</p>
    <p><b>Orientação Sexual:</b> {{$dados->orientacao_sexual['descricao']}} (Cod. {{$dados->orientacao_sexual['id']}})</p>
    <p><b>Identidade de Gênero:</b> {{$dados->identidade_genero['descricao']}} (Cod. {{$dados->identidade_genero['id']}})</p>
    
    <p><b>Possui algum transtorno/deficiência?</b> {{$dados->tem_transtorno ? 'SIM' : 'NÃO'}}</p>
    @if($dados->tem_transtorno)
    {{-- <p><b>Transtornos:</b></p> --}}
    <ul>
        @foreach($dados->transtornos as $transtorno)
        <li>{{$transtorno->descricao}} (Cod. {{$transtorno->id}})</li>
        @endforeach
    </ul>
    @endif
    
    <!-- --------------------------- DADOS DA OCORRÊNCIA ----------------------- -->
    <h2 class="secao">Dados da ocorrência</h2>
    <p><b>Dia da ocorrência:</b> {{date('d/m/Y', strtotime($dados->dia_ocorrencia))}}</p>
    <p><b>Hora da ocorrência:</b> {{date('H:i', strtotime($dados->hora_ocorrencia))}}</p>

     <p><b>Local da ocorrência:</b></p>
     <ul>
        @foreach($dados->local as $local)
        <li>{{$local->descricao}} (Cod. {{$local->id}})</li>
        @endforeach
    </ul>

    <p><b>Ocorreu outras vezes: </b> {{$dados->ocorreu_outras_vezes['descricao']}} (Cod. {{$dados->ocorreu_outras_vezes['id']}})</p>
    <p><b>A lesão foi auto provocada: </b> {{$dados->lesao_autoprovocada['descricao']}} (Cod. {{$dados->lesao_autoprovocada['id']}})</p>
    
    <!-- --------------------------- VIOLÊNCIA ----------------------- -->
    <h2 class="secao">Violência</h2>
    <p><b>Essa violência foi motivada por?</b> {{$dados->motivo_violencia['descricao']}} (Cod. {{$dados->motivo_violencia['id']}})</p>
    
    <p><b>Tipo de violência:</b></p>
     <ul>
        @foreach($dados->tipo_violencia as $tv)
        <li>{{$tv->descricao}} (Cod. {{$tv->id}})</li>
        @endforeach
    </ul>
    
    <p><b>Meio de agressão:</b></p>
     <ul>
        @foreach($dados->meio_violencia as $mv)
        <li>{{$mv->descricao}} (Cod. {{$mv->id}})</li>
        @endforeach
    </ul>
    
    @if(count($dados->violencia_sexual) > 0)
    <p><b>Em caso de violência sexual, o tipo foi:</b></p>
     <ul>
        @foreach($dados->violencia_sexual as $vs)
        <li>{{$vs->descricao}} (Cod. {{$vs->id}})</li>
        @endforeach
    </ul>
    @endif

    <p><b>Violência relacionada ao trabalho:</b> {{$dados->violencia_trabalho['descricao']}} (Cod. {{$dados->violencia_trabalho['id']}})</p>
    
    <!-- --------------------------- DADOS AGRESSOR ----------------------- -->
    <h2 class="secao">Dados do provável autor da violência</h2>
    <p><b>Número de envolvidos:</b> {{$dados->numero_envolvidos['descricao']}} (Cod. {{$dados->numero_envolvidos['id']}})</p>

    <p><b>Quem eram os agressores:</b></p>
     <ul>
        @foreach($dados->vinculo_agressor as $va)
        <li>{{$va->descricao}} (Cod. {{$va->id}})</li>
        @endforeach
    </ul>

    <p><b>Sexo do provável agressor:</b> {{$dados->sexo_agressor['descricao']}} (Cod. {{$dados->sexo_agressor['id']}})</p>
    <p><b>Suspeita de álcool:</b> {{$dados->uso_alcool['descricao']}} (Cod. {{$dados->uso_alcool['id']}})</p>
    <p><b>Idade do provável agressor:</b> {{$dados->idade_agressor['descricao']}} (Cod. {{$dados->idade_agressor['id']}})</p>

    <!-- --------------------------- EXTRA ----------------------- -->
    <h2 class="secao">Extra</h2>
    <p><b>Observação:</b></p>
    <p>{{$dados->observacao}}</p>



</body>
</html>