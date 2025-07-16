<?php

require_once __DIR__ . '/conexao.php';

if (!$conn) {
    die("Erro: conexão com o banco não estabelecida.");
}
if (!isset($_SERVER['REQUEST_METHOD'])) {
    die("REQUEST_METHOD não definido.");
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Requisição inválida: método recebido foi " . $_SERVER['REQUEST_METHOD']);
}

// Captura e valida dados do formulário
$id = $_POST['id'] ?? null;
$nome = $_POST['nome'] ?? null;
$valor = $_POST['valor'] ?? null;
$categoria = $_POST['categoria'] ?? null;
$componentes = $_POST['componentes'] ?? null;
$observacoes = $_POST['observacoes'] ?? null;
$status = $_POST['status'] ?? null;

if (!$id || !$nome || !$valor) {
    die("Campos obrigatórios não preenchidos.");
}

// Primeiro, buscar o nome da imagem atual para exclusão se necessário
$stmt_img = $conn->prepare("SELECT imagem FROM kits WHERE id = ?");
$stmt_img->bind_param("i", $id);
$stmt_img->execute();
$result_img = $stmt_img->get_result();
$kit_atual = $result_img->fetch_assoc();
$stmt_img->close();

$imagem_atual = $kit_atual['imagem'] ?? null;

// Verificar se usuário marcou para excluir imagem
$excluir_imagem = isset($_POST['excluir_imagem']) && $_POST['excluir_imagem'] == '1';

// Pasta onde as imagens ficam salvas
$pasta_imagens = __DIR__ . '/assets/imagens/';

$nova_imagem = null;

// Se excluir imagem marcada, remove o arquivo físico e prepara para atualizar o campo no banco
if ($excluir_imagem && $imagem_atual) {
    $caminho_imagem = $pasta_imagens . $imagem_atual;
    if (file_exists($caminho_imagem)) {
        unlink($caminho_imagem);
    }
    $imagem_atual = null; // vamos zerar o campo imagem
}

// Se enviou nova imagem via upload
if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
    // Se existir imagem atual e não foi marcada para excluir, apagar ela pois será substituída
    if ($imagem_atual) {
        $caminho_imagem = $pasta_imagens . $imagem_atual;
        if (file_exists($caminho_imagem)) {
            unlink($caminho_imagem);
        }
    }

    // Processar novo upload
    $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
    $nome_arquivo = uniqid('img_', true) . '.' . $extensao;
    $destino = $pasta_imagens . $nome_arquivo;

    if (!is_dir($pasta_imagens)) {
        mkdir($pasta_imagens, 0777, true);
    }

    if (move_uploaded_file($_FILES['imagem']['tmp_name'], $destino)) {
        $nova_imagem = $nome_arquivo;
    } else {
        die("Erro ao salvar a imagem.");
    }
}

// Definir qual valor será salvo no campo imagem no banco
// Se excluiu, salva NULL; se enviou nova imagem, salva ela; senão mantém a atual
$imagem_para_salvar = $nova_imagem ?? $imagem_atual;

// Preparar update incluindo o campo imagem
$stmt = $conn->prepare("UPDATE kits SET nome = ?, valor = ?, categoria = ?, componentes = ?, observacoes = ?, status = ?, imagem = ? WHERE id = ?");
if (!$stmt) {
    die("Erro na preparação da consulta: " . $conn->error);
}

// 's' string, 'd' double, 'i' int
$stmt->bind_param("sdsssssi", $nome, $valor, $categoria, $componentes, $observacoes, $status, $imagem_para_salvar, $id);

if ($stmt->execute()) {
    header("Location: listar_kits.php");
    exit;
} else {
    die("Erro ao atualizar o kit: " . $stmt->error);
}
