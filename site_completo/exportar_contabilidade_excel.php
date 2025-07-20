<?php
include 'conexao.php';
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=contabilidade.xls");

$data_inicio = $_GET['inicio'] ?? date('Y-m-01');
$data_fim = $_GET['fim'] ?? date('Y-m-t');

$query = "SELECT * FROM receitas WHERE data_receita BETWEEN '$data_inicio' AND '$data_fim'";
$result = mysqli_query($conn, $query);

echo "<table border='1'>";
echo "<tr><th>Descrição</th><th>Valor</th><th>Data</th></tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
            <td>{$row['descricao']}</td>
            <td>R$ " . number_format($row['valor'], 2, ',', '.') . "</td>
            <td>" . date('d/m/Y', strtotime($row['data_receita'])) . "</td>
          </tr>";
}
echo "</table>";
