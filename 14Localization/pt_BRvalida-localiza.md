# Para implementar localização em um projeto com Laravel em pt_BR siga os passos:

## - Editar config/app.php
```php
Localizar
    'locale' => 'en',

E mudar para
    'locale' => 'pt_BR',

Ou apenas criar uma cópia
```
## Encontrar a pasta

resources/lang/en

E copiar para

resources/lang/pt_BR

## Agora podemos traduzir manualmente cada um dos arquivos ou encontrar um pacote já traduzido como:

https://github.com/esjdev/laravel-6.x-ptBR-localization
https://github.com/lucascudo/laravel-pt-BR-localization
https://github.com/vitorec/laravel-5.5-pt-br-locale

## Teste

Em um controller ou em um model, no action store():
```php
    public function store(Request $request)
    {
        
        $requestData = $request->all();

       $validatedData = $request->validate([
          'nome' => 'required||min:3|max:55',
          'email' => 'unique:clientes',
       ]);
        
        Cliente::create($requestData);

        return redirect('clientes')->with('flash_message', 'Cliente added!');
    }
```
Agora tente inserir um registro que descumpra as regras de validação

