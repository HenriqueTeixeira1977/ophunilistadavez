<?php
require_once 'includes/header.php';

if (isAdmin()) {
    header("Location: dashboard.php");
    exit;
}
?>

<?php
$vendedor_id = $_SESSION['usuario_id'];

$mesAtual = date('m');
$anoAtual = date('Y');

if(!isset($_SESSION['usuario_id'])){
    header("Location: index.php");
    exit;
}

/* ============================
   MÉTRICAS INDIVIDUAIS
============================ */

$sql = "
SELECT 
COUNT(id) as AT,
SUM(CASE WHEN resultado = 'Venda' THEN 1 ELSE 0 END) as CC,
SUM(CASE WHEN resultado = 'Não comprou' THEN 1 ELSE 0 END) as CNC,
SUM(CASE WHEN resultado = 'Venda' THEN valor ELSE 0 END) as faturamento,
SUM(quantidade) as PCS
FROM atendimentos
WHERE vendedor_id = '$vendedor_id'
AND MONTH(data_atendimento) = '$mesAtual'
AND YEAR(data_atendimento) = '$anoAtual'
";

$dados = $conn->query($sql)->fetch_assoc();

$AT = $dados['AT'] ?? 0;
$CC = $dados['CC'] ?? 0;
$CNC = $dados['CNC'] ?? 0;
$faturamento = $dados['faturamento'] ?? 0;
$PCS = $dados['PCS'] ?? 0;
$PA = ($AT > 0) ? $PCS / $AT : 0;
$TKM = ($CC > 0) ? $faturamento / $CC : 0;
$TXC = ($AT > 0) ? ($CC / $AT) * 100 : 0;
$comissao = $faturamento * 0.01;

?>

<div class="container p-3">
    <h5 class="mb-3">📊 Meu Desempenho</h5>
    <?php
        $ranking = $conn->query("
        SELECT vendedor_id,
        SUM(CASE WHEN resultado='Venda' THEN valor ELSE 0 END) as total
        FROM atendimentos
        WHERE MONTH(data_atendimento)=MONTH(CURDATE())
        AND YEAR(data_atendimento)=YEAR(CURDATE())
        GROUP BY vendedor_id
        ORDER BY total DESC
        ");

        $posicao = 1;
        $minhaPosicao = 0;

        while($row = $ranking->fetch_assoc()){
            if($row['vendedor_id'] == $vendedor_id){
                $minhaPosicao = $posicao;
                break;
            }
            $posicao++;
        }
    ?>

    <div class="alert alert-info mt-3 text-center">
        🏆 Você está na posição <strong><?= $minhaPosicao ?>º</strong> no ranking mensal
    </div>
    <div class="row g-3">
        <div class="col-12 col-md-12">
            <div class="card shadow-sm border-0 text-center p-3">
                <small class="text-muted">Faturamento</small>
                <h5 class="fw-bold">R$ <?= number_format($faturamento,2,',','.') ?></h5>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm border-0 text-center p-3">
                <small class="text-muted">Comissão (1%)</small>
                <h5 class="fw-bold text-success">R$ <?= number_format($comissao,2,',','.') ?></h5>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm border-0 text-center p-3">
                <small class="text-muted">Atendimentos</small>
                <h5 class="fw-bold"><?= number_format($AT,0.) ?></h5>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm border-0 text-center p-3">
                <small class="text-muted">Convertidos</small>
                <h5 class="fw-bold"><?= number_format($CC,0.) ?></h5>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm border-0 text-center p-3">
                <small class="text-muted">Não Convertidos</small>
                <h5 class="fw-bold"><?= number_format($CNC,0.) ?></h5>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm border-0 text-center p-3">
                <small class="text-muted"> Taxa de Conversão</small>
                <h5 class="fw-bold"><?= number_format($TXC,1) ?>%</h5>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm border-0 text-center p-3">
                <small class="text-muted">Ticket Médio</small>
                <h5 class="fw-bold">R$ <?= number_format($TKM,2,',','.') ?></h5>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm border-0 text-center p-3">
                <small class="text-muted">Peças</small>
                <h5 class="fw-bold"><?= number_format($PCS,0) ?></h5>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm border-0 text-center p-3">
                <small class="text-muted">PA</small>
                <h5 class="fw-bold"><?= number_format($PA,0) ?></h5>
            </div>
        </div>
    </div>
</div>



<!--  ==========  GRAFICO EVOLUÇÃO MENSAL  =========  -->

<?php
    $grafico = $conn->query("
    SELECT DATE(data_atendimento) as dia,
    SUM(CASE WHEN resultado='Venda' THEN valor ELSE 0 END) as total
    FROM atendimentos
    WHERE vendedor_id = '$vendedor_id'
    AND MONTH(data_atendimento)=MONTH(CURDATE())
    AND YEAR(data_atendimento)=YEAR(CURDATE())
    GROUP BY DATE(data_atendimento)
    ");

    $dias = [];
    $valores = [];

    while($row = $grafico->fetch_assoc()){
    $dias[] = date('d/m', strtotime($row['dia']));
    $valores[] = $row['total'];
    }
?>

<div class="card shadow-sm border-0 mt-4">
    <div class="card-body">
        <h6>Evolução Mensal</h6>
        <canvas id="graficoIndividual"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    new Chart(document.getElementById('graficoIndividual'), {
        type: 'line',
        data: {
            labels: <?= json_encode($dias) ?>,
            datasets: [{
                label: 'Minhas Vendas',
                data: <?= json_encode($valores) ?>,
                borderWidth: 2,
                tension: 0.3
            }]
        }
    });
</script>

<!--  ==========  POSIÇÃO NO RANCKING  =========  -->
<?php
$ranking = $conn->query("
SELECT vendedor_id,
SUM(CASE WHEN resultado='Venda' THEN valor ELSE 0 END) as total
FROM atendimentos
WHERE MONTH(data_atendimento)=MONTH(CURDATE())
AND YEAR(data_atendimento)=YEAR(CURDATE())
GROUP BY vendedor_id
ORDER BY total DESC
");

$posicao = 1;
$minhaPosicao = 0;

while($row = $ranking->fetch_assoc()){
    if($row['vendedor_id'] == $vendedor_id){
        $minhaPosicao = $posicao;
        break;
    }
    $posicao++;
}
?>

<div class="alert alert-info mt-3 text-center">
    🏆 Você está na posição <strong><?= $minhaPosicao ?>º</strong> no ranking mensal
</div>

<?php require_once 'includes/footer.php'; ?>