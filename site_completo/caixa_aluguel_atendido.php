<?php
include 'conexao.php';

$sql = "SELECT a.*, c.nome AS cliente_nome, k.nome AS kit_nome 
        FROM alugueis a
        JOIN clientes c ON a.cliente_id = c.id
        JOIN kits k ON a.kit_id = k.id
        WHERE a.atendido = 1
        ORDER BY a.data_retirada DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>📦 Aluguéis Atendidos - Caixa</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 30px;
        }

        h2 {
            text-align: center;
            color: #2c3e50;
        }

        .tabs {
            margin: 20px 0;
            text-align: center;
        }

        .tabs a {
            text-decoration: none;
            padding: 10px 20px;
            margin: 0 8px;
            background-color: #3498db;
            color: white;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .tabs a:hover,
        .tabs a.active {
            background-color: #2980b9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 14px 12px;
            text-align: left;
        }

        thead {
            background-color: #34495e;
            color: white;
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tbody tr:hover {
            background-color: #eef6fb;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
        }

        .no-data {
            padding: 20px;
            background-color: #fce4e4;
            color: #c0392b;
            text-align: center;
            margin-top: 20px;
            border-radius: 8px;
        }
    </style>
</head>
<body>
<div class="container">

    <h2>📦 Aluguéis Atendidos</h2>

    <div class="tabs">
        <a href="menu_principal.php" >Voltar ao menu</a>
        <a href="caixa_alugueis_atendidos.php" class="active">Aluguéis Atendidos</a>
        <a href="caixa_orcamentos_pendentes.php">Aluguéis Pendentes</a>
    </div>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Kit</th>
                    <th>Retirada</th>
                    <th>Devolução</th>
                    <th>Valor Total</th>
                    <th>Forma de Pagamento</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['cliente_nome']) ?></td>
                        <td><?= htmlspecialchars($row['kit_nome']) ?></td>
                        <td><?= date("d/m/Y", strtotime($row['data_retirada'])) ?></td>
                        <td><?= date("d/m/Y", strtotime($row['data_devolucao'])) ?></td>
                        <td>R$ <?= number_format($row['valor_total'], 2, ',', '.') ?></td>
                        <td>
                            <?php
                            $pagamento = $conn->query("SELECT nome FROM formas_pagamento WHERE id = " . $row['forma_pagamento_id'])->fetch_assoc();
                            echo htmlspecialchars($pagamento['nome'] ?? '—');
                            ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="no-data">Nenhum aluguel atendido encontrado.</div>
    <?php endif; ?>

</div>
</body>
</html>
