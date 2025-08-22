<!-- Login Modal -->
<div id="loginModal" class="modal modal-auth hidden fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 p-4">
    <div id="subLoginModal" class="login-modal bg-white rounded-2xl max-w-md w-full">
        <div class="auth-modal-header text-center flex justify-between items-center mb-4 p-3">
            <h3 class="auth-modal-title text-2xl font-bold">Login</h3>
            <button id="closeSigninModal" class="modalClose_BT close-btn focus:outline-none">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-6">
            <form id="loginForm">
                <div id="signupMessage" style="justify-content: space-between;" class="d-none"></div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Email</label>
                    <input type="email" id="email" name="email" class="input-gradient w-full px-3 py-3 rounded-md shadow-sm focus:outline-none focus:ring-0 relative z-10" required>
                </div>
                <div class="mb-6 relative">
                    <label for="password" class="block text-gray-700 text-sm font-medium mb-2">Senha</label>
                    <input type="password" id="password" name="password" class="senha_IN input-gradient w-full px-3 py-3 pr-12 rounded-md shadow-sm focus:outline-none focus:ring-0 relative z-10" required>
                    <button type="button" class="passwordToggle_BT">
                        <i class="far fa-eye"></i>
                    </button>
                </div>
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="remember-me" class="ml-2 block text-sm text-gray-700">Lembrar-me</label>
                    </div>
                    <button id="forgotPasswordLink" class="forgotPassword_BT text-sm text-indigo-600 hover:text-indigo-500">Esqueceu a senha?</button>
                </div>
                <div id="loginCaptcha" class="g-recaptcha" data-sitekey="SUA_SITE_KEY" style="display:none"></div>
                <div>
                    <button type="button" id="fazerLogin_BT" class="btn-primary w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Entrar
                    </button>
                </div>
            </form>
            <div class="mt-6">
                <p class="text-center text-sm text-gray-600">
                    Não tem uma conta?
                    <button id="switchToSignup" class="inscrever_BT font-medium text-indigo-600 hover:text-indigo-500">
                        Cadastre-se
                    </button>
                </p>
            </div>
        </div>
    </div>
</div>