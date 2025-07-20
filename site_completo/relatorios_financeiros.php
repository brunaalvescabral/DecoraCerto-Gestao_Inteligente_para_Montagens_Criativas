<?php
include 'conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatórios Financeiros</title>
    <style>
        /* Reset básico */
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f7f8;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .container {
            max-width: 900px;
            background: #fff;
            margin: 40px auto;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
            font-weight: 700;
            letter-spacing: 1.2px;
        }

        form {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
            margin-bottom: 35px;
        }

        label {
            display: flex;
            flex-direction: column;
            font-weight: 600;
            font-size: 0.95rem;
            color: #555;
            min-width: 140px;
        }

        input[type="date"] {
            padding: 8px 12px;
            font-size: 1rem;
            border: 2px solid #ddd;
            border-radius: 8px;
            transition: border-color 0.3s;
        }
        input[type="date"]:focus {
            border-color: #3498db;
            outline: none;
        }

        button {
            padding: 10px 25px;
            font-size: 1rem;
            font-weight: 700;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
            align-self: flex-end;
            margin-left: 10px;
            min-width: 130px;
        }
        button:hover {
            background-color: #2980b9;
        }

        p {
            text-align: center;
            font-size: 1.1rem;
            color: #444;
            margin-bottom: 30px;
        }

        ul {
            list-style: none;
            padding: 0;
            max-width: 500px;
            margin: 0 auto;
        }

        ul li {
            background-color: #ecf0f1;
            margin-bottom: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            transition: background-color 0.3s;
        }

        ul li:hover {
            background-color: #d1e7f5;
        }

        ul li a {
            display: block;
            padding: 15px 20px;
            color: #2c3e50;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            border-radius: 8px;
        }

        ul li a:hover {
            color: #1a5276;
        }

        /* Responsivo */
        @media (max-width: 600px) {
            form {
                flex-direction: column;
                gap: 20px;
            }

            button {
                width: 100%;
                margin-left: 0;
                align-self: stretch;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Relatórios Financeiros</h1>

        <form method="GET" action="">
            <label for="data_inicio">Data Início:
                <input type="date" name="data_inicio" id="data_inicio" required value="<?= htmlspecialchars($_GET['data_inicio'] ?? '') ?>">
            </label>
            <label for="data_fim">Data Fim:
                <input type="date" name="data_fim" id="data_fim" required value="<?= htmlspecialchars($_GET['data_fim'] ?? '') ?>">
            </label>
            <button type="submit">Aplicar Filtro</button>
        </form>

        <?php
        if (isset($_GET['data_inicio']) && isset($_GET['data_fim'])) {
            $inicio = htmlspecialchars($_GET['data_inicio']);
            $fim = htmlspecialchars($_GET['data_fim']);
            echo "<p>Relatórios disponíveis para o período de <strong>$inicio</strong> até <strong>$fim</strong>.</p>";
        } else {
            echo "<p>Escolha um intervalo de datas para visualizar os relatórios.</p>";
        }
        ?>

        <ul>
            <li><a href="relatorio_planejamento.php?data_inicio=<?= $inicio ?? '' ?>&data_fim=<?= $fim ?? '' ?>">Relatório de Planejamento Financeiro</a></li>
            <li><a href="relatorio_contabilidade.php?data_inicio=<?= $inicio ?? '' ?>&data_fim=<?= $fim ?? '' ?>">Relatório de Contabilidade</a></li>
            <li><a href="relatorio_custos.php?data_inicio=<?= $inicio ?? '' ?>&data_fim=<?= $fim ?? '' ?>">Relatório de Gestão de Custos</a></li>
            <li><a href="relatorio_investimentos.php?data_inicio=<?= $inicio ?? '' ?>&data_fim=<?= $fim ?? '' ?>">Relatório de Investimentos</a></li>
            <li><a href="relatorio_riscos.php?data_inicio=<?= $inicio ?? '' ?>&data_fim=<?= $fim ?? '' ?>">Relatório de Riscos</a></li>
        </ul>
        <p><a href="dashboard_financeiro.php">← Voltar</a></p>
    </div>
</body>
</html>
