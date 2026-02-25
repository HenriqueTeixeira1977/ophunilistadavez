<?php
$nome = $_GET['nome'] ?? '';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Até logo 👋</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body{
        background: linear-gradient(135deg,#999,#1e293b);
        height:100vh;
        display:flex;
        align-items:center;
        justify-content:center;
        color:white;
    }
    .card{
        background:#000;
        border:none;
        border-radius:15px;
    }
    .card h2{
        color: #fff;
    }
</style>

</head>
<body>

<div class="card p-5 text-center shadow-lg">
    <h2 class="mb-3">👋 Até logo<?= $nome ? ", $nome" : "" ?>!</h2>
    <p class="text-secondary">
        Obrigado por utilizar o Sistema Lista da Vez OPHICINA.
    </p>
    <p class="text-secondary">
        Seu desempenho faz a diferença 🚀
    </p>
    <a href="login.php" class="btn btn-primary mt-3">Fazer login novamente</a>
</div>

</body>
</html>