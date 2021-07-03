Dica sobre migrations

You need to run the composer dumpautoload command to generate a new classmap every time you add a file to database/, otherwise it will not be autoloaded.

É recomendado setar o tamanho dos campos strings para 191 em:

Edite

app/Providers/AppServiceProvider.php

Adiciona

use Illuminate\Support\Facades\Schema;

E ao método boot

Schema::defaultstringLength(191);
