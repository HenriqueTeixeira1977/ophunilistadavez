<?php
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../includes/auth.php';
?>

<!--  ==========  MENU 2.0  ==========  -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>OPHICINA - Sistema</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body{
            background:#f4f6f9;
        }
        .navbar-brand{
            font-weight:600;
            letter-spacing:1px;
        }
        .nav-link{
            font-weight:500;
        }
        nav{
            width: 100%;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php">
                <i class="bi bi-graph-up"></i> OPHICINA Unimart
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav me-auto">
                    <?php if(isAdmin()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">
                                <i class="bi bi-speedometer2"></i> Painel Geral
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pages/ranking/index.php">
                                <i class="bi bi-trophy"></i> Ranking
                            </a>                
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-bullseye"></i> Metas</a>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                                <li><a class="dropdown-item" href="pages/metas/index.php">Painel Geral</a></li>
                                <li><a class="dropdown-item" href="pages/metas/importar.php">Importar Metas</a></li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </li>                                        
                        <li class="nav-item">
                            <a class="nav-link" href="pages/vendedores/index.php">
                                <i class="bi bi-people"></i> Vendedores
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pages/listadavez/index.php">
                                <i class="bi bi-list-ol"></i> Lista da Vez
                            </a>
                        </li>
                    <?php endif; ?>


                    <!--  ==========  MENU PARA VENDEDORES  ==========  -->
                    
                    <?php if(isVendedor()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="vendedor_dashboard.php">
                                <i class="bi bi-person-circle"></i> Meu Painel
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pages/listadavez/index.php">
                                <i class="bi bi-list-ol"></i> Lista da Vez
                            </a>
                        </li>
                    <?php endif; ?>                    
                </ul>
                <div class="d-flex align-items-center">
                    <span class="text-white me-3">
                        <i class="bi bi-person-fill"></i>
                        <?= $_SESSION['nome'] ?>
                    </span>
                    <a href="../auth/logout.php" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-box-arrow-right"></i> Sair
                    </a>
                </div>
            </div>
        </div>
    </nav>

<div class="container-fluid mt-4">

