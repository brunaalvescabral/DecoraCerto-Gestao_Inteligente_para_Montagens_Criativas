<?php
$mysqli = new mysqli("localhost", "root", "", "sistema");
if ($mysqli->connect_errno) {
    die("Erro ao conectar: " . $mysqli->connect_error);
}

// Obter dados por mês para gráfico
$dados_mensais = [];
for ($i = 0; $i < 12; $i++) {
    $mes = date('Y-m', strtotime("-$i months"));
    $dados_mensais[$mes] = ['receitas' => 0, 'despesas' => 0];
}
$dados_mensais = array_reverse($dados_mensais);

// Buscar receitas
$res = $mysqli->query("
    SELECT DATE_FORMAT(data_receita, '%Y-%m') AS mes, SUM(valor) AS total
    FROM receitas
    GROUP BY mes
");
while ($row = $res->fetch_assoc()) {
    $mes = $row['mes'];
    if (isset($dados_mensais[$mes])) {
        $dados_mensais[$mes]['receitas'] = (float)$row['total'];
    }
}

// Buscar despesas
$res = $mysqli->query("
    SELECT DATE_FORMAT(data_registro, '%Y-%m') AS mes, SUM(valor) AS total
    FROM contas_pagar
    GROUP BY mes
");
while ($row = $res->fetch_assoc()) {
    $mes = $row['mes'];
    if (isset($dados_mensais[$mes])) {
        $dados_mensais[$mes]['despesas'] = (float)$row['total'];
    }
}

// Cálculos
$total_receitas = array_sum(array_column($dados_mensais, 'receitas'));
$total_despesas = array_sum(array_column($dados_mensais, 'despesas'));
$variaveis = $mysqli->query("SELECT SUM(valor) AS total FROM contas_pagar WHERE categoria = 'Variável'")->fetch_assoc()['total'] ?? 0;
$fixas = $mysqli->query("SELECT SUM(valor) AS total FROM contas_pagar WHERE categoria = 'Fixa'")->fetch_assoc()['total'] ?? 0;
$vencidas = $mysqli->query("SELECT COUNT(*) AS qtd FROM contas_pagar WHERE data_vencimento < CURDATE() AND status != 'Paga'")->fetch_assoc()['qtd'] ?? 0;

// Limpar riscos antigos do dia
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
    <meta charset="UTF-8">
    <title>Gestão de Riscos</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: Arial, sans-serif; background: #f2f2f2; padding: 20px; }
        .container { background: white; padding: 30px; max-width: 1100px; margin: auto; border-radius: 10px; box-shadow: 0 0 10px #ccc; }
        h1 { text-align: center; margin-bottom: 30px; }
        .risco { background: #fff3cd; border-left: 5px solid #ffc107; padding: 15px; margin-bottom: 15px; border-radius: 5px; color: #856404; }
        .risco.critico { background: #f8d7da; border-left-color: #dc3545; color: #721c24; }
        .risco.info { background: #d1ecf1; border-left-color: #17a2b8; color: #0c5460; }
        canvas { max-width: 100%; margin-top: 40px; }
    </style>
</head>
<body>
    <div class="container">
        <p><a href="dashboard_financeiro.php">← Voltar</a></p>
        <h1>Gestão de Riscos Financeiros</h1>

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
