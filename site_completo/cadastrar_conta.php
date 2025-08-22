<?php
require_once("conexao.php");

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];
    $data_venc = $_POST['data_vencimento'];
    $data_reg = $_POST['data_registro'];
    $categoria = $_POST['categoria'];
    $subcategoria = $_POST['subcategoria'];

    $sql = "INSERT INTO contas_pagar (descricao, valor, data_vencimento, data_registro, categoria, subcategoria) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdssss", $descricao, $valor, $data_venc, $data_reg, $categoria, $subcategoria);
    $stmt->execute();
    $msg = "✅ Conta cadastrada com sucesso!";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Conta a Pagar</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #6858b7ff, #1abc9c);
            margin: 0;
            padding: 20px 30px;
            color: #333;
        }

        h2 {
            color: #fff;
            text-align: center;
            margin-bottom: 20px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
        }

        form {
            background: #ffffff;
            padding: 25px 30px;
            border-radius: 12px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }

        label {
            font-weight: 600;
            display: block;
            margin-bottom: 6px;
            margin-top: 20px;
            color: #333;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        select {
            width: 100%;
            padding: 10px 12px;
            border: 1.5px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
            box-sizing: border-box;
        }

        input:focus, select:focus {
            border-color: #8e44ad;
            outline: none;
        }

        button {
            background: linear-gradient(to right, #464390ff, #464390ff);
            color: white;
            border: none;
            padding: 12px 22px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 25px;
            transition: opacity 0.3s ease;
        }

        button:hover {
            opacity: 0.85;
        }

        a {
            display: inline-block;
            margin-left: 15px;
            margin-top: 25px;
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            background: #2c3e50;
            padding: 10px 20px;
            border-radius: 6px;
            transition: background 0.3s ease;
        }

        a:hover {
            background: #1a242f;
        }

        .success {
            background: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 6px;
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>
<body>
    <h2>Cadastrar Conta a Pagar</h2>

    <form method="post">
        <?php if (!empty($msg)) echo "<div class='success'>$msg</div>"; ?>

        <label>Descrição:</label>
        <input name="descricao" type="text" required>

        <label>Valor (R$):</label>
        <input name="valor" type="number" step="0.01" required>

        <label>Data de Vencimento:</label>
        <input name="data_vencimento" type="date" required>

        <label>Data de Registro:</label>
        <input name="data_registro" type="date" required>

        <label>Categoria:</label>
        <select name="categoria" required>
            <option value="">Selecione...</option>
            <option>Fixo</option>
            <option>Variável</option>
        </select>

        <label>Subcategoria:</label>
        <select name="subcategoria" required>
            <option value="">Selecione...</option>
            <option>Despesas Administrativas</option>
            <option>Despesas Operacionais</option>
        </select>

        <button type="submit">Salvar</button>
        <a href="dashboard_contas_pagar.php">Voltar</a>
    </form>
</body>
</html>
