```php
Route::get('/', function () {
    return view('welcome');
});

Route::get('foo', function () {
    return 'Hello World';
});

Route::redirect('/here', '/there', 401);

Route::view('/welcome', 'welcome', ['name' => 'Taylor']);

// Parâmetros opcionais
Route::get('user/{name?}', function ($name = 'John') {
    return $name;
});


use App\Post;
use App\User;

Route::get('api/users/{user}/posts/{post:slug}', function (User $user, Post $post) {
    return $post;
});

```
