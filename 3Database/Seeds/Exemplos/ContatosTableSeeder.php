<?php

use Illuminate\Database\Seeder;

class ContatosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Opção 1

        DB::table('contatos')->insert([
          'saudacao' => 'Sr',
          'nome' => 'Angelito Casagrande',
          'telefone' => '123123123',
          'nascimento' => '2000-04-02',
          'email' => 'ribafs@gmail.com',
          'nota' => 'Usuário criado usando o seeder com DB',
          'created_at' => date('Y-m-d H:i:s')
        ]);

        // Opção 2
        factory(App\Contato::class, 20)->create();

    }
}
