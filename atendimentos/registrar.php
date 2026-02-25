<?php
include '../config/database.php';

if(!isset($_GET['id'])){
    die("Vendedor não informado.");
}

$vendedor_id = $_GET['id'];

$vendedor = $conn->query("
SELECT nome FROM vendedores WHERE id = $vendedor_id
")->fetch_assoc();

if(!$vendedor){
    die("Vendedor não encontrado.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registrar Atendimento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container-fluid">
    <h3 class="mb-4">Registrar Atendimento - <strong><?= $vendedor['nome']; ?></strong></h3>
    <form action="salvar.php" method="POST">
        <input type="hidden" name="vendedor_id" value="<?= $vendedor_id ?>">
        <div class="mb-3">
            <label class="form-label">Nome do Cliente</label>
            <input type="text" name="cliente" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Valor da Venda (R$)</label>
            <input type="number" step="0.01" name="valor" class="form-control" value="0" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Quantidade de Peças</label>
            <input type="number" name="quantidade" class="form-control" value="1" min="0" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Resultado</label>
            <select name="resultado" class="form-select" required>
                <option value="Venda">Venda</option>
                <option value="Não comprou">Não comprou</option>
                <option value="Troca com dinheiro">Troca com diferença</option>
                <option value="Troca sem diferenca">Troca sem diferença</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Observações</label>
            <textarea name="obs" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Salvar Atendimento</button>
        <a href="../vendedor_dashboard.php" class="btn btn-secondary">Cancelar</a>
    </form>
</body>
</html>