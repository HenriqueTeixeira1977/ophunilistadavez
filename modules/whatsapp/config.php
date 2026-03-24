<?php
require_once '../../includes/header.php';
require_once __DIR__ . '/../../config/database.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../index.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM config_whatsapp ORDER BY id DESC LIMIT 1");
$config = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">
    <h2>Configuração da API WhatsApp</h2>

    <?php include __DIR__ . '/includes/menu.php'; ?>

    <form action="salvar_config.php" method="POST" class="card p-4 shadow-sm">
        <input type="hidden" name="id" value="<?= $config['id'] ?? '' ?>">

        <div class="mb-3">
            <label class="form-label">Nome da Conexão</label>
            <input type="text" name="nome_conexao" class="form-control" value="<?= htmlspecialchars($config['nome_conexao'] ?? 'Conexão Principal') ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Provider</label>
            <select name="provider" class="form-control" required>
                <option value="zapi" <?= (($config['provider'] ?? '') === 'zapi') ? 'selected' : '' ?>>Z-API</option>
                <option value="evolution" <?= (($config['provider'] ?? '') === 'evolution') ? 'selected' : '' ?>>Evolution API</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Instance ID</label>
            <input type="text" name="instance_id" class="form-control" value="<?= htmlspecialchars($config['instance_id'] ?? '') ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Token</label>
            <input type="text" name="token" class="form-control" value="<?= htmlspecialchars($config['token'] ?? '') ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Client Token</label>
            <input type="text" name="client_token" class="form-control" value="<?= htmlspecialchars($config['client_token'] ?? '') ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Telefone Remetente</label>
            <input type="text" name="telefone_remetente" class="form-control" value="<?= htmlspecialchars($config['telefone_remetente'] ?? '') ?>">
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="ativo" value="1" <?= (($config['ativo'] ?? 1) == 1) ? 'checked' : '' ?>>
            <label class="form-check-label">Conexão ativa</label>
        </div>

        <button type="submit" class="btn btn-success">Salvar Configuração</button>
    </form>
</div>

<?php require_once '../../includes/footer.php'; ?>