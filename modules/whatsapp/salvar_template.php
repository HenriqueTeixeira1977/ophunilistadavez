<?php
require_once __DIR__ . '/../../config/database.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../index.php");
    exit;
}

$id = $_POST['id'] ?? null;
$nome = trim($_POST['nome'] ?? '');
$tipo = trim($_POST['tipo'] ?? 'manual');
$mensagem = trim($_POST['mensagem'] ?? '');
$ativo = isset($_POST['ativo']) ? 1 : 1;

if (!$nome || !$mensagem) {
    header("Location: templates.php?erro=1");
    exit;
}

if ($id) {
    $sql = "UPDATE templates_whatsapp SET
                nome = :nome,
                tipo = :tipo,
                mensagem = :mensagem,
                ativo = :ativo
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nome' => $nome,
        ':tipo' => $tipo,
        ':mensagem' => $mensagem,
        ':ativo' => $ativo,
        ':id' => $id
    ]);
} else {
    $sql = "INSERT INTO templates_whatsapp (nome, tipo, mensagem, ativo)
            VALUES (:nome, :tipo, :mensagem, :ativo)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nome' => $nome,
        ':tipo' => $tipo,
        ':mensagem' => $mensagem,
        ':ativo' => $ativo
    ]);
}

header("Location: templates.php?sucesso=1");
exit;