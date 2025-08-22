<div class="container-fluid">
  <div class="d-flex align-items-center justify-content-between py-2">
    <!-- Conteúdo do header -->
    <div class="flex-grow-1">
      <nav class="header_navigation">
        <div class="navigation">
          <!-- Botão toggle sidebar mobile -->
          <button class="btn btn-outline-primary sidebar-toggle d-lg-none" type="button" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
          </button>
          <!-- Logo -->
          <a class="navbar-brand py-2 px-3" href="#">
            <img class="img-fluid" src="<?= include_asset('imagens/logo.png') ?>" alt="Logo" style="min-width:50px; height:50px;">
          </a>
          <!-- Barra de busca -->
          <div class="header_search">
            <input id="search-input" maxlength="800" autocorrect="off" autocapitalize="off" spellcheck="false"
              placeholder="O que você busca?" value="" />
            <img src="<?= include_asset('/icons/search.png') ?>" class="img-fluid rounded">
          </div>
        </div>
        <div class="header_login navigation">
            <button class="notificacao">
              <i class="bi bi-bell"></i>
            </button>
            <?php if(!isset($_SESSION['user'])):?>
              <button class="inscrever_BT subscribe">Inscreva-se</button>
              <button class="logar_BT login">Entrar</button>
            <?php endif;?>
        </div>
      </nav>
    </div>
  </div>
</div>