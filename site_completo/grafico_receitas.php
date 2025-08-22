<?php
$mysqli = new mysqli("localhost", "root", "", "sistema");
if ($mysqli->connect_errno) {
    die("Falha na conexão: " . $mysqli->connect_error);
}

$data_inicio = $_GET['inicio'] ?? date('Y-01-01');
$data_fim = $_GET['fim'] ?? date('Y-m-d');

$receitasPorMes = [];
$mesesNomes = [
    1 => 'Jan', 2 => 'Fev', 3 => 'Mar', 4 => 'Abr',
    5 => 'Mai', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago',
    9 => 'Set', 10 => 'Out', 11 => 'Nov', 12 => 'Dez'
];

$sql = "SELECT MONTH(data_receita) AS mes, SUM(valor) AS total 
        FROM receitas 
        WHERE data_receita BETWEEN '$data_inicio' AND '$data_fim'
        GROUP BY mes 
        ORDER BY mes ASC";

$res = $mysqli->query($sql);
$labels = [];
$valores = [];

while ($row = $res->fetch_assoc()) {
    $mes = (int)$row['mes'];
    $labels[] = $mesesNomes[$mes];
    $valores[] = (float)$row['total'];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Gráficos de Receitas</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            background: linear-gradient(to right, #007bff, #00b894);
            color: #333;
        }
        .container {
            max-width: 1000px;
            margin: 40px auto;
            background: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #444;
            margin-bottom: 30px;
        }
        a {
            text-decoration: none;
            color: #007bff;
            font-size: 14px;
        }
        a:hover {
            text-decoration: underline;
        }
        form {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 30px;
        }
        label {
            font-weight: 500;
            margin-right: 5px;
        }
        input[type="date"] {
            padding: 6px 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        button {
            padding: 8px 18px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.2s;
        }
        button:hover {
            background-color: #218838;
        }
        canvas {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <a href="dashboard_receitas.php">← Voltar</a>
    <h1>Gráfico de Receitas por Mês</h1>

    <form method="GET">
        <div>
            <label for="inicio">Início:</label>
            <input type="date" id="inicio" name="inicio" value="<?= $data_inicio ?>">
        </div>
        <div>
            <label for="fim">Fim:</label>
            <input type="date" id="fim" name="fim" value="<?= $data_fim ?>">
        </div>
        <button type="submit">Filtrar</button>
    </form>

    <canvas id="graficoReceitas" height="140"></canvas>
</div>

<script>
const ctx = document.getElementById('graficoReceitas').getContext('2d');
const data = {
    labels: <?= json_encode($labels) ?>,
    datasets: [{
        label: 'Receitas (R$)',
        backgroundColor: '#28a745',
        borderColor: '#1e7e34',
        borderWidth: 1,
        data: <?= json_encode($valores) ?>,
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
    },
    plugins: {
        legend: {
            labels: {
                font: {
                    size: 14
                }
            }
        }
    }
};

new Chart(ctx, { type: 'bar', data: data, options: options });
</script>
</body>
</html>
