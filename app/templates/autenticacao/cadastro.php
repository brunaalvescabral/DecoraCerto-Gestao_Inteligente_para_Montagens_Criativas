<div id="signupModal" class="modal modal-auth fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden absolute">
    <div class="auth-modal bg-white rounded-2xl max-w-md w-full ">
        <div class="auth-modal-header text-center flex justify-between items-center mb-4 p-3">
            <h3 class="auth-modal-title text-2xl font-bold">Cadastro</h3>
            <button id="closeSignupModal" class="modalClose_BT close-btn focus:outline-none">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="py-0 px-3 relative">
            <div id="signupMessage" style="justify-content: space-between;" class="d-none"></div>
            <form id="signupForm" method="post" class="space-y-5">
                <div class="input-group">
                    <label for="name" class="input-label">
                        <i class="fas fa-user mr-2 text-purple-500"></i>
                        Nome completo
                    </label>
                    <input type="text" id="name" name="nome" class="input-gradient" placeholder="Seu nome completo" required>
                </div>
                <div class="input-group">
                    <label for="signup-email" class="input-label">
                        <i class="fas fa-envelope mr-2 text-purple-500"></i>
                        Email
                    </label>
                    <input type="email" id="signup-email" name="email" class="input-gradient" placeholder="seu@email.com" required>
                </div>
                <div class="input-group">
                    <label for="endereco" class="input-label">
                        <i class="fas fa-user mr-2 text-purple-500"></i>
                        Endereço
                    </label>
                    <input type="text" id="endereco" name="endereco" class="input-gradient" placeholder="endereco" required>
                </div>
                <div class="d-flex">
                    <div class="input-group">
                        <label for="cpf" class="input-label">
                            <i class="fas fa-user mr-2 text-purple-500"></i>
                            CPF
                        </label>
                        <input type="number" id="cpf" name="cpf" class="input-gradient" placeholder="cpf - somente numeros" required>
                    </div>
                    <div class="input-group">
                        <label for="data_nascimento" class="input-label">
                            <i class="fas fa-user mr-2 text-purple-500"></i>
                            Data Nascimento
                        </label>
                        <input style="outline: none; border: none;" type="date" id="data_nascimento" name="data_nascimento" class="input-gradient" placeholder="00/00/0000" required>
                    </div>
                </div>
                <div class="input-group relative">
                    <label for="signup-password" class="input-label">
                        <i class="fas fa-lock mr-2 text-purple-500"></i>
                        Senha
                    </label>
                    <input type="password" id="signup-password" name="senha" class="senha_IN input-gradient pr-12" placeholder="Crie uma senha forte" required>
                    <button type="button" class="passwordToggle_BT">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <div class="input-group relative">
                    <label for="confirm-password" class="input-label">
                        <i class="fas fa-lock mr-2 text-purple-500"></i>
                        Confirmar senha
                    </label>
                    <input type="password" id="confirm-password" name="confirm_senha" class="senha_IN input-gradient pr-12" placeholder="Confirme sua senha" required>
                    <button type="button" class="passwordToggle_BT">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <div class="custom-checkbox">
                    <input id="accept-terms" name="accept-terms" type="checkbox" required>
                    <label for="accept-terms" class="checkbox-label">
                        Aceito os
                        <a href="#" class="text-purple-600 hover:text-purple-500 font-medium">termos de uso</a>
                        e
                        <a href="#" class="text-purple-600 hover:text-purple-500 font-medium">política de privacidade</a>
                    </label>
                </div>
                <button id="fazerCadastro_BT" type="button" class="btn-primary w-full py-3 rounded-lg text-white font-medium">
                    Criar conta
                </button>
            </form>
            <div class="mt-6 text-center">
                <p class="text-gray-600">
                    Já tem uma conta?
                    <button id="switchToLogin" class="logar_BT font-medium text-purple-600 hover:text-purple-500 ml-1">
                        Entrar aqui
                    </button>
                </p>
            </div>
        </div>
    </div>
</div>
<?php unset($_SESSION['logMensagem']); ?>