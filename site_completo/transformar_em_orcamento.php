<?php
include('conexao.php');

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $prereserva_id = $_POST['prereserva_id'];
    $cliente_id = $_POST['cliente_id'];
    $kit_id = $_POST['kit_id'];
    $data_retirada = $_POST['data_retirada'];
    $data_devolucao = $_POST['data_devolucao'];
    $forma_pagamento_id = $_POST['forma_pagamento_id'];
    $desconto = $_POST['desconto'];
    $acrescimo = $_POST['acrescimo'];

    // Buscar valor do kit
    $stmt = $mysqli->prepare("SELECT valor FROM kits WHERE id = ?");
    $stmt->bind_param("i", $kit_id);
    $stmt->execute();
    $stmt->bind_result($valor_base);
    $stmt->fetch();
    $stmt->close();

    $valor_total = $valor_base - $desconto + $acrescimo;
    $data_aluguel = date('Y-m-d');
    $atendido = 1;

    // Inserir na tabela de alugueis
    $stmt = $mysqli->prepare("INSERT INTO alugueis (cliente_id, kit_id, data_retirada, data_devolucao, forma_pagamento_id, desconto, acrescimo, data_aluguel, valor_total, atendido)
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissiddsdi", $cliente_id, $kit_id, $data_retirada, $data_devolucao, $forma_pagamento_id, $desconto, $acrescimo, $data_aluguel, $valor_total, $atendido);

    if ($stmt->execute()) {
        // Atualiza status da pré-reserva para atendida
        $mysqli->query("UPDATE prereservas SET status = 'atendida' WHERE id = $prereserva_id");

        echo "<script>alert('Pré-reserva transformada em orçamento com sucesso!'); window.location='atendente_prereservas.php';</script>";
    } else {
        echo "Erro ao salvar orçamento: " . $stmt->error;
    }

    $stmt->close();
}
?>
