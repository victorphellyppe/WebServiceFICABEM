<?php

namespace App\Models\Questionario;

use Illuminate\Database\Eloquent\Model;

class VinculoAgressor extends Model
{
    //
    protected $table = 'vinculo_agressores';
    protected $hidden = ['created_at', 'updated_at'];
}
