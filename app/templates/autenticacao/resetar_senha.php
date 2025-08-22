<div id="resetPasswordModal" class="modal modal-auth fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden p-4">
    <div class="auth-modal bg-white rounded-2xl max-w-md w-full overflow-hidden relative">
        <div class="auth-modal-header text-center flex justify-between items-center mb-4 p-3">
            <h3 class="auth-modal-title text-2xl font-bold">Nova Senha</h3>
            <button id="closeForgotPasswordModal" class="modalClose_BT close-btn focus:outline-none">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-6">
            <form id="resetPasswordForm" class="space-y-5">
                <div class="input-group relative">
                    <label for="new-password" class="input-label">
                        <i class="fas fa-lock mr-2 text-purple-500"></i>
                        Nova senha
                    </label>
                    <input type="password" id="new-password" name="password" class="senha_IN input-gradient pr-12" placeholder="Digite sua nova senha" required>
                    <button type="button" class="passwordToggle_BT">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>

                <div class="input-group relative">
                    <label for="confirm-new-password" class="input-label">
                        <i class="fas fa-lock mr-2 text-purple-500"></i>
                        Confirmar nova senha
                    </label>
                    <input type="password" id="confirm-new-password" name="confirm-password" class=" senha_IN input-gradient pr-12" placeholder="Confirme sua nova senha" required>
                    <button type="button" class="passwordToggle_BT">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>

                <button type="submit" class="btn-primary w-full py-3 rounded-lg text-white font-medium">
                    <i class="fas fa-key mr-2"></i>
                    Redefinir Senha
                </button>
            </form>
        </div>
    </div>
</div>