<?php
require_once '../../config/database.php';
session_start();

if(!isAdmin()) exit;

$id = $_GET['id'];
$acao = $_GET['acao'];

if($acao == 'ativar'){
    $conn->query("UPDATE vendedores SET ativo = 1 WHERE id = $id");
}

if($acao == 'desativar'){
    $conn->query("UPDATE vendedores SET ativo = 0 WHERE id = $id");
}

header("Location: index.php");
exit;