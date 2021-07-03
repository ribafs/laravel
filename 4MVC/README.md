# MVC

O Laravel usa o padrão de arquitetura MCV, que ajuda a organizar o código em 3 camadas: Models, Controllers e Views.

## Pastas do MVC do Laravel

    • Rotas - /routes/web 
    • Model - /app/Models (Na versão 8, nas anteriores era na /app) 
    • Controller - /app/Http/Controllers 
    • Views - /resources/views 
    
Um router envia a requisição do usuário para o devido action de um controller. Um controller é responsável por mapear as ações do usuário final para a resposta do aplicativo, enquanto as ações de um modelo incluem ativar processos de negócios ou alterar o estado do modelo. As interações do usuário e a resposta do modelo decidem como um controlador responderá selecionando uma view apropriada.
