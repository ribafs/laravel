Alguns scripts em batch para windows

Aqui os copio para a pasta windows para que fiquem no path e a disposição de qualquer diretório

- am.bat: php artisan migrate

- ams.bat: php artisan migrate --seed

- as.bat: php artisan serve

- asd.bat: php artisan db:seed

- auth.bat (autenticação para o laravel 7)
composer require laravel/ui
php artisan ui bootstrap --auth
npm install && npm run dev
npm audit fix

- pa.bat (geral, recebendo parâmetros)
# c:\windows\pa.bat
php artisan %1 %2 %3 %4
# Sintaxe: exemplo
# pa.bat serve ou pa.bat db:seed --class=ClientsSeeder

Procurar strings - findstr
Aqui está uma lista de exemplos que você pode achar úteis:

    findstr / c: "windows 10" windows.txt - Procura no documento windows.txt a string "windows 10"
    findstr "windows 10" windows txt - Procura por "windows" ou "10" no arquivo.
    findstr "windows" c: \ documents \ *. * - Pesquisa qualquer arquivo em c: \ documents pela string "windows".
    findstr / s / i Windows *. * - Pesquisa todos os arquivos no diretório atual e todos os subdiretórios da palavra Windows que ignoram letras maiúsculas.
    findstr / b / n / r / c: "^ * FOR" * .bas - Retorna qualquer linha que comece com FOR que seja precedida por zero ou mais espaços. Imprime o número da linha também.


