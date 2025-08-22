<?php
include 'conexao.php';

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $forma_id = $_POST['forma_pagamento_id'];

    // Você pode aqui salvar no banco de dados, em sessão, ou redirecionar para próximo passo
    // Por exemplo, salvar numa sessão temporária:
    session_start();
    $_SESSION['forma_pagamento_id'] = $forma_id;

    // Ou buscar o nome da forma de pagamento
    $res = mysqli_query($conn, "SELECT nome FROM formas_pagamento WHERE id = $forma_id");
    $forma = mysqli_fetch_assoc($res);

    echo "<h3>Forma de pagamento selecionada: " . htmlspecialchars($forma['nome']) . "</h3>";
    echo "<a href='proxima_etapa.php'>Avançar</a>";
} else {
    echo "Acesso inválido.";
}
