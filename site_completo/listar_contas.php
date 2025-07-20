<?php
require_once("conexao.php");

$sql = "SELECT * FROM contas_pagar ORDER BY data_vencimento ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Contas a Pagar</title>
    <style>
        body { font-family: Arial; padding: 30px; background: #f0f0f0; }
        .container { max-width: 900px; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px #ccc; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border-bottom: 1px solid #ccc; text-align: left; }
        th { background: #f8f8f8; }
        a.btn { padding: 6px 10px; text-decoration: none; border-radius: 5px; margin-right: 5px; font-size: 14px; }
        .editar { background: #ffc107; color: white; }
        .pagar { background: #28a745; color: white; }
        .status-paga { color: green; font-weight: bold; }
        .status-pendente { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <a href="dashboard_contas_pagar.php" class="botao-voltar">← Voltar</a>
        <h2>Contas Registradas</h2>
        <table>
            <tr>
                <th>Descrição</th>
                <th>Valor</th>
                <th>Vencimento</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['descricao'] ?></td>
                <td>R$ <?= number_format($row['valor'], 2, ',', '.') ?></td>
                <td><?= date('d/m/Y', strtotime($row['data_vencimento'])) ?></td>
                <td>
                    <?php if ($row['status'] == 'Paga'): ?>
                        <span class="status-paga">Paga</span>
                    <?php else: ?>
                        <span class="status-pendente">Pendente</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a class="btn editar" href="editar_conta.php?id=<?= $row['id'] ?>">Editar</a>
                    <?php if ($row['status'] == 'Pendente'): ?>
                        <a class="btn pagar" href="marcar_conta_paga.php?id=<?= $row['id'] ?>">Paga</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
