<?php

use Illuminate\Database\Seeder;
use App\Models\Questionario\MotivoNaoDenunciar;
use App\Models\Questionario\Transtorno;
use App\Models\Questionario\Local;
use App\Models\Questionario\TipoViolencia;
use App\Models\Questionario\MeioViolencia;
use App\Models\Questionario\ViolenciaSexual;
use App\Models\Questionario\VinculoAgressor;

class QuestionarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        MotivoNaoDenunciar::insert([
            ['id' => 1, 'descricao' => 'Medo'],
            ['id' => 2, 'descricao' => 'Dependência Econômica'],
            ['id' => 3, 'descricao' => 'Descrença na justiça'],
            ['id' => 4, 'descricao' => 'Vergonha'],
            ['id' => 5, 'descricao' => 'Preservar a relação'],
            ['id' => 6, 'descricao' => 'Outro'],
        ]);

        Transtorno::insert([
            ['id' => 1, 'descricao' => 'Deficiência Física'],
            ['id' => 2, 'descricao' => 'Deficiência Intelectual'],
            ['id' => 3, 'descricao' => 'Deficiência Visual'],
            ['id' => 4, 'descricao' => 'Deficiência Auditiva'],
            ['id' => 5, 'descricao' => 'Transtorno Mental'],
            ['id' => 6, 'descricao' => 'Transtorno de Comportamento'],
            ['id' => 7, 'descricao' => 'Outro']
        ]);
            
        Local::insert([
            ['id' => 1, 'descricao' => 'Residência'],
            ['id' => 2, 'descricao' => 'Habitação Coletiva'],
            ['id' => 3, 'descricao' => 'Escola'],
            ['id' => 4, 'descricao' => 'Local de prática esportiva'],
            ['id' => 5, 'descricao' => 'Bar ou similar'],
            ['id' => 6, 'descricao' => 'Via pública'],
            ['id' => 7, 'descricao' => 'Comércio/Serviços'],
            ['id' => 8, 'descricao' => 'Indústrias/Construção'],
            ['id' => 9, 'descricao' => 'Outro'],
            ['id' => 99, 'descricao' => 'Ignorado']      
        ]);
        
        TipoViolencia::insert([
            ['id' => 1, 'descricao' => 'Física'],
            ['id' => 2, 'descricao' => 'Psicológica/Moral'],
            ['id' => 3, 'descricao' => 'Tortura'],
            ['id' => 4, 'descricao' => 'Sexual'],
            ['id' => 5, 'descricao' => 'Tráfico de seres humanos'],
            ['id' => 6, 'descricao' => 'Financeira/Econômica'],
            ['id' => 7, 'descricao' => 'Negligência/Abandono'],
            ['id' => 8, 'descricao' => 'Trabalho Infantil'],
            ['id' => 9, 'descricao' => 'Intervenção Legal'],
            ['id' => 10, 'descricao' => 'Outros'],
        ]);

        MeioViolencia::insert([
            ['id' => 1, 'descricao' => 'Força Corporal/Espancamento'],
            ['id' => 2, 'descricao' => 'Obj. pérfuro-cortante'],
            ['id' => 3, 'descricao' => 'Arma de fogo'],
            ['id' => 4, 'descricao' => 'Enforcamento'],
            ['id' => 5, 'descricao' => 'Substância/Obj. quente'],
            ['id' => 6, 'descricao' => 'Ameaça'],
            ['id' => 7, 'descricao' => 'Obj. contundente'],
            ['id' => 8, 'descricao' => 'Envenenamento, intoxicação'],
            ['id' => 9, 'descricao' => 'Outros']
        ]);

        ViolenciaSexual::insert([
            ['id' => 1, 'descricao' => 'Assédio sexual'],
            ['id' => 2, 'descricao' => 'Estupro'],
            ['id' => 3, 'descricao' => 'Pornográfia Infantil'],
            ['id' => 4, 'descricao' => 'Exploração Sexual'],
            ['id' => 5, 'descricao' => 'Outros']
        ]);
        
        VinculoAgressor::insert([
            ['id' => 1, 'descricao' => 'Pai'],
            ['id' => 2, 'descricao' => 'Mãe'],
            ['id' => 3, 'descricao' => 'Padrasto'],
            ['id' => 4, 'descricao' => 'Madrasta'],
            ['id' => 5, 'descricao' => 'Cônjulge'],
            ['id' => 6, 'descricao' => 'Ex-Cônjulge'],
            ['id' => 7, 'descricao' => 'Namorado(a)'],
            ['id' => 8, 'descricao' => 'Ex-Namorado(a)'],
            ['id' => 9, 'descricao' => 'Filho'],
            ['id' => 10, 'descricao' => 'Irmão'],
            ['id' => 11, 'descricao' => 'Amigos/Conhecidos'],
            ['id' => 12, 'descricao' => 'Desconhecido(a)'],
            ['id' => 13, 'descricao' => 'Cuidador(a)'],
            ['id' => 14, 'descricao' => 'Patrão/Chefe'],
            ['id' => 15, 'descricao' => 'Pessoa com relação institucional'],
            ['id' => 16, 'descricao' => 'Policial/Agente da lei'],
            ['id' => 17, 'descricao' => 'Própria pessoa'],
            ['id' => 18, 'descricao' => 'Outros']
        ]);
    }
}
