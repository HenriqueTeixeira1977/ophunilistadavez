<?php
require_once '../../includes/header.php';

if(!isAdmin()){
    header("Location: ../vendedor_dashboard.php");
    exit;
}

$metas = [
[3290,3948,14,7,12],[2590,3108,12,6,10],[2240,2688,10,5,8],
[2380,2856,10,5,9],[2660,3192,12,6,10],[3500,4200,16,8,13],
[5740,6888,26,13,22],[3640,4368,16,8,14],[2100,2520,10,5,8],
[1890,2268,8,4,7],[1540,1848,6,3,6],[1820,2184,8,4,7],
[2450,2940,10,5,9],[3500,4200,16,8,13],[2100,2520,10,5,8],
[2380,2856,10,5,9],[1820,2184,8,4,7],[1750,2100,8,4,7],
[1680,2016,8,4,6],[2380,2856,10,5,9],[4340,5208,20,10,16],
[2450,2940,10,5,9],[1400,1680,6,3,5],[1330,1596,6,3,5],
[1540,1848,6,3,6],[1680,2016,8,4,6],[2310,2772,10,5,9],
[3500,4200,16,8,13],
];

$totalVendas = $totalMais20 = $totalAt = $totalConv = $totalPecas = 0;

foreach($metas as $m){
    $totalVendas += $m[0];
    $totalMais20 += $m[1];
    $totalAt += $m[2];
    $totalConv += $m[3];
    $totalPecas += $m[4];
}

$mediaVendas = $totalVendas / count($metas);
$taxaConversao = ($totalConv/$totalAt)*100;
?>

<style>
    .card-modern{
        background: linear-gradient(145deg,#1e293b,#0f172a);
        border:none;
        border-radius:16px;
        color:white;
        transition:0.3s;
    }
    .card-modern:hover{
        transform: translateY(-4px);
        box-shadow:0 8px 25px rgba(0,0,0,0.4);
    }
    .highlight{
        background: linear-gradient(135deg,#2563eb,#1d4ed8);
    }
    .progress{
        height:8px;
        background:#1e293b;
    }
    .progress-bar{
        background: linear-gradient(90deg,#22c55e,#16a34a);
    }
    .table-modern{
        border-radius:12px;
        overflow:hidden;
    }
</style>

<h3 class="mb-4">🎯 Planejamento Estratégico de Metas</h3>

<!-- RESUMO PRINCIPAL -->
<div class="row g-4 mb-4">
    <div class="col-lg-4">
        <div class="card-modern p-4">
            <small class="text-secondary">Meta Total do Mês</small>
            <h3 class="text-success">
                R$ <?= number_format($totalVendas,2,',','.') ?>
            </h3>
            <div class="progress mt-2">
                <div class="progress-bar" style="width:100%"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card-modern highlight p-4">
            <small>Meta Agressiva (+20%)</small>
            <h3>
                R$ <?= number_format($totalMais20,2,',','.') ?>
            </h3>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card-modern p-4">
            <small class="text-secondary">Média Diária</small>
            <h3>
                R$ <?= number_format($mediaVendas,2,',','.') ?>
            </h3>
        </div>
    </div>
</div>

<!-- METAS OPERACIONAIS -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card-modern text-center p-3">
            <small>Atendimentos</small>
            <h4><?= $totalAt ?></h4>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card-modern text-center p-3">
            <small>Convertidos</small>
            <h4><?= $totalConv ?></h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-modern text-center p-3">
            <small>Peças</small>
            <h4><?= $totalPecas ?></h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-modern text-center p-3">
            <small>TXC Esperada</small>
            <h4><?= number_format($taxaConversao,1) ?>%</h4>
        </div>
    </div>
</div>

<!-- TABELA DETALHADA -->

<div class="card-modern p-4 table-modern">
    <h5 class="mb-3">📅 Meta Diária Detalhada</h5>
    <div class="table-responsive">
        <table class="table table-dark align-middle mb-0">
            <thead>
                <tr>
                <th>Dia</th>
                <th>Meta</th>
                <th>+20%</th>
                <th>At</th>
                <th>Conv</th>
                <th>Peças</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($metas as $index => $m): ?>
                    <tr>
                        <td><?= $index+1 ?></td>
                        <td class="text-success">R$ <?= number_format($m[0],2,',','.') ?></td>
                        <td class="text-warning">R$ <?= number_format($m[1],2,',','.') ?></td>
                        <td><?= $m[2] ?></td>
                        <td><?= $m[3] ?></td>
                        <td><?= $m[4] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>