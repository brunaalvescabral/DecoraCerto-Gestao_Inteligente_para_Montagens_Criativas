<?php
// Incluir sistema de autenticação
// require_once __DIR__ . '/../backend/auth.php';

function include_CSSs() {
    $css_dir = '../public/css/';
    foreach (glob($css_dir.'*.css') as $css) {
        echo '<link rel="stylesheet" href="'.$css_dir.basename($css).'">' . PHP_EOL;
    }
}

function include_JSs() {
    $js_dir = '../public/js/';
    foreach (glob($js_dir.'*.js') as $js) {
        echo '<script type="module" src="'.$js_dir.basename($js).'" defer></script>'.PHP_EOL;
    }
}
function include_asset($asset_path) {
    $path = "../public/assets/{$asset_path}";
    if(file_exists($path)) return $path;
    return "";
}
function include_page($pasta = "", $nome_arquivo="") {
    $pasta = preg_replace('#^(\./|\.\./|/)+|/+$#', '', $pasta);
    $nome_arquivo = preg_replace('#^(\./|\.\./|/)+|/+$#', '', $nome_arquivo);
    $path = "./templates/".($pasta!==''?"/{$pasta}": '')."/{$nome_arquivo}.php";
    if(file_exists($path)) include $path;
} 
function include_backEnd($pasta = "", $nome_arquivo="") {
    $pasta = preg_replace('#^(\./|\.\./|/)+|/+$#', '', $pasta);
    $nome_arquivo = preg_replace('#^(\./|\.\./|/)+|/+$#', '', $nome_arquivo);
    $path = "./backend" .($pasta !== '' ? "/{$pasta}": '')."/{$nome_arquivo}.php";
    if(file_exists($path)) include $path;
    return @$result;
}
