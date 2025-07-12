// /FUNÇÃO JAVASCRIPT PARA MOSTRAR E OCULTAR SENHA NA PÁGINA LOGIN

function showHide() {
	//Da página de login
	HiddenPassword('#password', '.iconSenha');
}
function showHideConfirm() {
	//Da página de confirmação
	HiddenPassword('#password_confirm', '.iconSenha_confirm');
}
function HiddenPassword(idInput, classIcon) {
	const password = document.querySelector(idInput);
	const icon = document.querySelector(classIcon);
	if (password.type === 'password') {
		password.type = 'text';
		icon.classList.add('hide')
	} else {
		password.type = 'password';
		icon.classList.remove('hide');
	}
}