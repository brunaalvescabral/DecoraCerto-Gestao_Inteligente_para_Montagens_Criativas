<?php
require 'conexao.php';

$id = $_GET['id'] ?? null;
if (!$id) die("ID inválido.");

$stmt = $pdo->prepare("SELECT * FROM clientes WHERE id = ?");
$stmt->execute([$id]);
$cliente = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$cliente) die("Cliente não encontrado.");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Cliente</title>
</head>
<body>
    <h2>Editar Cliente</h2>
    <form action="atualizar_cliente.php" method="post">
        <input type="hidden" name="id" value="<?= $cliente['id'] ?>">
        Nome: <input type="text" name="nome" value="<?= $cliente['nome'] ?>" required><br><br>
        CPF: <input type="text" value="<?= $cliente['cpf'] ?>" readonly><br><br>
        Email: <input type="email" name="email" value="<?= $cliente['email'] ?>" required><br><br>
        Data de nascimento: <input type="date" name="data_nascimento" value="<?= $cliente['data_nascimento'] ?>" required><br><br>
        Contato: <input type="text" name="contato" value="<?= $cliente['contato'] ?>" required><br><br>
        Endereço: <input type="text" name="endereco" value="<?= $cliente['endereco'] ?>" required><br><br>
        Login: <input type="text" name="login" value="<?= $cliente['login'] ?>" required><br><br>
        Status:
        <select name="status">
            <option value="ativo" <?= $cliente['status'] == 'ativo' ? 'selected' : '' ?>>Ativo</option>
            <option value="inativo" <?= $cliente['status'] == 'inativo' ? 'selected' : '' ?>>Inativo</option>
        </select><br><br>
        <button type="submit">Atualizar</button>
    </form>
    <a href="index.php">Voltar</a>
</body>
</html>
