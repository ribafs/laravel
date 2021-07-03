## Autenticação no Laravel 7

No laravel 6 e anteriores a autenticação era bem simples, apenas:
```php
php artisan make:auth
```
Mas no 7 precisa executar umas poucas linhas de comando
```php
composer require laravel/ui:^2.4
php artisan ui bootstrap --auth
```
Onde tem bootstrap pode ser:

- vue
- react
```php
npm install && npm run dev

npm audit fix
```
## Autenticação para laravel 8
```php
sudo composer require laravel/jetstream;
sudo php artisan jetstream:install livewire;
```


