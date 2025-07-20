<?php
require 'conexao.php';

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $data_nascimento = $_POST['data_nascimento'];
    $contato = trim($_POST['contato']);
    $endereco = trim($_POST['endereco']);
    $login = trim($_POST['login']);
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE clientes 
        SET nome = ?, email = ?, data_nascimento = ?, contato = ?, endereco = ?, login = ?, status = ?
        WHERE id = ?");

    $stmt->bind_param("sssssssi", $nome, $email, $data_nascimento, $contato, $endereco, $login, $status, $id);
    $stmt->execute();


    header("Location: dashboard_cadastro_cliente.php");
    exit;
}
