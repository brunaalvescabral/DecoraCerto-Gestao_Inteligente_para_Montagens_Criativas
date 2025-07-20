<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Menu - Atendente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
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
            padding: 40px 0 20px 0;
            flex-direction: column;
        }
        .menu-box {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
            justify-content: center;
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
            color: #198754;
        }
        .menu-item span {
            font-size: 18px;
            font-weight: 600;
        }
        .voltar-container {
            margin-top: 30px;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="header-title">Menu - Atendente</div>

    <div class="menu-container">
        <div class="menu-box">
            <a href="dashboard_cadastro_cliente.php" class="menu-item">
                <i class="bi bi-person-plus-fill"></i>
                <span>Cadastro de Cliente</span>
            </a>
            <a href="dashboard_alugueis.php" class="menu-item">
                <i class="bi bi-receipt-cutoff"></i>
                <span>Orçamentos</span>
            </a>
            <a href="caixa_alugueis_atendidos.php" class="menu-item">
                <i class="bi bi-file-earmark-text-fill"></i>
                <span>Termo de Compromisso</span>
            </a>
        </div>

        <div class="voltar-container">
            <a href="menu_principal.php" class="btn btn-success">
                <i class="bi bi-arrow-left-circle"></i> Voltar ao Menu Principal
            </a>
        </div>
    </div>

</body>
</html>
