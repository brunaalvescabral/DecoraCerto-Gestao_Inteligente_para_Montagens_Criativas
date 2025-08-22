<?php
$mysqli = new mysqli("localhost", "root", "", "sistema");
if ($mysqli->connect_errno) {
    die("Erro na conexão com o banco de dados: " . $mysqli->connect_error);
}

// Receber datas do filtro ou usar padrão últimos 12 meses
$data_inicio = isset($_GET['inicio']) && $_GET['inicio'] !== '' ? $_GET['inicio'] : date('Y-m-01', strtotime('-11 months'));
$data_fim = isset($_GET['fim']) && $_GET['fim'] !== '' ? $_GET['fim'] : date('Y-m-t');

$periodo = [];
$data_loop = new DateTime($data_inicio);
$data_fim_dt = new DateTime($data_fim);

// Garante que o loop só ocorra se a data de início for anterior ou igual à data de fim
if ($data_inicio <= $data_fim) {
    while ($data_loop <= $data_fim_dt) {
        $mes = $data_loop->format('Y-m');
        $periodo[$mes] = ['receita' => 0, 'despesa' => 0];
        $data_loop->modify('+1 month');
    }
}

// Receitas por mês
$query = "SELECT DATE_FORMAT(data_receita, '%Y-%m') AS mes, SUM(valor) AS total 
          FROM receitas 
          WHERE data_receita BETWEEN '$data_inicio' AND '$data_fim' 
          GROUP BY mes";
$res = $mysqli->query($query);
while ($row = $res->fetch_assoc()) {
    if (isset($periodo[$row['mes']])) {
        $periodo[$row['mes']]['receita'] = (float)$row['total'];
    }
}

// Despesas por mês
$query = "SELECT DATE_FORMAT(data_vencimento, '%Y-%m') AS mes, SUM(valor) AS total 
          FROM contas_pagar 
          WHERE data_vencimento BETWEEN '$data_inicio' AND '$data_fim' 
          GROUP BY mes";
$res = $mysqli->query($query);
while ($row = $res->fetch_assoc()) {
    if (isset($periodo[$row['mes']])) {
        $periodo[$row['mes']]['despesa'] = (float)$row['total'];
    }
}

// Totais
$total_receitas = array_sum(array_column($periodo, 'receita'));
$total_despesas = array_sum(array_column($periodo, 'despesa'));
$lucro_liquido = $total_receitas - $total_despesas;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Contabilidade</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(to right, #6858b7ff, #1abc9c);
        margin: 0; 
        padding: 20px 30px;
        color: #333; }
        .container { background: #fff; max-width: 1000px; margin: auto; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px #ccc; }
        h1 { text-align: center; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
        th { background: #493d84ff; color: white; }
        canvas { max-width: 100%; margin-bottom: 40px; }
        .filtro { margin-bottom: 30px; text-align: center; }
        .filtro input[type="date"] { padding: 5px; margin: 0 10px; }
        .filtro button { padding: 6px 12px; background: #493d84ff; color: white; border: none; border-radius: 5px; }
        .filtro button:hover { background: #1e183bff; cursor: pointer; }
    </style>
</head>
<body>
<div class="container">
    <p><a href="dashboard_financeiro.php">← Voltar</a></p>
    <h1>Contabilidade Geral</h1>

    <div class="filtro">
        <form method="GET">
            <label>De: <input type="date" name="inicio" value="<?= $data_inicio ?>"></label>
            <label>Até: <input type="date" name="fim" value="<?= $data_fim ?>"></label>
            <button type="submit">Filtrar</button>
        </form>
    </div>

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
const labels = <?= json_encode(array_keys($periodo)) ?>;
const receitas = <?= json_encode(array_column($periodo, 'receita')) ?>;
const despesas = <?= json_encode(array_column($periodo, 'despesa')) ?>;
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
