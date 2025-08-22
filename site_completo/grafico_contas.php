<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gráficos Mensais de Contas</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@1.1.0/dist/chartjs-plugin-annotation.min.js"></script>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #6858b7ff, #1abc9c);
            margin: 0;
            padding: 20px 30px;
            color: #333; }
        .container { max-width: 100%; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px #ccc; }
        h2 { text-align: center; margin-bottom: 30px; }
        .graficos {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 30px;
        }
        canvas {
            width: 100%;
            height: 400px !important;
            max-width: 600px;
            background: #fff;
            padding: 10px;
            border-radius: 10px;
        }
        .filtro-form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 10px;
            margin-bottom: 20px;
        }
        .filtro-form label {
            display: flex;
            flex-direction: column;
        }
        .filtro-form input, .filtro-form select{
            padding: 8px; border-radius: 5px; border: 1px solid #ccc;
        }
        .filtro-form button {background:  #464390ff; color: white; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer;}
    </style>
</head>
<body>
<div class="container">
    <a href="dashboard_contas_pagar.php" class="botao-voltar">← Voltar</a>
    <h2>Gráficos Mensais de Despesas</h2>

    <form class="filtro-form" method="GET" id="filtro-form">
        <label>Data Registro (de): <input type="date" name="data_registro_inicio" id="data_registro_inicio"></label>
        <label>Data Registro (até): <input type="date" name="data_registro_fim" id="data_registro_fim"></label>
        <label>Data Vencimento (de): <input type="date" name="data_vencimento_inicio" id="data_vencimento_inicio"></label>
        <label>Data Vencimento (até): <input type="date" name="data_vencimento_fim" id="data_vencimento_fim"></label>
        <label>Status:
            <select name="status" id="status">
                <option value="">Todos</option>
                <option value="Paga">Paga</option>
                <option value="Pendente">Pendente</option>
            </select>
        </label>
        <button type="button" onclick="carregarGraficos()">Filtrar</button>
    </form>

    <div class="graficos">
        <canvas id="grafico_subcategoria"></canvas>
        <canvas id="grafico_categoria"></canvas>
    </div>
</div>

<script>
function carregarGraficos() {
    const dados = {
        data_registro_inicio: document.getElementById('data_registro_inicio').value,
        data_registro_fim: document.getElementById('data_registro_fim').value,
        data_vencimento_inicio: document.getElementById('data_vencimento_inicio').value,
        data_vencimento_fim: document.getElementById('data_vencimento_fim').value,
        status: document.getElementById('status').value,
    };

    const params = new URLSearchParams(dados).toString();

    fetch(`dados_grafico_contas.php?${params}`)
    .then(res => res.json())
    .then(dados => {
        if (window.subcatChart) window.subcatChart.destroy();
        if (window.catChart) window.catChart.destroy();

        const configY = {
            beginAtZero: true,
            min: 0,
            max: 100000,
            ticks: {
                stepSize: 10000,
                callback: function(value) {
                    return 'R$ ' + value.toLocaleString('pt-BR');
                }
            }
        };

        const annotationOptions = {
            annotations: {
                linhaZero: {
                    type: 'line',
                    yMin: 0,
                    yMax: 0,
                    borderColor: 'red',
                    borderWidth: 2,
                    borderDash: [6, 6],
                    label: {
                        content: 'Valor Zero',
                        enabled: true,
                        position: 'start',
                        backgroundColor: 'rgba(255,0,0,0.5)',
                        color: 'white',
                        font: {
                            style: 'normal',
                            weight: 'bold'
                        }
                    }
                }
            }
        };

        const ctx1 = document.getElementById('grafico_subcategoria').getContext('2d');
        window.subcatChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: dados.meses,
                datasets: [
                    {
                        label: 'Despesas Operacionais',
                        data: dados.subcategorias["Despesas Operacionais"],
                        backgroundColor: '#007bff'
                    },
                    {
                        label: 'Despesas Administrativas',
                        data: dados.subcategorias["Despesas Administrativas"],
                        backgroundColor: '#ffc107'
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Despesas por Subcategoria (Mensal)'
                    },
                    annotation: annotationOptions.annotations
                },
                scales: {
                    y: configY
                }
            },
            plugins: [Chart.registry.getPlugin('annotation')]
        });

        const ctx2 = document.getElementById('grafico_categoria').getContext('2d');
        window.catChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: dados.meses,
                datasets: [
                    {
                        label: 'Despesas Fixas',
                        data: dados.categorias["Fixo"],
                        backgroundColor: '#28a745'
                    },
                    {
                        label: 'Despesas Variáveis',
                        data: dados.categorias["Variável"],
                        backgroundColor: '#dc3545'
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Despesas por Categoria (Mensal)'
                    },
                    annotation: annotationOptions.annotations
                },
                scales: {
                    y: configY
                }
            },
            plugins: [Chart.registry.getPlugin('annotation')]
        });
    });
}

window.onload = carregarGraficos;
</script>
</body>
</html>
