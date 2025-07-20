<?php
$mysqli = new mysqli("localhost", "root", "", "sistema");
if ($mysqli->connect_errno) {
    die("Erro na conexão: " . $mysqli->connect_error);
}

// Recebe filtro período via GET
$data_inicio = $_GET['data_inicio'] ?? date('Y-m-01');
$data_fim = $_GET['data_fim'] ?? date('Y-m-t');

// Monta array meses do período
$periodo = [];
$dt = new DateTime($data_inicio);
$dt_fim = new DateTime($data_fim);
while ($dt <= $dt_fim) {
    $periodo[$dt->format('Y-m')] = ['investido' => 0, 'retornado' => 0];
    $dt->modify('+1 month');
}

// Consulta valores investidos por mês (todos status)
$resInv = $mysqli->prepare("SELECT DATE_FORMAT(data_investimento, '%Y-%m') AS mes, SUM(valor_investido) AS total FROM investimentos WHERE data_investimento BETWEEN ? AND ? GROUP BY mes");
$resInv->bind_param("ss", $data_inicio, $data_fim);
$resInv->execute();
$resultInv = $resInv->get_result();
while ($row = $resultInv->fetch_assoc()) {
    if (isset($periodo[$row['mes']])) {
        $periodo[$row['mes']]['investido'] = (float)$row['total'];
    }
}
$resInv->close();

// Consulta valores retornados (investimentos finalizados) por mês da data_investimento
$resRet = $mysqli->prepare("SELECT DATE_FORMAT(data_investimento, '%Y-%m') AS mes, SUM(valor_real) AS total FROM investimentos WHERE status = 'Finalizado' AND data_investimento BETWEEN ? AND ? GROUP BY mes");
$resRet->bind_param("ss", $data_inicio, $data_fim);
$resRet->execute();
$resultRet = $resRet->get_result();
while ($row = $resultRet->fetch_assoc()) {
    if (isset($periodo[$row['mes']])) {
        $periodo[$row['mes']]['retornado'] = (float)$row['total'];
    }
}
$resRet->close();

$meses = array_keys($periodo);
$investido = array_column($periodo, 'investido');
$retornado = array_column($periodo, 'retornado');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8" />
<title>Gráfico de Investimentos</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    body { font-family: Arial; background: #f4f4f4; padding: 20px; }
    .container { max-width: 900px; margin: auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px #ccc; }
    h1 { text-align: center; margin-bottom: 30px; }
    form { display: flex; justify-content: center; gap: 20px; margin-bottom: 30px; flex-wrap: wrap; }
    form label { display: flex; flex-direction: column; font-weight: bold; }
    form input[type="date"] { padding: 8px; border-radius: 5px; border: 1px solid #ccc; }
    form button { padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; }
    canvas { max-width: 100%; }
    a { display: inline-block; margin-top: 15px; color: #007bff; text-decoration: none; }
    a:hover { text-decoration: underline; }
</style>
</head>
<body>
<div class="container">
    <h1>Gráfico de Investimentos</h1>

    <form method="GET">
        <label>Data Início:
            <input type="date" name="data_inicio" value="<?= htmlspecialchars($data_inicio) ?>" required>
        </label>
        <label>Data Fim:
            <input type="date" name="data_fim" value="<?= htmlspecialchars($data_fim) ?>" required>
        </label>
        <button type="submit">Filtrar</button>
    </form>

    <canvas id="graficoInvestimentos"></canvas>

    <p><a href="investimentos_dashboard.php">← Voltar</a></p>
</div>

<script>
const ctx = document.getElementById('graficoInvestimentos').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($meses) ?>,
        datasets: [
            {
                label: 'Valor Investido (R$)',
                data: <?= json_encode($investido) ?>,
                backgroundColor: '#28a745'
            },
            {
                label: 'Valor Retornado (R$)',
                data: <?= json_encode($retornado) ?>,
                backgroundColor: '#007bff'
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
</script>
</body>
</html>
