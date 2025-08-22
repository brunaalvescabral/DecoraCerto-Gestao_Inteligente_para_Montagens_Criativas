<!DOCTYPE html>
<html>
<head>
    <title>Cadastrar Cliente</title>
</head>
<body>
    <h2>Cadastro de Cliente</h2>
    <form action="processa_cadastro.php" method="post">
        Nome: <input type="text" name="nome" required><br><br>
        CPF: <input type="text" name="cpf" maxlength="11" required><br><br>
        Email: <input type="email" name="email" required><br><br>
        Data de nascimento: <input type="date" name="data_nascimento" required><br><br>
        Contato: <input type="text" name="contato" required><br><br>
        Endereço: <input type="text" name="endereco" required><br><br>
        Login: <input type="text" name="login" required><br><br>
        Senha: <input type="password" name="senha" required><br><br>
        Status:
        <select name="status">
            <option value="ativo">Ativo</option>
            <option value="inativo">Inativo</option>
        </select><br><br>
        <button type="submit">Cadastrar</button>
    </form>
    <a href="index.php">Voltar</a>
</body>
</html>
