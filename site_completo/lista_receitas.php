<?php
$mysqli = new mysqli("localhost", "root", "", "sistema");
if ($mysqli->connect_errno) {
    die("Falha na conexão: " . $mysqli->connect_error);
}

$sql = "SELECT r.id, r.origem, r.origem_id, r.descricao, r.valor, r.data_receita, r.criado_em,
        a.cliente_id, a.kit_id
        FROM receitas r
        LEFT JOIN alugueis a ON r.origem = 'aluguel' AND r.origem_id = a.id
        ORDER BY r.data_receita DESC, r.criado_em DESC";

$result = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Listagem de Receitas</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background:#f0f0f0;}
        .container { max-width: 1000px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px #ccc;}
        table { width: 100%; border-collapse: collapse; margin-top: 20px;}
        th, td { padding: 8px 12px; border: 1px solid #ccc; text-align: left; font-size: 14px;}
        th { background: #007bff; color: white; }
        a { text-decoration:none; color:#007bff; }
        a:hover { text-decoration: underline; }
        .origem-manual { color: #28a745; font-weight: bold;}
        .origem-aluguel { color: #17a2b8; font-weight: bold;}
        a.botao-voltar { display: inline-block; margin-bottom: 10px; color: #007bff;}
    </style>
</head>
<body>
<div class="container">
    <a href="dashboard_receitas.php" class="botao-voltar">← Voltar</a>
    <h1>Listagem de Receitas</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Origem</th>
                <th>Descrição</th>
                <th>Valor (R$)</th>
                <th>Data Receita</th>
                <th>Data Cadastro</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td class="<?= $row['origem'] == 'manual' ? 'origem-manual' : 'origem-aluguel' ?>">
                        <?= ucfirst($row['origem']) ?>
                    </td>
                    <td><?= htmlspecialchars($row['descricao'] ?: "Receita do aluguel #{$row['origem_id']}") ?></td>
                    <td><?= number_format($row['valor'], 2, ',', '.') ?></td>
                    <td><?= date('d/m/Y', strtotime($row['data_receita'])) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($row['criado_em'])) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
