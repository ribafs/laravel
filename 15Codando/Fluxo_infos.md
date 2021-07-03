# Passando variável do Model Post para o controller PostsController

## Model Post

	public $msg='Ribamar';

## PostsController

use App\Post;
```php
    public function index(Post $post)
    {
		$ms = $post->msg;
		print $ms;exit;

    }
```
## Caso não importe o model no início, podemos fazer assim:
```php
    public function index()
    {
		$post = new \App\Post;
		$ms = $post->msg;
		print $ms;exit;
	}
```
## Passando um método do Model para o Controller

Post
```php
	public function teste()
	{
		$var1 = 'João';
		$var2 = 'Pedro';
		$var3 = 'Joaquim';

		return compact('var1','var2','var3');
	}
```
PostsController
```php
use App\Post;
    public function index(Post $post)
    {
			$ret= $post->teste();

print $ret['var1'].'<br>';
print $ret['var2'].'<br>';
print $ret['var3'];
exit;
        return 'Método index';
    }
```
## Criar variável que fique disponível para todas as views

app\Htpp\Controllers\Controller.php

Adicionar:
```php
    function __construct()
    {
    	return \View::share('usuario', 'Ribamar');
    }
```
## Na View

<h3>Usuário {{$usuario}}</h3>

Ou então usando o méetodo boot do app/Providers/AppServiceProvider.php
```php
    public function boot()
    {
		return \View::share('usuario', 'Ribamar');
    }
```
## Na view

<h3>Usuário {{$usuario}}</h3>

Criar Controller base extendendo Controller

E demais extendendo del
```php
class BasicoController extends Controller {

    protected $cdata;

    public function __construct()
    {
        $this->cdata = 'Something';
    }   

}

class ClientesController extends BasicoController {

    public function __construct() 
    {
        parent::__construct();

        dd($this->cdata);
    }   

}
```


