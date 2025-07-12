// --- Toggle Tema Dark / Light ---
function toggleDarkMode() {
  const body = document.body;
  const icon = document.getElementById('themeToggleIcon');

  // Alterna a classe dark-mode no body
  const isDark = body.classList.toggle('dark-mode');

  // Atualiza o ícone conforme o tema atual
  icon.src = isDark
    ? '../public/assets/icons/ligth.png'   // tema escuro → mostra sol (modo claro disponível)
    : '../public/assets/icons/dark.png';   // tema claro → mostra lua (modo escuro disponível)

  // Salva a preferência no localStorage
  localStorage.setItem('theme', isDark ? 'dark' : 'light');
}

// Aplica o tema salvo ao carregar a página
function applySavedTheme() {
  const savedTheme = localStorage.getItem('theme');
  const icon = document.getElementById('themeToggleIcon');
  if (savedTheme === 'dark') {
    document.body.classList.add('dark-mode');
    icon.src = '../public/assets/icons/ligth.png';
  } else {
    icon.src = '../public/assets/icons/dark.png';
  }
}
// --- Ajusta padding-top do main para compensar altura do navbar ---
function ajustarPaddingMain() {
  const navbar = document.getElementById('navbar');
  const main = document.getElementById('main-content');
  if (navbar && main) {
    const alturaNavbar = navbar.offsetHeight;
    main.style.paddingTop = alturaNavbar + 'px';
  }
}
// --- Carrossel com scroll horizontal e botões ---
function initCarouselScroll(containerId, leftBtnId, rightBtnId) {
  const container = document.getElementById(containerId);
  const btnLeft = document.getElementById(leftBtnId);
  const btnRight = document.getElementById(rightBtnId);

  let velScroll = 30;
  let currentScroll = 0; // valor numérico da % de scroll
  const maxScroll = 2;    // limite à esquerda
  const minScroll = -48;  // limite à direita

  // Aplica posição inicial
  container.style.transform = `translateX(${currentScroll}%)`;

  // Acessibilidade nas setas
  document.querySelectorAll('.carousel-arrow').forEach(arrow => {
    arrow.setAttribute('aria-label', arrow.classList.contains('left-arrow') ? 'Slide anterior' : 'Próximo slide');
  });
  function updateToggles() {
    btnLeft?.classList.toggle('d-none', currentScroll >= maxScroll);
    btnRight?.classList.toggle('d-none', currentScroll <= minScroll);
  }
  updateToggles();
  btnLeft?.addEventListener('click', () => {
    currentScroll = Math.min(currentScroll + velScroll, maxScroll);
    container.style.transform = `translateX(${currentScroll}%)`;
    updateToggles();
  });
  btnRight?.addEventListener('click', () => {
    currentScroll = Math.max(currentScroll - velScroll, minScroll);
    container.style.transform = `translateX(${currentScroll}%)`;
    updateToggles();
  });
}

// --- Inicializações ao carregar a página ---
window.addEventListener('DOMContentLoaded', () => {
  applySavedTheme();
  ajustarPaddingMain();
  initCarouselScroll('carousel-container', 'carousel-left', 'carousel-right');
});
window.addEventListener('resize', ajustarPaddingMain);

