<?php
require 'db.php';
 
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    header('Location: listar.php');
    exit;
}
 
// buscar registro
$stmt = $pdo->prepare('SELECT * FROM doacoes WHERE id = ?');
$stmt->execute([$id]);
$doacao = $stmt->fetch();
if (!$doacao) {
    header('Location: listar.php');
    exit;
}
 
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome_doador'] ?? '');
    $tipo = trim($_POST['tipo_alimento'] ?? '');
    $quantidade = trim($_POST['quantidade'] ?? '');
    $validade = $_POST['validade'] ?: null;
    $endereco = trim($_POST['endereco'] ?? '');
    $contato = trim($_POST['contato'] ?? '');
    $status = in_array($_POST['status'] ?? '', ['disponivel','entregue']) ? $_POST['status'] : 'disponivel';
 
    if ($nome === '' || $tipo === '') {
        $errors[] = 'Nome do doador e tipo de alimento são obrigatórios.';
    }
 
    if (empty($errors)) {
        $stmt = $pdo->prepare('UPDATE doacoes SET nome_doador=?, tipo_alimento=?, quantidade=?, validade=?, endereco=?, contato=?, status=? WHERE id=?');
        $stmt->execute([$nome, $tipo, $quantidade ?: null, $validade, $endereco ?: null, $contato ?: null, $status, $id]);
        header('Location: listar.php?msg=atualizado');
        exit;
    }
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Editar Doação</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-4">
    <a href="listar.php" class="btn btn-link">&larr; Voltar</a>
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Editar Doação #<?= $doacao['id'] ?></h4>
 
        <?php if (!empty($errors)): ?>
          <div class="alert alert-danger">
            <?php foreach ($errors as $e) echo htmlspecialchars($e) . '<br>'; ?>
          </div>
        <?php endif; ?>
 
        <form method="post">
          <div class="mb-3"><label class="form-label">Nome do doador</label>
            <input name="nome_doador" class="form-control" value="<?= htmlspecialchars($_POST['nome_doador'] ?? $doacao['nome_doador']) ?>"></div>
 
          <div class="mb-3"><label class="form-label">Tipo de alimento</label>
            <input name="tipo_alimento" class="form-control" value="<?= htmlspecialchars($_POST['tipo_alimento'] ?? $doacao['tipo_alimento']) ?>"></div>
 
          <div class="mb-3"><label class="form-label">Quantidade</label>
            <input name="quantidade" class="form-control" value="<?= htmlspecialchars($_POST['quantidade'] ?? $doacao['quantidade']) ?>"></div>
 
          <div class="mb-3"><label class="form-label">Validade</label>
            <input type="date" name="validade" class="form-control" value="<?= htmlspecialchars($_POST['validade'] ?? $doacao['validade']) ?>"></div>
 
          <div class="mb-3"><label class="form-label">Endereço</label>
            <input name="endereco" class="form-control" value="<?= htmlspecialchars($_POST['endereco'] ?? $doacao['endereco']) ?>"></div>
 
          <div class="mb-3"><label class="form-label">Contato</label>
            <input name="contato" class="form-control" value="<?= htmlspecialchars($_POST['contato'] ?? $doacao['contato']) ?>"></div>
 
          <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
              <option value="disponivel" <?= (($_POST['status'] ?? $doacao['status']) === 'disponivel') ? 'selected' : '' ?>>disponivel</option>
              <option value="entregue" <?= (($_POST['status'] ?? $doacao['status']) === 'entregue') ? 'selected' : '' ?>>entregue</option>
            </select>
          </div>
 
          <button class="btn btn-primary">Salvar</button>
          <a class="btn btn-secondary" href="listar.php">Cancelar</a>
        </form>
      </div>
    </div>
  </div>
</body>
</html>