<?php
include 'conexao.php';
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=planejamento_financeiro.xls");

$data_inicio = $_GET['inicio'] ?? date('Y-m-01');
$data_fim = $_GET['fim'] ?? date('Y-m-t');

// Consulta metas do período
$query = "SELECT * FROM meta_financeira 
          WHERE data_inicio >= '$data_inicio' AND data_fim <= '$data_fim' 
          ORDER BY data_inicio ASC";
$result = mysqli_query($conn, $query);

// Título da tabela
echo "<table border='1'>";
echo "<tr>
        <th>Tipo</th>
        <th>Descrição</th>
        <th>Valor Atual</th>
        <th>Valor Meta</th>
        <th>Status</th>
        <th>Data Início</th>
        <th>Data Fim</th>
      </tr>";

// Laço para exibir os dados e calcular status da meta
while ($row = mysqli_fetch_assoc($result)) {
    $status = $row['valor_atual'] >= $row['valor_meta'] ? 'Meta Batida' : 'Meta Não Batida';

    echo "<tr>
            <td>{$row['tipo']}</td>
            <td>{$row['descricao']}</td>
            <td>R$ " . number_format($row['valor_atual'], 2, ',', '.') . "</td>
            <td>R$ " . number_format($row['valor_meta'], 2, ',', '.') . "</td>
            <td>{$status}</td>
            <td>" . date('d/m/Y', strtotime($row['data_inicio'])) . "</td>
            <td>" . date('d/m/Y', strtotime($row['data_fim'])) . "</td>
          </tr>";
}

echo "</table>";
?>
