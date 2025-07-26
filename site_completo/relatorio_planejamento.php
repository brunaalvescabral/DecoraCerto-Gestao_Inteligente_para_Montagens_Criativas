<?php
include 'conexao.php';

// Pega filtros via GET ou usa padrão
$data_inicio = $_GET['inicio'] ?? date('Y-m-01');
$data_fim = $_GET['fim'] ?? date('Y-m-t');
$status_filtro = $_GET['status'] ?? 'todos';

// Busca metas dentro do período
$sql = "SELECT * FROM meta_financeira WHERE data_inicio >= '$data_inicio' AND data_fim <= '$data_fim' ORDER BY data_inicio ASC";
$result = mysqli_query($conn, $sql);
$metas_filtradas = [];

// Função para calcular valor atual da receita no período da meta
function calcular_valor_atual($conn, $data_inicio, $data_fim) {
    $sql = "SELECT SUM(valor) as total FROM receitas WHERE data_receita BETWEEN '$data_inicio' AND '$data_fim'";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);
    return $row['total'] ?? 0;
}

// Processa metas e aplica filtro de status
while ($meta = mysqli_fetch_assoc($result)) {
    $valor_meta = floatval($meta['valor_meta']);
    $valor_atual = calcular_valor_atual($conn, $meta['data_inicio'], $meta['data_fim']);
    $status = $valor_atual >= $valor_meta ? 'Meta Batida' : 'Meta Não Batida';

    // Aplica filtro de status
    if (
        $status_filtro === 'todos' ||
        ($status_filtro === 'batidas' && $status === 'Meta Batida') ||
        ($status_filtro === 'nao_batidas' && $status === 'Meta Não Batida')
    ) {
        $meta['valor_atual'] = $valor_atual;
        $meta['status'] = $status;
        $metas_filtradas[] = $meta;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Planejamento Financeiro</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f0f2f5;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .container {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #4a55a2;
        }
        form {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 30px;
            justify-content: center;
        }
        label {
            font-weight: 600;
            font-size: 0.95rem;
            display: flex;
            flex-direction: column;
        }
        input, select, button {
            padding: 10px;
            font-size: 1rem;
            border-radius: 8px;
            border: 1px solid #ccc;
        }
        button {
            background: #4a55a2;
            color: white;
            border: none;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background: #373e7c;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #e0e0e0;
            text-align: left;
        }
        th {
            background: #4a55a2;
            color: white;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        .export-links {
            margin-top: 25px;
            text-align: center;
        }
        .export-links a {
            margin: 0 15px;
            color: #4a55a2;
            text-decoration: none;
            font-weight: 600;
        }
        .export-links a:hover {
            color: #00C16E;
        }
    </style>
</head>
<body>
<div class="container">
    <a class="back-link" href="relatorios_financeiros.php">← Voltar</a>
    <h2>Relatório de Planejamento Financeiro</h2>

    <form method="get">
        <label>
            De:
            <input type="date" name="inicio" value="<?= htmlspecialchars($data_inicio) ?>" required>
        </label>
        <label>
            Até:
            <input type="date" name="fim" value="<?= htmlspecialchars($data_fim) ?>" required>
        </label>
        <label>
            Status:
            <select name="status">
                <option value="todos" <?= $status_filtro === 'todos' ? 'selected' : '' ?>>Todas</option>
                <option value="batidas" <?= $status_filtro === 'batidas' ? 'selected' : '' ?>>Metas Batidas</option>
                <option value="nao_batidas" <?= $status_filtro === 'nao_batidas' ? 'selected' : '' ?>>Metas Não Batidas</option>
            </select>
        </label>
        <button type="submit">Filtrar</button>
    </form>

    <table>
        <thead>
        <tr>
            <th>Descrição</th>
            <th>Tipo</th>
            <th>Período</th>
            <th>Valor Meta</th>
            <th>Valor Atual</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        <?php if (count($metas_filtradas) > 0): ?>
            <?php foreach ($metas_filtradas as $m): ?>
                <tr>
                    <td><?= htmlspecialchars($m['descricao']) ?></td>
                    <td><?= htmlspecialchars($m['tipo']) ?></td>
                    <td><?= date('d/m/Y', strtotime($m['data_inicio'])) ?> a <?= date('d/m/Y', strtotime($m['data_fim'])) ?></td>
                    <td>R$ <?= number_format($m['valor_meta'], 2, ',', '.') ?></td>
                    <td>R$ <?= number_format($m['valor_atual'], 2, ',', '.') ?></td>
                    <td><?= $m['status'] ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="6" style="text-align:center; color:#888;">Nenhuma meta encontrada para o filtro.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

    <div class="export-links">
        <a href="exportar_planejamento_pdf.php?inicio=<?= urlencode($data_inicio) ?>&fim=<?= urlencode($data_fim) ?>&status=<?= urlencode($status_filtro) ?>">Exportar PDF</a>
        <a href="exportar_planejamento_excel.php?inicio=<?= urlencode($data_inicio) ?>&fim=<?= urlencode($data_fim) ?>&status=<?= urlencode($status_filtro) ?>">Exportar Excel</a>
    </div>
</div>
</body>
</html>
