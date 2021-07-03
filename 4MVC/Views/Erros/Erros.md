# Erros

Uma boa ideia é cria um include com a listagem de erros

# Criar o include
resources/views/includes/errors.blade.php
```php
@if(count($errors) != 0)
  <div class="alert alert-danger">
    @if(count($errors) == 1)
      <p class="erro">ERRO:</p>
    @else
      <p class="erro">ERROS:</p>
    @endif
    <ul>
      @foreach($errors->all() as $erro)
        <li>{{ $erro }}</li>
      @endforeach
    </ul>
  </div>
@endif
```
## Adicionar para as views com formulários

@include(includes.errors)
