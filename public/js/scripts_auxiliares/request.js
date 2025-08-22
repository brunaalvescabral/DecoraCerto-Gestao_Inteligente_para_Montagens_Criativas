import { CarregarJS } from './carregador.js';
export function navegarPara(rota) {
    if (typeof rota !== 'string' || rota.trim() === '') {
        rota = 'home'; // Define a rota padrão se a rota for inválida
    }
    fetch(`ajax.php?page=${encodeURIComponent(rota)}`)
        .then(res => res.text()) // recebe como texto primeiro
        .then(text => {
            try {
                const data = JSON.parse(text);
                if (data.erro) {
                    console.error('Erro do servidor:', data.erro);
                    return;
                }
                document.querySelector('#conteudo-principal').innerHTML = data.html;
                history.pushState(null, '', data.url);
                CarregarJS(data.url);
            } catch (e) {
                console.error('Resposta não é JSON válido:', text);
            }
        })
        .catch(err => {
            console.error('Erro AJAX:', err);
        });
}
export function carregarDados(acao, id, dados = {}) {
    return new Promise((resolve, reject) => {
        fetch(`ajax.php?${encodeURIComponent(acao)}=${encodeURIComponent(id)}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: new URLSearchParams(dados).toString()
        })
        .then(res => res.text())
        .then(text => {
            try {
                const data = JSON.parse(text);
                if (data.erro) {
                    reject('Erro do servidor: ' + data.erro);
                } else {
                    resolve(data);
                }
            } catch (e) {
                reject('Resposta não é JSON válido: ' + text);
            }
        })
        .catch(err => {
            reject('Erro AJAX: ' + err);
        });
    });
}

export function carregarAssets() {
    return new Promise((resolve, reject) => {
        fetch("../pages.json") // ← raiz do servidor
            .then(r => {
                if (!r.ok) {
                    throw new Error("Erro HTTP: " + r.status);
                }
                return r.json();
            })
            .then(config => {
                if (!config || !config.pages) {
                    reject("JSON inválido ou mal formatado");
                } else {
                    resolve(config);
                }
            })
            .catch(err => reject("Erro ao carregar pages.json: " + err));
    });
}


// let page = config.pages.find(p => p.name === page);
// if (!page) {
//     console.warn("Página não encontrada:", page);
//     return;
// }
// page.css.forEach(cssFile => {
//     let link = document.createElement("link");
//     link.rel = "stylesheet";
//     link.href = cssFile;
//     document.head.appendChild(link);
// });
// page.js.forEach(jsFile => {
//     let script = document.createElement("script");
//     script.src = jsFile;
//     document.body.appendChild(script);
// });