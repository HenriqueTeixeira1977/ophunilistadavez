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
$nome_conexao = trim($_POST['nome_conexao'] ?? '');
$provider = trim($_POST['provider'] ?? 'zapi');
$instance_id = trim($_POST['instance_id'] ?? '');
$token = trim($_POST['token'] ?? '');
$client_token = trim($_POST['client_token'] ?? '');
$telefone_remetente = trim($_POST['telefone_remetente'] ?? '');
$ativo = isset($_POST['ativo']) ? 1 : 0;

if ($id) {
    $sql = "UPDATE config_whatsapp SET
                nome_conexao = :nome_conexao,
                provider = :provider,
                instance_id = :instance_id,
                token = :token,
                client_token = :client_token,
                telefone_remetente = :telefone_remetente,
                ativo = :ativo
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nome_conexao' => $nome_conexao,
        ':provider' => $provider,
        ':instance_id' => $instance_id,
        ':token' => $token,
        ':client_token' => $client_token,
        ':telefone_remetente' => $telefone_remetente,
        ':ativo' => $ativo,
        ':id' => $id
    ]);
} else {
    $sql = "INSERT INTO config_whatsapp
            (nome_conexao, provider, instance_id, token, client_token, telefone_remetente, ativo)
            VALUES
            (:nome_conexao, :provider, :instance_id, :token, :client_token, :telefone_remetente, :ativo)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nome_conexao' => $nome_conexao,
        ':provider' => $provider,
        ':instance_id' => $instance_id,
        ':token' => $token,
        ':client_token' => $client_token,
        ':telefone_remetente' => $telefone_remetente,
        ':ativo' => $ativo
    ]);
}

header("Location: config.php?sucesso=1");
exit;