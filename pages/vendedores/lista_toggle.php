<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';

if(!isAdmin()){
    header("Location: ../../dashboard.php");
    exit;
}

$id = intval($_GET['id']);
$acao = $_GET['acao'] ?? '';

if($acao === 'remover'){
    $valor = 0;
} elseif($acao === 'adicionar'){
    $valor = 1;
} else {
    header("Location: index.php");
    exit;
}

$stmt = $conn->prepare("UPDATE vendedores SET na_lista = ? WHERE id = ?");
$stmt->bind_param("ii", $valor, $id);
$stmt->execute();

header("Location: index.php");
exit;