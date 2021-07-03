# Um pouco da QueryBuilder

## Rota
```php
Route::get('teste', function(){
  //$dados = DB->table('clientes')->get();
  $dados = DB->table('clientes')->where('nome', 'joao')->get();
  return $dados;
});  
```

## Num controller adicionar

use Illuminate\Suporte\Facades\DB;
```php
public function index(){
$id = 12;
//$data = DB::select('select * from clientes');
//$data = DB::table('clientes')->select('nome')->get();
//$data = DB::table('clientes')->where('nome', 'Joao')->get();
$data = DB::table('clientes')->where('nome', 'Joao')->count();
$data = DB::table('clientes')->where('id', '<', 20)->get();
$data = DB::table('clientes')->where('id', '=', $id)->get();
$data = DB::table('clientes')
    ->where('id', '=', $id)
    ->select('email')
    ->get();
$data = DB::table('clientes')
    ->where('nome', 'Joao')
    ->orWhere('nome', 'Rui')
    ->get();

return $data;
}
```

