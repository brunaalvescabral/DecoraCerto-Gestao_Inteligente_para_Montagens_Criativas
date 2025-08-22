<?php
include 'conexao.php';

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $produto_id = $_POST['produto_id'];
    $imagem = $_FILES['nova_imagem'];

    if ($imagem['error'] === UPLOAD_ERR_OK) {
        $extensao = pathinfo($imagem['name'], PATHINFO_EXTENSION);
        $nome_arquivo = uniqid() . '.' . $extensao;
        $caminho = "../assets/imagens/" . $nome_arquivo;

        if (move_uploaded_file($imagem['tmp_name'], $caminho)) {
            $stmt = $conn->prepare("UPDATE produtos_nota SET imagem = ? WHERE id = ?");
            $stmt->bind_param("si", $nome_arquivo, $produto_id);
            $stmt->execute();
            $stmt->close();
            echo "Imagem atualizada com sucesso. <a href='visualizar_estoque.php'>Voltar</a>";
        } else {
            echo "Erro ao salvar imagem.";
        }
    } else {
        echo "Erro no upload da imagem.";
    }

    $conn->close();
}
?>
