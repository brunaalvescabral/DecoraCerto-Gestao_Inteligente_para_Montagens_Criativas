// // --- Toggle Tema Dark / Light ---
// function toggleDarkMode() {
//   const body = document.body;
//   const icon = document.getElementById('themeToggleIcon');

//   // Alterna a classe dark-mode no body
//   const isDark = body.classList.toggle('dark-mode');

//   // Atualiza o ícone conforme o tema atual
//   icon.src = isDark
//     ? '../public/assets/icons/ligth.png'   // tema escuro → mostra sol (modo claro disponível)
//     : '../public/assets/icons/dark.png';   // tema claro → mostra lua (modo escuro disponível)

//   // Salva a preferência no localStorage
//   localStorage.setItem('theme', isDark ? 'dark' : 'light');
// }

// Aplica o tema salvo ao carregar a página
// function applySavedTheme() {
//   const savedTheme = localStorage.getItem('theme');
//   const icon = document.getElementById('themeToggleIcon');
//   if (savedTheme === 'dark') {
//     document.body.classList.add('dark-mode');
//     icon.src = '../public/assets/icons/ligth.png';
//   } else {
//     icon.src = '../public/assets/icons/dark.png';
//   }
// }