# Tinker - Console interativa do Laravel

## Interagir com o aplicativo através do terminal
php artisan tinker

## Como usar

Após executar php artisan tinker
```php
use App\Post;
Post::create(['title'=>'Título do Post', 'content'=>'Conteúdo do Post']);

Post::create(['title'=>'Título do Post2', 'content'=>'Conteúdo do Post2']); 

use App\Comment;
Comment::create(['post_id'=>1, 'comment'=>'Comentário']);

$p = Post::find(1);

$p->comments; //Lista comentários do post acima, pois estão relacionados

$c = Comment::find(1);

$c->post // Trará o post relacionado com o comentário

DB::table('clientes')->get();

DB::table('clientes')->where('nome', 'joao')->get();

===
$user = App\User::find(1);
===

$c->post->title;

// see the count of all users
App\User::count();

// find a specific user and see their attributes
App\User::where('username', 'samuel')->first();

// find the relationships of a user
$user = App\User::with('posts')->first();
$user->posts;

App\User::all();

Criar novo user
$user = new App\User;
$user->name = "Wruce Bayne";
$user->email = "iambatman@savegotham.com";
$user->password = Hash::make('123456');
$user->save();

Deletando
$user = App\User::find(1);
$user->delete();

class Order extends Eloquent {}
$order = new Order;
$order->title = 'Xbox One';
$order->save();

echo Config::get('app.url');

use App\Role;
$r = new Role;

$r->name = 'Admin';
$r->slug = 'admin';
$r->description = 'manager admin privilege';
$r->save();
```
## Atualização
```php
$r = new Role();
$r->update(['id' =>1,'description'=>'manage super privilege']);

 use App\Role;
$r = Role::create(['id'=>2, 'name'=>'Manager', 'slug'=>'manager','description'=>'manager manager privilege']);
```

## Usando o tinker para trazer um produto e suas avaliações

php artisan tinker
```php
use Loja\Produto;
$p->Prpduto::find(5);

$p->avaliacoes;
```

## Gerar 500 users fakes usando a lib Faker
```php
php artisan tinker
factory(App\User::class, 500)->create();
```
## Gerar products fakes

database/factories/UserFactory.php
```php
<?php
use Faker\Generator as Faker;
/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/
$factory->define(App\User::class, function (Faker $faker) {
    static $password;
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});
$factory->define(App\Post::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'body' => $faker->text,
    ];
});
```

php artisan tinker
factory(App\Product::class, 500)->create();


Adicionar um usuário

php artisan tinker

use App\User;
User::create(['name'=>'Admin', 'email'=>'admin@gmail.com', 'password' => bcrypt(123456)]);
User::create(['name'=>'Author', 'email'=>'author@gmail.com', 'password' => bcrypt(123456)]);
User::create(['name'=>'Editor', 'email'=>'editor@gmail.com', 'password' => bcrypt(123456)]);


Cadastrar novo user com tinker

php artisan tinker

use App\User;
$user = new App\Models\User;
$user->name = "Ribamar FS";
$user->email = "ribafs@gmail.com";
$user->password = bcrypt('123456');
$user->role = 'admin';
$user->save();

Ou então de uma única vez

use App\Models\User;
User::create(['name'=>'Super', 'email'=>'super@gmail.com', 'password' => bcrypt(123456)]);
User::create(['name'=>'Admin', 'email'=>'admin@gmail.com', 'password' => bcrypt(123456)]);
User::create(['name'=>'Autor', 'email'=>'autor@gmail.com', 'password' => bcrypt(123456)]);
User::create(['name'=>'Editor', 'email'=>'editor@gmail.com', 'password' => bcrypt(123456)]);

use App\Models\User;
User::create(['name'=>'Ribamar FS', 'email'=>'ribafs@gmail.com', 'password' => bcrypt(123456), 'role'=>'admin']);

User::create(['name'=>'Author', 'email'=>'author@gmail.com', 'password' => bcrypt(123456), 'role'=>'author']);

User::create(['name'=>'Editor', 'email'=>'editor@gmail.com', 'password' => bcrypt(123456), 'role'=>'editor']);


Ver todos

$user::all();


Gerar hash bcrypt

bcrypt('123456');

$2y$10$DUcWrQ58KfigSiGLjxIUjuUrxE6PznMi62CTnCEDBcGCnSXB35Jvy


