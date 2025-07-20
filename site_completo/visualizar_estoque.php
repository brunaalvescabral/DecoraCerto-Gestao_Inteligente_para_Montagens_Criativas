<?php
include_once __DIR__ . '/conexao.php';

if (!$conn) {
    die("Erro: conexão com o banco não estabelecida.");
}

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
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f9f9f9;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #0d6efd;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        img {
            width: 100px;
            height: auto;
            border-radius: 4px;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        input[type="file"] {
            padding: 4px;
        }
        button {
            background-color: #198754;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #146c43;
        }
        .no-produtos {
            padding: 20px;
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="buttons">
           <a href="dashboard_catalogo_gerente.php" class="botao">← Voltar</a>
    </div>
    <h1>📦 Estoque Geral - Produtos das Notas Fiscais</h1>

    <?php if ($result->num_rows === 0): ?>
        <div class="no-produtos">Nenhum produto cadastrado no estoque.</div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID Nota Fiscal</th>
                    <th>Produto</th>
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
                                <img src="assets/imagens/<?= htmlspecialchars($row['imagem']) ?>" alt="Imagem do produto">
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
