<?php
include 'conexao.php';

$sql = "SELECT a.*, c.nome AS cliente_nome, k.nome AS kit_nome 
        FROM alugueis a
        JOIN clientes c ON a.cliente_id = c.id
        JOIN kits k ON a.kit_id = k.id
        WHERE a.atendido = 0
        ORDER BY a.data_retirada";

$result = $conn->query($sql);
?>

<h2>Orçamentos Pendentes</h2>
<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Cliente</th>
        <th>Kit</th>
        <th>Data Retirada</th>
        <th>Data Devolução</th>
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
            <td><a href="caixa_editar_orcamento.php?id=<?= $row['id'] ?>"><button>Selecionar</button></a></td>
        </tr>
    <?php } ?>
</table>
