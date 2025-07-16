<h2>Adicionar Novo Kit</h2>
<form action="salvar_kit.php" method="post" enctype="multipart/form-data">
    Nome: <input type="text" name="nome" required><br><br>
    Valor: <input type="text" name="valor" required><br><br>
    Categoria: <input type="text" name="categoria"><br><br>
    Componentes (separados por vírgula): <input type="text" name="componentes"><br><br>
    Observações: <textarea name="observacoes"></textarea><br><br>
    Imagem: <input type="file" name="imagem"><br><br>
    <input type="submit" value="Salvar Kit">
</form>
<a href="listar_kits.php">Voltar</a>
