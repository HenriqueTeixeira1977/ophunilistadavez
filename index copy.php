<?php
include 'config/database.php';

$email = $_POST['email'] ?? '';
$senha = md5($_POST['senha'] ?? '');

$sql = "SELECT * FROM vendedores WHERE email='$email' AND senha='$senha'";
$result = $conn->query($sql);

if($result && $result->num_rows > 0){

    $usuario = $result->fetch_assoc();

    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['nome'] = $usuario['nome'];
    $_SESSION['perfil'] = $usuario['perfil'];

    if($usuario['perfil'] === 'admin'){
        header("Location: dashboard.php");
    } else {
        header("Location: vendedor_dashboard.php");
    }

    exit;

} else {
    header("Location: login.php?erro=1");
    exit;
}