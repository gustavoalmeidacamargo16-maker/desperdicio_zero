<?php
// Definindo variáveis para conexão
$hostname_conn  =   "localhost";
$database_conn  =   "desperdicio_zero";
$username_conn  =   "desperdicio_zero";
$password_conn  =   "senacti19";
$charset_conn   =   "utf8";

$conn_alimentos  =   
    new mysqli(
        $hostname_conn,
        $username_conn,
        $password_conn,
        $database_conn
    );
// Definir o conjunto de caracteres da conexão
mysqli_set_charset($conn_alimentos,$charset_conn);

// Verificando possíveis erros na conexão
if($conn_alimentos->connect_error){
    echo "Error: ".$conn_alimentos->connect_error;
};
// Não deixar espaços vazios depois do fechamento do PHP pois causa erro HEADER
?>