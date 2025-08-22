import { openModal, closeModal } from "./carousel.js";
import { carregarDados, navegarPara } from "../scripts_auxiliares/request.js";
// navegarPara('home');
function ElementosAutenticacao() {
    const botoesLogar = document.querySelectorAll(".logar_BT");
    const botoesInscrever = document.querySelectorAll(".inscrever_BT");
    const botoesRecuperarSenha = document.querySelectorAll(".forgotPassword_BT");
    const botoesVerificarCodigo = document.querySelectorAll(".KeyVerification_BT");
    const botoesRecriarSenha = document.querySelectorAll(".resetPassword_BT");
    const inputsSenha = document.querySelectorAll(".senha_IN");
    const botaoTogglePassword = document.querySelectorAll(".passwordToggle_BT");
    const modaisAuth = document.querySelectorAll(".modal-auth");

    // const botaoFazerLogin = document.querySelector("#fazerLogin_BT");

    return {
        botoesLogar,
        botoesInscrever,
        botoesRecuperarSenha,
        botoesVerificarCodigo,
        botoesRecriarSenha,
        inputsSenha,
        botaoTogglePassword,
        modaisAuth
    };
}
export default function inicializarAutenticacao() {
    const { botoesLogar, botoesInscrever, botoesRecuperarSenha, botoesVerificarCodigo, botoesRecriarSenha, inputsSenha, botaoTogglePassword, modaisAuth } = ElementosAutenticacao();
    ClickEnventOpenModal(botoesLogar, "loginModal");
    ClickEnventOpenModal(botoesInscrever, "signupModal");
    ClickEnventOpenModal(botoesRecuperarSenha, "forgotPasswordModal");
    ClickEnventOpenModal(botoesVerificarCodigo, "verificationModal");
    ClickEnventOpenModal(botoesRecriarSenha, "resetPasswordModal");
    inputsSenha.forEach(input => {
        const button = input.nextElementSibling; // Assuming the button is the next sibling
        if (button && button.classList.contains("passwordToggle_BT")) {
            button.addEventListener("click", () => {
                togglePassword(input, button);
            });
        }
    });
    modaisAuth.forEach(modalAuth => { });
    RealizarCadastro();
    RealizarLogin();
}
function ClickEnventOpenModal(ElementoCLASSs, idModal) {
    ElementoCLASSs.forEach(elemento => {
        elemento.addEventListener("click", () => {
            openModal(idModal);
        });
    });
}
function RealizarCadastro() {
    const botaoFazerCadastro = document.querySelector("#fazerCadastro_BT");
    if (botaoFazerCadastro) {
        botaoFazerCadastro.addEventListener("click", (e) => {
            e.preventDefault();
            // verificar se todos os dados estão ok
            const form = document.querySelector("#signupForm");
            const formData = new FormData(form);
            const datas = Object.fromEntries(formData.entries());
            carregarDados('auth', 'cadastro', datas).then(datasRes => {
                AcaoPosAltenticacao(datasRes,"cadastro");
            }).catch(error => {
                console.error('Erro ao realizar cadastro:', error);
            });

        });
    }
}
function RealizarLogin(){
    const botaoFazerLogin = document.querySelector("#fazerLogin_BT");
    if (botaoFazerLogin) {
        botaoFazerLogin.addEventListener("click", (e) => {
            e.preventDefault();
            // verificar se todos os dados estão ok
            const form = document.querySelector("#loginForm");
            const formData = new FormData(form);
            const datas = Object.fromEntries(formData.entries());
            carregarDados('auth', 'login', datas).then(datasRes => {
                AcaoPosAltenticacao(datasRes, "login");
            }).catch(error => {
                console.error('Erro ao realizar cadastro:', error);
            });

        });
    }
}

function AcaoPosAltenticacao(datas,page) {
    const msg = document.querySelector("#signupMessage");
    msg.classList.remove('d-none');
    msg.classList.add(`alert-${datas.status}`,'alert','d-flex');
    msg.innerHTML = `<p>${datas.message}</p> 
                <span id="f_alert" style="color:red; font-weight: bolder; cursor: pointer;">x</span>`;
    if (datas.status == "success") {
        setTimeout(() => {
            if(page == "cadastro")openModal("loginModal");
            else closeModal("loginModal");
            msg.classList.remove(`alert-${datas.status}`,'alert','d-flex');
            msg.classList.add('d-none');
            msg.innerHTML = "";
            // reload após login
            if(page == "login") location.reload();
        }, 1000);
    }
    document.querySelector("#f_alert").addEventListener("click", () => {
        msg.classList.remove(`alert-${datas.status}`, 'alert');
        msg.classList.add('d-none');
        msg.innerHTML = "";
    });
    console.log('cadastro:', datas);
}
function togglePassword(input, button) {
    const icon = button.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'far fa-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'far fa-eye';
    }
}