import { navegarPara } from "./scripts_auxiliares/request.js";
window.addEventListener('DOMContentLoaded', () => {
  ajustarPaddingMain();
  navegarPara('home');
  Opcao_expansiva_de_sidebar();
});
window.addEventListener('resize', ajustarPaddingMain);
// --- Ajusta padding-top do main para compensar altura do navbar ---
function ajustarPaddingMain() {
  const navbar = document.getElementById('grid-header');
  const main = document.getElementById('grid-main');
  if (navbar && main) {
    const alturaNavbar = navbar.offsetHeight;
    main.style.paddingTop = (alturaNavbar + 20) + 'px';
  }
}
// ========================================================================================================
// Função para toggle da sidebar mobile
function toggleSidebar() {
  const sidebar = document.getElementById('sidebarMobile');
  sidebar.classList.toggle('show');
}
// Função para fechar sidebar mobile
function closeSidebar() {
  const sidebar = document.getElementById('sidebarMobile');
  sidebar.classList.remove('show');
}
// Navegação ativa na sidebar
function manipularSidebar() {
  const navLinks = document.querySelectorAll('.sidebar-nav .nav-link');
  navLinks.forEach(link => {
    link.addEventListener('click', function (e) {
      navLinks.forEach(l => l.classList.remove('active'));
      this.classList.add('active');
    });
  });
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        target.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }
    });
  });
}
// Fechar sidebar ao redimensionar para desktop
window.addEventListener('resize', function () {
  if (window.innerWidth >= 992) {
    closeSidebar();
  }
});
// =============================================================================================================
// opção de menu expansivo verticalmente
function Opcao_expansiva_de_sidebar() {
  const menuItems = document.querySelectorAll('.menu-item.has-submenu');
  menuItems.forEach(item => {
    item.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      const menuType = this.getAttribute('data-menu');
      const submenu = document.getElementById(`submenu-${menuType}`);
      const isExpanded = this.classList.contains('expanded');
      // Fecha todos os outros submenus
      menuItems.forEach(otherItem => {
        if (otherItem !== this) {
          otherItem.classList.remove('expanded', 'active');
          const otherMenuType = otherItem.getAttribute('data-menu');
          const otherSubmenu = document.getElementById(`submenu-${otherMenuType}`);
          if (otherSubmenu) {
            otherSubmenu.classList.remove('expanded');
          }
        }
      });
      // Toggle do submenu atual
      if (isExpanded) {
        this.classList.remove('expanded', 'active');
        submenu.classList.remove('expanded');
      } else {
        this.classList.add('expanded', 'active');
        submenu.classList.add('expanded');
      }
    });
  });
  // Efeito de hover nos itens do menu
  document.querySelectorAll('.menu-item:not(.has-submenu)').forEach(item => {
    item.addEventListener('mouseenter', function () {
      const icon = this.querySelector('.bi:first-child');
      if (icon) {
        icon.style.transform = 'scale(1.1)';
        icon.style.color = '#667eea';
      }
    });
    item.addEventListener('mouseleave', function () {
      const icon = this.querySelector('.bi:first-child');
      if (icon) {
        icon.style.transform = 'scale(1)';
        icon.style.color = '';
      }
    });
  });
  // Efeito de hover nos itens do submenu
  document.querySelectorAll('.submenu-item').forEach(item => {
    item.addEventListener('mouseenter', function () {
      const icon = this.querySelector('.bi');
      if (icon) {
        icon.style.transform = 'scale(1.1)';
      }
    });
    item.addEventListener('mouseleave', function () {
      const icon = this.querySelector('.bi');
      if (icon) {
        icon.style.transform = 'scale(1)';
      }
    });
  });
}