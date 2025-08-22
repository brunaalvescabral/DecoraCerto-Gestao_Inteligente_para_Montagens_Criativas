<?php
require_once("conexao.php");

$sql = "SELECT * FROM contas_pagar ORDER BY data_vencimento ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Contas a Pagar</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #6858b7ff, #1abc9c);
            margin: 0;
            padding: 20px 30px;
            color: #333;
        }

        .container {
            max-width: 1100px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 32px;
        }

        .botao-voltar {
            display: inline-block;
            background: #6a11cb;
            color: white;
            padding: 10px 18px;
            border-radius: 10px;
            text-decoration: none;
            margin-bottom: 20px;
            font-weight: bold;
            transition: 0.3s;
        }

        .botao-voltar:hover {
            background: #4e0ec0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #e0e0e0;
            text-align: left;
        }

        th {
            background: #f1f1f1;
            color: #333;
            font-weight: 600;
        }

        a.btn {
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        .editar {
            background: #ffc107;
            color: #fff;
        }

        .editar:hover {
            background: #e0a800;
        }

        .pagar {
            background: #28a745;
            color: #fff;
        }

        .pagar:hover {
            background: #218838;
        }

        .status-paga {
            color: #28a745;
            font-weight: bold;
        }

        .status-pendente {
            color: #dc3545;
            font-weight: bold;
        }

        tr:hover {
            background: #f9f9f9;
        }

        @media screen and (max-width: 768px) {
            .container {
                padding: 20px;
            }

            table, thead, tbody, th, td, tr {
                display: block;
            }

            th {
                display: none;
            }

            td {
                padding: 10px;
                position: relative;
                padding-left: 50%;
                text-align: right;
            }

            td:before {
                content: attr(data-label);
                position: absolute;
                left: 15px;
                width: 45%;
                padding-left: 15px;
                font-weight: bold;
                text-align: left;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="dashboard_contas_pagar.php" class="botao-voltar">← Voltar</a>
        <h2>Contas Registradas</h2>
        <table>
            <thead>
                <tr>
                    <th>Descrição</th>
                    <th>Valor</th>
                    <th>Vencimento</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td data-label="Descrição"><?= $row['descricao'] ?></td>
                    <td data-label="Valor">R$ <?= number_format($row['valor'], 2, ',', '.') ?></td>
                    <td data-label="Vencimento"><?= date('d/m/Y', strtotime($row['data_vencimento'])) ?></td>
                    <td data-label="Status">
                        <?php if ($row['status'] == 'Paga'): ?>
                            <span class="status-paga">Paga</span>
                        <?php else: ?>
                            <span class="status-pendente">Pendente</span>
                        <?php endif; ?>
                    </td>
                    <td data-label="Ações">
                        <a class="btn editar" href="editar_conta.php?id=<?= $row['id'] ?>">Editar</a>
                        <?php if ($row['status'] == 'Pendente'): ?>
                            <a class="btn pagar" href="marcar_conta_paga.php?id=<?= $row['id'] ?>">Paga</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
