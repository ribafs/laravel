# Upload no Laravel 7

https://www.youtube.com/watch?v=Ahm4S_6e1JA&list=PLVSNL1PHDWvQBtcH_4VR82Dg-aFiVOZBY&index=51
```php
<form action="{{route('produtos.store')}}" method="post" enctype="multipart/form-data">
  @csrf
  <input type="text" name="name" placeholder="Nome">
  <input type="text" name="description" placeholder="Descrição">
  <input type="file" name="photo">
  <button type="submit">Enviar</button>
</form>
@endsection
```
## No controller, onde o form será recebido, podemos validar antes do upload

## método store()
```php
if($request->file('photo')->isValid()){ ;// true/false
  dd($request->photo);// dd($request->photo->extension());
}
```
## Configurações
config/filesystems.php

## Por default são salvos em 
storage/app/public // públicos

storage/app/ // privados
```php
if($request->file('photo')->isValid()){ ;// true/false
//  $request->file('photo')->storage(); // Armazena no path default
  $request->file('photo')->storage('produtos');

// Salvar com nome personalizado
//  $nameFile = $request->name . '.' . $request->photo->extension();
//  dd($request->file('photo')->storeAs('produtos', $nameFile));
}
// dd($request->photo->extension());
```
## Para salvar os arquivos do upload mude assim
```php
config/filesystems.php

Mudar de
    'default' => env('FILESYSTEM_DRIVER', 'local'),
para
    'default' => env('FILESYSTEM_DRIVER', 'public'),
```
## Rodar
php artisan config:clear

## Para serem visto pelo público no site, precisamos criar um link simbólico
php artisan storage:link

## Cria link simbólico dentro de public com nome storage
Agora os arquivos de storage poderão ser vistos pela URL do site


