<?php
require 'conexao.php';

$id = $_GET['id'] ?? null;
if (!$id) die("ID inválido.");

$stmt = $conn->prepare("SELECT * FROM clientes WHERE id = ?");
$stmt->bind_param("i", $id); // "i" indica que $id é um inteiro
$stmt->execute();
$result = $stmt->get_result();
$cliente = $result->fetch_assoc();

if (!$cliente) die("Cliente não encontrado.");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Cliente</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            padding: 20px;
        }

        .container {
            background-color: #ffffff;
            max-width: 600px;
            margin: auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
            color: #555;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }

        .readonly-field {
            background-color: #f0f0f0;
            cursor: not-allowed;
        }

        button {
            margin-top: 20px;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        button:hover {
            background-color: #0056b3;
        }

        .back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
            text-decoration: none;
            color: #555;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Editar Cliente</h2>
    <form action="atualizar_cliente.php" method="post">
        <input type="hidden" name="id" value="<?= htmlspecialchars($cliente['id']) ?>">
        
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="<?= htmlspecialchars($cliente['nome']) ?>" required>

        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" class="readonly-field" value="<?= htmlspecialchars($cliente['cpf']) ?>" readonly>
        <input type="hidden" name="cpf" value="<?= htmlspecialchars($cliente['cpf']) ?>">

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($cliente['email']) ?>" required>

        <label for="data_nascimento">Data de Nascimento:</label>
        <input type="date" name="data_nascimento" id="data_nascimento" value="<?= htmlspecialchars($cliente['data_nascimento']) ?>" required>

        <label for="contato">Contato:</label>
        <input type="text" name="contato" id="contato" value="<?= htmlspecialchars($cliente['contato']) ?>" required>

        <label for="endereco">Endereço:</label>
        <input type="text" name="endereco" id="endereco" value="<?= htmlspecialchars($cliente['endereco']) ?>" required>

        <label for="login">Login:</label>
        <input type="text" name="login" id="login" value="<?= htmlspecialchars($cliente['login']) ?>" required>

        <label for="status">Status:</label>
        <select name="status" id="status">
            <option value="ativo" <?= $cliente['status'] == 'ativo' ? 'selected' : '' ?>>Ativo</option>
            <option value="inativo" <?= $cliente['status'] == 'inativo' ? 'selected' : '' ?>>Inativo</option>
        </select>

        <button type="submit">Atualizar</button>
    </form>
    <a class="back-link" href="dashboard_cadastro_cliente.php">← Voltar</a>
</div>
</body>
</html>
