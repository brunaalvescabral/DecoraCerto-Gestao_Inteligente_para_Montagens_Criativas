<?php
$mysqli = new mysqli("localhost", "root", "", "sistema");
if ($mysqli->connect_errno) {
    die("Erro na conexão: " . $mysqli->connect_error);
}

// Buscar alugueis atendidos que ainda não foram inseridos na tabela receitas
$sql = "SELECT a.id, a.valor_total, a.data_aluguel 
        FROM alugueis a
        LEFT JOIN receitas r ON r.origem = 'aluguel' AND r.origem_id = a.id
        WHERE a.atendido = 1 AND r.id IS NULL";

$res = $mysqli->query($sql);

$inseridos = 0;
while ($row = $res->fetch_assoc()) {
    $id_aluguel = (int)$row['id'];
    $valor = (float)$row['valor_total'];
    $data_receita = $mysqli->real_escape_string($row['data_aluguel']);

    $sql_insert = "INSERT INTO receitas (origem, origem_id, valor, data_receita) 
                   VALUES ('aluguel', $id_aluguel, $valor, '$data_receita')";
    if ($mysqli->query($sql_insert)) {
        $inseridos++;
    }
}

echo "Sincronização finalizada. $inseridos registros inseridos.";
?>
