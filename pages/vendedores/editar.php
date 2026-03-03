<?php
require_once '../../includes/header.php';
require_once '../../config/database.php';

if(!isAdmin()) exit;

$id = intval($_GET['id']);
$v = $conn->query("SELECT * FROM vendedores WHERE id = $id")->fetch_assoc();

if($_POST){
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("UPDATE vendedores SET nome=?, email=? WHERE id=?");
    $stmt->bind_param("ssi", $nome, $email, $id);
    $stmt->execute();

    header("Location: index.php");
    exit;
}
?>

<form method="POST" class="container mt-4">
    <input type="text" name="nome" value="<?= $v['nome'] ?>" class="form-control mb-2">
    <input type="email" name="email" value="<?= $v['email'] ?>" class="form-control mb-2">
    <button class="btn btn-primary">Salvar</button>
</form>