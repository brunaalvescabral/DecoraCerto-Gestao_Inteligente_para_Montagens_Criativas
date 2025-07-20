<?php
require_once("conexao.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];
    $data_venc = $_POST['data_vencimento'];
    $data_reg = $_POST['data_registro'];
    $categoria = $_POST['categoria'];
    $subcategoria = $_POST['subcategoria'];

    $sql = "INSERT INTO contas_pagar (descricao, valor, data_vencimento, data_registro, categoria, subcategoria) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdssss", $descricao, $valor, $data_venc, $data_reg, $categoria, $subcategoria);
    $stmt->execute();
    $msg = "Conta cadastrada com sucesso!";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Conta</title>
    <style>
        body { font-family: Arial; background: #f4f4f4; padding: 30px; }
        .container { background: #fff; padding: 25px; max-width: 500px; margin: auto; border-radius: 10px; box-shadow: 0 0 10px #ccc; }
        h2 { text-align: center; }
        label { display: block; margin-top: 15px; font-weight: bold; }
        input, select { width: 100%; padding: 10px; margin-top: 5px; border-radius: 5px; border: 1px solid #ccc; }
        button { margin-top: 25px; width: 100%; background: #007bff; color: white; padding: 12px; border: none; border-radius: 6px; cursor: pointer; font-size: 16px; }
        button:hover { background: #0056b3; }
        .success { background: #d4edda; padding: 10px; border-radius: 5px; color: #155724; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <a href="dashboard_contas_pagar.php" class="botao-voltar">← Voltar</a>
        <h2>Cadastrar Conta a Pagar</h2>
        <?php if (!empty($msg)) echo "<div class='success'>$msg</div>"; ?>
        <form method="post">
            <label>Descrição:</label>
            <input name="descricao" required>

            <label>Valor:</label>
            <input name="valor" type="number" step="0.01" required>

            <label>Data de Vencimento:</label>
            <input name="data_vencimento" type="date" required>

            <label>Data de Registro:</label>
            <input name="data_registro" type="date" required>

            <label>Categoria:</label>
            <select name="categoria" required>
                <option>Fixo</option>
                <option>Variável</option>
            </select>

            <label>Subcategoria:</label>
            <select name="subcategoria" required>
                <option>Despesas Administrativas</option>
                <option>Despesas Operacionais</option>
            </select>

            <button type="submit">Salvar Conta</button>
        </form>
    </div>
</body>
</html>
