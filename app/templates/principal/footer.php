
    <!-- LOGO -->
    <!-- <div class="footer-logo-standalone">
      <img src="logo.png" alt="Logo GIMC" />
    </div> -->

    <div class="footer-container">
      <!-- COLUNA 1 -->
      <div class="footer-col">
        <h3 onclick="toggleSection(this)">
          <span class="text">DECORACERTO – GIMC</span> <i class="fa-solid fa-chevron-down toggle-icon"></i>
        </h3>
        <ul>
          <li>Quem Somos</li>
          <li>Nossa Localização</li>
          <li>Política de Privacidade</li>
          <li>Política de Segurança da Informação</li>
        </ul>
      </div>

      <!-- COLUNA 2 -->
      <div class="footer-col">
        <h3 onclick="toggleSection(this)">
          <span class="text">AJUDA E SUPORTE</span> <i class="fa-solid fa-chevron-down toggle-icon"></i>
        </h3>
        <ul>
          <li>Ajuda e Suporte</li>
          <li>Locação Segura</li>
          <li>Pagamento</li>
          <li>Entrega e Montagem</li>
          <li>Dúvidas Frequentes</li>
          <li>Cancelamento</li>
          <li>Fale Conosco</li>
        </ul>
      </div>

      <!-- COLUNA 3 -->
      <div class="footer-col">
        <h3 onclick="toggleSection(this)">
          <span class="text">CONTATO</span> <i class="fa-solid fa-chevron-down toggle-icon"></i>
        </h3>
        <ul>
          <li><i class="fas fa-phone"></i> (77) 99165-7243</li>
          <li><i class="fas fa-phone"></i> (77) 99886-2327</li>
          <li><i class="fas fa-envelope"></i> decoracerto@gmail.com</li>
        </ul>
        <div class="mobile-version">
          <i class="fas fa-mobile-alt"></i>
          <a href="#">Versão Mobile</a>
        </div>
      </div> 

      <!-- COLUNA 4 -->
      <div class="footer-col atendimento">
        <h3 onclick="toggleSection(this)">
          <span class="text">ATENDIMENTO<br>PARA LOCAÇÃO</span> <i class="fa-solid fa-chevron-down toggle-icon"></i>
        </h3>
        <ul>
          <li>Seg. à Sex. das 08h às 18h</li>
          <li>Sábados das 08h às 12h</li>
        </ul>
        <div class="social-icons">
          <a href="https://www.linkedin.com/" target="_blank"><i class="fab fa-linkedin-in"></i></a>
          <a href="https://www.instagram.com/" target="_blank"><i class="fab fa-instagram"></i></a>
          <a href="https://www.youtube.com/" target="_blank"><i class="fab fa-youtube"></i></a>
          <a href="https://www.facebook.com/" target="_blank"><i class="fab fa-facebook-f"></i></a>
          <a href="https://twitter.com/" target="_blank"><i class="fab fa-twitter"></i></a>
        </div>
      </div>

    </div>

    <hr class="full-line" />
    <div class="footer-bottom">
      &copy; 2025 DecoraCerto – GIMC. Todos os direitos reservados.
    </div>
  </footer>

  <script>
    function toggleSection(header) {
      const col = header.closest('.footer-col');
      col.classList.toggle('collapsed');
    }
  </script> 

