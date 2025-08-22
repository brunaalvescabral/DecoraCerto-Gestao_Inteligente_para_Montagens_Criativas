<?php
include 'conexao.php';

$data_inicio = $_GET['data_inicio'] ?? date('Y-m-01');
$data_fim = $_GET['data_fim'] ?? date('Y-m-t');

if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data_inicio)) $data_inicio = date('Y-m-01');
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data_fim)) $data_fim = date('Y-m-t');

$sql = "SELECT a.id, c.nome AS cliente_nome, k.nome AS kit_nome, a.data_retirada, a.data_devolucao, a.valor_total, a.atendido
        FROM alugueis a
        JOIN clientes c ON a.cliente_id = c.id
        JOIN kits k ON a.kit_id = k.id
        WHERE a.data_aluguel BETWEEN ? AND ?
        ORDER BY a.data_aluguel DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $data_inicio, $data_fim);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8" />
<title>Dashboard de Aluguéis</title>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f5f7fa;
        margin: 0;
        padding: 30px;
        color: #333;
    }
    h1 {
        text-align: center;
        margin-bottom: 25px;
        color: #34495e;
    }
    .botoes-container {
        max-width: 600px;
        margin: 0 auto 20px auto;
        display: flex;
        justify-content: center;
        gap: 15px;
    }
    .botoes-container button {
        padding: 12px 25px;
        font-size: 16px;
        font-weight: bold;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        color: white;
        transition: background-color 0.3s ease;
    }
    .botoes-container button.pre-reserva {
        background-color: #27ae60;
    }
    .botoes-container button.pre-reserva:hover {
        background-color: #1e8449;
    }
    .botoes-container button.alugar {
        background-color: #2980b9;
    }
    .botoes-container button.alugar:hover {
        background-color: #1c5980;
    }
    .botoes-container button.menu {
        background-color: #2980b9;
    }
    .botoes-container button.menu:hover {
        background-color: #1c5980;
    }

    form#filtro {
        max-width: 600px;
        margin: 0 auto 30px auto;
        display: flex;
        gap: 12px;
        justify-content: center;
        flex-wrap: wrap;
    }
    form#filtro label {
        align-self: center;
        font-weight: 600;
    }
    form#filtro input[type="date"] {
        padding: 8px 10px;
        font-size: 16px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }
    form#filtro button {
        padding: 9px 18px;
        background-color: #2980b9;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }
    form#filtro button:hover {
        background-color: #1c5980;
    }
    table {
        width: 100%;
        max-width: 900px;
        margin: 0 auto;
        border-collapse: collapse;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.1);
    }
    th, td {
        padding: 14px 16px;
        border-bottom: 1px solid #eee;
        text-align: left;
    }
    th {
        background-color: #3498db;
        color: white;
    }
    tbody tr:hover {
        background-color: #f1f8ff;
    }
    .status {
        font-weight: bold;
        padding: 6px 10px;
        border-radius: 12px;
        text-align: center;
        width: 100px;
        display: inline-block;
    }
    .status.atendido {
        background-color: #27ae60;
        color: white;
    }
    .status.pendente {
        background-color: #e67e22;
        color: white;
    }
</style>
</head>
<body>
<h1>Aluguéis</h1>


<div class="botoes-container">
    <button class="menu" onclick="window.location.href='menu_atendente.php'">Voltar ao menu</button>
    <button class="pre-reserva" onclick="window.location.href='atendente_prereservas.php'">📅 Pré-Reservas</button>
    <button class="alugar" onclick="window.location.href='aluguel_kit.php'">🛒 Alugar Kit</button>
    
</div>

<form id="filtro" method="GET">
    <label for="data_inicio">Data Início:</label>
    <input type="date" id="data_inicio" name="data_inicio" value="<?= htmlspecialchars($data_inicio) ?>" required>

    <label for="data_fim">Data Fim:</label>
    <input type="date" id="data_fim" name="data_fim" value="<?= htmlspecialchars($data_fim) ?>" required>

    <button type="submit">Filtrar</button>
</form>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Kit</th>
            <th>Data Retirada</th>
            <th>Data Devolução</th>
            <th>Valor Total (R$)</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result->num_rows === 0): ?>
            <tr><td colspan="7" style="text-align:center; padding: 20px; color: #777;">Nenhum aluguel encontrado para o período selecionado.</td></tr>
        <?php else: ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['cliente_nome']) ?></td>
                    <td><?= htmlspecialchars($row['kit_nome']) ?></td>
                    <td><?= date("d/m/Y", strtotime($row['data_retirada'])) ?></td>
                    <td><?= date("d/m/Y", strtotime($row['data_devolucao'])) ?></td>
                    <td>R$ <?= number_format($row['valor_total'], 2, ',', '.') ?></td>
                    <td>
                        <span class="status <?= $row['atendido'] ? 'atendido' : 'pendente' ?>">
                            <?= $row['atendido'] ? 'Atendido' : 'Pendente' ?>
                        </span>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>
