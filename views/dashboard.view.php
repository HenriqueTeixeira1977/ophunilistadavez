<style>
.kpi-card {
    transition: 0.3s ease;
    border-radius: 12px;
}

.kpi-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}

.kpi-icon {
    width: 45px;
    height: 45px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: white;
}

.bg-purple {
    background-color: #6f42c1;
}

.text-purple {
    color: #6f42c1;
}
</style>

<?php require_once __DIR__ . '/../includes/header.php'; ?>

<div class="container py-4">


    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">Performance Comercial</h3>
            <small class="text-muted">
                <?= date('d/m/Y', strtotime($inicio)) ?> 
                até 
                <?= date('d/m/Y', strtotime($fim)) ?>
            </small>
        </div>
        <div class="text-end">
            <div class="fw-bold fs-4 text-primary">
                <?= number_format($percentual,1) ?>%
            </div>
            <small class="text-muted">da Meta</small>
        </div>
    </div>



            
    <!-- FILTRO -->
    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-4">
            <input type="date" name="inicio" value="<?= $inicio ?>" class="form-control">
        </div>
        <div class="col-md-4">
            <input type="date" name="fim" value="<?= $fim ?>" class="form-control">
        </div>
        <div class="col-md-4">
            <button class="btn btn-dark w-100">Filtrar</button>
        </div>
    </form>

    <!-- META -->
<div class="card border-0 shadow-lg mb-4">
    <div class="card-body">

        <div class="row align-items-center">

            <div class="col-md-6">
                <h6 class="text-muted">Faturamento</h6>
                <h2 class="fw-bold text-success">
                    R$ <?= number_format($faturamento,2,',','.') ?>
                </h2>

                <small class="text-muted">
                    Meta: R$ <?= number_format($meta,2,',','.') ?>
                </small>
            </div>

            <div class="col-md-6 text-end">
                <h1 class="fw-bold 
                    <?= $percentual >= 100 ? 'text-success' : 'text-dark' ?>">
                    <?= number_format($percentual,1) ?>%
                </h1>

                <?php if($percentual >= 100): ?>
                    <span class="badge bg-success">Meta Batida</span>
                <?php else: ?>
                    <span class="badge bg-warning text-dark">Em Progresso</span>
                <?php endif; ?>
            </div>

        </div>

        <div class="progress mt-3" style="height:12px;">
            <div class="progress-bar <?= $cor ?>" 
                 style="width: <?= min($percentual,100) ?>%">
            </div>
        </div>

    </div>
</div>
<!-- KPIs PROFISSIONAIS -->
<div class="row g-4 mt-1">

    <!-- Atendimentos -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100 kpi-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">Atendimentos</small>
                        <h3 class="fw-bold mb-0 text-primary"><?= $AT ?></h3>
                    </div>
                    <div class="kpi-icon bg-primary">
                        📞
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Conversões -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100 kpi-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">Conversões</small>
                        <h3 class="fw-bold mb-0 text-success"><?= $CC ?></h3>
                    </div>
                    <div class="kpi-icon bg-success">
                        💰
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Taxa Conversão -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100 kpi-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">Taxa Conversão</small>
                        <h3 class="fw-bold mb-0 text-purple">
                            <?= number_format($TXC,1) ?>%
                        </h3>
                    </div>
                    <div class="kpi-icon bg-purple">
                        📊
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ticket Médio -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100 kpi-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">Ticket Médio</small>
                        <h3 class="fw-bold mb-0 text-warning">
                            R$ <?= number_format($TKM,2,',','.') ?>
                        </h3>
                    </div>
                    <div class="kpi-icon bg-warning">
                        🎟
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Peças -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100 kpi-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">Peças Vendidas</small>
                        <h3 class="fw-bold mb-0 text-dark"><?= $PCS ?></h3>
                    </div>
                    <div class="kpi-icon bg-dark">
                        📦
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- P.A -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100 kpi-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">Peças por Atendimento</small>
                        <h3 class="fw-bold mb-0 text-info">
                            <?= number_format($PA,2) ?>
                        </h3>
                    </div>
                    <div class="kpi-icon bg-info">
                        🧮
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Comissão -->
    <div class="col-md-3">
        <div class="card border-0 shadow-lg h-100 kpi-card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small>Comissão</small>
                        <h3 class="fw-bold mb-0">
                            R$ <?= number_format($faturamento * 0.01,2,',','.') ?>
                        </h3>
                    </div>
                    <div class="kpi-icon bg-light text-success">
                        💸
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>