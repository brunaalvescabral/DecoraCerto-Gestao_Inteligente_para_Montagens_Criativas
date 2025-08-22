<?php
include 'conexao.php';

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero_nota = trim($_POST['numero_nota'] ?? '');
    $empresa = trim($_POST['empresa'] ?? '');
    $observacao = trim($_POST['observacao'] ?? '');
    $valor = floatval($_POST['valor'] ?? 0);
    $frete = floatval($_POST['frete'] ?? 0);

    $nomes = $_POST['produto_nome'] ?? [];
    $qtds = $_POST['produto_qtd'] ?? [];
    $valores = $_POST['produto_valor'] ?? [];

    if (empty($numero_nota) || empty($empresa) || empty($nomes) || $valor <= 0) {
        die("Por favor, preencha todos os campos obrigatórios.");
    }

    // Verifica duplicidade
    $stmt_check = $conn->prepare("SELECT COUNT(*) FROM notas_fiscais WHERE numero_nota = ? AND empresa = ?");
    $stmt_check->bind_param("ss", $numero_nota, $empresa);
    $stmt_check->execute();
    $stmt_check->bind_result($count);
    $stmt_check->fetch();
    $stmt_check->close();

    if ($count > 0) {
        die("Esta nota fiscal já está cadastrada no sistema.");
    }

    // Inserir nota fiscal
    $stmt_nota = $conn->prepare("INSERT INTO notas_fiscais (numero_nota, empresa, produtos, valor, frete, observacao, data_cadastro) VALUES (?, ?, ?, ?, ?, ?, NOW())");
    $produtos_texto = "Produtos salvos separadamente";
    $stmt_nota->bind_param("sssdss", $numero_nota, $empresa, $produtos_texto, $valor, $frete, $observacao);

    if (!$stmt_nota->execute()) {
        die("Erro ao salvar nota fiscal: " . $stmt_nota->error);
    }

    $nota_id = $stmt_nota->insert_id;
    $stmt_nota->close();

    // Inserir os produtos na nova tabela
    $stmt_produto = $conn->prepare("INSERT INTO produtos_nota (nota_fiscal_id, nome, quantidade, valor_unitario) VALUES (?, ?, ?, ?)");

    for ($i = 0; $i < count($nomes); $i++) {
        $nome = trim($nomes[$i]);
        $qtd = intval($qtds[$i]);
        $valor_unit = floatval($valores[$i]);

        if (!empty($nome) && $qtd > 0 && $valor_unit > 0) {
            $stmt_produto->bind_param("isid", $nota_id, $nome, $qtd, $valor_unit);
            $stmt_produto->execute();
        }
    }

    $stmt_produto->close();
    $conn->close();

    echo "✅ Nota fiscal e produtos cadastrados com sucesso!";
    echo '<br><a href="financeiro_cadastrar_nota.php">Voltar</a>';
} else {
    echo "Requisição inválida.";
}
