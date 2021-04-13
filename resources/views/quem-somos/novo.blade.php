@extends('template')

@section('titulo', 'Nova aba')

@section('conteudo')


<div class="card">
    <div class="card-header">
        <strong>Cadastro de nova aba (Quem Somos)</strong>
    </div>

    <form action="{{route('quem-somos.cadastrar')}}" method="post">
        
        <div class="card-body card-block">
            <!-- FORMULARIO -->
            @include('quem-somos._shared.form')
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