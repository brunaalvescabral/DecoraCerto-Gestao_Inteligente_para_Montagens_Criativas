<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Novo Kit</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            padding-top: 40px;
        }

        .container {
            background: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            width: 500px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        form input[type="text"],
        form textarea,
        form input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        form textarea {
            resize: vertical;
            height: 100px;
        }

        .buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn {
            padding: 10px 20px;
            background-color: #1976d2;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
            transition: background 0.3s ease;
        }

        .btn:hover {
            background-color: #125ca1;
        }

        .btn-secondary {
            background-color: #777;
        }

        .btn-secondary:hover {
            background-color: #555;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Adicionar Novo Kit</h2>
    <form action="salvar_kit.php" method="post" enctype="multipart/form-data">
        <label for="nome">Nome</label>
        <input type="text" name="nome" id="nome" required>

        <label for="valor">Valor</label>
        <input type="text" name="valor" id="valor" required>

        <label for="categoria">Categoria</label>
        <input type="text" name="categoria" id="categoria">

        <label for="componentes">Componentes (separados por vírgula)</label>
        <input type="text" name="componentes" id="componentes">

        <label for="observacoes">Observações</label>
        <textarea name="observacoes" id="observacoes"></textarea>

        <label for="imagem">Imagem</label>
        <input type="file" name="imagem" id="imagem">

        <div class="buttons">
            <button type="submit" class="btn">Salvar Kit</button>
            <a href="dashboard_catalogo_gerente.php" class="btn btn-secondary">Voltar</a>
        </div>
    </form>
</div>

</body>
</html>
