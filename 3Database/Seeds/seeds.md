# Seeds - são classes que armazenam informações sobre registros de uma tabela.

No laravel 8 as pastass chamam-se database/seeders

## Para criar a classe de um seed com regitro(s) de uma tabela executamos:

php artisan make:seeder ClientesTableSeeder

## Então editamos o arquivo criado em

database/seeds

Exemplo

```php
<?php
use Illuminate\Database\Seeder;

class ClientesTablesSeeder extends Seeder
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
            DB::table('clientes')
                ->insert([
                'nome'      => $faker->userName,
                'email'      => $faker->email,
                ]);
        endfor;
    }
}
```
## Mudar o run() de DatabaseSeeder.php para:

```php
    public function run()
    {
        $this->call(ClientesSeeder::class);
    }
```

## Para gravar os registros na tabela execute

php artisan db:seed --class=ClienteSeeder

ou todos

php artisan db:seed

## Seed simples, sem uso do faker

```php
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'user_type' => 'admin',
            'password' => bcrypt('123456')
        ]);
        DB::table('users')->insert([
            'name' => 'Autor',
            'email' => 'autor@gmail.com',
            'user_type' => 'autor',
            'password' => bcrypt('123456')
        ]);
        DB::table('users')->insert([
            'name' => 'Editor',
            'email' => 'editor@gmail.com',
            'user_type' => 'editor',
            'password' => bcrypt('123456')
        ]);
    }
```

Detalhes:

https://laravel.com/docs/7.x/seeding


# Run with all defaults.

php artisan db:seed

# Specify database connection.

php artisan db:seed --database=staging

# Specify a different seeder class.

php artisan db:seed --seeder=ConfigurationSeeder

# Force the seed while in production.

php artisan db:seed --force

# All together.

php artisan db:seed --database=staging --seeder=ConfigurationSeeder --force


