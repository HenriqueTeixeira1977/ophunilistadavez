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
    <!-- KPIs -->
    <div class="row g-3">

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                <small class="text-muted">Atendimentos</small>
                <h5 class="fw-bold"><?= $AT ?></h5>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                <small class="text-muted">Conversões</small>
                <h5 class="fw-bold"><?= $CC ?></h5>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                <small class="text-muted">Taxa Conversão</small>
                <h5 class="fw-bold"><?= number_format($TXC,1) ?>%</h5>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                <small class="text-muted">Ticket Médio</small>
                <h5 class="fw-bold">
                    R$ <?= number_format($TKM,2,',','.') ?>
                </h5>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                <small class="text-muted">Peças</small>
                <h5 class="fw-bold"><?= $PCS ?></h5>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                <small class="text-muted">P.A</small>
                <h5 class="fw-bold"><?= number_format($PA,2) ?></h5>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-success text-white text-center p-3">
                <small>Comissão</small>
                <h5 class="fw-bold">
                    R$ <?= number_format($faturamento * 0.01,2,',','.') ?>
                </h5>
            </div>
        </div>

    </div>

</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>