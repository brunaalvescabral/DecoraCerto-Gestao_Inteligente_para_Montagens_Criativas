<?php
include 'conexao.php';

$id = $_GET['id'] ?? null;
if (!$id) die("ID não informado.");

$stmt = $conn->prepare("SELECT a.*, c.nome AS cliente_nome, k.nome AS kit_nome, valor 
                        FROM alugueis a
                        JOIN clientes c ON a.cliente_id = c.id
                        JOIN kits k ON a.kit_id = k.id
                        WHERE a.id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$orcamento = $stmt->get_result()->fetch_assoc();

if (!$orcamento) die("Orçamento não encontrado.");
?>

<h2>Editar Orçamento #<?= $orcamento['id'] ?></h2>
<form action="caixa_salvar_orcamento.php" method="POST">
    <input type="hidden" name="id" value="<?= $orcamento['id'] ?>">
    <input type="hidden" id="valor" value="<?= $orcamento['valor'] ?>">

    Cliente: <b><?= htmlspecialchars($orcamento['cliente_nome']) ?></b><br>
    Kit: <b><?= htmlspecialchars($orcamento['kit_nome']) ?></b><br><br>

    Data Retirada:<br>
    <input type="date" name="data_retirada" id="data_retirada" value="<?= $orcamento['data_retirada'] ?>" onchange="calcularValor()" required><br><br>

    Data Devolução:<br>
    <input type="date" name="data_devolucao" id="data_devolucao" value="<?= $orcamento['data_devolucao'] ?>" onchange="calcularValor()" required><br><br>

    Desconto (R$):<br>
    <input type="number" step="0.01" name="desconto" id="desconto" value="<?= $orcamento['desconto'] ?>" oninput="calcularValor()"><br><br>

    Acréscimo (R$):<br>
    <input type="number" step="0.01" name="acrescimo" id="acrescimo" value="<?= $orcamento['acrescimo'] ?>" oninput="calcularValor()"><br><br>

    Forma de Pagamento:<br>
    <select name="forma_pagamento_id" required>
        <option value="">Selecione</option>
        <?php
        $formas = $conn->query("SELECT id, nome FROM formas_pagamento");
        while ($f = $formas->fetch_assoc()) {
            $sel = ($f['id'] == $orcamento['forma_pagamento_id']) ? 'selected' : '';
            echo "<option value='{$f['id']}' $sel>" . htmlspecialchars($f['nome']) . "</option>";
        }
        ?>
    </select><br><br>

    Valor Total (R$):<br>
    <input type="number" step="0.01" name="valor_total" id="valor_total" value="<?= $orcamento['valor_total'] ?>" readonly><br><br>

    <button type="submit">Salvar e Marcar como Atendido</button>
</form>

<script>
function calcularValor() {
    const diaria = parseFloat(document.getElementById('valor_diaria').value);
    const retirada = new Date(document.getElementById('data_retirada').value);
    const devolucao = new Date(document.getElementById('data_devolucao').value);
    const desconto = parseFloat(document.getElementById('desconto').value || 0);
    const acrescimo = parseFloat(document.getElementById('acrescimo').value || 0);

    const dias = Math.ceil((devolucao - retirada) / (1000 * 60 * 60 * 24));
    if (dias <= 0) {
        document.getElementById('valor_total').value = '';
        return;
    }

    const total = (diaria * dias) + acrescimo - desconto;
    document.getElementById('valor_total').value = total.toFixed(2);
}
</script>
