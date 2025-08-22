<?php
function cadastrarUsuario($conn, $datas){
    $retornoDados = ['status' => 'danger', 'message' => '', 'datas' => []];
    if(empty($datas)){
        $retornoDados['status'] = 'worning';
        $retornoDados['message'] = 'Os campos nome, CPF, email e senha são obrigatórios.';
        return $retornoDados;
    }
    // Verifica conexão
    if (!$conn || $conn->connect_errno) {
        $retornoDados['message'] = "Erro de conexão. conexão inválida.";
        // $retornoDados['message'] = "Erro de conexão: " . ($conn->connect_error ?? "conexão inválida");
        return $retornoDados;
    }

    // Campos obrigatórios
    $nome = trim($datas['nome'] ?? '');
    $cpf = trim($datas['cpf'] ?? '');
    $email = trim($datas['email'] ?? '');
    $senha = trim($datas['senha'] ?? '');
    $confirmarSenha = trim($datas['confirm_senha']??'' ); 

    if (!$nome || !$cpf || !$email || !$senha) {
        $retornoDados['status'] = 'warning';
        $retornoDados['message'] = "Os campos nome, CPF, email e senha são obrigatórios.";
        return $retornoDados;
    }

    $data_nascimento = trim($datas['data_nascimento'] ?? '');
    $contato = trim($datas['contato'] ?? '');
    // $endereco = trim($datas['endereco'] ?? '');
    // $endereco = $datas['endereco'] ?? "gerente";
    $endereco = rand(0,5);
    $status = $datas['status'] ?? 'ativo';
    $login = $email;
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    $senhaHash = password_hash($confirmarSenha, PASSWORD_DEFAULT);
    if($senha !== $confirmarSenha){
        $retornoDados['status'] = "warning";
        $retornoDados['message'] = "As senhas não coincidem.";
        return $retornoDados;
    }

    // Validação CPF
    if (strlen($cpf) !== 11 || !ctype_digit($cpf)) {
        $retornoDados['status'] = "warning";
        $retornoDados['message'] = "CPF inválido. Deve conter 11 dígitos numéricos.";
        return $retornoDados;
    }

    // Verifica se já existe CPF
    $stmt = $conn->prepare("SELECT id FROM clientes WHERE cpf = ?");
    if (!$stmt) {
        $retornoDados['status'] = "danger";
        $retornoDados['message'] = "Erro ao cadastrar dados.";
        // $retornoDados['message'] = "Erro ao preparar dados: " . $conn->error;
        return $retornoDados;
    }

    $stmt->bind_param("s", $cpf);
    if (!$stmt->execute()) {
        $retornoDados['status'] = "danger";
        $retornoDados['message'] = "Erro ao verificar CPF.";
        // $retornoDados['message'] = "Erro ao verificar CPF: " . $stmt->error;
        $stmt->close();
        return $retornoDados;
    }

    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $retornoDados['status'] = 'warning';
        $retornoDados['message'] = "Esse CPF já está cadastrado no sistema.";
        $stmt->close();
        return $retornoDados;
    }
    $stmt->close();

    // Inserção no banco
    $stmt = $conn->prepare("INSERT INTO clientes 
        (nome, cpf, email, data_nascimento, contato, endereco_id, login, senha, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        $retornoDados['status'] = "danger";
        $retornoDados['message'] = "Erro ao preparar insert: " . $conn->error;
        return $retornoDados;
    }

    $stmt->bind_param("sssssisss", $nome, $cpf, $email, $data_nascimento, $contato, $endereco, $login, $senhaHash, $status);
    
    // $stmtU = $conn->prepare("INSERT INTO usuarios 
    //     (nome,email, senha, nivel, status, criado_em) 
    //     VALUES (?, ?, ?, ?, ?, ?)");
    // $stmtU->bind_param("ssssss", $nome, $email, $senhaHash, $endereco, $status,date("Y-m-d H:i:s"));
    // // $stmtU->execute();

    if ($stmt->execute()) {
        $retornoDados['status'] = "success";
        $retornoDados['message'] = "usuário cadastrado com sucesso!";
        $retornoDados['datas'] = [
            'id' => $conn->insert_id,
            'nome' => $nome,
            'cpf' => $cpf,
            'email' => $email
        ];
    } else {
        $retornoDados['status'] = "danger";
        $retornoDados['message'] = "Erro ao gravar dados.";
        $retornoDados['message'] = "Erro ao inserir no banco: " . $stmt->error;
    }
    $stmt->close();
    return $retornoDados;
}

