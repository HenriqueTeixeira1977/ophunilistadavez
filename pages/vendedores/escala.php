<?php
require_once '../../includes/header.php';
require_once __DIR__ . '/../../config/database.php';

if(!isset($_SESSION['usuario_id'])){
    header("Location: ../../index.php");
    exit;
}

$vendedor_id = intval($_GET['vendedor'] ?? 0);

$vendedor = $conn->query("
    SELECT nome FROM vendedores 
    WHERE id = $vendedor_id
")->fetch_assoc();

if(!$vendedor){
    echo "Vendedor não encontrado.";
    exit;
}

$diasSemana = [
    1 => 'Segunda',
    2 => 'Terça',
    3 => 'Quarta',
    4 => 'Quinta',
    5 => 'Sexta',
    6 => 'Sábado',
    7 => 'Domingo'
];

$escala = $conn->query("
    SELECT dia_semana, trabalha
    FROM escala_vendedores
    WHERE vendedor_id = $vendedor_id
");

$config = [];
while($e = $escala->fetch_assoc()){
    $config[$e['dia_semana']] = $e['trabalha'];
}
?>

<div class="container py-4">
    <h3 class="fw-bold mb-4">
        📅 Escala Semanal - <?= $vendedor['nome'] ?>
    </h3>

    <div class="card shadow border-0">
        <div class="card-body">
            <div class="row g-3">

                <?php foreach($diasSemana as $numero => $nome): 

                    $trabalha = $config[$numero] ?? 1;
                    $cor = $trabalha ? 'success' : 'danger';
                ?>

                <div class="col-md-3">
                    <form method="POST" action="salvar_escala.php">
                        <input type="hidden" name="vendedor_id" value="<?= $vendedor_id ?>">
                        <input type="hidden" name="dia_semana" value="<?= $numero ?>">

                        <button type="submit" name="trabalha"
                            value="<?= $trabalha ? 0 : 1 ?>"
                            class="btn btn-outline-<?= $cor ?> w-100">

                            <?= $nome ?><br>
                            <small><?= $trabalha ? 'Trabalha' : 'Folga' ?></small>
                        </button>
                    </form>
                </div>

                <?php endforeach; ?>

            </div>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>