# Laravel 7.x Authorization using Gates

Step 1 : Instalar laravel

laravel new gates

cd gates
 
Step 2:  Make Auth
```php
composer require laravel/ui --dev
php artisan ui vue --auth
npm install & npm run watch
```
Step 3 : Create Migration

Adicionar campo role para a tabela users
```php
php artisan make:migration add_role_column_to_users_table
 
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role',  ['admin', 'author', 'editor'])->default('admin');
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
```
Rodar
```php
php artisan migrate
```
Step 4: Add Some Dummy Users
```php
php artisan tinker

use App\User;
User::create(['name'=>'Admin', 'email'=>'admin@gmail.com', 'password' => bcrypt(123456), 'role'=>'admin']);

User::create(['name'=>'Author', 'email'=>'author@gmail.com', 'password' => bcrypt(123456), 'role'=>'author']);

User::create(['name'=>'Editor', 'email'=>'editor@gmail.com', 'password' => bcrypt(123456), 'role'=>'editor']);
```
 
Step 6: Define Gates

Editar
```php
app/Providers/AuthServiceProvider.php
namespace App\Providers;

    public function boot()
    {
        $this->registerPolicies();

         // define a admin user role 
         Gate::define('isAdmin', function($user) {
            return $user->role == 'admin';
         });
        
         //define a author user role 
         Gate::define('isAuthor', function($user) {
             return $user->role == 'author';
         });
       
         // define a editor role 
         Gate::define('isEditor', function($user) {
             return $user->role == 'editor';
         });
    }
}
``` 
Step 7:  Usages of Gates

Editar resources/views/home.blade.php e deixar assim:
```php
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Home</div>
                <div class="card-body">
                 
               @can('isAdmin')
                    <div class="btn btn-success btn-lg">
                      You have Admin Access
                    </div>
               @elsecan('isAuthor')        
                    <div class="btn btn-primary btn-lg">
                      You have Author Access
                    </div>
                @else
                    <div class="btn btn-info btn-lg">
                      You have Editor Access
                    </div>
                @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
```
 
Testando
```php
php artisan serve

localhost:8000
```
Faça Login com os 3 usuários

Step 8 : Gates in Controller:

Adicione a rota
```php
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::get('hello',function(){   

//   return Gate::allows('isAdmin') ? Response::allow()
  //  : Response::allow('You do not edit this post.');// Era: deny

  //Or use  
    if (Gate::allows('isAdmin')) {
        dd('You are admin');
    } elseif(Gate::allows('isAuthor')){
        dd('You are Athor');
    } elseif(Gate::allows('isEditor')){
        dd('You are Editor');
    }else{
      print 'You are not: admin, author or editor';
    }

   //Or use
    if (Gate::denies('isEditor')) {
        dd('You are editor');
    } else {
        dd('Only admin can access this page');
    }
});
```
 
Step 9 : Gate as Middleware

Adicione as rotas
```php
Route::get('/items/delete', 'PostController@delete')->middleware('can:isAdmin')->name('items.delete');

Route::get('/items/update', 'PostController@update')->middleware('can:isAuthor')->name('items.update');

Route::get('/items/create', 'PostController@create')->middleware('can:isEditor')->name('items.create');
```
Apenas certifique-se de não usar gates e polícies totalmente para as mesmas ações do Model, pois isso criará problemas.

https://www.codechief.org/article/laravel-6-authorization-using-gates#gsc.tab=0
