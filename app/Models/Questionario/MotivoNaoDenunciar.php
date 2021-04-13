<?php

namespace App\Models\Questionario;

use Illuminate\Database\Eloquent\Model;

class MotivoNaoDenunciar extends Model
{
    
    protected $table = 'motivo_nao_denunciar';

    protected $hidden = ['created_at', 'updated_at'];
}
