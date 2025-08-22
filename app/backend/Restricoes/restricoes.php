<?php
function restricoes_templates_users($user_type) {
    $restricoes_templates = [
        // Templates restritos por tipo de usuário(templetes que os usuários não podem acessar);
        "admin" => [],
        "loja" => [
            "adicionar_admin",
            "visualizar_admins",
            "editar_admin",
            "deletar_admin",
            "alterar_permissoes",
        ],
        "gerente" => [
            "adicionar_admin",
            "visualizar_admins",
            "editar_admin",
            "deletar_admin",
            "alterar_permissoes",
            "adicionar_gerente",
            "editar_gerente",
            "deletar_gerente",
            "adicionar_atendente",
            "editar_atendente",
            "deletar_atendente",
            "cadastrar_lo",
        ],
        "atendente" => [
            // Atendente com mais restrições
            "visualizar_clientes",
            "editar_cliente",
            "deletar_cliente",
            "visualizar_estoque",
            "adicionar_kit",
            "editar_kit",
            "deletar_kit",
            "adicionar_admin",
            "visualizar_admins",
            "editar_admin",
            "deletar_admin",
            "alterar_permissoes",
            "adicionar_gerente",
            "editar_gerente",
            "deletar_gerente",
            "adicionar_atendente",
            "editar_atendente",
            "deletar_atendente",
            "cadastrar_lo",
        ],
    ];
    return $restricoes_templates[$user_type] ?? [];
}
