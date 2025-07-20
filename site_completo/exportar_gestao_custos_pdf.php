<?php
require_once __DIR__ . '/vendor/autoload.php';
use Dompdf\Dompdf;

$mysqli = new mysqli("localhost", "root", "", "sistema");

$data_inicio = $_GET['data_inicio'] ?? date('Y-m-01');
$data_fim = $_GET['data_fim'] ?? date('Y-m-t');

// Buscar dados
$sql = "SELECT categoria, SUM(valor) AS total 
        FROM contas_pagar 
        WHERE data_registro BETWEEN '$data_inicio' AND '$data_fim'
        GROUP BY categoria";
$res = $mysqli->query($sql);

$html = '<h2>Relatório de Custos por Categoria</h2>';
$html .= "<p>Período: " . date('d/m/Y', strtotime($data_inicio)) . " a " . date('d/m/Y', strtotime($data_fim)) . "</p>";
$html .= '<table border="1" cellpadding="5" cellspacing="0">
            <tr><th>Categoria</th><th>Total (R$)</th></tr>';

while ($row = $res->fetch_assoc()) {
    $html .= '<tr><td>' . htmlspecialchars($row['categoria']) . '</td><td>R$ ' . number_format($row['total'], 2, ',', '.') . '</td></tr>';
}
$html .= '</table>';

// Gerar PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("gestao_custos.pdf", ["Attachment" => false]);
exit;
?>
