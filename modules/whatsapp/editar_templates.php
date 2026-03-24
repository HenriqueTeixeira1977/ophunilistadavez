<?php
require_once '../../includes/header.php';
require_once __DIR__ . '/../../config/database.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../index.php");
    exit;
}

$id = $_GET['id'] ?? 0;

$stmt = $pdo->prepare("SELECT * FROM templates_whatsapp WHERE id = :id");
$stmt->execute([':id' => $id]);
$template = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$template) {
    header("Location: templates.php?erro=naoencontrado");
    exit;
}
?>

<div class="container mt-4">
    <h2>Editar Template</h2>

    <?php include __DIR__ . '/includes/menu.php'; ?>

    <div class="card p-4 shadow-sm">
        <form action="salvar_template.php" method="POST">
            <input type="hidden" name="id" value="<?= $template['id'] ?>">

            <div class="mb-3">
                <label class="form-label">Nome do Template</label>
                <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($template['nome']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tipo</label>
                <select name="tipo" class="form-control" required>
                    <option value="aniversario" <?= $template['tipo'] == 'aniversario' ? 'selected' : '' ?>>Aniversário</option>
                    <option value="saudade" <?= $template['tipo'] == 'saudade' ? 'selected' : '' ?>>Saudade</option>
                    <option value="promocao" <?= $template['tipo'] == 'promocao' ? 'selected' : '' ?>>Promoção</option>
                    <option value="pos_venda" <?= $template['tipo'] == 'pos_venda' ? 'selected' : '' ?>>Pós-venda</option>
                    <option value="manual" <?= $template['tipo'] == 'manual' ? 'selected' : '' ?>>Manual</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Mensagem</label>
                <textarea name="mensagem" class="form-control" rows="8" required><?= htmlspecialchars($template['mensagem']) ?></textarea>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="ativo" value="1" <?= $template['ativo'] ? 'checked' : '' ?>>
                <label class="form-check-label">Template ativo</label>
            </div>

            <button type="submit" class="btn btn-success">Salvar Alterações</button>
            <a href="templates.php" class="btn btn-secondary">Voltar</a>
        </form>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>