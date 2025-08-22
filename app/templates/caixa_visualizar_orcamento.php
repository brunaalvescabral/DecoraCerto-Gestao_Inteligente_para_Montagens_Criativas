<?php
include 'conexao.php';

$id = $_GET['id'] ?? null;
if (!$id) die("ID não informado.");

$stmt = $conn->prepare("SELECT a.*, c.nome AS cliente_nome, c.contato, k.nome AS kit_nome 
                        FROM alugueis a
                        JOIN clientes c ON a.cliente_id = c.id
                        JOIN kits k ON a.kit_id = k.id
                        WHERE a.id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$orcamento = $stmt->get_result()->fetch_assoc();

if (!$orcamento) die("Orçamento não encontrado.");
?>

<h2>Orçamento Atendido</h2>

<p><strong>Cliente:</strong> <?= htmlspecialchars($orcamento['cliente_nome']) ?></p>
<p><strong>Telefone:</strong> <?= htmlspecialchars($orcamento['contato']) ?></p>
<p><strong>Kit:</strong> <?= htmlspecialchars($orcamento['kit_nome']) ?></p>
<p><strong>Retirada:</strong> <?= $orcamento['data_retirada'] ?></p>
<p><strong>Devolução:</strong> <?= $orcamento['data_devolucao'] ?></p>
<p><strong>Desconto:</strong> R$ <?= number_format($orcamento['desconto'], 2, ',', '.') ?></p>
<p><strong>Acréscimo:</strong> R$ <?= number_format($orcamento['acrescimo'], 2, ',', '.') ?></p>
<p><strong>Valor Total:</strong> R$ <?= number_format($orcamento['valor_total'], 2, ',', '.') ?></p>

<br>
<a href="gerar_termo_compromisso.php?id=<?= $orcamento['id'] ?>" target="_blank">
    <button>Gerar Termo de Compromisso</button>
</a>
