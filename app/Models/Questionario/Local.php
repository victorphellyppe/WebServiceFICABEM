<?php

namespace App\Models\Questionario;

use Illuminate\Database\Eloquent\Model;

class Local extends Model {
    //
    protected $table = 'locais';
    protected $hidden = ['created_at', 'updated_at'];
}
