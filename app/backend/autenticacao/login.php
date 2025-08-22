<?php
function autenticarUsuario($conn, $datas){
    $dados = ['status' => 'danger', 'message' => '', 'datas' => []];

    $email = trim($datas['email'] ?? '');
    $senha = trim($datas['password'] ?? '');

    if (!$email || !$senha) {
        $dados['status'] = 'warning';
        $dados['message'] = "Login/email e senha são obrigatórios.";
        return $dados;
    }

    // Consulta pelo login ou email na tabela clientes
    $stmt = $conn->prepare("SELECT id, nome, login, email, contato, senha, status, endereco_id FROM clientes WHERE email = ?");
    
    // Primeiro busca na tabela clientes
    [$dados, $usuario] = RealizarBusca($conn, $stmt, $dados, $email);
    
    // Se não encontrou na tabela clientes, busca na tabela usuarios
    if (count($usuario) == 0) {
        $stmt2 = $conn->prepare("SELECT id, nome, email, nivel, senha, status FROM usuarios WHERE email = ?");
        [$dados, $usuario] = RealizarBusca($conn, $stmt2, $dados, $email);
        
        // Se encontrou na tabela usuarios, ajusta os campos para o padrão esperado
        if (count($usuario) > 0) {
            $usuario['login'] = $usuario['email']; // Define login como email para usuarios
            $usuario['contato'] = null; // usuarios não têm contato
            $usuario['endereco_id'] = null; // usuarios não têm endereco_id
        }
        
        if (count($usuario) == 0) {
            $dados['status'] = 'warning';
            $dados['message'] = "Email não cadastrado no sistema.";
            return $dados;
        }
    }

    if ($usuario['status'] !== 'ativo') {
        $dados['status'] = 'warning';
        $dados['message'] = "Conta inativa ou bloqueada.";
        return $dados;
    }

    if (!password_verify($senha, $usuario['senha'])) {
        $dados['status'] = 'danger';
        $dados['message'] = "Senha incorreta.";
        return $dados;
    }

    $dados['status'] = 'success';
    $dados['message'] = "Login realizado com sucesso!";
    
    // Criando sessão com estrutura correta
    $secao = [
        'id' => $usuario['id'],
        'nome' => $usuario['nome'],
        'login' => $usuario['login'] ?? $usuario['email'],
        'contato' => $usuario['contato'] ?? "000000000",
        'nivel' => $usuario['nivel'] ?? 'cliente'
    ];
    $_SESSION['user'] = $secao;

    // Corrigindo o retorno dos dados
    // $dados['datas'] = ['email' => $secao['login']];
    $dados['datas'] = $_SESSION['user'];
    
    return $dados;
}

function RealizarBusca($conn, $stmt, $dados, $email) {
    if (!$stmt) {
        error_log("Erro ao preparar consulta: " . $conn->error);
        $dados['status'] = 'danger';
        $dados['message'] = "Erro interno do sistema. Tente novamente.";
        return [$dados, []];
    }

    // Verifica quantos parâmetros o statement precisa
    $paramCount = substr_count($stmt->sqlstate ?? '', '?');
    if ($paramCount === 0) {
        // Conta os ? na query manualmente se sqlstate não funcionar
        $reflection = new ReflectionClass($stmt);
        $property = $reflection->getProperty('affected_rows');
        // Como não conseguimos acessar a query diretamente, assumimos pelos parâmetros passados
        $paramCount = 2; // padrão para clientes (email OR login)
    }

    if ($paramCount === 1) {
        // Para tabela usuarios (só email)
        $stmt->bind_param("s", $email);
    } else {
        // Para tabela clientes (email OR login)
        $stmt->bind_param("s", $email);
    }

    if (!$stmt->execute()) {
        error_log("Erro ao executar consulta: " . $stmt->error);
        $dados['status'] = 'danger';
        $dados['message'] = "Erro interno do sistema. Tente novamente.";
        $stmt->close();
        return [$dados, []];
    }

    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        $stmt->close();
        return [$dados, []]; // Retorna array vazio sem alterar status aqui
    }

    $usuario = $result->fetch_assoc();
    $stmt->close();
    
    return [$dados, $usuario];
}