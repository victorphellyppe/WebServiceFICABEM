<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contato extends Model {
    //
    use SoftDeletes;

    //Não protege nenhum campo
    protected $fillable = ['nome', 'telefone', 'usuario_id'];

    //Não exibe esses campos
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
