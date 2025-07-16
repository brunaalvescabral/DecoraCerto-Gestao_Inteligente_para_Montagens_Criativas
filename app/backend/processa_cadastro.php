<?php
require 'conexao.php';

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $cpf = trim($_POST['cpf']);
    $email = trim($_POST['email']);
    $data_nascimento = $_POST['data_nascimento'];
    $contato = trim($_POST['contato']);
    $endereco = trim($_POST['endereco']);
    $login = trim($_POST['login']);
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $status = $_POST['status'] ?? 'ativo';

    if (strlen($cpf) !== 11 || !ctype_digit($cpf)) {
        die("CPF inválido. Deve conter 11 dígitos numéricos.");
    }

    $stmt = $pdo->prepare("SELECT id FROM clientes WHERE cpf = ?");
    $stmt->execute([$cpf]);

    if ($stmt->rowCount() > 0) {
        die("Erro: Já existe um cliente com esse CPF.");
    }

    $stmt = $pdo->prepare("INSERT INTO clientes 
        (nome, cpf, email, data_nascimento, contato, endereco, login, senha, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->execute([$nome, $cpf, $email, $data_nascimento, $contato, $endereco, $login, $senha, $status]);

    header("Location: index.php");
    exit;
}

