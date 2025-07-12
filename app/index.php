<?php include 'include_funcs/includes.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?= include_CSSs() ?>
  <title>DecoraCerto - GIMC</title>
</head>
<body class="d-flex flex-column min-vh-100">
  <!-- Container principal como flex-column -->
  <div class="container-sm d-flex flex-column flex-grow-1">
    <!-- Header fixo no topo (já incluso pelo include_page) -->
    <header class="fixed-top flex-wrap bg-transparent justify-content-center m-0 p-0">
      <?= include_page("header") ?>
    </header>
    <!-- Main cresce para ocupar espaço -->
    <main id="main-content" class="container-fluid flex-grow-1">
      <!-- Conteúdo da página -->
      <?= include_page("carousel") ?>
      <?= include_page("main-cards") ?>
    </main>
    <!-- Footer no fim -->
    <footer class="mt-auto">
      <?= include_page("footer") ?>
    </footer>
  </div>
  <?= include_JSs() ?>
</body>
</html>
