<?php

use Illuminate\Database\Seeder;
use App\Models\GrupoApoio;

class GruposApoioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        GrupoApoio::insert([
            ['nome' => 'Hospital da Mulher Dra. Nise da Silveira', 'endereco' => 'Av. Comendador Leão, 1213 - Poço, Maceió - AL, 57025-000'],
            ['nome' => 'Hospital Geral do Estado Prof. Osvaldo Brandão Vilela', 'endereco' => 'Av. Siqueira Campos, 2095 - Trapiche da Barra, Maceió - AL, 57010-001'],
            ['nome' => 'Hospital Geral Dr. Ib Gatto Falcão', 'endereco' => 'R. Santo Antônio, S/N - Centro, Rio Largo - AL, 57100-000'],
            ['nome' => 'Hospital de Emergência Dr. Daniel Houly', 'endereco' => 'Sen. Arnon de Melo, Arapiraca - AL, 57315-745'],
            
            ['nome' => 'Hospital Metropolitano', 'endereco' => 'Av. Menino Marcelo, 9526-9672 - Barro Duro, Maceió - AL, 57083-410'],
            ['nome' => 'Hospital do Norte', 'endereco' => 'Porto Calvo - AL, 57900-000'],
            ['nome' => 'Unidade Mista Sen. Arnon de Melo', 'endereco' => 'Centro, Campo Alegre - AL, 57250-000'],
            // ['nome' => 'Hospital da Mata', 'endereco' => ''],
            ['nome' => 'Hospital Regional Nossa Senhora do Bom Conselho', 'endereco' => 'R. São Francisco, 154 - Centro, Arapiraca - AL, 57300-080'],
            // ['nome' => 'Hospital do Alto Sertão', 'endereco' => ''],
            ['nome' => 'Hospital Regional Dr. Clodolfo Rodrigues De Melo', 'endereco' => 'Avenida João Agostinho, 677 - Santo Antonio, Santana do Ipanema - AL, 57500-000']
        ]);
    }
}
