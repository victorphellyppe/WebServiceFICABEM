<?php

namespace App\Models\Questionario;

use Illuminate\Database\Eloquent\Model;

class TipoViolencia extends Model
{
    //
    protected $table = 'tipos_violencia';
    protected $hidden = ['created_at', 'updated_at'];
}
