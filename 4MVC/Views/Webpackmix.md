# Arquivo js para compilar os assets

No raiz

webpack.mix.js

Requer npm instalado

npm install

npm run dev

mix.copy(['resources/assets/image/website'], 'public/assets/image/website');
mix.styles(['resources/assets/css/website.css'], 'public/assets/css/website.css');//output

mix.js(['resources/assets/js/website.js'], 'public/assets/js/website.js');//output

cd aplicativo

npm install

npm run watch

cria a pasta node_modules

npm install bootstrap

.sass('node_modules/bootstrap/sass/bootstrap.scss','public/css/bootstrap.css');
.scripts('node_modules/jquery/dist/jquery.js', 'public/js/jquery.js');
.scripts('node_modules/bootstrap/dist/js/bootstrap.bundle.js', 'public/js/bootstrap.bundle.js');

## Rodar para cada comando acima

npm run dev


