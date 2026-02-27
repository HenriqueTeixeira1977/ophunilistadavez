<?php
include '../../config/database.php';

$id = $_GET['id'];

// pegar maior posição apenas dos ativos
$max = $conn->query("
    SELECT MAX(f.posicao) as ultima
    FROM fila f
    JOIN vendedores v ON f.vendedor_id = v.id
    WHERE v.status='ativo'
")->fetch_assoc()['ultima'];

// mover para última posição
$conn->query("
    UPDATE fila 
    SET posicao = $max 
    WHERE vendedor_id = $id
");

// reorganizar apenas ativos
$conn->query("
    SET @pos := 0;
");

$conn->query("
    UPDATE fila f
    JOIN vendedores v ON f.vendedor_id = v.id
    SET f.posicao = (@pos := @pos + 1)
    WHERE v.status='ativo'
    ORDER BY f.posicao
");

header("Location: index.php");