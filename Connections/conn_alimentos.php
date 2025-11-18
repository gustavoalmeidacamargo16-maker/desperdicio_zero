<?php
// db.php
$host = '127.0.0.1';
$db   = 'desperdicio_zero';
$user = 'root';
$pass = ''; // coloque a senha se tiver
$charset = 'utf8mb4';
 
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];
 
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // Em produção não mostre o erro completo.
    exit('Erro na conexão com o banco: ' . $e->getMessage());
}