# Aplicativo tipo olá mundo no Laravel 8

## Para mostrar o fluxo das informações. O caminho que elas percorrem em todo o aplicativo.
```php
route
controller
model
view
middleware
provider
event
etc
```
## Router

Route::get('/ola', 'App\Http\Controllers\OlaController@ola');

## Model
```php
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ola extends Model
{
    use HasFactory;

    public $msgOla = 'Olá do model';
}
```

## Controller
```php
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ola;

class OlaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ola(Ola $ola)
    {
        return $ola->msgOla;
//        return 'Olá do OlaController, action ola';
//        return view('ola');
    }
```

## View

ola.blade.php

<h3>Olá da view ola.blade.php</h3>

## Usando middleware

Adicionar __construct ao crud-generator-acl com auth
```php
    public function __construct()
    {
        $this->middleware('auth');        
    }
```
http://localhost:8000/ola?country=Brasil
```php
Route::get('admin/profile', function () {
    //
})->middleware('auth');

use App\Http\Middleware\CheckAge;

Route::get('admin/profile', function () {
    //
})->middleware(CheckAge::class);

use App\Http\Middleware\CheckAge;

Route::middleware([CheckAge::class])->group(function () {
    Route::get('/', function () {
        //
    });

    Route::get('admin/profile', function () {
        //
    })->withoutMiddleware([CheckAge::class]);
});


php artisan make:middleware Ola

    Use request dependency injection

    public function index(Request $request)
    {
        $compary = $request->attributes->get('company'); 
    }

public function __construct()
{
   $this->middleware(function ($request, $next) {
        $this->company = $request->attributes->get('company');
        return $next($request);
    });
}
```

Controller constructor will be initialized before middleware execution.

You can get data from Injected $request object in controller functions.


