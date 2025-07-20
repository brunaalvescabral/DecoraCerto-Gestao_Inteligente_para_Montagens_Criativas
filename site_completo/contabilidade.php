<?php
$mysqli = new mysqli("localhost", "root", "", "sistema");
if ($mysqli->connect_errno) {
    die("Erro na conexão com o banco de dados: " . $mysqli->connect_error);
}

// DRE (últimos 12 meses)
$meses = [];
$dados = [];
for ($i = 0; $i < 12; $i++) {
    $mes = date('Y-m', strtotime("-$i months"));
    $meses[$mes] = ['receita' => 0, 'despesa' => 0];
}
$meses = array_reverse($meses);

// Receitas por mês
$res = $mysqli->query("SELECT DATE_FORMAT(data_receita, '%Y-%m') AS mes, SUM(valor) AS total FROM receitas GROUP BY mes");
while ($row = $res->fetch_assoc()) {
    if (isset($meses[$row['mes']])) {
        $meses[$row['mes']]['receita'] = (float)$row['total'];
    }
}

// Despesas por mês
$res = $mysqli->query("SELECT DATE_FORMAT(data_registro, '%Y-%m') AS mes, SUM(valor) AS total FROM contas_pagar GROUP BY mes");
while ($row = $res->fetch_assoc()) {
    if (isset($meses[$row['mes']])) {
        $meses[$row['mes']]['despesa'] = (float)$row['total'];
    }
}

// Totais
$total_receitas = array_sum(array_column($meses, 'receita'));
$total_despesas = array_sum(array_column($meses, 'despesa'));
$lucro_liquido = $total_receitas - $total_despesas;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Contabilidade</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: Arial; background: #f5f5f5; padding: 20px; }
        .container { background: #fff; max-width: 1000px; margin: auto; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px #ccc; }
        h1 { text-align: center; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th, td { padding: 10px; border: 1px solid #ccc; }
        th { background: #007bff; color: white; }
        canvas { max-width: 100%; margin-bottom: 40px; }
    </style>
</head>
<body>
<div class="container">
    <p><a href="dashboard_financeiro.php">← Voltar</a></p>
    <h1>Contabilidade Geral</h1>

    <h2>Demonstração do Resultado do Exercício (DRE)</h2>
    <table>
        <tr><th>Item</th><th>Valor (R$)</th></tr>
        <tr><td>Receitas Totais</td><td>R$ <?= number_format($total_receitas, 2, ',', '.') ?></td></tr>
        <tr><td>Despesas Totais</td><td>R$ <?= number_format($total_despesas, 2, ',', '.') ?></td></tr>
        <tr><td><strong>Lucro Líquido</strong></td><td><strong>R$ <?= number_format($lucro_liquido, 2, ',', '.') ?></strong></td></tr>
    </table>

    <h2>Gráfico Comparativo: Receitas x Despesas</h2>
    <canvas id="graficoComparativo"></canvas>

    <h2>Lucro Mensal</h2>
    <canvas id="graficoLucro"></canvas>
</div>

<script>
const labels = <?= json_encode(array_keys($meses)) ?>;
const receitas = <?= json_encode(array_column($meses, 'receita')) ?>;
const despesas = <?= json_encode(array_column($meses, 'despesa')) ?>;
const lucro = receitas.map((r, i) => r - despesas[i]);

new Chart(document.getElementById('graficoComparativo'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [
            {
                label: 'Receitas',
                data: receitas,
                backgroundColor: '#28a745'
            },
            {
                label: 'Despesas',
                data: despesas,
                backgroundColor: '#dc3545'
            }
        ]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: val => 'R$ ' + val.toLocaleString('pt-BR')
                }
            }
        }
    }
});

new Chart(document.getElementById('graficoLucro'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Lucro Mensal',
            data: lucro,
            borderColor: '#007bff',
            backgroundColor: 'rgba(0,123,255,0.1)',
            fill: true,
            tension: 0.3
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: false,
                ticks: {
                    callback: val => 'R$ ' + val.toLocaleString('pt-BR')
                }
            }
        }
    }
});
</script>
</body>
</html>
