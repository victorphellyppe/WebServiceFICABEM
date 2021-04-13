<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comentario extends Model {
    
    //Sempre carrega autor
    protected $with = ['autor'];
    
    //Não protege nenhum campo
    protected $guarded = [];

    //Adiciona como atributo padrão
    protected $appends  = ['data'];

    protected $hidden = ['created_at', 'deleted_at', 'updated_at', 'usuario_id'];
    
    /** Retorna o dono da duvida */
    public function autor() {
        return $this->belongsTo('App\Models\Usuario', 'usuario_id');
    }

    /** Retorna a data de criação */
    public function getDataAttribute() {
        return substr($this->created_at, 0, 10);
    }
}
