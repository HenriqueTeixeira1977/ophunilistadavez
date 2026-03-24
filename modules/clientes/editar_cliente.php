<?php
require_once '../../includes/header.php';
require_once __DIR__ . '/../../config/database.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../index.php");
    exit;
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: clientes.php?erro=1");
    exit;
}

$id = (int) $_GET['id'];

$stmt = $pdo->prepare("
    SELECT 
        c.*,
        cw.optin_whatsapp,
        cw.bloqueado_whatsapp,
        cw.categoria_interesse,
        cw.vendedor_responsavel
    FROM clientes c
    LEFT JOIN clientes_whatsapp_config cw ON cw.cliente_id = c.id
    WHERE c.id = :id
    LIMIT 1
");
$stmt->execute([':id' => $id]);
$cliente = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$cliente) {
    header("Location: clientes.php?erro=1");
    exit;
}
?>

<div class="container mt-4">
    <h2 class="mb-4">Editar Cliente</h2>

    <div class="card">
        <div class="card-body">
            <form action="salvar_cliente.php" method="POST">
                <input type="hidden" name="acao" value="editar">
                <input type="hidden" name="id" value="<?= $cliente['id'] ?>">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Nome *</label>
                        <input type="text" name="nome" class="form-control" required value="<?= htmlspecialchars($cliente['nome']) ?>">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Telefone *</label>
                        <input type="text" name="telefone" class="form-control" required value="<?= htmlspecialchars($cliente['telefone']) ?>">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Data de Nascimento</label>
                        <input type="date" name="data_nascimento" class="form-control" value="<?= $cliente['data_nascimento'] ?>">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>E-mail</label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($cliente['email'] ?? '') ?>">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>CPF</label>
                        <input type="text" name="cpf" class="form-control" value="<?= htmlspecialchars($cliente['cpf'] ?? '') ?>">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Gênero</label>
                        <select name="genero" class="form-control">
                            <option value="">Selecione</option>
                            <option value="masculino" <?= ($cliente['genero'] == 'masculino') ? 'selected' : '' ?>>Masculino</option>
                            <option value="feminino" <?= ($cliente['genero'] == 'feminino') ? 'selected' : '' ?>>Feminino</option>
                            <option value="outro" <?= ($cliente['genero'] == 'outro') ? 'selected' : '' ?>>Outro</option>
                        </select>
                    </div>

                    <div class="col-md-2 mb-3">
                        <label>Ativo</label>
                        <select name="ativo" class="form-control">
                            <option value="1" <?= ($cliente['ativo'] == 1) ? 'selected' : '' ?>>Sim</option>
                            <option value="0" <?= ($cliente['ativo'] == 0) ? 'selected' : '' ?>>Não</option>
                        </select>
                    </div>

                    <div class="col-md-2 mb-3">
                        <label>CEP</label>
                        <input type="text" name="cep" class="form-control" value="<?= htmlspecialchars($cliente['cep'] ?? '') ?>">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Endereço</label>
                        <input type="text" name="endereco" class="form-control" value="<?= htmlspecialchars($cliente['endereco'] ?? '') ?>">
                    </div>

                    <div class="col-md-2 mb-3">
                        <label>Número</label>
                        <input type="text" name="numero" class="form-control" value="<?= htmlspecialchars($cliente['numero'] ?? '') ?>">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Complemento</label>
                        <input type="text" name="complemento" class="form-control" value="<?= htmlspecialchars($cliente['complemento'] ?? '') ?>">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Bairro</label>
                        <input type="text" name="bairro" class="form-control" value="<?= htmlspecialchars($cliente['bairro'] ?? '') ?>">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Cidade</label>
                        <input type="text" name="cidade" class="form-control" value="<?= htmlspecialchars($cliente['cidade'] ?? '') ?>">
                    </div>

                    <div class="col-md-2 mb-3">
                        <label>Estado</label>
                        <input type="text" name="estado" class="form-control" value="<?= htmlspecialchars($cliente['estado'] ?? '') ?>">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Categoria de Interesse</label>
                        <input type="text" name="categoria_interesse" class="form-control" value="<?= htmlspecialchars($cliente['categoria_interesse'] ?? '') ?>">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Vendedor Responsável</label>
                        <input type="text" name="vendedor_responsavel" class="form-control" value="<?= htmlspecialchars($cliente['vendedor_responsavel'] ?? '') ?>">
                    </div>

                    <div class="col-md-2 mb-3">
                        <label>Opt-in WhatsApp</label>
                        <select name="optin_whatsapp" class="form-control">
                            <option value="1" <?= ((int)($cliente['optin_whatsapp'] ?? 1) === 1) ? 'selected' : '' ?>>Sim</option>
                            <option value="0" <?= ((int)($cliente['optin_whatsapp'] ?? 1) === 0) ? 'selected' : '' ?>>Não</option>
                        </select>
                    </div>

                    <div class="col-md-2 mb-3">
                        <label>Bloqueado WhatsApp</label>
                        <select name="bloqueado_whatsapp" class="form-control">
                            <option value="0" <?= ((int)($cliente['bloqueado_whatsapp'] ?? 0) === 0) ? 'selected' : '' ?>>Não</option>
                            <option value="1" <?= ((int)($cliente['bloqueado_whatsapp'] ?? 0) === 1) ? 'selected' : '' ?>>Sim</option>
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Observações</label>
                        <textarea name="observacoes" class="form-control" rows="4"><?= htmlspecialchars($cliente['observacoes'] ?? '') ?></textarea>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Atualizar Cliente</button>
                <a href="clientes.php" class="btn btn-secondary">Voltar</a>
            </form>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>