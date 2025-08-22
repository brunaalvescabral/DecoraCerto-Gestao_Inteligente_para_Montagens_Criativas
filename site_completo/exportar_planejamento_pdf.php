<?php
require_once __DIR__ . '/vendor/autoload.php';
include 'conexao.php';

// Recebe o período do filtro (GET)
$data_inicio = $_GET['inicio'] ?? date('Y-m-01');
$data_fim = $_GET['fim'] ?? date('Y-m-t');

// Buscar metas financeiras dentro do período
$query = "SELECT * FROM meta_financeira 
          WHERE data_inicio >= '$data_inicio' AND data_fim <= '$data_fim'";
$result = mysqli_query($conn, $query);

// Início do HTML do relatório
$html = '<h2 style="text-align:center;">Relatório de Planejamento Financeiro</h2>';
$html .= "<p><strong>Período:</strong> " . date('d/m/Y', strtotime($data_inicio)) . " até " . date('d/m/Y', strtotime($data_fim)) . "</p>";
$html .= '<table border="1" cellspacing="0" cellpadding="6" width="100%">';
$html .= '<tr style="background-color: #f2f2f2;">
            <th>Descrição da Meta</th>
            <th>Valor Planejado</th>
            <th>Valor Realizado</th>
            <th>Meta Batida</th>
          </tr>';

// Loop nas metas
while ($row = mysqli_fetch_assoc($result)) {
    $descricao = $row['descricao'];
    $valor_meta = $row['valor_meta'];
    $dataMetaInicio = $row['data_inicio'];
    $dataMetaFim = $row['data_fim'];

    // Calcula o valor realizado no período da meta
    $query_realizado = "SELECT SUM(valor) as total_realizado 
                        FROM receitas 
                        WHERE data_receita BETWEEN '$dataMetaInicio' AND '$dataMetaFim'";
    $res_realizado = mysqli_query($conn, $query_realizado);
    $row_realizado = mysqli_fetch_assoc($res_realizado);
    $valor_realizado = $row_realizado['total_realizado'] ?? 0;

    // Verifica se a meta foi batida
    $meta_batida = $valor_realizado >= $valor_meta ? 'Sim' : 'Não';

    $html .= "<tr>
                <td>{$descricao}</td>
                <td>R$ " . number_format($valor_meta, 2, ',', '.') . "</td>
                <td>R$ " . number_format($valor_realizado, 2, ',', '.') . "</td>
                <td>$meta_batida</td>
              </tr>";
}

$html .= '</table>';

// Gera o PDF com Dompdf
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("relatorio_planejamento_financeiro.pdf", ["Attachment" => false]);
?>
