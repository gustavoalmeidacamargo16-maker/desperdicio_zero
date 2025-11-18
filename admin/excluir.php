<?php
require 'db.php';
$id = (int)($_GET['id'] ?? 0);
if ($id > 0) {
    $stmt = $pdo->prepare('DELETE FROM doacoes WHERE id = ?');
    $stmt->execute([$id]);
}
header('Location: listar.php?msg=excluido');
exit;