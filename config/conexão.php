<?php


$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "loja_brinquedos";


mysqli_report(MYSQLI_REPORT_OFF);

$conexao = new mysqli($servidor, $usuario, $senha, $banco);

if ($conexao->connect_error) {
    die("Erro ao conectar com o banco de dados. Verifique o arquivo conexao.php");
}

$conexao->set_charset("utf8");
?>