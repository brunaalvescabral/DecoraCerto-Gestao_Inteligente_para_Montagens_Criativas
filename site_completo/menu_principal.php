<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Menu Principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
        }
        .header-title {
            text-align: center;
            margin-top: 40px;
            font-size: 32px;
            font-weight: bold;
            color: #333;
        }
        .menu-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 0;
        }
        .menu-box {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
        }
        .menu-item {
            width: 220px;
            height: 200px;
            background-color: #fff;
            border-radius: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 30px 20px;
            text-decoration: none;
            color: #333;
            transition: all 0.3s ease;
        }
        .menu-item:hover {
            background-color: #e9f7ef;
            transform: translateY(-5px);
        }
        .menu-item i {
            font-size: 50px;
            margin-bottom: 15px;
            color: #0d6efd;
        }
        .menu-item span {
            font-size: 18px;
            font-weight: 600;
        }
    </style>
</head>
<body>

    <div class="header-title">Menu Principal</div>

    <div class="menu-container">
        <div class="menu-box">
            <a href="dashboard_catalogo_gerente.php" class="menu-item">
                <i class="bi bi-person-gear"></i>
                <span>Gerente</span>
            </a>
            <a href="menu_atendente.php" class="menu-item">
                <i class="bi bi-person-lines-fill"></i>
                <span>Atendente</span>
            </a>
            <a href="caixa_aluguel_atendido.php" class="menu-item">
                <i class="bi bi-cash-stack"></i>
                <span>Caixa</span>
            </a>
            <a href="dashboard_financeiro.php" class="menu-item">
                <i class="bi bi-bar-chart-fill"></i>
                <span>Setor Financeiro</span>
            </a>
        </div>
    </div>

</body>
</html>
