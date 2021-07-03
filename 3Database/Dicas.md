# Ao usar o collation utf8mb4_unicode_ci

Sempre use varchar() com no máximo 191. Exemplo:

$table->string('email', 191)->unique();

Melhor é alterar
```php
App/Providers/AppServiceProvider.php

Adicionar ao método boot()
Schema::defaultstringLength(191);

Também adicionar:
use Illuminate\Support\Facades\Schema;
```
