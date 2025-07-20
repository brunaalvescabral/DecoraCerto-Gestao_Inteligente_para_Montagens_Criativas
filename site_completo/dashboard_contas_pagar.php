<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Contas a Pagar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .container {
            text-align: center;
            padding: 50px 20px;
        }
        h1 {
            margin-bottom: 30px;
            color: #333;
        }
        .cards {
            display: flex;
            justify-content: center;
            gap: 40px;
            flex-wrap: wrap;
        }
        .card {
            background-color: #ffffff;
            width: 250px;
            height: 180px;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            transition: transform 0.2s;
            text-decoration: none;
            color: #333;
        }
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0px 0px 15px rgba(0,0,0,0.15);
        }
        .icon {
            font-size: 50px;
            margin-bottom: 15px;
            color: #007BFF;
        }
        .label {
            font-size: 18px;
            font-weight: bold;
        }
    </style>
    <!-- Ícones do Bootstrap ou FontAwesome (opcional) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <h1>Contas a Pagar</h1>
        <div class="cards">
            <a href="cadastrar_conta.php" class="card">
                <div class="icon"><i class="fas fa-plus-circle"></i></div>
                <div class="label">Cadastrar Conta</div>
            </a>
            <a href="listar_contas.php" class="card">
                <div class="icon"><i class="fas fa-list"></i></div>
                <div class="label">Listar Contas</div>
            </a>
            <a href="grafico_contas.php" class="card">
                <div class="icon"><i class="fas fa-chart-pie"></i></div>
                <div class="label">Gráfico de Contas</div>
            </a>
        </div>
        <p><a href="dashboard_financeiro.php">← Voltar</a></p>
    </div>
</body>
</html>
