<?php
require "conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, 'doador')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nome, $email, $senha);
    $stmt->execute();

    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Criar Conta - Desperdício Zero</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="card shadow p-4" style="max-width: 380px; width: 100%;">
        <h3 class="text-center text-success fw-bold">Criar Conta</h3>

        <form method="POST" class="mt-3">
            <div class="mb-3">
                <label class="form-label">Nome:</label>
                <input type="text" class="form-control" name="nome" required>
            </div>

            <div class="mb-3">
                <label class="form-label">E-mail:</label>
                <input type="email" class="form-control" name="email" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Senha:</label>
                <input type="password" class="form-control" name="senha" required>
            </div>

            <button class="btn btn-success w-100">Cadastrar</button>
            <a href="login.php" class="btn btn-link w-100 mt-2">Já tenho conta</a>
        </form>
    </div>
</div>

</body>
</html>
