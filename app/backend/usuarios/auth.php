<?php
// Função para verificar se o usuário está logado
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

// Função para verificar permissões por role
function hasPermission($required_roles) {
    if (!isLoggedIn()) {
        return false;
    }
    $user_role = $_SESSION['user_role'] ?? '';
    if (is_array($required_roles)) {
        return in_array($user_role, $required_roles);
    }
    return $user_role === $required_roles;
}
// Função para redirecionar se não autorizado
function requireAuth($required_roles = null) {
    if (!isLoggedIn()) {
        header('Location: ?template=login');
        exit;
    }
    if ($required_roles && !hasPermission($required_roles)) {
        header('Location: ?template=acesso_negado');
        exit;
    }
}
// Função para fazer login
function login($email, $senha) {
    global $conn;
    $stmt = $conn->prepare("SELECT id, nome, email, role, status FROM usuarios WHERE email = ? AND senha = ? AND status = 'ativo'");
    $stmt->bind_param("ss", $email, md5($senha));
    $stmt->execute();
    $result = $stmt->get_result();
    if ($user = $result->fetch_assoc()) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['nome'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['role'];
        // Log da atividade
        logActivity($user['id'], 'login', 'Usuário fez login no sistema');
        return true;
    }
    return false;
}

// Função para fazer logout
function logout() {
    if (isLoggedIn()) {
        logActivity($_SESSION['user_id'], 'logout', 'Usuário fez logout do sistema');
    }
    session_destroy();
    header('Location: ?template=login');
    exit;
}
// Função para registrar atividades
function logActivity($user_id, $action, $description) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO logs_atividade (user_id, action, description, ip_address, created_at) VALUES (?, ?, ?, ?, NOW())");
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $stmt->bind_param("isss", $user_id, $action, $description, $ip);
    $stmt->execute();
}

// Função para obter informações do usuário atual
function getCurrentUser() {
    if (!isLoggedIn()) {
        return null;
    }
    return [
        'id' => $_SESSION['user_id'],
        'name' => $_SESSION['user_name'],
        'email' => $_SESSION['user_email'],
        'role' => $_SESSION['user_role']
    ];
}
// Definir roles e suas permissões
$roles_permissions = [
    'admin' => ['all'],
    'gerente' => ['dashboard_gerente', 'relatorios', 'gestao_kits', 'gestao_clientes', 'financeiro'],
    'atendente' => ['menu_atendente', 'cadastro_cliente', 'aluguel_kit', 'prereservas'],
    'caixa' => ['dashboard_caixa', 'orcamentos', 'pagamentos', 'financeiro_basico'],
    'financeiro' => ['dashboard_financeiro', 'relatorios_financeiros', 'contabilidade']
];

// Função para verificar permissão específica
function hasSpecificPermission($permission) {
    global $roles_permissions;
    
    if (!isLoggedIn()) {
        return false;
    }
    
    $user_role = $_SESSION['user_role'];
    
    if (isset($roles_permissions[$user_role])) {
        return in_array('all', $roles_permissions[$user_role]) || 
               in_array($permission, $roles_permissions[$user_role]);
    }
    return false;
}
?>
