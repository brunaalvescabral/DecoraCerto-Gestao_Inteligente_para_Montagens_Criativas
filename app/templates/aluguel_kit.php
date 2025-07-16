<?php
include 'conexao.php';

// Buscar formas de pagamento
$formas_pagamento = mysqli_query($conn, "SELECT id, nome FROM formas_pagamento");
?>

<h2>Realizar Aluguel de Kit</h2>

<form action="processar_aluguel.php" method="POST" id="formAluguel">

    <!-- CLIENTE -->
    <label>Cliente:</label>
    <input type="hidden" name="cliente_id" id="cliente_id" required>
    <input type="text" id="cliente_nome" readonly placeholder="Nenhum cliente selecionado">
    <button type="button" onclick="abrirSelecionar('cliente')">Selecionar Cliente</button><br><br>

    <!-- KIT -->
    <label>Kit:</label>
    <input type="hidden" name="kit_id" id="kit_id" required>
    <input type="text" id="kit_nome" readonly placeholder="Nenhum kit selecionado">
    <button type="button" onclick="abrirSelecionar('kit')">Selecionar Kit</button><br><br>

    <!-- DATAS -->
    <label>Data de Retirada:</label>
    <input type="date" name="data_retirada" id="data_retirada" required><br><br>

    <label>Data de Devolução:</label>
    <input type="date" name="data_devolucao" id="data_devolucao" required><br><br>

    <p id="aviso_disponibilidade" style="color:red;"></p>

    <!-- DIAS AUTOMÁTICOS -->
    <label>Dias de Aluguel:</label>
    <input type="text" id="dias_aluguel" readonly><br><br>

    <!-- FORMA DE PAGAMENTO -->
    <label>Forma de Pagamento:</label>
    <select name="forma_pagamento_id" required>
        <option value="">Selecione</option>
        <?php while ($fp = mysqli_fetch_assoc($formas_pagamento)) { ?>
            <option value="<?= $fp['id'] ?>"><?= htmlspecialchars($fp['nome']) ?></option>
        <?php } ?>
    </select><br><br>

    <!-- DESCONTO E ACRÉSCIMO -->
    <label>Desconto (R$):</label>
    <input type="number" name="desconto" id="desconto" step="0.01" min="0" value="0"><br><br>

    <label>Acréscimo (R$):</label>
    <input type="number" name="acrescimo" id="acrescimo" step="0.01" min="0" value="0"><br><br>

    <!-- VALOR TOTAL -->
    <label>Valor Total (R$):</label>
    <input type="text" name="valor_total" id="valor_total" readonly><br><br>

    <input type="submit" value="Confirmar Aluguel" id="btnConfirmar">
</form>

<script>
    // Abre as janelas de seleção
    function abrirSelecionar(tipo) {
        if (tipo === 'cliente') {
            window.open('selecionar_cliente.php', '_blank', 'width=600,height=400');
        } else if (tipo === 'kit') {
            window.open('selecionar_kit.php', '_blank', 'width=600,height=400');
        }
    }

    // Cálculo do valor total
    function calcularTotal() {
        const precoPorDia = parseFloat(localStorage.getItem('kit_preco') || 0);
        const dataRetirada = document.getElementById('data_retirada').value;
        const dataDevolucao = document.getElementById('data_devolucao').value;
        const desconto = parseFloat(document.getElementById('desconto').value || 0);
        const acrescimo = parseFloat(document.getElementById('acrescimo').value || 0);

        let dias = 0;

        if (dataRetirada && dataDevolucao) {
            const dt1 = new Date(dataRetirada);
            const dt2 = new Date(dataDevolucao);

            const diffTime = dt2.getTime() - dt1.getTime();
            dias = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            if (dias < 1) {
                alert("A data de devolução deve ser posterior à data de retirada.");
                document.getElementById('data_devolucao').value = "";
                document.getElementById('dias_aluguel').value = "";
                document.getElementById('valor_total').value = "";
                return;
            }
        }

        const total = (precoPorDia * dias) + acrescimo - desconto;

        document.getElementById('dias_aluguel').value = dias + " dia(s)";
        document.getElementById('valor_total').value = total >= 0 ? total.toFixed(2) : '0.00';
    }

    // Verifica disponibilidade do kit via AJAX
    function verificarDisponibilidade() {
        const kit_id = document.getElementById('kit_id').value;
        const data_retirada = document.getElementById('data_retirada').value;
        const data_devolucao = document.getElementById('data_devolucao').value;

        const aviso = document.getElementById('aviso_disponibilidade');
        const btnConfirmar = document.getElementById('btnConfirmar');

        aviso.textContent = '';
        btnConfirmar.disabled = false;

        if (kit_id && data_retirada && data_devolucao) {
            const formData = new FormData();
            formData.append('kit_id', kit_id);
            formData.append('data_retirada', data_retirada);
            formData.append('data_devolucao', data_devolucao);

            fetch('verificar_disponibilidade.php', {
                method: 'POST',
                body: formData
            })
            .then(resp => resp.json())
            .then(data => {
                if (!data.disponivel) {
                    aviso.textContent = "❌ Kit indisponível neste período.";
                    document.getElementById('valor_total').value = '';
                    btnConfirmar.disabled = true;
                } else {
                    aviso.textContent = '';
                    btnConfirmar.disabled = false;
                    calcularTotal(); // só calcula se disponível
                }
            })
            .catch(err => {
                aviso.textContent = "Erro ao verificar disponibilidade.";
                btnConfirmar.disabled = true;
            });
        }
    }

    // Atualiza campos ao voltar para a aba (preenche cliente, kit e preço)
    window.addEventListener('focus', function () {
        const clienteId = localStorage.getItem('cliente_id');
        const clienteNome = localStorage.getItem('cliente_nome');
        const kitId = localStorage.getItem('kit_id');
        const kitNome = localStorage.getItem('kit_nome');
        const kitPreco = localStorage.getItem('kit_preco');

        if (clienteId && clienteNome) {
            document.getElementById('cliente_id').value = clienteId;
            document.getElementById('cliente_nome').value = clienteNome;
        }

        if (kitId && kitNome && kitPreco) {
            document.getElementById('kit_id').value = kitId;
            document.getElementById('kit_nome').value = kitNome;
            localStorage.setItem('kit_preco', kitPreco);
        }

        calcularTotal();
    });

    // Atualiza valor e verifica disponibilidade ao mudar campos relevantes
    window.addEventListener('load', () => {
        document.querySelectorAll('#data_retirada, #data_devolucao, #desconto, #acrescimo').forEach(el => {
            el.addEventListener('input', () => {
                verificarDisponibilidade();
            });
            el.addEventListener('change', () => {
                verificarDisponibilidade();
            });
        });
    });
</script>
