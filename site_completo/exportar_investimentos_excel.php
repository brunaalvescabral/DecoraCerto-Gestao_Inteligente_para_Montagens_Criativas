<?php
include 'conexao.php';
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=gestao_investimentos.xls");

$data_inicio = $_GET['inicio'] ?? date('Y-m-01');
$data_fim = $_GET['fim'] ?? date('Y-m-t');

$query = "SELECT * FROM investimentos WHERE data_investimento BETWEEN '$data_inicio' AND '$data_fim'";
$result = mysqli_query($conn, $query);

echo "<table border='1'>";
echo "<tr><th>Descrição</th><th>Valor Investido</th><th>Valor Retornado</th><th>Data</th></tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
            <td>{$row['descricao']}</td>
            <td>R$ " . number_format($row['valor_investido'], 2, ',', '.') . "</td>
            <td>R$ " . number_format($row['valor_real'], 2, ',', '.') . "</td>
            <td>" . date('d/m/Y', strtotime($row['data_investimento'])) . "</td>
          </tr>";
}
echo "</table>";
