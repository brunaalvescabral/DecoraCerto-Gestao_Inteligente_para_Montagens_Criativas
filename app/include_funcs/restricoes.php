<?php
/*
    SISTEMA DE PERMISSÕES E RESTRIÇÕES
    
    Estrutura:
    - "pasta@arquivo" → refere-se a um arquivo específico dentro de uma pasta.
    - "pasta@p_total" → refere-se a todos os arquivos dentro da pasta.

    Regras de precedência:
    1. Permissão específica SEMPRE prevalece sobre geral
    2. Restrição específica SEMPRE prevalece sobre geral
    3. Se pasta tem "p_total" permitido: permite tudo, exceto restrições específicas
    4. Se pasta tem "p_total" restrito: bloqueia tudo, exceto permissões específicas
    5. Se não há regra geral, só permite o que estiver explícito em permitidos
*/

// Permissões para usuários NÃO logados
$permissoes_templates_nao_logado = [
    "home@p_total",
    "autenticacao@p_total", 
    "principal@p_total",
    "kits@listar",
    "kits@selecionar"
];

// Permissões gerais após login (aplicam para TODOS os usuários logados)
$permissao_geral_apos_logado = [
    "autenticacao@p_total", // Corrigido: era "atutenticacao"
    "home@p_total",
    "principal@p_total"
];

// Restrições específicas após login (removem acesso mesmo se permitido em geral)
$restricao_templates_apos_logado = [
    "autenticacao@login",
    "home@p_total"
    // "home@titulo",
    // "home@modal_card",
    // "home@carousel",
    // "home@beneficios", 
    // "home@funcionalidades", 
    // "home@faixa-roxa"
    // "home"
];

// Permissões específicas por tipo de usuário
$permissoes_templetes = [
    "gerente" => [
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
        "orcamentos@p_total",
        "termos@gerar", // Corrigido: era "termo@gerar"
        "exportar@gerar_termo_compromisso",
        "kits@listar",
        "kits@selecionar",
        "dashboard@visualizar" // Acesso básico ao dashboard
    ],
    "financeiro" => [
        "orcamentos@visualizar", // Corrigido: era "visulalizar"
        "exportar@p_total",
        "dashboard@p_total",
        "financeiro@p_total",
        "relatorios@financeiro"
    ],
    "caixa" => [
        "financeiro@listar_notas",
        "financeiro@pagamentos",
        "financeiro@salvar_nota",
        "dashboard@resumo_caixa"
    ],
    "cliente" => [
        "kits@visualizar",
        "orcamentos@meus_orcamentos",
        "perfil@p_total"
    ]
];

/**
 * Verifica se usuário pode acessar determinado template
 * 
 * @param string $pastaEarquivo Formato: "pasta@arquivo"
 * @param string|null $user_type Tipo do usuário ou null se não logado
 * @return array [pasta, arquivo] se permitido, ["", ""] se negado
 */
function pode_acessar_template($pastaEarquivo, $user_type = null) {
    global $permissoes_templates_nao_logado, $restricao_templates_apos_logado;
    global $permissao_geral_apos_logado, $permissoes_templetes;

    // Validação básica do formato
    if (substr_count($pastaEarquivo, '@') !== 1) {
        error_log("Formato inválido para permissão: $pastaEarquivo");
        return ["", ""];
    }

    // Se o usuário não está logado
    if ($user_type === null || $user_type === '') {
        $tem_acesso = tem_acesso($pastaEarquivo, $permissoes_templates_nao_logado, []);
        return $tem_acesso ? explode('@', $pastaEarquivo, 2) : ["", ""];
    }

    // Usuário está logado - combina permissões gerais + específicas do tipo
    $permissoes_usuario = $permissoes_templetes[$user_type] ?? [];
    $permitidos = array_merge($permissao_geral_apos_logado, $permissoes_usuario);
    $restringidos = $restricao_templates_apos_logado;

    $tem_acesso = tem_acesso($pastaEarquivo, $permitidos, $restringidos);
    return $tem_acesso ? explode('@', $pastaEarquivo, 2) : ["", ""];
}

/**
 * Verifica se o acesso é permitido com base nas regras de permissão
 *
 * @param string $pastaEarquivo Formato: "pasta@arquivo"
 * @param array $permitidos Lista de permissões
 * @param array $restringidos Lista de restrições  
 * @return bool true se permitido, false se negado
 */
function tem_acesso($pastaEarquivo, $permitidos, $restringidos) {
    // Valida formato
    if (substr_count($pastaEarquivo, '@') !== 1) {
        return false;
    }

    // Separa pasta e arquivo
    [$pasta, $arquivo] = explode('@', $pastaEarquivo, 2);

    if (empty($pasta) || empty($arquivo)) {
        return false;
    }

    // Verifica permissões e restrições específicas
    $permitido_exato = in_array($pastaEarquivo, $permitidos);
    $restrito_exato = in_array($pastaEarquivo, $restringidos);

    // Verifica permissões e restrições gerais da pasta
    $permitido_geral = in_array("$pasta@p_total", $permitidos);
    $restrito_geral = in_array("$pasta@p_total", $restringidos);

    // REGRA 1: Restrição específica sempre prevalece
    if ($restrito_exato) {
        return false;
    }

    // REGRA 2: Permissão específica sempre prevalece (se não foi restrito especificamente)
    if ($permitido_exato) {
        return true;
    }

    // REGRA 3: Se pasta está restrita de forma geral, nega (já que não foi permitido especificamente)
    if ($restrito_geral) {
        return false;
    }

    // REGRA 4: Se pasta está permitida de forma geral, permite (já que não foi restrito especificamente)
    if ($permitido_geral) {
        return true;
    }

    // REGRA 5: Se não há regra específica nem geral, nega acesso por padrão
    return false;
}

/**
 * Função auxiliar para verificar se usuário tem permissão administrativa
 * 
 * @param string $user_type Tipo do usuário
 * @return bool true se é admin
 */
function is_admin($user_type) {
    return in_array($user_type, ['gerente', 'super_admin', 'admin']);
}

/**
 * Função auxiliar para verificar se usuário pode acessar área financeira
 * 
 * @param string $user_type Tipo do usuário
 * @return bool true se pode acessar financeiro
 */
function pode_acessar_financeiro($user_type) {
    return in_array($user_type, ['gerente', 'financeiro', 'caixa']);
}

/**
 * Obter todas as permissões de um usuário
 * 
 * @param string $user_type Tipo do usuário
 * @return array Lista de todas as permissões do usuário
 */
function obter_permissoes_usuario($user_type) {
    global $permissao_geral_apos_logado, $permissoes_templetes;
    
    if (!$user_type) {
        return [];
    }
    
    $permissoes_usuario = $permissoes_templetes[$user_type] ?? [];
    return array_merge($permissao_geral_apos_logado, $permissoes_usuario);
}

/**
 * Debug: Lista todas as permissões de um usuário (apenas para desenvolvimento)
 * 
 * @param string $user_type Tipo do usuário
 * @return array Informações detalhadas das permissões
 */
// function debug_permissoes($user_type = null) {
//     if (!defined('DEBUG') || !DEBUG) {
//         return [];
//     }
    
//     global $permissoes_templates_nao_logado, $restricao_templates_apos_logado;
//     global $permissao_geral_apos_logado, $permissoes_templetes;
    
//     if ($user_type === null) {
//         return [
//             'tipo' => 'não_logado',
//             'permitidos' => $permissoes_templates_nao_logado,
//             'restringidos' => []
//         ];
//     }
    
//     $permissoes_usuario = $permissoes_templetes[$user_type] ?? [];
//     $permitidos = array_merge($permissao_geral_apos_logado, $permissoes_usuario);
    
//     return [
//         'tipo' => $user_type,
//         'permitidos_gerais' => $permissao_geral_apos_logado,
//         'permitidos_especificos' => $permissoes_usuario,
//         'permitidos_total' => $permitidos,
//         'restringidos' => $restricao_templates_apos_logado
//     ];
// }