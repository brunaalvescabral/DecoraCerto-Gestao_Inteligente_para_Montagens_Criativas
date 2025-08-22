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
<html>
<head>
    <meta charset="UTF-8">
    <title>Termo de Compromisso</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; margin: 40px; }
        .termo { max-width: 800px; margin: auto; }
        .assinatura { margin-top: 50px; }
        .assinatura div { margin-top: 40px; }
    </style>
</head>
<body>
    <div class="termo">
        <h2 style="text-align: center;">Termo de Compromisso</h2>

        <p>
            Eu, <strong><?= htmlspecialchars($orcamento['cliente_nome']) ?></strong>,
            telefone <strong><?= htmlspecialchars($orcamento['contato']) ?></strong>,
            declaro que estou ciente das condições do empréstimo do kit <strong><?= htmlspecialchars($orcamento['kit_nome']) ?></strong>,
            referente ao período de <strong><?= $orcamento['data_retirada'] ?></strong> a <strong><?= $orcamento['data_devolucao'] ?></strong>.
        </p>

        <p>
            Valor total do serviço: <strong>R$ <?= number_format($orcamento['valor_total'], 2, ',', '.') ?></strong>,
            considerando eventuais descontos e acréscimos.
        </p>

        <p>
            Comprometo-me a devolver os materiais em perfeito estado, respeitando os prazos e condições previamente estabelecidos.
        </p>

        <div class="assinatura">
            <div>_____________________________________________<br>Assinatura do Cliente</div>
            <div>Data: <?= date('d/m/Y') ?></div>
        </div>
    </div>

    <script>
        window.print();
    </script>
</body>
</html>
