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
            background: #f7f9fc;
            margin: 0; padding: 20px 30px;
            color: #333;
        }
        h2 {
            color: #004085;
            border-bottom: 3px solid #007bff;
            padding-bottom: 6px;
            margin-bottom: 25px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 15px rgb(0 0 0 / 0.1);
            font-size: 15px;
        }
        thead {
            background-color: #007bff;
            color: white;
        }
        th, td {
            padding: 14px 18px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }
        tbody tr:hover {
            background-color: #f1f5fb;
        }
        a {
            color: #007bff;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        a:hover {
            color: #0056b3;
            text-decoration: underline;
        }
        @media (max-width: 720px) {
            table, thead, tbody, th, td, tr {
                display: block;
                width: 100%;
            }
            thead tr {
                display: none; /* Esconder cabeçalho para visual móvel */
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
                font-weight: 700;
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
                            <a href="financeiro_editar_nota.php?id=<?= $nota['id'] ?>">Editar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5" style="text-align:center; padding: 20px;">Nenhuma nota fiscal cadastrada.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
