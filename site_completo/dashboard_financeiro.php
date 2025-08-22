<?php
include 'conexao.php';

// Usar últimos 12 meses (sem filtro manual)
$data_inicio = date('Y-m-01', strtotime('-11 months'));
$data_fim = date('Y-m-t');

$periodo = [];
$meses = [];

$data_atual = strtotime($data_inicio);
$data_final = strtotime($data_fim);

while ($data_atual <= $data_final) {
    $mes = date('Y-m', $data_atual);
    $meses[] = $mes;
    $data_atual = strtotime('+1 month', $data_atual);
}

foreach ($meses as $mes) {
    $inicio_mes = $mes . '-01';
    $fim_mes = date('Y-m-t', strtotime($inicio_mes));

    $query_receitas = "SELECT SUM(valor) as total FROM receitas WHERE data_receita BETWEEN '$inicio_mes' AND '$fim_mes'";
    $query_despesas = "SELECT SUM(valor) as total FROM contas_pagar WHERE data_registro BETWEEN '$inicio_mes' AND '$fim_mes'";

    $resultado_receitas = mysqli_query($conn, $query_receitas);
    $resultado_despesas = mysqli_query($conn, $query_despesas);

    $total_receitas = mysqli_fetch_assoc($resultado_receitas)['total'] ?? 0;
    $total_despesas = mysqli_fetch_assoc($resultado_despesas)['total'] ?? 0;

    $periodo[] = [
        'mes' => $mes,
        'receitas' => (float) $total_receitas,
        'despesas' => (float) $total_despesas,
        'lucro' => (float) $total_receitas - (float) $total_despesas
    ];
}

// Define primeiro e último dia do mês atual
$mes_atual_inicio = date('Y-m-01');
$mes_atual_fim = date('Y-m-t');

// CATEGORIAS do mês atual
$categorias = [];
$res = mysqli_query($conn, "
    SELECT categoria, SUM(valor) as total 
    FROM contas_pagar 
    WHERE data_registro BETWEEN '$mes_atual_inicio' AND '$mes_atual_fim'
    GROUP BY categoria
");
while ($row = mysqli_fetch_assoc($res)) {
    $categorias[$row['categoria']] = (float) $row['total'];
}

// SUBCATEGORIAS do mês atual
$subcategorias = [];
$res = mysqli_query($conn, "
    SELECT subcategoria, SUM(valor) as total 
    FROM contas_pagar 
    WHERE data_registro BETWEEN '$mes_atual_inicio' AND '$mes_atual_fim'
    GROUP BY subcategoria
");
while ($row = mysqli_fetch_assoc($res)) {
    $subcategorias[$row['subcategoria']] = (float) $row['total'];
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Setor Financeiro</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: white;
        }

        header {
            background: linear-gradient(to right, #7A5FFF, #00C16E);
            color: white;
            padding: 40px;
            font-size: 32px;
            text-align: center;
            font-weight: bold;
        }

        .container {
            display: flex;
        }

        nav {
            width: 220px;
            background: #191435ff;
            color: white;
            min-height: calc(100vh - 80px);
            padding-top: 30px;
            flex-shrink: 0;
        }

        nav a {
            display: block;
            color: white;
            padding: 15px 25px;
            text-decoration: none;
            font-weight: bold;
        }

        nav a:hover {
            background-color: #302a52;
        }

        main {
            flex-grow: 1;
            padding: 40px;
        }

        h2, h3 {
            color: #2c3e50;
        }

        .graficos {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: center;
            margin-top: 30px;
        }

        canvas {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 0 12px rgba(0,0,0,0.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        table th, table td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: left;
        }

        footer {
            background: #512da8;
            color: white;
            padding: 30px;
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin-top: 50px;
        }

        footer div {
            min-width: 200px;
            margin-bottom: 20px;
        }

        footer h4 {
            margin-bottom: 10px;
            color: #00C16E;
        }

        footer a {
            color: white;
            text-decoration: none;
            display: block;
            margin-top: 5px;
        }

        #graficoFinanceiro {
            margin-top: 40px;
            max-height: 350px;   /* altura maior */
            max-width: 900px;    /* largura maior */
            width: 100%;
            margin: auto;
        }

        @media(max-width: 768px) {
            .graficos {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>
<header>Setor Financeiro</header>
<div class="container">
    <nav>
        <a href="dashboard_notas_fiscais.php">Notas fiscais</a>
        <a href="relatorios_financeiros.php">Relatórios Financeiros</a>
        <a href="planejamento_financeiro.php">Planejamento Financeiro</a>
        <a href="gestao_riscos.php">Gestão de Riscos</a>
        <a href="gestao_custos.php">Gestão de Custos</a>
        <a href="investimentos_dashboard.php">Gestão de Investimentos</a>
        <a href="contabilidade.php">Contabilidade</a>
        <a href="dashboard_receitas.php">Receitas</a>
        <a href="dashboard_contas_pagar.php">Despesas</a>
        <a href="menu_principal.php">Voltar ao menu principal</a>
    </nav>

    <main>
        <h2>Bem-vindo ao Setor Financeiro</h2>
        <p>Este menu centraliza o acesso a todas as funcionalidades importantes para a gestão financeira, facilitando o controle e entendimento das informações contábeis.</p>

        <h2 style="text-align: center; margin-top: 100px;">Gráfico Comparativo: Receitas x Despesas x Lucro</h2>
        <canvas id="graficoFinanceiro" style="margin-top: 60px;"></canvas>

        <div class="graficos">
            <div>
                <h3>Custos por Categoria</h3>
                <canvas id="graficoCategoria" width="300" height="300"></canvas>
            </div>
            <div>
                <h3>Custos por Subcategoria</h3>
                <canvas id="graficoSubcategoria" width="300" height="300"></canvas>
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
    </main>
</div>

<footer>
    <div>
        <h4>DECORACERTO – GIMC</h4>
        <a href="#">Quem Somos</a>
        <a href="#">Nossa Localização</a>
        <a href="#">Política de Privacidade</a>
        <a href="#">Segurança da Informação</a>
    </div>
    <div>
        <h4>AJUDA E SUPORTE</h4>
        <a href="#">Locação Segura</a>
        <a href="#">Pagamento</a>
        <a href="#">Dúvidas Frequentes</a>
    </div>
    <div>
        <h4>CONTATO</h4>
        <a href="#">(77) 99165-7243</a>
        <a href="#">(77) 99886-2327</a>
        <a href="#">decoracerto@gmail.com</a>
    </div>
    <div>
        <h4>ATENDIMENTO</h4>
        <p>Seg. a Sex. das 08h às 18h</p>
        <p>Sábados das 08h às 12h</p>
    </div>
</footer>

<script>
const ctx = document.getElementById('graficoFinanceiro').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_column($periodo, 'mes')) ?>,
        datasets: [
            {
                label: 'Receitas',
                backgroundColor: 'rgba(75, 192, 192, 0.7)',
                data: <?= json_encode(array_column($periodo, 'receitas')) ?>
            },
            {
                label: 'Despesas',
                backgroundColor: 'rgba(255, 99, 132, 0.7)',
                data: <?= json_encode(array_column($periodo, 'despesas')) ?>
            },
            {
                label: 'Lucro Líquido',
                backgroundColor: 'rgba(153, 102, 255, 0.7)',
                data: <?= json_encode(array_column($periodo, 'lucro')) ?>
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        },
        plugins: {
            legend: { position: 'bottom' }
        }
    }
});

// Gráfico Categoria
new Chart(document.getElementById('graficoCategoria'), {
    type: 'pie',
    data: {
        labels: <?= json_encode(array_keys($categorias)) ?>,
        datasets: [{
            data: <?= json_encode(array_values($categorias)) ?>,
            backgroundColor: ['#5fd4ffff', '#edf503ff', '#FFB946', '#E74C3C']
        }]
    }
});

// Gráfico Subcategoria
new Chart(document.getElementById('graficoSubcategoria'), {
    type: 'pie',
    data: {
        labels: <?= json_encode(array_keys($subcategorias)) ?>,
        datasets: [{
            data: <?= json_encode(array_values($subcategorias)) ?>,
            backgroundColor: ['#8dca97ff', '#e99139ff', '#F39C12', '#1ABC9C']
        }]
    }
});
</script>
</body>
</html>
