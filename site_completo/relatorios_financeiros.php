<?php
include 'conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <title>Relatórios Financeiros</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      padding: 0;
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

    .container {
      max-width: 950px;
      background: white;
      margin: 50px auto;
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
    }

    h1 {
      text-align: center;
      margin-bottom: 25px;
      font-size: 32px;
      color: #333;
    }

    form {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center;
      margin-bottom: 30px;
    }

    label {
      display: flex;
      flex-direction: column;
      font-size: 0.95rem;
      font-weight: 600;
      color: #555;
      min-width: 180px;
    }

    input[type="date"] {
      padding: 10px 12px;
      font-size: 1rem;
      border: 2px solid #ccc;
      border-radius: 8px;
      transition: border-color 0.3s;
    }

    input[type="date"]:focus {
      border-color: #7A5FFF;
      outline: none;
    }

    button {
      padding: 12px 28px;
      font-size: 1rem;
      font-weight: bold;
      background-color: #7A5FFF;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s;
      margin-top: 25px;
      min-width: 160px;
    }

    button:hover {
      background-color: #5d4bd9;
    }

    p.info {
      text-align: center;
      font-size: 1.1rem;
      color: #555;
      margin: 25px 0 35px;
    }

    .report-list {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
    }

    .report-card {
      background: #f0f4f8;
      padding: 20px 30px;
      border-radius: 12px;
      text-align: center;
      font-weight: 600;
      font-size: 1.05rem;
      color: #2c3e50;
      text-decoration: none;
      transition: transform 0.3s ease, background 0.3s ease;
      min-width: 260px;
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05);
    }

    .report-card:hover {
      background: linear-gradient(90deg, #7A5FFF, #00C16E);
      color: white;
      transform: translateY(-3px);
    }

    .back-link {
      display: block;
      text-align: center;
      margin-top: 40px;
      text-decoration: none;
      color: #7A5FFF;
      font-weight: 600;
      transition: color 0.2s;
    }

    .back-link:hover {
      color: #00C16E;
    }

    @media (max-width: 600px) {
      form {
        flex-direction: column;
        align-items: center;
      }

      label, button {
        width: 100%;
        text-align: center;
      }

      .report-card {
        width: 100%;
      }
    }
  </style>
</head>
<body>

  <header>Relatórios Financeiros</header>

  <div class="container">
    <h1>Selecione o Período</h1>

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
        echo "<p class='info'>Relatórios disponíveis para o período de <strong>$inicio</strong> até <strong>$fim</strong>.</p>";
    } else {
        echo "<p class='info'>Escolha um intervalo de datas para visualizar os relatórios disponíveis.</p>";
    }
    ?>

    <div class="report-list">
      <a class="report-card" href="relatorio_planejamento.php?data_inicio=<?= $inicio ?? '' ?>&data_fim=<?= $fim ?? '' ?>">📊 Planejamento Financeiro</a>
      <a class="report-card" href="relatorio_contabilidade.php?data_inicio=<?= $inicio ?? '' ?>&data_fim=<?= $fim ?? '' ?>">📘 Contabilidade</a>
      <a class="report-card" href="relatorio_custos.php?data_inicio=<?= $inicio ?? '' ?>&data_fim=<?= $fim ?? '' ?>">💰 Gestão de Custos</a>
      <a class="report-card" href="relatorio_investimentos.php?data_inicio=<?= $inicio ?? '' ?>&data_fim=<?= $fim ?? '' ?>">📈 Investimentos</a>
      <a class="report-card" href="relatorio_riscos.php?data_inicio=<?= $inicio ?? '' ?>&data_fim=<?= $fim ?? '' ?>">⚠️ Riscos</a>
    </div>

    <a class="back-link" href="dashboard_financeiro.php">← Voltar</a>
  </div>

</body>
</html>
