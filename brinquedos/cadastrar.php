<?php
include "conexao.php";

$erros = [];
$nome = "";
$categoria = "";
$faixa_etaria = "";
$preco = "";
$estoque = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST["nome"]);
    $categoria = trim($_POST["categoria"]);
    $faixa_etaria = trim($_POST["faixa_etaria"]);
    $preco = trim($_POST["preco"]);
    $estoque = trim($_POST["estoque"]);

    // aceita virgula no preco (ex: 10,50)
    $preco = str_replace(",", ".", $preco);

    // validacao dos dados
    if ($nome == "") {
        $erros[] = "Digite o nome do brinquedo.";
    }
    if ($categoria == "") {
        $erros[] = "Digite a categoria.";
    }
    if ($faixa_etaria == "") {
        $erros[] = "Digite a faixa etaria.";
    }
    if (!is_numeric($preco) || $preco < 0) {
        $erros[] = "O preco deve ser um numero maior ou igual a zero.";
    }
    if (!ctype_digit($estoque)) {
        $erros[] = "O estoque deve ser um numero inteiro maior ou igual a zero.";
    }

    // se nao teve erros, salva no banco
    if (count($erros) == 0) {
        $sql = "INSERT INTO brinquedos (nome, categoria, faixa_etaria, preco, estoque) VALUES (?, ?, ?, ?, ?)";
        $comando = $conexao->prepare($sql);

        if ($comando == false) {
            $erros[] = "Erro ao preparar o cadastro.";
        } else {
            $comando->bind_param("sssdi", $nome, $categoria, $faixa_etaria, $preco, $estoque);

            if ($comando->execute()) {
                header("Location: index.php?msg=Brinquedo cadastrado com sucesso!");
                exit;
            } else {
                $erros[] = "Erro ao cadastrar o brinquedo.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Brinquedo</title>
</head>
<body>
    <h1>Cadastrar Brinquedo</h1>

    <?php foreach ($erros as $erro) { ?>
        <p style="color:red"><?php echo htmlspecialchars($erro); ?></p>
    <?php } ?>

    <form method="post" action="cadastrar.php">
        <p>Nome:<br>
        <input type="text" name="nome" value="<?php echo htmlspecialchars($nome); ?>"></p>

        <p>Categoria:<br>
        <input type="text" name="categoria" value="<?php echo htmlspecialchars($categoria); ?>"></p>

        <p>Faixa etaria (ex: 3 a 5 anos):<br>
        <input type="text" name="faixa_etaria" value="<?php echo htmlspecialchars($faixa_etaria); ?>"></p>

        <p>Preco:<br>
        <input type="text" name="preco" value="<?php echo htmlspecialchars($preco); ?>"></p>

        <p>Estoque:<br>
        <input type="text" name="estoque" value="<?php echo htmlspecialchars($estoque); ?>"></p>

        <button type="submit">Salvar</button>
        <a href="index.php">Voltar</a>
    </form>
</body>
</html>