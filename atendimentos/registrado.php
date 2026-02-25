<?php
$nome = $_GET['nome'] ?? '';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Atendimento Registrado</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body{
        background: linear-gradient(135deg,#fff,#aaa);
        height:100vh;
        display:flex;
        align-items:center;
        justify-content:center;
        color:white;
    }
    .card{
        background:#ffffff;
        border:none;
        border-radius:15px;
    }
    .card h2 p{
        color: #f3f3f3;
    }
</style>

</head>
<body>

    <div class="card p-5 text-center shadow-lg">
        <h2 class="mb-3">REGISTRADO!!!<?= $nome ? ", $nome" : "" ?>!</h2>
        <p>Atendimento registrado com sucesso!!!</p>
        <p>Seu desempenho faz a diferença 🚀</p>
        <a href="../vendedor_dashboard.php" class="btn btn-primary mt-3">Volta para o inicio</a>
    </div>

</body>
</html>