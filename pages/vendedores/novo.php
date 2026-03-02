<?php
require_once '../../includes/header.php';

if(!isAdmin()){
    header("Location: ../../dashboard.php");
    exit;
}

$erro = '';
$sucesso = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $nome   = trim($_POST['nome']);
    $email  = trim($_POST['email']);
    $senha  = $_POST['senha'];
    $perfil = $_POST['perfil'];

    if(empty($nome) || empty($email) || empty($senha)){
        $erro = "Preencha todos os campos obrigatórios.";
    }

    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $erro = "Email inválido.";
    }

    else{

        $check = $conn->prepare("SELECT id FROM vendedores WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if($check->num_rows > 0){
            $erro = "Já existe um vendedor com este email.";
        }else{

            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("
                INSERT INTO vendedores (nome, email, senha, perfil, ativo, status)
                VALUES (?, ?, ?, ?, 1, 'ativo')
            ");

            $stmt->bind_param("ssss", $nome, $email, $senhaHash, $perfil);
            $stmt->execute();

            $sucesso = "Vendedor cadastrado com sucesso!";
        }
    }
}
?>

<div class="container" style="max-width:600px;">

<div class="card shadow-lg border-0 rounded-4">
<div class="card-body p-4">

<h4 class="fw-bold mb-4">
    <i class="bi bi-person-plus"></i> Novo Vendedor
</h4>

<?php if($erro): ?>
<div class="alert alert-danger"><?= $erro ?></div>
<?php endif; ?>

<?php if($sucesso): ?>
<div class="alert alert-success"><?= $sucesso ?></div>
<?php endif; ?>

<form method="POST">

<div class="mb-3">
<label class="form-label">Nome *</label>
<input type="text" name="nome" class="form-control" required>
</div>

<div class="mb-3">
<label class="form-label">Email *</label>
<input type="email" name="email" class="form-control" required>
</div>

<div class="mb-3">
<label class="form-label">Senha *</label>
<input type="password" name="senha" class="form-control" required>
</div>

<div class="mb-4">
<label class="form-label">Perfil</label>
<select name="perfil" class="form-select">
    <option value="vendedor">Vendedor</option>
    <option value="subgerente">Subgerente</option>
    <option value="gerente">Gerente</option>
    <option value="supervisor">Supervisor</option>
</select>
</div>

<div class="d-flex justify-content-between">
<a href="index.php" class="btn btn-outline-secondary">
    Voltar
</a>

<button type="submit" class="btn btn-primary px-4">
    Cadastrar
</button>
</div>

</form>

</div>
</div>
</div>

<?php require_once '../../includes/footer.php'; ?>