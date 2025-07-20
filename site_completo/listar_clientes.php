<?php
require 'conexao.php';

$result = $conn->query("SELECT * FROM clientes ORDER BY nome ASC");

$clientes = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $clientes[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Clientes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f7fa;
            margin: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 95%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 8px rgba(0,0,0,0.05);
        }

        th, td {
            padding: 12px 10px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
            font-weight: 600;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        a.btn-editar {
            padding: 6px 12px;
            background-color: #28a745;
            color: white;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
        }

        a.btn-editar:hover {
            background-color: #218838;
        }

        .voltar {
            display: block;
            width: fit-content;
            margin: 20px auto;
            text-align: center;
            padding: 10px 20px;
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        .voltar:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>

<h2>Clientes Cadastrados</h2>

<table>
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
            <td><?= $cliente['endereco'] ?></td>
            <td><?= $cliente['data_nascimento'] ?></td>
            <td><?= $cliente['contato'] ?></td>
            <td><?= ucfirst($cliente['status']) ?></td>
            <td>
                <a href="editar_cliente.php?id=<?= $cliente['id'] ?>" class="btn-editar">Editar</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<a href="index.php" class="voltar">Voltar</a>

</body>
</html>
