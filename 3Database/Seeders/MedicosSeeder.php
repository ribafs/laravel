<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Medicos;

class MedicosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $medico1 = new Medico;
        $medico1->name = "Jorge Almeida";
        $medico1->endereco = "Rua Candido de Souza 570";
        $medico1->cidade = "Fortaleza";
        $medico1->cep = "60420440";
        $medico1->uf = "CE";
        $medico1->pais = "Brasil";
        $medico1->email = "educadoresnolinnux@gmail.com";
        $medico1->user_id = 1;
        $medico1->save();

        $medico2 = new Medico;
        $medico1->name = "João Queiroz";
        $medico1->endereco = "Rua Roberto de Souza 570";
        $medico1->cidade = "Fortaleza";
        $medico1->cep = "6034056";
        $medico1->uf = "CE";
        $medico1->pais = "Algola";
        $medico1->email = "educadores@gmail.com";
        $medico1->user_id = 1;
        $medico1->save();
    }
}
