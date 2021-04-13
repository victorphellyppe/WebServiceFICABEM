<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\QuemSomos;
use App\Models\ContatoRAVVS;
use App\Models\GrupoApoio;

class RAVVSController extends Controller {

    //Recupera informações Quem Somos da RAVVS
    public function quemSomos(Request $request) {
        $abas = QuemSomos::orderBy('posicao')->get();
        return response()->json($abas, 200);
    }
    
    //Recupara dados de contato da RAVVS
    public function contato(Request $request) {
        $contato = ContatoRAVVS::first();
        return response()->json($contato, 200);
    }

    //Recupara Dados de grupos de apoio
    public function grupos(Request $request) {
        $grupos = GrupoApoio::all();
        return response()->json($grupos, 200);
    }
}
