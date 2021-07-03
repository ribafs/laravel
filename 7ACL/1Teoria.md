# ACL

A autenticação filtra quem entra/loga no aplicativo.

A autorização é mais complexa, com vários componentes e tem como principais elementos o Gate e o Policy.

Policies são classes que organizam a lógica de autorização em torno de um model ou recurso específico.

Por exemplo, se seu aplicativo for um blog, você pode ter um model Post e uma PostPolicy correspondente para autorizar ações do usuário, como criar ou atualizar postagens.

Você pode gerar uma política usando o comando make:policy do artisan. A política gerada será colocada no diretório app/Policies. Se este diretório não existir em seu aplicativo, o Laravel irá criá-lo para você.

ACL - lista de controle de acesso. Para isso temos dois grandes componentes: autenticação e autorização. O laravel cuida bem da primeira parte pra nós e da segunda existem ferramentas nativas e de terceiros.

## ACL no Laravel 7

- add, 
- add-edit, 
- add-index, 
- admin, 
- admin tem geralmente as permissões: view, add, edit e delete sobre algum recurso do site
  - admin - teria direito a administrar certa área

ALC é composta principalmente de dois elementos: autenticação e autorização.

Após registrar um usuário não temos ainda nenhuma role aplicada a ele, então podemos editar seus detalhes e atribuir uma função/role de administrador para ele no Gerenciamento de Usuários do aplicativo.

As funções/roles e permissões do ACL são muito importantes, especialmente se você estiver criando um grande aplicativo no laravel 7.X.

## Através de gates se implementa roles e permissions.
- Autenticação, que cuida do login verificando se o usuário tem direitos de acessar o aplicativo ou não
- Autorização, que cuida de conceder e remover privilégios para acesso diversas seções do site/aplicativo. São atribuídas funções/roles para específicos usuários e cada role tem específicos privilégios. 
  - autor - teria direito de criar artigos
- basic
- basic tem somente a permissão view
  - comun - direito somente a listar certa(a) seções
- delete
- delete-edit
- delete-index

Depois disso, você pode criar sua própria função/role com permissão como lista de funções, comorole-list, role-create, role-edit, role-delete, product-list, product-create, product-edit, product-delete. Você pode verificar como atribuir novo usuário e verificar isso.
- edit,
- edit-edit,
- edit-index,
  - editor - direito de editar artigos

Estamos considerando permissões apenas para um objeto ou site/aplicativo, mas podemos ter permissões assim:
  - etc
etc.

Exemplos de permissões:

Exemplos de permissões da edit.blade.php:

Exemplos de permissões da index.blade.php:

Exemplos de roles:

Funções/roles e permissões permite a você criar vários tipos de usuários com função/roles e permissão diferentes, ou seja, alguns usuários só veem uma lista de módulos de itens, alguns também podem editar módulos de itens, outros podem excluir e etc.

Middleware
- moderator, 
- moderator tem as permissões edit e view

No entanto, muitas vezes um aplicativo também pode querer restringir o acesso a certos aspectos do sistema a um determinado tipo de usuários. Esse segundo nível de triagem é conhecido como Controle de Acesso.

No Laravel authentication é um componente que instalamos e está pronto, out of box.
O pacote Spatie de permissão e roles/função fornece uma maneira de criar acl no laravel. Ele fornece maneira de atribuir role/função ao usuário, como atribuir permissão ao usuário e como atribuir permissão para roles/funções.

Os que conseguiram entrar serão verificados pela autorização, que checa quem tem permissão para acesssar cada seção do aplicativo e quem não tem.

Para anexar permissões para roles podemos usar

Permissões e Rules
  - super - é uma role que teria direito a tudo

Uma role 

Um dos recursos mais comuns em qualquer aplicativo Web é a autenticação, que permite ao usuário efetuar login ou logout de um aplicativo para gerenciar com segurança suas informações.
- view, 
- view-edit, 
- view-index, 

