# Segurança

Uma das formas de melhorar a segurança do aplicativo é criando controller, que mediará, validará e efetuará diversas rotinas para somente então liberar para a view.

Outro fator de segurança é usar blade nas views

Também em operações com bancos de dados existe a preocupação com segurança

## Force o uso do HTTPS na rota
```php
Route::filter('https', function(){
  if(Request::secure())
  return Redirect::secure(URI::current());
});
```
## Criar hash para senha em bcrypt

$password = Hash::make('secret');

Route::when('*', 'csrf', ['post']);

## Também devemos usar validações

Ser bastante criterioso na criação das tabelas:

- relacionamentos
- constraints
- tipos de dados
- tamanho dos campos
- etc

## Evite raw queries e DB

## Sempre use os escapes ({{ $var }} para escapar variáveis

Quando colocar o site em produção faça a devida alteração da variável APP_ENV no .env de local para production

Pode verificar com o artisan

php artisan env

Nunca anotar uma senha em arquivo HTML

Sempre que enviar o aplicativo para a nuvem remova o .env

Atualizar regularmente o aplicativo

## Evite o uso de views com php puro, ao invés use com blade e com suas tags

## Use a criptografia do Laravel, bcrypt

Mantenha o laravel e os pacotes atualizados

Nunca mostrar error nem exceptions em produção

## Filtrar arquivos de upload

## Instale no servidor o fail2ban para prevenor de DDOS, sempre que possível

https://getspooky.github.io/Laravel-Mitnick/docs.html

https://medium.com/@yasserameur/secure-your-laravel-application-with-laravel-mitnick-e67413904a57

## Confira meu novo repositório sobre segurança

[Muita coisa sobre segurança na web](https://github.com/ribafs/seguranca)

