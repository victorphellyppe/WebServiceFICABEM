@extends('template')

@section('titulo', 'Novo grupo')

@section('conteudo')


<div class="card">
    <div class="card-header">
        <strong>Cadastro de um novo grupo</strong>
    </div>

    <form action="{{route('grupos.cadastrar')}}" method="post">
        
        <div class="card-body card-block">
            <!-- FORMULARIO -->
            @include('grupos._shared.form')
            <!-- FORMULARIO -->
        </div>
        
        <div class="card-footer">
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fa fa-dot-circle-o"></i> Cadastrar
            </button>
        </div>
    </form>
</div>
@endsection