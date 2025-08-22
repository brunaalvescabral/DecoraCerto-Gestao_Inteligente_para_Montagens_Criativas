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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 40px;
            background: linear-gradient(to right, #705fc4ff, #1abc9c);
            color: #333;
        }

        .topo {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        h2 {
            text-align: center;
            color: #fff;
            flex: 1;
            margin: 0;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        }

        .botao {
            background: #2c3e50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        .botao:hover {
            background-color: #1a242f;
        }

        table {
            width: 100%;
            background-color: #ffffff;
            border-collapse: collapse;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 14px 18px;
            text-align: left;
            border-bottom: 1px solid #ccc;
            font-size: 15px;
        }

        th {
            background: #8e44ad;
            color: white;
            text-transform: uppercase;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        a.acao {
            background: linear-gradient(to right, #8e44ad, #1abc9c);
            color: white;
            padding: 8px 14px;
            text-decoration: none;
            border-radius: 6px;
            font-size: 14px;
            transition: opacity 0.3s ease;
        }

        a.acao:hover {
            opacity: 0.85;
        }

        p {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            text-align: center;
            font-size: 16px;
        }
    </style>
</head>
<body>

<div class="topo">
    <a href="dashboard_catalogo_gerente.php" class="botao">← Voltar</a>
    <h2>Notas Fiscais</h2>
    <div style="width: 120px;"></div> <!-- espaço à direita p/ alinhar -->
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
