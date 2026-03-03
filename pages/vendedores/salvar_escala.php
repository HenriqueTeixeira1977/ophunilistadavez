<?php
require_once '../../config/database.php';

$vendedor_id = intval($_POST['vendedor_id']);
$dia_semana = intval($_POST['dia_semana']);
$trabalha = intval($_POST['trabalha']);

$conn->query("
    INSERT INTO escala_vendedores (vendedor_id, dia_semana, trabalha)
    VALUES ($vendedor_id, $dia_semana, $trabalha)
    ON DUPLICATE KEY UPDATE trabalha = $trabalha
");

header("Location: escala.php?vendedor=$vendedor_id");
exit;