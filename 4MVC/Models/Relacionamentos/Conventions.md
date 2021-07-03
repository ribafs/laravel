# Convenções para nomes de tabelas

## Tabelas base

Tudo em minúsculas e no plural
```php
users
roles
permissions
```
## Tabelas pivô

A convenção para o nome das tabelas intermediárias, ou pivô - compsoto por dois nomes, separados por _ e ambos no singular, e os nomes em orodem alfabética.

Exemplos:
```php
role_user
permission_user
permission_role

// in Product model
public function features()
{
    return $this->belongsToMany('App\Feature', 'feature_product');
}

// in Feature model
public function products()
{
    return $this->belongsToMany('App\Product', 'feature_product');
}
```

