<?php
require_once '../config/database.php';

// Guarda nome antes de destruir
$nome = $_SESSION['usuario_nome'] ?? '';

// Destrói sessão
$_SESSION = [];
session_destroy();

// Redireciona para página de saída
header("Location: ../exitpage.php?nome=" . urlencode($nome));
exit;