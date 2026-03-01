<?php
require_once '../../includes/header.php';

// Apenas admin acessa
if(!isAdmin()){
    header("Location: ../vendedor_dashboard.php");
    exit;
}

/*  ========== FILTRO DE DATAS E DEZENAS ==========  */
$inicio = $_GET['inicio'] ?? date('Y-m-01');
$fim = $_GET['fim'] ?? date('Y-m-t');

if(isset($_GET['periodo'])){
    $ano = date('Y');
    $mes = date('m');
    $ultimoDia = date('t');

    if($_GET['periodo'] == 'dezena1'){
        $inicio = "$ano-$mes-01";
        $fim = "$ano-$mes-10";
    }

    if($_GET['periodo'] == 'dezena2'){
        $inicio = "$ano-$mes-11";
        $fim = "$ano-$mes-20";
    }

    if($_GET['periodo'] == 'dezena3'){
        $inicio = "$ano-$mes-21";
        $fim = "$ano-$mes-$ultimoDia";
    }
}


/*  ========== QUERIES CALCULO DE METAS ==========  */
$metaPeriodo = $conn->query("
    SELECT SUM(meta_vendas) as meta_total
    FROM metas_diarias
    WHERE DATE(data_meta) BETWEEN '$inicio' AND '$fim'
")
->fetch_assoc()['meta_total'] ?? 0;



/*  ========== QUERIES PRINCIPAIS ==========  */
$mesAtual = date('m');
$anoAtual = date('Y');

$sql = $conn->query("
SELECT 
    v.nome,
    SUM(CASE WHEN a.resultado='Venda' THEN a.valor ELSE 0 END) as faturamento,
    COUNT(a.id) as atendimentos,
    SUM(CASE WHEN a.resultado='Venda' THEN 1 ELSE 0 END) as convertidos,
    SUM(a.quantidade) as pecas
FROM atendimentos a
JOIN vendedores v ON a.vendedor_id = v.id
WHERE DATE(a.data_atendimento) BETWEEN '$inicio' AND '$fim'
GROUP BY v.id
ORDER BY faturamento DESC
");

$ranking = [];

while($row = $sql->fetch_assoc()){

    $row['percentual_meta'] = ($metaPeriodo > 0)
        ? ($row['faturamento'] / $metaPeriodo) * 100
        : 0;

    $row['bateu_meta'] = $row['percentual_meta'] >= 100;

    $row['tkm'] = ($row['convertidos'] > 0) 
        ? $row['faturamento'] / $row['convertidos'] 
        : 0;

    $row['txc'] = ($row['atendimentos'] > 0)
        ? ($row['convertidos'] / $row['atendimentos']) * 100
        : 0;

    $row['pa'] = ($row['atendimentos'] > 0)
        ? $row['pecas'] / $row['atendimentos']
        : 0;

    $ranking[] = $row;
}?>





<!--  ========== BODY ==========  -->
<form method="GET" class="row g-2 mb-4">

    <div class="col-md-3">
        <input type="date" name="inicio" value="<?= $inicio ?>" class="form-control">
    </div>

    <div class="col-md-3">
        <input type="date" name="fim" value="<?= $fim ?>" class="form-control">
    </div>

    <div class="col-md-2">
        <button class="btn btn-primary w-100">Filtrar</button>
    </div>

    <div class="col-md-4 d-flex gap-2">
        <a href="?periodo=dezena1" class="btn btn-outline-secondary w-100">1ª Dezena</a>
        <a href="?periodo=dezena2" class="btn btn-outline-secondary w-100">2ª Dezena</a>
        <a href="?periodo=dezena3" class="btn btn-outline-secondary w-100">3ª Dezena</a>
    </div>

</form>  




<h3 class="mb-4">🏆 Ranking Comercial - <?= date('m/Y') ?></h3>

<!-- PÓDIO -->
<div class="row mb-4">

    <?php 
        $posicoes = ['🥇','🥈','🥉'];
        for($i=0; $i<3; $i++):
        if(isset($ranking[$i])):
    ?>

    <div class="col-md-4 mb-3">
        <div class="card text-center shadow-lg border-0"
            style="background:#7ac41177;">

            <div class="card-body">

                <h4><?= $posicoes[$i] ?></h4>

                <h5 class="mt-2"><?= $ranking[$i]['nome'] ?></h5>
                <?php if($ranking[$i]['bateu_meta']): ?>
                    <div class="badge bg-success mt-2">🎯 Meta Batida</div>
                        <?php else: ?>
                        <div class="badge bg-warning mt-2">
                            <?= number_format($ranking[$i]['percentual_meta'],1) ?>% da meta
                    </div>
                <?php endif; ?>

                <h4 class="text-success">
                    R$ <?= number_format($ranking[$i]['faturamento'],2,',','.') ?>
                </h4>

                <p class="text-secondary">
                    P.A: <?= number_format($ranking[$i]['pa'],2) ?> |
                    TXC: <?= number_format($ranking[$i]['txc'],1) ?>% |
                    TKM: R$ <?= number_format($ranking[$i]['tkm'],2,',','.') ?>
                </p>
            </div>
        </div>
    </div>

    <?php endif; endfor; ?>

</div>




<!-- TABELA COMPLETA -->

<div class="card shadow border-0" style="background:#1e293b;">
    <div class="card-body table-responsive">

        <table class="table table-dark table-hover align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Vendedor</th>
                    <th>Meta</th>
                    <th>Faturamento</th>
                    <th>A.T</th>
                    <th>C.C</th>
                    <th>Peças</th>
                    <th>P.A</th>
                    <th>TXC</th>
                    <th>TKM</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($ranking as $index => $v): ?>
                <tr class="<?= $v['bateu_meta'] ? 'table-success' : '' ?>">   
                <tr>
                    <td><?= $index+1 ?></td>
                    <td><?= $v['nome'] ?></td>
                    <td style="min-width:150px;">
                        <div class="progress" style="height:8px;">
                            <div class="progress-bar 
                                <?= $v['percentual_meta']>=100?'bg-success':
                                    ($v['percentual_meta']>=70?'bg-warning':'bg-danger') ?>"
                                style="width: <?= min($v['percentual_meta'],100) ?>%">
                            </div>
                        </div>
                        <small>
                            <?= number_format($v['percentual_meta'],1) ?>%
                        </small>
                    </td>
                    <td class="text-success">
                        R$ <?= number_format($v['faturamento'],2,',','.') ?>
                    </td>
                    <td><?= $v['atendimentos'] ?></td>
                    <td><?= $v['convertidos'] ?></td>
                    <td><?= $v['pecas'] ?></td>
                    <td><?= number_format($v['pa'],2) ?></td>
                    <td>
                        <span class="badge bg-<?= $v['txc']>=50?'success':($v['txc']>=30?'warning':'danger') ?>">
                            <?= number_format($v['txc'],1) ?>%
                        </span>
                    </td>
                    <td>R$ <?= number_format($v['tkm'],2,',','.') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>