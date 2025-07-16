<?php
include 'conexao.php';

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {    // Obter os dados do formulário
    $id = $_POST['id'] ?? null;
    $data_retirada = $_POST['data_retirada'] ?? null;
    $data_devolucao = $_POST['data_devolucao'] ?? null;
    $desconto = floatval($_POST['desconto'] ?? 0);
    $acrescimo = floatval($_POST['acrescimo'] ?? 0);
    $valor_total = floatval($_POST['valor_total'] ?? 0);
    $forma_pagamento_id = $_POST['forma_pagamento_id'] ?? null;

    // Validação básica
    if (!$id || !$data_retirada || !$data_devolucao || !$forma_pagamento_id) {
        die("❌ Dados obrigatórios ausentes. Verifique o preenchimento do formulário.");
    }

    if (strtotime($data_devolucao) <= strtotime($data_retirada)) {
        die("❌ A data de devolução deve ser posterior à data de retirada.");
    }

    // Atualizar os dados no banco
    $sql = "UPDATE alugueis SET 
                data_retirada = ?, 
                data_devolucao = ?, 
                desconto = ?, 
                acrescimo = ?, 
                valor_total = ?, 
                forma_pagamento_id = ?, 
                atendido = 1
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "ssddddi", 
        $data_retirada, 
        $data_devolucao, 
        $desconto, 
        $acrescimo, 
        $valor_total, 
        $forma_pagamento_id, 
        $id
    );

    if ($stmt->execute()) {
        echo "✅ Orçamento atendido com sucesso!";
        echo '<br><a href="caixa_alugueis_atendidos.php">Ver Orçamentos Atendidos</a>';
    } else {
        echo "❌ Erro ao salvar: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

} else {
    echo "⚠️ Acesso inválido: este script só pode ser executado via formulário (POST).";
}
