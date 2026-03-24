<?php
require_once '../../includes/header.php';
require_once __DIR__ . '/../../config/database.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../index.php");
    exit;
}

$templates = $pdo->query("SELECT * FROM templates_whatsapp ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">
    <h2>Templates de WhatsApp</h2>

    <?php include __DIR__ . '/includes/menu.php'; ?>

    <div class="card p-4 shadow-sm mb-4">
        <h4>Novo Template</h4>
        <form action="salvar_template.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Nome do Template</label>
                <input type="text" name="nome" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tipo</label>
                <select name="tipo" class="form-control" required>
                    <option value="aniversario">Aniversário</option>
                    <option value="saudade">Saudade</option>
                    <option value="promocao">Promoção</option>
                    <option value="pos_venda">Pós-venda</option>
                    <option value="manual">Manual</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Mensagem</label>
                <textarea name="mensagem" class="form-control" rows="6" required placeholder="Ex.: Olá {nome}, sentimos sua falta!"></textarea>
                <small class="text-muted">
                    Variáveis permitidas: <strong>{nome}</strong>, <strong>{primeiro_nome}</strong>
                </small>
            </div>

            <button type="submit" class="btn btn-success">Salvar Template</button>
        </form>
    </div>

    <div class="card p-4 shadow-sm">
        <h4>Templates Cadastrados</h4>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Tipo</th>
                        <th>Ativo</th>
                        <th>Criado em</th>
                        <th width="180">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($templates) > 0): ?>
                        <?php foreach ($templates as $template): ?>
                            <tr>
                                <td><?= $template['id'] ?></td>
                                <td><?= htmlspecialchars($template['nome']) ?></td>
                                <td><?= ucfirst(str_replace('_', ' ', $template['tipo'])) ?></td>
                                <td><?= $template['ativo'] ? 'Sim' : 'Não' ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($template['created_at'])) ?></td>
                                <td>
                                    <a href="editar_template.php?id=<?= $template['id'] ?>" class="btn btn-primary btn-sm">Editar</a>
                                    <a href="excluir_template.php?id=<?= $template['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Deseja excluir este template?')">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">Nenhum template cadastrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>