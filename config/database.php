<?php
date_default_timezone_set('America/Sao_Paulo');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = "localhost";
$user = "u783757499_ophunilistavez";
$pass = "OphUniListadaVez2026";
$db   = "u783757499_ophunilistavez";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}
