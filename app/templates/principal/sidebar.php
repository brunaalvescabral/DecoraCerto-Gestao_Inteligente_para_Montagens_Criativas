<div class="user-sidebar">
    <div class="user-photo">
        <img class="img-fluid" src="<?= include_asset('imagens/logo.png') ?>" alt="Logo" style="height:50px;">
    </div>
    <div class="user-info">
        <div class="profile-name"><?=$_SESSION['user']['nome']??"Bem Vindo Ao DecoraCerto"?></div>
        <div class="profile-phone"><?=$_SESSION['user']['contato']??""?></div>
    </div>
</div>
<div class="sidebar-title">
    <h5 class="mb-0">
        <i class="fas fa-home me-2"></i>
        Menu Principal
    </h5>
    <hr class="separator1">
</div>
<nav>
    <ul class="sidebar-nav">
        <?php
        // $users_types = ["admin", "gerente", "atendente","cliente"];
        $loged = isset($_SESSION['user']);
        $user_type = $_SESSION['user']['nivel']??"";
        ?>
        <?php if (!$loged || ($loged && $user_type == "cliente")): ?>
            <li class="nav-item">
                <div class="menu-item has-submenu" data-menu="inicio">
                    <i class="fas fa-home"></i>
                    <span class="menu-text">Inicio</span>
                    <i class="bi bi-chevron-right arrow-icon"></i>
                </div>
                <div class="submenu" id="submenu-inicio">
                    <div class="submenu-item">
                        <i class="fas fa-lightbulb"></i>
                        <span>Inspirações</span>
                    </div>
                    <div class="submenu-item">
                        <i class="fas fa-tools"></i>
                        <span>Funcionalidades</span>
                    </div>
                    <div class="submenu-item">
                        <i class="fas fa-book"></i>
                        <span>Cátalogos</span>
                    </div>
                    <div class="submenu-item">
                        <i class="fas fa-gift"></i>
                        <span>Benefícios</span>
                    </div>
                </div>
            </li>
        <?php endif ?>

        <?php if ($loged): ?>
            <div class="menu-item has-submenu" data-menu="profile">
                <i class="bi bi-person-circle"></i>
                <span class="menu-text">Meu Perfil</span>
                <i class="bi bi-chevron-right arrow-icon"></i>
            </div>
            <div class="submenu" id="submenu-profile">
                <div class="submenu-item">
                    <i class="bi bi-person-lines-fill"></i>
                    <span>Informações Pessoais</span>
                </div>
                <div class="submenu-item">
                    <i class="bi bi-shield-lock"></i>
                    <span>Privacidade</span>
                </div>
            </div>
            </li>
        <?php endif ?>

        <?php if ($loged && $user_type == 'gerente' || $user_type == 'financeiro' || $user_type == 'atendente'): ?>
            <li class="nav-item">
                <div class="menu-item has-submenu" data-menu="dashboard">
                    <i class="fas fa-chart-line"></i>
                    <span class="menu-text">Dashboard</span>
                </div>
            </li>
        <?php endif ?>

        <?php if ($loged && $user_type == 'gerente' || $user_type == 'atendente'): ?>
            <li class="nav-item">
                <div class="menu-item has-submenu" data-menu="locacao">
                    <i class="fas fa-key"></i>
                    <span class="menu-text">Locação</span>
                </div>
            </li>
        <?php endif ?>

        <?php if ($user_type == 'atendente'): ?>
            <!-- <li class="nav-item">
            <div class="menu-item has-submenu" data-menu="termo-de-compromisso">
                <i class="fas fa-file-signature"></i>
                <span class="menu-text">Termo</span>
            </div>
            <div class="submenu" id="submenu-termo-de-compromisso">
                <div class="submenu-item">
                    <i class="fas fa-file-contract"></i>
                    <span>Termo de Responsabilidade</span>
                </div>
        </li> -->
        <?php endif ?>

        <?php if ($user_type == 'atendente'): //condição se logado, e quais usuários têm acesso a opção ?>
            <li class="nav-item">
                <div class="menu-item has-submenu" data-menu="usuarios">
                    <i class="fas fa-users"></i>
                    <span class="menu-text">Usuarios</span>
                    <i class="bi bi-chevron-right arrow-icon"></i>
                </div>
                <div class="submenu" id="submenu-usuarios">
                    <div class="submenu-item">
                        <i class="fas fa-user-tie"></i>
                        <span>Listar Funcionários</span>
                    </div>
                    <div class="submenu-item">
                        <i class="fas fa-users"></i>
                        <span>Listar Clientes</span>
                    </div>
                </div>
            </li>
        <?php endif ?>

        <!-- <?php if ($user_type == 'cliente'): ?>
                <li class="nav-item">
                    <div class="menu-item has-submenu" data-menu="catalogo">
                        <i class="fas fa-box-open"></i>
                        <span class="menu-text">Cátalogo</span>
                    </div>
                </li>
            <?php endif ?> -->
        <li class="nav-item">
            <div class="menu-item has-submenu" data-menu="contato">
                <i class="fas fa-phone-alt"></i>
                <span class="menu-text">Contato</span>
            </div>
        </li>
        <?php if ($loged && $user_type == 'financeiro'): ?>
            <li class="nav-item">
                <div class="menu-item has-submenu" data-menu="notas-fiscais">
                    <i class="fas fa-file-invoice-dollar"></i>
                    <span class="menu-text">Notas Fiscais</span>
                    <i class="bi bi-chevron-right arrow-icon"></i>
                </div>
                <div class="submenu" id="submenu-notas-fiscais">
                    <div class="submenu-item">
                        <i class="fas fa-plus-circle"></i>
                        <span>Cadastrar</span>
                    </div>
                    <div class="submenu-item">
                        <i class="fas fa-list"></i>
                        <span>Listar</span>
                    </div>
            </li>
        <?php endif ?>

        <?php if ($user_type == 'atendente'): ?>
            <!-- <hr class="separator1">
            <div class="linha-divisoria"><br> -->
            <!-- Coloque aqui uma linha para fazer a divisão  -->
            <!-- </div>
                <li class="nav-item">Relatórios
            <div class="menu-item has-submenu" data-menu="relatorios-financeiros">
                <i class="fas fa-chart-pie"></i>
                <span class="menu-text">Relatório de Venda</span>
                <i class="bi bi-chevron-right arrow-icon"></i>
            </div>
            <div class="menu-item has-submenu" data-menu="relatorios-financeiros">
                <i class="fas fa-boxes"></i>
                <span class="menu-text">Relatório de Produtos</span>
                <i class="bi bi-chevron-right arrow-icon"></i>
            </div>
            <div class="menu-item has-submenu" data-menu="relatorios-financeiros">
                <i class="fas fa-user-friends"></i>
                <span class="menu-text">Relatório de Clientes</span>
                <i class="bi bi-chevron-right arrow-icon"></i>
            </div>
            <div class="menu-item has-submenu" data-menu="relatorios-financeiros">
                <i class="fas fa-warehouse"></i>
                <span class="menu-text">Relatório de Estoque</span>
                <i class="bi bi-chevron-right arrow-icon"></i>
            </div>
        </li> -->
        <?php endif ?>
        <li class="nav-item">
            <div class="menu-item has-submenu" data-menu="configuracoes">
                <i class="fas fa-cog"></i>
                <span class="menu-text">Configurações</span>
                <i class="bi bi-chevron-right arrow-icon"></i>
            </div>
            <div class="submenu" id="submenu-configuracoes">
                <div class="submenu-item">
                    <i class="fas fa-palette"></i>
                    <span>Aparência</span>
                </div>
                <?php if ($loged): //condição se logado, e quais usuários têm acesso a opção 
                ?>
                    <div class="submenu-item">
                        <i class="fas fa-lock"></i>
                        <span>Privacidade e Segurança</span>
                    </div>
                <?php endif ?>
                <div class="submenu-item">
                    <i class="fas fa-language"></i>
                    <span>Idioma</span>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <div class="menu-item has-submenu" data-menu="duvidas_frequentes">
                <i class="fas fa-question-circle"></i>
                <span class="menu-text">Dúvidas</span>
                <i class="bi bi-chevron-right arrow-icon"></i>
            </div>
            <div class="submenu" id="submenu-duvidas_frequentes">
                <div class="submenu-item">
                    <i class="fas fa-question"></i>
                    <span>Frequentes</span>
                </div>
                <div class="submenu-item">
                    <i class="fas fa-comments"></i>
                    <span>Tirar Dúvidas</span>
                </div>
                <div class="submenu-item">
                    <i class="fas fa-info-circle"></i>
                    <span>Sobre</span>
                </div>
            </div>
        </li>

        <?php if ($loged): ?>
            <li class="nav-item">
                <div class="menu-item has-submenu" data-menu="logout">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="menu-text">Logout</span>
                </div>
            </li>
        <?php endif ?>
    </ul>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Toggle do tema
    // const themeToggle = document.getElementById('themeToggle');
    // const themeIcon = document.getElementById('themeIcon');
    // const body = document.body;
    // const sidebar = document.querySelector('.sidebar') || document.body; // Fallback caso não tenha .sidebar

    // let isDark = false;

    // themeToggle.addEventListener('click', (e) => {
    //     e.stopPropagation();

    //     isDark = !isDark;

    //     // Adiciona rotação ao ícone
    //     themeIcon.classList.add('rotating');

    //     setTimeout(() => {
    //         if (isDark) {
    //             body.classList.add('dark');
    //             if (sidebar !== body) sidebar.classList.add('dark');
    //             themeIcon.className = 'theme-icon sun-icon';
    //             themeIcon.innerHTML = `
    //                 <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
    //                   <circle cx="12" cy="12" r="5" fill="white"/>
    //                   <line x1="12" y1="1" x2="12" y2="3" stroke="white" stroke-width="2" stroke-linecap="round"/>
    //                   <line x1="12" y1="21" x2="12" y2="23" stroke="white" stroke-width="2" stroke-linecap="round"/>
    //                   <line x1="4.22" y1="4.22" x2="5.64" y2="5.64" stroke="white" stroke-width="2" stroke-linecap="round"/>
    //                   <line x1="18.36" y1="18.36" x2="19.78" y2="19.78" stroke="white" stroke-width="2" stroke-linecap="round"/>
    //                   <line x1="1" y1="12" x2="3" y2="12" stroke="white" stroke-width="2" stroke-linecap="round"/>
    //                   <line x1="21" y1="12" x2="23" y2="12" stroke="white" stroke-width="2" stroke-linecap="round"/>
    //                   <line x1="4.22" y1="19.78" x2="5.64" y2="18.36" stroke="white" stroke-width="2" stroke-linecap="round"/>
    //                   <line x1="18.36" y1="5.64" x2="19.78" y2="4.22" stroke="white" stroke-width="2" stroke-linecap="round"/>
    //                 </svg>
    //             `;
    //         } else {
    //             body.classList.remove('dark');
    //             if (sidebar !== body) sidebar.classList.remove('dark');
    //             themeIcon.className = 'theme-icon moon-icon';
    //             themeIcon.innerHTML = `
    //                 <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
    //                   <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" fill="white"/>
    //                   <circle cx="18" cy="6" r="1" fill="white"/>
    //                   <circle cx="16" cy="4" r="0.5" fill="white"/>
    //                   <circle cx="19" cy="8" r="0.5" fill="white"/>
    //                 </svg>
    //             `;
    //         }

    //         setTimeout(() => {
    //             themeIcon.classList.remove('rotating');
    //         }, 100);
    //     }, 250);
    // });

    // Upload de imagem do perfil
    // const imageInput = document.getElementById('imageInput');
    // const profileDisplay = document.getElementById('profileDisplay');

    // imageInput.addEventListener('change', function (e) {
    //     const file = e.target.files[0];
    //     if (file) {
    //         const reader = new FileReader();
    //         reader.onload = function (e) {
    //             profileDisplay.innerHTML = `<img src="${e.target.result}" alt="Profile Image">`;
    //         };
    //         reader.readAsDataURL(file);
    //     }
    // });
    // Funcionalidade das sub-abas
</script>