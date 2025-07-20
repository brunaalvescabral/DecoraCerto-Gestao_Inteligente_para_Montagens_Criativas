<?php
include 'conexao.php';

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $numero_nota = trim($_POST['numero_nota'] ?? '');
    $empresa = trim($_POST['empresa'] ?? '');
    $observacao = trim($_POST['observacao'] ?? '');
    $valor = floatval($_POST['valor'] ?? 0);

    $nomes = $_POST['produto_nome'] ?? [];
    $qtds = $_POST['produto_qtd'] ?? [];
    $valores = $_POST['produto_valor'] ?? [];

    if (empty($numero_nota) || empty($empresa) || empty($nomes) || $valor <= 0) {
        die("Preencha todos os campos obrigatórios.");
    }

    $descricao_produtos = "";
    for ($i = 0; $i < count($nomes); $i++) {
        $nome = htmlspecialchars($nomes[$i]);
        $qtd = intval($qtds[$i]);
        $val = floatval($valores[$i]);
        $subtotal = $qtd * $val;
        $descricao_produtos .= "$nome - $qtd x R$ " . number_format($val, 2, ',', '.') . " = R$ " . number_format($subtotal, 2, ',', '.') . "\n";
    }

    $stmt = $conn->prepare("UPDATE notas_fiscais SET numero_nota=?, empresa=?, produtos=?, valor=?, observacao=? WHERE id=?");
    $stmt->bind_param("sssdsn", $numero_nota, $empresa, $descricao_produtos, $valor, $observacao, $id);

    if ($stmt->execute()) {
        echo "Nota atualizada com sucesso. <a href='financeiro_listar_notas.php'>Voltar</a>";
    } else {
        echo "Erro ao atualizar a nota.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Requisição inválida.";
}
