# Exemplo de autenticaação em Blade
```php
@auth
    // The user is authenticated...
@endauth

@guest
    // The user is not authenticated...
@endguest

Guard

@auth('admin')
    // The user is authenticated...
@endauth

@guest('admin')
    // The user is not authenticated...
@endguest

@auth <!-- somente entra aqui se o user atual estiver autenticado -->
  <p>Autenticado</p>
@else
  <p>Não Autenticado</p>
@endauth

@guest - entra somente se não autenticado

@endguet
```

