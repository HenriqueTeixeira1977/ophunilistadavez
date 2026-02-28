<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>




<?php
require_once '../config/database.php';

$usuario_id = $_SESSION['usuario_id'] ?? null;
$tipo = $_SESSION['tipo'] ?? 'vendedor';


/* ======================
   FILTRO POR PERÍODO
====================== */

$inicio = $_GET['inicio'] ?? date('Y-m-01');
$fim = $_GET['fim'] ?? date('Y-m-t');

$filtroData = "AND DATE(a.data_atendimento) BETWEEN '$inicio' AND '$fim'";


/* ======================
   FILTRO POR PERFIL
====================== */

if($tipo == 'admin'){

    $sql = "
    SELECT a.*, v.nome as vendedor 
    FROM atendimentos a
    JOIN vendedores v ON v.id = a.vendedor_id
    WHERE 1=1
    $filtroData
    ORDER BY a.data_atendimento DESC
    ";

} else {

    $sql = "
    SELECT a.*, v.nome as vendedor 
    FROM atendimentos a
    JOIN vendedores v ON v.id = a.vendedor_id
    WHERE a.vendedor_id = $usuario_id
    $filtroData
    ORDER BY a.data_atendimento DESC
    ";

}

$result = $conn->query($sql);
?>

<?php require_once '../includes/header.php'; ?>


<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <?php
            $ano = date('Y');
            $mes = date('m');
            $ultimoDia = date('t');

            $hoje = date('Y-m-d');
            $ontem = date('Y-m-d', strtotime('-1 day'));

            $dezena1_inicio = "$ano-$mes-01";
            $dezena1_fim    = "$ano-$mes-10";

            $dezena2_inicio = "$ano-$mes-11";
            $dezena2_fim    = "$ano-$mes-20";

            $dezena3_inicio = "$ano-$mes-21";
            $dezena3_fim    = "$ano-$mes-$ultimoDia";

            $mes_inicio = "$ano-$mes-01";
            $mes_fim    = "$ano-$mes-$ultimoDia";
        ?>

        <div class="mb-3 d-flex flex-wrap gap-2">

            <a href="?inicio=<?= $hoje ?>&fim=<?= $hoje ?>" 
            class="btn btn-outline-primary btn-sm">Hoje</a>

            <a href="?inicio=<?= $ontem ?>&fim=<?= $ontem ?>" 
            class="btn btn-outline-secondary btn-sm">Ontem</a>

            <a href="?inicio=<?= $dezena1_inicio ?>&fim=<?= $dezena1_fim ?>" 
            class="btn btn-outline-dark btn-sm">Dezena 1</a>

            <a href="?inicio=<?= $dezena2_inicio ?>&fim=<?= $dezena2_fim ?>" 
            class="btn btn-outline-dark btn-sm">Dezena 2</a>

            <a href="?inicio=<?= $dezena3_inicio ?>&fim=<?= $dezena3_fim ?>" 
            class="btn btn-outline-dark btn-sm">Dezena 3</a>

            <a href="?inicio=<?= $mes_inicio ?>&fim=<?= $mes_fim ?>" 
            class="btn btn-outline-success btn-sm">Mês Atual</a>

        </div>

        <form method="GET" class="row g-3 align-items-end">

            <div class="col-md-4">
                <label class="form-label">Data Inicial</label>
                <input type="date" name="inicio" 
                       value="<?= $inicio ?>" 
                       class="form-control">
            </div>

            <div class="col-md-4">
                <label class="form-label">Data Final</label>
                <input type="date" name="fim" 
                       value="<?= $fim ?>" 
                       class="form-control">
            </div>

            <div class="col-md-4">
                <button class="btn btn-dark w-100">
                    🔍 Filtrar
                </button>
            </div>

        </form>

    </div>
</div>



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
                            <td><?= date('d/m/Y H:i', strtotime($row['data_atendimento'])) ?></td>
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