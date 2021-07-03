# Criar classe customizada no Laravel

A ideia é criar uma classe com conteúdo que desejo e utilizar a mesma em outras classes do Laravel.

Criar

app/Classes/PasswordGen.php

```php
<?php
namespace App\Classes;

class PasswordGen
{
  public static function passwordRand(){
    $value = '';
    $chars = 'abcdefghijklmnopqrstuvwxyz_ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!?#$%';

    for($m = 0; $m<10; $m++){
      $index = rand(0, strlen(chars));
      $value .= substr($chars. $index, 1);
    }
    return $value;
  }
}
```
## Usando:

Para utilizar esta nossa classe em qualquer classe do Laravel fazemos:

```php
use App\Classes\PasswordGen;
```

