<?php
$mysqli = new mysqli("localhost", "root", "", "sistema");

$data_inicio = $_GET['data_inicio'] ?? date('Y-m-01');
$data_fim = $_GET['data_fim'] ?? date('Y-m-t');

// Cabeçalhos para Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=gestao_custos.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "Relatório de Custos por Categoria\n";
echo "Período: " . date('d/m/Y', strtotime($data_inicio)) . " a " . date('d/m/Y', strtotime($data_fim)) . "\n\n";

echo "Categoria\tTotal (R$)\n";

$sql = "SELECT categoria, SUM(valor) AS total 
        FROM contas_pagar 
        WHERE data_registro BETWEEN '$data_inicio' AND '$data_fim'
        GROUP BY categoria";
$res = $mysqli->query($sql);

while ($row = $res->fetch_assoc()) {
    echo $row['categoria'] . "\t" . number_format($row['total'], 2, ',', '.') . "\n";
}
?>
