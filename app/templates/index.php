<?php
require 'conexao.php';

$stmt = $pdo->query("SELECT * FROM clientes ORDER BY nome");
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Lista de Clientes</title>
</head>
<body>
    <h2>Clientes Cadastrados</h2>
    <a href="cadastrar.php">Cadastrar novo cliente</a>
    <table border="1" cellpadding="5">
        <tr>
            <th>Nome</th>
            <th>CPF</th>
            <th>Email</th>
            <th>Data Nasc.</th>
            <th>Contato</th>
            <th>Endereço</th>
            <th>Login</th>
            <th>Status</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($clientes as $cliente): ?>
            <tr>
                <td><?= htmlspecialchars($cliente['nome']) ?></td>
                <td><?= htmlspecialchars($cliente['cpf']) ?></td>
                <td><?= htmlspecialchars($cliente['email']) ?></td>
                <td><?= htmlspecialchars($cliente['data_nascimento']) ?></td>
                <td><?= htmlspecialchars($cliente['contato']) ?></td>
                <td><?= htmlspecialchars($cliente['endereco']) ?></td>
                <td><?= htmlspecialchars($cliente['login']) ?></td>
                <td><?= htmlspecialchars($cliente['status']) ?></td>
                <td>
                    <a href="editar_cliente.php?id=<?= $cliente['id'] ?>">Editar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
