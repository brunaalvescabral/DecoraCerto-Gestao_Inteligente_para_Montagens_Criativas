<?php
require_once("conexao.php");

// Verifica se o ID foi passado
if (!isset($_GET['id'])) {
    echo "<h3>ID da conta não especificado.</h3>";
    exit;
}

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];
    $data_venc = $_POST['data_vencimento'];
    $categoria = $_POST['categoria'];
    $subcategoria = $_POST['subcategoria'];

    $sql = "UPDATE contas_pagar SET descricao=?, valor=?, data_vencimento=?, categoria=?, subcategoria=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdsssi", $descricao, $valor, $data_venc, $categoria, $subcategoria, $id);
    $stmt->execute();
    echo "<p class='success'>Conta atualizada com sucesso!</p>";
}

$stmt = $conn->prepare("SELECT * FROM contas_pagar WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$dados = $result->fetch_assoc();

if (!$dados) {
    echo "<h3>Conta não encontrada.</h3>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Conta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f3f3;
            padding: 40px;
        }

        .container {
            background: white;
            padding: 25px 40px;
            max-width: 500px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            margin-top: 25px;
            width: 100%;
            background: #28a745;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background: #218838;
        }

        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 10px;
            border-radius: 5px;
            max-width: 500px;
            margin: 10px auto;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Editar Conta a Pagar</h2>
        <form method="post">
            <label for="descricao">Descrição:</label>
            <input name="descricao" value="<?= htmlspecialchars($dados['descricao']) ?>" required>

            <label for="valor">Valor:</label>
            <input name="valor" type="number" step="0.01" value="<?= $dados['valor'] ?>" required>

            <label for="data_vencimento">Data de Vencimento:</label>
            <input type="date" name="data_vencimento" value="<?= $dados['data_vencimento'] ?>" required>

            <label for="categoria">Categoria:</label>
            <select name="categoria" required>
                <option value="Fixo" <?= $dados['categoria'] == 'Fixo' ? 'selected' : '' ?>>Fixo</option>
                <option value="Variável" <?= $dados['categoria'] == 'Variável' ? 'selected' : '' ?>>Variável</option>
            </select>

            <label for="subcategoria">Subcategoria:</label>
            <select name="subcategoria" required>
                <option value="Despesas Administrativas" <?= $dados['subcategoria'] == 'Despesas Administrativas' ? 'selected' : '' ?>>Despesas Administrativas</option>
                <option value="Despesas Operacionais" <?= $dados['subcategoria'] == 'Despesas Operacionais' ? 'selected' : '' ?>>Despesas Operacionais</option>
            </select>

            <button type="submit">Salvar Alterações</button>
        </form>
    </div>
</body>
</html>
