# Instruções para rodar aplicativos de terceiros baixados

Geralmente eles vem sem as pastas vendor e node_modules, então siga os passos:

- Descompacte par um diretório no diretório web

- Acesse o diretório

Execute

composer install

npm install

php artisan migrate

Caso exista seed:

php artisan db:seed

Testando

php artisan serve

http://localhost:8000/nome

O nome deve ser consultado na rota

routes/web.php - para aplicativos web

routes/api.php - para api

