# Executar comandos do PHP para o SO


```php
exec("ls",$o);
print_r($o);

exec("ls",$o,$v);
echo $v;

echo shell_exec('ls');

> echo shell_exec('date');

> echo shell_exec('whoami');

> echo shell_exec('ifconfig');

exec('comando');
exec('nohup php artisan some:command > /dev/null &');
```


