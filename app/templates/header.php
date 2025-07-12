<nav id="navbar" class="align-items-center navbar navbar-expand-lg navbar-dark bg-dark p-0 border-bottom">
  <div class="container-fluid align-items-center">
    <!-- Logo -->
    <a class="navbar-brand py-2 px-3" href="#">
      <img class="img-fluid" src="<?=include_asset('imagens/logo.png')?>" alt="Logo" style="height:50px;">
    </a>
    <!-- Busca -->
    <form class="form-inline flex-grow-1 mx-2 my-2 my-lg-0" style="max-width: 400px;">
      <div class="input-group position-relative">
        <input id="search" class="form-control w-75 pr-5" type="search" placeholder="O que você busca?" aria-label="Pesquisar">
        <button id="btn-search" class="btn position-absolute p-0 m-0 border-0 bg-transparent" type="submit">
          <img src="<?=include_asset('icons/magnifying-glass.png')?>" alt="Buscar">
        </button>
      </div>
    </form>
    <!-- Botões (lado direito) -->
    <div class="d-flex align-items-center ml-auto pr-3">
    <!-- Toggle Tema -->
      <button id="themeToggleBtn" class="btn p-0 m-0 border-0 bg-transparent" type="button" onclick="toggleDarkMode()" aria-label="Alternar tema">
        <img id="themeToggleIcon" src="<?=include_asset('icons/dark.png"')?>" alt="Ícone Tema" style="height: 24px; width: 24px;">
      </button>
      <!-- Botão Inscrever-se -->
      <a href="#" id="btn-register" class="btn text-secondary mr-2">Inscrever-se</a>
      <!-- Botão Login -->
      <a href="#" id="btn-login" class="btn btn-outline-light text-dark bg-white mr-2">Entrar</a>
    </div>
  </div>
</nav>
