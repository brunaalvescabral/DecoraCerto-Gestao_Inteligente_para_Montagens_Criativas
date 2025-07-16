<?php
include_once __DIR__ . '/conexao.php';

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    die("ID inválido.");
}

// Busca o kit atual
$stmt = $conn->prepare("SELECT * FROM kits WHERE id = ?");
if (!$stmt) {
    die("Erro na preparação da consulta: " . $conn->error);
}
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$kit = $result->fetch_assoc();
if (!$kit) {
    die("Kit não encontrado.");
}
?>

<h2>Editar Kit</h2>

<!-- Formulário principal -->
<form action="atualizar_kit.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= htmlspecialchars($kit['id']) ?>">
    
    Nome: <input type="text" name="nome" value="<?= htmlspecialchars($kit['nome']) ?>" required><br><br>
    Valor: <input type="text" name="valor" value="<?= htmlspecialchars($kit['valor']) ?>" required><br><br>
    Categoria: <input type="text" name="categoria" value="<?= htmlspecialchars($kit['categoria']) ?>"><br><br>
    Componentes: <input type="text" name="componentes" value="<?= htmlspecialchars($kit['componentes']) ?>"><br><br>
    Observações: <textarea name="observacoes"><?= htmlspecialchars($kit['observacoes']) ?></textarea><br><br>
    
    Status:
    <select name="status">
        <option value="ativo" <?= $kit['status'] === 'ativo' ? 'selected' : '' ?>>Ativo</option>
        <option value="inativo" <?= $kit['status'] === 'inativo' ? 'selected' : '' ?>>Inativo</option>
    </select><br><br>

    <!-- Exibe imagem atual, se existir -->
    <?php if (!empty($kit['imagem'])): ?>
        <div>
            <img src="assets/imagens/<?= htmlspecialchars($kit['imagem']) ?>" alt="Imagem do kit" width="150"><br>
            <label>
                <input type="checkbox" name="excluir_imagem" value="1">
                Excluir imagem atual
            </label>
        </div><br>
    <?php else: ?>
        <p>Sem imagem cadastrada.</p>
    <?php endif; ?>

    <!-- Upload nova imagem -->
    Alterar/Inserir imagem: <input type="file" name="imagem"><br><br>

    <button type="submit">Salvar</button>
</form>

<a href="listar_kits.php">Voltar</a>
