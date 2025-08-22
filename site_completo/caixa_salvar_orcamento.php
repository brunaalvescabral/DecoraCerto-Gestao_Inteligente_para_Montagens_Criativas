<?php
include 'conexao.php';

$mensagem = "";
$sucesso = false;

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obter os dados do formulário
    $id = $_POST['id'] ?? null;
    $data_retirada = $_POST['data_retirada'] ?? null;
    $data_devolucao = $_POST['data_devolucao'] ?? null;
    $desconto = floatval($_POST['desconto'] ?? 0);
    $acrescimo = floatval($_POST['acrescimo'] ?? 0);
    $valor_total = floatval($_POST['valor_total'] ?? 0);
    $forma_pagamento_id = $_POST['forma_pagamento_id'] ?? null;

    // Validação básica
    if (!$id || !$data_retirada || !$data_devolucao || !$forma_pagamento_id) {
        $mensagem = "❌ Dados obrigatórios ausentes. Verifique o preenchimento do formulário.";
    } elseif (strtotime($data_devolucao) <= strtotime($data_retirada)) {
        $mensagem = "❌ A data de devolução deve ser posterior à data de retirada.";
    } else {
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
            $mensagem = "✅ Orçamento atendido com sucesso!<br><a href='caixa_alugueis_atendidos.php'>Ver Orçamentos Atendidos</a>";
            $sucesso = true;
        } else {
            $mensagem = "❌ Erro ao salvar: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
} else {
    $mensagem = "⚠️ Acesso inválido: este script só pode ser executado via formulário (POST).";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Resultado</title>
    <style>
        /* Modal */
        .modal {
            display: flex;
            position: fixed;
            z-index: 999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            justify-content: center;
            align-items: center;
            background-color: rgba(0, 0, 0, 0.6);
        }

        .modal-content {
            background-color: #fff;
            padding: 20px 30px;
            border-radius: 12px;
            text-align: center;
            width: 400px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            font-family: Arial, sans-serif;
            position: relative;
        }

        .modal-content h2 {
            margin-bottom: 15px;
        }

        .modal-content p {
            font-size: 16px;
        }

        .modal-content a {
            display: inline-block;
            margin-top: 15px;
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 8px;
        }

        .modal-content .fechar {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            margin-top: 20px;
            border-radius: 8px;
        }
    </style>
</head>
<body>

<?php if (!empty($mensagem)): ?>
    <div class="modal" id="mensagemModal">
        <div class="modal-content">
            <h2><?= $sucesso ? "Sucesso" : "Erro" ?></h2>
            <p><?= $mensagem ?></p>
            <a href="caixa_orcamentos_pendentes.php" class="fechar" style="display:inline-block; padding:8px 12px; background:#f44336; color:#fff; border-radius:8px; text-decoration:none; cursor:pointer;">Fechar</a>
        </div>
    </div>
<?php endif; ?>

</body>
</html>
