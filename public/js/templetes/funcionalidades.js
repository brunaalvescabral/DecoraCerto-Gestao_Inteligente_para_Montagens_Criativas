
export default function inicializarFuncionalidades() {
    document.getElementById("btn-funcionalidades").addEventListener("click", mostrarFuncoes);
    document.querySelectorAll(".btn-funcionalidades-expansiva").forEach((expansivo_BT, i) => {
        expansivo_BT.addEventListener("click", () => {
            toggleConteudo(i);
        })
    });
    function mostrarFuncoes() {
        const containerBotoes = document.getElementById("botoes-funcionais");
        if (containerBotoes.style.display === "none" || containerBotoes.style.display === "") {
            containerBotoes.style.display = "flex";
        } else {
            containerBotoes.style.display = "none";
        }
    }
    function toggleConteudo(indexEle) {
        const conteudosPlataforma = document.querySelectorAll(".plataformas .conteudo")
        conteudosPlataforma.forEach(conteudoP => {
            if (conteudosPlataforma[indexEle] != conteudoP) {
                conteudoP.classList.remove("show");
            }
        });
        conteudosPlataforma[indexEle].classList.toggle("show");
    }
}