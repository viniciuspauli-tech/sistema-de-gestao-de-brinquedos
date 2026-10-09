<?php
include "config/conexao.php";

$mensagem = "";
if (isset($_GET["msg"])) {
    $mensagem = $_GET["msg"];
}

$sql = "SELECT id, nome, categoria, faixa_etaria, preco, estoque FROM brinquedos ORDER BY nome";
$comando = $conexao->prepare($sql);

if ($comando == false) {
    die("Erro ao preparar a consulta.");
}

if ($comando->execute() == false) {
    die("Erro ao buscar os brinquedos.");
}

$resultado = $comando->get_result();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gestao de Brinquedos</title>
</head>
<body>
    <h1>Gestao de Brinquedos</h1>

    <?php if ($mensagem != "") { ?>
        <p><b><?php echo htmlspecialchars($mensagem); ?></b></p>
    <?php } ?>

    <p><a href="brinquedos/cadastrar.php">Cadastrar novo brinquedo</a></p>

    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Categoria</th>
            <th>Faixa etaria</th>
            <th>Preco</th>
            <th>Estoque</th>
            <th>Acoes</th>
        </tr>

        <?php while ($brinquedo = $resultado->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $brinquedo["id"]; ?></td>
            <td><?php echo htmlspecialchars($brinquedo["nome"]); ?></td>
            <td><?php echo htmlspecialchars($brinquedo["categoria"]); ?></td>
            <td><?php echo htmlspecialchars($brinquedo["faixa_etaria"]); ?></td>
            <td>R$ <?php echo number_format($brinquedo["preco"], 2, ",", "."); ?></td>
            <td><?php echo $brinquedo["estoque"]; ?></td>
            <td>
                <a href="brinquedos/editar.php?id=<?php echo $brinquedo["id"]; ?>">Editar</a>

                <form method="post" action="brinquedos/excluir.php" style="display:inline" onsubmit="return confirm('Deseja excluir este brinquedo?');">
                    <input type="hidden" name="id" value="<?php echo $brinquedo["id"]; ?>">
                    <button type="submit">Excluir</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>

    <?php if ($resultado->num_rows == 0) { ?>
        <p>Nenhum brinquedo cadastrado.</p>
    <?php } ?>
</body>
</html>