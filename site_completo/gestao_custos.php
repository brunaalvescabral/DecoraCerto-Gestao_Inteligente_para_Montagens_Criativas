<?php
$mysqli = new mysqli("localhost", "root", "", "sistema");
if ($mysqli->connect_errno) {
    die("Erro na conexão: " . $mysqli->connect_error);
}

// Filtro por data
$data_inicio = $_GET['data_inicio'] ?? date('Y-m-01');
$data_fim = $_GET['data_fim'] ?? date('Y-m-t');

// Custos por categoria
$sql = "SELECT categoria, SUM(valor) AS total 
        FROM contas_pagar 
        WHERE data_registro BETWEEN '$data_inicio' AND '$data_fim'
        GROUP BY categoria";
$res = $mysqli->query($sql);

$categorias = [];
while ($row = $res->fetch_assoc()) {
    $categorias[$row['categoria']] = (float)$row['total'];
}

// Custos por subcategoria
$sql = "SELECT subcategoria, SUM(valor) AS total 
        FROM contas_pagar 
        WHERE data_registro BETWEEN '$data_inicio' AND '$data_fim'
        GROUP BY subcategoria";
$res2 = $mysqli->query($sql);

$subcategorias = [];
while ($row = $res2->fetch_assoc()) {
    $subcategorias[$row['subcategoria']] = (float)$row['total'];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Gestão de Custos</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        .container { background: white; max-width: 1100px; margin: auto; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px #ccc; }
        h1 { text-align: center; }
        .filtros { display: flex; gap: 10px; justify-content: center; margin-bottom: 20px; }
        .filtros input[type="date"] { padding: 6px; border: 1px solid #ccc; border-radius: 5px; }
        canvas { max-width: 500px; background: #fff; padding: 10px; border-radius: 10px; }
        .graficos { display: flex; flex-wrap: wrap; justify-content: center; gap: 20px; margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 30px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #007bff; color: white; }
        .botoes-exportar { text-align: center; margin-top: 20px; }
        .botoes-exportar a {
            padding: 10px 20px; margin: 5px; background: #28a745; color: white; text-decoration: none; border-radius: 5px;
        }
    </style>
</head>
<body>
<div class="container">
    <p><a href="dashboard_financeiro.php">← Voltar</a></p>
    <h1>Gestão de Custos</h1>

    <form class="filtros" method="get">
        <label>De: <input type="date" name="data_inicio" value="<?= $data_inicio ?>"></label>
        <label>Até: <input type="date" name="data_fim" value="<?= $data_fim ?>"></label>
        <button type="submit">Filtrar</button>
    </form>

    <div class="graficos">
        <div>
            <h3 style="text-align: center;">Por Categoria</h3>
            <canvas id="graficoCategoria"></canvas>
        </div>
        <div>
            <h3 style="text-align: center;">Por Subcategoria</h3>
            <canvas id="graficoSubcategoria"></canvas>
        </div>
    </div>

    <h2>Custos por Categoria</h2>
    <table>
        <tr><th>Categoria</th><th>Total (R$)</th></tr>
        <?php foreach ($categorias as $cat => $total): ?>
            <tr>
                <td><?= htmlspecialchars($cat) ?></td>
                <td>R$ <?= number_format($total, 2, ',', '.') ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Custos por Subcategoria</h2>
    <table>
        <tr><th>Subcategoria</th><th>Total (R$)</th></tr>
        <?php foreach ($subcategorias as $sub => $total): ?>
            <tr>
                <td><?= htmlspecialchars($sub) ?></td>
                <td>R$ <?= number_format($total, 2, ',', '.') ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <div class="botoes-exportar">
        <a href="exportar_gestao_custos_pdf.php?data_inicio=<?= $data_inicio ?>&data_fim=<?= $data_fim ?>" target="_blank">Exportar PDF</a>
        <a href="exportar_gestao_custos_excel.php?data_inicio=<?= $data_inicio ?>&data_fim=<?= $data_fim ?>" target="_blank">Exportar Excel</a>
    </div>
</div>

<script>
const dadosCategoria = {
    labels: <?= json_encode(array_keys($categorias)) ?>,
    datasets: [{
        label: 'Categoria',
        data: <?= json_encode(array_values($categorias)) ?>,
        backgroundColor: ['#007bff', '#ffc107']
    }]
};

const dadosSubcategoria = {
    labels: <?= json_encode(array_keys($subcategorias)) ?>,
    datasets: [{
        label: 'Subcategoria',
        data: <?= json_encode(array_values($subcategorias)) ?>,
        backgroundColor: ['#28a745', '#dc3545']
    }]
};

new Chart(document.getElementById('graficoCategoria'), {
    type: 'pie',
    data: dadosCategoria,
    options: { responsive: true }
});

new Chart(document.getElementById('graficoSubcategoria'), {
    type: 'pie',
    data: dadosSubcategoria,
    options: { responsive: true }
});
</script>
</body>
</html>
