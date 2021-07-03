# Session

## Add ao início do controller

use Session;
```php
Session::put('login', 'validado');
Session::put('is', $user->id);
Session::put('user', $user->username);

if(Session::has('login'){
  return direct('protegido');
}else{
  return direct('/');
}
```
Ao tentar acessar uma rota verificar se existe sessão, se existir acesse, se não não acessa

Destruir sessão/logout, limpando todas as variáveis de sessão

Session::flush();
