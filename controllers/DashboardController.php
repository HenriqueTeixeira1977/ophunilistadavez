<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';

class DashboardController {

    private $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    public function index(){

        /* ======================
           FILTRO POR PERÍODO
        ====================== */

        $inicio = $_GET['inicio'] ?? date('Y-m-01');
        $fim = $_GET['fim'] ?? date('Y-m-t');

        if(isset($_GET['periodo'])){
            $ano = date('Y');
            $mes = date('m');
            $ultimoDia = date('t');

            if($_GET['periodo'] == 'dezena1'){
                $inicio = "$ano-$mes-01";
                $fim = "$ano-$mes-10";
            }

            if($_GET['periodo'] == 'dezena2'){
                $inicio = "$ano-$mes-11";
                $fim = "$ano-$mes-20";
            }

            if($_GET['periodo'] == 'dezena3'){
                $inicio = "$ano-$mes-21";
                $fim = "$ano-$mes-$ultimoDia";
            }
        }

        /* ======================
           MÉTRICAS DO PERÍODO
        ====================== */

        $metricas = getMetricasPeriodo($inicio, $fim, $this->conn);
        $meta = getMetaPeriodo($inicio, $fim, $this->conn);

        $faturamento = $metricas['faturamento'] ?? 0;
        $AT = $metricas['AT'] ?? 0;
        $CC = $metricas['CC'] ?? 0;
        $CNC = $metricas['CNC'] ?? 0;
        $TS = $metricas['TS'] ?? 0;
        $TD = $metricas['TD'] ?? 0;
        $PCS = $metricas['PCS'] ?? 0;

        /* ======================
           CÁLCULOS
        ====================== */

        $percentual = ($meta > 0) ? ($faturamento / $meta) * 100 : 0;
        $faltam = max($meta - $faturamento, 0);
        $TKM = ($CC > 0) ? $faturamento / $CC : 0;
        $TXC = ($AT > 0) ? ($CC / $AT) * 100 : 0;
        $PA = ($AT > 0) ? $PCS / $AT : 0;
        $comissao = $faturamento * 0.01;

        require __DIR__ . '/../views/dashboard.view.php';
    }
}