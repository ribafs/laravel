## Criar aplicativo em Laravel 7 todo manualmente/na unha

Usando código de um aplicativo criado pelo gerador de CRUDs

Usando tabelas existentes para não precisar criar migrations

Usar clientes

## Instalação
laravel new crud-unha
cd crud-unha

## Configurar o banco no 
.env

## Criar rotas
Route::resource('clientes', 'ClienteController');

## Criar model
app\Cliente.php
```php
<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $primaryKey = 'id';
    protected $fillable = ['nome', 'email'];    
}
```
## Criar controller
app\Http\Controllers\ClienteController.php
```php
<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $clientes = Cliente::where('nome', 'LIKE', "%$keyword%")
                ->orWhere('email', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $clientes = Cliente::latest()->paginate($perPage);
        }

        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        
        $requestData = $request->all();
        
        Cliente::create($requestData);

        return redirect('clientes')->with('flash_message', 'Cliente added!');
    }

    public function show($id)
    {
        $cliente = Cliente::findOrFail($id);

        return view('clientes.show', compact('cliente'));
    }

    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);

        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, $id)
    {
        
        $requestData = $request->all();
        
        $cliente = Cliente::findOrFail($id);
        $cliente->update($requestData);

        return redirect('clientes')->with('flash_message', 'Cliente updated!');
    }

    public function destroy($id)
    {
        Cliente::destroy($id);

        return redirect('clientes')->with('flash_message', 'Cliente deleted!');
    }
}
```
## Copiar todas as views de clientes do relacionamentos
resources/views/clientes

e

resources/views/layouts

Para não usar a pasta admin, copiei seus dois arquivos para a pasta layouts e mudei o caminha de admin para layouts nas 4 views.

## Testando

php artisan serve

http://localhost:8000/clientes

