<?php
require_once __DIR__ . '../../config/database.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../index.php");
    exit;
}

$id = $_GET['id'] ?? 0;

$stmt = $pdo->prepare("DELETE FROM templates_whatsapp WHERE id = :id");
$stmt->execute([':id' => $id]);

header("Location: templates.php?excluido=1");
exit;