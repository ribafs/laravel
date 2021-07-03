# Um pouco do Eloquent

## Métodos find() e all():
```php
App\Produto::all(); //SELECT * FROM produtos;
App\Produto::find(1); // SELECT * FROM produtos WHERE id = 1;

App\Cliente;

public function index(){
// O código abaixo também funciona numa rota com App\Cliente;
//  $clientes = Cliente->all(); // ou get()
  $clientes = Cliente->where('nome', 'Joao')->get();
  return $clientes;
}
```
Importante: nas convenções do Laravel existe uma relação fiel entre o nome da tabela e da classe:

Tabela - clients

Model - Client

É útil também que usemos os nomes de tabelas, campos, classes, etc tudo em inglês para tornar nossas vidas mais fáceis, visto que o framework é todo baseado no inglês e suas convenções seguem este idioma.



