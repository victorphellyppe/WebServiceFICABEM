@extends('template')

@section('titulo', 'Grupos de Apoio')

@section('conteudo')
<div class="user-data m-b-30">
        <h3 class="title-3 m-b-30">
            <i class="zmdi zmdi-account-calendar"></i>Grupos de Apoio Cadastrados
            <a href="{{route('grupos.novo')}}" class="btn btn-primary">
                <i class="fa fa-dot-circle-o"></i> Cadastrar novo grupo
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
                        <td>Grupo</td>
                        <td>Endereço</td>
                        <td>Opções</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($grupos as $grupo)
                    <tr>
                        <!-- POSICAO -->
                        <td><h6>{{$grupo->id}}</h6></td>
                        <!-- DESCRICAO -->
                        <td>
                            <div class="table-data__info">
                                <h6>{{$grupo->nome}}</h6>
                            </div>
                        </td>
                        <!-- ENDEREÇO -->
                        <td>
                            <div class="table-data__info">
                                <h6>{{$grupo->endereco}}</h6>
                            </div>
                        </td>
                        <!-- OPÇÕES -->   
                        <td>
                            <a href="{{route('grupos.edicao', ['id' => $grupo->id])}}">
                                <span class="more"><i class="zmdi zmdi-edit"></i></span>
                            </a>
                            <span class="more remover-modal" data-toggle="modal" data-target="#smallmodal" data-id="{{$grupo->id}}"><i class="zmdi zmdi-delete"></i></span>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Paginação -->
            <div style="padding:10px">{{$grupos->links()}}</div>
            
        </div>
      
    </div>


    @push('javascript')
  <!-- modal small -->
  <div class="modal fade" id="smallmodal" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="smallmodalLabel">Remover grupo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                       Deseja Realmente excluir esse grupo?
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

        $('.btn-deletar').click(() => window.location.href="{{route('grupos.excluir')}}/"+conteudoID);
    </script>
@endpush
@endsection