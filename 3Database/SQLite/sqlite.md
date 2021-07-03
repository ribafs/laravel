# Usando SQLite no Laravel

Apenas crie o banco em databases com o nome

- touch database/database.sqlite

- Editar o .env e mudar a conexão

DB_CONNECTION=sqlite

php artisan migrate

Já migrou para o sqlite

php artisan tinker

\App\Models\User::all()

Já funciona normalmente


