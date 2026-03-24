<?php
require_once '../../includes/header.php';
require_once __DIR__ . '/../../config/database.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../index.php");
    exit;
}
?>

<div class="container mt-4">
    <h2 class="mb-4">Cadastrar Cliente</h2>

    <div class="card">
        <div class="card-body">
            <form action="salvar_cliente.php" method="POST">
                <input type="hidden" name="acao" value="cadastrar">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Nome *</label>
                        <input type="text" name="nome" class="form-control" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Telefone *</label>
                        <input type="text" name="telefone" class="form-control" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Data de Nascimento</label>
                        <input type="date" name="data_nascimento" class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>E-mail</label>
                        <input type="email" name="email" class="form-control">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>CPF</label>
                        <input type="text" name="cpf" class="form-control">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Gênero</label>
                        <select name="genero" class="form-control">
                            <option value="">Selecione</option>
                            <option value="masculino">Masculino</option>
                            <option value="feminino">Feminino</option>
                            <option value="outro">Outro</option>
                        </select>
                    </div>

                    <div class="col-md-2 mb-3">
                        <label>Ativo</label>
                        <select name="ativo" class="form-control">
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                    </div>

                    <div class="col-md-2 mb-3">
                        <label>CEP</label>
                        <input type="text" name="cep" class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Endereço</label>
                        <input type="text" name="endereco" class="form-control">
                    </div>

                    <div class="col-md-2 mb-3">
                        <label>Número</label>
                        <input type="text" name="numero" class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Complemento</label>
                        <input type="text" name="complemento" class="form-control">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Bairro</label>
                        <input type="text" name="bairro" class="form-control">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Cidade</label>
                        <input type="text" name="cidade" class="form-control">
                    </div>

                    <div class="col-md-2 mb-3">
                        <label>Estado</label>
                        <input type="text" name="estado" class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Categoria de Interesse</label>
                        <input type="text" name="categoria_interesse" class="form-control" placeholder="Ex: Casual, Running, Street">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Vendedor Responsável</label>
                        <input type="text" name="vendedor_responsavel" class="form-control">
                    </div>

                    <div class="col-md-2 mb-3">
                        <label>Opt-in WhatsApp</label>
                        <select name="optin_whatsapp" class="form-control">
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                    </div>

                    <div class="col-md-2 mb-3">
                        <label>Bloqueado WhatsApp</label>
                        <select name="bloqueado_whatsapp" class="form-control">
                            <option value="0">Não</option>
                            <option value="1">Sim</option>
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Observações</label>
                        <textarea name="observacoes" class="form-control" rows="4"></textarea>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Salvar Cliente</button>
                <a href="clientes.php" class="btn btn-secondary">Voltar</a>
            </form>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>