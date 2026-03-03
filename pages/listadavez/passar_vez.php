<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';

if(!isset($_SESSION['usuario_id'])){
    header("Location: ../../index.php");
    exit;
}

// Buscar todos da fila ativos e na_lista
$fila = $conn->query("
    SELECT f.id, f.vendedor_id
    FROM fila f
    JOIN vendedores v ON f.vendedor_id = v.id
    WHERE v.ativo = 1 AND v.na_lista = 1
    ORDER BY f.posicao ASC
");

$ids = [];
while($row = $fila->fetch_assoc()){
    $ids[] = $row;
}

if(count($ids) > 1){

    // Remove primeiro
    $primeiro = array_shift($ids);

    // Coloca ele no final
    $ids[] = $primeiro;

    // Reorganiza posições
    $pos = 1;
    foreach($ids as $item){
        $conn->query("
            UPDATE fila 
            SET posicao = $pos 
            WHERE id = {$item['id']}
        ");
        $pos++;
    }
}

header("Location: index.php");
exit;