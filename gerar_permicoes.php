<?php
/*
    Todas as restrições e permissões seguem a estrutura:
    - "pasta@arquivo" → refere-se a um arquivo específico dentro de uma pasta.
    - "pasta@p_total" → refere-se a todos os arquivos dentro da pasta.

    Regras:
    1. Se a pasta estiver listada como "pasta@p_total" nos **permitidos**, ela permite todos os arquivos da pasta, exceto os listados nos **restringidos**.
    2. Se a pasta estiver listada como "pasta@p_total" nos **restringidos**, ela bloqueia todos os arquivos da pasta, exceto os que estiverem explicitamente nos **permitidos**.
    3. Se o item for apenas "pasta@arquivo", ele se refere exclusivamente àquele arquivo.
*/
$permissoes_templates_nao_logado = [
    "home@p_total",
    "autenticacao@p_total", 
    "principal@p_total",
    "kits@listar",
    "kits@selecionar"
];
$permicao_geral_apos_logado = [
    "atutenticacao@p_total","home@p_total","principal@p_total"
];

$restricao_templates_apos_logado = [
    "autenticacao@login","home@beneficios", "home@funcionalidades", "home@modal_card"
];

$permissoes_templetes = [
    "gerente" => [
        // Permissões gerais
        "dashboard@p_total",
        "exportar@p_total",
        "financeiro@p_total",
        "graficos@p_total",
        "investimentos@p_total",
        "kits@p_total",
        "orcamentos@p_total",
        "relatorios@p_total",
        "usuarios@p_total",
        "termos@p_total"
    ],
    "atendente" => [
        "orcamentos@p_total",               // para acesso total se desejar
        "termo@gerar",                      // pode mapear para exportar/gerar_termo_compromisso.php
        "exportar@gerar_termo_compromisso", // arquivo real
        "kits@listar",
        "kits@selecionar",
    ],
    "financeiro" => [
        "orcamentos@visulalizar",
        "exportar@p_total",
        "dashboard@p_total",
        "financeiro@p_total"
    ],
    "caixa" => [
        // Permissões resumidas para o caixa (exemplo)
        "financeiro@listar_notas",
        "financeiro@pagamentos",
        "financeiro@salvar_nota"
    ],
    "cliente" => [
        // permissões que estão em geral
    ]
];