<div  id="verificationModal" class="modal modal-auth fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden p-4">
        <div class="auth-modal bg-white rounded-2xl max-w-md w-full overflow-hidden relative">
            <div class="auth-modal-header p-6 text-center relative">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="auth-modal-title text-2xl font-bold">Código de Verificação</h3>
                    <button id="closeVerificationModal" class="modalClose_BT close-btn focus:outline-none">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <p class="text-purple-100 text-sm">Verifique sua caixa de entrada</p>
            </div>
            
            <div class="p-6">
                <p class="text-gray-600 mb-6 text-center">Digite o código de 6 dígitos enviado para seu email.</p>
                
                <form id="verificationForm">
                    <div class="input-group">
                        <label for="verification-code" class="input-label">
                            <i class="fas fa-shield-alt mr-2 text-purple-500"></i>
                            Código de verificação
                        </label>
                        <input type="text" id="verification-code" name="code" maxlength="6" 
                               class="input-gradient text-center text-lg tracking-widest" 
                               placeholder="000000" required>
                    </div>
                    
                    <button type="submit" class="resetPassword_BT btn-primary w-full py-3 rounded-lg text-white font-medium">
                        <i class="fas fa-check mr-2"></i>
                        Verificar Código
                    </button>
                </form>
                
                <div class="mt-6 text-center">
                    <p class="text-gray-600">
                        Não recebeu o código?
                        <button id="resendCode" class="font-medium text-purple-600 hover:text-purple-500 ml-1">
                            Reenviar
                        </button>
                    </p>
                </div>
            </div>
        </div>
    </div>