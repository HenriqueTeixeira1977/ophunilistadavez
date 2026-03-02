<?php
require_once '../../config/database.php';
session_start();

if(!isset($_POST['vendedor_id'])) exit;

$vendedor_id = $_POST['vendedor_id'];
$data = $_POST['data'];
$status = $_POST['status'];

$conn->query("
    INSERT INTO presencas (vendedor_id, data, status)
    VALUES ('$vendedor_id', '$data', '$status')
    ON DUPLICATE KEY UPDATE status='$status'
");

header("Location: presencas.php?mes=".date('m',strtotime($data))."&ano=".date('Y',strtotime($data)));
exit;