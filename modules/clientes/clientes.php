<?php
require_once '../../includes/header.php';
require_once __DIR__ . '../../config/database.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../index.php");
    exit;
}

$stmt = $pdo->query("
    SELECT 
        c.*,
        cw.optin_whatsapp,
        cw.categoria_interesse,
        cw.vendedor_responsavel
    FROM clientes c
    LEFT JOIN clientes_whatsapp_config cw ON cw.cliente_id = c.id
    ORDER BY c.id DESC
");

$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Clientes</h2>
        <a href="cadastrar_cliente.php" class="btn btn-primary">+ Novo Cliente</a>
    </div>

    <?php if (isset($_GET['sucesso'])): ?>
        <div class="alert alert-success">Operação realizada com sucesso!</div>
    <?php endif; ?>

    <?php if (isset($_GET['erro'])): ?>
        <div class="alert alert-danger">Ocorreu um erro na operação.</div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Telefone</th>
                        <th>Nascimento</th>
                        <th>Categoria Interesse</th>
                        <th>Vendedor</th>
                        <th>WhatsApp</th>
                        <th>Status</th>
                        <th width="180">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($clientes) > 0): ?>
                        <?php foreach ($clientes as $cliente): ?>
                            <tr>
                                <td><?= $cliente['id'] ?></td>
                                <td><?= htmlspecialchars($cliente['nome']) ?></td>
                                <td><?= htmlspecialchars($cliente['telefone']) ?></td>
                                <td>
                                    <?= !empty($cliente['data_nascimento']) ? date('d/m/Y', strtotime($cliente['data_nascimento'])) : '-' ?>
                                </td>
                                <td><?= htmlspecialchars($cliente['categoria_interesse'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($cliente['vendedor_responsavel'] ?? '-') ?></td>
                                <td>
                                    <?= isset($cliente['optin_whatsapp']) && $cliente['optin_whatsapp'] == 1 ? 'Autorizado' : 'Sem autorização' ?>
                                </td>
                                <td><?= $cliente['ativo'] == 1 ? 'Ativo' : 'Inativo' ?></td>
                                <td>
                                    <a href="editar_cliente.php?id=<?= $cliente['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                                    <a href="excluir_cliente.php?id=<?= $cliente['id'] ?>" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Deseja realmente excluir este cliente?')">
                                       Excluir
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center">Nenhum cliente cadastrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>