# Assets

Pegar o active do CSS
```php
{{ Route::current()->get() === 'site.name' ? 'active' : ''}}
```

## Inserir CSS e JavaScript do Bootstrap em nossas views:

<link rel="stylesheet" href="{{asset('css/app.css')}}">

<link rel="stylesheet" href="{{asset('js/app.js')}}">

Estes são arquivos do bootstrap atualizados e renomeados.


