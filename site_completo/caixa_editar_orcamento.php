<?php
include 'conexao.php';

if (!$conn) {
    die("Erro na conexão com o banco de dados.");
}

// Captura o ID passado por GET
$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID do orçamento não informado.");
}

// Consulta os dados do orçamento
$stmt = $conn->prepare("SELECT a.*, c.nome AS cliente_nome, k.nome AS kit_nome, k.valor 
                        FROM alugueis a
                        JOIN clientes c ON a.cliente_id = c.id
                        JOIN kits k ON a.kit_id = k.id
                        WHERE a.id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$orcamento = $result->fetch_assoc();

if (!$orcamento) {
    die("Orçamento não encontrado.");
}
?>
<!-- Botão de Fechar Modal -->
<style>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    z-index: 10;
    display: flex;
    justify-content: center;
    align-items: center;
}
.modal {
    background: white;
    padding: 30px;
    border-radius: 12px;
    width: 600px;
    max-width: 90%;
    position: relative;
}
.modal h2 {
    margin-top: 0;
    font-size: 20px;
    color: #333;
}
.modal input, .modal select {
    width: 100%;
    padding: 8px;
    margin-top: 6px;
    margin-bottom: 16px;
    border-radius: 5px;
    border: 1px solid #ccc;
}
.modal button {
    background-color: #28a745;
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 6px;
    cursor: pointer;
}
.modal button:hover {
    background-color: #218838;
}
.close-btn {
    position: absolute;
    top: 10px;
    right: 16px;
    font-size: 36px;
    color: #aaa;
    cursor: pointer;
    user-select: none; /* evita seleção do X ao clicar */
}
.close-btn:hover {
    color: #000;
}
</style>

<div class="modal-overlay" id="modalEditar">
    <div class="modal">
        <span class="close-btn" onclick="window.location.href='caixa_orcamentos_pendentes.php'">&times;</span>

        
        <h2>Editar Orçamento #<?= $orcamento['id'] ?></h2>
        <form action="caixa_salvar_orcamento.php" method="POST">
            <input type="hidden" name="id" value="<?= $orcamento['id'] ?>">
            <input type="hidden" id="valor_diaria" value="<?= $orcamento['valor'] ?>">

            <p><strong>Cliente:</strong> <?= htmlspecialchars($orcamento['cliente_nome']) ?></p>
            <p><strong>Kit:</strong> <?= htmlspecialchars($orcamento['kit_nome']) ?></p>

            <label>Data Retirada:</label>
            <input type="date" name="data_retirada" id="data_retirada" value="<?= $orcamento['data_retirada'] ?>" onchange="calcularValor()" required>

            <label>Data Devolução:</label>
            <input type="date" name="data_devolucao" id="data_devolucao" value="<?= $orcamento['data_devolucao'] ?>" onchange="calcularValor()" required>

            <label>Desconto (R$):</label>
            <input type="number" step="0.01" name="desconto" id="desconto" value="<?= $orcamento['desconto'] ?>" oninput="calcularValor()">

            <label>Acréscimo (R$):</label>
            <input type="number" step="0.01" name="acrescimo" id="acrescimo" value="<?= $orcamento['acrescimo'] ?>" oninput="calcularValor()">

            <label>Forma de Pagamento:</label>
            <select name="forma_pagamento_id" required>
                <option value="">Selecione</option>
                <?php
                $formas = $conn->query("SELECT id, nome FROM formas_pagamento");
                while ($f = $formas->fetch_assoc()) {
                    $sel = ($f['id'] == $orcamento['forma_pagamento_id']) ? 'selected' : '';
                    echo "<option value='{$f['id']}' $sel>" . htmlspecialchars($f['nome']) . "</option>";
                }
                ?>
            </select>

            <label>Valor Total (R$):</label>
            <input type="number" step="0.01" name="valor_total" id="valor_total" value="<?= $orcamento['valor_total'] ?>" readonly>

            <button type="submit">Salvar e Marcar como Atendido</button>
        </form>
    </div>
</div>

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

function fecharModal() {
    document.getElementById("modalEditar").style.display = "none";
}
</script>
