<?php
$mysqli = new mysqli("localhost", "root", "", "sistema");
if ($mysqli->connect_errno) {
    die("Erro ao conectar: " . $mysqli->connect_error);
}

// Receber filtros via GET ou usar padrão: último ano (12 meses atrás até hoje)
$data_inicio = $_GET['inicio'] ?? date('Y-m-d', strtotime('-11 months')); // 11 meses atrás para completar 12 meses
$data_fim = $_GET['fim'] ?? date('Y-m-d');

// Preparar variáveis para uso seguro no SQL
$data_inicio_safe = $mysqli->real_escape_string($data_inicio);
$data_fim_safe = $mysqli->real_escape_string($data_fim);

// Preparar array de meses no intervalo para preencher gráfico
$periodo = new DatePeriod(
    new DateTime($data_inicio_safe),
    new DateInterval('P1M'),
    (new DateTime($data_fim_safe))->modify('+1 day') // para incluir o mês final
);

$dados_mensais = [];
foreach ($periodo as $dt) {
    $mes = $dt->format("Y-m");
    $dados_mensais[$mes] = ['receitas' => 0, 'despesas' => 0];
}

// Buscar receitas no período filtrado
$res = $mysqli->query("
    SELECT DATE_FORMAT(data_receita, '%Y-%m') AS mes, SUM(valor) AS total
    FROM receitas
    WHERE data_receita BETWEEN '$data_inicio_safe' AND '$data_fim_safe'
    GROUP BY mes
");
while ($row = $res->fetch_assoc()) {
    $mes = $row['mes'];
    if (isset($dados_mensais[$mes])) {
        $dados_mensais[$mes]['receitas'] = (float)$row['total'];
    }
}

// Buscar despesas no período filtrado (usando data_registro)
$res = $mysqli->query("
    SELECT DATE_FORMAT(data_registro, '%Y-%m') AS mes, SUM(valor) AS total
    FROM contas_pagar
    WHERE data_registro BETWEEN '$data_inicio_safe' AND '$data_fim_safe'
    GROUP BY mes
");
while ($row = $res->fetch_assoc()) {
    $mes = $row['mes'];
    if (isset($dados_mensais[$mes])) {
        $dados_mensais[$mes]['despesas'] = (float)$row['total'];
    }
}

// Cálculos no período filtrado
$total_receitas = array_sum(array_column($dados_mensais, 'receitas'));
$total_despesas = array_sum(array_column($dados_mensais, 'despesas'));

$variaveis = $mysqli->query("SELECT SUM(valor) AS total FROM contas_pagar WHERE categoria = 'Variável' AND data_registro BETWEEN '$data_inicio_safe' AND '$data_fim_safe'")->fetch_assoc()['total'] ?? 0;
$fixas = $mysqli->query("SELECT SUM(valor) AS total FROM contas_pagar WHERE categoria = 'Fixa' AND data_registro BETWEEN '$data_inicio_safe' AND '$data_fim_safe'")->fetch_assoc()['total'] ?? 0;
$vencidas = $mysqli->query("SELECT COUNT(*) AS qtd FROM contas_pagar WHERE data_vencimento < CURDATE() AND status != 'Paga'")->fetch_assoc()['qtd'] ?? 0;

// Limpar riscos antigos do dia (pode manter assim ou filtrar pelo período se preferir)
$mysqli->query("DELETE FROM riscos WHERE data_registro = CURDATE()");

$riscos = [];
function registrarRisco($mysqli, $descricao, $impacto_estimado = 0.00) {
    $stmt = $mysqli->prepare("INSERT INTO riscos (descricao, impacto_estimado, data_registro) VALUES (?, ?, CURDATE())");
    $stmt->bind_param("sd", $descricao, $impacto_estimado);
    $stmt->execute();
    $stmt->close();
}

if ($total_despesas > $total_receitas) {
    $msg = "❌ Risco: despesas maiores que receitas.";
    $riscos[] = $msg;
    registrarRisco($mysqli, $msg, $total_despesas - $total_receitas);
}
if ($variaveis > 50000) {
    $msg = "⚠️ Despesas variáveis acima de R$ 50.000 (R$ " . number_format($variaveis, 2, ',', '.') . ")";
    $riscos[] = $msg;
    registrarRisco($mysqli, $msg, $variaveis);
}
if ($vencidas >= 5) {
    $msg = "🔴 Existem $vencidas contas vencidas não pagas!";
    $riscos[] = $msg;
    registrarRisco($mysqli, $msg, 0);
}
if ($fixas > 0 && ($variaveis / $fixas) > 1.5) {
    $msg = "🚨 Despesas variáveis estão 50% maiores que despesas fixas.";
    $riscos[] = $msg;
    registrarRisco($mysqli, $msg, $variaveis - $fixas);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Gestão de Riscos</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(to right, #6858b7ff, #1abc9c);
        margin: 0; 
        padding: 20px 30px;
        color: #333;}
        .container { background: white; padding: 30px; max-width: 1100px; margin: auto; border-radius: 10px; box-shadow: 0 0 10px #ccc; }
        h1 { text-align: center; margin-bottom: 30px; }
        .risco { background: #fff3cd; border-left: 5px solid #ffc107; padding: 15px; margin-bottom: 15px; border-radius: 5px; color: #856404; }
        .risco.critico { background: #f8d7da; border-left-color: #dc3545; color: #721c24; }
        .risco.info { background: #d1ecf1; border-left-color: #17a2b8; color: #0c5460; }
        canvas { max-width: 100%; margin-top: 40px; }
        form {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }
        label {
            font-weight: 600;
            font-size: 14px;
            display: flex;
            flex-direction: column;
        }
        input[type="date"], button {
            padding: 8px 12px;
            border-radius: 6px;
            border: 1.5px solid #b8c0e0;
            font-size: 14px;
        }
        button {
            background-color: #4a55a2;
            color: white;
            border: none;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #373e7c;
        }
    </style>
</head>
<body>
    <div class="container">
        <p><a href="dashboard_financeiro.php">← Voltar</a></p>
        <h1>Gestão de Riscos Financeiros</h1>

        <!-- Formulário de filtro por período -->
        <form method="get" action="">
            <label for="inicio">Data Início
                <input type="date" id="inicio" name="inicio" value="<?= htmlspecialchars($data_inicio) ?>" required>
            </label>
            <label for="fim">Data Fim
                <input type="date" id="fim" name="fim" value="<?= htmlspecialchars($data_fim) ?>" required>
            </label>
            <button type="submit">Filtrar</button>
        </form>

        <?php if (empty($riscos)): ?>
            <div class="risco info">✅ Nenhum risco financeiro significativo detectado no momento.</div>
        <?php else: ?>
            <?php foreach ($riscos as $texto): ?>
                <div class="risco <?= str_contains($texto, '❌') || str_contains($texto, '🔴') || str_contains($texto, '🚨') ? 'critico' : '' ?>">
                    <?= $texto ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <h2 style="text-align: center;">Evolução Mensal de Receitas e Despesas</h2>
        <canvas id="graficoLinha"></canvas>
    </div>

    <script>
        const ctx = document.getElementById('graficoLinha').getContext('2d');
        const data = {
            labels: <?= json_encode(array_keys($dados_mensais)) ?>,
            datasets: [
                {
                    label: 'Receitas',
                    data: <?= json_encode(array_column($dados_mensais, 'receitas')) ?>,
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40,167,69,0.1)',
                    tension: 0.3
                },
                {
                    label: 'Despesas',
                    data: <?= json_encode(array_column($dados_mensais, 'despesas')) ?>,
                    borderColor: '#dc3545',
                    backgroundColor: 'rgba(220,53,69,0.1)',
                    tension: 0.3
                }
            ]
        };

        new Chart(ctx, {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: value => 'R$ ' + value.toLocaleString('pt-BR')
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
