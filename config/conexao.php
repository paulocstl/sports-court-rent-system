<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "aluguel_quadras";

$conn = new mysqli($servername, $username, $password, $dbname, 3306);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");