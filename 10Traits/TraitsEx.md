# Laravel 7 Traits Example: Create & Use Trait in Laravel

https://www.positronx.io/laravel-traits-example/

https://github.com/SinghDigamber/laravel-traits-example

Criação e uso de traits em aplicativos com Laravel 7.
Trait permite-nos criar uma peça de código e reutilizar em controllers e models em aplicativos laravel.

Neste exemplo iremos trabalhar com students do banco de dados e mostrar em view.

# Que são traits?

Em geral, Traits nada mais são do que uma coleção reutilizável de métodos e funções que podem ser incorporados em qualquer outra classe. Vamos ver quais são as memórias exatas de Traits de acordo com o PHP.

Traits são um mecanismo para reutilização de código em linguagens de herança única, como PHP. Um Trait é projetado para diminuir algumas limitações de herança única, permitindo que um desenvolvedor reutilize conjuntos de métodos sem obstruções em várias classes independentes que vivem em hierarquias de classes distintas. A semântica da combinação de Traits e classes é determinada de uma forma que diminui a complexidade e contorna as dificuldades usuais relacionadas com herança composta e Mixins.

Um Trait é comparável a uma classe, embora seja projetada apenas para agrupar a funcionalidade de uma maneira refinada e constante. Não é possível instanciar um Trait por conta própria. É um acréscimo à herança tradicional e permite a composição horizontal do trait; ou seja, a aplicação de membros da classe sem exigir herança.

## Instalar o laravel

laravel new trait

cd trait

## Config

.env

## Criar um model e uma migration
```php
php artisan make:model Student -m
```
## Atualizar a migration
```php
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamps();
        });
```
## Atualizar o model app/Student.php
```php
    protected $fillable = [
        'name',
        'email',
    ];

php artisan migrate
```
### Inserir dados fake em database/seeds/DatabaseSeeder.php
```php
    public function run()
    {
        $faker = Faker::create();

        $gender = $faker->randomElement(['male', 'female']);

        foreach (range(1,10) as $index) {
            DB::table('students')->insert([
                'name' => $faker->name($gender),
                'email' => $faker->email
            ]);
        }
    }
```

php artisan db:seed

## Criar um trait
```php
app/Traits/StudentTrait.php

<?php

namespace App\Http\Traits;
use App\Student;

trait StudentTrait {
    public function index() {
        // Fetch all the students from the 'student' table.
        $student = Student::all();
        return view('welcome')->with(compact('student'));
    }
}
```

## Adicionar a rota
```php
Route::resource('students', 'StudentController');
```
## Criar o controller
```php
php artisan make:controller StudentController
```
### Atualizar
```php
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\StudentTrait;

class StudentController extends Controller
{
    use StudentTrait;
}
```
## Criar a view para exibir os dados
```php
resources/views/welcome.blade.php

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>Laravel Traits Example</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <table class="table table-inverse">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                @foreach($student as $data)
                <tr id="student{{$data->id}}">
                    <td>{{$data->id}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->email}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
```

## Testar
```php
php artisan serve
http://127.0.0.1:8000/students
```
