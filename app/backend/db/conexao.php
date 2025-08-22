<?php
// Conecta sem selecionar banco
function Abrir_conexao()
{
  $conn = new mysqli(DB_HOST, DB_USER, DB_PASS);
  if ($conn->connect_error) {
    die("Erro na conexão com o servidor MySQL: " . $conn->connect_error);
  }
  $sql = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '" . $conn->real_escape_string(DB_NAME) . "'";
  if (($conn->query($sql))->num_rows == 0) {
    Criar_Banco($conn, fazer_insercoes: true);
  } else {
    $conn->select_db(DB_NAME);
  }
  return $conn;
};
function Fechar_conexão($conn)
{
  if ($conn instanceof mysqli) {
    $conn->close();
  }
}
//funções para recriar o banco, caso ele não exista.
function Criar_Banco($conn = null, $fazer_insercoes = false)
{
  $sql_cmd = [
    "CREATE TABLE IF NOT EXISTS `alugueis` (
      `id` int(11) NOT NULL,
      `cliente_id` int(11) NOT NULL,
      `kit_id` int(11) NOT NULL,
      `data_retirada` date NOT NULL,
      `data_devolucao` date NOT NULL,
      `forma_pagamento_id` int(11) NOT NULL,
      `desconto` decimal(10,2) DEFAULT 0.00,
      `acrescimo` decimal(10,2) DEFAULT 0.00,
      `data_aluguel` datetime DEFAULT current_timestamp(),
      `valor_total` decimal(10,2) DEFAULT 0.00,
      `atendido` tinyint(1) DEFAULT 0
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",
    "CREATE TABLE IF NOT EXISTS `endereco` (
      `id` INT(11) NOT NULL,
      `logradouro` VARCHAR(255) NOT NULL,
      `numero` VARCHAR(10) NOT NULL,
      `complemento` VARCHAR(100) DEFAULT NULL,
      `bairro` VARCHAR(100) NOT NULL,
      `cidade` VARCHAR(100) NOT NULL,
      `estado` CHAR(2) NOT NULL,
      `cep` VARCHAR(10) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",
    "CREATE TABLE IF NOT EXISTS `clientes`(
      `id` INT(11) NOT NULL,
      `nome` VARCHAR(100) NOT NULL,
      `cpf` VARCHAR(11) NOT NULL,
      `email` VARCHAR(100) NOT NULL,
      `login` VARCHAR(50) NOT NULL,
      `senha` VARCHAR(255) NOT NULL,
      `status` ENUM('ativo', 'inativo') DEFAULT 'ativo',
      `endereco_id` INT(11) NOT NULL,
      `data_nascimento` DATE NOT NULL,
      `contato` VARCHAR(20) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",
    "CREATE TABLE IF NOT EXISTS `contas_pagar` (
      `id` int(11) NOT NULL,
      `descricao` varchar(255) DEFAULT NULL,
      `valor` decimal(10,2) DEFAULT NULL,
      `data_vencimento` date DEFAULT NULL,
      `data_registro` date DEFAULT NULL,
      `categoria` enum('Fixo','Variável') DEFAULT NULL,
      `subcategoria` enum('Despesas Administrativas','Despesas Operacionais') DEFAULT NULL,
      `status` enum('Pendente','Paga') DEFAULT 'Pendente'
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",
    "CREATE TABLE IF NOT EXISTS `formas_pagamento` (
      `id` int(11) NOT NULL,
      `nome` varchar(100) NOT NULL,
      `ativo` tinyint(1) NOT NULL DEFAULT 1
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",
    "CREATE TABLE IF NOT EXISTS `investimentos` (
      `id` int(11) NOT NULL,
      `nome` varchar(100) DEFAULT NULL,
      `tipo` varchar(50) DEFAULT NULL,
      `valor_investido` decimal(10,2) DEFAULT NULL,
      `rentabilidade_esperada` decimal(5,2) DEFAULT NULL,
      `data_investimento` date DEFAULT NULL,
      `status` enum('Ativo','Finalizado') DEFAULT 'Ativo',
      `valor_real` decimal(10,2) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",
    "CREATE TABLE IF NOT EXISTS `kits` (
      `id` int(11) NOT NULL,
      `nome` varchar(100) NOT NULL,
      `valor` decimal(10,2) NOT NULL,
      `componentes` text NOT NULL,
      `observacoes` text NOT NULL,
      `imagem` varchar(255) NOT NULL,
      `status` enum('ativo','inativo') DEFAULT 'ativo',
      `categoria` varchar(50) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",
    "CREATE TABLE IF NOT EXISTS `metas_financeiras` (
      `id` int(11) NOT NULL,
      `descricao` varchar(255) NOT NULL,
      `valor_alvo` decimal(10,2) NOT NULL,
      `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
      `status` enum('Pendente','Concluída') DEFAULT 'Pendente'
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",
    "CREATE TABLE IF NOT EXISTS `notas_fiscais` (
      `id` int(11) NOT NULL,
      `numero_nota` varchar(50) NOT NULL,
      `empresa` varchar(100) NOT NULL,
      `produtos` text NOT NULL,
      `valor` decimal(12,2) NOT NULL,
      `observacao` text DEFAULT NULL,
      `data_cadastro` datetime NOT NULL,
      `frete` decimal(10,2) DEFAULT 0.00
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",
    "CREATE TABLE IF NOT EXISTS `prereservas` (
      `id` int(11) NOT NULL,
      `kit_id` int(11) NOT NULL,
      `data_retirada` date DEFAULT NULL,
      `data_devolucao` date DEFAULT NULL,
      `cliente_id` int(11) NOT NULL,
      `data_agendamento` date NOT NULL,
      `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
      `atendido` tinyint(1) DEFAULT 0
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",
    "CREATE TABLE IF NOT EXISTS `produtos_nota` (
      `id` int(11) NOT NULL,
      `nota_fiscal_id` int(11) NOT NULL,
      `nome` varchar(255) NOT NULL,
      `quantidade` int(11) NOT NULL,
      `valor_unitario` decimal(10,2) NOT NULL,
      `imagem` varchar(255) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",
    "CREATE TABLE IF NOT EXISTS `receitas` (
      `id` int(11) NOT NULL,
      `origem` enum('manual','aluguel') NOT NULL,
      `origem_id` int(11) DEFAULT NULL,
      `descricao` varchar(255) DEFAULT NULL,
      `valor` decimal(10,2) NOT NULL,
      `data_receita` date NOT NULL,
      `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",
    "CREATE TABLE `usuarios` (
      `id` int(11) NOT NULL,
      `nome` varchar(100) NOT NULL,
      `email` varchar(100) NOT NULL,
      `senha` varchar(255) NOT NULL,
      `nivel` enum('admin','gerente','atendente','caixa','financeiro') DEFAULT 'atendente',
      `status` enum('ativo','inativo') DEFAULT 'ativo',
      `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",
    //Primary keys and indexes
    "ALTER TABLE `alugueis`
      ADD PRIMARY KEY (`id`),
      ADD KEY `cliente_id` (`cliente_id`),
      ADD KEY `kit_id` (`kit_id`),
      ADD KEY `forma_pagamento_id` (`forma_pagamento_id`);",
    "ALTER TABLE `endereco`
      ADD PRIMARY KEY (`id`);",
    "ALTER TABLE `clientes`
      ADD PRIMARY KEY (`id`),
      ADD UNIQUE KEY `cpf` (`cpf`),
      ADD UNIQUE KEY `email` (`email`),
      ADD UNIQUE KEY `login` (`login`),
      ADD KEY `endereco_id` (`endereco_id`);",
    "ALTER TABLE `contas_pagar`
      ADD PRIMARY KEY (`id`);",
    "ALTER TABLE `formas_pagamento`
      ADD PRIMARY KEY (`id`);",
    "ALTER TABLE `investimentos`
      ADD PRIMARY KEY (`id`);",
    "ALTER TABLE `kits`
      ADD PRIMARY KEY (`id`);",
    "ALTER TABLE `metas_financeiras`
      ADD PRIMARY KEY (`id`);",
    "ALTER TABLE `notas_fiscais`
      ADD PRIMARY KEY (`id`);",
    "ALTER TABLE `prereservas`
      ADD PRIMARY KEY (`id`),
      ADD KEY `kit_id` (`kit_id`),
      ADD KEY `cliente_id` (`cliente_id`);",
    "ALTER TABLE `produtos_nota`
      ADD PRIMARY KEY (`id`),
      ADD KEY `nota_fiscal_id` (`nota_fiscal_id`);",
    "ALTER TABLE `receitas`
      ADD PRIMARY KEY (`id`);",
    "ALTER TABLE `usuarios`
      ADD PRIMARY KEY (`id`);",
    // Auto increment adição
    "ALTER TABLE `alugueis`
      MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;",
    "ALTER TABLE `clientes`
      MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;",
    "ALTER TABLE `endereco`
      MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;",
    "ALTER TABLE `contas_pagar`
      MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;",
    "ALTER TABLE `formas_pagamento`
      MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;",
    "ALTER TABLE `investimentos`
      MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;",
    "ALTER TABLE `kits`
      MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;",
    "ALTER TABLE `metas_financeiras`
      MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;",
    "ALTER TABLE `notas_fiscais`
      MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;",
    "ALTER TABLE `prereservas`
      MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;",
    "ALTER TABLE `produtos_nota`
      MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;",
    "ALTER TABLE `receitas`
      MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;",
    "ALTER TABLE `usuarios`
      MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;"
  ];
  //inserções para teste do sistema
  $sql_inserts = [
    //inserts
    "INSERT INTO `alugueis` (`id`, `cliente_id`, `kit_id`, `data_retirada`, `data_devolucao`, `forma_pagamento_id`, `desconto`, `acrescimo`, `data_aluguel`, `valor_total`, `atendido`) VALUES
        (1, 1, 1, '2025-07-13', '2025-07-15', 8, 5.00, 0.00, '2025-07-13 13:30:58', 0.00, 0),
        (2, 1, 1, '2025-07-13', '2025-07-15', 8, 8.00, 0.00, '2025-07-13 13:37:03', 0.00, 0),
        (3, 1, 1, '2025-07-13', '2025-07-15', 8, 80.00, 0.00, '2025-07-13 13:48:13', 420.00, 1),
        (4, 1, 2, '2025-07-13', '2025-07-14', 9, 0.00, 90.00, '2025-07-13 14:30:49', 890.00, 1),
        (5, 1, 1, '2025-07-17', '2025-07-21', 10, 0.00, 0.00, '2025-07-13 14:51:58', 1000.00, 1),
        (6, 2, 2, '2025-07-31', '2025-08-08', 16, 0.00, 5.00, '2025-07-13 23:01:16', 6405.00, 1),
        (7, 3, 5, '2025-07-21', '2025-07-22', 10, 0.00, 0.00, '2025-07-14 19:55:40', 138.00, 1),
        (8, 3, 5, '2025-07-25', '2025-07-31', 15, 32.00, 0.00, '2025-07-18 12:01:57', 796.00, 1),
        (9, 1, 4, '2025-07-10', '2025-07-15', 13, 0.00, 25.00, '2025-07-18 12:13:31', 625.00, 1),
        (10, 2, 1, '2025-07-30', '2025-07-31', 8, 0.00, 0.00, '2025-07-18 12:15:56', 250.00, 0),
        (11, 2, 2, '2025-08-17', '2025-08-20', 14, 0.00, 0.00, '2025-07-19 20:15:54', 2400.00, 0);",
    "INSERT INTO `endereco` (`id`, `logradouro`, `numero`, `complemento`, `bairro`, `cidade`, `estado`, `cep`) VALUES
        (1, 'Rua das Flores', '123', 'Apto 101', 'Centro', 'Salvador', 'BA', '40000-000'),
        (2, 'Avenida Brasil', '456', '', 'Barra', 'Salvador', 'BA', '40001-000'),
        (3, 'Rua do Comércio', '789', '', 'Comércio', 'Salvador', 'BA', '40002-000'),
        (4, 'Rua da Alegria', '321', 'Casa 2', 'Liberdade', 'Salvador', 'BA', '40003-000'),
        (5, 'Avenida das Palmeiras', '654', '', 'Pituba', 'Salvador', 'BA', '40004-000');",
    "INSERT INTO `clientes` (`id`, `nome`, `cpf`, `email`, `login`, `senha`, `status`, `endereco_id`, `data_nascimento`, `contato`) VALUES
        (1, 'Élida de Melo Guedes', '46298256194', 'elida@gmail.com', 'elida@hotmail.com', '\$2y\$10\$cuMNqlDsySMLXvfJ..T78emaZN3USUDfUTI5tUCXJIYWf81mtJa4.', 'ativo',1, '2002-08-10', '77991586427'),
        (2, 'Murilo Neri', '75962437469', 'neri@outlook.com', 'neri@outlook.com', '\$2y\$10\$Rd7UyVT8u29tYQgQi/C7lOS09RDiSnd8OyY6KWjdVr3kI4DvfPe1a', 'ativo', 2, '2025-07-03', '55699321569'),
        (3, 'Bruna Farias', '25642382435', 'bruninha.09@gmail.com', 'bruninha.09@gmail.com', '\$2y\$10\$zGjtXphp1G1xumxO9TrKWeONnnkbIGaO3AJ/qhcRpRdeWstFDGIDu', 'ativo', 3, '2004-09-10', '77999551267');",
    "INSERT INTO `contas_pagar` (`id`, `descricao`, `valor`, `data_vencimento`, `data_registro`, `categoria`, `subcategoria`, `status`) VALUES
        (1, 'Aluguel loja sede', 800.00, '2025-07-25', '2025-07-15', 'Fixo', 'Despesas Operacionais', 'Pendente'),
        (2, 'Compra e itens de escritório (canetas e grampos)', 39.50, '2025-07-15', '2025-07-15', 'Variável', 'Despesas Administrativas', 'Paga'),
        (3, 'pagamento de funcionário (Adelmo Santos)', 1518.00, '2025-08-05', '2025-07-15', 'Fixo', 'Despesas Operacionais', 'Pendente'),
        (4, 'Energia depósito num.2', 67.20, '2025-07-20', '2025-07-15', 'Fixo', 'Despesas Operacionais', 'Paga');",

    "INSERT INTO `formas_pagamento` (`id`, `nome`, `ativo`) VALUES
        (8, 'Dinheiro', 1),
        (9, 'Pix', 1),
        (10, 'Cartão de Débito', 1),
        (11, 'Cartão de Crédito à vista', 1),
        (12, 'Cartão de Crédito 2x', 1),
        (13, 'Cartão de Crédito 3x', 1),
        (14, 'Cartão de Crédito 4x', 1),
        (15, 'Cartão de Crédito 5x', 1),
        (16, 'Cartão de Crédito 6x', 1);",

    "INSERT INTO `kits` (`id`, `nome`, `valor`, `componentes`, `observacoes`, `imagem`, `status`, `categoria`) VALUES
        (1, 'moana', 250.00, 'paineis, mesas, bolo', 'kit nunca utilizado ainda', '', 'ativo', 'premium'),
        (2, 'princesas disney', 800.00, 'paineis, mesas, bolo, balões', 'fhdhdjdjkkjdsjk', '68733076874b3_Pegue monte CADASTRO DE FUNCIONARIOS GERENTE.jpg', 'ativo', 'super premuim'),
        (3, 'carros', 262.00, 'paineis, arco de balões, toalhas de mesa, centros de mesa', 'infantojuvenil', 'img_687543eb210354.31637372.jpg', 'ativo', 'premium'),
        (4, 'florida', 120.00, 'mesas de bolo/doces, arco de flores, arranjo flores, bolo fake', 'facil montagem', 'img_687543f434ee63.56573725.jpg', 'ativo', 'basico'),
        (5, 'Arraiá junino', 138.00, 'mesas de bolo/doces, arco de flores, arranjo flores, bolo fake', 'festa junina\r\nsão joão', 'img_6875449bd400c9.40165964.jpg', 'ativo', 'basico');",

    "INSERT INTO `metas_financeiras` (`id`, `descricao`, `valor_alvo`, `data_criacao`, `status`) VALUES
        (1, 'Meta de alugueis primeira semana de agosto', 8000.00, '2025-07-19 02:21:48', 'Pendente'),
        (2, 'Meta mes de julho', 8500.00, '2025-07-19 02:22:23', 'Pendente'),
        (3, 'meta julho', 5000.00, '2025-07-19 02:23:27', 'Concluída');",

    "INSERT INTO `notas_fiscais` (`id`, `numero_nota`, `empresa`, `produtos`, `valor`, `observacao`, `data_cadastro`, `frete`) VALUES
        (1, '26', 'DecorTudo', 'mesas convidados - 5 x R$ 35,00 = R$ 175,00\nbuques deflores artificiais (margaridas) - 8 x R$ 29,85 = R$ 238,80\n', 413.80, '', '2025-07-13 23:17:38', 0.00),
        (2, '01', 'DecorTudo', 'toalha de mesa cetim dourado - 150 x R$ 9,52 = R$ 1.428,00\npainel branca de neve  - 1 x R$ 52,16 = R$ 52,16\narco decorativo - 8 x R$ 24,87 = R$ 198,96\n', 1713.72, 'Conferido pela colaboradora Aline', '2025-07-13 23:30:43', 34.60),
        (3, '08', 'DecorTudo', 'Produtos salvos separadamente', 184.67, 'conferido por Edilson', '2025-07-14 15:08:59', 34.60),
        (4, '06', 'DecorTudo', 'Produtos salvos separadamente', 388.56, 'conferido por Adelmo', '2025-07-14 19:57:14', 50.00);",

    "INSERT INTO `prereservas` (`id`, `kit_id`, `data_retirada`, `data_devolucao`, `cliente_id`, `data_agendamento`, `criado_em`, `atendido`) VALUES
        (2, 5, NULL, NULL, 1, '2025-08-08', '2025-07-16 17:51:26', 0),
        (3, 4, NULL, NULL, 1, '2025-07-17', '2025-07-16 17:57:11', 0);",

    "INSERT INTO `produtos_nota` (`id`, `nota_fiscal_id`, `nome`, `quantidade`, `valor_unitario`, `imagem`) VALUES
        (1, 3, 'painel carros', 1, 35.00, NULL),
        (2, 3, 'mesas de doces', 3, 22.64, NULL),
        (3, 3, 'bolo fake carros 3 andares', 1, 18.44, NULL),
        (4, 3, 'arco/suporte balões', 3, 9.57, NULL),
        (5, 4, 'arranjo de flores artificiais amarelas', 15, 12.00, NULL),
        (6, 4, 'mesas convidados', 8, 19.82, NULL);",

    "INSERT INTO `receitas` (`id`, `origem`, `origem_id`, `descricao`, `valor`, `data_receita`, `criado_em`) VALUES
        (1, 'aluguel', 3, NULL, 420.00, '2025-07-13', '2025-07-15 19:57:20'),
        (2, 'aluguel', 4, NULL, 890.00, '2025-07-13', '2025-07-15 19:57:39'),
        (3, 'aluguel', 5, NULL, 1000.00, '2025-07-17', '2025-07-21 19:57:39'),
        (4, 'manual', NULL, 'Doação', 120.00, '2025-07-20', '2025-07-21 19:57:39');",

      "INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `nivel`, `status`, `criado_em`) VALUES
        (1, 'gerente', 'gerente@decoracerto.com', '\$2y$10\$J1wU.OOLPI/h3dhfeUrM6.apNzbMGGiumXlUKUSv6kIQOnu9X/UP6', 'gerente', 'ativo', '2025-07-19 03:00:00'),
        (2, 'atendente', 'atendente@decoracerto.com', '\$2y$10\$J1wU.OOLPI/h3dhfeUrM6.apNzbMGGiumXlUKUSv6kIQOnu9X/UP6', 'atendente', 'ativo', '2025-07-19 03:00:00'),
        (3, 'caixa', 'caixa@decoracerto.com', '\$2y\$10\$J1wU.OOLPI/h3dhfeUrM6.apNzbMGGiumXlUKUSv6kIQOnu9X/UP6', 'caixa', 'ativo', '2025-07-19 03:00:00'),
        (4, 'financeiro', 'financeiro@decoracerto.com', '\$2y\$10\$J1wU.OOLPI/h3dhfeUrM6.apNzbMGGiumXlUKUSv6kIQOnu9X/UP6', 'financeiro', 'ativo', '2025-07-19 03:00:00'),
        (5, 'elida', 'elida@teste.com', '\$2y\$10\$J1wU.OOLPI/h3dhfeUrM6.apNzbMGGiumXlUKUSv6kIQOnu9X/UP6', 'financeiro', 'ativo', '2025-08-22 02:31:01'),
        (6, 'bruna', 'gerentebruna@teste.com', '\$2y\$10\$J1wU.OOLPI/h3dhfeUrM6.apNzbMGGiumXlUKUSv6kIQOnu9X/UP6', 'gerente', 'ativo', '2025-08-22 02:39:51');"

  ];
  $sql = "CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
  if ($conn->query($sql) === TRUE) {
    echo "Banco de dados '" . DB_NAME . "' criado com sucesso!<br>";
  } else {
    die("Erro ao criar banco: " . $conn->error);
  }
  $conn->select_db(DB_NAME);
  if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
  }
  // Nova conexão já com o banco
  foreach ($sql_cmd as $index => $sql) {
    if (Alterar_tabela($conn, $sql, $index)) {
      executar_sql($conn, $sql, $index);
    } else {
      echo "Comando {$index} ignorado.<br>";
    }
  }
  if (!$fazer_insercoes) return;
  foreach ($sql_inserts as $index => $sql) {
    executar_sql($conn, $sql, $index);
  }
}
function executar_sql($conn = null, $sql = "", $index = 0)
{
  if (mysqli_query($conn, $sql)) {
    echo "Comando {$index} executado com sucesso.<br>";
  } else {
    echo "Erro no comando {$index}: " . mysqli_error($conn) . "<br>";
  }
}
function Alterar_tabela($conn = null, $sql = "", $index = 0)
{
  $sqlTrim = trim($sql);
  if (preg_match('/^ALTER TABLE\s+`?(\w+)`?.*ADD (PRIMARY KEY|KEY) `?(\w+)`?/i', $sqlTrim, $matches)) {
    $tabela = $matches[1];
    $tipoChave = strtoupper($matches[2]); // PRIMARY KEY ou KEY
    $nomeChave = $matches[3];
    // Se for PRIMARY KEY, o nome da chave sempre é 'PRIMARY' no MySQL
    if ($tipoChave === 'PRIMARY KEY') {
      $nomeChave = 'PRIMARY';
    }
    // Verifica se já existe essa chave/índice na tabela
    $checkSql = "SHOW INDEX FROM `$tabela` WHERE Key_name = '$nomeChave'";
    $result = mysqli_query($conn, $checkSql);
    if ($result && mysqli_num_rows($result) > 0) {
      echo "Índice/chave '{$nomeChave}' já existe na tabela '{$tabela}'. Comando {$index} ignorado.<br>";
      return false;
    }
    return true;
  }
  return true; // Se não for um comando ALTER TABLE, executa normalmente
}
