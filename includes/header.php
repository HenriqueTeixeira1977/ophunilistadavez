<?php
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../includes/auth.php';
?>

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

        /* NAVBAR PREMIUM */
        .navbar{
            background: linear-gradient(90deg,#0f172a,#1e293b);
            padding:12px 20px;
        }

        .navbar-brand{
            font-weight:700;
            letter-spacing:1px;
            font-size:18px;
        }

        .nav-link{
            font-weight:500;
            position:relative;
            color:#e2e8f0 !important;
            transition: all .3s ease;
        }

        .nav-link::after{
            content:'';
            position:absolute;
            width:0%;
            height:2px;
            left:0;
            bottom:0;
            background:#38bdf8;
            transition:.3s;
        }

        .nav-link:hover{
            color:#38bdf8 !important;
        }

        .nav-link:hover::after{
            width:100%;
        }

        /* Dropdown Premium */
        .dropdown-menu{
            background:#1e293b;
            border:none;
            border-radius:12px;
            box-shadow:0 10px 25px rgba(0,0,0,0.4);
        }

        .dropdown-item{
            color:#e2e8f0;
        }

        .dropdown-item:hover{
            background:#334155;
            color:#38bdf8;
        }

        /* Usuário */
        .user-box{
            background:#334155;
            padding:6px 12px;
            border-radius:20px;
            font-size:14px;
        }

        .btn-logout{
            border-radius:20px;
        }

        /* Responsividade Melhorada */
        @media(max-width:991px){
            .navbar-nav{
                margin-top:15px;
            }
            .nav-link{
                padding:10px 0;
            }
        }

    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark shadow">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="bi bi-graph-up"></i> OPHICINA Unimart
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav me-auto">
                    <?php if(isAdmin()): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../../dashboard.php">
                            <i class="bi bi-speedometer2"></i> Painel
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../pages/ranking/index.php">
                            <i class="bi bi-trophy"></i> Ranking
                        </a>
                    </li>
                    <!-- METAS -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-bullseye"></i> Metas
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../../pages/metas/index.php">Painel de Metas</a></li>
                            <li><a class="dropdown-item" href="../../pages/metas/importar.php">Importar Metas</a></li>
                        </ul>
                    </li>
                    <!-- VENDEDORES -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-people"></i> Vendedores
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../../pages/vendedores/index.php">
                                Cadastro
                            </a></li>
                            <li><a class="dropdown-item" href="../../pages/admin/presencas.php">
                                Controle de Presenças
                            </a></li>
                            <li><a class="dropdown-item" href="../../pages/admin/escala.php">
                                Escala Semanal
                            </a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../pages/listadavez/index.php">
                            <i class="bi bi-list-ol"></i> Lista da Vez
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../atendimentos/atendimentos.php">
                            <i class="bi bi-headset"></i> Atendimentos
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if(isVendedor()): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../../vendedor_dashboard.php">
                            <i class="bi bi-person-circle"></i> Meu Painel
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../pages/listadavez/index.php">
                            <i class="bi bi-list-ol"></i> Lista da Vez
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../atendimentos/atendimentos.php">
                            <i class="bi bi-headset"></i> Atendimentos
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <span class="text-white user-box">
                        <i class="bi bi-person-fill"></i>
                        <?= $_SESSION['nome'] ?>
                    </span>
                    <a href="../../auth/logout.php" class="btn btn-outline-light btn-sm btn-logout">
                        <i class="bi bi-box-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </nav>

<div class="container-fluid mt-4">