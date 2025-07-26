<?php
include 'conexao.php';

$data_inicio = $_GET['inicio'] ?? date('Y-m-01');
$data_fim = $_GET['fim'] ?? date('Y-m-t');

$query = "SELECT * FROM riscos WHERE data_registro BETWEEN '$data_inicio' AND '$data_fim'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Relatório de Riscos</title>
    <style>
        /* Mesma estilização do planejamento financeiro */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9faff;
            margin: 0;
            padding: 20px;
            color: #2c3e50;
        }

        .container {
            max-width: 900px;
            background: #fff;
            margin: 30px auto;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        form {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        form label {
            font-weight: 600;
            font-size: 0.9rem;
            display: flex;
            flex-direction: column;
            color: #34495e;
        }

        form input[type="date"] {
            padding: 8px 12px;
            border: 2px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
            min-width: 140px;
        }
        form input[type="date"]:focus {
            border-color: #3498db;
            outline: none;
        }

        form button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 700;
            font-size: 1rem;
            transition: background-color 0.3s ease;
            align-self: flex-end;
            min-width: 130px;
        }
        form button:hover {
            background-color: #2980b9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 12px 15px;
            text-align: left;
            font-size: 0.95rem;
        }

        table th {
            background-color: #3498db;
            color: white;
            font-weight: 600;
        }

        table tr:nth-child(even) {
            background-color: #f4f7fb;
        }

        a.export-links {
            display: flex;
            justify-content: center;
            gap: 20px;
            font-weight: 600;
            text-decoration: none;
            color: #3498db;
            margin-top: 10px;
        }

        a.export-links:hover {
            text-decoration: underline;
        }

        /* Responsivo */
        @media (max-width: 600px) {
            form {
                flex-direction: column;
                align-items: center;
            }
            form button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <p><a href="relatorios_financeiros.php">← Voltar</a></p>
    <h2>Relatório de Riscos</h2>

    <form method="get">
        <label for="inicio">De:
            <input type="date" name="inicio" id="inicio" value="<?= htmlspecialchars($data_inicio) ?>" required>
        </label>
        <label for="fim">Até:
            <input type="date" name="fim" id="fim" value="<?= htmlspecialchars($data_fim) ?>" required>
        </label>
        <button type="submit">Filtrar</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Descrição do Risco</th>
                <th>Impacto estimado</th>
                <th>Data Detectada</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?= htmlspecialchars($row['descricao']) ?></td>
                        <td><?= htmlspecialchars($row['impacto_estimado']) ?></td>
                        <td><?= date('d/m/Y', strtotime($row['data_registro'])) ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="text-align:center; color:#999;">Nenhum registro encontrado para o período selecionado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="export-links">
        <a href="exportar_riscos_pdf.php?inicio=<?= urlencode($data_inicio) ?>&fim=<?= urlencode($data_fim) ?>">Exportar PDF</a>
        <a href="exportar_riscos_excel.php?inicio=<?= urlencode($data_inicio) ?>&fim=<?= urlencode($data_fim) ?>">Exportar Excel</a>
    </div>
</div>
</body>
</html>
