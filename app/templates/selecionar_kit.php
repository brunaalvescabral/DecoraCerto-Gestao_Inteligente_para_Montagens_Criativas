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
<input type="text" id="busca" value="<?= htmlspecialchars($busca) ?>" placeholder="Buscar kit..." onkeyup="filtrar()" />
<br><br>
<table border="1" cellpadding="5">
    <thead><tr><th>Nome</th><th>Preço/dia (R$)</th><th>Ação</th></tr></thead>
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
