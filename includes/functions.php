
<?php
/*  ==========  METAS DIARIAS  ==========  */
function getMetaPeriodo($inicio, $fim, $conn){

    $sql = "
        SELECT SUM(meta_vendas) as total
        FROM metas_diarias
        WHERE DATE(data_meta) BETWEEN '$inicio' AND '$fim'
    ";

    $result = $conn->query($sql);

    if($result && $result->num_rows > 0){
        $row = $result->fetch_assoc();
        return $row['total'] ?? 0;
    }

    return 0;
}

/* ===========  ATENDIMENTOS  ==========  */
function getMetricasPeriodo($inicio, $fim, $conn){

    $sql = "
        SELECT 
        COUNT(id) as AT,
        SUM(CASE WHEN resultado='Venda' THEN 1 ELSE 0 END) as CC,
        SUM(CASE WHEN resultado='Não comprou' THEN 1 ELSE 0 END) as CNC,
        SUM(CASE WHEN resultado='Troca' AND valor = 0 THEN 1 ELSE 0 END) as TS,
        SUM(CASE WHEN resultado='Troca + Diferença' THEN 1 ELSE 0 END) as TD,
        SUM(CASE WHEN resultado='Venda' THEN valor ELSE 0 END) as faturamento,
        SUM(quantidade) as PCS
        FROM atendimentos
        WHERE DATE(data_atendimento) BETWEEN '$inicio' AND '$fim'
    ";

    $result = $conn->query($sql);

    if($result && $result->num_rows > 0){
        return $result->fetch_assoc();
    }

    return [];
}