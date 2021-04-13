@extends('template')

@section('titulo', 'Nova resposta')

@section('conteudo')


<div class="card">
    <div class="card-header">
        <strong>Adicionando uma resposta a {{$duvida->autor->nome}}</strong>
    </div>

    <form action="{{route('duvidas.comentarios.cadastrar', ['duvidaID' => $duvida->id])}}" method="post">
        
        <div class="card-body card-block">
            <!-- FORMULARIO -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @csrf


            <!-- FORMULARIO -->

            <!-- DESCRICAO -->
            <div class="form-group">
                <label for="nf-email" class=" form-control-label">Resposta</label>
                <textarea class="form-control" name="comentario" rows="10">{{old('comentario', $comentario->comentario)}}</textarea>      
            </div>

        </div>
        
        <div class="card-footer">
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fa fa-dot-circle-o"></i> Responder
            </button>
        </div>
    </form>
</div>
@endsection