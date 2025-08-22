<?php
// Caminho correto para incluir a conexão
require_once 'conexao.php'; // Caminho atualizado para um nível acima

// Consulta para obter as pré-reservas feitas por clientes
$sql = "SELECT pr.id, pr.cliente_id, pr.kit_id, c.nome AS nome_cliente, k.nome AS nome_kit, pr.data_retirada, pr.data_devolucao
        FROM prereservas pr
        INNER JOIN clientes c ON pr.cliente_id = c.id
        INNER JOIN kits k ON pr.kit_id = k.id
        WHERE pr.atendido = '0'
        ORDER BY pr.data_retirada ASC";

$resultado = $conn->query($sql);

if (!$resultado) {
    die("Erro ao buscar pré-reservas: " . $mysqli->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pré-Reservas - Atendente</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .top-buttons {
            text-align: center;
            margin-top: 20px;
        }
        .botao {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            margin: 5px;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            display: inline-block;
        }
        .botao:hover {
            background-color: #45a049;
        }
        table {
            width: 90%;
            margin: auto;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #aaa;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #ddd;
        }
        h2 {
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>

<h2>Pré-Reservas Recebidas</h2>

<div class="top-buttons">
    <a class="botao" href="dashboard_alugueis.php">← Voltar</a>
</div>

<table>
    <tr>
        <th>Cliente</th>
        <th>Kit</th>
        <th>Data Retirada</th>
        <th>Data Devolução</th>
        <th>Ações</th>
    </tr>
    <?php while($row = $resultado->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['nome_cliente']) ?></td>
            <td><?= htmlspecialchars($row['nome_kit']) ?></td>
            <td><?= htmlspecialchars($row['data_retirada']) ?></td>
            <td><?= htmlspecialchars($row['data_devolucao']) ?></td>
            <td>
                <a class="botao" href="aluguel_kit.php?cliente_id=<?= $row['cliente_id'] ?>&cliente_nome=<?= urlencode($row['nome_cliente']) ?>&kit_id=<?= $row['kit_id'] ?>&kit_nome=<?= urlencode($row['nome_kit']) ?>&data_retirada=<?= $row['data_retirada'] ?>&data_devolucao=<?= $row['data_devolucao'] ?>">Gerar Orçamento</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
