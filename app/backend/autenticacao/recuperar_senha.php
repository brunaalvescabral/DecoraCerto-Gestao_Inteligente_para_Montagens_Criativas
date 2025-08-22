    <div  id="forgotPasswordModal" class="modal modal-auth modal-auth fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden p-4">
        <div class="auth-modal bg-white rounded-2xl max-w-md w-full overflow-hidden relative">
            <div class="auth-modal-header p-6 text-center relative">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="auth-modal-title text-2xl font-bold">Recuperar Senha</h3>
                    <button id="closeForgotPasswordModal" class="modalClose_BT close-btn focus:outline-none">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <p class="text-purple-100 text-sm">Não se preocupe, vamos ajudar você</p>
            </div>
            
            <div class="p-6">
                <p class="text-gray-600 mb-6 text-center">Digite seu email para receber as instruções de recuperação de senha.</p>
                
                <form id="forgotPasswordForm">
                    <div class="input-group">
                        <label for="forgot-email" class="input-label">
                            <i class="fas fa-envelope mr-2 text-purple-500"></i>
                            Email
                        </label>
                        <input type="email" id="forgot-email" name="email" class="input-gradient" placeholder="seu@email.com" required>
                    </div>
                    <button type="submit" class="KeyVerification_BT btn-primary w-full py-3 rounded-lg text-white font-medium">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Enviar Código
                    </button>
                </form>
                
                <div class="mt-6 text-center">
                    <p class="text-gray-600">
                        Lembrou da senha?
                        <button id="backToLogin" class="font-medium text-purple-600 hover:text-purple-500 ml-1">
                            Voltar ao login
                        </button>
                    </p>
                </div>
            </div>
        </div>
    </div>