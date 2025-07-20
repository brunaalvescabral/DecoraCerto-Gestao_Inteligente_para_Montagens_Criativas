<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel do Gerente</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 80px auto;
            padding: 30px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 0 12px rgba(0,0,0,0.08);
            text-align: center;
        }

        h2 {
            color: #333;
            margin-bottom: 30px;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        ul li {
            margin: 15px 0;
        }

        a {
            text-decoration: none;
            background-color: #007bff;
            color: white;
            padding: 12px 25px;
            border-radius: 12px;
            transition: background 0.3s ease;
            display: inline-block;
            font-size: 16px;
        }

        a:hover {
            background-color: #0056b3;
        }

        @media (max-width: 480px) {
            .container {
                margin: 20px;
                padding: 20px;
            }

            a {
                width: 100%;
                display: block;
                box-sizing: border-box;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Painel do Gerente</h2>
        <ul>
            <li><a href="listar_kits.php">📦 Listar Kits</a></li>
            <li><a href="adicionar_kit.php">➕ Adicionar Novo Kit</a></li>
            <li><a href="visualizar_estoque.php">📊 Visualizar Estoque</a></li>
            <li><a href="listar_notas_fiscais.php">🧾 Visualizar notas fiscais</a></li>
            <li><a href="menu_principal.php">🔙 Voltar ao menu</a></li>
        </ul>
    </div>
</body>
</html>
