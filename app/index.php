<?php
session_start();
require_once('../config.php');
require('../array_de_rotas.php');
require('./include_funcs/includes.php');
require("./include_funcs/restricoes.php");
include('./include_funcs/rotas.php');

$conn = Abrir_conexao();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="src/imagens/favicon.png" type="image/x-icon" />
    <!-- links externos de frameworks (bootstrap e google-fonts) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Raleway:wght@600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

    <!-- Bootstrap Core CSS -->
    <?= include_CSSs() ?>
    <title>DecoraCerto - GIMC</title>
</head>

<body>
    <!-- Container Grid Principal -->
    <main class="grid-container">
        <!-- Header -->
        <header id="grid-header" class="grid-header">
            <?= include_page("principal", "header") ?>
        </header>
        <!-- Container principal com sidebar e conteúdo em 2 colunas -->
        <div id="grid-main" class="grid-main">
            <!-- Sidebar Desktop -->
            <div class="grid-sidebar d-none d-lg-block">
                <?= include_page("principal", "sidebar") ?>
            </div>
            <!-- Conteúdo Principal -->
            <div id="conteudo-principal" class=" grid-content">
                <!-- conteudo -->
            </div>
        </div>
        <!--sidebar Mobile-->
        <div class="sidebar-mobile d-lg-none" id="sidebarMobile">
            <?= include_page("principal", "sidebar") ?>
        </div>
        </div>
        <!-- Footer -->
        <footer class="grid-footer">
            <?= include_page("principal", "footer") ?>
        </footer>
    </main>
</body>
<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
<?= include_JSs() ?>
<script src="https://cdn.tailwindcss.com"></script>

</html>