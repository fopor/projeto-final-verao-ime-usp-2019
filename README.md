Tarefas para o projeto final.

Instale as bibliotecas usando
$ composer install

Iniciailize o servidor do Symfony usando o comando
$ php bin/console server:run

## Tarefas já feitas:
* Colocar um cabeçalho com menu (nav-bar) em todas as páginas.


## Tarefas a fazer:
* Aplicar CSS a todas as páginas

* Página Inicial:
- Arrumar a página inicial para carregar dois produtos de forma aleatória.

* Buscar Produto
- Receber o POST do campo de busca de produtos e exibir os produtos que tenham o termo pesquisado no nome ou na descrição. (Ver mysql like)

* Carrinho de Compras
- Permitir alterar a quantidade de um produto no carrinho de compra. Se a quantidade for 0, remover o produto do carrinho.

* Cadastro de Cliente
- Finalizar o cadastro de cliente, salvando o cliente no banco de dados e enviando para a página "/loja/finalizar".

Tarefas-extras:

* Finalização de Pedidos
- Fazer uma tela onde o cliente possa escolhar a forma de pagamento.

* Salvar o pedido no banco de dados. Obs.: Precisa de uma tabela pedidos (id, cliente_id, data, total) e uma pedidos_produtos (id, pedido_id, produto_id, quantidade, preco, total)

* Mostrar os dados da tela de obrigado à partir dos dados salvos no banco de dados

* Enviar um e-mail (SMTP) com a confirmação do pedido.

