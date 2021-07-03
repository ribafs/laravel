# Roteiro para popular tabelas com seed no Laravel

## Criar a classe de seed com o faker

php artisan make:seeder ClientesTableSeeder

## Dica

$article->email = $faker->userName.'@gmail';

```php
<?php
use Illuminate\Database\Seeder;

class ClientesTableSeeder extends Seeder
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

Ou
    public function run()
    {
        $faker = \Faker\Factory::create();
            for ($i = 1; $i<6; $i++) {
                $article = new \App\User();
                $article->name = $faker->userName;
                $article->email = $faker->userName.'@gmail';
                $article->password = bcrypt(123456);
                $article->save();
           }

    }

```
## Mudar o run() de DatabaseSeeder.php para:
```php
    public function run()
    {
        $this->call(ClientesTableSeeder::class);
    }
```
## Executar para popular a tabela

composer dump-autoload
php artisan db:seed --class=ClientesTableSeeder

## Exemplo sem faker, apenas com registros simples

Simples
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

Rodar um seeder de dentro da classe do migration

public function up()
{
    Schema::create('themes', function (Blueprint $table) {
        $table->increments('id');
        $table->text('name');
    });

    Artisan::call('db:seed', [
        '--class' => ThemesTableSeeder::class
    ]);
}

Seeder testes/local ou em produção

DatabaseSeeder for Local and Production

Sometimes you need to seed some data only in your local environment, but not in production. Or, use different seeder files for different environments.

Not sure if it’s the most elegant way, but here’s how in the past I’ve achieved different seeding for local and production environments.
```php
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (app()->environment() == 'production') {
            $this->call(ThemesTableSeeder::class);
            $this->call(LanguagesTableSeeder::class);
        } else {
            $this->call(UsersTableSeeder::class);
            $this->call(ModulesTableSeeder::class);
            $this->call(ThemesTableSeeder::class);
            $this->call(LanguagesTableSeeder::class);
        }
    }
}
```

