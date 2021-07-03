# Implantação do aplicativo em produção

Antes de publicar no servidor o nosso aplicativo precisamos efetuar algumas alterações/configurações

Otimização com o composer

composer install --optimize-autoloader --no-dev

Otimizar as configurações de carga

php artisan config:cache

Otimizar cache de rotas

php artisan route:cache

Otimizar a carga das views

php artisan view:cache

Mudar o debug para produção no .env

APP_DEBUG=false

APP_ENV=production


