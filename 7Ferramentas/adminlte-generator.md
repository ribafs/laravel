# Laravel Generator

## Instalação

https://labs.infyom.com/laravelgenerator/docs/7.0/installation

## Download

https://github.com/InfyOmLabs/adminlte-generator/

ou alternativamente

https://github.com/InfyOmLabs/coreui-generator/tree/7.0


## Descompactar

cd aminlte-generator

## Copiar o .env e configurar o banco

composer install

## Criar registro
```php
php artisan tinker

use App\User;
User::create(['name'=>'Admin', 'email'=>'admin@admin.com', 'password' => bcrypt(123456)]);

php artisan serve
localhost:8000
```
Login com

admin@admin.com

123456

Não tem quase nada na web mas podemos usar os geradores pelo terminal
```php
php artisan infyom:api $MODEL_NAME
php artisan infyom:scaffold $MODEL_NAME     (com isso gera model, controller, views, repositório, migration e tests)
php artisan infyom:api_scaffold $MODEL_NAME 
php artisan infyom:scaffold $MODEL_NAME --save (para salvar o arquivo)
php artisan infyom:scaffold $MODEL_NAME --factory (gerar factory)
php artisan infyom:scaffold $MODEL_NAME --seeder (gerar seed)
php artisan infyom:rollback $MODEL_NAME $COMMAND_TYPE
php artisan infyom:rollback $MODEL_NAME $COMMAND_TYPE --views=edit,create,index,show
php artisan infyom:migration $MODEL_NAME
php artisan infyom:model $MODEL_NAME
php artisan infyom:repository $MODEL_NAME
php artisan infyom.api:controller $MODEL_NAME
php artisan infyom.api:requests $MODEL_NAME
php artisan infyom.api:tests $MODEL_NAME
php artisan infyom:api $MODEL_NAME --paginate=10
php artisan infyom.scaffold:controller $MODEL_NAME
php artisan infyom.scaffold:requests $MODEL_NAME
php artisan infyom.scaffold:views $MODEL_NAME
```
Crud default de users
```php
php artisan infyom.publish:user
php artisan infyom:api_scaffold Post --relations
```

Obs: Tudo é com entrada de um model.

Código criado pelos geradores no terminal aparecem no site.

