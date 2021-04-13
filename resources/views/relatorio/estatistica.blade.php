@extends('template')

@section('titulo', 'Relatório Estatística')

@section('conteudo')
<div class="user-data m-b-30">
        <h3 class="title-3 m-b-30">
            <i class="zmdi zmdi-account-calendar"></i>Estatísticas
        </h3>

        <div id="filtros">
            <form>
                <input type="hidden" value="1" name="filtrar"/>
                <h4>Filtrar ocorrências</h4>
                <p>Intervalo da ocorrência:</p>
                <div class="form-group">
                    <div class="row">
                        <div class="col-4">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i> Data inicial
                                </div>
                                <input type="date" name="data_inicio" value="{{$dataInicio}}" placeholder="período inicial da busca" class="form-control">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i> Data Final
                                </div>
                                <input type="date" name="data_fim" value="{{$dataFim}}" placeholder="período final da busca" class="form-control">
                            </div>
                        </div>
                        
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fa fa-search"></i> Buscar
                    </button>
                </div>
            </form>
        </div>

        <!-- DADOS DA VITIMA -->
        <h2 class="secoes">Dados das Vítimas</h2>
        <div class="graficos-principais">
            <canvas id="gDadosVitimas"></canvas>
        </div>
        <hr/>

        <div class="graficos-menores">
            <div><canvas id="gGestantes"></canvas></div>
            <div><canvas id="gEscolaridade"></canvas></div>
            <div><canvas id="gZonas"></canvas></div>
            <div><canvas id="gOrientacaoSexual"></canvas></div>
            <div><canvas id="gIdade"></canvas></div>
        </div>
        <hr/>

        <!-- DADOS DA OCORRÊNCIA -->
        <h2 class="secoes">Dados da ocorrência</h2>
        <div class="graficos-principais">
            <canvas id="gMeioViolencia"></canvas>
        </div>
        <hr/>

        <div class="graficos-menores">
            <div><canvas id="gLocal"></canvas></div>
            <div><canvas id="gMotivoNaoDenunciar"></canvas></div>

            <div><canvas id="gTipoViolencia"></canvas></div>
            <div><canvas id="gVinculoAgressor"></canvas></div>

            <div><canvas id="gViolenciaSexual"></canvas></div>
            <div><canvas id="gIdadeAgressor"></canvas></div>
        </div>

        <div class="graficos-principais">
            <canvas id="gMotivoViolencia"></canvas>
        </div>
        <hr/>
    </div>

@push('css')
<style>
    .filtro-in-line { flex:1; display:flex; flex-direction: row;}
    #filtros {padding: 10px;}
    .secoes { text-align: center }
    .graficos-principais { display: flex; flex: 1; padding: 10px 5%; }
    .graficos-menores { display: flex; padding: 20px; flex-wrap: wrap; justify-content: space-around;}
    .graficos-menores div { width: 50%; margin-bottom: 50px; }
</style>
@endpush

@push('javascript')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script>
        var gDadosVitimas = document.getElementById('gDadosVitimas').getContext('2d');
        var chart = new Chart(gDadosVitimas, {
            // The type of chart we want to create
            type: 'bar',

            // The data for our dataset
            data: {
                labels: ['{{$total}} Entrevistados'],
                datasets: [
                    { 
                        label: 'Na família há usuários de drogas',
                        backgroundColor: 'rgba(30, 144, 255, 0.7)',
                        data: [{{$drogasFamilia}}],
                    },
                    { 
                        label: 'Participa de benefício do governo',
                        backgroundColor: 'rgba(222, 184, 135, 0.7)',
                        data: [{{$beneficios}}],
                    },
                    { 
                        label: 'Sofreu abuso anterior',
                        backgroundColor: 'rgba(0, 255, 127, 0.7)',
                        data: [{{$abusoAnterior}}],
                        },
                    { 
                        label: 'Estava gestante',
                        backgroundColor: 'rgba(119, 136, 153, 0.7)',
                        data: [{{$gestantes}}]
                    },
                    { 
                        label: 'Analfabeto',
                        backgroundColor: 'rgba(160, 32, 240, 0.7)',
                        data: [{{$analfabetos}}]
                    },
                    { 
                        label: 'Sofre de transtorno',
                        backgroundColor: 'rgba(255, 255, 0, 0.7)',
                        data: [{{$sofreTranstornos}}]
                    },
                ]
            },
            options: { title: { display: true, text: 'Informações Gerais'}, scales: { yAxes: [{ ticks: { beginAtZero: true } }] }}
        });

        var gGestantes = document.getElementById('gGestantes').getContext('2d');
        var chart = new Chart(gGestantes, {
            // The type of chart we want to create
            type: 'pie',

            // The data for our dataset
            data: {
                labels: [{!!join(',', $gestacao['opcoes'])!!}],
                datasets: [
                    { 
                        backgroundColor: ['rgba(30, 144, 255, 0.7)', 'rgba(222, 184, 135, 0.7)', 'rgba(0, 255, 127, 0.7)', 'rgba(119, 136, 153, 0.7)', 'rgba(160, 32, 240, 0.7)', 'rgba(255, 255, 0, 0.7)'],
                        data: [{{$gestacao[1]}}, {{$gestacao[2]}}, {{$gestacao[3]}}, {{$gestacao[4]}}],
                    }
                ]
            },
            options: { title: { display: true, text: 'Período de Gestão das vítimas'}, scales: { display:false } }
        });

        var gEscolaridade = document.getElementById('gEscolaridade').getContext('2d');
        var chart = new Chart(gEscolaridade, {
            // The type of chart we want to create
            type: 'pie',

            // The data for our dataset
            data: {
                labels: [{!!join(',', $escolaridade['opcoes'])!!}],
                datasets: [
                    { 
                        backgroundColor: ['rgba(30, 144, 255, 0.7)', 'rgba(222, 184, 135, 0.7)', 'rgba(0, 255, 127, 0.7)', 'rgba(119, 136, 153, 0.7)', 'rgba(160, 32, 240, 0.7)', 'rgba(255, 255, 0, 0.7)', 'rgba(139, 58, 58, 0.7)', 'rgba(238, 0, 0, 0.7)', 'rgba(255, 193, 37, 0.7)'],
                        data: [{{$escolaridade[0]}}, {{$escolaridade[1]}}, {{$escolaridade[2]}}, {{$escolaridade[3]}}, {{$escolaridade[4]}}, {{$escolaridade[5]}}, {{$escolaridade[6]}}, {{$escolaridade[7]}}, {{$escolaridade[8]}}],
                    }
                ]
            },
            options: { title: { display: true, text: 'Escolaridade das vítimas'},scales: { display:false }}
        });

        var gZonas = document.getElementById('gZonas').getContext('2d');
        var chart = new Chart(gZonas, {
            // The type of chart we want to create
            type: 'pie',

            // The data for our dataset
            data: {
                labels: [{!!join(',', $zonas['opcoes'])!!}],
                datasets: [
                    { 
                        backgroundColor: ['rgba(30, 144, 255, 0.7)', 'rgba(222, 184, 135, 0.7)', 'rgba(0, 255, 127, 0.7)', 'rgba(119, 136, 153, 0.7)', 'rgba(160, 32, 240, 0.7)', 'rgba(255, 255, 0, 0.7)', 'rgba(139, 58, 58, 0.7)', 'rgba(238, 0, 0, 0.7)', 'rgba(255, 193, 37, 0.7)'],
                        data: [{{$zonas[1]}}, {{$zonas[2]}}, {{$zonas[3]}}],
                    }
                ]
            },
            options: { title: { display: true, text: 'Zona onde ocorreu o acidente'},scales: { display:false }}
        });

        var gOrientacaoSexual = document.getElementById('gOrientacaoSexual').getContext('2d');
        var chart = new Chart(gOrientacaoSexual, {
            // The type of chart we want to create
            type: 'pie',

            // The data for our dataset
            data: {
                labels: [{!!join(',', $orientacaoSexual['opcoes'])!!}],
                datasets: [
                    { 
                        backgroundColor: ['rgba(30, 144, 255, 0.7)', 'rgba(222, 184, 135, 0.7)', 'rgba(0, 255, 127, 0.7)', 'rgba(119, 136, 153, 0.7)', 'rgba(160, 32, 240, 0.7)', 'rgba(255, 255, 0, 0.7)', 'rgba(139, 58, 58, 0.7)', 'rgba(238, 0, 0, 0.7)', 'rgba(255, 193, 37, 0.7)'],
                        data: [{{$orientacaoSexual[1]}}, {{$orientacaoSexual[2]}}, {{$orientacaoSexual[3]}}],
                    }
                ]
            },
            options: { title: { display: true, text: 'Orientação Sexual da Vítima'},scales: { display:false }}
        });

        var gIdade = document.getElementById('gIdade').getContext('2d');
        var chart = new Chart(gIdade, {
            // The type of chart we want to create
            type: 'pie',

            // The data for our dataset
            data: {
                labels: [{!!join(',', $idadeVitima['opcoes'])!!}],
                datasets: [
                    { 
                        backgroundColor: ['rgba(30, 144, 255, 0.7)', 'rgba(222, 184, 135, 0.7)', 'rgba(0, 255, 127, 0.7)', 'rgba(119, 136, 153, 0.7)', 'rgba(160, 32, 240, 0.7)', 'rgba(255, 255, 0, 0.7)', 'rgba(139, 58, 58, 0.7)', 'rgba(238, 0, 0, 0.7)', 'rgba(255, 193, 37, 0.7)'],
                        data: [{{$idadeVitima[0]}}, {{$idadeVitima[1]}}, {{$idadeVitima[2]}}, {{$idadeVitima[3]}}, {{$idadeVitima[4]}}, {{$idadeVitima[5]}}, {{$idadeVitima[6]}}, {{$idadeVitima[7]}}, {{$idadeVitima[8]}}, {{$idadeVitima[9]}}],
                    }
                ]
            },
            options: { title: { display: true, text: 'Idade da Vítima'},scales: { display:false }}
        });

        var gMeioViolencia = document.getElementById('gMeioViolencia').getContext('2d');
        var chart = new Chart(gMeioViolencia, {
            // The type of chart we want to create
            type: 'bar',

            // The data for our dataset
            data: {
                labels: ['{{$total}} Entrevistados'],
                datasets: [
                    @foreach($meio_violencia['opcoes'] as $id => $mv)
                    { 
                        label: {!!$mv!!},
                        backgroundColor: 'rgba({{rand(10, 255)}}, {{rand(10, 255)}}, {{rand(10, 255)}}, 0.7)',
                        data: [{{$meio_violencia[$id]}}],
                    },
                    @endforeach
                ]
            },
            options: { title: { display: true, text: 'Meios de Violência'}, scales: { yAxes: [{ ticks: { beginAtZero: true } }] }}
        });

        var gLocal = document.getElementById('gLocal').getContext('2d');
        var chart = new Chart(gLocal, {
            // The type of chart we want to create
            type: 'pie',

            // The data for our dataset
            data: {
                labels: [{!!join(',', $local['opcoes'])!!}],
                datasets: [
                    { 
                        backgroundColor: ['rgba(30, 144, 255, 0.7)', 'rgba(222, 184, 135, 0.7)', 'rgba(0, 255, 127, 0.7)', 'rgba(119, 136, 153, 0.7)', 'rgba(160, 32, 240, 0.7)', 'rgba(255, 255, 0, 0.7)', 'rgba(139, 58, 58, 0.7)', 'rgba(238, 0, 0, 0.7)', 'rgba(255, 193, 37, 0.7)'],
                        data: [{{join(',', array_slice($local, 1))}}],
                    }
                ]
            },
            options: { title: { display: true, text: 'Local do ocorrido'},scales: { display:false }}
        });

        var gMotivoNaoDenunciar = document.getElementById('gMotivoNaoDenunciar').getContext('2d');
        var chart = new Chart(gMotivoNaoDenunciar, {
            // The type of chart we want to create
            type: 'pie',

            // The data for our dataset
            data: {
                labels: [{!!join(',', $motivo_nao_denunciar['opcoes'])!!}],
                datasets: [
                    { 
                        backgroundColor: ['rgba(30, 144, 255, 0.7)', 'rgba(222, 184, 135, 0.7)', 'rgba(0, 255, 127, 0.7)', 'rgba(119, 136, 153, 0.7)', 'rgba(160, 32, 240, 0.7)', 'rgba(255, 255, 0, 0.7)', 'rgba(139, 58, 58, 0.7)', 'rgba(238, 0, 0, 0.7)', 'rgba(255, 193, 37, 0.7)'],
                        data: [{{join(',', array_slice($motivo_nao_denunciar, 1))}}],
                    }
                ]
            },
            options: { title: { display: true, text: 'Motivo por não denunciar antes'},scales: { display:false }}
        });

        var gTipoViolencia = document.getElementById('gTipoViolencia').getContext('2d');
        var chart = new Chart(gTipoViolencia, {
            // The type of chart we want to create
            type: 'pie',

            // The data for our dataset
            data: {
                labels: [{!!join(',', $tipo_violencia['opcoes'])!!}],
                datasets: [
                    { 
                        backgroundColor: ['rgba(30, 144, 255, 0.7)', 'rgba(222, 184, 135, 0.7)', 'rgba(0, 255, 127, 0.7)', 'rgba(119, 136, 153, 0.7)', 'rgba(160, 32, 240, 0.7)', 'rgba(255, 255, 0, 0.7)', 'rgba(139, 58, 58, 0.7)', 'rgba(238, 0, 0, 0.7)', 'rgba(255, 193, 37, 0.7)'],
                        data: [{{join(',', array_slice($tipo_violencia, 1))}}],
                    }
                ]
            },
            options: { title: { display: true, text: 'Tipo de Violência'},scales: { display:false }}
        });

        var gVinculoAgressor = document.getElementById('gVinculoAgressor').getContext('2d');
        var chart = new Chart(gVinculoAgressor, {
            // The type of chart we want to create
            type: 'pie',

            // The data for our dataset
            data: {
                labels: [{!!join(',', $vinculo_agressor['opcoes'])!!}],
                datasets: [
                    { 
                        backgroundColor: ['rgba(30, 144, 255, 0.7)', 'rgba(222, 184, 135, 0.7)', 'rgba(0, 255, 127, 0.7)', 'rgba(119, 136, 153, 0.7)', 'rgba(160, 32, 240, 0.7)', 'rgba(255, 255, 0, 0.7)', 'rgba(139, 58, 58, 0.7)', 'rgba(238, 0, 0, 0.7)', 'rgba(255, 193, 37, 0.7)'],
                        data: [{{join(',', array_slice($vinculo_agressor, 1))}}],
                    }
                ]
            },
            options: { title: { display: true, text: 'Qual o vinculo com o agressor'},scales: { display:false }}
        });

        var gViolenciaSexual = document.getElementById('gViolenciaSexual').getContext('2d');
        var chart = new Chart(gViolenciaSexual, {
            // The type of chart we want to create
            type: 'pie',

            // The data for our dataset
            data: {
                labels: [{!!join(',', $violencia_sexual['opcoes'])!!}],
                datasets: [
                    { 
                        backgroundColor: ['rgba(30, 144, 255, 0.7)', 'rgba(222, 184, 135, 0.7)', 'rgba(0, 255, 127, 0.7)', 'rgba(119, 136, 153, 0.7)', 'rgba(160, 32, 240, 0.7)', 'rgba(255, 255, 0, 0.7)', 'rgba(139, 58, 58, 0.7)', 'rgba(238, 0, 0, 0.7)', 'rgba(255, 193, 37, 0.7)'],
                        data: [{{join(',', array_slice($violencia_sexual, 1))}}],
                    }
                ]
            },
            options: { title: { display: true, text: 'Tipo de violência sexual'},scales: { display:false }}
        });

        var gIdadeAgressor = document.getElementById('gIdadeAgressor').getContext('2d');
        var chart = new Chart(gIdadeAgressor, {
            // The type of chart we want to create
            type: 'pie',

            // The data for our dataset
            data: {
                labels: [{!!join(',', $idadeAgressor['opcoes'])!!}],
                datasets: [
                    { 
                        backgroundColor: ['rgba(30, 144, 255, 0.7)', 'rgba(222, 184, 135, 0.7)', 'rgba(0, 255, 127, 0.7)', 'rgba(119, 136, 153, 0.7)', 'rgba(160, 32, 240, 0.7)', 'rgba(255, 255, 0, 0.7)', 'rgba(139, 58, 58, 0.7)', 'rgba(238, 0, 0, 0.7)', 'rgba(255, 193, 37, 0.7)'],
                        data: [{{join(',', array_slice($idadeAgressor, 1))}}],
                    }
                ]
            },
            options: { title: { display: true, text: 'Idade do possível agressor'},scales: { display:false }}
        });

        var gMotivoViolencia = document.getElementById('gMotivoViolencia').getContext('2d');
        var chart = new Chart(gMotivoViolencia, {
            // The type of chart we want to create
            type: 'bar',

            // The data for our dataset
            data: {
                labels: ['{{$total}} Entrevistados'],
                datasets: [
                    @foreach($motivoViolencia['opcoes'] as $id => $mv)
                    { 
                        label: {!!$mv!!},
                        backgroundColor: 'rgba({{rand(10, 255)}}, {{rand(10, 255)}}, {{rand(10, 255)}}, 0.7)',
                        data: [{{$motivoViolencia[$id]}}],
                    },
                    @endforeach
                ]
            },
            options: { title: { display: true, text: 'Meios de Violência'}, scales: { yAxes: [{ ticks: { beginAtZero: true } }] }}
        });

    </script>
@endpush
@endsection