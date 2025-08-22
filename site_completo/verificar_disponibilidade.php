<?php
include 'conexao.php';

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $kit_id = $_POST['kit_id'] ?? null;
    $data_retirada = $_POST['data_retirada'] ?? null;
    $data_devolucao = $_POST['data_devolucao'] ?? null;

    if (!$kit_id || !$data_retirada || !$data_devolucao) {
        echo json_encode(['disponivel' => false, 'erro' => 'Dados incompletos.']);
        exit;
    }

    $sql = "SELECT id FROM alugueis 
            WHERE kit_id = ? 
            AND (
                data_retirada <= ? AND data_devolucao >= ?
            )";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $kit_id, $data_devolucao, $data_retirada);
    $stmt->execute();
    $res = $stmt->get_result();

    $disponivel = $res->num_rows === 0;

    echo json_encode(['disponivel' => $disponivel]);
}
