<?php
require_once '../../includes/header.php';

if(!isAdmin()){
    header("Location: ../vendedor_dashboard.php");
    exit;
}

$mes = $_GET['mes'] ?? date('m');
$ano = $_GET['ano'] ?? date('Y');

$primeiroDia = "$ano-$mes-01";
$ultimoDia = date("Y-m-t", strtotime($primeiroDia));
$diasNoMes = date("t", strtotime($primeiroDia));
?>

<?php
$vendedores = $conn->query("
    SELECT id, nome 
    FROM vendedores 
    WHERE ativo = 1 
    ORDER BY nome
");
?>

<?php
$presencas = [];

$sqlPresencas = $conn->query("
    SELECT vendedor_id, data, status
    FROM presencas
    WHERE data BETWEEN '$primeiroDia' AND '$ultimoDia'
");

while($p = $sqlPresencas->fetch_assoc()){
    $presencas[$p['vendedor_id']][$p['data']] = $p['status'];
}
?>


<div class="container py-4">

    <h3 class="mb-4">📅 Controle de Presenças - <?= "$mes/$ano" ?></h3>

    <div class="table-responsive">
        <table class="table table-bordered text-center align-middle">

            <thead class="table-dark">
                <tr>
                    <th>Vendedor</th>
                    <?php for($d=1; $d <= $diasNoMes; $d++): ?>
                        <th><?= $d ?></th>
                    <?php endfor; ?>
                </tr>
            </thead>

             <tbody>

                    <?php while($v = $vendedores->fetch_assoc()): ?>
                    <tr>
                        <td class="fw-bold"><?= $v['nome'] ?></td>

                        <?php for($d=1; $d <= $diasNoMes; $d++): 

                            $data = sprintf('%04d-%02d-%02d', $ano, $mes, $d);
                            $status = $presencas[$v['id']][$data] ?? '';

                            $cor = match($status){
                                'trabalhou' => 'bg-success',
                                'folga' => 'bg-info',
                                'falta' => 'bg-danger',
                                'ferias' => 'bg-warning',
                                'atestado' => 'bg-secondary',
                                default => ''
                            };
                        ?>

                        <td>
                            <form method="POST" action="salvar_presenca.php">
                                <input type="hidden" name="vendedor_id" value="<?= $v['id'] ?>">
                                <input type="hidden" name="data" value="<?= $data ?>">

                                <select name="status" 
                                        class="form-select form-select-sm <?= $cor ?>"
                                        onchange="this.form.submit()">

                                    <option value="">-</option>
                                    <option value="trabalhou" <?= $status=='trabalhou'?'selected':'' ?>>TRABALHOU</option>
                                    <option value="folga" <?= $status=='folga'?'selected':'' ?>>FOLGA</option>
                                    <option value="falta" <?= $status=='falta'?'selected':'' ?>>FALTA</option>
                                    <option value="ferias" <?= $status=='ferias'?'selected':'' ?>>FERIAS</option>
                                    <option value="atestado" <?= $status=='atestado'?'selected':'' ?>>ATESTADO</option>
                                </select>
                            </form>
                        </td>

                        <?php endfor; ?>
                    </tr>
                <?php endwhile; ?>

            </tbody>
        </table>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>