# Limpar Cache no laravel

Para uso quando não conseguimos limpar normalmente o cache e especialmente antes de jogar um aplicativo em produção/deploy.

Criar dois comandos:

- clearall
- clearsome

Executar o cache respectivo à tarefa.

Se estamos trabalhando com view:

php artisan view:clear

Se com rotas

php artisan route:clear

Se com config

php artisan config:clear

Caso não consigamos assim, então apelas para os demais

Podem auxiliar
```php
php artisan list
php artisan route:list
php artisan roue:cache

php artisan view:clear
php artisan cache:clear
php artisan config:clear
php artisan route:clear

php artisan up
php artisan clear-compiled
php artisan optimize
php artisan migrate --force
php artisan cdn:push
php artisan queue:restart
php artisan opcache:clear
php artisan package:discover

composer dumpautoload
composer clearcache
```

Limpar cache do git
```php
git rm -r --cached .
git add .
git commit -am 'git cache cleared'
git push
```
Remover

rm bootstrap/cache/*

Após limpar execute

php artisan route:cache

Criação dos commands:
```php
        public function clearCompiled()
        {
            Artisan::call($this->commands['clearCompiled']);
            return $this->readView('Clear Compiled');
        }
        
        /**
         * Clear Cache facade value
         *
         * @return mixed
         */
        public function cache()
        {
            Artisan::call($this->commands['cache']);
            return $this->readView('Cache Clear');
        }

        /**
         * Clear View cache
         *
         * @return mixed
         */
        public function view()
        {
            Artisan::call($this->commands['view']);
            return $this->readView('View Clear');
        }
        
        /**
         * Clear Config cache
         *
         * @return mixed
         */
        public function config()
        {
            Artisan::call($this->commands['config']);
            return $this->readView('Config Clear');
        }
```

Gosto de usar o clearall num alias pois poderei usar em todos os aplicativos em qualquer path.


