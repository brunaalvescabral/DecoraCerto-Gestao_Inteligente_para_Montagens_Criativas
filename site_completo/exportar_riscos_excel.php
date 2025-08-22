<?php
include 'conexao.php';
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=gestao_riscos.xls");

$data_inicio = $_GET['inicio'] ?? date('Y-m-01');
$data_fim = $_GET['fim'] ?? date('Y-m-t');

$query = "SELECT * FROM riscos WHERE data_registro BETWEEN '$data_inicio' AND '$data_fim'";
$result = mysqli_query($conn, $query);

echo "<table border='1'>";
echo "<tr><th>Descrição</th><th>Impacto Estimado</th><th>Data</th></tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
            <td>{$row['descricao']}</td>
            <td>{$row['impacto_estimado']}</td>
            <td>" . date('d/m/Y', strtotime($row['data_registro'])) . "</td>
          </tr>";
}
echo "</table>";
