# Trabalhando com SQLie no Laravel

## Instalar

sudo apt install sqlite3 php7.4-pdo-sqlite

## Criar o banco acl

cd acl/database

touch database.sqlite

## Abrir o banco

cd acl/database

sqlite3 database.sqlite3

## .env
```php
DB_CONNECTION=sqlite
DB_DATABASE=/backup/www/laravel/demo58/database/database.sqlite3
DB_HOST=127.0.0.1
DB_PORT=3306
DB_USERNAME=root
DB_PASSWORD=
```
Apenas as linhas

DB_CONNECTION=sqlite
DB_DATABASE=/backup/www/laravel/demo58/database/database.sqlite3

Lembrando que o caminho do database precisa ser o path absoluto

As demais são ignoradas

## config/database.php

Alterar apenas:
```php
    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DATABASE_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite3')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],
```

## Alguns comandos do sqlite3

### Mostrar esquema da tabela

.schema contatos

### Listar tabelas do banco atual

.tables

### Sair do terminal

.quit

### Ativar timer

.timer on
.timer off - desativar

### Abrir banco

sqlite3 db_agenda

### Listar bancos

.databases

### Mostrar saída como planilha

.excel

### Help

.help


## Criar tabela contatos no sqlite

sqlite3 databases.sqlite3

create table contatos(id integer primary key AUTOINCREMENT, nome varchar(45));

## Dica

Criar o arquivo do banco do SQLite com nome

database/database.sqlite

Assim não precisaremos alterar o config/database.php

Apenas indicar o path completo do mesmo no .env


## Site oficial

https://sqlite.org


# Usando Laravel com SQLite

## Instalar a extensão

sudo apt install php7.4-sqlite3

## Criar o banco

cd database

touch database.sqlite

## Editar o .env
```php
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```
Deixe os demais sem alterar, pois o sqlite não usa host,  user nem senha
```php
sudo service apache2 restart

php artisan migrate
```

