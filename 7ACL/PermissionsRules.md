# ACL no Laravel 7

As ACL são listas de controle de acesso. Para isso temos dois grandes componentes: autenticação e autorização. O laravel cuida bem da primeira parte pra nós e da segunda existem ferramentas nativas e de terceiros para isso.

No laravel autorização é implementada através de gates e policies.

## Policies

Políticas/policies são classes que ajudam a organizar a lógica de autorização em torno de qualquer recurso de modelo. Ele tem um mecanismo elegante para garantir que os usuários sejam autorizados a executar ações nos recursos.

O principal objetivo da Política do Laravel é fornecer mais controle sobre a autorização, como:
- Um user pode criar um artigo
- O único user do artigo é quem pode editar ou excluir ele

- Autenticação, que cuida do login verificando se o usuário tem direitos de acessar o aplicativo
- Autorização, que cuida de conceder e remover privilégios para acesso a diversas seções do site/aplicativo. São atribuídas funções/roles para específicos usuários e cada role tem específicos privilégios. 
  - super - é uma role que teria direito a tudo
  - admin - teria direito a administrar certa área
  - autor - teria direito de criar artigos
  - editor - direito de editar artigos
  - comun - direito somente a listar certa(a) seções
  - etc

## Permissões e Rules

Permissões e funções/roles

Exemplos de roles:
- admin, 
- moderator, 
- basic

Exemplos de permissões:
- view, 
- add, 
- edit,
- delete

## Uma role 
- admin tem geralmente as permissões: view, add, edit e delete
- moderator tem as permissões edit e view
- basic tem somente a permissão view

Estamos considerando permissões apenas para um objeto ou site/aplicativo, mas podemos ter permissões assim:

Exemplos de permissões da index.blade.php:
- view-index, 
- add-index, 
- edit-index,
- delete-index

Exemplos de permissões da edit.blade.php:
- view-edit, 
- add-edit, 
- edit-edit,
- delete-edit

etc.
Para anexar permissões para roles podemos usar
Middleware

Um dos recursos mais comuns em qualquer aplicativo Web é a autenticação, que permite ao usuário efetuar login ou logout de um aplicativo para gerenciar com segurança suas informações.

No entanto, muitas vezes um aplicativo também pode querer restringir o acesso a certos aspectos do sistema a um determinado tipo de usuários. Esse segundo nível de triagem é conhecido como Controle de Acesso. Recentemente, tive que implementar um nível muito avançado e granular de controle de acesso em um aplicativo baseado na API do Laravel.

As funções/roles e permissões do ACL são muito importantes, especialmente se você estiver criando um grande aplicativo no laravel 7.X.

Funções/roles e permissões permite a você criar vários tipos de usuários com função/roles e permissão diferentes, ou seja, alguns usuários só veem uma lista de módulos de itens, alguns também podem editar módulos de itens, outros podem excluir e etc.

Após registrar um usuário não temos ainda nenhuma role aplicada a ele, então podemos editar seus detalhes e atribuir uma função/role de administrador para ele no Gerenciamento de Usuários do aplicativo.

Depois disso, você pode criar sua própria função/role com permissão como lista de funções, comorole-list, role-create, role-edit, role-delete, product-list, product-create, product-edit, product-delete. Você pode verificar como atribuir novo usuário e verificar isso.

O pacote Spatie de permissão de roles/função fornece uma maneira de criar acl no laravel. Ele fornecemaneira de atribuir role/função ao usuário, como atribuir permissão ao usuário e como atribuir permissão para roles/funções.

