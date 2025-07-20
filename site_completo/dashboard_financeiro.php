<?php
// dashboard_financeiro.php
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Setor Financeiro</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f7fa;
            color: #333;
        }
        header {
            background: #004085;
            color: white;
            padding: 15px 30px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .container {
            display: flex;
            height: calc(100vh - 60px);
        }
        nav {
            width: 250px;
            background: #007bff;
            color: white;
            padding-top: 20px;
            box-shadow: 2px 0 5px rgb(0 0 0 / 0.1);
        }
        nav a {
            display: block;
            padding: 15px 20px;
            color: white;
            text-decoration: none;
            border-left: 4px solid transparent;
            transition: background 0.3s, border-left-color 0.3s;
        }
        nav a:hover {
            background: #0056b3;
            border-left-color: #ffc107;
        }
        nav a.active {
            background: #0056b3;
            border-left-color: #ffc107;
            font-weight: bold;
        }
        main {
            flex-grow: 1;
            padding: 40px 50px;
            overflow-y: auto;
        }
        main h1 {
            margin-top: 0;
            color: #004085;
        }
        main p {
            font-size: 18px;
            max-width: 700px;
        }
        main .quick-links {
            margin-top: 30px;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        main .quick-links a {
            background: #007bff;
            color: white;
            padding: 15px 25px;
            border-radius: 8px;
            font-weight: bold;
            text-decoration: none;
            box-shadow: 0 3px 6px rgb(0 123 255 / 0.3);
            transition: background 0.3s;
        }
        main .quick-links a:hover {
            background: #0056b3;
        }

        @media(max-width: 768px) {
            .container {
                flex-direction: column;
            }
            nav {
                width: 100%;
                display: flex;
                overflow-x: auto;
                padding: 0;
            }
            nav a {
                flex: 1 0 auto;
                text-align: center;
                border-left: none;
                border-bottom: 4px solid transparent;
            }
            nav a.active {
                border-left: none;
                border-bottom-color: #ffc107;
            }
            main {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <header>
        Setor Financeiro
    </header>
    <div class="container">
        <nav>
            <a href="relatorios_financeiros.php">Relatórios Financeiros</a>
            <a href="planejamento_financeiro.php">Planejamento financeiro</a>
            <a href="gestao_riscos.php">Gestão de Riscos</a>
            <a href="gestao_custos.php">Gestão de Custos</a>
            <a href="investimentos_dashboard.php">Gestão de Investimentos</a>
            <a href="contabilidade.php">Contabilidade</a>
            <a href="dashboard_receitas.php">Receitas</a>
            <a href="dashboard_contas_pagar.php">Despesas</a>
            <a href="menu_principal.php">Voltar ao menu principal</a>
        </nav>
        <main>
            <h1>Bem-vindo ao Setor Financeiro</h1>
            <p>Este dashboard centraliza o acesso a todas as funcionalidades importantes para gestão financeira, facilitando a navegação e o controle das informações essenciais do sistema.</p>

            <div class="quick-links">
                <a href="relatorios_financeiros.php">Ver Relatórios</a>
                <a href="planejamento_financeiro.php">Planejamento financeiro</a>
                <a href="gestao_riscos.php">Analisar Riscos</a>
                <a href="gestao_custos.php">Controle de Custos</a>
                <a href="investimentos_dashboard.php">Investimentos</a>
                <a href="contabilidade.php">Contabilidade</a>
                <a href="dashboard_receitas.php">Gerenciar Receitas</a>
                <a href="dashboard_contas_pagar.php">Gerenciar Despesas</a>
            </div>
        </main>
    </div>
</body>
</html>
