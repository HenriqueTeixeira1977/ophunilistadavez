<!--
require_once '../../includes/header.php';

if (isAdmin()) {
    header("Location: /ophuni-listadavez/pages/listadavez/index.php");
    exit;
}
-->


<?php
require_once '../../includes/header.php';
include '../../config/database.php';

$fila = $conn->query("
    SELECT f.posicao, v.nome, v.id, v.status
    FROM fila f
    JOIN vendedores v ON f.vendedor_id = v.id
    ORDER BY f.posicao ASC
");
?>

<div class="container py-4">

    <h2 class="mb-4 fw-bold text-center">
        🎯 Lista da Vez - Ophicina
    </h2>

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body table-responsive">

            <table class="table align-middle text-center">

                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Vendedor</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while($row = $fila->fetch_assoc()): ?>
                    <tr class="<?= ($row['posicao']==1 && $row['status']=='ativo') ? 'table-success fw-bold' : '' ?>">
                        <td><?= $row['posicao'] ?></td>
                        <td>
                            <?= $row['nome'] ?>
                            <?php if($row['posicao']==1 && $row['status']=='ativo'): ?>
                               <span class="badge bg-success ms-2">NA VEZ</span>
                          <?php endif; ?>
                        </td>
                        <td>
                            <?php if($row['status']=='ativo'): ?>
                                <span class="badge bg-success">Ativo</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Inativo</span>
                            <?php endif; ?>
                        </td>
                        <td class="d-flex gap-2 justify-content-center flex-wrap">

                            <a href="../../atendimentos/registrar.php?id=<?= $row['id'] ?>"
                                class="btn btn-sm btn-primary">
                                📝 Atendimento
                            </a>

                            <?php if($row['posicao']==1 && $row['status']=='ativo'): ?>
                                <a href="passar_vez.php?id=<?= $row['id'] ?>"
                                    class="btn btn-sm btn-warning">
                                    🔄 Passar
                                </a>
                            <?php endif; ?>

                            <?php if($row['status']=='ativo'): ?>
                                <a href="alterar_status.php?id=<?= $row['id'] ?>&acao=pausar"
                                    class="btn btn-sm btn-outline-danger">
                                    ⏸ Pausar
                                </a>
                            <?php else: ?>
                                <a href="alterar_status.php?id=<?= $row['id'] ?>&acao=ativar"
                                    class="btn btn-sm btn-outline-success">
                                    ▶ Ativar
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include '../../includes/footer.php'; ?>