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

<!-- POSICAO -->
<div class="form-group">
    <div class="input-group">
        <div class="input-group-addon">
            <i class="fa fa-sort"></i> Posição
        </div>
        <input type="number" name="posicao" value="{{old('posicao', $aba->posicao)}}" placeholder="posicao" class="form-control" min="1" max="20">
    </div>
</div>

<!-- DESCRICAO -->
<div class="form-group">
    <label for="nf-email" class=" form-control-label">Informação</label>
    <textarea class="form-control" name="descricao" rows="10">{{old('descricao', $aba->descricao)}}</textarea>
    
</div>
