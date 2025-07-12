<?php
function include_CSSs() {
    $css_dir = '../public/css/';
    foreach (glob($css_dir . '*.css') as $css) {
        echo '<link rel="stylesheet" href="'.$css_dir.basename($css).'">' . PHP_EOL;
    }
}
function include_JSs() {
    $js_dir = '../public/js/';
    foreach (glob($js_dir . '*.js') as $js) {
        echo '<script src="'.$js_dir.basename($js).'"></script>'.PHP_EOL;
    }
}
function include_asset($asset_path) {
    $path = "../public/assets/{$asset_path}";
    if(file_exists($path))return $path;
    return "";
}
function include_page($file_page) {
    $path = "./templates/{$file_page}.php";
    file_exists($path)?include $path :"";
}
