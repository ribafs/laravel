# Criar um factory para popular uma tabela com um seeder

## Criar migration para contatos

php artisan make:migration create_contatos_table --create=contatos

## Editar e completar os campos
```php
    public function up()
    {
        Schema::create('contatos', function (Blueprint $table) {
            $table->id();
            $table->string('saudacao',5);
            $table->string('nome',50);
            $table->string('telefone');
            $table->date('nascimento');
            $table->string('email', 80);
            $table->string('nota');
            $table->timestamps();
        });
    }
```
## Criar model

php artisan make:model Contato

## Criar o factory

php artisan make:factory ContatoFactory

## Criar o seeder

php artisan make:seeder ContatosTableSeeder

## Executar

composer dumpautoload

## Editar o factory criado e deixar assim:
```php
<?php
use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Contato::class, function (Faker $faker) {
    return [
        'saudacao' => 'Sr.',
        'nome' => $faker->name,
        'telefone' => $faker->cellphoneNumber,
        'nascimento' => $faker->date("Y-m-d"),
        'email' => $faker->unique()->safeEmail,
        'nota' => 'Usuário criado usando o método factory e a classe faker'
    ];
});
```

## Editar o seeder criado e deixar assim:
```php
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
        // Opção 1 - aqui criará um registro

        DB::table('contatos')->insert([
          'saudacao' => 'Sr',
          'nome' => 'Angelito Casagrande',
          'telefone' => '123123123',
          'nascimento' => '2000-04-02',
          'email' => 'ribafs@gmail.com',
          'noma' => 'Usuário criado usando o seeder com DB',
          'created_at' => date('Y-m-d H:i:s')
        ]);

        // Opção 2 - aqui criará mais 20 registros
        factory(App\Contato::class, 20)->create();

    }
}
```
## Descomentar a linha em seeds/DatabaseSeeder.php

        $this->call(ContatosTableSeeder::class);

## Executar

php artisan migrate:refresh --seed

