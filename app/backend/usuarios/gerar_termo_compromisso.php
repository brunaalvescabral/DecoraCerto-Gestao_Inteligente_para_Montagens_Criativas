<?php
$id = $_GET['id'] ?? null;
if (!$id) die("ID não informado.");
$stmt = $conn->prepare("SELECT a.*, c.nome AS cliente_nome, c.contato, k.nome AS kit_nome 
                        FROM alugueis a
                        JOIN clientes c ON a.cliente_id = c.id
                        JOIN kits k ON a.kit_id = k.id
                        WHERE a.id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();
if (!$result) die("Orçamento não encontrado.");