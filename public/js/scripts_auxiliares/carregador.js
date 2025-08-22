import { carregarAssets } from './request.js';

export function CarregarJS(page) {
    page = page.replace("?", "").split("=");
    carregarAssets().then(config => {
        let rota = config.pages.find(p => p.name === page[1]);
        for (let js of rota.js) {
            if(!js.includes(".js"))continue; // Verifica se é um arquivo JS
            import(`../templetes/${js}`).then(module => {
                module.default(); // Chama a função padrão do módulo carregado
            }).catch(error => { console.error(`Erro ao carregar o módulo ${js}:`, error); });
        }
    }).catch(error => {console.error('Erro ao buscar os dados do card:', error);});
}