<?php
include 'conexao.php';

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $cliente_id = $_POST['cliente_id'];
    $kit_id = $_POST['kit_id'];
    $data_retirada = $_POST['data_retirada'];
    $data_devolucao = $_POST['data_devolucao'];
    $forma_pagamento_id = $_POST['forma_pagamento_id'];
    $desconto = floatval($_POST['desconto'] ?? 0);
    $acrescimo = floatval($_POST['acrescimo'] ?? 0);
    $valor_total = floatval($_POST['valor_total'] ?? 0);

    $sql = "INSERT INTO alugueis 
        (cliente_id, kit_id, data_retirada, data_devolucao, forma_pagamento_id, desconto, acrescimo, valor_total, data_aluguel)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iissiddd", $cliente_id, $kit_id, $data_retirada, $data_devolucao, $forma_pagamento_id, $desconto, $acrescimo, $valor_total);

    if ($stmt->execute()) {
        echo "✅ Aluguel registrado com sucesso!";
    } else {
        echo "❌ Erro ao registrar aluguel: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Requisição inválida.";
}
