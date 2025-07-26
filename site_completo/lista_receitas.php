<?php
$mysqli = new mysqli("localhost", "root", "", "sistema");
if ($mysqli->connect_errno) {
    die("Falha na conexão: " . $mysqli->connect_error);
}

$dataInicio = $_GET['data_inicio'] ?? '';
$dataFim = $_GET['data_fim'] ?? '';

$where = '';
if (!empty($dataInicio) && !empty($dataFim)) {
    $inicioFormatado = date('Y-m-d', strtotime($dataInicio));
    $fimFormatado = date('Y-m-d', strtotime($dataFim));
    $where = "WHERE r.data_receita BETWEEN '$inicioFormatado' AND '$fimFormatado'";
}

$sql = "SELECT r.id, r.origem, r.origem_id, r.descricao, r.valor, r.data_receita, r.criado_em,
        a.cliente_id, a.kit_id
        FROM receitas r
        LEFT JOIN alugueis a ON r.origem = 'aluguel' AND r.origem_id = a.id
        $where
        ORDER BY r.data_receita DESC, r.criado_em DESC";

$result = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Listagem de Receitas</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #6858b7ff, #1abc9c);
            margin: 0;
            padding: 20px 30px;
            color: #333;
        }

        header {
            color: #fff;
            padding: 25px 40px;
            font-size: 28px;
            font-weight: 700;
            text-align: center;
        }

        .container {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 10px #ccc;
        }

        .container h1 {
            margin-top: 0;
        }

        form.filtro-form {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            align-items: flex-end;
        }

        form.filtro-form label {
            display: flex;
            flex-direction: column;
            font-weight: bold;
            font-size: 14px;
        }

        form.filtro-form input {
            padding: 8px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        form.filtro-form button {
            padding: 9px 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        form.filtro-form button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            padding: 10px 14px;
            border: 1px solid #ccc;
            text-align: left;
            font-size: 14px;
        }

        th {
            background: #007bff;
            color: white;
        }

        a {
            text-decoration: none;
            color: #007bff;
        }

        a:hover {
            text-decoration: underline;
        }

        .origem-manual {
            color: #28a745;
            font-weight: bold;
        }

        .origem-aluguel {
            color: #17a2b8;
            font-weight: bold;
        }

        a.botao-voltar {
            display: inline-block;
            margin-bottom: 10px;
            color: #007bff;
        }
    </style>
</head>
<body>
<header>Gestão de Receitas</header>
<div class="container">
    <a href="dashboard_receitas.php" class="botao-voltar">← Voltar</a>
    <h1>Listagem de Receitas</h1>

    <form class="filtro-form" method="GET" action="">
        <label>
            Data Início:
            <input type="date" name="data_inicio" value="<?= htmlspecialchars($dataInicio) ?>" required>
        </label>
        <label>
            Data Fim:
            <input type="date" name="data_fim" value="<?= htmlspecialchars($dataFim) ?>" required>
        </label>
        <button type="submit">Filtrar</button>
    </form>

    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Origem</th>
            <th>Descrição</th>
            <th>Valor (R$)</th>
            <th>Data Receita</th>
            <th>Data Cadastro</th>
        </tr>
        </thead>
        <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td class="<?= $row['origem'] == 'manual' ? 'origem-manual' : 'origem-aluguel' ?>">
                        <?= ucfirst($row['origem']) ?>
                    </td>
                    <td><?= htmlspecialchars($row['descricao'] ?: "Receita do aluguel #{$row['origem_id']}") ?></td>
                    <td><?= number_format($row['valor'], 2, ',', '.') ?></td>
                    <td><?= date('d/m/Y', strtotime($row['data_receita'])) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($row['criado_em'])) ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="6">Nenhuma receita encontrada no período selecionado.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
