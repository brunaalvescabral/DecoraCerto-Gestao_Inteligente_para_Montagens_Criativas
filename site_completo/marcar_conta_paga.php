<?php
require_once("conexao.php");

$id = $_GET['id'];

$sql = "UPDATE contas_pagar SET status='Paga' WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "Conta marcada como paga!";
} else {
    echo "Erro ao atualizar status!";
}
?>
