<?php
require_once '../../includes/header.php';
require_once __DIR__ . '/../../config/database.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if(!isset($_SESSION['usuario_id'])){
    header("Location: ../../index.php");
    exit;
}
?>

<?php
$fila = $conn->query("
    SELECT f.posicao, v.nome, v.id, v.status
    FROM fila f
    JOIN vendedores v ON f.vendedor_id = v.id
    WHERE v.ativo = 1
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
                        <tr class="<?= $row['posicao']==1 ? 'table-success fw-bold' : '' ?>">                       
                        
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

                            <!-- PASSAR (pode deixar para todos ou restringir se quiser) -->
                            <a href="passar_vez.php?id=<?= $row['id'] ?>"
                                class="btn btn-sm btn-warning">
                                🔄 Passar
                            </a>

                            <?php if(isAdmin()): ?>

                                <?php if($row['status']=='ativo'): ?>
                                    <a href="alterar_status.php?id=<?= $row['id'] ?>&acao=pausar"
                                        class="btn btn-sm btn-outline-danger">
                                        ⏸ Pausar
                                    </a>
                                <?php else: ?>
                                    <a href="alterar_status.php?id=<?= $row['id'] ?>&acao=ativar"
                                        class="btn btn-sm btn-outline-success">
                                        ▶ Habilitar
                                    </a>
                                <?php endif; ?>

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