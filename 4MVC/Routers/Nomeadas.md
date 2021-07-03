# Rotas nomeadas
```php
Route::get('about', function() {
    return view('pages.about');
})->name('about');

// Ou usando um controller:
Route::get('about', 'PageController@showAbout')->name('about');

Route::get('/users', [UserController::class, 'index'])->name('users.index');
```

## Na view
```php
<a href="{{ route('posts.show', [$id]) }}">Link to Resource {{ $id }}</a>
<a href="{{ route('posts.show', [$id], false) }}">Link to Resource {{ $id }}</a>
/posts/10

<?php
// Define rota em `routes/web.php`
Route::get('posts/{post}/comments/{comment}', 'CommentController@show')->name('comment');
{-- Create link to named route in Blade --}
<a href="{{ route('comment', ['1', '2', 'par'=>'HELLO', 'par2'=>'Goodbye']) }}">The Comment</a>
A URL gerada parece com: http://example.com/posts/1/comments/2?par=HELLO&par2=Goodbye

redirecionar para http://example.com/leads?ship=Rocinante
return redirect()->route('leads.index', ['ship' => 'Rocinante']);
https://dev-notes.eu/2016/11/generate-urls-to-named-routes-in-laravel/ 
```


