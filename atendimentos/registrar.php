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
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Registrar Atendimento</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-lg-6">

            <div class="card shadow-lg border-0 rounded-4">

                <!-- Cabeçalho -->
                <div class="card-header bg-dark text-white text-center rounded-top-4">
                    <h4 class="mb-1">📝 Registrar Atendimento</h4>
                    <small>Controle de Performance</small>
                </div>

                <div class="card-body p-4">

                    <!-- Destaque do vendedor -->
                    <div class="text-center mb-4">
                        <h5 class="fw-bold text-primary mb-1">
                            <?= $vendedor['nome']; ?>
                        </h5>
                        <span class="badge bg-success">Atendimento em andamento</span>
                    </div>

                    <form action="salvar.php" method="POST">
                        <input type="hidden" name="vendedor_id" value="<?= $vendedor_id ?>">

                        <!-- Cliente -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">👤 Nome do Cliente</label>
                            <input type="text" name="cliente" 
                                   class="form-control form-control-lg rounded-3" required>
                        </div>

                        <!-- Valor -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">💰 Valor da Venda (R$)</label>
                            <input type="number" step="0.01" name="valor" 
                                   class="form-control form-control-lg rounded-3" 
                                   value="0" required>
                        </div>

                        <!-- Peças -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">👕 Quantidade de Peças</label>
                            <input type="number" name="quantidade" 
                                   class="form-control rounded-3" 
                                   value="1" min="0" required>
                        </div>

                        <!-- Resultado -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">📊 Resultado</label>
                            <select name="resultado" 
                                    class="form-select rounded-3" required>
                                <option value="Venda">Venda</option>
                                <option value="Não comprou">Não comprou</option>
                                <option value="Troca com dinheiro">Troca com diferença</option>
                                <option value="Troca sem diferenca">Troca sem diferença</option>
                            </select>
                        </div>

                        <!-- Observações -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">🗒 Observações</label>
                            <textarea name="obs" 
                                      class="form-control rounded-3" 
                                      rows="3"></textarea>
                        </div>

                        <!-- Botões -->
                        <div class="d-grid gap-2">

                            <button type="submit" 
                                    class="btn btn-success btn-lg rounded-3">
                                ✅ Salvar Atendimento
                            </button>

                            <a href="../vendedor_dashboard.php" 
                               class="btn btn-outline-secondary rounded-3">
                                ↩ Cancelar
                            </a>

                        </div>

                    </form>

                </div>
            </div>

            <!-- Rodapé discreto -->
            <p class="text-center text-muted mt-3 small">
                Sistema de Gestão Ophicina
            </p>

        </div>
    </div>

</div>

</body>
</html>