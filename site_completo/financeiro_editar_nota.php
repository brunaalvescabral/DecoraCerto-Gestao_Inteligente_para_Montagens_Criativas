<?php
include 'conexao.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID inválido.");
}

$stmt = $conn->prepare("SELECT * FROM notas_fiscais WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$nota = $result->fetch_assoc();

if (!$nota) {
    die("Nota não encontrada.");
}

$produtos_linhas = explode("\n", $nota['produtos']);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Editar Nota Fiscal</title>
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
            padding-bottom: 8px;
            margin-bottom: 25px;
        }
        form {
            background: white;
            padding: 25px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgb(0 0 0 / 0.1);
            max-width: 700px;
            margin: auto;
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: 600;
            color: #212529;
        }
        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 8px 12px;
            margin-top: 6px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            font-size: 14px;
            box-sizing: border-box;
            font-family: inherit;
        }
        textarea {
            resize: vertical;
        }
        button[type="submit"] {
            margin-top: 25px;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 7px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 700;
            transition: background-color 0.3s ease;
        }
        button[type="submit"]:hover {
            background-color: #0056b3;
        }
        #produtos-container {
            margin-top: 10px;
            margin-bottom: 15px;
        }
        .produto-row {
            background: #e9ecef;
            border-radius: 8px;
            padding: 12px 15px;
            margin-bottom: 12px;
            display: flex;
            gap: 12px;
            align-items: center;
            flex-wrap: wrap;
        }
        .produto-row input[type="text"],
        .produto-row input[type="number"] {
            flex: 1 1 150px;
            min-width: 150px;
        }
        .subtotal {
            font-weight: 600;
            width: 110px;
            color: #212529;
        }
        .produto-row button {
            background-color: #dc3545;
            border: none;
            color: white;
            padding: 7px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 700;
            transition: background-color 0.3s ease;
        }
        .produto-row button:hover {
            background-color: #a71d2a;
        }
        #add-produto-btn {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 7px;
            cursor: pointer;
            font-weight: 700;
            transition: background-color 0.3s ease;
            margin-bottom: 20px;
        }
        #add-produto-btn:hover {
            background-color: #1e7e34;
        }
    </style>
</head>
<body>
    <h2>Editar Nota Fiscal</h2>

    <form action="financeiro_atualizar_nota.php" method="POST">
        <input type="hidden" name="id" value="<?= $nota['id'] ?>">

        <label for="numero_nota">Número da Nota:</label>
        <input type="text" id="numero_nota" name="numero_nota" value="<?= htmlspecialchars($nota['numero_nota']) ?>" required>

        <label for="empresa">Empresa:</label>
        <input type="text" id="empresa" name="empresa" value="<?= htmlspecialchars($nota['empresa']) ?>" required>

        <label>Produtos:</label>
        <div id="produtos-container">
            <?php foreach ($produtos_linhas as $linha):
                if (preg_match('/^(.*?) - (\d+) x R\$ ([\d,\.]+) =/', $linha, $matches)) {
                    $nome = trim($matches[1]);
                    $qtd = $matches[2];
                    $valor = str_replace(',', '.', $matches[3]);
                ?>
                <div class="produto-row">
                    <input type="text" name="produto_nome[]" value="<?= htmlspecialchars($nome) ?>" required>
                    <input type="number" name="produto_qtd[]" class="quantidade" value="<?= $qtd ?>" min="1" required oninput="calcularTotais()">
                    <input type="number" name="produto_valor[]" class="valor_unitario" value="<?= $valor ?>" step="0.01" min="0" required oninput="calcularTotais()">
                    <span class="subtotal">0.00</span>
                    <button type="button" onclick="this.parentNode.remove(); calcularTotais();">Remover</button>
                </div>
            <?php } endforeach; ?>
        </div>
        <button type="button" id="add-produto-btn" onclick="adicionarProduto()">+ Adicionar Produto</button>

        <label for="observacao">Observação:</label>
        <textarea id="observacao" name="observacao" rows="3"><?= htmlspecialchars($nota['observacao']) ?></textarea>

        <label for="valor_total">Valor Total (R$):</label>
        <input type="text" id="valor_total" name="valor" value="<?= number_format($nota['valor'], 2, '.', '') ?>" readonly>

        <button type="submit">Salvar Alterações</button>
    </form>

    <script>
        function calcularTotais() {
            let total = 0;
            document.querySelectorAll('.produto-row').forEach(row => {
                const qtd = parseFloat(row.querySelector('.quantidade').value) || 0;
                const valor = parseFloat(row.querySelector('.valor_unitario').value) || 0;
                const subtotal = qtd * valor;
                row.querySelector('.subtotal').innerText = subtotal.toFixed(2);
                total += subtotal;
            });
            document.getElementById('valor_total').value = total.toFixed(2);
        }

        function adicionarProduto() {
            const container = document.getElementById('produtos-container');
            const div = document.createElement('div');
            div.classList.add('produto-row');
            div.innerHTML = `
                <input type="text" name="produto_nome[]" placeholder="Nome do produto" required>
                <input type="number" name="produto_qtd[]" class="quantidade" placeholder="Qtd" value="1" min="1" required oninput="calcularTotais()">
                <input type="number" name="produto_valor[]" class="valor_unitario" placeholder="Valor unit." step="0.01" value="0" min="0" required oninput="calcularTotais()">
                <span class="subtotal">0.00</span>
                <button type="button" onclick="this.parentNode.remove(); calcularTotais();">Remover</button>
            `;
            container.appendChild(div);
        }

        window.onload = calcularTotais;
    </script>
</body>
</html>
