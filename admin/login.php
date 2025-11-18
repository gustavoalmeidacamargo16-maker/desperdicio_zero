<?php
session_start();
require "conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $senha = $_POST["senha"];

    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        $user = $res->fetch_assoc();

        if (password_verify($senha, $user["senha"])) {
            $_SESSION["usuario"] = $user;

            if ($user["tipo"] == "admin") {
                header("Location: admin/index.php");
            } else {
                header("Location: painel/index.php");
            }
            exit;
        }

        $erro = "Senha incorreta.";
    } else {
        $erro = "Usuário não encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Desperdício Zero</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="card shadow p-4" style="max-width: 380px; width: 100%;">
        <h3 class="text-center text-success fw-bold">Entrar</h3>

        <?php if (isset($erro)): ?>
            <div class="alert alert-danger mt-3"><?= $erro ?></div>
        <?php endif; ?>

        <form method="POST" class="mt-3">
            <div class="mb-3">
                <label class="form-label">E-mail:</label>
                <input type="email" class="form-control" name="email" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Senha:</label>
                <input type="password" class="form-control" name="senha" required>
            </div>

            <button class="btn btn-success w-100">Entrar</button>
            <a href="cadastro_usuario.php" class="btn btn-link w-100 mt-2">Criar conta</a>
        </form>
    </div>
</div>

</body>
</html>
