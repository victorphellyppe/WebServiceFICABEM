@extends('template')

@section('titulo', 'Quem somos')

@section('conteudo')
<div class="user-data m-b-30">
        <h3 class="title-3 m-b-30">
            <i class="zmdi zmdi-account-calendar"></i>Abas Cadastrados
            <a href="{{route('quem-somos.nova')}}" class="btn btn-primary">
                <i class="fa fa-dot-circle-o"></i> Cadastrar nova aba
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
                        <td>Posição</td>
                        <td>Descrição</td>
                        <td>Opções</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($abas as $aba)
                    <tr>
                        <!-- POSICAO -->
                        <td><h6>{{$aba->posicao}}</h6></td>
                        <!-- DESCRICAO -->
                        <td>
                            <div class="table-data__info">
                                <h6>{{mb_strimwidth($aba->descricao, 0, 100, "...")}}</h6>
                            </div>
                        </td>
                        <!-- OPÇÕES -->   
                        <td>
                            <a href="{{route('quem-somos.edicao', ['id' => $aba->id])}}">
                                <span class="more"><i class="zmdi zmdi-edit"></i></span>
                            </a>
                            <span class="more remover-modal" data-toggle="modal" data-target="#smallmodal" data-id="{{$aba->id}}"><i class="zmdi zmdi-delete"></i></span>

                            <span class="more up" data-id="{{$aba->id}}"><i class="zmdi zmdi-format-valign-top"></i></span>
                            <span class="more down" data-id="{{$aba->id}}"><i class="zmdi zmdi-format-valign-bottom"></i></span>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>
      
    </div>


    @push('javascript')
  <!-- modal small -->
  <div class="modal fade" id="smallmodal" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="smallmodalLabel">Remover aba</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                       Deseja Realmente excluir essa aba?
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
        let abaID;
        $('.remover-modal').click(function() {
            abaID = $(this).data('id');
        })

        $('.btn-deletar').click(() => window.location.href="{{route('quem-somos.excluir')}}/"+abaID);
    </script>

    <script>
        $(document).ready(function () {
            $(".up, .down").click(function () {
                var $element = this;
                console.log($(this).data('id'))

                $.post('{{route('quem-somos.posicao')}}', {id:$(this).data('id'), sobe:$(this).is('.up')}, (dados) => {
                    console.log(dados)
                })

                var row = $($element).parents("tr:first");

                if($(this).is('.up')){
                    row.insertBefore(row.prev());
                }
                else{
                    row.insertAfter(row.next());
                }
                row.siblings().andSelf().each(function(i, el){
                    $(el).find('.order').text(i + 1);
                });
            });
        });
        </script>
@endpush
@endsection