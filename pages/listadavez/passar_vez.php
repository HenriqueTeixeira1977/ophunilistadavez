<?php
include '../../config/database.php';

$id = $_GET['id'];

// Pega posição atual
$atual = $conn->query("
    SELECT posicao FROM fila WHERE vendedor_id = $id
")->fetch_assoc()['posicao'];

// Pega última posição
$ultima = $conn->query("
    SELECT MAX(posicao) as max FROM fila
")->fetch_assoc()['max'];

// Move para última
$conn->query("
    UPDATE fila 
    SET posicao = $ultima + 1
    WHERE vendedor_id = $id
");

// Reorganiza sequencial
$conn->query("SET @p = 0");

$conn->query("
    UPDATE fila 
    SET posicao = (@p := @p + 1)
    ORDER BY posicao
");

header("Location: index.php");