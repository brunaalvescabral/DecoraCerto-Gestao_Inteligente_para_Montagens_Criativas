// FUNÇÃO EM JAVASCRIPT PARA VALIDAÇÃO DE SENHA
function conferesenha() {
	const senha1 = document.querySelector('#password');
	const senha2 = document.querySelector('#password_confirm');
	if (senha2.value == senha1.value) {
		senha2.setCustomValidity('');
	} else {
		senha2.setCustomValidity('As senhas não conferem');
	}

}
// método onchange =  é utilizado para que seja realizada determinada ação após alguma mudança.

//     conferesenha = funçao responsavel por fazer a validação

//     setCustomValidity = Permite setar uma mensagem de erro
//      personalizada explicando o porque um determinado valor não é válido.
//       Quando uma mensagem é setada o estado do elemento passa a ser inválido.
//        Caso queira que o estado volte a ser válido chame este método e
//         passe uma string vazia como parâmetro.