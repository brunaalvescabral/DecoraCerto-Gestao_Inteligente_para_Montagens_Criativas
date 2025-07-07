<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php
    include("./includes/head.php");
    ?>
</head>
<body>
    <div id="container_main">
        <header>
            <?php
            include("./includes/header.php");
            // include('../includes/conn.php');
            // session_start();
            ?>
        </header>
        <main>
            <?php
            include("./includes/table.php");
            // include("./includes/routes.php");
            ?>
        </main>
        <footer>
            <?php include("./includes/footer.php"); ?>
        </footer>
    </div>
</body>
    <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
    <script>
        new window.VLibras.Widget('https://vlibras.gov.br/app');
    </script>
</html>