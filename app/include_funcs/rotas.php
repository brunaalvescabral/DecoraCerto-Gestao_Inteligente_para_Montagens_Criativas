<?php 
require_once('./backend/db/conexao.php');
$rota_padrao = 'home'; // rota padrão
function load_templates() {
    global $rotas;
    global$rota_padrao;

    // 1. Pega a rota da URL, se existir e não vazia
    $rota_url = isset($_GET['page']) && !empty($_GET['page']) ? $_GET['page'] : null;

    // 2. Verifica se a rota da URL é válida (existe no array $rotas)
    if ($rota_url && array_key_exists($rota_url, $rotas)) {
        $rota = $rota_url;
        // Atualiza a rota na sessão para lembrar essa rota
        $_SESSION['ultima_rota'] = $rota;
    } 
    else if (isset($_SESSION['ultima_rota']) && array_key_exists($_SESSION['ultima_rota'], $rotas)) {
        // Se não veio rota na URL ou inválida, usa a última rota válida da sessão
        $rota = $_SESSION['ultima_rota'];
    } 
    else {
        // Senão, usa a rota padrão
        $rota = $rota_padrao;
        $_SESSION['ultima_rota'] = $rota;
    }
    // Se houver parâmetro id, copia para $_REQUEST['id']
    if (isset($_GET['id'])) {
        $_REQUEST['id'] = $_GET['id'];
    }
    // Carrega templates da rota
    if (isset($rotas[$rota]) && is_array($rotas[$rota])) {
        foreach ($rotas[$rota] as $tpl) {
            [$pasta, $arquivo] = pode_acessar_template($tpl, $_SESSION['user']['nivel']??null);
            if (!empty($pasta) && !empty($arquivo)) {
                include_page($pasta, $arquivo);
            }
        }
    } else {
        include_page("principal","acesso_negado");
    }
    return $rota;
}


/**
 * Gera URL para uma rota específica
 * @param string $rota Nome do template
 * @param array $params Parâmetros adicionais
 * @return string URL formatada
 */
function get_route($pagina, $parametro = []){
    global $rotas;
    $url = "?page=" . $pagina;
    // Verifica se a rota existe
    if (!empty($parametro)) {
        foreach ($parametro as $key => $value) {
            $url .= "&" . urlencode($key) . "=" . urlencode($value);
        }
    }
    return $url;
}
/**
 * Retorna o título da página atual
 * @return string Título da página
 */
function get_page_title(){
    global $rotas;
    $pagina = $_GET["page"] ?? 'cadastro';
    return isset($rotas[$pagina])
        ? $rotas[$pagina]['title']
        : 'DecoraCerto - GIMC';
}
/**
 * Verifica se uma rota tem templates adicionais
 * @param string $pagina Nome do template
 * @return bool
 */
function has_additional_templates($pagina)
{
    global $rotas;
    return isset($rotas[$pagina]) && count($rotas[$pagina]['page']) > 1;
}
/**
 * Retorna os templates adicionais de uma rota
 * @param string $pagina Nome do template
 * @return array
 */
function get_additional_templates($pagina){
    global $rotas;
    if (isset($rotas[$pagina])) {
        // Retorna todos os templates exceto o primeiro
        return array_slice($rotas[$pagina]['page'], 1);
    }
    return [];
}
