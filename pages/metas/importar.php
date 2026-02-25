<?php
require_once '../../config/database.php';
require_once '../../includes/header.php';

if(isset($_POST['importar'])){

    if(isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] == 0){

        $arquivo = $_FILES['arquivo']['tmp_name'];
        $handle = fopen($arquivo, "r");

        // Pula cabeçalho
        fgetcsv($handle, 1000, ",");

        $linhasImportadas = 0;

        while(($dados = fgetcsv($handle, 1000, ",")) !== FALSE){

            $data_meta = $dados[0];
            $meta_vendas = $dados[1];
            $meta_vendas_20 = $dados[2];
            $meta_atendimentos = $dados[3];
            $meta_convertidos = $dados[4];
            $meta_pecas = $dados[5];

            // Evita duplicidade (atualiza se já existir)
            $stmt = $conn->prepare("
                INSERT INTO metas_diarias 
                (data_meta, meta_vendas, meta_vendas_20, meta_atendimentos, meta_convertidos, meta_pecas)
                VALUES (?, ?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE
                meta_vendas = VALUES(meta_vendas),
                meta_vendas_20 = VALUES(meta_vendas_20),
                meta_atendimentos = VALUES(meta_atendimentos),
                meta_convertidos = VALUES(meta_convertidos),
                meta_pecas = VALUES(meta_pecas)
            ");

            $stmt->bind_param(
                "sddiii",
                $data_meta,
                $meta_vendas,
                $meta_vendas_20,
                $meta_atendimentos,
                $meta_convertidos,
                $meta_pecas
            );

            $stmt->execute();
            $linhasImportadas++;
        }

        fclose($handle);

        echo "
        <div class='alert alert-success mt-3'>
            ✅ $linhasImportadas metas importadas/atualizadas com sucesso!
        </div>";
    }
}
?>

<div class="container mt-4">
    <div class="card shadow border-0 p-4">
        <h4 class="mb-3">📥 Importar Planilha de Metas</h4>

        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <input type="file" name="arquivo" class="form-control" accept=".csv" required>
            </div>

            <button type="submit" name="importar" class="btn btn-dark w-100">
                Importar Metas
            </button>
        </form>

        <small class="text-muted d-block mt-3">
            Formato esperado: data_meta, meta_vendas, meta_vendas_20, meta_atendimentos, meta_convertidos, meta_pecas
        </small>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>