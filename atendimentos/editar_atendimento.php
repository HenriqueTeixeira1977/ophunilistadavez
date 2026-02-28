<?php
require_once '/../config/database.php';

$usuario_id = $_SESSION['usuario_id'] ?? null;
$tipo = $_SESSION['tipo'] ?? 'vendedor';

/* ======================
   FILTRO POR PERFIL
====================== */

if($tipo == 'admin'){
    $sql = "
    SELECT a.*, v.nome as vendedor 
    FROM atendimentos a
    JOIN vendedores v ON v.id = a.vendedor_id
    ORDER BY a.data DESC
    ";
} else {
    $sql = "
    SELECT a.*, v.nome as vendedor 
    FROM atendimentos a
    JOIN vendedores v ON v.id = a.vendedor_id
    WHERE a.vendedor_id = $usuario_id
    ORDER BY a.data DESC
    ";
}

$result = $conn->query($sql);
?>

<?php require_once 'includes/header.php'; ?>

<div class="container py-4">

    <h3 class="fw-bold mb-4">📋 Lista de Atendimentos</h3>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th>Data</th>
                            <th>Vendedor</th>
                            <th>Cliente</th>
                            <th>Valor</th>
                            <th>Qtd</th>
                            <th>Resultado</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= date('d/m/Y H:i', strtotime($row['data'])) ?></td>
                            <td><?= $row['vendedor'] ?></td>
                            <td><?= $row['cliente'] ?></td>
                            <td class="fw-bold text-success">
                                R$ <?= number_format($row['valor'],2,',','.') ?>
                            </td>
                            <td><?= $row['quantidade'] ?></td>
                            <td><?= $row['resultado'] ?></td>

                            <td class="text-center">

                                <!-- BOTÃO EDITAR -->
                                <button class="btn btn-sm btn-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editarModal<?= $row['id'] ?>">
                                    ✏ Editar
                                </button>

                                <!-- BOTÃO DELETAR -->
                                <a href="deletar_atendimento.php?id=<?= $row['id'] ?>"
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Deseja realmente excluir?')">
                                    🗑 Deletar
                                </a>

                            </td>
                        </tr>

                        <!-- MODAL EDITAR -->
                        <div class="modal fade" id="editarModal<?= $row['id'] ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <form action="editar_atendimento.php" method="POST">

                                        <div class="modal-header">
                                            <h5 class="modal-title">Editar Atendimento</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">

                                            <input type="hidden" name="id" value="<?= $row['id'] ?>">

                                            <div class="mb-3">
                                                <label>Cliente</label>
                                                <input type="text" name="cliente" 
                                                    class="form-control"
                                                    value="<?= $row['cliente'] ?>">
                                            </div>

                                            <div class="mb-3">
                                                <label>Valor</label>
                                                <input type="number" step="0.01"
                                                    name="valor"
                                                    class="form-control"
                                                    value="<?= $row['valor'] ?>">
                                            </div>

                                            <div class="mb-3">
                                                <label>Quantidade</label>
                                                <input type="number"
                                                    name="quantidade"
                                                    class="form-control"
                                                    value="<?= $row['quantidade'] ?>">
                                            </div>

                                            <div class="mb-3">
                                                <label>Resultado</label>
                                                <select name="resultado" class="form-select">
                                                    <option <?= $row['resultado']=='Venda'?'selected':'' ?>>Venda</option>
                                                    <option <?= $row['resultado']=='Não comprou'?'selected':'' ?>>Não comprou</option>
                                                    <option <?= $row['resultado']=='Troca com diferença'?'selected':'' ?>>Troca com diferença</option>
                                                    <option <?= $row['resultado']=='Troca sem diferença'?'selected':'' ?>>Troca sem diferença</option>
                                                </select>
                                            </div>

                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-success">Salvar</button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>

                        <?php endwhile; ?>
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>

<?php require_once 'includes/footer.php'; ?>