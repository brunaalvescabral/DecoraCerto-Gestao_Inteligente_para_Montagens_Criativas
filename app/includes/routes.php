<?php
if (isset($_GET['page'])) { // caso, solicite a rota page
    $page = $_GET['page'];
    //paginas de autentocação só são acessadas se o usuário não estiver autenticado.
    if (!isset($_SESSION['autenticado'])) { //se não existe a sessão autenticado
        if ($page == "login") {
            //incluir pagina de login
        } else if ($page == "registerForm") {
            // incluir página de registro
        } else if ($page == "reset") {
            //  incluir página para alteração de senha
        } else if ($page == "code_confirmation") {
            // incluir página de código de confirmação
        } else if ($page == "change_password") {
            // 
        } else if ($page == "autenticar") {
            // 
        } else {
            header('location: ./?page=login');
        }
    } else if ($_SESSION['autenticado']) { //se existe a sessão autenticado ()
        //páginas principais só são acessadas se o usuário estiver autenticado
        //se o usuário estiver autenticado, é permitido o acesso as páginas abaixo dependendo do nível de acesso
        if ($page == "home" && isset($_SESSION['tipo'])) {
            //verifica qual o nível de acesso do úsuario e redireciona de acordo. Se um usuário comum tentar acessar a de admin ele é redirecionado para a página de comum.
            if ($_SESSION['tipo'] == 1) {
                //incluir página principal do usuário (admin)
            } else {
                // redirecionar para a pághin de usuário comum
                header('location: ./?page=<userComum>');
            }
        } else if ($page == "home_usuario") {
            include("../pages/home_usuario.php");
        } else if ($page == "emprestimos") {
        //    
        } else if ($page == "efetivarEmprestimos") {
        // 
        } else if ($page == "UpdateAtivos") {
        // 
        } else if ($page == "EditarAtivosForm") {
        //
        } else if ($page == "Pedidos") {
        //
        } else if ($page == "EntregarAtivos") {
        //
        } else if ($page == "efetivarEntrega") {
        //
        } else if ($page == "ExcluirAtivos") {
        //
        } else if ($page == "CancelarEntrega") {
        //
        } else {
            if (isset($_SESSION['tipo'])) {
                //verifica qual o nível de acesso do úsuario e redireciona de acordo. Se um usuário comum tentar acessar a de admin ele é redirecionado para a página de comum.
                if ($_SESSION['tipo'] == 1) {
                    //incluir página principal do usuário (admin)
                } else {
                    // redirecionar para a pághin de usuário comum
                    header('location: ./?page=<userComum>');
                }
            }
        }
    }
} else { //se não existe a varíavel page na url
    //se não estiver é redirecionado para página de login
    header('location: ./?page=login');
}
