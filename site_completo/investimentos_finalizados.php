<?php
$mysqli = new mysqli("localhost", "root", "", "sistema");
if ($mysqli->connect_errno) {
    die("Erro na conexão: " . $mysqli->connect_error);
}

$finalizados = $mysqli->query("SELECT * FROM investimentos WHERE status = 'Finalizado' ORDER BY data_investimento DESC");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8" />
<title>Investimentos Finalizados</title>
<style>
    body { font-family: Arial; background: #f4f4f4; padding: 20px; }
    .container { max-width: 1100px; margin: auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px #ccc; }
    h1, h2 { text-align: center; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 40px; }
    th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
    th { background: #007bff; color: white; }
    a { display: inline-block; margin-top: 10px; color: #007bff; text-decoration: none; }
    a:hover { text-decoration: underline; }
</style>
</head>
<body>
<div class="container">
    <h1>Investimentos Finalizados</h1>
    <table>
        <tr>
            <th>Nome</th><th>Tipo</th><th>Valor Investido</th><th>Valor Real</th><th>Rentabilidade (%)</th><th>Data</th><th>Status</th>
        </tr>
        <?php while ($row = $finalizados->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['nome']) ?></td>
            <td><?= htmlspecialchars($row['tipo']) ?></td>
            <td>R$ <?= number_format($row['valor_investido'], 2, ',', '.') ?></td>
            <td>R$ <?= number_format($row['valor_real'], 2, ',', '.') ?></td>
            <td><?= number_format($row['rentabilidade_esperada'], 2, ',', '.') ?>%</td>
            <td><?= date('d/m/Y', strtotime($row['data_investimento'])) ?></td>
            <td><?= htmlspecialchars($row['status']) ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <p><a href="investimentos_dashboard.php">← Voltar</a></p>
</div>
</body>
</html>
