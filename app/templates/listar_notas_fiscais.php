<?php
include_once __DIR__ . '/conexao.php';

$result = $conn->query("SELECT id, numero_nota, data_cadastro FROM notas_fiscais");
?>

<h2>Notas Fiscais</h2>
<table border="1" cellpadding="6">
    <tr>
        <th>ID</th>
        <th>Número</th>
        <th>Data de Emissão</th>
        <th>Ações</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['numero_nota']) ?></td>
            <td><?= htmlspecialchars($row['data_cadastro']) ?></td>
            <td>
                <a href="visualizar_estoque.php?nota_fiscal_id=<?= $row['id'] ?>">Visualizar Estoque</a>
            </td>
        </tr>
    <?php } ?>
</table>
