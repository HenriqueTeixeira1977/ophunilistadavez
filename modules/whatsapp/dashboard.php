<?php
require_once '../../includes/header.php';
require_once __DIR__ . '/../../config/database.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../index.php");
    exit;
}

$totalTemplates = $pdo->query("SELECT COUNT(*) FROM templates_whatsapp")->fetchColumn();
$totalPendentes = $pdo->query("SELECT COUNT(*) FROM fila_envios_whatsapp WHERE status = 'pendente'")->fetchColumn();
$totalEnviados = $pdo->query("SELECT COUNT(*) FROM fila_envios_whatsapp WHERE status = 'enviado'")->fetchColumn();
$totalErros = $pdo->query("SELECT COUNT(*) FROM fila_envios_whatsapp WHERE status = 'erro'")->fetchColumn();
?>

<div class="container mt-4">
    <h2>Módulo WhatsApp - Dashboard</h2>

    <?php include __DIR__ . '/includes/menu.php'; ?>

    <div class="row">
        <div class="col-md-3">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h5>Templates</h5>
                    <h3><?= $totalTemplates ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h5>Fila Pendente</h5>
                    <h3><?= $totalPendentes ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h5>Enviados</h5>
                    <h3><?= $totalEnviados ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h5>Erros</h5>
                    <h3><?= $totalErros ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>