<?php
include_once __DIR__ . '/conexao.php';

if (!isset($conn)) {
    die("Erro: conexão com o banco não estabelecida.");
}

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $componentes = $_POST['componentes'] ?? '';
    $valor = floatval($_POST['valor'] ?? 0);
    $categoria = $_POST['categoria'] ?? '';
    $observacoes = $_POST['observacoes'] ?? '';
    $imagem = null;

    // Processa a imagem, se enviada
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $pastaDestino = __DIR__ . '/assets/imagens/';

        // Cria a pasta se não existir
        if (!is_dir($pastaDestino)) {
            mkdir($pastaDestino, 0777, true);
        }

        $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
        $nomeImagem = uniqid('img_', true) . '.' . $extensao;
        $caminhoCompleto = $pastaDestino . $nomeImagem;

        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoCompleto)) {
            $imagem = $nomeImagem;
        } else {
            echo "❌ Erro ao salvar a imagem.";
            exit;
        }
    }

    // Insere no banco incluindo categoria e observacoes
    $sql = "INSERT INTO kits (nome, componentes, valor, categoria, observacoes, imagem) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdsss", $nome, $componentes, $valor, $categoria, $observacoes, $imagem);

    if ($stmt->execute()) {
        echo "✅ Kit salvo com sucesso!";
    } else {
        echo "❌ Erro ao salvar kit: " . $stmt->error;
    }

    $stmt->close();
}
?>


