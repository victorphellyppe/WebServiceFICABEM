@extends('template')

@section('titulo', 'Edição de aba (Quem somos)')

@section('conteudo')


<div class="card">
    <div class="card-header">
        <strong>Edição</strong>
    </div>

    <form action="{{route('quem-somos.editar', ['id' => $aba->id])}}" method="post">
        
        <div class="card-body card-block">
            <!-- FORMULARIO -->
            @include('quem-somos._shared.form')
            <!-- FORMULARIO -->
        </div>
        
        <div class="card-footer">
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fa fa-dot-circle-o"></i> Editar
            </button>
        </div>
    </form>
</div>
@endsection