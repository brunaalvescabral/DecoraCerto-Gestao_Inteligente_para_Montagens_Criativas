<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <title>Gestão de Receitas</title>
  <style>
    * { box-sizing: border-box; }

    body {
      margin: 0;
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
      background: linear-gradient(90deg, #007bff, #00b894);
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
      .dashboard-container { flex-direction: column; }

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
        border-bottom: 3px solid #ffd54f;
        background-color: transparent;
        color: #ffd54f;
      }

      main {
        padding: 30px 20px;
      }

      .cards { gap: 20px; }

      .cards a {
        padding: 24px;
      }
    }

    /* Overlay */
    #overlay {
      display: none;
      position: fixed;
      z-index: 9999;
      top: 0; left: 0;
      width: 100vw;
      height: 100vh;
      background: rgba(0, 0, 0, 0.6);
      backdrop-filter: blur(3px);
    }

    #overlay .modal {
      background: white;
      padding: 30px;
      max-width: 500px;
      margin: 150px auto;
      border-radius: 10px;
      text-align: center;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
      font-size: 18px;
    }

    #overlay .modal button {
      margin-top: 20px;
      padding: 10px 20px;
      border: none;
      background: #dc3545;
      color: white;
      border-radius: 5px;
      cursor: pointer;
      font-weight: bold;
    }

    #overlay .modal button:hover {
      background: #c82333;
    }
  </style>
</head>
<body>
  <header>
    Gestão de Receitas
  </header>

  <div class="dashboard-container">
    <nav>
      <a href="cadastro_receita.php">Cadastrar Receita</a>
      <a href="lista_receitas.php">Listagem</a>
      <a href="grafico_receitas.php">Gráficos</a>
      <a href="#" id="syncLink">Sincronizar Aluguéis</a>
      <a href="dashboard_financeiro.php">Voltar</a>
    </nav>

    <main>
      <h1>Bem-vindo ao Módulo de Receitas</h1>
      <p>Gerencie suas receitas de forma eficiente. Utilize os atalhos abaixo para acessar os módulos disponíveis.</p>

      <div class="cards">
        <a href="cadastro_receita.php"><span>💰 Cadastrar Receita</span></a>
        <a href="lista_receitas.php"><span>📄 Ver Receitas</span></a>
        <a href="grafico_receitas.php"><span>📊 Gráficos</span></a>
        <a href="#" id="syncCard"><span>🔄 Sincronizar Aluguéis</span></a>
      </div>
    </main>
  </div>

  <!-- Overlay de sincronização -->
  <div id="overlay">
    <div class="modal">
      <div id="syncMessage">Sincronizando aluguéis...</div>
      <button onclick="fecharOverlay()">Fechar</button>
    </div>
  </div>

  <script>
    function abrirOverlay() {
      document.getElementById("overlay").style.display = "block";
      document.getElementById("syncMessage").innerText = "Sincronizando aluguéis...";
      
      fetch("sincronizar_receitas.php")
        .then(res => res.text())
        .then(data => {
          document.getElementById("syncMessage").innerText = data;
        })
        .catch(() => {
          document.getElementById("syncMessage").innerText = "Erro ao sincronizar.";
        });
    }

    function fecharOverlay() {
      document.getElementById("overlay").style.display = "none";
    }

    document.getElementById("syncLink").addEventListener("click", function(e) {
      e.preventDefault();
      abrirOverlay();
    });

    document.getElementById("syncCard").addEventListener("click", function(e) {
      e.preventDefault();
      abrirOverlay();
    });
  </script>
</body>
</html>
