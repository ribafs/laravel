# Adicionar campo com migration

Criaremos uma nova migração para adicionar uma coluna "role". vamos usar o tipo de dados enum para a coluna role. Consideraremos apenas os valores de "user", "manager" e "admin" nisso. vamos manter "user" como valor padrão.

então vamos criar como abaixo:

```php
php artisan make:migration add_role_column_to_users_table

    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role',  ['user', 'manager', 'admin'])->default('user');
        });
    }
```

