# Criar uma permissão que nenhum user tem

all-no

php artisan add:perm 'No perms' all-no 

E atribuir para todas as views que não desejo acesso

@can('all-no')

Nos actions
```php
    public function create(Request $request)
    {
        if ($request->user()->can('all-no')) {
            return view('admin.clients.create');
        }else{
            print '<a href="#" onClick="window.history.back();">Back to app</a>';
            return '<h3 align="center">Access denied in this demo</h3>';
        }
    }
```
Restringi para somente os que tem a permissão all-no, que nenhum user tem.

Não precisa mexer nas views.
