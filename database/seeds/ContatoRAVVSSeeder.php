<?php

use Illuminate\Database\Seeder;
use App\Models\ContatoRAVVS;

class ContatoRAVVSSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        ContatoRAVVS::create([
            'telefone'  => '(82)3315-1393 e (82)98882-9765',
            'endereco'  => 'Av. Comendador Leão, 1213 - Poço, Maceió - AL, 57025-000',
            'email'     => 'ravvs.al@gmail.com'
        ]);
    }
}
