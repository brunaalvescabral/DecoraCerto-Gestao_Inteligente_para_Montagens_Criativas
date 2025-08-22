<?php
include 'conexao.php';
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=gestao_custos.xls");

$data_inicio = $_GET['inicio'] ?? date('Y-m-01');
$data_fim = $_GET['fim'] ?? date('Y-m-t');

$query = "SELECT * FROM contas_pagar WHERE status = 'Paga' AND data_vencimento BETWEEN '$data_inicio' AND '$data_fim'";
$result = mysqli_query($conn, $query);

echo "<table border='1'>";
echo "<tr><th>Descrição</th><th>Valor</th><th>Data de Vencimento</th></tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
            <td>{$row['descricao']}</td>
            <td>R$ " . number_format($row['valor'], 2, ',', '.') . "</td>
            <td>" . date('d/m/Y', strtotime($row['data_vencimento'])) . "</td>
          </tr>";
}
echo "</table>";
