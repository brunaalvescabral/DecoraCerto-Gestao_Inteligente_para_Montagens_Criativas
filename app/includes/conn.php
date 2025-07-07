<?php

$host = "<host>"; //Endereço da máquina onde o servidor de bd está localizado
$usuario = "<user>"; //nome de usuário do sgbd
$senha = "<password>"; //senha de acesso ao sgbd
$db = "<nome_Db>"; //nome do banco de dados

$mysqli = new mysqli($host, $usuario, $senha, $db);

if ($mysqli->connect_errno) {
	die("Não foi possivel conectar");
} //else{//pode descomentar se quiser checar se está conectando corretamente
//     echo "Conectado com sucesso!";
//  }

?>


