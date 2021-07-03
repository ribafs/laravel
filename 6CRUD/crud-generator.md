# Dicas de uso do crud-generator

Usar o nome do CRUD no singular e após a criação renomear as pastas das views para seu plural

php artisan crud:generate User --fields='name#string; email#string; password#string;' --view-path='' --controller-namespace=App\\Http\\Controllers --route-group='' --form-helper=html

php artisan crud:generate Role --fields='name#string; slug#string;' --view-path='' --controller-namespace=App\\Http\\Controllers --route-group='' --form-helper=html

php artisan crud:generate Permission --fields='name#string; slug#string;' --view-path='' --controller-namespace=App\\Http\\Controllers --route-group='' --form-helper=html

php artisan crud:generate Client --fields='name#string; email#string;' --view-path='' --controller-namespace=App\\Http\\Controllers --route-group='' --form-helper=html

php artisan crud:generate Product --fields='name#string; price#decimal;' --view-path='' --controller-namespace=App\\Http\\Controllers --route-group='' --form-helper=html
```php
Exemplo: Car
Gera assim:
migration: cars
model: Car
controller:CarController 
views: car (mudar para cars)
```
Mudar o nome das pastas de views para o plural
