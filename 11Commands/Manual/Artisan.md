# Artisan em comandos

Usar
```php
use Illuminate\Support\Facades\Artisan;

Artisan::call('some:command');
    Artisan::call('list');
    \Artisan::call('config:clear');
    \Artisan::call('migrate');
    dd(Artisan::output());

ou
dd('Done')
```
## Executando o comando criado:
```php
php artisan command:name argumento1 argumento2 --optionn1
```
How to run an artisan command from a controller

Apart from within another command, I am not really sure I can think of a good reason to do this. But if you really want to call a Laravel command from a controller (or model, etc.) then you can use Artisan::call()
```php
    Artisan::call('email:send', [
            'user' => 1, '--queue' => 'default'
        ]);
```
One interesting feature that I wasn't aware of until I just Googled this to get the right syntax is Artisan::queue(), which will process the command in the background (by your queue workers):
```php
    Route::get('/foo', function () {
        Artisan::queue('email:send', [
            'user' => 1, '--queue' => 'default'
        ]);
     
        //
    });
```
If you are calling a command from within another command you don't have to use the Artisan::call method - you can just do something like this:
```php
    public function handle()
    {
        $this->call('email:send', [
            'user' => 1, '--queue' => 'default'
        ]);
     
        //
    }
```

