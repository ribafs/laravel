# Includes

São similares aos includes do php

Podemos criar arquivos que serão incluídos nas views.

Bom para conteúdo que se repete.

Criamos o arquivo, que pode ser .php ou .blade.php

Na view usamos

@include('nome_arquivo', ['dados' => $dados])

# Criar a pasta
resources/views/includes

# Criar
resources/views/includes/dados.blade.php

# Criar a view

resources/views/apresentacao.blade.php

<h1>Includes</h1>

<div>Este é o texto da primeira seção</div>

@include('includes.dados')

<div>Este é o texto do rodapé</div>

## Rota
```php
Route::get('show', function(){
  return view('apresentacao');
});
```

