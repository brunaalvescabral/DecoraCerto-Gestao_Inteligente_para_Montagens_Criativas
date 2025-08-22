<?php
include 'conexao.php';

$formas_pagamento = mysqli_query($conn, "SELECT id, nome FROM formas_pagamento");

$cliente_id = $_GET['cliente_id'] ?? '';
$cliente_nome = $_GET['cliente_nome'] ?? '';
$kit_id = $_GET['kit_id'] ?? '';
$kit_nome = $_GET['kit_nome'] ?? '';
$data_retirada = $_GET['data_retirada'] ?? '';
$data_devolucao = $_GET['data_devolucao'] ?? '';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Aluguel de Kit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="card shadow-lg rounded-4">
        <div class="card-body">
            <h2 class="card-title text-center mb-4">Realizar Aluguel de Kit</h2>

            <form action="processar_aluguel.php" method="POST" id="formAluguel">

                <!-- CLIENTE -->
                <div class="mb-3">
                    <label class="form-label">Cliente:</label>
                    <input type="hidden" name="cliente_id" id="cliente_id" required>
                    <div class="input-group">
                        <input type="text" id="cliente_nome" class="form-control" readonly placeholder="Nenhum cliente selecionado">
                        <button type="button" class="btn btn-primary" onclick="abrirSelecionar('cliente')">Selecionar</button>
                    </div>
                </div>

                <!-- KIT -->
                <div class="mb-3">
                    <label class="form-label">Kit:</label>
                    <input type="hidden" name="kit_id" id="kit_id" required>
                    <div class="input-group">
                        <input type="text" id="kit_nome" class="form-control" readonly placeholder="Nenhum kit selecionado">
                        <button type="button" class="btn btn-primary" onclick="abrirSelecionar('kit')">Selecionar</button>
                    </div>
                </div>

                <!-- DATAS -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Data de Retirada:</label>
                        <input type="date" name="data_retirada" id="data_retirada" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Data de Devolução:</label>
                        <input type="date" name="data_devolucao" id="data_devolucao" class="form-control" required>
                    </div>
                </div>

                <p id="aviso_disponibilidade" class="text-danger fw-bold text-center"></p>

                <!-- DIAS -->
                <div class="mb-3">
                    <label class="form-label">Dias de Aluguel:</label>
                    <input type="text" id="dias_aluguel" class="form-control" readonly>
                </div>

                <!-- FORMA PAGAMENTO -->
                <div class="mb-3">
                    <label class="form-label">Forma de Pagamento:</label>
                    <select name="forma_pagamento_id" class="form-select" required>
                        <option value="">Selecione</option>
                        <?php while ($fp = mysqli_fetch_assoc($formas_pagamento)) { ?>
                            <option value="<?= $fp['id'] ?>"><?= htmlspecialchars($fp['nome']) ?></option>
                        <?php } ?>
                    </select>
                </div>

                <!-- DESCONTO / ACRÉSCIMO -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Desconto (R$):</label>
                        <input type="number" name="desconto" id="desconto" step="0.01" min="0" value="0" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Acréscimo (R$):</label>
                        <input type="number" name="acrescimo" id="acrescimo" step="0.01" min="0" value="0" class="form-control">
                    </div>
                </div>

                <!-- VALOR TOTAL -->
                <div class="mb-4">
                    <label class="form-label">Valor Total (R$):</label>
                    <input type="text" name="valor_total" id="valor_total" class="form-control fw-bold text-success" readonly>
                </div>

                <div class="d-flex justify-content-center gap-3 mt-3">
                    <a href="dashboard_alugueis.php" class="btn btn-success fw-bold">← Voltar</a>
                    <button type="submit" class="btn btn-success fw-bold" id="btnConfirmar">Confirmar Aluguel</button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    function abrirSelecionar(tipo) {
        const url = tipo === 'cliente' ? 'selecionar_cliente.php' : 'selecionar_kit.php';
        window.open(url, '_blank', 'width=600,height=400');
    }

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
            const diffTime = dt2 - dt1;
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
                    calcularTotal();
                }
            })
            .catch(err => {
                aviso.textContent = "Erro ao verificar disponibilidade.";
                btnConfirmar.disabled = true;
            });
        }
    }

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

    window.addEventListener('load', () => {
        document.querySelectorAll('#data_retirada, #data_devolucao, #desconto, #acrescimo').forEach(el => {
            el.addEventListener('input', verificarDisponibilidade);
            el.addEventListener('change', verificarDisponibilidade);
        });
    });
</script>

</body>
</html>
