<?php
include 'conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Cadastrar Nota Fiscal</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #6858b7ff, #1abc9c);
            margin: 0; 
            padding: 20px 30px;
            color: #333;
        }

        h2 {
            color: #fff;
            text-align: center;
            margin-bottom: 20px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
        }

        form {
            background: #ffffff;
            padding: 25px 30px;
            border-radius: 12px;
            max-width: 800px;
            margin: auto;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }

        label {
            font-weight: 600;
            display: block;
            margin-bottom: 6px;
            margin-top: 20px;
            color: #333;
        }

        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1.5px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
            box-sizing: border-box;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        textarea:focus {
            border-color: #8e44ad;
            outline: none;
        }

        textarea {
            resize: vertical;
        }

        button {
            background: linear-gradient(to right, #464390ff, #464390ff);
            color: white;
            border: none;
            padding: 12px 22px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 25px;
            transition: opacity 0.3s ease;
        }

        button:hover {
            opacity: 0.85;
        }

        a {
            display: inline-block;
            margin-left: 15px;
            margin-top: 25px;
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            background: #2c3e50;
            padding: 10px 20px;
            border-radius: 6px;
            transition: background 0.3s ease;
        }

        a:hover {
            background: #1a242f;
        }

        #produtos-container {
            margin-top: 10px;
            margin-bottom: 15px;
        }

        .produto-row {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: center;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            padding: 10px 12px;
            border-radius: 6px;
            background-color: #f1f1f1;
        }

        .produto-row input[type="text"],
        .produto-row input[type="number"] {
            flex: 1 1 180px;
            max-width: 250px;
        }

        .produto-row span.subtotal {
            min-width: 100px;
            font-weight: 600;
            color: #2c3e50;
        }

        .produto-row button {
            flex: 0 0 auto;
            background-color: #e74c3c;
            padding: 6px 12px;
            font-size: 14px;
            border-radius: 6px;
            color: white;
        }

        .produto-row button:hover {
            background-color: #c0392b;
        }

        @media (max-width: 720px) {
            .produto-row {
                flex-direction: column;
                align-items: flex-start;
            }

            .produto-row button {
                margin-left: 0;
                margin-top: 10px;
            }
        }
    </style>

    <script>
        function calcularTotais() {
            let totalNota = 0;
            const linhas = document.querySelectorAll('.produto-row');
            linhas.forEach(row => {
                const qtd = parseFloat(row.querySelector('.quantidade').value) || 0;
                const valor = parseFloat(row.querySelector('.valor_unitario').value) || 0;
                const subtotal = qtd * valor;
                row.querySelector('.subtotal').innerText = subtotal.toFixed(2);
                totalNota += subtotal;
            });

            const frete = parseFloat(document.getElementById('frete').value) || 0;
            document.getElementById('valor_total').value = (totalNota + frete).toFixed(2);
        }

        function adicionarProduto() {
            const container = document.getElementById('produtos-container');
            const novaLinha = document.createElement('div');
            novaLinha.classList.add('produto-row');
            novaLinha.innerHTML = `
                <input type="text" name="produto_nome[]" placeholder="Nome do produto" required>
                <input type="number" name="produto_qtd[]" class="quantidade" placeholder="Qtd" min="1" value="1" required oninput="calcularTotais()">
                <input type="number" name="produto_valor[]" class="valor_unitario" placeholder="Valor unit." step="0.01" min="0" required oninput="calcularTotais()">
                Subtotal: R$ <span class="subtotal">0.00</span>
                <button type="button" onclick="this.parentNode.remove(); calcularTotais();">Remover</button>
            `;
            container.appendChild(novaLinha);
            calcularTotais();
        }

        window.onload = () => {
            adicionarProduto();
        };
    </script>
</head>
<body>
    <h2>Cadastrar Nota Fiscal</h2>

    <form action="financeiro_salvar_nota.php" method="POST">
        <label for="numero_nota">Número da Nota Fiscal*:</label>
        <input type="text" name="numero_nota" id="numero_nota" required>

        <label for="empresa">Empresa*:</label>
        <input type="text" name="empresa" id="empresa" required>

        <label>Produtos*:</label>
        <div id="produtos-container"></div>
        <button type="button" onclick="adicionarProduto()">+ Adicionar Produto</button>

        <label for="frete">Frete (R$):</label>
        <input type="number" name="frete" id="frete" step="0.01" min="0" value="0" oninput="calcularTotais()">

        <label for="observacao">Observação:</label>
        <textarea name="observacao" id="observacao" rows="3" cols="50"></textarea>

        <label for="valor_total">Valor Total (R$):</label>
        <input type="text" name="valor" id="valor_total" readonly required>

        <button type="submit">Salvar</button>
        <a href="dashboard_notas_fiscais.php">Voltar</a>
    </form>
</body>
</html>
