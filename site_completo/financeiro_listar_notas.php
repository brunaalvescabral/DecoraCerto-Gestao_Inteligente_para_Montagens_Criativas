<?php
include 'conexao.php';

$result = $conn->query("SELECT * FROM notas_fiscais ORDER BY data_cadastro DESC");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Notas Fiscais Cadastradas</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #6858b7ff, #1abc9c);
            margin: 0;
            padding: 40px 30px;
            color: #333;
        }

        a.voltar {
            background-color: rgba(32, 48, 65, 1)ff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            transition: background 0.3s ease;
            display: inline-block;
            margin-bottom: 30px;
        }

        a.voltar:hover {
            background-color: #1e49a6ff;
        }

        h2 {
            text-align: center;
            color: #fff;
            margin-bottom: 30px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            font-size: 15px;
        }

        thead {
            background-color: #444dadff;
            color: white;
        }

        th, td {
            padding: 14px 18px;
            text-align: left;
            border-bottom: 1px solid #e6e6e6;
        }

        tbody tr:hover {
            background-color: #f9f9f9;
        }

        a.acao {
            background: linear-gradient(to right, #499259ff, #468f56ff);
            color: white;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 14px;
            transition: opacity 0.3s ease;
        }

        a.acao:hover {
            opacity: 0.85;
        }

        td[colspan="5"] {
            text-align: center;
            padding: 30px;
            background-color: #fff;
            border-radius: 0 0 12px 12px;
        }

        @media (max-width: 720px) {
            table, thead, tbody, th, td, tr {
                display: block;
                width: 100%;
            }

            thead tr {
                display: none;
            }

            tbody tr {
                margin-bottom: 20px;
                background: white;
                border-radius: 8px;
                box-shadow: 0 3px 8px rgb(0 0 0 / 0.1);
                padding: 15px;
            }

            tbody td {
                padding-left: 50%;
                position: relative;
                text-align: right;
                border: none;
                border-bottom: 1px solid #eee;
            }

            tbody td::before {
                content: attr(data-label);
                position: absolute;
                left: 15px;
                top: 14px;
                font-weight: bold;
                text-transform: uppercase;
                font-size: 13px;
                color: #555;
                text-align: left;
                width: calc(50% - 30px);
            }
        }
    </style>
</head>
<body>

    <a href="dashboard_notas_fiscais.php" class="voltar">← Voltar</a>

    <h2>Notas Fiscais Cadastradas</h2>

    <table>
        <thead>
            <tr>
                <th>Número</th>
                <th>Empresa</th>
                <th>Valor</th>
                <th>Data</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($nota = $result->fetch_assoc()): ?>
                    <tr>
                        <td data-label="Número"><?= htmlspecialchars($nota['numero_nota']) ?></td>
                        <td data-label="Empresa"><?= htmlspecialchars($nota['empresa']) ?></td>
                        <td data-label="Valor">R$ <?= number_format($nota['valor'], 2, ',', '.') ?></td>
                        <td data-label="Data"><?= date('d/m/Y H:i', strtotime($nota['data_cadastro'])) ?></td>
                        <td data-label="Ações">
                            <a href="financeiro_editar_nota.php?id=<?= $nota['id'] ?>" class="acao">Editar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5">Nenhuma nota fiscal cadastrada.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>
