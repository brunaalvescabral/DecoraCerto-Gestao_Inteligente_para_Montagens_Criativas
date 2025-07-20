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

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Orçamento Atendido</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f9fc;
            margin: 20px;
            color: #333;
        }
        h2 {
            color: #007bff;
            text-align: center;
            margin-bottom: 30px;
        }
        .detalhes {
            background: #fff;
            max-width: 600px;
            margin: 0 auto 40px auto;
            padding: 25px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .detalhes p {
            font-size: 1.1em;
            margin: 10px 0;
            line-height: 1.5;
        }
        .detalhes strong {
            color: #555;
            width: 140px;
            display: inline-block;
        }
        a button {
            display: block;
            margin: 0 auto;
            background-color: #28a745;
            border: none;
            color: white;
            padding: 12px 30px;
            font-size: 1.1em;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-align: center;
        }
        a button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<h2>Orçamento Atendido</h2>


<div class="detalhes">
    <p><strong>Cliente:</strong> <?= htmlspecialchars($orcamento['cliente_nome']) ?></p>
    <p><strong>Telefone:</strong> <?= htmlspecialchars($orcamento['contato']) ?></p>
    <p><strong>Kit:</strong> <?= htmlspecialchars($orcamento['kit_nome']) ?></p>
    <p><strong>Retirada:</strong> <?= date('d/m/Y', strtotime($orcamento['data_retirada'])) ?></p>
    <p><strong>Devolução:</strong> <?= date('d/m/Y', strtotime($orcamento['data_devolucao'])) ?></p>
    <p><strong>Desconto:</strong> R$ <?= number_format($orcamento['desconto'], 2, ',', '.') ?></p>
    <p><strong>Acréscimo:</strong> R$ <?= number_format($orcamento['acrescimo'], 2, ',', '.') ?></p>
    <p><strong>Valor Total:</strong> R$ <?= number_format($orcamento['valor_total'], 2, ',', '.') ?></p>
    <a href="caixa_alugueis_atendidos.php" class="botao">← Voltar</a>
</div>

<a href="gerar_termo_compromisso.php?id=<?= $orcamento['id'] ?>" target="_blank">
    <button>Gerar Termo de Compromisso</button>
</a>

</body>
</html>
