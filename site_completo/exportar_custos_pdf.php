<?php
require_once __DIR__ . '/vendor/autoload.php';
include 'conexao.php';

$data_inicio = $_GET['inicio'] ?? date('Y-m-01');
$data_fim = $_GET['fim'] ?? date('Y-m-t');

$query = "SELECT * FROM contas_pagar WHERE status = 'Paga' AND data_vencimento BETWEEN '$data_inicio' AND '$data_fim'";
$result = mysqli_query($conn, $query);

$html = '<h2>Relatório de Gestão de Custos</h2>';
$html .= "<p>Período: $data_inicio até $data_fim</p>";
$html .= '<table border="1" cellspacing="0" cellpadding="5">';
$html .= '<tr><th>Descrição</th><th>Valor</th><th>Data de Pagamento</th></tr>';

while ($row = mysqli_fetch_assoc($result)) {
    $html .= "<tr>
                <td>{$row['descricao']}</td>
                <td>R$ " . number_format($row['valor'], 2, ',', '.') . "</td>
                <td>" . date('d/m/Y', strtotime($row['data_vencimento'])) . "</td>
              </tr>";
}
$html .= '</table>';

use Dompdf\Dompdf;
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("gestao_custos.pdf", ["Attachment" => false]);
