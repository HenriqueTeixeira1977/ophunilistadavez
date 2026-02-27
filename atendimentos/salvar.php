
<?php
date_default_timezone_set('America/Sao_Paulo');
include '../config/database.php';

$vendedor_id = $_POST['vendedor_id'];
$cliente = $_POST['cliente'];
$valor = $_POST['valor'];
$quantidade = $_POST['quantidade'];
$resultado = $_POST['resultado'];
$obs = $_POST['obs'];

// 1️⃣ Inserir atendimento
$conn->query("
INSERT INTO atendimentos 
(vendedor_id, cliente, valor, quantidade, resultado, observacoes)
VALUES 
($vendedor_id, '$cliente', '$valor', '$quantidade', '$resultado', '$obs')
");

// 2️⃣ Rotacionar fila
$max = $conn->query("
SELECT MAX(posicao) as max FROM fila
")->fetch_assoc()['max'];

$conn->query("
UPDATE fila SET posicao = $max + 1 
WHERE vendedor_id = $vendedor_id
");

// 3️⃣ Reorganizar posições
$reordenar = $conn->query("
SELECT id FROM fila ORDER BY posicao ASC
");

$contador = 1;
while($linha = $reordenar->fetch_assoc()){
    $conn->query("
    UPDATE fila SET posicao = $contador 
    WHERE id = {$linha['id']}
    ");
    $contador++;
}

header("Location: registrado.php");