<?php
include 'conexao.php';

$data_inicio = $_GET['inicio'] ?? date('Y-m-01');
$data_fim = $_GET['fim'] ?? date('Y-m-t');

// Preparar datas para filtro seguro
$data_inicio_safe = mysqli_real_escape_string($conn, $data_inicio);
$data_fim_safe = mysqli_real_escape_string($conn, $data_fim);

// Receitas filtradas por período
$sql_receitas = "SELECT descricao, origem, origem_id, valor, data_receita 
                 FROM receitas 
                 WHERE data_receita BETWEEN '$data_inicio_safe' AND '$data_fim_safe'
                 ORDER BY data_receita DESC";
$res_receitas = mysqli_query($conn, $sql_receitas);

// Despesas filtradas por período
$sql_despesas = "SELECT descricao, valor, data_vencimento, categoria, status 
                 FROM contas_pagar 
                 WHERE data_vencimento BETWEEN '$data_inicio_safe' AND '$data_fim_safe'
                 ORDER BY data_vencimento DESC";
$res_despesas = mysqli_query($conn, $sql_despesas);

// Calcular totais para lucro líquido (mesmo filtro)
$sql_total_receitas = "SELECT SUM(valor) as total_receitas 
                       FROM receitas 
                       WHERE data_receita BETWEEN '$data_inicio_safe' AND '$data_fim_safe'";
$res_total_receitas = mysqli_query($conn, $sql_total_receitas);
$total_receitas = mysqli_fetch_assoc($res_total_receitas)['total_receitas'] ?? 0;

$sql_total_despesas = "SELECT SUM(valor) as total_despesas 
                       FROM contas_pagar 
                       WHERE data_vencimento BETWEEN '$data_inicio_safe' AND '$data_fim_safe'";
$res_total_despesas = mysqli_query($conn, $sql_total_despesas);
$total_despesas = mysqli_fetch_assoc($res_total_despesas)['total_despesas'] ?? 0;

$lucro_liquido = $total_receitas - $total_despesas;
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8" />
<title>Relatório Contabilidade</title>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f4f6f8;
        margin: 20px;
        color: #333;
    }
    h1, h2 {
        color: #4a55a2;
        text-align: center;
    }
    .container {
        max-width: 1100px;
        margin: auto;
        background: #fff;
        padding: 25px 30px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgb(0 0 0 / 0.1);
    }
    form {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-bottom: 25px;
        flex-wrap: wrap;
    }
    label {
        font-weight: 600;
        color: #222;
        display: flex;
        flex-direction: column;
        font-size: 14px;
    }
    input[type="date"] {
        padding: 8px 10px;
        border-radius: 6px;
        border: 1.5px solid #b8c0e0;
        font-size: 14px;
        margin-top: 5px;
        min-width: 140px;
    }
    button, .btn-export {
        background-color: #4a55a2;
        color: white;
        border: none;
        padding: 10px 18px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        transition: background-color 0.3s ease;
    }
    button:hover, .btn-export:hover {
        background-color: #373e7c;
    }
    .btn-export {
        margin-left: 10px;
        text-decoration: none;
        display: inline-block;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 30px;
        font-size: 15px;
    }
    th, td {
        padding: 12px 16px;
        border: 1px solid #ddd;
        text-align: left;
    }
    th {
        background-color: #4a55a2;
        color: white;
        font-weight: 600;
    }
    tr:hover {
        background-color: #f1f3fa;
    }
    .lucro {
        font-size: 18px;
        font-weight: 700;
        color: #009688;
        text-align: right;
        margin-top: 15px;
    }
    .export-container {
        text-align: center;
        margin-bottom: 30px;
    }
</style>
</head>
<body>
<div class="container">
    <a class="back-link" href="relatorios_financeiros.php">← Voltar</a>
    <h1>Relatório de Contabilidade</h1>

    <form method="get" action="">
        <label for="inicio">Data Início
            <input type="date" id="inicio" name="inicio" value="<?= htmlspecialchars($data_inicio) ?>" required>
        </label>
        <label for="fim">Data Fim
            <input type="date" id="fim" name="fim" value="<?= htmlspecialchars($data_fim) ?>" required>
        </label>
        <button type="submit">Filtrar</button>
    </form>

    <div class="export-container">
        <a href="exportar_contabilidade_pdf.php?inicio=<?= urlencode($data_inicio) ?>&fim=<?= urlencode($data_fim) ?>" class="btn-export" target="_blank">Exportar PDF</a>
        <a href="exportar_contabilidade_excel.php?inicio=<?= urlencode($data_inicio) ?>&fim=<?= urlencode($data_fim) ?>" class="btn-export" target="_blank">Exportar Excel</a>
    </div>

    <h2>Receitas</h2>
    <table>
        <thead>
            <tr>
                <th>Descrição</th>
                <th>Origem</th>
                <th>Valor (R$)</th>
                <th>Data da Receita</th>
            </tr>
        </thead>
        <tbody>
            <?php if(mysqli_num_rows($res_receitas) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($res_receitas)):
                    $descricao = $row['descricao'];
                    if (strtolower($row['origem']) === 'aluguel') {
                        $descricao = "Aluguel #" . ($row['origem_id'] ?? 'N/A');
                    }
                ?>
                <tr>
                    <td><?= htmlspecialchars($descricao) ?></td>
                    <td><?= htmlspecialchars($row['origem']) ?></td>
                    <td><?= number_format($row['valor'], 2, ',', '.') ?></td>
                    <td><?= date('d/m/Y', strtotime($row['data_receita'])) ?></td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="4" style="text-align:center; color:#888;">Nenhuma receita encontrada.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <h2>Despesas</h2>
    <table>
        <thead>
            <tr>
                <th>Descrição</th>
                <th>Valor (R$)</th>
                <th>Vencimento</th>
                <th>Categoria</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if(mysqli_num_rows($res_despesas) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($res_despesas)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['descricao']) ?></td>
                    <td><?= number_format($row['valor'], 2, ',', '.') ?></td>
                    <td><?= date('d/m/Y', strtotime($row['data_vencimento'])) ?></td>
                    <td><?= htmlspecialchars($row['categoria']) ?></td>
                    <td><?= htmlspecialchars($row['status']) ?></td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5" style="text-align:center; color:#888;">Nenhuma despesa encontrada.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

        <div class="lucro" style="text-align: right; margin-top: 15px;">
            <p><strong>Total de Receitas:</strong> R$ <?= number_format($total_receitas, 2, ',', '.') ?></p>
            <p><strong>Total de Despesas:</strong> R$ <?= number_format($total_despesas, 2, ',', '.') ?></p>
            <p><strong>Lucro Líquido:</strong> R$ <?= number_format($lucro_liquido, 2, ',', '.') ?></p>
        </div>

</div>
</body>
</html>
