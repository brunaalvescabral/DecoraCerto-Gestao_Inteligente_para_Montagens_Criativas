<?php
$mysqli = new mysqli("localhost", "root", "", "sistema");
if ($mysqli->connect_errno) {
    die("Falha na conexão: " . $mysqli->connect_error);
}

// Inicializa array para meses 1-12 com zero
$receitasPorMes = array_fill(1, 12, 0);

// Consulta soma valores agrupados por mês da data_receita
$sql = "SELECT MONTH(data_receita) AS mes, SUM(valor) AS total FROM receitas GROUP BY mes";
$res = $mysqli->query($sql);
while ($row = $res->fetch_assoc()) {
    $mes = (int)$row['mes'];
    $receitasPorMes[$mes] = (float)$row['total'];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Gráficos de Receitas</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background:#f0f0f0; }
        .container { max-width: 900px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px #ccc;}
        a { text-decoration:none; color:#007bff; }
        a:hover { text-decoration: underline; }
        h1 { text-align:center; }
    </style>
</head>
<body>
<div class="container">
    <a href="dashboard_receitas.php">← Voltar</a>
    <h1>Gráficos Mensais de Receitas</h1>
    <canvas id="graficoReceitas" height="150"></canvas>
</div>

<script>
const ctx = document.getElementById('graficoReceitas').getContext('2d');
const data = {
    labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
    datasets: [{
        label: 'Receitas (R$)',
        backgroundColor: '#28a745',
        borderColor: '#218838',
        borderWidth: 1,
        data: <?= json_encode(array_values($receitasPorMes)) ?>,
    }]
};

const options = {
    responsive: true,
    scales: {
        y: {
            beginAtZero: true,
            ticks: {
                callback: value => 'R$ ' + value.toLocaleString('pt-BR')
            }
        }
    }
};

new Chart(ctx, { type: 'bar', data: data, options: options });
</script>
</body>
</html>
