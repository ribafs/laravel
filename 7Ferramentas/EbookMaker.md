# Ibis Ebook Maker

Ajuda a criar ebooks de arquivos markdown com possibilidade escolher a cor de fundo e as fontes e mais.

- Foto de capa
- Índice auto-gerado clicável
- Sintax highlight em códigos
- Dois temas: light e dark
- Fontes

## Instale o Ibis globalmente

composer global require themsaid/ibis

## Criar diretório e rodar

mkdir ibis
cd ibis

ibis init

## Estrutura criada

/assets
/assets/fonts
/assets/cover.jpg
/assets/theme-light.html
/assets/theme-dark.html
/content
/ibis.php

## Criando um ebook

### Configurando

Edite o arquivo ibis.php e configure

<?php

return [
    /**
     * The book title.
     */
    'title' => 'Laravel com foco na versão 8',

    /**
     * The author name.
     */
    'author' => 'Ribamar FS',

    /**
     * The list of fonts to be used in the different themes.
     */
    'fonts' => [
//        'calibri' => 'Calibri-Regular.ttf',
//        'times' => 'times-regular.ttf',
    ],

    /**
     * Page ranges to be used with the sample command.
     */
    'sample' => [
        [1, 3],
    ],

    /**
     * A notice printed at the final page of a generated sample.
     */
    'sample_notice' => 'Isto é uma amostra do meu livro "Laravel com foco na versão 8" por Ribamar FS. <br>
                        Para mais informações, <a href="https://github.com/ribafs/laravel8/">Clique aqui</a>.',
];

### Fontes customizadas

Caso deseje usar as próprias fontes, que devems er .ttf, deve copiar para assets/fonts e apontar no ibis.php

## Criando o conteúdo

Devemos criá-lo com markdown na pasta content e podemos quebrar em capítulos/arquivos ou seções. O ibis varrerá seu diretório em ordem alfabética.

Ibis usa os headers (#, ##, ###) para dividir o e-book em partes e capítulos 

Exemplo:

1-introducao.md
capitulo1.md
capitulo2.md
capitulo3.md


## Algumas dicas

Links - devem ser entrados da forma correta - [Descrição](Link)

Tags HTML devem ser escapadas com ```html, especialmetne a </body>

Ele prefere na sintaxe highlight: 'html', 'php', 'js', 'bash', 'json'

O capítulo 3.10 aparece antes do 3.0

## - cada um fica numa página separada

### - Todos ficam numa mesma página

Então renomeei o 3.10 para 4.1

Nomes de arquivos e Títulos dos capítulos internamente

1.0-Introdução          # 1 - Introdução
2.0-Planejamento.md     # 2.0 - Planejamento
    2.1-Requisitos.md   ## 2.1 - Requisitos
    2.2-BancoDados.md   ## 2.2 - Bancos de dados
        2.2.1-MySQL.md  ## 2.2.1 - MySQL

Para os capítulos - #
Para os itens de capítulos - ##
Terceiro nível - ## (fica no mesmo nível do segundo, ainda não suporta ### no título)

## Informações:

Após concluir o conteúdo crie a capa. Existe um exemplo:

assets/cover.jpg

Deve ser uma imagem em torno de 2481 × 3508 pixels.

Agora poderá construir seu ebook

ibis build

Por default criará uma versão light

Para criar um dark

ibis build dark

O e-book será criado na pasta

export

O ibis pode geras amostras/sample do e-book para divulgação. Para gerar uma amostra de 3 páginas

ibis sample

ibis sample dark

Será gerado na pasta export

## Exemplos criados com ibis

https://learn-laravel-queues.com/

https://learn-laravel-queues.com/laravel-queues-in-action/laravel-queues-in-action.zip

Referências

https://laravel-news.com/ibis-book-maker
https://github.com/themsaid/ibis


