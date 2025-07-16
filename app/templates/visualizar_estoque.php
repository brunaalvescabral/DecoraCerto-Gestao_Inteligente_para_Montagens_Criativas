<?php
include_once __DIR__ . '/conexao.php';

if (!$conn) {
    die("Erro: conexão com o banco não estabelecida.");
}

// Consulta todos os produtos das notas fiscais
$sql = "SELECT id, nome, valor_unitario, imagem, quantidade, nota_fiscal_id 
        FROM produtos_nota 
        ORDER BY nome ASC";

$result = $conn->query($sql);

if (!$result) {
    die("Erro na consulta: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Estoque Geral</title>
</head>
<body>
    <h1>Todos os Produtos no Estoque (Notas Fiscais)</h1>

    <?php if ($result->num_rows === 0): ?>
        <p>Nenhum produto cadastrado no estoque.</p>
    <?php else: ?>
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>ID Nota Fiscal</th>
                    <th>Nome do Produto</th>
                    <th>Valor Unitário</th>
                    <th>Quantidade</th>
                    <th>Imagem</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nota_fiscal_id']) ?></td>
                        <td><?= htmlspecialchars($row['nome']) ?></td>
                        <td>R$ <?= number_format($row['valor_unitario'], 2, ',', '.') ?></td>
                        <td><?= htmlspecialchars($row['quantidade']) ?></td>
                        <td>
                            <?php if (!empty($row['imagem'])): ?>
                                <img src="assets/imagens/<?= htmlspecialchars($row['imagem']) ?>" width="100" alt="Imagem do produto">
                            <?php else: ?>
                                <form action="atualizar_imagem_produto.php" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="produto_id" value="<?= $row['id'] ?>">
                                    <input type="file" name="imagem" required>
                                    <button type="submit">Adicionar</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
