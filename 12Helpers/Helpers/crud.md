# CRUD genérico, para qualquer tabela, com exemplos de uso

#### select($table = 'users', $id){
```php
return select('users', 5);
```
#### insert($table = 'users', $fields = []){
```php
return insert('users', ['name' => 'Ribamar FS', 'email' => 'joao@gmail.com', 'password' => bcrypt('123456')]);
```
#### update($table = 'users', $whereValue, $fields = []){
```php
return update('users', 5, ['name' => 'João Brito']);
return update('users', 5, ['name' => 'João Brito', 'email' => 'joao@joao.org']);
```
#### delete($table = 'users', $id){
```php
return delete('users', 5);
```
## Agradecimento

Meus sinceros agradecimentos ao colega Klaus Andrade, do grupo Laravel Brasil, que me enviou as sugestões/recomendações para refatorar as funções do crud.php. Ficaram uma beleza, ao meu ver. Daqui rpa frente tentarei fazer assim. 

