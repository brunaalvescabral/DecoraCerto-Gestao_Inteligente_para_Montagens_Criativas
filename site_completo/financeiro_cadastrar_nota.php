<?php
include 'conexao.php';

// Buscar todas as notas fiscais já cadastradas
$sql_notas = "SELECT * FROM notas_fiscais ORDER BY data_cadastro DESC";
$result_notas = $conn->query($sql_notas);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Cadastrar Nota Fiscal</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f7f9fc;
            margin: 0; padding: 20px 30px;
            color: #333;
        }
        h2 {
            color: #004085;
            border-bottom: 3px solid #007bff;
            padding-bottom: 6px;
            margin-bottom: 20px;
        }
        form {
            background: white;
            padding: 25px 30px;
            border-radius: 10px;
            box-shadow: 0 3px 15px rgb(0 0 0 / 0.1);
            max-width: 800px;
            margin-bottom: 50px;
        }
        label {
            font-weight: 600;
            display: block;
            margin-bottom: 6px;
            margin-top: 20px;
            color: #212529;
        }
        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1.5px solid #ced4da;
            border-radius: 6px;
            font-size: 15px;
            transition: border-color 0.2s ease;
            box-sizing: border-box;
        }
        input[type="text"]:focus,
        input[type="number"]:focus,
        textarea:focus {
            border-color: #007bff;
            outline: none;
        }
        textarea {
            resize: vertical;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 12px 22px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 25px;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0056b3;
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
            border: 1px solid #dee2e6;
            padding: 10px 12px;
            border-radius: 6px;
            background-color: #f8f9fa;
        }
        .produto-row input[type="text"],
        .produto-row input[type="number"] {
            flex: 1 1 180px;
            max-width: 250px;
        }
        .produto-row span.subtotal {
            min-width: 100px;
            font-weight: 600;
            color: #212529;
        }
        .produto-row button {
            flex: 0 0 auto;
            background-color: #dc3545;
            padding: 6px 12px;
            font-size: 14px;
            border-radius: 6px;
            margin-left: auto;
        }
        .produto-row button:hover {
            background-color: #b02a37;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 15px rgb(0 0 0 / 0.1);
        }
        th, td {
            padding: 14px 18px;
            border-bottom: 1px solid #dee2e6;
            text-align: left;
            font-size: 15px;
        }
        th {
            background-color: #007bff;
            color: white;
            font-weight: 600;
            text-transform: uppercase;
        }
        tr:hover {
            background-color: #f1f5fb;
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
            adicionarProduto(); // adiciona uma linha inicialmente
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
    </form>

    <hr style="margin: 40px 0; border: 1px solid #dee2e6;">

    <h2>Notas Fiscais Cadastradas</h2>

    <table>
        <thead>
            <tr>
                <th>Número</th>
                <th>Empresa</th>
                <th>Valor</th>
                <th>Frete</th>
                <th>Data Cadastro</th>
                <th>Observação</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result_notas->num_rows > 0): ?>
                <?php while ($nota = $result_notas->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($nota['numero_nota']) ?></td>
                        <td><?= htmlspecialchars($nota['empresa']) ?></td>
                        <td>R$ <?= number_format($nota['valor'], 2, ',', '.') ?></td>
                        <td>R$ <?= number_format($nota['frete'], 2, ',', '.') ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($nota['data_cadastro'])) ?></td>
                        <td><?= htmlspecialchars($nota['observacao']) ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="6" style="text-align:center;">Nenhuma nota fiscal cadastrada ainda.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
