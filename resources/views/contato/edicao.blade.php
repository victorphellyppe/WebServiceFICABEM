@extends('template')

@section('titulo', 'Contato RAVVS')

@section('conteudo')


<div class="card">
    <div class="card-header">
        <strong>Configuração</strong>
    </div>

    <form action="{{route('contato-ravvs.editar')}}" method="post">
        
        <div class="card-body card-block">
            <!-- FORMULARIO -->
            <!-- ERRO -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- SUCESSO -->
            @if(session('sucesso'))
                <div class="alert alert-success" role="alert" style="margin:10px 10px">
                    {{session('sucesso')}}
                </div>
            @endif


            @csrf

            <!-- NOME -->
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-phone"></i>Telefone
                    </div>
                    <input type="text" name="telefone" value="{{old('telefone', $ravvs->telefone)}}" placeholder="Nome" class="form-control fone">
                </div>
            </div>

            <!-- ENDEREÇO -->
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-map-marker"></i>Endereço
                    </div>
                    <input type="text" name="endereco" value="{{old('endereco', $ravvs->endereco)}}" placeholder="Endereço" class="form-control">
                </div>
            </div>

            <!-- ENDEREÇO -->
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-envelope"></i>Email
                    </div>
                    <input type="email" name="email" value="{{old('email', $ravvs->email)}}" placeholder="Email" class="form-control">
                </div>
            </div>

            <!-- FORMULARIO -->
        </div>
        
        <div class="card-footer">
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fa fa-dot-circle-o"></i> Atualizar
            </button>
        </div>
    </form>
</div>
@endsection

@push("javascript")
    <script type="text/javascript" src="{{asset('js/libs/jquery.mask.min.js')}}"></script>

    <script>
        $(document).ready(function(){
            $('.fone').mask('(00) 0 0000-0000');
        });
    </script>
@endpush