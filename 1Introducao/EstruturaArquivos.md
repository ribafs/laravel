# Alguns dos principais diretórios do Laravel 7

app/ - Diretório dos arquivos da sua aplicação

bootstrap/ - Arquivos de inicialização, são chamados em cada requisição ao servidor

config/ - Arquivos de configuração como banco de dados, serviços, etc.

database/ - Aqui existem basicamente duas pastas,  “migrations” que guardam os arquivos que fazem as alterações na estrutura do banco, como nome das tabelas, colunas, etc, e “seeds” que seriam arquivos e classes que geram registros no banco de dados, seja para testes ou para possuir informações iniciais de utilização.

public/ - São os arquivos públicos do sistema, normalmente é aqui que são colocados os arquivos de imagens, CSS e JS.

resources/ - Arquivos de recursos como bibliotecas JS e CSS, arquivos com arrays de traduções de mensagens, normalmente usados numa aplicação multilinguagem e as próprias views do sistema.

storage/ - Arquivos de cache, sessões (quando usado armazenamento em arquivo), views compiladas e logs.

tests/ - Arquivos de testes do sistema.

vendor/ - pasta criada pelo composer para controle e versionamento de bibliotecas.


# Todas as pastas
```php
/app
  /Console
  /Exceptions
  /Http
  /Providers
  /User.php
/bootstrap
  app.php
/config
/database
  /factories
  /mirations
  /seeds
/public
  index.php
/resources
  /js
  /lang
  /sass
  /views
/routes
  api.php
  web.php
/storage
/tests
/vendor - pacotes de terceiros
artisan
composer.json
package.json
phpunit.xml
server.php
webpack.mix.js
.env
```
## A pasta public funciona como document root

43,6 MB (uma instalação limpa do Laravel 7.12)

```php
composer.json - informações sobre o aplicativo, autoload e dependências para o composer
composer.lock
package.json - informações para o nodeJS
package-lock.json
phpunit.xml - Testes unitários
README.md - Como se fosse o índex.html estando o projeto no GitHub
server.php - servidor web nativo do PHP
webpack.mix.js
.editorconfig
.env - configurações
.env.example
.gitattributes
.gitignore
.styleci.yml
```

