<?php
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class FuncionariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        for($i=0; $i<=100; $i++):
            DB::table('funcionarios')
                ->insert([
                'nome'      => $faker->userName,
                'email'      => $faker->email,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'=> Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        endfor;
    }
}

