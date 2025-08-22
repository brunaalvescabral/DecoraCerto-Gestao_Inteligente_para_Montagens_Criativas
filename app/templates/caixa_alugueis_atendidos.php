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

<h2>Orçamentos Atendidos</h2>

<form method="GET">
    <label>De: <input type="date" name="data_inicio" value="<?= $data_inicio ?>"></label>
    <label>Até: <input type="date" name="data_fim" value="<?= $data_fim ?>"></label>
    <button type="submit">Filtrar</button>
</form>

<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Cliente</th>
        <th>Kit</th>
        <th>Retirada</th>
        <th>Devolução</th>
        <th>Valor Total</th>
        <th>Ação</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['cliente_nome']) ?></td>
            <td><?= htmlspecialchars($row['kit_nome']) ?></td>
            <td><?= $row['data_retirada'] ?></td>
            <td><?= $row['data_devolucao'] ?></td>
            <td>R$ <?= number_format($row['valor_total'], 2, ',', '.') ?></td>
            <td>
                <a href="caixa_visualizar_orcamento.php?id=<?= $row['id'] ?>"><button>Visualizar</button></a>
            </td>
        </tr>
    <?php } ?>
</table>
