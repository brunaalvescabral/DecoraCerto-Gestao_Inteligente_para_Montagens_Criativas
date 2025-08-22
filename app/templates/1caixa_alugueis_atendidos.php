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

<h2>Orçamentos Atendidos</h2>
<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Cliente</th>
        <th>Kit</th>
        <th>Retirada</th>
        <th>Devolução</th>
        <th>Valor Total</th>
        <th>Forma de Pagamento</th>
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
                <?php
                $pagamento = $conn->query("SELECT nome FROM formas_pagamento WHERE id = " . $row['forma_pagamento_id'])->fetch_assoc();
                echo htmlspecialchars($pagamento['nome'] ?? '—');
                ?>
            </td>
        </tr>
    <?php } ?>
</table>
