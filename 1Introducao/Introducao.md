# Introdução ao Framework Laravel

O framework Laravel nos oferece uma estrutura com muitos e bons recursos para a criação de aplicativos, APIs, sites, etc.

O Laravel é, basicamente, sobre equipar e capacitar os desenvolvedores. Seu objetivo é fornecer informações claras, código e recursos simples e bonitos que ajudam os desenvolvedores a aprender, iniciar e desenvolver rapidamente, e escreva um código simples, claro e que dure.

“Desenvolvedores felizes fazem o melhor código” está escrito na documentação. “A felicidade do desenvolvedor, do download ao deploy” foi o slogan não oficial por um tempo.

Onde outros frameworks podem ter como objetivo principal a pureza arquitetônica, ou compatibilidade com os objetivos e valores das equipes de desenvolvimento corporativo, o principal recurso do Laravel, seu foco está em servir o desenvolvedor individual.

O Laravel se concentra em "convenção sobre configuração" - o que significa que, se você estiver disposto para usar os padrões do Laravel, você precisará fazer muito menos trabalho do que com outros frameworks que exigem que você declare todas as suas configurações, mesmo se você estiver usando a recomendada configuração. Os projetos criados no Laravel levam menos tempo do que os criados na maioria dos outros PHP frameworks.

Nos bastidores, o Laravel usa muitos padrões de design e à medida que avança. Desde o início, o Laravel o ajuda a codificar ambiente acoplado. A estrutura se concentra no design de classes para ter uma única responsabilidade, evitando a codificação embutida nos módulos de nível superior. Módulos de nível superior não dependem dos módulos de nível inferior, tornando a codificação uma experiência agradável.

Devido a essa flexibilidade, o Laravel se tornou um dos frameworks mais populares de hoje.

O Laravel pode lidar com seu ciclo de vida de request/response com bastante facilidade. A complexidade dos requests não existe aqui.

Você pode pensar na primeira camada como a autenticação, enquanto o middleware testa se o usuário está autenticado. Se o usuário não estiver autenticado, o usuário é enviado de volta à página de login. Se o usuário efetuar login com sucesso, o usuário deve enfrentar a segunda camada, que pode consistir na validação do token CSRF. o processo continua assim e os casos de uso mais comuns do middleware Laravel que protege seu aplicativo: autenticação, validação de token CSRF, modo de manutenção, e assim por diante. Quando seu aplicativo está no modo de manutenção, uma visualização personalizada é exibida para todos os pedidos.

O autor do Laravel, Taylor Otwell, resume os recursos flexíveis do Laravel da seguinte forma (em uma conferência do PHPWorld em 2014):

• Procure simplicidade
• Configuração mínima
• Sintaxe concisa, memorável e expressiva
• Infraestrutura poderosa para PHP moderno
• Ótimo para iniciantes e desenvolvedores avançados
• Abraça a comunidade PHP

**Versões do Laravel**
```sh
1.0 	June 2011
2.0 	September 2011
3.0 	February 22, 2012
3.1 	March 27, 2012
3.2 	May 22, 2012
4.0 	May 28, 2013 	≥ 5.3.0
4.1 	December 12, 2013 	≥ 5.3.0
4.2 	June 1, 2014 	≥ 5.4.0
5.0 	February 4, 2015 	≥ 5.4.0
5.1 LTS 	June 9, 2015 	≥ 5.5.9
5.2 	December 21, 2015 	≥ 5.5.9
5.3 	August 23, 2016 	≥ 5.6.4
5.4 	January 24, 2017 	≥ 5.6.4
5.5 LTS 	August 30, 2017 	≥ 7.0.0
5.6 	February 7, 2018 	≥ 7.1.3
5.7 	September 4, 2018 	≥ 7.1.3
5.8 	February 26, 2019 	≥ 7.1.3
6 LTS 	September 3, 2019 	≥ 7.2.0
7 	March 3, 2020[17] 	≥ 7.2.5[18]
8 	September 3, 2020 (TBC) 	≥ 7.3.0
```
**Início dos frameworks, seguindo o Rails**

CakePHP foi o primeiro em 2005, foi seguido pelo Symfony, CodeIgniter, Zend Framework e Kohana (um fork do CodeIgniter). Yii em 2008 e Aura e Slim em
2010 . 2011 vem o FuelPHP e Laravel

## Alguns dos principais recursos atuais:

- Instalação facilitada
- Configurações simples no .env
- namespace com psr-4
- Convenções sobre configurações
- Router
- MVC
- ORM Eloquente
- Validação de dados
- Tamplates com blade para as views
- Biblioteca para a criação de formulários
- Artisan
- Tinker
- Migrations
- Seeds
- Service Providers
- Middlewares
- Traits
- Tratamento de erros
- Autenticação
- Autorização
- Entre outros

## Exemplo usando as convenções: produtos

- Router - routes/web.php
- Model - app/Produto.php
- Controller - app/Http/Controllers/ProdutoController.php
- View - resources/views/produtos

## Métodos/actions padrões de CRUD em controller:

- index - listagem dos registros
- create - form para adicionar novo registro. Trabalha em conjunto com store para adicionar ao banco
- store - armazena no banco novos registros
- show - mostra um registro na tela
- edit - form para edição de registro. Trabalha em conjunto com update, que armazena no banco
- update - armazena no banco alteração de registro
- destroy - excluir registro do banco

## MVC

O Laravel usa o padrão de arquitetura MVC

Pastas do MVC do Laravel

- Rotas - /routes
- Model - /app/Models
- Controller - /app/Http/Controllers
- Views - /resources/views

Um controller é responsável por mapear as ações do usuário final para a resposta do aplicativo, enquanto as ações de um modelo incluem ativar processos de negócios ou alterar o estado do modelo. As interações do usuário e a resposta do modelo decidem como um controlador responderá selecionando uma view apropriada.

## Fluxo resumido de código de uma aplicação com Laravel

- Um usuário através do Navegador acessa uma rota. Exemplo: clients
- A rota (routes/web.php) geralmente chama um action de um controller. No caso controller clients e action index()
- O controller/action carrega o model respectivo
- Então o model efetua a consulta ao banco de dados
- O banco de dados devolve o resultado para o model
- O model devolve para o controller/action
- O controller chama a view respectiva, passando para ela as informações recebidas do model
- A view mostra para o usuário as informações solicitadas na tela do aplicativo

## Dicas
http://artesaos.github.io/laravel-br-awesome/

