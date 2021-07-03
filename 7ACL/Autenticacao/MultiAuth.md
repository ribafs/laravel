# Laravel 7 Multiple Authentication Example Tutorial

https://xpertphp.com/laravel-7-multiple-authentication-example-tutorial/

Múltiplas autenticações usando um middleware

laravel new multi-auth --auth

cd multi-auth

Config

.env

Atualizar migration users

    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('is_admin')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

php artisan migrate

Criar middleware

php artisan make:middleware IsAdmin

Atualizar
```php
<?php
namespace App\Http\Middleware;
use Closure;
class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(auth()->user()->is_admin == 1){
            return $next($request);
        }
        return redirect('home')->with('error',"You don't have admin access.");
    }
}
```
Registrar em app/Http/Kernel.php
```php
protected $routeMiddleware = [
'is_admin' => \App\Http\Middleware\IsAdmin::class,
```
Atualizar app/Http/Controllers/HomeController.php
```php
<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
 
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
/**
     * Show the application dashboard for admin.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminHome()
    {
        return view('adminHome');
    }
}
```
Atualizar o app/Http/Controllers/Auth/LoginController.php
```php
<?php
namespace App\Http\Controllers\Auth;
 
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
 
class LoginController extends Controller
{
 
    use AuthenticatesUsers;
 
    protected $redirectTo = RouteServiceProvider::HOME;
 
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {  
        $input = $request->all();
  
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
  
        if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password'])))
        {
            if (auth()->user()->is_admin == 1) {
                return redirect()->route('admin.home');
            }else{
                return redirect()->route('home');
            }
        }else{
            return redirect()->route('login')
                ->with('error','Email-Address And Password Are Wrong.');
        }
          
    }
}
```
Atualizaar app/User.php
```php
    protected $fillable = [
        'name', 'email', 'password', 'is_admin'
    ];
```
Adicionar ao web.php as rotas
```php
Route::get('/home', 'HomeController@index')->name('home');
Route::get('admin/home', 'HomeController@adminHome')->name('admin.home')->middleware('is_admin');
```
Criar as views
```php
resources/views/adminHome.blade.php

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
 
                    You are logged in admin dashboard!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
```
Testando

Criar dois usuários: admin e comun
```php
php artisan tinker
User::create(['name'=>'Admin', 'email'=>'admin@gmail.com', 'password' => bcrypt(123456)])
User::create(['name'=>'Common', 'email'=>'common@gmail.com', 'password' => bcrypt(123456)])

php artisan serve

http://127.0.0.1:8000/login

Testar com os dois usuários
```
