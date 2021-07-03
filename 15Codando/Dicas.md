# Dicas

For foreign key migrations instead of ​ integer()​ use ​ unsignedInteger()​ type or

integer()->unsigned()​ , otherwise you may get SQL errors.
```php
Schema::create('employees', function (Blueprint $table) {
  $table->​ unsignedInteger​ ('company_id');
  $table->foreign('company_id')->references('id')->on('companies');
// ...
});
```
Também podemos usar unsignedBigInteger()

OrderBy on Eloquent relationships

You can specify ​ orderBy()​ directly on your Eloquent relationships.
```php
public function products()
{
return $this->hasMany(Product::class);
}
public function productsByName()
{
return $this->hasMany(Product::class)->orderBy('name');
}
```
Order of Migrations

If you want to change the order of DB migrations, just rename the file's timestamp, like from
```php
2018_08_04_070443_create_posts_table.php​ to
2018_07_04_070443_create_posts_table.php​ (changed from ​ 2018_08_04 ​ to
2018_07_04 ​ ). They run in alphabetical order.

$loop variable in foreach
```
Inside of foreach loop, check if current entry is first/last by just using $loop variable.
```php
@foreach ($users as $user)
  @if ($loop->first)
    This is the first iteration.
  @endif
  @if ($loop->last)
    This is the last iteration.
  @endif
    <p>This is user {{ $user->id }}</p>
@endforeach
```
There are also other properties like ​ $loop->iteration​ or ​ $loop->count​ .

Rotas. Grupo dentro de grupo
```php
Route::group(['prefix' => 'account', 'as' => 'account.'], function() {
  Route::get('login', 'AccountController@login');
  Route::get('register', 'AccountController@register');

  Route::group(['middleware' => 'auth'], function() {
    Route::get('edit', 'AccountController@edit');
  });
});
```
Incremento e decremento
```php
Post::find($post_id)->increment('view_count');
User::find($user_id)->increment('points', 50);
```
Checar se view existe
```php
if (view()->exists('custom.page')) {
// Load the view
}
```
Default timestamp
```php
$table->timestamp('created_at')->useCurrent();
$table->timestamp('updated_at')->useCurrent();
```
Versão do laravel
```php
php artisan --version
```
Código de erros no blade

resources/views/errors/500.blade.php

ou
```php
403.blade.php

@auth no blade

@if(auth()->user())
// The user is authenticated.
@endif

@auth
// The user is authenticated.
@endauth  

@guest
// The user is not authenticated.
@endguest
```
Fail

In addition to ​ findOrFail()​ , there's also Eloquent method ​ firstOrFail()​ which will return

404 page if no records for query are found.

$user = User::where('email', 'povilas@laraveldaily.com')->firstOrFail();

Usando dd() em nosso código
```php
$users = User::where('name', 'Taylor')->get()->dd();
```
Checar por dependências vencidas
```php
composer outdated

// maximum of 10 requests for guests, 60 for authenticated users
Route::middleware('throttle:10|60,1')->group(function () {
//
});
```
Blade
```php
@canany(['update', 'view', 'delete'], $post)
// The current user can update, view, or delete the post
@elsecanany(['create'], \App\Post::class)
// The current user can create a post
@endcanany

DB::statement('DROP TABLE users');
DB::statement('ALTER TABLE projects AUTO_INCREMENT=123');

// Will return Eloquent Model
$user = User::find(1);

// Will return Eloquent Collection
$users = User::find([1,2,3]);
```
Parar (bail) no primeiro erro de validaçõ
```php
$request->validate([
'title' => 'bail|required|unique:posts|max:255',
'body' => 'required',
]);

use App\User;
print Auth::id();exit;
```
Checar se user atual está logado
```php
if (Auth::check()) {
    print 'logado';exit;
}else{
    print 'não logado';exit;
}
```
Redirecionar usuários não logados
```php
protected function redirectTo($request)
{
    return route('login');
}
```
Redirecionar para login
```php
Route::get('/hello', function () {
    // Users must confirm their password before continuing...
})->middleware(['auth', 'password.confirm']);

Auth::login($user);

// Login and "remember" the given user...
Auth::login($user, true);

Auth::guard('admin')->login($user);
```

Logout

Auth::logout();


