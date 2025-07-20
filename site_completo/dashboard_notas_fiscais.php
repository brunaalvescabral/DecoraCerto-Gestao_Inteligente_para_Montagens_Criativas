<?php
// dashboard_notas_fiscais.php
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Dashboard - Notas Fiscais</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            color: #333;
        }
        header {
            background: #0069d9;
            color: white;
            padding: 15px 30px;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            letter-spacing: 1px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        }
        .container {
            display: flex;
            height: calc(100vh - 60px);
        }
        nav {
            width: 220px;
            background: #007bff;
            padding-top: 20px;
            box-shadow: 2px 0 6px rgba(0,0,0,0.1);
        }
        nav a {
            display: block;
            padding: 15px 20px;
            color: white;
            text-decoration: none;
            border-left: 4px solid transparent;
            transition: background 0.3s, border-left-color 0.3s;
            font-weight: 600;
        }
        nav a:hover {
            background: #0056b3;
            border-left-color: #ffc107;
        }
        nav a.active {
            background: #004085;
            border-left-color: #ffc107;
            font-weight: 700;
        }
        main {
            flex-grow: 1;
            padding: 40px 50px;
            overflow-y: auto;
            background: white;
        }
        main h1 {
            margin-top: 0;
            color: #004085;
        }
        main p {
            font-size: 18px;
            max-width: 700px;
            line-height: 1.4;
        }
        .quick-links {
            margin-top: 40px;
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        .quick-links a {
            background: #007bff;
            color: white;
            padding: 14px 28px;
            border-radius: 8px;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 3px 6px rgba(0,123,255,0.4);
            transition: background 0.3s ease;
        }
        .quick-links a:hover {
            background: #0056b3;
        }
        @media (max-width: 768px) {
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
        Cadastro de Notas Fiscais
    </header>

    <div class="container">
        <nav>
            <a href="financeiro_cadastrar_nota.php">Cadastrar Nota Fiscal</a>
            <a href="financeiro_listar_notas.php">Listar Notas Fiscais</a>
        </nav>

        <main>
            <h1>Bem-vindo ao Módulo de Notas Fiscais</h1>
            <p>Gerencie todas as suas notas fiscais de forma simples e rápida. Utilize as opções do menu para cadastrar novas notas, visualizar a lista de notas já cadastradas e acessar relatórios detalhados.</p>

            <div class="quick-links">
                <a href="financeiro_cadastrar_nota.php">Nova Nota Fiscal</a>
                <a href="financeiro_listar_notas.php">Visualizar Notas</a>
            </div>
        </main>
    </div>
</body>
</html>
