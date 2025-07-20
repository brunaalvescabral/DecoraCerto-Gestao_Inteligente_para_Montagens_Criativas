<?php
$mysqli = new mysqli("localhost", "root", "", "sistema");
if ($mysqli->connect_errno) {
    die("Falha na conexão: " . $mysqli->connect_error);
}

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $descricao = $mysqli->real_escape_string($_POST['descricao']);
    $valor = floatval(str_replace(',', '.', $_POST['valor']));
    $data_receita = $mysqli->real_escape_string($_POST['data_receita']);

    $sql = "INSERT INTO receitas (origem, origem_id, descricao, valor, data_receita) 
            VALUES ('manual', NULL, '$descricao', $valor, '$data_receita')";
    if ($mysqli->query($sql)) {
        header("Location: cadastro_receita.php?success=1");
        exit;
    } else {
        $error = "Erro ao cadastrar receita: " . $mysqli->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Cadastrar Receita Manualmente</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f0f0f0; margin:0; padding:20px;}
        .container { max-width: 600px; margin: auto; background:white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px #ccc;}
        label { display: block; margin-top: 15px;}
        input[type=text], input[type=number], input[type=date] {
            width: 100%; padding: 8px; margin-top: 5px; border-radius: 5px; border: 1px solid #ccc;
        }
        button {
            margin-top: 20px; padding: 10px 15px; border:none; background:#28a745; color:white; border-radius: 5px; cursor:pointer;
        }
        button:hover { background:#218838; }
        .msg-sucesso { background: #d4edda; color: #155724; padding: 10px; margin-bottom: 10px; border-radius: 5px; }
        .msg-erro { background: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 10px; border-radius: 5px; }
        a { text-decoration:none; color:#007bff; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
<div class="container">
    <a href="dashboard_receitas.php">← Voltar</a>
    <h1>Cadastrar Receita Manualmente</h1>

    <?php if (isset($_GET['success'])): ?>
        <div class="msg-sucesso">Receita cadastrada com sucesso!</div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="msg-erro"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="descricao">Descrição:</label>
        <input type="text" id="descricao" name="descricao" required>

        <label for="valor">Valor (R$):</label>
        <input type="text" id="valor" name="valor" required pattern="^\d+([,\.]\d{1,2})?$" title="Digite um valor válido">

        <label for="data_receita">Data da Receita:</label>
        <input type="date" id="data_receita" name="data_receita" required>

        <button type="submit">Cadastrar Receita</button>
    </form>
</div>
</body>
</html>
