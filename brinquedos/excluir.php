<?php
include "conexao.php";

if ($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST["id"])) {
    header("Location: index.php");
    exit;
}

$id = $_POST["id"];

if (!ctype_digit($id)) {
    header("Location: index.php?msg=ID invalido!");
    exit;
}

$sql = "DELETE FROM brinquedos WHERE id = ?";
$comando = $conexao->prepare($sql);

if ($comando == false) {
    header("Location: index.php?msg=Erro ao preparar a exclusao!");
    exit;
}

$comando->bind_param("i", $id);

if ($comando->execute()) {
    header("Location: index.php?msg=Brinquedo excluido com sucesso!");
} else {
    header("Location: index.php?msg=Erro ao excluir o brinquedo!");
}
exit;
?>