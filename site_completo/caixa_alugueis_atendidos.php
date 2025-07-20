<?php
include 'conexao.php';

// Filtro de datas
$data_inicio = $_GET['data_inicio'] ?? '';
$data_fim = $_GET['data_fim'] ?? '';

$sql = "SELECT a.*, c.nome AS cliente_nome, k.nome AS kit_nome
        FROM alugueis a
        JOIN clientes c ON a.cliente_id = c.id
        JOIN kits k ON a.kit_id = k.id
        WHERE a.atendido = 1";

if ($data_inicio && $data_fim) {
    $sql .= " AND a.data_retirada BETWEEN '$data_inicio' AND '$data_fim'";
}

$sql .= " ORDER BY a.data_retirada DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Orçamentos Atendidos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f9fc;
            margin: 20px;
            color: #333;
        }

        .btn-voltar {
            display: inline-block;
            margin-bottom: 20px;
            background-color: #007bff;
            color: white;
            padding: 8px 16px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .btn-voltar:hover {
            background-color: #0056b3;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #007bff;
        }

        form {
            text-align: center;
            margin-bottom: 25px;
        }

        label {
            margin: 0 10px;
            font-weight: 600;
        }

        input[type="date"] {
            padding: 6px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-left: 5px;
            font-size: 1em;
        }

        button {
            background-color: #007bff;
            border: none;
            color: white;
            padding: 8px 16px;
            margin-left: 15px;
            font-size: 1em;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #007bff;
            color: white;
            font-weight: 600;
        }

        tr:hover {
            background-color: #f1f7ff;
        }

        a button {
            background-color: #28a745;
            padding: 6px 12px;
            font-size: 0.9em;
            border-radius: 4px;
            border: none;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        a button:hover {
            background-color: #1e7e34;
        }

        @media (max-width: 768px) {
            body {
                margin: 10px;
            }
            table, thead, tbody, th, td, tr {
                display: block;
            }
            th {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }
            tr {
                margin-bottom: 15px;
                border: 1px solid #ccc;
                border-radius: 5px;
                padding: 10px;
            }
            td {
                border: none;
                position: relative;
                padding-left: 50%;
                text-align: left;
            }
            td:before {
                position: absolute;
                top: 12px;
                left: 15px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
                font-weight: 600;
                content: attr(data-label);
            }
            a button {
                width: 100%;
                box-sizing: border-box;
            }
        }
    </style>
</head>
<body>

<a href="menu_atendente.php" class="btn-voltar">← Voltar</a>

<h2>Orçamentos Atendidos</h2>

<form method="GET">
    <label>De:
        <input type="date" name="data_inicio" value="<?= htmlspecialchars($data_inicio) ?>">
    </label>
    <label>Até:
        <input type="date" name="data_fim" value="<?= htmlspecialchars($data_fim) ?>">
    </label>
    <button type="submit">Filtrar</button>
</form>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Kit</th>
            <th>Retirada</th>
            <th>Devolução</th>
            <th>Valor Total</th>
            <th>Ação</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result->num_rows === 0): ?>
            <tr><td colspan="7">Nenhum orçamento atendido encontrado.</td></tr>
        <?php else: ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td data-label="ID"><?= $row['id'] ?></td>
                    <td data-label="Cliente"><?= htmlspecialchars($row['cliente_nome']) ?></td>
                    <td data-label="Kit"><?= htmlspecialchars($row['kit_nome']) ?></td>
                    <td data-label="Retirada"><?= date('d/m/Y', strtotime($row['data_retirada'])) ?></td>
                    <td data-label="Devolução"><?= date('d/m/Y', strtotime($row['data_devolucao'])) ?></td>
                    <td data-label="Valor Total">R$ <?= number_format($row['valor_total'], 2, ',', '.') ?></td>
                    <td data-label="Ação">
                        <a href="caixa_visualizar_orcamento.php?id=<?= $row['id'] ?>"><button type="button">Visualizar</button></a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>
