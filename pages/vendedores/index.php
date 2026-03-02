<?php
require_once '../../includes/header.php';

if(!isAdmin()){
    header("Location: ../../dashboard.php");
    exit;
}

$vendedores = $conn->query("
    SELECT id, nome, email, perfil, ativo, status
    FROM vendedores
    ORDER BY nome
");
?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .vendedor-card{
            transition: all .3s ease;
            border-radius:18px;
        }
        .vendedor-card:hover{
            transform: translateY(-6px);
            box-shadow:0 12px 30px rgba(0,0,0,0.15);
        }
        .avatar-circle{
            width:45px;
            height:45px;
            border-radius:50%;
            background:linear-gradient(45deg,#0ea5e9,#2563eb);
            display:flex;
            align-items:center;
            justify-content:center;
            color:#fff;
            font-size:20px;
        }
    </style>
</head>
<body>
    

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">
            <i class="bi bi-people"></i> Gestão de Vendedores
        </h3>

        <a href="novo.php" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Novo Vendedor
        </a>
    </div>

    <div class="row g-4">
        <?php while($v = $vendedores->fetch_assoc()): 

            $ativo = $v['ativo'] == 1;
            $corStatus = $ativo ? 'success' : 'secondary';
            $textoStatus = $ativo ? 'Ativo' : 'Inativo';
        ?>


        <!--  ========== CARD PRINCIPAL (TESTE) ==========  -->
        <div class="col-md-6 col-lg-4">
            <div class="card vendedor-card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center mb-3">

                        <div class="avatar-circle me-3">
                            <i class="bi bi-person"></i>
                        </div>

                        <div>
                            <h5 class="fw-bold mb-0"><?= $v['nome'] ?></h5>
                            <small class="text-muted"><?= ucfirst($v['perfil']) ?></small>
                        </div>

                    </div>

                    <div class="mb-3">

                        <span class="badge bg-<?= $corStatus ?>">
                            <?= $textoStatus ?>
                        </span>

                    </div>

                    <div class="d-flex justify-content-between text-center mb-3">

                        <div>
                            <small class="text-muted">Meta</small><br>
                            <strong>--</strong>
                        </div>

                        <div>
                            <small class="text-muted">Vendas</small><br>
                            <strong>--</strong>
                        </div>

                        <div>
                            <small class="text-muted">Faltas</small><br>
                            <strong>--</strong>
                        </div>

                    </div>

                    <div class="d-flex flex-wrap gap-2">

                        <a href="editar.php?id=<?= $v['id'] ?>" 
                        class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>

                        <a href="../admin/presencas.php?vendedor=<?= $v['id'] ?>" 
                        class="btn btn-sm btn-outline-success">
                            <i class="bi bi-calendar-check"></i>
                        </a>

                        <a href="../admin/escala.php?vendedor=<?= $v['id'] ?>" 
                        class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-clock"></i>
                        </a>

                    </div>

                </div>
            </div>
        </div>
        
        <!--  ========== CARD PRINCIPAL ==========  -->
        <!--
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm border-0 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0">
                            <?= $v['nome'] ?>
                        </h5>

                        <span class="badge bg-<?= $corStatus ?>">
                            <?= $textoStatus ?>
                        </span>
                    </div>

                    <p class="text-muted small mb-1">
                        <i class="bi bi-envelope"></i> <?= $v['email'] ?? 'Não informado' ?>
                    </p>

                    <p class="mb-3">
                        <span class="badge bg-info text-dark">
                            <?= ucfirst($v['perfil']) ?>
                        </span>
                    </p>

                    <div class="d-flex flex-wrap gap-2">
                        <a href="editar.php?id=<?= $v['id'] ?>" 
                        class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <a href="../admin/presencas.php?vendedor=<?= $v['id'] ?>" 
                        class="btn btn-sm btn-outline-success">
                            <i class="bi bi-calendar-check"></i> Presenças
                        </a>
                        <a href="../admin/escala.php?vendedor=<?= $v['id'] ?>" 
                        class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-clock"></i> Escala
                        </a>
                        <?php if($ativo): ?>
                            <a href="status.php?id=<?= $v['id'] ?>&acao=desativar" 
                            class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-x-circle"></i>
                            </a>
                        <?php else: ?>
                            <a href="status.php?id=<?= $v['id'] ?>&acao=ativar" 
                            class="btn btn-sm btn-outline-success">
                                <i class="bi bi-check-circle"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
                        -->
    </div>
</body>
</html>

<?php require_once '../../includes/footer.php'; ?>
