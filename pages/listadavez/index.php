<?php
require_once '../../includes/header.php';

if (isAdmin()) {
    header("Location: /ophuni-listadavez/pages/listadavez/index.php");
    exit;
}
?>


<?php
include '../../config/database.php';

$fila = $conn->query("
    SELECT f.posicao, v.nome, v.id 
    FROM fila f
    JOIN vendedores v ON f.vendedor_id = v.id
    ORDER BY f.posicao ASC
    ");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista da Vez - OPHICINA Unimart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container">
<h2 class="mb-4">Lista da Vez - Ophicina</h2>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Posição</th>
            <th>Vendedor</th>
            <th>Ação</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = $fila->fetch_assoc()): ?>
        <tr>
            <td><?= $row['posicao'] ?></td>
            <td>
                <?php if($row['posicao'] == 1): ?>
                    <strong class="text-success"><?= $row['nome'] ?> (NA VEZ)</strong>
                <?php else: ?>
                    <?= $row    ['nome'] ?>
                <?php endif; ?>
            </td>
            <td>
                <a href="../../atendimentos/registrar.php?id=<?= $row['id'] ?>" 
                class="btn btn-primary btn-sm">
                Registrar Atendimento
                </a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

</body>
</html>
<?php include '../../includes/footer.php'; ?>