<?php
include 'conexao.php';

$busca = $_GET['busca'] ?? '';
$busca = $conn->real_escape_string($busca);

$sql = "SELECT id, nome, valor FROM kits WHERE nome LIKE '%$busca%' ORDER BY nome";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8" />
<title>Selecionar Kit</title>
<style>
    * {
        box-sizing: border-box;
    }
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f9fafb;
        padding: 20px;
        margin: 0;
        color: #333;
    }
    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #2c3e50;
    }
    #busca {
        width: 100%;
        max-width: 400px;
        display: block;
        margin: 0 auto 30px auto;
        padding: 10px 15px;
        font-size: 16px;
        border: 2px solid #3498db;
        border-radius: 6px;
        transition: border-color 0.3s ease;
    }
    #busca:focus {
        outline: none;
        border-color: #2980b9;
        box-shadow: 0 0 6px rgba(41, 128, 185, 0.5);
    }
    table {
        border-collapse: collapse;
        width: 100%;
        max-width: 700px;
        margin: 0 auto;
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    thead {
        background-color: #3498db;
        color: white;
    }
    th, td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    tbody tr:hover {
        background-color: #f1f8ff;
    }
    button {
        background-color: #27ae60;
        border: none;
        color: white;
        padding: 8px 14px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: 600;
        transition: background-color 0.3s ease;
    }
    button:hover {
        background-color: #219150;
    }
    @media (max-width: 600px) {
        table, thead, tbody, th, td, tr {
            display: block;
        }
        thead tr {
            display: none;
        }
        tr {
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            background: #fff;
        }
        td {
            border: none;
            padding-left: 50%;
            position: relative;
            white-space: pre-wrap;
        }
        td::before {
            position: absolute;
            left: 15px;
            top: 12px;
            width: 45%;
            white-space: nowrap;
            font-weight: bold;
            color: #555;
        }
        td:nth-of-type(1)::before { content: "Nome"; }
        td:nth-of-type(2)::before { content: "Preço/dia (R$)"; }
        td:nth-of-type(3)::before { content: "Ação"; }
    }
</style>
<script>
function selecionarKit(id, nome, preco) {
    localStorage.setItem('kit_id', id);
    localStorage.setItem('kit_nome', nome);
    localStorage.setItem('kit_preco', preco);
    window.close();
}

function filtrar() {
    const termo = document.getElementById('busca').value;
    window.location.href = '?busca=' + encodeURIComponent(termo);
}
</script>
</head>
<body>

<h2>Selecionar Kit</h2>

<input type="text" id="busca" value="<?= htmlspecialchars($busca) ?>" placeholder="Buscar kit..." onkeyup="filtrar()" autofocus />

<table>
    <thead>
        <tr><th>Nome</th><th>Preço/dia (R$)</th><th>Ação</th></tr>
    </thead>
    <tbody>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= htmlspecialchars($row['nome']) ?></td>
            <td><?= number_format($row['valor'], 2, ',', '.') ?></td>
            <td><button onclick="selecionarKit('<?= $row['id'] ?>', '<?= addslashes(htmlspecialchars($row['nome'])) ?>', '<?= $row['valor'] ?>')">Selecionar</button></td>
        </tr>
    <?php } ?>
    </tbody>
</table>

</body>
</html>
