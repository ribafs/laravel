# Criar hash de senha para user com bcrypt no seed
```php
    public function run()
    {
        User::create([
            'name' => 'Hapo Tester',
            'email' => 'test@haposoft.com',
            'password' => bcrypt('12345678')
        ]);
    }
```
