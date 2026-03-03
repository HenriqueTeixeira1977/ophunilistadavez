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

    // Remove da lista
    $conn->query("UPDATE vendedores SET na_lista = 0 WHERE id = $id");

    // Remove da fila
    $conn->query("DELETE FROM fila WHERE vendedor_id = $id");

    // Reorganiza posições
    $posicoes = $conn->query("SELECT id FROM fila ORDER BY posicao ASC");

    $novaPos = 1;
    while($f = $posicoes->fetch_assoc()){
        $conn->query("UPDATE fila SET posicao = $novaPos WHERE id = {$f['id']}");
        $novaPos++;
    }

}

if($acao === 'adicionar'){

    $conn->query("UPDATE vendedores SET na_lista = 1 WHERE id = $id");

    // Coloca no final da fila
    $ultima = $conn->query("SELECT MAX(posicao) as max FROM fila")->fetch_assoc();
    $novaPos = ($ultima['max'] ?? 0) + 1;

    $conn->query("INSERT INTO fila (vendedor_id, posicao) VALUES ($id, $novaPos)");
}

header("Location: index.php");
exit;