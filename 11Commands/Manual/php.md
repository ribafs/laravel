# Dicas de PHP para uso em comandos

## Podemos usar todas as funções nativas do PHP nos comandos do laravel

Separar código para model e código para controller
```php
/*
//read the entire string
$str=file_get_contents('ClienteController.php');

//replace something in the file string - this is a VERY simple example
$str=str_replace('clientes', 'vendedores',$str);
$str=str_replace('cliente', 'vendedor',$str);
$str=str_replace('Cliente', 'Vendedor',$str);
$str=str_replace('nome', 'name',$str);
$str=str_replace('email', 'cpf',$str);

//write the entire string
file_put_contents('ClienteController.php', $str);

// Rename to Vendedor.php
rename('ClienteController.php', 'VendedorController.php');

*/

$table = 'clientes';

// Model name
$model = ucfirst($table);
$model = substr($model,0,-1);

// Controlller name
$controller = $model.'Controller';

// Views folder
$viewFolder = $table;
```

