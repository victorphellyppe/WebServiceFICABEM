<?php

use Illuminate\Database\Seeder;
use App\Models\Usuario;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Usuario::create([
            'nome'  => 'Admin',
            'email' => 'admin@admin.com',
            'telefone' => '9999999',
            'senha' => md5('123456'),
            'admin' => true
        ]);
    }
}
