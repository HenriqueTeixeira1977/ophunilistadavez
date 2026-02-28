<?php
require_once 'config/database.php';

$id = $_POST['id'];
$cliente = $_POST['cliente'];
$valor = $_POST['valor'];
$quantidade = $_POST['quantidade'];
$resultado = $_POST['resultado'];

$conn->query("
UPDATE atendimentos SET
cliente = '$cliente',
valor = '$valor',
quantidade = '$quantidade',
resultado = '$resultado'
WHERE id = $id
");

header("Location: atendimentos.php");