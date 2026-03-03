<?php

var_dump($_GET);
exit;


require_once '../../config/database.php';
require_once '../../includes/auth.php';

if(!isAdmin()){
    header("Location: ../../dashboard.php");
    exit;
}

$id = intval($_GET['id']);
$acao = $_GET['acao'] ?? '';

if($acao === 'remover'){
    $stmt = $conn->prepare("UPDATE vendedores SET na_lista = 0 WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

if($acao === 'adicionar'){
    $stmt = $conn->prepare("UPDATE vendedores SET na_lista = 1 WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: index.php");
exit;