# Autenticação

// Permitir user com permissão de acesso para ver a página
```php
Route::get('/test', [
    'middleware' => ['auth', 'permissions.required'],
    'permissions' => 'access',
    'uses' => 'MyController@myAction'
]);

// Permitir user com permissão de acesso ou admin para ver a página
Route::get('/test', [
    'middleware' => ['auth', 'permissions.required'],
    'permissions' => ['access', 'admin'],
    'uses' => 'MyController@myAction'
]);

// Permitir user com permissão de acesso e admin para ver a página
Route::get('/test', [
    'middleware' => ['auth', 'permissions.required'],
    'permissions' => ['access', 'admin'],
    'permissions_require_all' => true,
    'uses' => 'MyController@myAction'
]);
```

