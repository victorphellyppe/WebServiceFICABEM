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

<!-- NOME -->
<div class="form-group">
    <div class="input-group">
        <div class="input-group-addon">
            <i class="fa fa-hands-helping"></i>Nome
        </div>
        <input type="text" name="nome" value="{{old('nome', $grupo->nome)}}" placeholder="Nome" class="form-control">
    </div>
</div>

<!-- ENDEREÇO -->
<div class="form-group">
    <div class="input-group">
        <div class="input-group-addon">
            <i class="fa fa-map-marked-alt"></i>Endereço
        </div>
        <input type="text" name="endereco" value="{{old('endereco', $grupo->endereco)}}" placeholder="Endereço" class="form-control">
    </div>
</div>
