<?php
$mysqli = new mysqli("localhost", "root", "", "sistema");
if ($mysqli->connect_errno) {
    die("Erro na conexão: " . $mysqli->connect_error);
}

// Cadastrar novo investimento
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome']) && !isset($_POST['finalizar_id'])) {
    $nome = $_POST['nome'];
    $tipo = $_POST['tipo'];
    $valor = (float)$_POST['valor_investido'];
    $rent = (float)$_POST['rentabilidade_esperada'];
    $data = $_POST['data_investimento'];

    $stmt = $mysqli->prepare("INSERT INTO investimentos (nome, tipo, valor_investido, rentabilidade_esperada, data_investimento, status) VALUES (?, ?, ?, ?, ?, 'Ativo')");
    $stmt->bind_param("ssdds", $nome, $tipo, $valor, $rent, $data);
    $stmt->execute();
    header("Location: investimentos.php");
    exit;
}

// Marcar como finalizado e atualizar valor real
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['finalizar_id'])) {
    $id = (int)$_POST['finalizar_id'];
    $valor_real = (float)$_POST['valor_real'];

    $stmt = $mysqli->prepare("UPDATE investimentos SET status = 'Finalizado', valor_real = ? WHERE id = ?");
    $stmt->bind_param("di", $valor_real, $id);
    $stmt->execute();

    header("Location: investimentos.php");
    exit;
}

// Buscar investimentos ativos
$ativos = $mysqli->query("SELECT * FROM investimentos WHERE status = 'Ativo' ORDER BY data_investimento DESC");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8" />
<title>Investimentos Ativos</title>
<style>
    body { font-family: Arial; background: #f4f4f4; padding: 20px; }
    .container { max-width: 1100px; margin: auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px #ccc; }
    h1, h2 { text-align: center; }
    form#cadastro { display: flex; flex-wrap: wrap; gap: 10px; justify-content: center; margin-bottom: 30px; }
    form#cadastro input { padding: 8px; width: 200px; border: 1px solid #ccc; border-radius: 5px; }
    form#cadastro button { background: #007bff; color: white; border: none; padding: 10px 25px; border-radius: 5px; cursor: pointer; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 40px; }
    th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
    th { background: #007bff; color: white; }
    form.finalizar-form { display: flex; justify-content: center; gap: 5px; }
    form.finalizar-form input[type="number"] { width: 120px; padding: 5px; }
    form.finalizar-form button { background: #28a745; border: none; color: white; cursor: pointer; border-radius: 5px; padding: 6px 12px; }
</style>
</head>
<body>
<div class="container">
    <h1>Investimentos Ativos</h1>

    <h2>Cadastrar Novo Investimento</h2>
    <form id="cadastro" method="POST" autocomplete="off">
        <input type="text" name="nome" placeholder="Nome do investimento" required>
        <input type="text" name="tipo" placeholder="Tipo (Ex: Renda Fixa)" required>
        <input type="number" name="valor_investido" placeholder="Valor Investido (R$)" step="0.01" min="0" required>
        <input type="number" name="rentabilidade_esperada" placeholder="Rentabilidade (%)" step="0.01" min="0" required>
        <input type="date" name="data_investimento" required>
        <button type="submit">Cadastrar</button>
    </form>

    <h2>Lista de Investimentos Ativos</h2>
    <table>
        <thead>
            <tr>
                <th>Nome</th><th>Tipo</th><th>Valor Investido</th><th>Rentabilidade (%)</th><th>Data</th><th>Finalizar</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $ativos->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['nome']) ?></td>
            <td><?= htmlspecialchars($row['tipo']) ?></td>
            <td>R$ <?= number_format($row['valor_investido'], 2, ',', '.') ?></td>
            <td><?= number_format($row['rentabilidade_esperada'], 2, ',', '.') ?>%</td>
            <td><?= date('d/m/Y', strtotime($row['data_investimento'])) ?></td>
            <td>
                <form class="finalizar-form" method="POST" onsubmit="return confirmarFinalizar(this)">
                    <input type="hidden" name="finalizar_id" value="<?= $row['id'] ?>">
                    <input type="number" step="0.01" min="0" name="valor_real" placeholder="Valor real (R$)" required>
                    <button type="submit">Finalizar</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <p><a href="investimentos_dashboard.php">← Voltar</a></p>
</div>

<script>
function confirmarFinalizar(form) {
    const valor = form.valor_real.value;
    if (!valor || parseFloat(valor) <= 0) {
        alert('Informe um valor real válido para finalizar.');
        return false;
    }
    return confirm('Tem certeza que deseja finalizar este investimento?');
}
</script>
</body>
</html>


 