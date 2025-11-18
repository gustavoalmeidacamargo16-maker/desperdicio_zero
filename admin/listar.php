<?php
require 'db.php';
 
// Filtros simples por tipo, cidade/bairro (endereco) e data
$w = [];
$params = [];
 
if (!empty($_GET['tipo'])) {
    $w[] = 'tipo_alimento LIKE ?';
    $params[] = '%' . $_GET['tipo'] . '%';
}
if (!empty($_GET['endereco'])) {
    $w[] = 'endereco LIKE ?';
    $params[] = '%' . $_GET['endereco'] . '%';
}
if (!empty($_GET['data'])) {
    $w[] = 'DATE(criado_em) = ?';
    $params[] = $_GET['data'];
}
 
$sql = 'SELECT * FROM doacoes';
if ($w) $sql .= ' WHERE ' . implode(' AND ', $w);
$sql .= ' ORDER BY criado_em DESC';
 
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$doacoes = $stmt->fetchAll();
 
$msg = $_GET['msg'] ?? '';
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Lista de Doações</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-4">
    <div class="d-flex mb-3">
      <a href="index.html" class="btn btn-link">&larr; Início</a>
      <a href="cadastrar.php" class="btn btn-success ms-auto">Nova doação</a>
    </div>
 
    <?php if ($msg === 'criado'): ?>
      <div class="alert alert-success">Doação cadastrada com sucesso.</div>
    <?php endif; ?>
 
    <div class="card mb-3">
      <div class="card-body">
        <form class="row g-2" method="get">
          <div class="col-md-4"><input name="tipo" placeholder="Tipo de alimento" class="form-control" value="<?= htmlspecialchars($_GET['tipo'] ?? '') ?>"></div>
          <div class="col-md-4"><input name="endereco" placeholder="Cidade / bairro" class="form-control" value="<?= htmlspecialchars($_GET['endereco'] ?? '') ?>"></div>
          <div class="col-md-3"><input type="date" name="data" class="form-control" value="<?= htmlspecialchars($_GET['data'] ?? '') ?>"></div>
          <div class="col-md-1"><button class="btn btn-primary w-100">Filtrar</button></div>
        </form>
      </div>
    </div>
 
    <?php if (count($doacoes) === 0): ?>
      <div class="alert alert-info">Nenhuma doação encontrada.</div>
    <?php else: ?>
      <div class="row">
        <?php foreach ($doacoes as $d): ?>
          <div class="col-md-6">
            <div class="card mb-3">
              <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($d['tipo_alimento']) ?> <small class="text-muted">— <?= htmlspecialchars($d['quantidade']) ?></small></h5>
                <p class="mb-1"><strong>Doador:</strong> <?= htmlspecialchars($d['nome_doador']) ?></p>
                <p class="mb-1"><strong>Retirada:</strong> <?= htmlspecialchars($d['endereco']) ?></p>
                <p class="mb-1"><strong>Contato:</strong> <?= htmlspecialchars($d['contato']) ?></p>
                <p class="mb-1"><strong>Status:</strong> <?= htmlspecialchars($d['status']) ?></p>
                <div class="mt-2">
                  <a class="btn btn-sm btn-outline-primary" href="editar.php?id=<?= $d['id'] ?>">Ver / Editar</a>
                  <a class="btn btn-sm btn-outline-danger" href="excluir.php?id=<?= $d['id'] ?>" onclick="return confirm('Deseja realmente excluir?')">Excluir</a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
 
  </div>
</body>
</html>
