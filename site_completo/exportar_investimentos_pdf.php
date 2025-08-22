<?php
ob_start(); // Inicia o buffer de saída
require_once __DIR__ . '/vendor/autoload.php';
include 'conexao.php';

use Dompdf\Dompdf;

$data_inicio = $_GET['inicio'] ?? date('Y-m-01');
$data_fim = $_GET['fim'] ?? date('Y-m-t');

$query = "SELECT * FROM investimentos WHERE data_investimento BETWEEN '$data_inicio' AND '$data_fim'";
$result = mysqli_query($conn, $query);

// Monta o HTML
$html = '<h2 style="text-align:center;">Relatório de Gestão de Investimentos</h2>';
$html .= "<p><strong>Período:</strong> " . date('d/m/Y', strtotime($data_inicio)) . " até " . date('d/m/Y', strtotime($data_fim)) . "</p>";
$html .= '<table border="1" cellspacing="0" cellpadding="5" width="100%">';
$html .= '<tr><th>Descrição</th><th>Valor Investido</th><th>Valor Retornado</th><th>Data</th></tr>';

while ($row = mysqli_fetch_assoc($result)) {
    $descricao = htmlspecialchars($row['nome'] ?? 'N/A');
    $valor_investido = 'R$ ' . number_format($row['valor_investido'] ?? 0, 2, ',', '.');
    $valor_real = 'R$ ' . number_format($row['valor_real'] ?? 0, 2, ',', '.');
    $data = isset($row['data_investimento']) ? date('d/m/Y', strtotime($row['data_investimento'])) : 'N/A';

    $html .= "<tr>
                <td>{$descricao}</td>
                <td>{$valor_investido}</td>
                <td>{$valor_real}</td>
                <td>{$data}</td>
              </tr>";
}
$html .= '</table>';

// Gera o PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("gestao_investimentos.pdf", ["Attachment" => false]);

ob_end_flush(); // Finaliza o buffer

