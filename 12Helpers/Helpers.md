Helpers

Yratan Hofecker, no grupo Laravel Brasil:

Cara, nesse caso específico de pegar algo do DB não seria um helper e sim no seu model ou em um repositório.
Eu entendo que helper seja funcoes do tipo, formatar strings, datas, etc, coisas mais genéricas.
Eu organizo meus helpers assim: crio um comon.php para funções genéricas, e se por exemplo, eu tiver várias funções de formatar data, crio um helper só para isso.
E também eu crio dentro de uma pasta helper e dou autoload nos arquivos que estiverem dentro dela.


