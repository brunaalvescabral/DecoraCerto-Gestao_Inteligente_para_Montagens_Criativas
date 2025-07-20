<?php
header('Content-Type: application/json');

// Conexão com banco de dados
$pdo = new PDO('mysql:host=localhost;dbname=sistema', 'root', '');

// Função auxiliar para montar os filtros
function montarFiltro($coluna, $inicio, $fim) {
    $filtro = "";
    if (!empty($inicio)) $filtro .= " AND $coluna >= '$inicio'";
    if (!empty($fim)) $filtro .= " AND $coluna <= '$fim'";
    return $filtro;
}

// Captura os filtros
$data_registro_inicio = $_GET['data_registro_inicio'] ?? '';
$data_registro_fim = $_GET['data_registro_fim'] ?? '';
$data_vencimento_inicio = $_GET['data_vencimento_inicio'] ?? '';
$data_vencimento_fim = $_GET['data_vencimento_fim'] ?? '';
$status = $_GET['status'] ?? '';

// Monta o filtro WHERE
$filtros = " WHERE 1=1 ";
$filtros .= montarFiltro("data_registro", $data_registro_inicio, $data_registro_fim);
$filtros .= montarFiltro("data_vencimento", $data_vencimento_inicio, $data_vencimento_fim);
if (!empty($status)) {
    $filtros .= " AND status = '$status'";
}

// Inicializa os meses e valores zerados
$meses = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];

$categorias = [
    "Fixo" => array_fill(0, 12, 0),
    "Variável" => array_fill(0, 12, 0),
];
$subcategorias = [
    "Despesas Administrativas" => array_fill(0, 12, 0),
    "Despesas Operacionais" => array_fill(0, 12, 0),
];

// Consulta as contas
$query = $pdo->query("SELECT valor, categoria, subcategoria, MONTH(data_registro) as mes FROM contas_pagar $filtros");

while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    $mes = intval($row['mes']) - 1; // de 1-12 para 0-11

    $valor = floatval($row['valor']);
    $cat = $row['categoria'];
    $sub = $row['subcategoria'];

    if (isset($categorias[$cat])) {
        $categorias[$cat][$mes] += $valor;
    }
    if (isset($subcategorias[$sub])) {
        $subcategorias[$sub][$mes] += $valor;
    }
}

echo json_encode([
    "meses" => $meses,
    "categorias" => $categorias,
    "subcategorias" => $subcategorias
]);
