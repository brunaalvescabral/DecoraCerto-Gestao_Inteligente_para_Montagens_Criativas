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
        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            color: #2c3e50;
        }

        header {
            background: linear-gradient(90deg, #007bff, #00b894);
            color: #fff;
            padding: 25px 40px;
            font-size: 28px;
            font-weight: 700;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
        }

        .container {
            max-width: 600px;
            background: white;
            margin: 50px auto;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .container h1 {
            font-size: 28px;
            margin-bottom: 25px;
            text-align: center;
        }

        label {
            display: block;
            font-weight: 600;
            margin-top: 20px;
            color: #333;
        }

        input[type="text"],
        input[type="date"] {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        button {
            margin-top: 30px;
            width: 100%;
            padding: 14px;
            border: none;
            background: linear-gradient(90deg, #00b894, #007bff);
            color: white;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background: linear-gradient(90deg, #00a07c, #005fcc);
        }

        .msg-sucesso, .msg-erro {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-size: 16px;
            text-align: center;
        }

        .msg-sucesso {
            background-color: #d4edda;
            color: #155724;
            border-left: 5px solid #28a745;
        }

        .msg-erro {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 5px solid #dc3545;
        }

        a.voltar {
            display: inline-block;
            margin-bottom: 20px;
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.2s ease;
        }

        a.voltar:hover {
            color: #0056b3;
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            .container {
                padding: 25px;
                margin: 30px 15px;
            }

            button {
                font-size: 15px;
            }
        }
    </style>
</head>
<body>
    <header>Gestão de Receitas</header>

    <div class="container">
        
        <h1>Cadastrar Receita Manual</h1>

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
        <button onclick="location.href='dashboard_receitas.php'" class="voltar">← Voltar</button>
    </div>
    
</body>
</html>

