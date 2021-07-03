<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Paciente;

class PacientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $paciente1 = new Paciente;
        $paciente1->name = "Luan";
        $paciente1->cpf = "12345678912";
        $paciente1->anamnese = "";
        $paciente1->email = "educadoresnolinnux@gmail.com";
        $paciente1->medico_id = 1;
        $paciente1->save();

        $paciente2 = new Paciente;
        $paciente2->name = "Neto";
        $paciente2->cpf = "14725836947";
        $paciente2->anamnese = "";
        $paciente2->email = "educadores@gmail.com";
        $paciente2->medico_id = 2;
        $paciente2->save();
    }
}
