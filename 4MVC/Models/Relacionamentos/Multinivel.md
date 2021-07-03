# Como fazer relacionamento "multinível" no Laravel 7?

Suponhamos que eu tenha as seguintes tables e respectivas models:

• states (id, name, abbreviation);
• cities (id, name) - belongsTo State;
• districts (id, name) - belongsTo City

Nos meus controllers, eu posso listar uma ou mais cidades chamando o método with('state') para exibir o nome do respectivo estado; e também posso listar um ou mais bairros chamando o método with('city') para saber o nome da respectiva cidade. Até aqui tudo OK.

Mas no meu controller District, como eu faço pra listar o(s) bairro(s) exibindo o nome da cidade e do estado ao mesmo tempo?

Não sei se me fiz entender...

Claudius Nascimento

Se que pegar o estado a partir do distrito, usa morphTo.. se der pra passar pela cidade..

With('city.state')...

da certo sim... leia os docs.... A relacao tem mais 3 paramentros pra passar a tabela e as chaves estrangeiras...
