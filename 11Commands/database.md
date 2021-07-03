# Dicas de bancos para comandos
```php
$cfg=config('database.connections.' . config('database.default'));// . '.database');
dd($cfg);// Volta os dados da conexão:
"host" => "127.0.0.1"
  "port" => "3306"
  "database" => "tt"
  "username" => "root"
  "password" => "root"
```
E mais
```php
$cfg=config('database.connections.' . config('database.default') . '.database');
print $cfg;

$bd = config('database.connections.' . config('database.default') . '.database');
print $cfg;exit;// Retorna nome do banco

$cfg=config('database.connections.' . config('database.default') . '.host');
print $cfg;exit;// host

$cfg=config('database.connections.' . config('database.default') . '.username');
print $cfg;exit;// user

$cfg=config('database.connections.' . config('database.default') . '.password');
print $cfg;exit;// pass

```
