<?php
require 'conexao.php';

$result = $conn->query("SELECT * FROM clientes ORDER BY nome");

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
    <meta charset="UTF-8" />
    <title>Lista de Clientes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9fafb;
            margin: 20px;
            color: #333;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        a.btn-cadastrar {
            display: inline-block;
            margin-bottom: 15px;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        a.btn-cadastrar:hover {
            background-color: #0056b3;
        }

        a.btn-menu {
            display: inline-block;
            margin-bottom: 15px;
            padding: 10px 15px;
            background-color: #05c943ff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        a.btn-menu:hover {
            background-color: #016d23ff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
            font-weight: 600;
        }

        tr:hover {
            background-color: #f1f7ff;
        }

        a.editar-link {
            color: #28a745;
            font-weight: 600;
            text-decoration: none;
        }

        a.editar-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            table, thead, tbody, th, td, tr { 
                display: block; 
            }
            th {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }
            tr {
                margin-bottom: 15px;
                border-bottom: 2px solid #ddd;
            }
            td {
                border: none;
                position: relative;
                padding-left: 50%;
                white-space: pre-wrap;
                text-align: left;
            }
            td:before {
                position: absolute;
                top: 12px;
                left: 15px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
                font-weight: bold;
                content: attr(data-label);
            }
        }
    </style>
</head>
<body>

    <h2>Clientes Cadastrados</h2>
    <a href="cadastrar.php" class="btn-cadastrar">+ Cadastrar Novo Cliente</a>

    <a href="menu_atendente.php" class="btn-menu">Voltar ao Menu</a>

    <table>
        <thead>
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
        </thead>
        <tbody>
        <?php foreach ($clientes as $cliente): ?>
            <tr>
                <td data-label="Nome"><?= htmlspecialchars($cliente['nome']) ?></td>
                <td data-label="CPF"><?= htmlspecialchars($cliente['cpf']) ?></td>
                <td data-label="Email"><?= htmlspecialchars($cliente['email']) ?></td>
                <td data-label="Data Nasc."><?= htmlspecialchars($cliente['data_nascimento']) ?></td>
                <td data-label="Contato"><?= htmlspecialchars($cliente['contato']) ?></td>
                <td data-label="Endereço"><?= htmlspecialchars($cliente['endereco']) ?></td>
                <td data-label="Login"><?= htmlspecialchars($cliente['login']) ?></td>
                <td data-label="Status"><?= ucfirst(htmlspecialchars($cliente['status'])) ?></td>
                <td data-label="Ações"><a href="editar_cliente.php?id=<?= $cliente['id'] ?>" class="editar-link">Editar</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>
