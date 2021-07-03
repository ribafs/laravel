# Laravel 7.x Gate and Policy Example From Scratch
 
Step 1: Install Laravel

laravel new gates_scratch

cd gates_scratch
 
Step 2: Create Migration 

Add migrate para adicionar campo role para a tabela users
```php
php artisan make:migration add_role_column_to_users_table
 
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role',  ['user', 'manager', 'admin'])->default('user');
        });
    }
```
Executar 

php artisan migrate
 
Step 3:  Define Gates

Editar
```php
app/Providers/AuthServiceProvider.php
    public function boot()
    {
        $this->registerPolicies();
   
        /* define a admin user role */
        Gate::define('isAdmin', function($user) {
           return $user->role == 'admin';
        });
       
        /* define a manager user role */
        Gate::define('isManager', function($user) {
            return $user->role == 'manager';
        });
      
        /* define a user role */
        Gate::define('isUser', function($user) {
            return $user->role == 'user';
        });
    }
}
```
Step 4:  Use Gates in Blade File

Editar resources/views/home.blade.php e deixar assim:
```php
@extends('layouts.app')
  
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
   
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
  
                    @can('isAdmin')
                        <div class="btn btn-success btn-lg">
                          You have Admin Access
                        </div>
                    @elsecan('isManager')
                        <div class="btn btn-primary btn-lg">
                          You have Manager Access
                        </div>
                    @else
                        <div class="btn btn-info btn-lg">
                          You have User Access
                        </div>
                    @endcan
  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
```
Step 5:  Use Gates in Controller

Você pode autorizar user em controller assim:

Criar controller
```php
php artisan make:controller GatesController

<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GatesController extends Controller
{
  public function delete()
  {
      if (Gate::allows('isAdmin')) {
          dd('Admin allowed');
      } else {
          dd('You are not Admin');
      }
  }
}
```
Criar rota
```php
Route::get('delete', 'GatesController@delete');
```
Testar
```php
php artisan serve
localhost:8000/delete
```
Step 6 : Gates in Middleware

We can use user roles with middleware as like bellow:
```php
routes/web.php
Route::get('/posts/delete', 'PostController@delete')->middleware('can:isAdmin')->name('post.delete');

Route::get('/posts/update', 'PostController@update')->middleware('can:isManager')->name('post.update');

Route::get('/posts/create', 'PostController@create')->middleware('can:isUser')->name('post.create');

```
 
Creating Policies

Com policies podemos permitir ou negar cada usuário de acessar as seções do site. Também podemos usar gates para ver seu próprio conteúdo.
For example, if your application is a blog, you may have a Post model and a corresponding PostPolicy to authorize user actions such as creating or updating posts.
 
Step 7 : Create Policy
```php
php artisan make:policy PostPolicy
``` 
You may specify a --model when executing the command:
```php
php artisan make:policy PostPolicy --model=Post
```
Step 8: Register policies

In this step we need to register our policy before use it. So register it in the following file:

Editar app/Providers/AuthServiceProvider.php
```php
namespace App\Providers;

use App\Policies\PostPolicy;
use App\Post;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Post::class => PostPolicy::class,
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
```
 
Once the policy has been registered, we may add methods for each action it authorizes in PostPolicy class like below.

Editar app/Policies/PostPolicy.php
```php
namespace App\Policies;

use App\Post;
use App\User;

class PostPolicy
{
    /**
     * Determine if the given post can be updated by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return bool
     */
    public function update(User $user, Post $post)
    {
        return $user->id === $post->user_id;
    }
}
```
Here the logic defines that only those user can update their post who are the author of their post. Now you can check it like below.
```php
if ($user->can('update', $post)) {
    //user is authorized now
}
```
Step 9: Used policy via Middleware

Laravel includes a middleware that can authorize actions before the incoming request even reaches your routes or controllers, check below code to understand.
```php
use App\Post;

Route::put('/post/{post}', function (Post $post) {
    // The current user may update the post...
})->middleware('can:update,post');
``` 
You can also use it to avoiding models.
```php
Route::post('/post', function () {
    // The current user may create posts...
})->middleware('can:create,App\Post');
```
 
Step 10: Controllers Helpers

You can use policy class method to authorize user like below.
```php
public function update(Request $request, Post $post)
{
   $this->authorize('update', $post);

   // The current user can update the blog post...
}
``` 
The following controller methods will be mapped to their corresponding policy method:

Controller Method
```php
Policy          Method
index           viewAny
show            view
create          create
store           create
edit            update
update          update
destroy         delete
``` 
Step 11: Policy in Blade Template 

In this situation, you may use the @can and @cannot family of directives:
```php
@can('update', $post)
    
@elsecan('create', App\Post::class)
    
@endcan

@cannot('update', $post)
    
@elsecannot('create', App\Post::class)
    
@endcannot
```
 
Like most of the other authorization methods, you may pass a class name to the @can and @cannot directives if the action does not require a model instance:
```php
@can('create', App\Post::class)
    
@endcan

@cannot('create', App\Post::class)
    
@endcannot
```
 
https://www.codechief.org/article/laravel-gate-and-policy-example-from-scratch#gsc.tab=0


