# Instalação do Laravel

Criar aplicativo com Laravel 7

## Pré-requisitos

- PHP >= 7.2.5
- BCMath PHP Extension
- Ctype PHP Extension
- Fileinfo PHP extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- SGBD MySQL

## Laravel 7 suporta os seguintes SGBDs
- MySQL 5.6 ou up
- PostgreSQL 9.4 ou up
- SQLite 3.8.8 ou up
- SQL Server 2017 ou up
- Redis

O Redis é um armazenamento de estrutura de dados de chave-valor de código aberto e na memória. O Redis oferece um conjunto de estruturas versáteis de dados na memória que permite a fácil criação de várias aplicações personalizadas. Os principais casos de uso do Redis incluem cache, gerenciamento de sessões, PUB/SUB e classificações. É o armazenamento de chave-valor mais conhecido atualmente.

https://laravel.com/docs/7.x#server-requirements

## Instalação

## Instalação global
```
composer global require laravel/installer
```
Agora para criar os projetos ou se coloca o laravel no path assim (para Ubuntu):
```
echo 'export PATH="$PATH:$HOME/.config/composer/vendor/bin"' >> ~/.bashrc
```
Fechar o terminal e abrir novamente para surtir efeito

Upgrade para o 4
```
composer global require "laravel/installer:^4.0"
```

Versão específica

- macOS: $HOME/.composer/vendor/bin
- Windows: %USERPROFILE%\AppData\Roaming\Composer\vendor\bin
- GNU / Linux Distributions: $HOME/.config/composer/vendor/bin or $HOME/.composer/vendor/bin

## Criar projeto com laravel 8
```
laravel new blog
```
Com jetstream, teams e livewire
```
laravel new app --jet --teams --stack=livewire
```
Silente, sem nenhuma mensagem na tela
```
laravel new app --jet --teams --stack=livewire --quiet
```
### Instalando depois do laravel instalado
```
cd aplicativo
composer require laravel/jetstream
php artisan jetstream:install livewire
ou
php artisan jetstream:install inertia
```
## Instalação local
```
composer create-project --prefer-dist laravel/laravel blog
```
Instalar com uma versão específica e não a atual
```
composer create-project laravel/laravel="7.*" blog

php composer.phar create-project laravel/laravel="5.8" demo
```
## Executar servidor nativo do PHP
```
php artisan serve
http://localhost:8000/
```
## Instalar com autenticação
laravel new project --auth


