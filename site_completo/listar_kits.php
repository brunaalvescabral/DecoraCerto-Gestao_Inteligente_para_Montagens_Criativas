<?php
include_once __DIR__ . '/conexao.php';

if (!isset($conn)) {
    die("Erro: conexão com o banco não estabelecida.");
}

$sql = "SELECT * FROM kits";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Kits</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.08);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 15px;
        }

        th, td {
            padding: 12px 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .status-ativo {
            color: green;
            font-weight: bold;
        }

        .status-inativo {
            color: red;
            font-weight: bold;
        }

        img {
            width: 100px;
            height: auto;
            border-radius: 6px;
        }

        .editar-btn {
            background-color: #007bff;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
        }

        .editar-btn:hover {
            background-color: #0056b3;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .adicionar-btn {
            background-color: #28a745;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            font-size: 15px;
            text-decoration: none;
        }

        .adicionar-btn:hover {
            background-color: #218838;
        }

    </style>
</head>
<body>
    <div class="container">
        <a href="dashboard_catalogo_gerente.php" class="botao-voltar">← Voltar</a>
        <div class="top-bar">
            <h1>Lista de Kits</h1>
            <a href="adicionar_kit.php" class="adicionar-btn">+ Adicionar Novo Kit</a>
        </div>

        <table>
            <tr>
                <th>Nome</th>
                <th>Categoria</th>
                <th>Componentes</th>
                <th>Valor</th>
                <th>Observações</th>
                <th>Status</th>
                <th>Imagem</th>
                <th>Ações</th>
            </tr>

            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['nome']) ?></td>
                    <td><?= htmlspecialchars($row['categoria']) ?></td>
                    <td><?= htmlspecialchars($row['componentes']) ?></td>
                    <td>R$ <?= number_format($row['valor'], 2, ',', '.') ?></td>
                    <td><?= htmlspecialchars($row['observacoes']) ?></td>
                    <td class="status-<?= $row['status'] ?>">
                        <?= ucfirst($row['status']) ?>
                    </td>
                    <td>
                        <?php if (!empty($row['imagem'])): ?>
                            <img src="assets/imagens/<?= htmlspecialchars($row['imagem']) ?>" alt="Imagem do kit">
                        <?php else: ?>
                            <em>Sem imagem</em>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="editar_kit.php?id=<?= $row['id'] ?>" class="editar-btn">Editar</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
