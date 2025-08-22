<?php
include 'conexao.php';

// Buscar aluguéis com atendido = 0
$sql = "SELECT 
            a.id,
            a.data_retirada,
            a.data_devolucao,
            a.valor_total,
            c.nome AS cliente_nome,
            k.nome AS kit_nome
        FROM alugueis a
        JOIN clientes c ON a.cliente_id = c.id
        JOIN kits k ON a.kit_id = k.id
        WHERE a.atendido = 0
        ORDER BY a.data_retirada ASC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>📋 Orçamentos Pendentes - Caixa</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f2f4f8;
            padding: 30px;
            margin: 0;
        }

        h2 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
            overflow: hidden;
        }

        thead {
            background-color: #3498db;
            color: white;
        }

        th, td {
            padding: 14px 12px;
            text-align: left;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #eef6fb;
        }

        .btn {
            background-color: #27ae60;
            color: white;
            border: none;
            padding: 8px 14px;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s ease;
            font-weight: bold;
        }

        .btn:hover {
            background-color: #219150;
        }

        .no-data {
            text-align: center;
            color: #888;
            font-size: 16px;
            margin-top: 30px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div class="container">
    <a href="caixa_aluguel_atendido.php" class="btn" style="display:inline-block; padding:8px 12px; background:#f44336; color:#fff; border-radius:8px; text-decoration:none; cursor:pointer;">Voltar</a>

    <h2>📋 Orçamentos Pendentes</h2>

    <?php if ($result->num_rows > 0) { ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Kit</th>
                    <th>Data Retirada</th>
                    <th>Data Devolução</th>
                    <th>Valor Total (R$)</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['cliente_nome']) ?></td>
                        <td><?= htmlspecialchars($row['kit_nome']) ?></td>
                        <td><?= date("d/m/Y", strtotime($row['data_retirada'])) ?></td>
                        <td><?= date("d/m/Y", strtotime($row['data_devolucao'])) ?></td>
                        <td>R$ <?= number_format($row['valor_total'], 2, ',', '.') ?></td>
                        <td>
                            <form action="caixa_editar_orcamento.php" method="GET">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <button type="submit" class="btn">Selecionar</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="no-data">✅ Nenhum orçamento pendente encontrado.</p>
    <?php } ?>

</div>
</body>
</html>
