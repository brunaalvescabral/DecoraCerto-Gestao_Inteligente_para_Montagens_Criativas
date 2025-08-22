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
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f5f7fa;
      color: #2c3e50;
    }

    header {
      background: linear-gradient(90deg, #7A5FFF, #00C16E);
      color: #fff;
      padding: 25px 40px;
      font-size: 28px;
      font-weight: 700;
      text-align: center;
      box-shadow: 0 4px 12px rgba(122, 95, 255, 0.3);
    }

    .dashboard-container {
      display: flex;
      min-height: calc(100vh - 90px);
    }

    nav {
      width: 250px;
      background-color: #1e1a33;
      display: flex;
      flex-direction: column;
      padding: 30px 0;
      box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
    }

    nav a {
      padding: 18px 30px;
      color: #fff;
      text-decoration: none;
      font-size: 17px;
      font-weight: 600;
      transition: all 0.3s ease;
      border-left: 4px solid transparent;
    }

    nav a:hover,
    nav a.active {
      background-color: #302a52;
      border-left: 4px solid #ffd54f;
      color: #ffd54f;
    }

    main {
      flex-grow: 1;
      padding: 50px 60px;
      background-color: #f0f4f8;
    }

    main h1 {
      font-size: 34px;
      color: #333;
      margin-bottom: 10px;
    }

    main p {
      font-size: 18px;
      color: #555;
      margin-bottom: 40px;
      max-width: 700px;
    }

    .cards {
      display: flex;
      gap: 30px;
      flex-wrap: wrap;
    }

    .cards a {
      background: white;
      padding: 30px 40px;
      border-radius: 15px;
      text-align: center;
      text-decoration: none;
      color: #2c3e50;
      font-size: 18px;
      font-weight: bold;
      box-shadow: 0 8px 18px rgba(0, 0, 0, 0.1);
      flex: 1 1 250px;
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }

    .cards a::before {
      content: "";
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, #7A5FFF, #00C16E);
      z-index: 0;
      transition: left 0.4s ease;
    }

    .cards a:hover::before {
      left: 0;
    }

    .cards a span {
      position: relative;
      z-index: 1;
      color: #fff;
    }

    @media (max-width: 900px) {
      .dashboard-container {
        flex-direction: column;
      }

      nav {
        flex-direction: row;
        width: 100%;
        justify-content: space-around;
        padding: 10px 0;
      }

      nav a {
        padding: 12px 10px;
        font-size: 15px;
        text-align: center;
        border-left: none;
        border-bottom: 3px solid transparent;
      }

      nav a.active {
        border-left: none;
        border-bottom: 3px solid #ffd54f;
        background-color: transparent;
        color: #ffd54f;
      }

      main {
        padding: 30px 20px;
      }

      .cards {
        gap: 20px;
      }

      .cards a {
        padding: 24px;
      }
    }
  </style>
</head>
<body>
  <header>
    Cadastro de Notas Fiscais
  </header>

  <div class="dashboard-container">
    <nav>
      <a href="financeiro_cadastrar_nota.php">Cadastrar Nota</a>
      <a href="financeiro_listar_notas.php" class="active">Listar Notas</a>
      <a href="dashboard_financeiro.php">Voltar</a>
    </nav>

    <main>
      <h1>Bem-vindo ao Módulo de Notas Fiscais</h1>
      <p>Utilize os atalhos abaixo para gerenciar suas notas fiscais com agilidade e eficiência.</p>

      <div class="cards">
        <a href="financeiro_cadastrar_nota.php"><span>📄 Cadastrar Nota Fiscal</span></a>
        <a href="financeiro_listar_notas.php"><span>📁 Visualizar Notas Fiscais</span></a>
      </div>
    </main>
  </div>
</body>
</html>
