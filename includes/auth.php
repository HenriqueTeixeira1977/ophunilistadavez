<?php

if (!function_exists('isAdmin')) {

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['usuario_id'])) {
        header("Location: /lista-da-vez/login.php");
        exit;
    }

    function isAdmin(){
        return isset($_SESSION['perfil']) && $_SESSION['perfil'] === 'admin';
    }

    function isVendedor(){
        return isset($_SESSION['perfil']) && $_SESSION['perfil'] === 'vendedor';
    }

}
?>