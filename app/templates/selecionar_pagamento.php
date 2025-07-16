<?php
include 'conexao.php';

// Busca formas de pagamento ativas
$query = "SELECT * FROM formas_pagamento WHERE ativo = 1";
$result = mysqli_query($conn, $query);
?>

<h2>Selecione a Forma de Pagamento</h2>

<form action="confirmar_pagamento.php" method="POST">
    <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <label>
            <input type="radio" name="forma_pagamento_id" value="<?= $row['id'] ?>" required>
            <?= htmlspecialchars($row['nome']) ?>
        </label><br>
    <?php } ?>

    <br>
    <input type="submit" value="Confirmar Forma de Pagamento">
</form>
