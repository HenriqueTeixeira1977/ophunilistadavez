<?php
require_once '../../includes/header.php';

// Apenas admin acessa
if(!isAdmin()){
    header("Location: ../vendedor_dashboard.php");
    exit;
}

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
WHERE MONTH(a.data_atendimento) = '$mesAtual'
AND YEAR(a.data_atendimento) = '$anoAtual'
GROUP BY v.id
ORDER BY faturamento DESC
");

$ranking = [];

while($row = $sql->fetch_assoc()){
    $row['tkm'] = ($row['convertidos'] > 0) 
        ? $row['faturamento'] / $row['convertidos'] 
        : 0;

    $row['txc'] = ($row['atendimentos'] > 0)
        ? ($row['convertidos'] / $row['atendimentos']) * 100
        : 0;

    $ranking[] = $row;
}
?>

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

<h4 class="text-success">
R$ <?= number_format($ranking[$i]['faturamento'],2,',','.') ?>
</h4>

<p class="text-secondary">
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
<th>Faturamento</th>
<th>A.T</th>
<th>C.C</th>
<th>TXC</th>
<th>Peças</th>
<th>TKM</th>
</tr>
</thead>
<tbody>

<?php foreach($ranking as $index => $v): ?>

<tr>
<td><?= $index+1 ?></td>
<td><?= $v['nome'] ?></td>
<td class="text-success">
R$ <?= number_format($v['faturamento'],2,',','.') ?>
</td>
<td><?= $v['atendimentos'] ?></td>
<td><?= $v['convertidos'] ?></td>
<td>
<span class="badge bg-<?= $v['txc']>=50?'success':($v['txc']>=30?'warning':'danger') ?>">
<?= number_format($v['txc'],1) ?>%
</span>
</td>
<td><?= $v['pecas'] ?></td>
<td>R$ <?= number_format($v['tkm'],2,',','.') ?></td>
</tr>

<?php endforeach; ?>

</tbody>
</table>

</div>
</div>

<?php require_once '../../includes/footer.php'; ?>