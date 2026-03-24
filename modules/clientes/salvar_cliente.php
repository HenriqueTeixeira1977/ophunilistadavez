<?php
require_once __DIR__ . '/../../config/database.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: clientes.php?erro=1");
    exit;
}

$acao = $_POST['acao'] ?? '';

$nome = trim($_POST['nome'] ?? '');
$telefone = trim($_POST['telefone'] ?? '');
$email = trim($_POST['email'] ?? '');
$cpf = trim($_POST['cpf'] ?? '');
$data_nascimento = !empty($_POST['data_nascimento']) ? $_POST['data_nascimento'] : null;
$genero = !empty($_POST['genero']) ? $_POST['genero'] : null;

$cep = trim($_POST['cep'] ?? '');
$endereco = trim($_POST['endereco'] ?? '');
$numero = trim($_POST['numero'] ?? '');
$complemento = trim($_POST['complemento'] ?? '');
$bairro = trim($_POST['bairro'] ?? '');
$cidade = trim($_POST['cidade'] ?? '');
$estado = trim($_POST['estado'] ?? '');
$observacoes = trim($_POST['observacoes'] ?? '');
$ativo = isset($_POST['ativo']) ? (int) $_POST['ativo'] : 1;

$optin_whatsapp = isset($_POST['optin_whatsapp']) ? (int) $_POST['optin_whatsapp'] : 1;
$bloqueado_whatsapp = isset($_POST['bloqueado_whatsapp']) ? (int) $_POST['bloqueado_whatsapp'] : 0;
$categoria_interesse = trim($_POST['categoria_interesse'] ?? '');
$vendedor_responsavel = trim($_POST['vendedor_responsavel'] ?? '');

if (empty($nome) || empty($telefone)) {
    header("Location: clientes.php?erro=1");
    exit;
}

try {
    $pdo->beginTransaction();

    if ($acao === 'cadastrar') {

        $stmt = $pdo->prepare("
            INSERT INTO clientes (
                nome, telefone, email, cpf, data_nascimento, genero,
                cep, endereco, numero, complemento, bairro, cidade, estado,
                observacoes, ativo
            ) VALUES (
                :nome, :telefone, :email, :cpf, :data_nascimento, :genero,
                :cep, :endereco, :numero, :complemento, :bairro, :cidade, :estado,
                :observacoes, :ativo
            )
        ");

        $stmt->execute([
            ':nome' => $nome,
            ':telefone' => $telefone,
            ':email' => $email ?: null,
            ':cpf' => $cpf ?: null,
            ':data_nascimento' => $data_nascimento,
            ':genero' => $genero,
            ':cep' => $cep ?: null,
            ':endereco' => $endereco ?: null,
            ':numero' => $numero ?: null,
            ':complemento' => $complemento ?: null,
            ':bairro' => $bairro ?: null,
            ':cidade' => $cidade ?: null,
            ':estado' => $estado ?: null,
            ':observacoes' => $observacoes ?: null,
            ':ativo' => $ativo
        ]);

        $cliente_id = $pdo->lastInsertId();

        $stmtWpp = $pdo->prepare("
            INSERT INTO clientes_whatsapp_config (
                cliente_id, optin_whatsapp, bloqueado_whatsapp, categoria_interesse, vendedor_responsavel
            ) VALUES (
                :cliente_id, :optin_whatsapp, :bloqueado_whatsapp, :categoria_interesse, :vendedor_responsavel
            )
        ");

        $stmtWpp->execute([
            ':cliente_id' => $cliente_id,
            ':optin_whatsapp' => $optin_whatsapp,
            ':bloqueado_whatsapp' => $bloqueado_whatsapp,
            ':categoria_interesse' => $categoria_interesse ?: null,
            ':vendedor_responsavel' => $vendedor_responsavel ?: null
        ]);

    } elseif ($acao === 'editar') {

        $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;

        if ($id <= 0) {
            throw new Exception("ID inválido.");
        }

        $stmt = $pdo->prepare("
            UPDATE clientes SET
                nome = :nome,
                telefone = :telefone,
                email = :email,
                cpf = :cpf,
                data_nascimento = :data_nascimento,
                genero = :genero,
                cep = :cep,
                endereco = :endereco,
                numero = :numero,
                complemento = :complemento,
                bairro = :bairro,
                cidade = :cidade,
                estado = :estado,
                observacoes = :observacoes,
                ativo = :ativo
            WHERE id = :id
        ");

        $stmt->execute([
            ':nome' => $nome,
            ':telefone' => $telefone,
            ':email' => $email ?: null,
            ':cpf' => $cpf ?: null,
            ':data_nascimento' => $data_nascimento,
            ':genero' => $genero,
            ':cep' => $cep ?: null,
            ':endereco' => $endereco ?: null,
            ':numero' => $numero ?: null,
            ':complemento' => $complemento ?: null,
            ':bairro' => $bairro ?: null,
            ':cidade' => $cidade ?: null,
            ':estado' => $estado ?: null,
            ':observacoes' => $observacoes ?: null,
            ':ativo' => $ativo,
            ':id' => $id
        ]);

        $check = $pdo->prepare("SELECT id FROM clientes_whatsapp_config WHERE cliente_id = :cliente_id LIMIT 1");
        $check->execute([':cliente_id' => $id]);

        if ($check->fetch()) {
            $stmtWpp = $pdo->prepare("
                UPDATE clientes_whatsapp_config SET
                    optin_whatsapp = :optin_whatsapp,
                    bloqueado_whatsapp = :bloqueado_whatsapp,
                    categoria_interesse = :categoria_interesse,
                    vendedor_responsavel = :vendedor_responsavel
                WHERE cliente_id = :cliente_id
            ");

            $stmtWpp->execute([
                ':optin_whatsapp' => $optin_whatsapp,
                ':bloqueado_whatsapp' => $bloqueado_whatsapp,
                ':categoria_interesse' => $categoria_interesse ?: null,
                ':vendedor_responsavel' => $vendedor_responsavel ?: null,
                ':cliente_id' => $id
            ]);
        } else {
            $stmtWpp = $pdo->prepare("
                INSERT INTO clientes_whatsapp_config (
                    cliente_id, optin_whatsapp, bloqueado_whatsapp, categoria_interesse, vendedor_responsavel
                ) VALUES (
                    :cliente_id, :optin_whatsapp, :bloqueado_whatsapp, :categoria_interesse, :vendedor_responsavel
                )
            ");

            $stmtWpp->execute([
                ':cliente_id' => $id,
                ':optin_whatsapp' => $optin_whatsapp,
                ':bloqueado_whatsapp' => $bloqueado_whatsapp,
                ':categoria_interesse' => $categoria_interesse ?: null,
                ':vendedor_responsavel' => $vendedor_responsavel ?: null
            ]);
        }

    } else {
        throw new Exception("Ação inválida.");
    }

    $pdo->commit();
    header("Location: clientes.php?sucesso=1");
    exit;

} catch (Exception $e) {
    $pdo->rollBack();
    header("Location: clientes.php?erro=1");
    exit;
}