<?php
include 'conexao.php';

$busca = $_GET['busca'] ?? '';
$busca = $conn->real_escape_string($busca);

$sql = "SELECT id, nome FROM clientes WHERE nome LIKE '%$busca%' ORDER BY nome";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8" />
<title>Selecionar Cliente</title>
<script>
function selecionarCliente(id, nome) {
    localStorage.setItem('cliente_id', id);
    localStorage.setItem('cliente_nome', nome);
    window.close();
}

function filtrar() {
    const termo = document.getElementById('busca').value;
    window.location.href = '?busca=' + encodeURIComponent(termo);
}
</script>
</head>
<body>
<h2>Selecionar Cliente</h2>
<input type="text" id="busca" value="<?= htmlspecialchars($busca) ?>" placeholder="Buscar cliente..." onkeyup="filtrar()" />
<br><br>
<table border="1" cellpadding="5">
    <thead><tr><th>Nome</th><th>Ação</th></tr></thead>
    <tbody>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= htmlspecialchars($row['nome']) ?></td>
            <td><button onclick="selecionarCliente('<?= $row['id'] ?>', '<?= addslashes(htmlspecialchars($row['nome'])) ?>')">Selecionar</button></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
</body>
</html>
