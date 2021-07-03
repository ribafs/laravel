public function store(Request $request)
{
$name = $request->input('name');

//
}

Erismar B. Vieira

O Obj Request é responsável por capturar todo o tipo de requisição HTTP, sejam elas formulários, Headers, url (query string), informações do servidor de destino e de origem, etc...

Então o que vc faz aí é simplesmente instanciar o parâmetro como o Obj Request e acessar essas propriedades...
O Laravel já lhe entrega isso prontinho através das rotas...
