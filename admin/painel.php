<?php 
require "proteger.php";
$usuario = $_SESSION["usuario"];
?>

<!DOCTYPE html>
<html>
<head>
<title>Painel</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container p-4">
    <h2>Bem-vindo, <?= $usuario['nome'] ?>!</h2>

    <a class="btn btn-success" href="cadastrar.php">Cadastrar doação</a>
    <a class="btn btn-primary" href="listar.php">Minhas doações</a>
    <a class="btn btn-danger" href="../logout.php">Sair</a>
</div>

<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: ../login.php");
    exit;
}
?>


</body>
</html>
