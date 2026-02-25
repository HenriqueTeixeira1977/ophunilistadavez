<?php require_once __DIR__ . '/../includes/header.php'; ?>

<div class="container py-4">

    <h4 class="fw-bold mb-4">📊 Painel Comercial</h4>

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
    <div class="card shadow border-0 mb-4">
        <div class="card-body text-center">
            <h6 class="text-muted">Faturamento</h6>
            <h3 class="fw-bold text-success">
                R$ <?= number_format($faturamento,2,',','.') ?>
            </h3>

            <small class="text-muted">
                Meta: R$ <?= number_format($meta,2,',','.') ?>
            </small>

            <?php 
            $cor = "bg-danger";
            if($percentual >= 100) $cor = "bg-success";
            elseif($percentual >= 70) $cor = "bg-warning";
            ?>

            <div class="progress mt-3" style="height:8px;">
                <div class="progress-bar <?= $cor ?>" 
                     style="width: <?= min($percentual,100) ?>%">
                </div>
            </div>

            <div class="mt-2 fw-bold">
                <?= number_format($percentual,1) ?>% da meta
            </div>

            <?php if($percentual < 100): ?>
                <div class="text-danger mt-2">
                    Faltam R$ <?= number_format($faltam,2,',','.') ?>
                </div>
            <?php else: ?>
                <div class="text-success fw-bold mt-2">
                    🎯 Meta Batida!
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- KPIs -->
    <div class="row g-3">

        <div class="col-md-3">
            <div class="card shadow-sm text-center p-3">
                <small class="text-muted">Atendimentos</small>
                <h5 class="fw-bold"><?= $AT ?></h5>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm text-center p-3">
                <small class="text-muted">Conversões</small>
                <h5 class="fw-bold"><?= $CC ?></h5>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm text-center p-3">
                <small class="text-muted">Taxa Conversão</small>
                <h5 class="fw-bold"><?= number_format($TXC,1) ?>%</h5>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm text-center p-3">
                <small class="text-muted">Ticket Médio</small>
                <h5 class="fw-bold">
                    R$ <?= number_format($TKM,2,',','.') ?>
                </h5>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm text-center p-3">
                <small class="text-muted">Peças</small>
                <h5 class="fw-bold"><?= $PCS ?></h5>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm text-center p-3">
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