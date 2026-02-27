<?php
require_once '../../includes/header.php';

if(!isAdmin()){
    header("Location: index.php");
    exit;
}
$id = $_GET['id'];
$acao = $_GET['acao'];

if($acao == 'pausar'){

    // coloca como inativo
    $conn->query("UPDATE vendedores SET status='inativo' WHERE id=$id");

}

if($acao == 'ativar'){

    // ativa vendedor
    $conn->query("UPDATE vendedores SET status='ativo' WHERE id=$id");

    // pega última posição atual
    $ultima = $conn->query("
        SELECT MAX(posicao) as max FROM fila
    ")->fetch_assoc()['max'];

    // coloca ele na última posição
    $conn->query("
        UPDATE fila 
        SET posicao = $ultima + 1
        WHERE vendedor_id = $id
    ");

    // reorganiza fila
    $conn->query("SET @p = 0");

    $conn->query("
        UPDATE fila
        SET posicao = (@p := @p + 1)
        ORDER BY posicao
    ");
}

header("Location: index.php");