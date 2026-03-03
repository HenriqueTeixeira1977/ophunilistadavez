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
        <?php
            // META DO MÊS
            $meta = $conn->query("
                SELECT meta FROM metas 
                WHERE vendedor_id = {$v['id']} 
                AND MONTH(data) = MONTH(CURDATE())
            ")->fetch_assoc();

            $metaValor = $meta['meta'] ?? 0;

            // VENDAS DO MÊS
            $vendas = $conn->query("
                SELECT SUM(valor) as total 
                FROM atendimentos 
                WHERE vendedor_id = {$v['id']}
                AND MONTH(data) = MONTH(CURDATE())
            ")->fetch_assoc();

            $totalVendas = $vendas['total'] ?? 0;

            // FALTAS
            $faltas = $conn->query("
                SELECT COUNT(*) as total 
                FROM presencas 
                WHERE vendedor_id = {$v['id']}
                AND status = 'falta'
                AND MONTH(data) = MONTH(CURDATE())
            ")->fetch_assoc();

            $totalFaltas = $faltas['total'] ?? 0;
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
                            <strong>R$ <?= number_format($metaValor,2,',','.') ?></strong>
                        </div>
                        <div>
                            <small class="text-muted">Vendas</small><br>
                            <strong>R$ <?= number_format($totalVendas,2,',','.') ?></strong>
                        </div>
                        <div>
                            <small class="text-muted">Faltas</small><br>
                            <strong>R$ <?= number_format($totalVendas,2,',','.') ?></strong>
                        </div>
                    </div>


                    <div class="d-flex flex-wrap gap-2">
                        <a href="editar.php?id=<?= $v['id'] ?>" 
                            class="btn btn-sm btn-outline-primary"
                            data-bs-toggle="tooltip"
                            title="Editar">                            
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="presencas.php?vendedor=<?= $v['id'] ?>" 
                            class="btn btn-sm btn-outline-success"
                            data-bs-toggle="tooltip"
                            title="Presença">
                            <i class="bi bi-calendar-check"></i>
                        </a>
                        <a href="escala.php?vendedor=<?= $v['id'] ?>" 
                            class="btn btn-sm btn-outline-warning"
                            data-bs-toggle="tooltip"
                            title="Escala">
                            <i class="bi bi-clock"></i>
                        </a>               
                        
                        <?php if($ativo): ?>
                            <a href="status.php?id=<?= $v['id'] ?>&acao=desativar"
                                class="btn btn-sm btn-outline-danger">
                                ❌ Remover da Lista
                            </a>
                        <?php else: ?>
                            <a href="status.php?id=<?= $v['id'] ?>&acao=ativar"
                                class="btn btn-sm btn-outline-success">
                                ➕ Habilitar na Lista
                            </a>
                        <?php endif; ?>
                        <!--
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
                        -->
                        
                        <a href="excluir.php?id=<?= $v['id'] ?>"
                            class="btn btn-sm btn-outline-danger"
                            onclick="return confirm('Deseja excluir este vendedor?')"
                            data-bs-toggle="tooltip"
                            title="Excluir Vendedor">
                            <i class="bi bi-trash"></i>
                        </a>        


                    </div>
                </div>
            </div>
        </div>      
        <?php endwhile; ?>
    </div>
</body>
</html>

<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>

<?php require_once '../../includes/footer.php'; ?>
