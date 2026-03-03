<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';

if(!isAdmin()) exit;

$id = intval($_GET['id']);

$conn->query("DELETE FROM fila WHERE vendedor_id = $id");
$conn->query("DELETE FROM vendedores WHERE id = $id");

header("Location: index.php");
exit;