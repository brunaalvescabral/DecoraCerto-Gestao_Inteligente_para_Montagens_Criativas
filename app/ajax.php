<?php
session_start();
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");
header('Content-Type: application/json; charset=UTF-8');
header("Access-Control-Allow-Origin: https://localhost/DecoraCerto-Gestao_vf/app/");

require_once('../config.php');
require('../array_de_rotas.php');
require('./include_funcs/includes.php');
require("./include_funcs/restricoes.php");
include('./include_funcs/rotas.php');

function Api0(){
    $conn = Abrir_conexao();
    ob_start();
    if (empty($_GET)) {
        $_GET['page'] = 'home';
    }

    $postData = $_POST;
    $saida = [];

    if (isset($_GET['page'])) {
        $rota_final = load_templates();
        $saida = [
            'html' => ob_get_clean(),
            'url'  => '?page=' . urlencode($rota_final)
        ];
        Fechar_conexão($conn);
        return $saida;
    }

    if (isset($_GET['card'])) {
        include_backEnd("home", "carousel");
        $saida = [ getCardById($_GET['card'] + 1), 'post' => $postData ];
        Fechar_conexão($conn);
        ob_end_clean();
        return $saida;
    }
    if (isset($_GET['auth'])) {
        if ($_GET['auth'] === 'cadastro') {
            include_backEnd("autenticacao", "cadastro");
            $dados = cadastrarUsuario($conn, $postData);
            unset($postData['senha'],$postData['confirm_senha']);
            $dados['datas'] = $postData;
        }
        if ($_GET['auth'] === 'login') {
            include_backEnd("autenticacao", "login");
            $dados = autenticarUsuario($conn, $postData);
        }
        Fechar_conexão($conn);
        ob_end_clean();
        return $dados;
    }
    Fechar_conexão($conn);
    ob_end_clean();
    return ['post' => $postData];
}

$result = Api0();
if (!is_array($result) && !is_object($result)) {
    $result = ['datas' => $result];
}
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);








