
<?php
include 'conexao.php';

// Função para calcular o valor atual da receita entre datas
function calcular_valor_atual($conn, $data_inicio, $data_fim) {
    $sql = "SELECT SUM(valor) as total FROM receitas WHERE data_receita BETWEEN '$data_inicio' AND '$data_fim'";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);
    return $row['total'] ?? 0;
}

// Inserir nova meta (se formulário enviado)
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['descricao'])) {
    $descricao = $conn->real_escape_string($_POST['descricao']);
    $tipo = $conn->real_escape_string($_POST['tipo']);
    $valor_meta = floatval($_POST['valor_meta']);
    $data_inicio = $_POST['data_inicio'];
    $data_fim = $_POST['data_fim'];

    $sql_insert = "INSERT INTO meta_financeira (tipo, descricao, valor_meta, data_inicio, data_fim, criado_em) 
                   VALUES ('$tipo', '$descricao', $valor_meta, '$data_inicio', '$data_fim', NOW())";
    mysqli_query($conn, $sql_insert);
    header('Location: planejamento_financeiro.php');
    exit;
}

// Buscar metas existentes ordenadas por data_inicio
$sql = "SELECT * FROM meta_financeira ORDER BY data_inicio ASC";
$res = mysqli_query($conn, $sql);
$metas = [];
while ($row = mysqli_fetch_assoc($res)) {
    $metas[] = $row;
}

// Montar arrays para gráfico (sem arrow functions)
$metasLabels = [];
$metasValoresMeta = [];
$metasValoresAtuais = [];
foreach ($metas as $m) {
    $metasLabels[] = $m['descricao'];
    $metasValoresMeta[] = floatval($m['valor_meta']);
    $valor_atual_meta = calcular_valor_atual($conn, $m['data_inicio'], $m['data_fim']);
    $metasValoresAtuais[] = round($valor_atual_meta, 2);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8" />
<title>Planejamento Financeiro</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    body {
        
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(to right, #6858b7ff, #1abc9c);
        margin: 0; 
        padding: 20px 30px;
        color: #333;
        
    }
    .container {
        max-width: 1000px;
        margin: auto;
        background: #ffffff; /* sem transparência */
        padding: 25px 30px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgb(0 0 0 / 0.1);
    }
    h1, h2 {
        color: #4a55a2;
        margin-bottom: 20px;
        text-align: center;
    }
    form {
        margin-bottom: 40px;
    }
    label {
        font-weight: 600;
        display: block;
        margin-bottom: 6px;
        margin-top: 16px;
        color: #222;
    }
    input[type="text"], input[type="number"], input[type="date"], select {
        width: 100%;
        padding: 10px 12px;
        border: 1.5px solid #b8c0e0;
        border-radius: 8px;
        font-size: 16px;
        box-sizing: border-box;
        transition: border-color 0.3s ease;
    }
    input[type="text"]:focus, input[type="number"]:focus, input[type="date"]:focus, select:focus {
        border-color: #4a55a2;
        outline: none;
    }
    .grid-duas-colunas {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    button {
        background-color: #4a55a2;
        color: white;
        border: none;
        padding: 14px 22px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 17px;
        margin-top: 25px;
        width: 100%;
        transition: background-color 0.3s ease;
    }
    button:hover {
        background-color: #373e7c;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 30px;
        font-size: 15px;
    }
    th, td {
        padding: 14px 18px;
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
    .progress-container {
        background: #e0e3f7;
        border-radius: 15px;
        height: 20px;
        margin-top: 6px;
        width: 100%;
        overflow: hidden;
    }
    .progress-bar {
        height: 100%;
        background-color: #4a55a2;
        width: 0%;
        transition: width 0.8s ease;
    }
    .center-text {
        text-align: center;
    }
    .btn-graph {
        background-color: #009688;
        margin-top: 20px;
        width: auto;
        padding: 10px 16px;
        font-weight: 600;
        border-radius: 8px;
        display: inline-block;
    }
    .btn-graph:hover {
        background-color: #00796b;
    }
    @media(max-width: 600px) {
        .grid-duas-colunas {
            grid-template-columns: 1fr;
        }
    }
</style>
</head>
<body>

<div class="container">
    <a class="back-link" href="dashboard_financeiro.php">← Voltar</a>
    <h1>Planejamento Financeiro</h1>

    <form method="POST" action="planejamento_financeiro.php" id="formMeta">
        <label for="tipo">Tipo de Meta</label>
        <select name="tipo" id="tipo" required>
            <option value="" disabled selected>Selecione o tipo</option>
            <option value="Semanal">Semanal</option>
            <option value="Mensal">Mensal</option>
            <option value="Trimestral">Trimestral</option>
            <option value="Anual">Anual</option>
        </select>

        <label for="descricao">Descrição da Meta</label>
        <input type="text" name="descricao" id="descricao" required placeholder="Descreva a meta">

        <div class="grid-duas-colunas">
            <div>
                <label for="data_inicio">Data Inicial</label>
                <input type="date" name="data_inicio" id="data_inicio" required>
            </div>
            <div>
                <label for="data_fim">Data Final</label>
                <input type="date" name="data_fim" id="data_fim" required>
            </div>
        </div>

        <label for="valor_meta">Valor da Meta (R$)</label>
        <input type="number" name="valor_meta" id="valor_meta" min="0" step="0.01" required>

        <button type="submit">Cadastrar Meta</button>
    </form>

    <button class="btn-graph" onclick="document.getElementById('graficoContainer').scrollIntoView({behavior:'smooth'});">
        Ver Gráfico de Metas
    </button>

    <h2>Lista de Metas</h2>
    <table>
        <thead>
            <tr>
                <th>Descrição</th>
                <th>Tipo</th>
                <th>Período</th>
                <th>Valor Meta (R$)</th>
                <th>Valor Atual (R$)</th>
                <th>Progresso</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($metas) === 0): ?>
                <tr><td colspan="6" class="center-text">Nenhuma meta cadastrada.</td></tr>
            <?php else: ?>
                <?php foreach ($metas as $m): 
                    $valor_atual = calcular_valor_atual($conn, $m['data_inicio'], $m['data_fim']);
                    $percentual = ($valor_atual / $m['valor_meta']) * 100;
                    if ($percentual > 100) $percentual = 100;
                ?>
                <tr>
                    <td><?= htmlspecialchars($m['descricao']) ?></td>
                    <td><?= htmlspecialchars($m['tipo']) ?></td>
                    <td><?= date('d/m/Y', strtotime($m['data_inicio'])) ?> a <?= date('d/m/Y', strtotime($m['data_fim'])) ?></td>
                    <td>R$ <?= number_format($m['valor_meta'], 2, ',', '.') ?></td>
                    <td>R$ <?= number_format($valor_atual, 2, ',', '.') ?></td>
                    <td>
                        <div class="progress-container">
                            <div class="progress-bar" style="width: <?= $percentual ?>%;"></div>
                        </div>
                        <small><?= round($percentual, 2) ?>%</small>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <div id="graficoContainer" style="margin-top: 60px;">
        <h2>Gráfico de Metas</h2>
        <canvas id="graficoMetas" height="150"></canvas>
    </div>
</div>

<script>
    const metasLabels = <?= json_encode($metasLabels) ?>;
    const metasValoresMeta = <?= json_encode($metasValoresMeta) ?>;
    const metasValoresAtuais = <?= json_encode($metasValoresAtuais) ?>;

    const ctx = document.getElementById('graficoMetas').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: metasLabels,
            datasets: [
                {
                    label: 'Valor da Meta (R$)',
                    data: metasValoresMeta,
                    backgroundColor: 'rgba(106, 120, 223, 0.8)',
                },
                {
                    label: 'Valor Atual (R$)',
                    data: metasValoresAtuais,
                    backgroundColor: 'rgba(35, 235, 215, 0.8)',
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'R$ ' + value.toLocaleString('pt-BR', {minimumFractionDigits: 2});
                        }
                    }
                }
            },
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>

</body>
</html>
