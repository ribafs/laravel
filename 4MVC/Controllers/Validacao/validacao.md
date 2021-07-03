# Validação no Controller
```php
public function store(Request $request)
{
    $validatedData = $request->validate([
        'nome' => 'required|max:55',
        'email' => 'required',
        'cpf' => 'required|cpf',
    ]);

    // The blog post is valid...
}
```
https://laravel.com/docs/8.x/validation#introduction
