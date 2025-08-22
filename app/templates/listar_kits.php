<?php
include_once __DIR__ . '/conexao.php';

if (!isset($conn)) {
    die("Erro: conexão com o banco não estabelecida.");
}

$sql = "SELECT * FROM kits";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Listar Kits</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .status-ativo {
            color: green;
            font-weight: bold;
        }

        .status-inativo {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Lista de Kits</h1>
    <table>
        <tr>
            <th>Nome</th>
            <th>Categoria</th>
            <th>Componentes</th>
            <th>Valor</th>
            <th>Observações</th>
            <th>Status</th>
            <th>Imagem</th>
            <th>Editar</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= htmlspecialchars($row['nome']) ?></td>
                <td><?= htmlspecialchars($row['categoria']) ?></td>
                <td><?= htmlspecialchars($row['componentes']) ?></td>
                <td><?= number_format($row['valor'], 2, ',', '.') ?></td>
                <td><?= htmlspecialchars($row['observacoes']) ?></td>
                <td class="status-<?= $row['status'] ?>">
                    <?= ucfirst($row['status']) ?>
                </td>
                <td>
                    <?php if (!empty($row['imagem'])): ?>
                        <img src="assets/imagens/<?= htmlspecialchars($row['imagem']) ?>" alt="Imagem do kit" width="100">
                    <?php else: ?>
                        Sem imagem
                    <?php endif; ?>
                </td>
                <td>
                    <a href="editar_kit.php?id=<?= $row['id'] ?>" title="Editar Kit">✏️</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
