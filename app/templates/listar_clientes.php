<?php
require 'conexao.php';

$stmt = $pdo->query("SELECT * FROM clientes ORDER BY nome ASC");
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Clientes</title>
</head>
<body>

<h2>Clientes Cadastrados</h2>

<table border="1" cellpadding="5">
    <tr>
        <th>Nome</th>
        <th>CPF</th>
        
        <th>Email</th>
        <th>Endereço</th>
        <th>Data de Nascimento</th>
        <th>Contato</th>
        <th>Status</th>
        <th>Ações</th>
    </tr>
    <?php foreach ($clientes as $cliente): ?>
        <tr>
            <td><?= htmlspecialchars($cliente['nome']) ?></td>
            <td><?= $cliente['cpf'] ?></td>
            <td><?= $cliente['email'] ?></td>
            <td><?= $cliente['endereço'] ?></td>
            <td><?= $cliente['data_nascimento'] ?></td>
            <td><?= $cliente['contato'] ?></td>
            <td><?= $cliente['status'] ?></td>
            <td>
                <a href="editar_cliente.php?id=<?= $cliente['id'] ?>">Editar</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
