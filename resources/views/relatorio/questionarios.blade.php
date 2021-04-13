@extends('template')

@section('titulo', 'Relatório - Dados do ocorrido')

@section('conteudo')
<div class="user-data m-b-30">
        <h3 class="title-3 m-b-30">
            <i class="zmdi zmdi-account-calendar"></i>Dados das ocorrências
            <a target="_blank" href="{{route('relatorio.dados.todos')}}" class="btn btn-primary">
                <i class="fa fa-download"></i> Baixar todos em CSV
            </a>
        </h3>

        <div class="table-responsive table-data">
                
            

            @if(session('sucesso'))
                <div class="alert alert-success" role="alert" style="margin:0px 10px">
                    {{session('sucesso')}}
                </div>
            @endif
            <table class="table">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Vítima</td>
                        <td>Data da Ocorrência</td>
                        <td>Atendido</td>
                        <td>Opções</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($questionarios as $q)
                    <tr>
                        <!-- ID -->
                        <td><h6>{{$q->id}}</h6></td>
                        <!-- DENUNCIANTE -->
                        <td>
                            @if($q->anonimo)
                            <p>Anônimo</p>
                            @else
                            <p>{{$q->autor->nome}} ({{$q->autor->telefone}})</p>
                            @endif
                        </td>
                        <!-- VITIMA -->
                        <td><p>{{$q->nome}}</p></td>
                        <!-- Data da Ocorrência -->
                        <td><p>{{date('d/m/Y', strtotime($q->dia_ocorrencia))}}</p></td>
                        <!-- Atentico -->
                        <td>
                            @if ($q->atendido)
                            <p class="badge badge-success">SIM</p>
                            @else
                            <p class="badge badge-danger">NÃO</p>
                            @endif
                        </td>
                        <!-- OPÇÕES -->   
                        <td>
                            <!-- ATENDIDO -->
                            @if($q->atendido)
                            <a title="Marcar como não atendido" href="{{route('relatorio.dados.atendido', ['id' => $q->id, 'atendido' => 0])}}">
                                <span class="more"><i class="zmdi zmdi-crop-square"></i></span>
                            </a>
                            @else
                            <a title="Marcar como atendido" href="{{route('relatorio.dados.atendido', ['id' => $q->id, 'atendido' => 1])}}">
                                <span class="more"><i class="zmdi zmdi-check-square"></i></span>
                            </a>
                            @endif
                            <!-- BAIXAR -->
                            <a title="Baixar dados da ocorrência" target="_blank" href="{{route('relatorio.dados.ocorrencia', ['id' => $q->id])}}">
                                <span class="more"><i class="zmdi zmdi-download"></i></span>
                            </a>
                            <!-- EXCLUIR -->
                            <span class="more remover-modal" data-toggle="modal" data-target="#smallmodal" data-id="{{$q->id}}"><i class="zmdi zmdi-delete"></i></span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
           
            <!-- Paginação -->
            <div style="padding:10px">{{$questionarios->links()}}</div>
        </div>
      
    </div>


    @push('javascript')
  <!-- modal small -->
  <div class="modal fade" id="smallmodal" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="smallmodalLabel">Remover ocorrência</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                       Deseja Realmente excluir essa ocorrência?
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary btn-deletar">Confirmar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end modal small -->

    <script>
        let conteudoID;
        $('.remover-modal').click(function() {
            conteudoID = $(this).data('id');
        })

        $('.btn-deletar').click(() => window.location.href="{{route('relatorio.excluir')}}/"+conteudoID);
    </script>
@endpush
@endsection