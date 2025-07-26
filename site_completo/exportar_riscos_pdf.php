<?php
require_once __DIR__ . '/vendor/autoload.php';


include 'conexao.php';

$data_inicio = $_GET['inicio'] ?? date('Y-m-01');
$data_fim = $_GET['fim'] ?? date('Y-m-t');

$query = "SELECT * FROM riscos WHERE data_registro BETWEEN '$data_inicio' AND '$data_fim'";
$result = mysqli_query($conn, $query);

$html = '<h2>Relatório de Gestão de Riscos</h2>';
$html .= "<p>Período: $data_inicio até $data_fim</p>";
$html .= '<table border="1" cellspacing="0" cellpadding="5">';
$html .= '<tr><th>Descrição</th><th>Impacto Estimado</th><th>Data</th></tr>';

while ($row = mysqli_fetch_assoc($result)) {
    $html .= "<tr>
                <td>{$row['descricao']}</td>
                <td>{$row['impacto_estimado']}</td>
                <td>" . date('d/m/Y', strtotime($row['data_registro'])) . "</td>
              </tr>";
}
$html .= '</table>';

use Dompdf\Dompdf;
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("gestao_riscos.pdf", ["Attachment" => false]);
