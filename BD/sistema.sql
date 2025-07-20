-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 20/07/2025 às 04:49
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sistema`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `alugueis`
--

CREATE TABLE `alugueis` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `alugueis`
--

INSERT INTO `alugueis` (`id`, `cliente_id`, `kit_id`, `data_retirada`, `data_devolucao`, `forma_pagamento_id`, `desconto`, `acrescimo`, `data_aluguel`, `valor_total`, `atendido`) VALUES
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
(11, 2, 2, '2025-08-17', '2025-08-20', 14, 0.00, 0.00, '2025-07-19 20:15:54', 2400.00, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `login` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `status` enum('ativo','inativo') DEFAULT 'ativo',
  `endereco` varchar(255) NOT NULL,
  `data_nascimento` date NOT NULL,
  `contato` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `clientes`
--

INSERT INTO `clientes` (`id`, `nome`, `cpf`, `email`, `login`, `senha`, `status`, `endereco`, `data_nascimento`, `contato`) VALUES
(1, 'Élida de Melo Guedes', '46298256194', 'elida@gmail.com', 'elida@hotmail.com', '$2y$10$cuMNqlDsySMLXvfJ..T78emaZN3USUDfUTI5tUCXJIYWf81mtJa4.', 'ativo', 'ibotirama', '2002-08-10', '77991586427'),
(2, 'Murilo Neri', '75962437469', 'neri@outlook.com', 'neri@outlook.com', '$2y$10$Rd7UyVT8u29tYQgQi/C7lOS09RDiSnd8OyY6KWjdVr3kI4DvfPe1a', 'ativo', 'Galegos', '2025-07-03', '55699321569'),
(3, 'Bruna Farias', '25642382435', 'bruninha.09@gmail.com', 'bruninha.09@gmail.com', '$2y$10$zGjtXphp1G1xumxO9TrKWeONnnkbIGaO3AJ/qhcRpRdeWstFDGIDu', 'ativo', 'Bom Jesus da Lapa', '2004-09-10', '77999551267');

-- --------------------------------------------------------

--
-- Estrutura para tabela `contas_pagar`
--

CREATE TABLE `contas_pagar` (
  `id` int(11) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `data_vencimento` date DEFAULT NULL,
  `data_registro` date DEFAULT NULL,
  `categoria` enum('Fixo','Variável') DEFAULT NULL,
  `subcategoria` enum('Despesas Administrativas','Despesas Operacionais') DEFAULT NULL,
  `status` enum('Pendente','Paga') DEFAULT 'Pendente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `contas_pagar`
--

INSERT INTO `contas_pagar` (`id`, `descricao`, `valor`, `data_vencimento`, `data_registro`, `categoria`, `subcategoria`, `status`) VALUES
(1, 'Aluguel loja sede', 800.00, '2025-07-25', '2025-07-15', 'Fixo', 'Despesas Operacionais', 'Pendente'),
(2, 'Compra e itens de escritório (canetas e grampos)', 39.50, '2025-07-15', '2025-07-15', 'Variável', 'Despesas Administrativas', 'Paga'),
(3, 'pagamento de funcionário (Adelmo Santos)', 1518.00, '2025-08-05', '2025-07-15', 'Fixo', 'Despesas Operacionais', 'Pendente'),
(4, 'Energia depósito num.2', 67.20, '2025-07-20', '2025-07-15', 'Fixo', 'Despesas Operacionais', 'Paga');

-- --------------------------------------------------------

--
-- Estrutura para tabela `formas_pagamento`
--

CREATE TABLE `formas_pagamento` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `formas_pagamento`
--

INSERT INTO `formas_pagamento` (`id`, `nome`, `ativo`) VALUES
(8, 'Dinheiro', 1),
(9, 'Pix', 1),
(10, 'Cartão de Débito', 1),
(11, 'Cartão de Crédito à vista', 1),
(12, 'Cartão de Crédito 2x', 1),
(13, 'Cartão de Crédito 3x', 1),
(14, 'Cartão de Crédito 4x', 1),
(15, 'Cartão de Crédito 5x', 1),
(16, 'Cartão de Crédito 6x', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `investimentos`
--

CREATE TABLE `investimentos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `valor_investido` decimal(10,2) DEFAULT NULL,
  `rentabilidade_esperada` decimal(5,2) DEFAULT NULL,
  `data_investimento` date DEFAULT NULL,
  `status` enum('Ativo','Finalizado') DEFAULT 'Ativo',
  `valor_real` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `kits`
--

CREATE TABLE `kits` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `componentes` text NOT NULL,
  `observacoes` text NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `status` enum('ativo','inativo') DEFAULT 'ativo',
  `categoria` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `kits`
--

INSERT INTO `kits` (`id`, `nome`, `valor`, `componentes`, `observacoes`, `imagem`, `status`, `categoria`) VALUES
(1, 'moana', 250.00, 'paineis, mesas, bolo', 'kit nunca utilizado ainda', '', 'ativo', 'premium'),
(2, 'princesas disney', 800.00, 'paineis, mesas, bolo, balões', 'fhdhdjdjkkjdsjk', '68733076874b3_Pegue monte CADASTRO DE FUNCIONARIOS GERENTE.jpg', 'ativo', 'super premuim'),
(3, 'carros', 262.00, 'paineis, arco de balões, toalhas de mesa, centros de mesa', 'infantojuvenil', 'img_687543eb210354.31637372.jpg', 'ativo', 'premium'),
(4, 'florida', 120.00, 'mesas de bolo/doces, arco de flores, arranjo flores, bolo fake', 'facil montagem', 'img_687543f434ee63.56573725.jpg', 'ativo', 'basico'),
(5, 'Arraiá junino', 138.00, 'mesas de bolo/doces, arco de flores, arranjo flores, bolo fake', 'festa junina\r\nsão joão', 'img_6875449bd400c9.40165964.jpg', 'ativo', 'basico');

-- --------------------------------------------------------

--
-- Estrutura para tabela `metas_financeiras`
--

CREATE TABLE `metas_financeiras` (
  `id` int(11) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `valor_alvo` decimal(10,2) NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pendente','Concluída') DEFAULT 'Pendente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `metas_financeiras`
--

INSERT INTO `metas_financeiras` (`id`, `descricao`, `valor_alvo`, `data_criacao`, `status`) VALUES
(1, 'Meta de alugueis primeira semana de agosto', 8000.00, '2025-07-19 02:21:48', 'Pendente'),
(2, 'Meta mes de julho', 8500.00, '2025-07-19 02:22:23', 'Pendente'),
(3, 'meta julho', 5000.00, '2025-07-19 02:23:27', 'Concluída');

-- --------------------------------------------------------

--
-- Estrutura para tabela `notas_fiscais`
--

CREATE TABLE `notas_fiscais` (
  `id` int(11) NOT NULL,
  `numero_nota` varchar(50) NOT NULL,
  `empresa` varchar(100) NOT NULL,
  `produtos` text NOT NULL,
  `valor` decimal(12,2) NOT NULL,
  `observacao` text DEFAULT NULL,
  `data_cadastro` datetime NOT NULL,
  `frete` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `notas_fiscais`
--

INSERT INTO `notas_fiscais` (`id`, `numero_nota`, `empresa`, `produtos`, `valor`, `observacao`, `data_cadastro`, `frete`) VALUES
(1, '26', 'DecorTudo', 'mesas convidados - 5 x R$ 35,00 = R$ 175,00\nbuques deflores artificiais (margaridas) - 8 x R$ 29,85 = R$ 238,80\n', 413.80, '', '2025-07-13 23:17:38', 0.00),
(2, '01', 'DecorTudo', 'toalha de mesa cetim dourado - 150 x R$ 9,52 = R$ 1.428,00\npainel branca de neve  - 1 x R$ 52,16 = R$ 52,16\narco decorativo - 8 x R$ 24,87 = R$ 198,96\n', 1713.72, 'Conferido pela colaboradora Aline', '2025-07-13 23:30:43', 34.60),
(3, '08', 'DecorTudo', 'Produtos salvos separadamente', 184.67, 'conferido por Edilson', '2025-07-14 15:08:59', 34.60),
(4, '06', 'DecorTudo', 'Produtos salvos separadamente', 388.56, 'conferido por Adelmo', '2025-07-14 19:57:14', 50.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `prereservas`
--

CREATE TABLE `prereservas` (
  `id` int(11) NOT NULL,
  `kit_id` int(11) NOT NULL,
  `data_retirada` date DEFAULT NULL,
  `data_devolucao` date DEFAULT NULL,
  `cliente_id` int(11) NOT NULL,
  `data_agendamento` date NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `atendido` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `prereservas`
--

INSERT INTO `prereservas` (`id`, `kit_id`, `data_retirada`, `data_devolucao`, `cliente_id`, `data_agendamento`, `criado_em`, `atendido`) VALUES
(2, 5, NULL, NULL, 1, '2025-08-08', '2025-07-16 17:51:26', 0),
(3, 4, NULL, NULL, 1, '2025-07-17', '2025-07-16 17:57:11', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos_nota`
--

CREATE TABLE `produtos_nota` (
  `id` int(11) NOT NULL,
  `nota_fiscal_id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `valor_unitario` decimal(10,2) NOT NULL,
  `imagem` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos_nota`
--

INSERT INTO `produtos_nota` (`id`, `nota_fiscal_id`, `nome`, `quantidade`, `valor_unitario`, `imagem`) VALUES
(1, 3, 'painel carros', 1, 35.00, NULL),
(2, 3, 'mesas de doces', 3, 22.64, NULL),
(3, 3, 'bolo fake carros 3 andares', 1, 18.44, NULL),
(4, 3, 'arco/suporte balões', 3, 9.57, NULL),
(5, 4, 'arranjo de flores artificiais amarelas', 15, 12.00, NULL),
(6, 4, 'mesas convidados', 8, 19.82, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `receitas`
--

CREATE TABLE `receitas` (
  `id` int(11) NOT NULL,
  `origem` enum('manual','aluguel') NOT NULL,
  `origem_id` int(11) DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `valor` decimal(10,2) NOT NULL,
  `data_receita` date NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `receitas`
--

INSERT INTO `receitas` (`id`, `origem`, `origem_id`, `descricao`, `valor`, `data_receita`, `criado_em`) VALUES
(1, 'aluguel', 3, NULL, 420.00, '2025-07-13', '2025-07-15 19:57:20'),
(2, 'aluguel', 4, NULL, 890.00, '2025-07-13', '2025-07-15 19:57:20'),
(3, 'aluguel', 6, NULL, 6405.00, '2025-07-13', '2025-07-15 19:57:20'),
(4, 'manual', NULL, 'Retorno de investimento', 413.80, '2025-07-24', '2025-07-15 20:05:53');

-- --------------------------------------------------------

--
-- Estrutura para tabela `riscos`
--

CREATE TABLE `riscos` (
  `id` int(11) NOT NULL,
  `descricao` text NOT NULL,
  `impacto_estimado` decimal(12,2) NOT NULL DEFAULT 0.00,
  `data_registro` date NOT NULL,
  `criado_em` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `alugueis`
--
ALTER TABLE `alugueis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_id` (`cliente_id`),
  ADD KEY `kit_id` (`kit_id`),
  ADD KEY `forma_pagamento_id` (`forma_pagamento_id`);

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf` (`cpf`);

--
-- Índices de tabela `contas_pagar`
--
ALTER TABLE `contas_pagar`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `formas_pagamento`
--
ALTER TABLE `formas_pagamento`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `investimentos`
--
ALTER TABLE `investimentos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `kits`
--
ALTER TABLE `kits`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `metas_financeiras`
--
ALTER TABLE `metas_financeiras`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `notas_fiscais`
--
ALTER TABLE `notas_fiscais`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero_nota` (`numero_nota`,`empresa`);

--
-- Índices de tabela `prereservas`
--
ALTER TABLE `prereservas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kit_id` (`kit_id`),
  ADD KEY `cliente_id` (`cliente_id`);

--
-- Índices de tabela `produtos_nota`
--
ALTER TABLE `produtos_nota`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nota_fiscal_id` (`nota_fiscal_id`);

--
-- Índices de tabela `receitas`
--
ALTER TABLE `receitas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `origem_id` (`origem_id`);

--
-- Índices de tabela `riscos`
--
ALTER TABLE `riscos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `alugueis`
--
ALTER TABLE `alugueis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `contas_pagar`
--
ALTER TABLE `contas_pagar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `formas_pagamento`
--
ALTER TABLE `formas_pagamento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `investimentos`
--
ALTER TABLE `investimentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `kits`
--
ALTER TABLE `kits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `metas_financeiras`
--
ALTER TABLE `metas_financeiras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `notas_fiscais`
--
ALTER TABLE `notas_fiscais`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `prereservas`
--
ALTER TABLE `prereservas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `produtos_nota`
--
ALTER TABLE `produtos_nota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `receitas`
--
ALTER TABLE `receitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `riscos`
--
ALTER TABLE `riscos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `alugueis`
--
ALTER TABLE `alugueis`
  ADD CONSTRAINT `alugueis_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `alugueis_ibfk_2` FOREIGN KEY (`kit_id`) REFERENCES `kits` (`id`),
  ADD CONSTRAINT `alugueis_ibfk_3` FOREIGN KEY (`forma_pagamento_id`) REFERENCES `formas_pagamento` (`id`);

--
-- Restrições para tabelas `prereservas`
--
ALTER TABLE `prereservas`
  ADD CONSTRAINT `prereservas_ibfk_1` FOREIGN KEY (`kit_id`) REFERENCES `kits` (`id`),
  ADD CONSTRAINT `prereservas_ibfk_2` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`);

--
-- Restrições para tabelas `produtos_nota`
--
ALTER TABLE `produtos_nota`
  ADD CONSTRAINT `produtos_nota_ibfk_1` FOREIGN KEY (`nota_fiscal_id`) REFERENCES `notas_fiscais` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
