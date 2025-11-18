<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "desperdicio_zero";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Erro ao conectar ao banco: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>
