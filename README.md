# ponderada2

Esse repositório é para entregar a atividade ponderada "Atividade: Elaboração de aplicação web integrada a um banco de dados", proposta pelo professsor Tomaz Mikio.

Esse repositório contém:

- Código
- Link para o vídeo
- Explicação no readme sobre o funcionamento da aplicação(abaixo).


## Funcionalidades

O código PHP possui as seguintes funcionalidades:

- **Conexão com o Banco de Dados:** Ele estabelece uma conexão com um banco de dados MySQL usando as informações de conexão fornecidas em um arquivo de inclusão `dbinfo.inc`.

- **Verificação da Tabela NOVA_TABELA:** Verifica se a tabela `NOVA_TABELA` existe no banco de dados. Se não existir, cria a tabela com as colunas apropriadas.

- **Adição de Dados à Tabela NOVA_TABELA:** Permite ao usuário preencher um formulário com informações sobre um produto (nome, preço, disponibilidade e descrição) e, em seguida, adiciona esses dados à tabela `NOVA_TABELA` no banco de dados.

- **Exibição de Dados da Tabela NOVA_TABELA:** Exibe os dados da tabela `NOVA_TABELA` em uma tabela HTML na página da web. Os dados são recuperados do banco de dados e exibidos em formato tabular.

- **Exclusão de Todos os Dados da Tabela NOVA_TABELA:** Oferece a opção de excluir todos os dados da tabela `NOVA_TABELA`. Isso é feito por meio de um botão "Excluir Todos os Dados da NOVA_TABELA" no formulário.

* A conexão com o EC2 foi feita usando o openSSH.

## Serviços

- EC2
- RDS --> MySQL
  
## "Ferramentas" do desenvolvimento

- HTML
- PHP

## Link para o vídeo

link: https://drive.google.com/file/d/1JLjxMr9PWUmuiEbf7IBAZgqNnDtm-aJ0/view?usp=sharing
