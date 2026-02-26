<?php
include '../../config/database.php';

$id = $_GET['id'];
$acao = $_GET['acao'];

if($acao == 'pausar'){
    $conn->query("UPDATE vendedores SET status='inativo' WHERE id=$id");
}

if($acao == 'ativar'){
    $conn->query("UPDATE vendedores SET status='ativo' WHERE id=$id");
}

header("Location: index.php");