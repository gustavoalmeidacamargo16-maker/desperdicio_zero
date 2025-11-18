<?php
require 'db.php';
 
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ler e sanitizar entradas
    $nome = trim($_POST['nome_doador'] ?? '');
    $tipo = trim($_POST['tipo_alimento'] ?? '');
    $quantidade = trim($_POST['quantidade'] ?? '');
    $validade = $_POST['validade'] ?? null;
    $endereco = trim($_POST['endereco'] ?? '');
    $contato = trim($_POST['contato'] ?? '');
 
    if ($nome === '' || $tipo === '') {
        $errors[] = 'Nome do doador e tipo de alimento são obrigatórios.';
    }
 
    if (empty($errors)) {
        $stmt = $pdo->prepare('INSERT INTO doacoes (nome_doador, tipo_alimento, quantidade, validade, endereco, contato) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([$nome, $tipo, $quantidade ?: null, $validade ?: null, $endereco ?: null, $contato ?: null]);
        header('Location: listar.php?msg=criado');
        exit;
    }
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Cadastrar Doação</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <a href="index.html" class="btn btn-link">&larr; Voltar</a>
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Cadastrar Doação</h4>
 
        <?php if (!empty($errors)): ?>
          <div class="alert alert-danger">
            <?php foreach ($errors as $e) echo htmlspecialchars($e) . '<br>'; ?>
          </div>
        <?php endif; ?>
 
        <form method="post" novalidate>
          <div class="mb-3">
            <label class="form-label">Nome do doador / empresa *</label>
            <input name="nome_doador" class="form-control" required value="<?= isset($nome) ? htmlspecialchars($nome) : '' ?>">
          </div>
 
          <div class="mb-3">
            <label class="form-label">Tipo de alimento *</label>
            <input name="tipo_alimento" class="form-control" required value="<?= isset($tipo) ? htmlspecialchars($tipo) : '' ?>" placeholder="Ex: Frutas, Pães, Marmitas">
          </div>
 
          <div class="mb-3">
            <label class="form-label">Quantidade</label>
            <input name="quantidade" class="form-control" value="<?= isset($quantidade) ? htmlspecialchars($quantidade) : '' ?>" placeholder="Ex: 5 kg, 10 unidades">
          </div>
 
          <div class="mb-3">
            <label class="form-label">Validade / Disponibilidade</label>
            <input type="date" name="validade" class="form-control" value="<?= isset($validade) ? htmlspecialchars($validade) : '' ?>">
          </div>
 
          <div class="mb-3">
            <label class="form-label">Endereço / Local de retirada</label>
            <input name="endereco" class="form-control" value="<?= isset($endereco) ? htmlspecialchars($endereco) : '' ?>">
          </div>
 
          <div class="mb-3">
            <label class="form-label">Contato (telefone, WhatsApp, e-mail)</label>
            <input name="contato" class="form-control" value="<?= isset($contato) ? htmlspecialchars($contato) : '' ?>">
          </div>
 
          <button class="btn btn-success">Cadastrar</button>
          <a class="btn btn-secondary" href="listar.php">Cancelar</a>
        </form>
 
      </div>
    </div>
  </div>
</body>
</html>