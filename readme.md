Gestao de Brinquedos

Projeto de recuperacao (Atividades 6 a 8) feito em PHP com MySQL. O sistema controla os brinquedos de uma loja e tem as 4 operacoes do CRUD:

Create: cadastrar um novo brinquedo (cadastrar.php)
Read: listar os brinquedos (index.php)
Update: editar um brinquedo (editar.php)
Delete: excluir um brinquedo (excluir.php)

Cada brinquedo tem: nome, categoria, faixa etaria, preco e quantidade em estoque.

Todas as consultas ao banco usam Prepared Statements (mysqli), e os dados digitados sao validados antes de salvar. Se acontecer algum erro no banco, uma mensagem e mostrada na tela.

Estrutura de pastas
gestao-brinquedos/
|-- index.php              (lista os brinquedos)
|-- README.md
|-- banco/
|   `-- banco.sql          (cria o banco e a tabela)
|-- config/
|   `-- conexao.php        (conexao com o MySQL)
`-- brinquedos/
    |-- cadastrar.php      (formulario de cadastro)
    |-- editar.php         (formulario de edicao)
    `-- excluir.php        (exclui o brinquedo)