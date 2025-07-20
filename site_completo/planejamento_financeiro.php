<?php
// Conexão com banco
$mysqli = new mysqli("localhost", "root", "", "sistema");
if ($mysqli->connect_errno) {
    die("Erro na conexão: " . $mysqli->connect_error);
}

// Criar tabela metas se não existir
$mysqli->query("CREATE TABLE IF NOT EXISTS metas_financeiras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(255) NOT NULL,
    valor_alvo DECIMAL(10,2) NOT NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('Pendente','Concluída') DEFAULT 'Pendente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

// Inserir nova meta
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['descricao'])) {
    $descricao = $_POST['descricao'];
    $valor_alvo = (float)$_POST['valor_alvo'];

    $stmt = $mysqli->prepare("INSERT INTO metas_financeiras (descricao, valor_alvo) VALUES (?, ?)");
    $stmt->bind_param("sd", $descricao, $valor_alvo);
    $stmt->execute();
    header("Location: planejamento_financeiro.php");
    exit;
}

// Marcar como concluída
if (isset($_GET['concluir_id'])) {
    $id = (int)$_GET['concluir_id'];
    $mysqli->query("UPDATE metas_financeiras SET status='Concluída' WHERE id=$id");
    header("Location: planejamento_financeiro.php");
    exit;
}

// Buscar metas
$metas = $mysqli->query("SELECT * FROM metas_financeiras ORDER BY data_criacao DESC");

// Buscar totais do sistema
$totalReceitas = (float)($mysqli->query("SELECT SUM(valor) as total FROM receitas")->fetch_assoc()['total'] ?? 0);
$totalDespesas = (float)($mysqli->query("SELECT SUM(valor) as total FROM contas_pagar WHERE status='Pendente'")->fetch_assoc()['total'] ?? 0);
$totalInvestimentos = (float)($mysqli->query("SELECT SUM(valor_investido) as total FROM investimentos WHERE status='Ativo'")->fetch_assoc()['total'] ?? 0);

$valorSugerido = max(0, $totalReceitas - $totalDespesas - $totalInvestimentos);

// Preparar dados das metas
$metas_array = [];
foreach ($metas as $meta) {
    $valor_atual = min($valorSugerido, (float)$meta['valor_alvo']);
    $metas_array[] = [
        'id' => $meta['id'],
        'descricao' => $meta['descricao'],
        'valor_alvo' => (float)$meta['valor_alvo'],
        'valor_atual' => $valor_atual,
        'status' => $meta['status']
    ];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Planejamento Financeiro</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: Arial; margin: 0; display: flex; }
        nav { width: 220px; background: #007bff; padding: 30px 20px; color: #fff; }
        nav h2 { text-align: center; margin-bottom: 30px; }
        nav a { display: block; color: white; text-decoration: none; padding: 10px; border-radius: 5px; margin-bottom: 10px; }
        nav a:hover, nav a.active { background: #0056b3; }
        main { flex-grow: 1; padding: 30px; background: #f9f9f9; }
        h1 { margin-top: 0; }
        form { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 30px; }
        form input, form button { padding: 10px; border-radius: 5px; border: 1px solid #ccc; font-size: 16px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
        th { background: #007bff; color: white; }
        .status-pendente { color: #dc3545; font-weight: bold; }
        .status-concluida { color: #28a745; font-weight: bold; }
        .btn-concluir { background: #28a745; color: white; padding: 6px 10px; border-radius: 5px; text-decoration: none; }
        canvas { max-width: 100%; margin-top: 30px; }
    </style>
</head>
<body>

<nav>
    <p><a href="dashboard_financeiro.php">← Voltar</a></p>
    <h2>Planejamento</h2>
    <a href="#" onclick="mostrar('metas', this)" class="active">Metas</a>
    <a href="#" onclick="mostrar('grafico', this)">Gráfico</a>
</nav>

<main>
    <section id="metas">
        <h1>Metas Financeiras</h1>
        <form method="POST">
            <input type="text" name="descricao" placeholder="Descrição da meta" required>
            <input type="number" step="0.01" name="valor_alvo" placeholder="Valor alvo (R$)" value="<?= number_format($valorSugerido, 2, '.', '') ?>" required>
            <button type="submit">Cadastrar</button>
        </form>
        <table>
            <thead>
                <tr><th>Descrição</th><th>Valor Alvo</th><th>Valor Atual</th><th>Status</th><th>Ação</th></tr>
            </thead>
            <tbody>
                <?php foreach ($metas_array as $meta): ?>
                    <tr>
                        <td><?= $meta['descricao'] ?></td>
                        <td>R$ <?= number_format($meta['valor_alvo'], 2, ',', '.') ?></td>
                        <td>R$ <?= number_format($meta['valor_atual'], 2, ',', '.') ?></td>
                        <td class="status-<?= strtolower($meta['status']) ?>"><?= $meta['status'] ?></td>
                        <td>
                            <?php if ($meta['status'] === 'Pendente'): ?>
                                <a class="btn-concluir" href="?concluir_id=<?= $meta['id'] ?>">Concluir</a>
                            <?php else: ?>-
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <section id="grafico" style="display:none;">
        <h1>Gráfico de Metas</h1>
        <canvas id="graficoMetas"></canvas>
    </section>
</main>

<script>
function mostrar(id, el) {
    document.getElementById('metas').style.display = 'none';
    document.getElementById('grafico').style.display = 'none';
    document.getElementById(id).style.display = 'block';
    document.querySelectorAll('nav a').forEach(a => a.classList.remove('active'));
    el.classList.add('active');
}

const labels = <?= json_encode(array_column($metas_array, 'descricao')) ?>;
const valoresAlvo = <?= json_encode(array_column($metas_array, 'valor_alvo')) ?>;
const valoresAtuais = <?= json_encode(array_column($metas_array, 'valor_atual')) ?>;

new Chart(document.getElementById('graficoMetas').getContext('2d'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [
            {
                label: 'Valor Alvo',
                data: valoresAlvo,
                backgroundColor: '#007bff'
            },
            {
                label: 'Valor Atual',
                data: valoresAtuais,
                backgroundColor: '#28a745'
            }
        ]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'R$ ' + value.toLocaleString('pt-BR');
                    }
                }
            }
        }
    }
});
</script>

</body>
</html>
