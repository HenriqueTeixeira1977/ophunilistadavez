<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';

if(!isAdmin()){
    header("Location: ../../dashboard.php");
    exit;
}

$id = intval($_GET['id']);
$acao = $_GET['acao'] ?? '';

if($acao === 'ativar'){
    $stmt = $conn->prepare("UPDATE vendedores SET ativo = 1 WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

if($acao === 'desativar'){
    $stmt = $conn->prepare("UPDATE vendedores SET ativo = 0 WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: index.php");
exit;