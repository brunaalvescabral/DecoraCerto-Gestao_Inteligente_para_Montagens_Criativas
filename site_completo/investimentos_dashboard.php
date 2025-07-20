<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8" />
<title>Gestão de Investimentos</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: #f4f4f4;
        margin: 0; padding: 0;
    }
    .container {
        max-width: 700px;
        margin: 50px auto;
        background: white;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 0 15px #aaa;
        text-align: center;
    }
    h1 {
        margin-bottom: 40px;
        color: #333;
    }
    .menu {
        display: flex;
        justify-content: center;
        gap: 25px;
        flex-wrap: wrap;
    }
    .menu a {
        display: block;
        padding: 20px 40px;
        background: #007bff;
        color: white;
        font-size: 18px;
        text-decoration: none;
        border-radius: 8px;
        transition: background-color 0.3s ease;
        min-width: 180px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .menu a:hover {
        background: #0056b3;
    }
</style>
</head>
<body>
<div class="container">
    <h1>Gestão de Investimentos</h1>
    <div class="menu">
        <a href="investimentos.php">Investimentos Ativos</a>
        <a href="investimentos_finalizados.php">Investimentos Finalizados</a>
        <a href="grafico_investimentos.php">Gráfico de Investimentos</a>
    </div>
    <p><a href="dashboard_financeiro.php">← Voltar</a></p>
</div>
</body>
</html>
