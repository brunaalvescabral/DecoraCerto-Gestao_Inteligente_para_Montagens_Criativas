<?php
require_once __DIR__ . '/vendor/autoload.php'; // Dompdf
include 'conexao.php';

use Dompdf\Dompdf;

$data_inicio = $_GET['inicio'] ?? date('Y-m-01');
$data_fim = $_GET['fim'] ?? date('Y-m-t');

$data_inicio_safe = mysqli_real_escape_string($conn, $data_inicio);
$data_fim_safe = mysqli_real_escape_string($conn, $data_fim);

// Buscar receitas
$sql_receitas = "SELECT descricao, origem, origem_id, valor, data_receita 
                 FROM receitas 
                 WHERE data_receita BETWEEN '$data_inicio_safe' AND '$data_fim_safe'
                 ORDER BY data_receita DESC";
$res_receitas = mysqli_query($conn, $sql_receitas);

// Buscar despesas
$sql_despesas = "SELECT descricao, valor, data_vencimento, categoria, status 
                 FROM contas_pagar 
                 WHERE data_vencimento BETWEEN '$data_inicio_safe' AND '$data_fim_safe'
                 ORDER BY data_vencimento DESC";
$res_despesas = mysqli_query($conn, $sql_despesas);

// Calcular totais para lucro líquido
$sql_total_receitas = "SELECT SUM(valor) as total_receitas 
                       FROM receitas 
                       WHERE data_receita BETWEEN '$data_inicio_safe' AND '$data_fim_safe'";
$total_receitas = mysqli_fetch_assoc(mysqli_query($conn, $sql_total_receitas))['total_receitas'] ?? 0;

$sql_total_despesas = "SELECT SUM(valor) as total_despesas 
                       FROM contas_pagar 
                       WHERE status != 'Paga' AND data_vencimento BETWEEN '$data_inicio_safe' AND '$data_fim_safe'";
$total_despesas = mysqli_fetch_assoc(mysqli_query($conn, $sql_total_despesas))['total_despesas'] ?? 0;

$lucro_liquido = $total_receitas - $total_despesas;

// Montar HTML para o PDF
$html = '
<h2 style="text-align:center;">Relatório de Contabilidade</h2>
<p><strong>Período:</strong> ' . date('d/m/Y', strtotime($data_inicio)) . ' até ' . date('d/m/Y', strtotime($data_fim)) . '</p>

<h3>Receitas</h3>
<table width="100%" border="1" cellspacing="0" cellpadding="5" style="border-collapse: collapse;">
<thead>
<tr style="background-color:#4a55a2; color:#fff;">
<th>Descrição</th><th>Origem</th><th>Valor (R$)</th><th>Data da Receita</th>
</tr>
</thead>
<tbody>';

if (mysqli_num_rows($res_receitas) > 0) {
    while ($row = mysqli_fetch_assoc($res_receitas)) {
        $descricao = $row['descricao'];
        if (strtolower($row['origem']) === 'aluguel') {
            $descricao = "Aluguel #" . ($row['origem_id'] ?? 'N/A');
        }
        $html .= '<tr>
        <td>' . htmlspecialchars($descricao) . '</td>
        <td>' . htmlspecialchars($row['origem']) . '</td>
        <td style="text-align:right;">' . number_format($row['valor'], 2, ',', '.') . '</td>
        <td>' . date('d/m/Y', strtotime($row['data_receita'])) . '</td>
        </tr>';
    }
} else {
    $html .= '<tr><td colspan="4" style="text-align:center; color:#888;">Nenhuma receita encontrada.</td></tr>';
}

$html .= '
</tbody>
</table>

<h3>Despesas</h3>
<table width="100%" border="1" cellspacing="0" cellpadding="5" style="border-collapse: collapse;">
<thead>
<tr style="background-color:#4a55a2; color:#fff;">
<th>Descrição</th><th>Valor (R$)</th><th>Vencimento</th><th>Categoria</th><th>Status</th>
</tr>
</thead>
<tbody>';

if (mysqli_num_rows($res_despesas) > 0) {
    while ($row = mysqli_fetch_assoc($res_despesas)) {
        $html .= '<tr>
        <td>' . htmlspecialchars($row['descricao']) . '</td>
        <td style="text-align:right;">' . number_format($row['valor'], 2, ',', '.') . '</td>
        <td>' . date('d/m/Y', strtotime($row['data_vencimento'])) . '</td>
        <td>' . htmlspecialchars($row['categoria']) . '</td>
        <td>' . htmlspecialchars($row['status']) . '</td>
        </tr>';
    }
} else {
    $html .= '<tr><td colspan="5" style="text-align:center; color:#888;">Nenhuma despesa encontrada.</td></tr>';
}

$html .= '
</tbody>
</table>

<h3 style="text-align:right;">Lucro Líquido: R$ ' . number_format($lucro_liquido, 2, ',', '.') . '</h3>
';

// Gerar PDF com Dompdf
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("relatorio_contabilidade.pdf", ["Attachment" => true]);
exit;
