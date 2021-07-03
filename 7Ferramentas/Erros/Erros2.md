# Várias causas de erros são oriundas de

## Cache

Então limpar o cache do laravel (clearall)

## Outro problema comun acontece com as rotas, mesmo existindo não são encontradas

No laravel 8 a quantidade default de rotas é bem grande

Então executar

php artisan route:list

# Num linux

Ver página a página

php artisan route:list | less

Verificar a existência da rota dashboard

php artisan route:list | grep dashboard

Ver rotas de clients

php artisan route:list | grep clients

php artisan route:clear

Testar novamente


