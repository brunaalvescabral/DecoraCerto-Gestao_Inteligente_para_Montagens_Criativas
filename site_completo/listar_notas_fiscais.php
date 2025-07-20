<?php
include_once __DIR__ . '/conexao.php';

$result = $conn->query("SELECT id, numero_nota, data_cadastro FROM notas_fiscais");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Notas Fiscais</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f4f4f4;
        }
        h2 {
            color: #333;
        }
        .topo {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .botao {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            border: none;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .botao:hover {
            background-color: #218838;
        }
        table {
            width: 100%;
            background-color: white;
            border-collapse: collapse;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        a.acao {
            background-color: #007bff;
            color: white;
            padding: 6px 10px;
            text-decoration: none;
            border-radius: 4px;
        }
        a.acao:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="topo">
    <h2>Notas Fiscais</h2>
    <a href="dashboard_catalogo_gerente.php" class="botao">← Voltar</a>
</div>

<?php if ($result->num_rows === 0): ?>
    <p>Nenhuma nota fiscal cadastrada.</p>
<?php else: ?>
    <table>
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
                <td><?= date('d/m/Y', strtotime($row['data_cadastro'])) ?></td>
                <td>
                    <a class="acao" href="visualizar_estoque.php?nota_fiscal_id=<?= $row['id'] ?>">Visualizar Estoque</a>
                </td>
            </tr>
        <?php } ?>
    </table>
<?php endif; ?>

</body>
</html>
