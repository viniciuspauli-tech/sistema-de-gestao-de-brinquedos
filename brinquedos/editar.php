<?php
include "conexao.php";

$erros = [];

// pega o id (na primeira vez vem pela URL, depois vem pelo formulario)
if (isset($_POST["id"])) {
    $id = $_POST["id"];
} elseif (isset($_GET["id"])) {
    $id = $_GET["id"];
} else {
    $id = "";
}

if (!ctype_digit($id)) {
    die("ID invalido. <a href='index.php'>Voltar</a>");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // veio do formulario: valida e atualiza
    $nome = trim($_POST["nome"]);
    $categoria = trim($_POST["categoria"]);
    $faixa_etaria = trim($_POST["faixa_etaria"]);
    $preco = trim($_POST["preco"]);
    $estoque = trim($_POST["estoque"]);

    $preco = str_replace(",", ".", $preco);

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

    if (count($erros) == 0) {
        $sql = "UPDATE brinquedos SET nome = ?, categoria = ?, faixa_etaria = ?, preco = ?, estoque = ? WHERE id = ?";
        $comando = $conexao->prepare($sql);

        if ($comando == false) {
            $erros[] = "Erro ao preparar a atualizacao.";
        } else {
            $comando->bind_param("sssdii", $nome, $categoria, $faixa_etaria, $preco, $estoque, $id);

            if ($comando->execute()) {
                header("Location: index.php?msg=Brinquedo atualizado com sucesso!");
                exit;
            } else {
                $erros[] = "Erro ao atualizar o brinquedo.";
            }
        }
    }
} else {
    // primeira vez que abre a pagina: busca o brinquedo no banco
    $sql = "SELECT nome, categoria, faixa_etaria, preco, estoque FROM brinquedos WHERE id = ?";
    $comando = $conexao->prepare($sql);

    if ($comando == false) {
        die("Erro ao preparar a busca.");
    }

    $comando->bind_param("i", $id);
    $comando->execute();
    $resultado = $comando->get_result();

    if ($resultado->num_rows == 0) {
        die("Brinquedo nao encontrado. <a href='index.php'>Voltar</a>");
    }

    $brinquedo = $resultado->fetch_assoc();
    $nome = $brinquedo["nome"];
    $categoria = $brinquedo["categoria"];
    $faixa_etaria = $brinquedo["faixa_etaria"];
    $preco = $brinquedo["preco"];
    $estoque = $brinquedo["estoque"];
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Brinquedo</title>
</head>
<body>
    <h1>Editar Brinquedo</h1>

    <?php foreach ($erros as $erro) { ?>
        <p style="color:red"><?php echo htmlspecialchars($erro); ?></p>
    <?php } ?>

    <form method="post" action="editar.php">
        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <p>Nome:<br>
        <input type="text" name="nome" value="<?php echo htmlspecialchars($nome); ?>"></p>

        <p>Categoria:<br>
        <input type="text" name="categoria" value="<?php echo htmlspecialchars($categoria); ?>"></p>

        <p>Faixa etaria:<br>
        <input type="text" name="faixa_etaria" value="<?php echo htmlspecialchars($faixa_etaria); ?>"></p>

        <p>Preco:<br>
        <input type="text" name="preco" value="<?php echo htmlspecialchars($preco); ?>"></p>

        <p>Estoque:<br>
        <input type="text" name="estoque" value="<?php echo htmlspecialchars($estoque); ?>"></p>

        <button type="submit">Atualizar</button>
        <a href="index.php">Voltar</a>
    </form>
</body>
</html>