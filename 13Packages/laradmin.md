Criar um bonito Dashboard

Usando laravel-acl-exist, tipo:

Admin

- users
- roles
- permissions
- products
- clients

Site

- index e show de clients
- index e show de products

Menu lateral vertical esquerdo


- Instalar o laravel

laravel new laradmin --jet --stack=livewire

npm install && npm run dev && npm audit fix

cd laradmin

Instalar o crud-generator-acl

composer require ribafs/crud-generator-acl

php artisan vendor:publish --provider="Ribafs\CrudGeneratorAcl\CrudGeneratorServiceProvider"

Cruar um crud products

php artisan crud-acl:generate Products --fields='name#string; price#decimal;' --view-path=admin --controller-namespace=App\\Http\\Controllers\\Admin --route-group=admin --form-helper=html

Instalar o laravel-acl-exist

composer require ribafs/laravel-acl-exist

php artisan vendor:publish --provider="Ribafs\LaravelAclExist\LaravelAclExistServiceProvider"

php artisan copy:files

Remover os arquivos de backup criados .BAK:

- roures
- resources/views
- app/Models
- database/seeders

Criar o banco 'laradmin' e configurar em

APP_NAME='Simple Laravel Admin'

.env

Executar migrations e seeders

php artisan migrate --seed


Testar

php artisan serve

http://localhost:8000/admin/clients

Acessar com

super@mail.org
123456

Melhorar a aparência:

No título do aplicativo no app.blade.php

                <a class="navbar-brand bg-dark text-white" href="{{ url('/') }}">
                    &nbsp;&nbsp;&nbsp;{{ config('app.name', 'Simple Laravel Admin') }}&nbsp;&nbsp;&nbsp;
                </a>

Nas views

Adicionei bg-success e bg-light
                    <div class="card-header bg-success">Product {{ $product->id }}</div>
                    <div class="card-body bg-light">

E também no sidebar.blade.php

Ajustes nos controllers sobre ACL
Adicionar products nas rotas
Ajustes nas views e ProductController quanto a ACL


