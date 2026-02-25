<?php
require_once '../../includes/header.php';

if(!isAdmin()){
    header("Location: ../vendedor_dashboard.php");
    exit;
}

if(isset($_POST['importar'])){

    $arquivo = $_FILES['arquivo']['tmp_name'];
    $handle = fopen($arquivo, "r");

    $linha = 0;

    while(($dados = fgetcsv($handle, 1000, ";")) !== FALSE){

        if($linha == 0){ $linha++; continue; }

        $data = date('Y-m-') . str_pad($linha,2,"0",STR_PAD_LEFT);

        $meta_vendas = str_replace(['R$','.',','],['','','.'],$dados[0]);
        $meta_20 = str_replace(['R$','.',','],['','','.'],$dados[1]);

        $meta_at = $dados[2];
        $meta_conv = $dados[3];
        $meta_pecas = $dados[4];

        $conn->query("
            INSERT INTO metas_diarias 
            (data, meta_vendas, meta_vendas_20, meta_atendimentos, meta_convertidos, meta_pecas)
            VALUES 
            ('$data','$meta_vendas','$meta_20','$meta_at','$meta_conv','$meta_pecas')
        ");

        $linha++;
    }

    echo "<div class='alert alert-success'>Planilha importada com sucesso!</div>";
}
?>

<h3>📥 Importar Planilha de Metas</h3>

<form method="POST" enctype="multipart/form-data" class="card p-4 bg-dark">
    <input type="file" name="arquivo" class="form-control mb-3" required>
    <button name="importar" class="btn btn-success">Importar</button>
</form>

<?php require_once '../../includes/footer.php'; ?>