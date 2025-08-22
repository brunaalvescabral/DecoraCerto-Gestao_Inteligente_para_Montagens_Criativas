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
    <title>Orçamentos Pendentes - Caixa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #999;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        button {
            padding: 6px 10px;
            background-color: #3498db;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        button:hover {
            background-color: #2980b9;
        }

        h2 {
            color: #333;
        }
    </style>
</head>
<body>

<h2>Orçamentos Pendentes</h2>

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
                    <td><?= $row['data_retirada'] ?></td>
                    <td><?= $row['data_devolucao'] ?></td>
                    <td><?= number_format($row['valor_total'], 2, ',', '.') ?></td>
                    <td>
                        <form action="caixa_editar_orcamento.php" method="GET" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <button type="submit">Selecionar</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } else { ?>
    <p>✅ Nenhum orçamento pendente encontrado.</p>
<?php } ?>

</body>
</html>
