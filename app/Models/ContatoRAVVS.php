<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContatoRAVVS extends Model
{
    //
    protected $table = 'contato_ravvs';
        
    //Não protege nenhum campo
    protected $guarded = [];

    //Não exibe esses campos
    protected $hidden = ['id', 'created_at', 'updated_at'];
}
