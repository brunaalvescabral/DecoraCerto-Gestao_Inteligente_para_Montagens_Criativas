-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 25/07/2025 às 23:14
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
(1, 1, 1, '2025-07-13', '2025-07-15', 8, 5.00, 0.00, '2025-07-13 13:30:58', 0.00, 1),
(2, 1, 1, '2025-07-13', '2025-07-15', 8, 8.00, 0.00, '2025-07-13 13:37:03', 0.00, 1),
(3, 1, 1, '2025-07-13', '2025-07-15', 8, 80.00, 0.00, '2025-07-13 13:48:13', 420.00, 1),
(4, 1, 2, '2025-07-13', '2025-07-14', 9, 0.00, 90.00, '2025-07-13 14:30:49', 890.00, 1),
(5, 1, 1, '2025-07-17', '2025-07-21', 10, 0.00, 0.00, '2025-07-13 14:51:58', 1000.00, 1),
(6, 2, 2, '2025-07-31', '2025-08-08', 16, 0.00, 5.00, '2025-07-13 23:01:16', 6405.00, 1),
(7, 3, 5, '2025-07-21', '2025-07-22', 10, 0.00, 0.00, '2025-07-14 19:55:40', 138.00, 1),
(8, 3, 5, '2025-07-25', '2025-07-31', 15, 32.00, 0.00, '2025-07-18 12:01:57', 796.00, 1),
(9, 1, 4, '2025-07-10', '2025-07-15', 13, 0.00, 25.00, '2025-07-18 12:13:31', 625.00, 1),
(10, 2, 1, '2025-07-30', '2025-07-31', 8, 0.00, 0.00, '2025-07-18 12:15:56', 250.00, 1),
(11, 2, 2, '2025-08-17', '2025-08-20', 14, 0.00, 0.00, '2025-07-19 20:15:54', 2400.00, 1),
(12, 11, 44, '2025-05-06', '2025-05-09', 9, 8.00, 0.00, '2025-07-20 22:54:14', 400.00, 1),
(13, 16, 3, '2025-05-07', '2025-05-12', 8, 60.00, 0.00, '2025-07-20 22:55:02', 1250.00, 1),
(14, 4, 25, '2025-05-01', '2025-05-03', 11, 6.00, 0.00, '2025-07-20 22:55:28', 270.00, 1),
(15, 19, 11, '2025-05-09', '2025-05-12', 12, 0.00, 3.00, '2025-07-20 22:56:30', 270.00, 0),
(16, 3, 34, '2025-05-02', '2025-05-05', 11, 0.00, 0.00, '2025-07-20 22:57:04', 375.00, 1),
(17, 19, 14, '2025-05-09', '2025-05-12', 10, 18.00, 0.00, '2025-07-20 22:57:47', 720.00, 1),
(18, 18, 46, '2025-05-17', '2025-05-20', 10, 37.00, 0.00, '2025-07-20 22:58:32', 440.00, 1),
(19, 17, 18, '2025-05-19', '2025-05-23', 13, 0.00, 0.00, '2025-07-20 22:59:12', 1556.00, 1),
(20, 8, 40, '2025-05-19', '2025-05-23', 12, 0.00, 0.00, '2025-07-20 22:59:36', 624.00, 1),
(21, 14, 30, '2025-05-21', '2025-05-23', 8, 18.00, 0.00, '2025-07-20 23:00:13', 300.00, 0),
(22, 13, 5, '2025-05-23', '2025-05-27', 12, 2.00, 0.00, '2025-07-20 23:01:49', 550.00, 1),
(23, 7, 36, '2025-05-23', '2025-05-27', 12, 0.00, 0.00, '2025-07-20 23:02:14', 556.00, 1),
(24, 9, 4, '2025-05-23', '2025-05-27', 11, 25.00, 0.00, '2025-07-20 23:02:41', 455.00, 1),
(25, 12, 21, '2025-05-26', '2025-05-30', 11, 27.00, 0.00, '2025-07-20 23:03:26', 645.00, 1),
(26, 15, 44, '2025-05-26', '2025-05-30', 9, 34.00, 0.00, '2025-07-20 23:03:56', 510.00, 1),
(27, 10, 42, '2025-05-26', '2025-05-30', 15, 0.00, 0.00, '2025-07-20 23:04:22', 756.00, 1),
(28, 15, 29, '2025-05-26', '2025-05-30', 16, 0.00, 0.00, '2025-07-20 23:04:49', 744.00, 1),
(29, 7, 13, '2025-05-26', '2025-05-30', 10, 21.00, 0.00, '2025-07-20 23:05:25', 615.00, 1),
(30, 7, 31, '2025-05-26', '2025-05-30', 10, 0.00, 0.00, '2025-07-20 23:05:40', 636.00, 1),
(31, 1, 18, '2025-05-27', '2025-05-29', 11, 28.00, 0.00, '2025-07-20 23:06:14', 750.00, 1),
(32, 6, 18, '2025-05-14', '2025-05-17', 14, 0.00, 3.00, '2025-07-20 23:07:03', 1170.00, 1),
(33, 4, 3, '2025-05-30', '2025-06-02', 14, 0.00, 0.00, '2025-07-20 23:07:42', 786.00, 1),
(34, 4, 18, '2025-05-30', '2025-06-02', 12, 0.00, 0.00, '2025-07-20 23:08:06', 1167.00, 1),
(35, 13, 31, '2025-05-30', '2025-06-02', 12, 0.00, 0.00, '2025-07-20 23:08:20', 477.00, 1),
(36, 3, 34, '2025-06-01', '2025-06-04', 10, 5.00, 0.00, '2025-07-20 23:08:49', 370.00, 0),
(37, 9, 30, '2025-06-03', '2025-06-06', 10, 0.00, 0.00, '2025-07-20 23:09:23', 477.00, 1),
(38, 8, 40, '2025-06-03', '2025-06-05', 8, 0.00, 0.00, '2025-07-20 23:09:49', 312.00, 1),
(39, 17, 24, '2025-06-03', '2025-06-05', 8, 0.00, 0.00, '2025-07-20 23:10:09', 178.00, 1),
(40, 16, 6, '2025-06-05', '2025-06-07', 8, 26.00, 0.00, '2025-07-20 23:10:39', 470.00, 1),
(41, 15, 8, '2025-06-05', '2025-06-07', 8, 0.00, 0.00, '2025-07-20 23:11:00', 306.00, 1),
(42, 13, 45, '2025-06-06', '2025-06-09', 10, 0.00, 0.00, '2025-07-20 23:11:28', 381.00, 1),
(43, 6, 17, '2025-06-06', '2025-06-09', 8, 0.00, 0.00, '2025-07-20 23:11:49', 246.00, 1),
(44, 15, 12, '2025-06-08', '2025-06-10', 8, 0.00, 0.00, '2025-07-20 23:12:12', 276.00, 1),
(45, 11, 32, '2025-06-09', '2025-06-12', 12, 0.00, 0.00, '2025-07-20 23:12:37', 534.00, 1),
(46, 14, 9, '2025-06-10', '2025-06-14', 15, 4.00, 0.00, '2025-07-20 23:13:11', 1100.00, 1),
(47, 8, 35, '2025-06-10', '2025-06-12', 12, 0.00, 0.00, '2025-07-20 23:13:40', 318.00, 1),
(48, 3, 2, '2025-06-10', '2025-06-12', 15, 0.00, 0.00, '2025-07-20 23:14:06', 1600.00, 1),
(49, 12, 10, '2025-06-10', '2025-06-12', 13, 0.00, 0.00, '2025-07-20 23:14:36', 540.00, 1),
(50, 1, 33, '2025-06-10', '2025-06-13', 10, 0.00, 0.00, '2025-07-20 23:15:04', 375.00, 0),
(51, 10, 26, '2025-06-10', '2025-06-13', 9, 16.00, 0.00, '2025-07-20 23:15:27', 350.00, 1),
(52, 4, 23, '2025-06-10', '2025-06-14', 9, 29.00, 0.00, '2025-07-20 23:16:14', 675.00, 1),
(53, 14, 20, '2025-06-12', '2025-06-14', 9, 0.00, 0.00, '2025-07-20 23:16:37', 360.00, 1),
(54, 18, 17, '2025-06-12', '2025-06-14', 9, 0.00, 0.00, '2025-07-20 23:16:52', 164.00, 1),
(55, 10, 22, '2025-06-12', '2025-06-16', 14, 0.00, 0.00, '2025-07-20 23:17:14', 704.00, 0),
(56, 17, 42, '2025-06-13', '2025-06-16', 10, 17.00, 0.00, '2025-07-20 23:17:50', 550.00, 1),
(57, 14, 25, '2025-06-13', '2025-06-16', 10, 0.00, 0.00, '2025-07-20 23:18:06', 414.00, 1),
(58, 16, 8, '2025-06-13', '2025-06-16', 8, 0.00, 0.00, '2025-07-20 23:18:27', 459.00, 0),
(59, 10, 29, '2025-06-13', '2025-06-16', 8, 0.00, 0.00, '2025-07-20 23:18:41', 558.00, 1);

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
(3, 'Bruna Farias', '25642382435', 'bruninha.09@gmail.com', 'bruninha.09@gmail.com', '$2y$10$zGjtXphp1G1xumxO9TrKWeONnnkbIGaO3AJ/qhcRpRdeWstFDGIDu', 'ativo', 'Bom Jesus da Lapa', '2004-09-10', '77999551267'),
(4, 'Aline Carneiro Dias', '56315632516', 'a.line_dias@hotmail.com', 'a.line_dias@hotmail.com', '$2y$10$uyDLoLER8Kl0vSoBZaIJ7eUVUUOTSdNQptnxdOwpmI/o9IBT/upEa', 'ativo', 'Brejo Velho', '1999-04-10', '77998654133'),
(5, 'Aline Carneiro Dias', '56315632519', 'a.line_dias@hotmail.com', 'a.line_dias@hotmail.com', '$2y$10$Q/nxX097g.60cqY90u8LOuEamKQZwMKC9PvIrgyvlkaKqD8JwpiBG', 'ativo', 'Brejo Velho', '1999-04-10', '77998654133'),
(6, 'Luana Vitória Gomes', '45795216740', 'lua_gomes@gmail.com', 'lua_gomes@gmail.com', '$2y$10$pUOS7SdZVbx5Ss.L/rPD8O1QHfO6NUFOajcReMcg/9EOcXFNkFhfa', 'ativo', 'Bom Jesus da Lapa', '2001-09-17', '77999452186'),
(7, 'João Silva', '48310924834', 'joaos@gmail.com', 'joaos@gmail.com', '$2y$10$dKJWV8fjm00QrPTE8G/fw.YhxD3f8ndSIbh3mwOOIxkZTMpfmITSS', 'ativo', 'Bom Jesus da Lapa', '1986-03-05', '77999452186'),
(8, 'Ana Julia Campos Monte', '45161597204', 'camposjulia_03@hotmail.com', 'camposjulia_03@hotmail.com', '$2y$10$pYJDN12B8Axr1dJsHZF5yuC2zA8wbwWNx14BsMTt/eKa1d/yb0dPm', 'ativo', 'Ibotirama', '2005-01-01', '77998245688'),
(9, 'Jerusa Antonia Melo', '71255930159', 'jerusa@outlook.com', 'jerusa@outlook.com', '$2y$10$./uiAGXkYvEh/CyrRAU5Ke8XZ4OD/58J3dgi7Q05m95hsl7L4Nwc.', 'ativo', 'Ibotirama', '1982-06-04', '77998215649'),
(10, 'Jonas Martins Costa', '64294310294', 'jonamaco.83@outlook.com', 'jonamaco.83@outlook.com', '$2y$10$pCIs5tRE81d1xsS88kmMDe.axo1YRCMBlTiHab.s7rNzqNAS/.ajy', 'ativo', 'Bom Jesus da Lapa', '1983-12-26', '77994621563'),
(11, 'Anderson Freitas Martins', '23154623632', 'freitanderson@hotmail.com', 'freitanderson@hotmail.com', '$2y$10$Fwr98cqu3Nc4PLPXzaK8leQ4K9Mc7uQRkSTPFM73heQZZXaJQEc/C', 'ativo', 'Brejo Velho', '2003-11-06', '77999452106'),
(12, 'Joaquim Matos Souza', '58213946246', 'jomaso@gmail.com', 'jomaso@gmail.com', '$2y$10$lCy.p59vinPQhFbXe91N9.kI91LykOoqTWhZalJDAaexcNsjnmQAG', 'ativo', 'Brejo Velho', '1978-12-10', '77998546310'),
(13, 'Arlindo Costa Rodrigues', '46279233594', 'Arlindocosta@gmail.com', 'Arlindocosta@gmail.com', '$2y$10$h7.DkHQG/ySSJr94ZI3zi..yDFVOgiIhT6KabzTu3F1PV9HV7u63K', 'ativo', 'Brejo Velho', '1985-05-03', '77999456210'),
(14, 'Antonio Meira Santos', '54963215673', 'antoniosts.20@hotmail.com', 'antoniosts.20@hotmail.com', '$2y$10$xZIEdYTuIJn8ddyem12L8.qOAZyAGyLY5UjMWuveif5AeEJHImFoa', 'ativo', 'Galegos', '1975-02-08', '77999156420'),
(15, 'Maria José da Costa Pereira', '45201369712', 'mariaper.5@gmail.com', 'mariaper.5@gmail.com', '$2y$10$Oo3rXlgVvbf0Gx//QqYmyeJVBOQ3ekiS4Cfnbo/UIwFMrcBfmJQT6', 'ativo', 'ibotirama', '1968-10-12', '77991654230'),
(16, 'Janaina Pinto Souza', '45230164925', 'janasouza@outlook.com', 'janasouza@outlook.com', '$2y$10$XNXkZLU6.Shr2TclprBsneOE4jutArB3u6wUwTFeBOvffWzO6eJC2', 'ativo', 'ibotirama', '1986-12-22', '77991543286'),
(17, 'Helena Rodrigues Melo', '51230456921', 'Helenrodrigues@gmail.com', 'Helenrodrigues@gmail.com', '$2y$10$LwM/1dN.q0mxZFZSvDipx.0GpujVI5FGWZ0Vt2TFHaQQUskiQyx3W', 'ativo', 'Paratinga', '2002-11-05', '77991254636'),
(18, 'Gabriela Almeida Santos', '45210359812', 'gabists_0412@outlook.com', 'gabists_0412@outlook.com', '$2y$10$NZst49K2pMRw8Bh0PDsJ2.Izvgn3qwocbI..FdDWRCUyxAClT1ydu', 'ativo', 'Paratinga', '1995-07-15', '77991568421'),
(19, 'Milena Oliveira Gomes', '45210367895', 'mi.lenaGo@hotmail.com', 'mi.lenaGo@hotmail.com', '$2y$10$IdjdQKVeUNWC/E6vBVMCve8rykIcBEfcbmUiGKSZtUUw2e0OIBxRy', 'ativo', 'Brejo Velho', '2001-12-15', '77999654216');

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
(1, 'Aluguel loja sede', 800.00, '2025-07-25', '2025-07-15', 'Fixo', 'Despesas Operacionais', 'Paga'),
(2, 'Compra e itens de escritório (canetas e grampos)', 39.50, '2025-07-15', '2025-07-15', 'Variável', 'Despesas Administrativas', 'Paga'),
(3, 'pagamento de funcionário (Adelmo Santos)', 1518.00, '2025-08-05', '2025-07-15', 'Fixo', 'Despesas Operacionais', 'Paga'),
(4, 'Energia depósito num.2', 67.20, '2025-07-20', '2025-07-15', 'Fixo', 'Despesas Operacionais', 'Paga'),
(5, 'Pagamento de conta de energia depósito 1', 118.90, '2025-05-20', '2025-05-19', 'Variável', 'Despesas Operacionais', 'Paga'),
(6, 'Pagamento de conta de energia depósito 2', 156.30, '2025-05-20', '2025-05-19', 'Variável', 'Despesas Operacionais', 'Paga'),
(7, 'Pagamento de funcionário Aline Dias Queiroz', 2090.00, '2025-05-05', '2025-05-03', 'Fixo', 'Despesas Operacionais', 'Paga'),
(8, 'Pagamento de funcionário Aline Dias Queiroz', 20190.00, '2025-06-05', '2025-06-03', 'Fixo', 'Despesas Operacionais', 'Paga'),
(9, 'Pagamento de funcionário Aline Dias Queiroz', 2090.00, '2025-07-05', '2025-07-03', 'Fixo', 'Despesas Operacionais', 'Paga'),
(10, 'Pagamento de funcionário Adriane Oliveira', 1518.00, '2025-07-05', '2025-07-03', 'Fixo', 'Despesas Operacionais', 'Paga'),
(11, 'Pagamento de funcionário Adriane Oliveira', 1518.00, '2025-06-05', '2025-06-03', 'Fixo', 'Despesas Operacionais', 'Paga'),
(12, 'Pagamento de funcionário Adriane Oliveira', 1518.00, '2025-05-05', '2025-05-03', 'Fixo', 'Despesas Operacionais', 'Paga'),
(13, 'Compra e itens de escritório (Cadeado)', 53.00, '2025-05-20', '2025-05-20', 'Variável', 'Despesas Administrativas', 'Paga'),
(14, 'Compra e itens de escritório (canetas e clips)', 29.90, '2025-05-15', '2025-05-15', 'Variável', 'Despesas Administrativas', 'Paga'),
(15, 'Compra e itens de limpeza (vassouras e pá)', 19.65, '2025-05-10', '2025-05-10', 'Variável', 'Despesas Administrativas', 'Paga'),
(16, 'Compra e itens de limpeza (Detergente, sabão em pó)', 38.00, '2025-05-12', '2025-05-12', 'Variável', 'Despesas Administrativas', 'Paga'),
(17, 'Instalação de Ar condicionado escritório', 290.00, '2025-05-09', '2025-05-09', 'Variável', 'Despesas Operacionais', 'Paga'),
(18, 'Conserto de Climatizador ', 150.00, '2025-05-09', '2025-05-09', 'Variável', 'Despesas Operacionais', 'Paga'),
(19, 'Pagamento de internet loja sede', 120.00, '2025-05-10', '2025-05-01', 'Fixo', 'Despesas Operacionais', 'Paga'),
(20, 'internet celular da loja', 52.90, '2025-05-15', '2025-05-10', 'Fixo', 'Despesas Administrativas', 'Paga'),
(21, 'internet celular da loja', 52.60, '2025-06-15', '2025-06-10', 'Fixo', 'Despesas Administrativas', 'Paga'),
(22, 'internet celular da loja', 52.60, '2025-07-15', '2025-07-10', 'Fixo', 'Despesas Administrativas', 'Paga'),
(23, 'internet celular da loja', 52.60, '2025-04-15', '2025-04-10', 'Fixo', 'Despesas Administrativas', 'Paga'),
(24, 'Pagamento de funcionário Aline Dias Queiroz', 2090.00, '2025-04-05', '2025-04-01', 'Fixo', 'Despesas Operacionais', 'Paga'),
(25, 'Serviço de auditoria', 290.00, '2025-05-15', '2025-05-01', 'Variável', 'Despesas Administrativas', 'Paga'),
(26, 'Consultoria jurídica', 376.00, '2025-05-22', '2025-05-15', 'Variável', 'Despesas Administrativas', 'Paga'),
(27, 'Serviços bancários maio', 642.50, '2025-05-31', '2025-05-01', 'Variável', 'Despesas Administrativas', 'Paga'),
(28, 'Compra de monitores', 1900.00, '2025-05-15', '2025-05-02', 'Variável', 'Despesas Administrativas', 'Paga'),
(29, 'Comissões de vendedores', 862.00, '2025-05-05', '2025-05-01', 'Variável', 'Despesas Operacionais', 'Paga'),
(30, 'Compra de brindes', 294.50, '2025-05-29', '2025-05-22', 'Variável', 'Despesas Operacionais', 'Paga'),
(31, 'Taxas de cartão de crédito/débito', 59.40, '2025-05-05', '2025-05-01', 'Variável', 'Despesas Operacionais', 'Paga'),
(32, 'Embalagens, caixas e rótulos', 359.90, '2025-05-26', '2025-05-20', 'Fixo', 'Despesas Operacionais', 'Paga'),
(33, 'Embalagens, caixas e rótulos', 659.20, '2025-06-26', '2025-06-20', 'Fixo', 'Despesas Operacionais', 'Paga'),
(34, 'Embalagens, caixas e rótulos', 625.30, '2025-07-26', '2025-07-20', 'Fixo', 'Despesas Operacionais', 'Paga'),
(35, 'Manutenção de veículo', 354.20, '2025-06-18', '2025-06-02', 'Variável', 'Despesas Operacionais', 'Paga'),
(36, 'Manutenção de máquinas e equipamentos', 865.00, '2025-06-12', '2025-06-12', 'Variável', 'Despesas Operacionais', 'Paga'),
(37, 'Compra de impressoras', 5642.00, '2025-06-25', '2025-06-20', 'Variável', 'Despesas Administrativas', 'Paga'),
(38, 'Equipamentos de informática', 294.00, '2025-06-06', '2025-06-06', 'Variável', 'Despesas Administrativas', 'Paga'),
(39, 'Serviços bancários junho', 539.20, '2025-06-30', '2025-06-01', 'Fixo', 'Despesas Administrativas', 'Paga'),
(40, 'Hospedagem de site institucional', 65.90, '2025-04-09', '2025-04-01', 'Fixo', 'Despesas Administrativas', 'Paga'),
(41, 'Hospedagem de site institucional', 65.90, '2025-05-09', '2025-05-01', 'Fixo', 'Despesas Administrativas', 'Paga'),
(42, 'Hospedagem de site institucional', 65.90, '2025-06-09', '2025-06-01', 'Fixo', 'Despesas Administrativas', 'Paga'),
(43, 'Hospedagem de site institucional', 65.90, '2025-07-09', '2025-07-01', 'Fixo', 'Despesas Administrativas', 'Paga'),
(44, 'Reembolsos de viagens administrativas', 289.20, '2025-07-21', '2025-07-11', 'Variável', 'Despesas Administrativas', 'Paga'),
(45, 'Encargos trabalhistas', 865.20, '2025-05-21', '2025-05-15', 'Variável', 'Despesas Operacionais', 'Paga'),
(46, 'Encargos trabalhistas', 865.20, '2025-06-21', '2025-06-15', 'Variável', 'Despesas Operacionais', 'Paga'),
(47, 'Encargos trabalhistas', 865.20, '2025-07-21', '2025-07-15', 'Variável', 'Despesas Operacionais', 'Paga'),
(48, 'Encargos trabalhistas', 865.20, '2025-04-21', '2025-04-15', 'Variável', 'Despesas Operacionais', 'Paga'),
(49, 'Encargos trabalhistas', 265.30, '2025-04-21', '2025-04-15', 'Fixo', 'Despesas Administrativas', 'Pendente');

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

--
-- Despejando dados para a tabela `investimentos`
--

INSERT INTO `investimentos` (`id`, `nome`, `tipo`, `valor_investido`, `rentabilidade_esperada`, `data_investimento`, `status`, `valor_real`) VALUES
(1, 'Ferramentas de automação', 'Administrativo', 560.00, 11.00, '2025-04-17', 'Finalizado', 627.20),
(2, 'Consultoria com especialista em negócios criativos', 'Operacional', 499.90, 10.00, '2025-06-12', 'Finalizado', 549.89),
(3, 'Consultoria com especialista em negócios criativos', 'Operacional', 289.60, 5.00, '2025-04-24', 'Finalizado', 304.08),
(4, 'Ferramentas de automação', 'Administrativo', 826.35, 11.00, '2025-05-28', 'Finalizado', 917.25),
(5, 'Ferramentas de automação', 'Administrativo', 186.50, 11.00, '2025-06-18', 'Finalizado', 207.01),
(6, 'Software para controle financeiro', 'Administrativo', 2500.00, 11.00, '2025-05-14', 'Finalizado', 2775.00),
(7, 'Cursos de decoração', 'Operacional', 490.00, 12.00, '2025-06-25', 'Ativo', NULL),
(8, 'Treinamentos em atendimento ao cliente', 'Operacional', 224.65, 3.00, '2025-06-19', 'Ativo', NULL),
(9, 'Equipamentos de segurança', 'Cameras, alarmes, etc', 2549.28, 8.00, '2025-04-03', 'Finalizado', 2600.00),
(10, 'Ferramentas para manutenção', 'Operacional', 542.97, 15.00, '2025-07-01', 'Finalizado', 658.00),
(11, 'Sessões de fotos dos kits (fotografia profissional)', 'Marketing', 276.50, 20.00, '2025-07-10', 'Finalizado', 332.00),
(12, 'Investimento em redes sociais', 'Marketing', 56.84, 20.00, '2025-07-21', 'Finalizado', 68.21);

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
(1, 'moana', 250.00, 'paineis, mesas, bolo', 'kit nunca utilizado ainda', '', 'inativo', 'premium'),
(2, 'princesas disney', 800.00, 'paineis, mesas, bolo, balões', 'fhdhdjdjkkjdsjk', '68733076874b3_Pegue monte CADASTRO DE FUNCIONARIOS GERENTE.jpg', 'ativo', 'super premuim'),
(3, 'carros', 262.00, 'paineis, arco de balões, toalhas de mesa, centros de mesa', 'infantojuvenil', 'img_687543eb210354.31637372.jpg', 'ativo', 'premium'),
(4, 'florida', 120.00, 'mesas de bolo/doces, arco de flores, arranjo flores, bolo fake', 'facil montagem', 'img_687543f434ee63.56573725.jpg', 'ativo', 'basico'),
(5, 'Arraiá junino', 138.00, 'mesas de bolo/doces, arco de flores, arranjo flores, bolo fake', 'festa junina\r\nsão joão', 'img_6875449bd400c9.40165964.jpg', 'ativo', 'basico'),
(6, 'Moana baby 1', 248.00, '1 painel grande de fundo com estampa da Moana, 3 cilindros decorados personalizados (banco ou mesa suporte), 2 suportes de bolo (bandejas coloridas), 2 arranjos florais artificiais decorativos, Tapete felpudo, Detalhes extras como cachepôs e adornos.', 'Infantil, Temática-Moana', 'img_687cf5df82e256.75860963.jpeg', 'ativo', 'premium'),
(7, 'Moana criança', 252.00, '1 painel grande de fundo com estampa da Moana, 3 cilindros decorados personalizados (banco ou mesa suporte), 2 suportes de bolo (bandejas coloridas), 2 arranjos florais artificiais decorativos, Tapete felpudo, Detalhes extras como cachepôs e adornos.', 'Infantojuvenil, Temática-Moana', 'img_687cf9759e4393.32538547.jpeg', 'ativo', 'premium'),
(8, 'Jardim Rosas Vermelhas', 153.00, '1 painel grande de fundo com estampa de rosas vermelhas, 1 cilindro decorados personalizados (banco ou mesa suporte), 2 mesas de suporte, 1 suporte de bolo, 2 arranjos florais artificiais decorativos, Tapete felpudo.', 'Temática - Jardim', 'img_687cfa679e72f5.78041861.jpeg', 'ativo', 'basico'),
(9, 'Sonic', 276.00, '1 painel grande (imagem do sonic), 3 cilindros (mesas de suporte), 3 suportes pra doces, 1 bolo fake, 1 arranjo decorativo artificial', 'Infantojuvenil, temática-sonic', 'img_687cfb79a901e8.83763715.jpeg', 'ativo', 'premium'),
(10, 'Princesa Jasmin', 270.00, '1 painel grande (imagem da Jasmin), 3 cilindros (mesas de suporte), 3 suportes de bolo e 2 de doces, 2  arranjo flores artificiais, uma Jasmin', 'infantojuvenil, Temática-Princesas', 'img_687d03ef1d0ac7.45005013.jpeg', 'ativo', 'premium'),
(11, 'Cerejas', 89.00, '1 painel (cerejas), 3 cilindros (mesas suporte), 2 bandejas de doces, 3 suportes de bolo, tapete felpudo', '', 'img_687d0463202fb2.19412332.jpeg', 'ativo', 'basico'),
(12, 'Ursinhos carinhosos', 138.00, '1 painel (ursinhos), 3 cilindros (mesas suporte), 1 bandeja de doces, 4 suportes de bolo, tapete felpudo, decorações de mesa (ursinhos)', 'infantil', 'img_687d04ff6caf80.37975097.jpeg', 'ativo', 'premium'),
(13, 'Irmãs Frozen', 159.00, '1 painel (Elza e Ana), 3 cilindros (mesas suporte), 1 bandeja de doces, 4 suportes de bolo, tapete felpudo, decorações de mesa (ursinhos e arranjos artificiais)', 'infantojuvenil, Temática - Princesas', 'img_687d057b3aa3a0.43140385.jpeg', 'ativo', 'premium'),
(14, 'Explorador Mickey Mouse', 246.00, '1 painel (Mickey), 3 cilindros (mesas suporte), 1 bandeja de doces, 3 suportes de bolo, tapete felpudo, decorações de mesa (ursos e 1 arranjo artificial), 2 ursos grandes', 'infantil, Temática - Disney', 'img_687d0608996570.78128524.jpeg', 'ativo', 'premium'),
(15, 'Palmeiras', 235.00, '1 painel (Palmeiras), 3 cilindros (mesas suporte), 1 bandeja de doces, 4 suportes de bolo, decorações de mesa (chuteira, troféu e 1 arranjo artificial)', 'Temática - times', 'img_687d0687ab4c90.41427539.jpeg', 'ativo', 'premium'),
(16, 'Minie e Margarida', 189.00, '1 painel (Minie e Margarida), 3 cilindros (mesas suporte), 1 bandeja de doces, 3 suportes de bolo, decorações de mesa (ursinhos e 2 arranjos artificiais)', 'infantil, Temática - Disney', 'img_687d071098c019.50281029.jpeg', 'ativo', 'premium'),
(17, 'Minecraft', 82.00, '1 painel (Minecraft), 3 cilindros (mesas suporte), 2 bandejas de doces, 2 suportes de bolo, decorações de mesa (bolo fake e 1 arranjo artificial), tapete felpudo.', 'infantojuvenil, tematica - jogos', 'img_687d12bf06c458.70612154.jpeg', 'ativo', 'premium'),
(18, 'Barbie', 389.00, '2 paineis (barbie e cor de rosa), 3 cilindros e comoda rosa (mesas suporte), 2 bandejas de doces, 6 suportes de bolo, decorações de mesa (barbies e 2 arranjos artificiais), tapete felpudo, 1 cadeira rosa.', '', 'img_687d139683f7e0.99313845.jpeg', 'ativo', 'super premuim'),
(19, 'Moana baby 2', 180.00, '1 painel (Moana baby), 3 cilindros (mesas suporte), 2 bandejas de doces, 3 suportes de bolo, decorações de mesa ( 2 arranjos artificiais), tapete felpudo.', 'infantil, Temática - princesas/Moana', 'img_687d146180cfe3.65432226.jpeg', 'ativo', 'premium'),
(20, 'Patrulha Canina', 180.00, '1 painel (Patrulha), 3 cilindros (mesas suporte), 4 suportes de bolo, decorações de mesa ( 1 arranjo artificial, ursos), tapete felpudo.', 'infantil, temática - desenhos infantis', 'img_687d14e950cf64.26030820.jpeg', 'ativo', 'premium'),
(21, 'Gatinha Marie', 168.00, '1 painel (Marie), 3 cilindros (mesas suporte), 3 suportes de bolo, decorações de mesa ( 2 arranjo artificial, urso), tapete felpudo.', 'infantojuvenil, Temática - desenhos infantis', 'img_687d156e1845b6.97656442.jpeg', 'ativo', 'premium'),
(22, 'Moranguinho', 176.00, '1 painel (Morangunho), 3 cilindros (mesas suporte), 3 suportes de bolo, decorações de mesa ( 1 arranjo artificial), tapete felpudo.', 'infantojuvenil, Temática - desenhos infantis', 'img_687d15c7dab368.56474142.jpeg', 'ativo', 'premium'),
(23, 'Patrulha Canina 2', 176.00, '1 painel (patrulha), 3 cilindros (mesas suporte), 4 suportes de bolo, decorações de mesa ( 2 arranjos artificiais, ursos, mini-paineis), tapete felpudo.', 'infantil, tematica - desenhos infantis', 'img_687d162d5cd6a6.93589386.jpeg', 'ativo', 'premium'),
(24, 'Lilo e Stitch Love', 89.00, '1 painel (Stitch love), 3 cilindros (mesas suporte), 3 suportes de bolo, 2 bandejas de doce, decorações de mesa ( 2 arranjos artificiais, bonecos), tapete felpudo.', 'infantojuvenil, temática - desenhos inantis', 'img_687d16ea2261d3.03457466.jpeg', 'ativo', 'premium'),
(25, 'Ana Castela Boiadeira', 138.00, '1 painel (Ana Castela), 3 cilindros (mesas suporte), 4 suportes de bolo, 1 bandejas de doce, decorações de mesa ( 2 arranjos artificiais, bonecos cavalo), tapete felpudo.', 'infantojuvenil, Temática - musica', 'img_687d176525e960.26364740.jpeg', 'ativo', 'premium'),
(26, 'Peppa Pig', 122.00, '1 painel (familia pig), 3 cilindros (mesas suporte), 4 suportes de bolo, 1 bandejas de doce, decorações de mesa ( 2 arranjos artificiais, pelucia peppa), tapete felpudo.', 'infantil, temática - desenhos infantis', 'img_687d17ce747c79.14697527.jpeg', 'ativo', 'premium'),
(27, 'Mini Fazendinha 1', 118.00, '1 painel (baby animais), 3 cilindros (mesas suporte), 3 suportes de bolo, 1 bandejas de doce, decorações de mesa ( 1 arranjo artificial, pelúcias), tapete felpudo.', 'infantil', 'img_687d183c19f513.61535240.jpeg', 'ativo', 'premium'),
(28, 'Mini Fazendinha 2', 118.00, '1 painel (baby animais), 3 cilindros (mesas suporte), 4 suportes de bolo, 1 bandeja de doce, decorações de mesa ( 1 arranjo artificial, pelúcias), tapete felpudo.', 'infantil', 'img_687d188ecb6a26.99604716.jpeg', 'ativo', 'premium'),
(29, 'Hotweels', 186.00, '1 painel (carro), 3 cilindros (mesas suporte), 4 suportes de bolo, 1 bandeja de doce, decorações de mesa ( 1 arranjo artificial, 2 cones), tapete felpudo.', 'infantojuvenil', 'img_687d1a958da3d3.93623323.jpeg', 'ativo', 'premium'),
(30, 'Homem Aranha', 159.00, '1 painel (Homem aranha), 3 cilindros (mesas suporte), 4 suportes de bolo, 1 bandeja de doce, decorações de mesa ( 1 arranjo artificial, 2 bonecos), tapete felpudo.', 'infantojuvenil, Temática - desenho infantil', 'img_687d1adee70bc9.50773229.jpeg', 'ativo', 'premium'),
(31, 'Campeonato futebol', 159.00, '1 painel (estadio), 3 cilindros (mesas suporte), 4 suportes de bolo, 1 bandeja de doce, decorações de mesa ( 1 arranjo artificial, 2 trofeus, 1 chuteira), tapete felpudo.', 'infantojuvenil', 'img_687d1b376c0786.50680935.jpeg', 'ativo', 'premium'),
(32, 'Super Mário Bros', 178.00, '1 painel (Mário), 3 cilindros (mesas suporte), 4 suportes de bolo, 1 bandeja de doce, decorações de mesa ( 1 arranjo artificial, 3 bonecos), tapete felpudo.', 'infantojuvenil, temática - desenho infantil', 'img_687d1ba496f6b0.86415059.jpeg', 'ativo', 'premium'),
(33, 'Pokemon', 125.00, '1 painel (Pokemon), 3 cilindros (mesas suporte), 4 suportes de bolo, 2 bandeja de doce, decorações de mesa ( 1 arranjo artificial, 2 bonecos pelúcia), tapete felpudo.', 'infantojuvenil, temática - desenho infantil', 'img_687d1bf359f9d3.74534528.jpeg', 'ativo', 'premium'),
(34, 'Cinderela Baby', 125.00, '1 painel (Cinderela baby), 3 cilindros (mesas suporte), 3 suportes de bolo, 2 bandeja de doce, decorações de mesa ( 2 arranjo artificial, 1 boneca pelúcia), tapete felpudo.', 'infantil, temática - princesas', 'img_687d1c42bba7b1.47018402.jpeg', 'ativo', 'premium'),
(35, 'Princesinha Ariel', 159.00, '1 painel (Ariel), 3 cilindros (mesas suporte), 4 suportes de bolo, 2 bandeja de doce, decorações de mesa ( 2 arranjo artificial, 1 boneca pelúcia, conchas e cauda), tapete felpudo.', 'infantojuvenil, temática - princesas', 'img_687d1cbfdadf23.10379746.jpeg', 'ativo', 'premium'),
(36, 'Tropical', 139.00, '1 painel (Tardezinha), 3 cilindros (mesas suporte), 3 suportes de bolo, 2 bandeja de doce, decorações de mesa ( 1 arranjo artificial, 3 itens decorativos).', 'juvenil', 'img_687d1d297abc06.97098786.jpeg', 'ativo', 'premium'),
(37, 'Princesa Jasmin 2', 186.00, '1 painel (Jasmin), 3 cilindros (mesas suporte), 3 suportes de bolo, 2 bandeja de doce, decorações de mesa ( 2 arranjo artificial, pelúcia), tapete felpudo.', 'infantojuvenil, temática - princesas', 'img_687d1d94560235.01060790.jpeg', 'ativo', 'premium'),
(38, 'Mundo mágico Unicórnios baby', 186.00, '1 painel (unicórnio baby), 3 cilindros (mesas suporte), 4 suportes de bolo, 2 bandeja de doce, decorações de mesa ( 2 arranjo artificial, 2 pelúcias), tapete felpudo.', 'infantil, temática - magia', 'img_687d1df5738393.74644789.jpeg', 'ativo', 'premium'),
(39, 'O rei leão', 186.00, '1 painel (Mufasa), 3 cilindros (mesas suporte),  suportes de bolo, 1 bandeja de doce, decorações de mesa ( 1 arranjo artificial, bolo fake), tapete felpudo.', 'infantil, temática - desenho infantil', 'img_687d1e56b66479.56481973.jpeg', 'ativo', 'premium'),
(40, 'Circo Mágico', 156.00, '1 painel (circo), 3 cilindros (mesas suporte), 4 suportes de bolo, 1 bandeja de doce, decorações de mesa ( 1 arranjo artificial, pelúcia), tapete felpudo.', 'infantil, temática - magia', 'img_687d1ea8431cd0.36014287.jpeg', 'ativo', 'premium'),
(41, 'Lilo e Stitch', 158.00, '1 painel (stitch), 3 cilindros (mesas suporte), 4 suportes de bolo, 1 bandeja de doce, decorações de mesa ( 2 arranjo artificial, boneco stitch), tapete felpudo.', 'infantojuvenil, temática - princesas', 'img_687d1f3ec730f4.38478508.jpeg', 'ativo', 'premium'),
(42, 'Hello kitty', 189.00, '1 painel (kitty), 3 cilindros (mesas suporte), 3 suportes de bolo, 1 bandeja de doce, decorações de mesa ( 2 arranjo artificial, boneco kitty), tapete felpudo.', 'infantil, temática - desenho infantil', 'img_687d1fc3748639.00628984.jpeg', 'ativo', 'premium'),
(43, 'Moana - um mar de aventuras', 156.00, '1 painel (Moana e Maui), 3 cilindros (mesas suporte), 5 suportes de bolo, decorações de mesa ( 2 arranjo artificial, moana e maui), tapete felpudo.', 'infantojuvenil, temática - princesas', 'img_687d204a4e7cd7.36024440.jpeg', 'ativo', 'premium'),
(44, 'Divertidamente', 136.00, '1 painel (emoções), 3 cilindros (mesas suporte), 6 suportes de bolo, decorações de mesa ( 1 arranjo artificial), tapete felpudo.', 'infantojuvenil, temática - desenho infantil', 'img_687d2098a8b318.60296806.jpeg', 'ativo', 'premium'),
(45, 'Meninas Super Poderosas', 127.00, '1 painel (meninas), 3 cilindros (mesas suporte), 4 suportes de bolo, decorações de mesa ( 2 arranjo artificial, bonecas), tapete felpudo.', 'infantil, temática - desenhos infantis', 'img_687d453c7ad604.31186078.jpeg', 'ativo', 'premium'),
(46, 'Flamengo', 159.00, '1 painel (flamengo), 3 cilindros (mesas suporte), 5 suportes de bolo, decorações de mesa ( 1 arranjo artificial, trofeu e chuteira), tapete felpudo.', 'temática - times', 'img_687d45a1ae93e6.24712637.jpeg', 'ativo', 'premium');

-- --------------------------------------------------------

--
-- Estrutura para tabela `meta_financeira`
--

CREATE TABLE `meta_financeira` (
  `id` int(11) NOT NULL,
  `tipo` varchar(20) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `valor_meta` decimal(10,2) DEFAULT NULL,
  `valor_atual` decimal(10,2) DEFAULT NULL,
  `data_inicio` date DEFAULT NULL,
  `data_fim` date DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `meta_financeira`
--

INSERT INTO `meta_financeira` (`id`, `tipo`, `descricao`, `valor_meta`, `valor_atual`, `data_inicio`, `data_fim`, `criado_em`) VALUES
(1, 'Mensal', 'Meta mês de julho', 23000.00, NULL, '2025-07-01', '2025-07-31', '2025-07-25 03:08:46'),
(2, 'Mensal', 'Meta mês de junho', 23000.00, NULL, '2025-06-01', '2025-06-30', '2025-07-25 03:09:25');

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
(4, 'manual', NULL, 'Retorno de investimento', 413.80, '2025-07-24', '2025-07-15 20:05:53'),
(5, 'aluguel', 1, NULL, 0.00, '2025-07-13', '2025-07-21 02:24:16'),
(6, 'aluguel', 2, NULL, 0.00, '2025-07-13', '2025-07-21 02:24:16'),
(7, 'aluguel', 5, NULL, 1000.00, '2025-07-13', '2025-07-21 02:24:16'),
(8, 'aluguel', 7, NULL, 138.00, '2025-07-14', '2025-07-21 02:24:16'),
(9, 'aluguel', 8, NULL, 796.00, '2025-07-18', '2025-07-21 02:24:16'),
(10, 'aluguel', 9, NULL, 625.00, '2025-07-18', '2025-07-21 02:24:16'),
(11, 'aluguel', 10, NULL, 250.00, '2025-07-18', '2025-07-21 02:24:16'),
(12, 'aluguel', 11, NULL, 2400.00, '2025-07-19', '2025-07-21 02:24:16'),
(13, 'aluguel', 12, NULL, 400.00, '2025-07-20', '2025-07-21 02:24:16'),
(14, 'aluguel', 13, NULL, 1250.00, '2025-07-20', '2025-07-21 02:24:16'),
(15, 'aluguel', 14, NULL, 270.00, '2025-07-20', '2025-07-21 02:24:16'),
(16, 'aluguel', 16, NULL, 375.00, '2025-07-20', '2025-07-21 02:24:16'),
(17, 'aluguel', 17, NULL, 720.00, '2025-07-20', '2025-07-21 02:24:16'),
(18, 'aluguel', 18, NULL, 440.00, '2025-07-20', '2025-07-21 02:24:16'),
(19, 'aluguel', 19, NULL, 1556.00, '2025-07-20', '2025-07-21 02:24:16'),
(20, 'aluguel', 20, NULL, 624.00, '2025-07-20', '2025-07-21 02:24:16'),
(21, 'aluguel', 22, NULL, 550.00, '2025-07-20', '2025-07-21 02:24:16'),
(22, 'aluguel', 23, NULL, 556.00, '2025-07-20', '2025-07-21 02:24:16'),
(23, 'aluguel', 24, NULL, 455.00, '2025-07-20', '2025-07-21 02:24:16'),
(24, 'aluguel', 25, NULL, 645.00, '2025-07-20', '2025-07-21 02:24:16'),
(25, 'aluguel', 26, NULL, 510.00, '2025-07-20', '2025-07-21 02:24:16'),
(26, 'aluguel', 27, NULL, 756.00, '2025-07-20', '2025-07-21 02:24:16'),
(27, 'aluguel', 28, NULL, 744.00, '2025-07-20', '2025-07-21 02:24:16'),
(28, 'aluguel', 29, NULL, 615.00, '2025-07-20', '2025-07-21 02:24:16'),
(29, 'aluguel', 30, NULL, 636.00, '2025-07-20', '2025-07-21 02:24:16'),
(30, 'aluguel', 31, NULL, 750.00, '2025-07-20', '2025-07-21 02:24:16'),
(31, 'aluguel', 32, NULL, 1170.00, '2025-07-20', '2025-07-21 02:24:16'),
(32, 'aluguel', 33, NULL, 786.00, '2025-07-20', '2025-07-21 02:24:16'),
(33, 'aluguel', 34, NULL, 1167.00, '2025-07-20', '2025-07-21 02:24:16'),
(34, 'aluguel', 35, NULL, 477.00, '2025-07-20', '2025-07-21 02:24:16'),
(35, 'aluguel', 37, NULL, 477.00, '2025-07-20', '2025-07-21 02:24:16'),
(36, 'aluguel', 38, NULL, 312.00, '2025-07-20', '2025-07-21 02:24:16'),
(37, 'aluguel', 39, NULL, 178.00, '2025-07-20', '2025-07-21 02:24:16'),
(38, 'aluguel', 40, NULL, 470.00, '2025-07-20', '2025-07-21 02:24:16'),
(39, 'aluguel', 41, NULL, 306.00, '2025-07-20', '2025-07-21 02:24:16'),
(40, 'aluguel', 42, NULL, 381.00, '2025-07-20', '2025-07-21 02:24:16'),
(41, 'aluguel', 43, NULL, 246.00, '2025-07-20', '2025-07-21 02:24:16'),
(42, 'aluguel', 44, NULL, 276.00, '2025-07-20', '2025-07-21 02:24:16'),
(43, 'aluguel', 45, NULL, 534.00, '2025-07-20', '2025-07-21 02:24:16'),
(44, 'aluguel', 46, NULL, 1100.00, '2025-07-20', '2025-07-21 02:24:16'),
(45, 'aluguel', 47, NULL, 318.00, '2025-07-20', '2025-07-21 02:24:16'),
(46, 'aluguel', 48, NULL, 1600.00, '2025-07-20', '2025-07-21 02:24:16'),
(47, 'aluguel', 49, NULL, 540.00, '2025-07-20', '2025-07-21 02:24:16'),
(48, 'aluguel', 51, NULL, 350.00, '2025-07-20', '2025-07-21 02:24:16'),
(49, 'aluguel', 52, NULL, 675.00, '2025-07-20', '2025-07-21 02:24:16'),
(50, 'aluguel', 53, NULL, 360.00, '2025-07-20', '2025-07-21 02:24:16'),
(51, 'aluguel', 54, NULL, 164.00, '2025-07-20', '2025-07-21 02:24:16'),
(52, 'aluguel', 56, NULL, 550.00, '2025-07-20', '2025-07-21 02:24:16'),
(53, 'aluguel', 57, NULL, 414.00, '2025-07-20', '2025-07-21 02:24:16'),
(54, 'aluguel', 59, NULL, 558.00, '2025-07-20', '2025-07-21 02:24:16'),
(55, 'manual', NULL, 'Recebimento Aluguel no nome da empresa', 860.00, '2025-05-29', '2025-07-21 02:27:51'),
(56, 'manual', NULL, 'Recebimento Aluguel no nome da empresa', 860.00, '2025-06-29', '2025-07-21 02:28:01'),
(57, 'manual', NULL, 'Recebimento Aluguel no nome da empresa', 860.00, '2025-07-20', '2025-07-21 02:28:29'),
(58, 'manual', NULL, 'Recebimento Aluguel no nome da empresa', 860.00, '2025-04-20', '2025-07-21 03:06:03'),
(59, 'manual', NULL, 'Recebimento Aluguel no nome da empresa', 860.00, '2025-05-20', '2025-07-21 03:06:08'),
(60, 'manual', NULL, 'Recebimento Aluguel no nome da empresa', 860.00, '2025-06-20', '2025-07-21 03:06:12'),
(61, 'manual', NULL, 'Taxa por atraso na devolução dos kits', 64.90, '2025-04-10', '2025-07-21 03:07:28'),
(62, 'manual', NULL, 'Taxa por atraso na devolução dos kits', 64.90, '2025-04-19', '2025-07-21 03:07:38'),
(63, 'manual', NULL, 'Taxa por atraso na devolução dos kits', 64.90, '2025-04-29', '2025-07-21 03:07:45'),
(64, 'manual', NULL, 'Taxa por atraso na devolução dos kits', 64.90, '2025-05-04', '2025-07-21 03:07:52'),
(65, 'manual', NULL, 'Taxa por atraso na devolução dos kits', 64.90, '2025-05-10', '2025-07-21 03:07:58'),
(66, 'manual', NULL, 'Taxa por atraso na devolução dos kits', 64.90, '2025-05-19', '2025-07-21 03:08:03'),
(67, 'manual', NULL, 'Taxa por atraso na devolução dos kits', 64.90, '2025-05-28', '2025-07-21 03:08:08'),
(68, 'manual', NULL, 'Taxa por atraso na devolução dos kits', 64.90, '2025-06-02', '2025-07-21 03:08:16'),
(69, 'manual', NULL, 'Taxa por atraso na devolução dos kits', 64.90, '2025-06-08', '2025-07-21 03:08:22'),
(70, 'manual', NULL, 'Taxa por atraso na devolução dos kits', 64.90, '2025-06-19', '2025-07-21 03:08:28'),
(71, 'manual', NULL, 'Taxa por atraso na devolução dos kits', 64.90, '2025-06-16', '2025-07-21 03:08:34'),
(72, 'manual', NULL, 'Publicidade nos eventos (patrocínio)', 160.00, '2025-04-02', '2025-07-21 03:09:20'),
(73, 'manual', NULL, 'Publicidade nos eventos (patrocínio)', 160.00, '2025-05-02', '2025-07-21 03:09:27'),
(74, 'manual', NULL, 'Publicidade nos eventos (patrocínio)', 160.00, '2025-06-02', '2025-07-21 03:09:30');

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
-- Despejando dados para a tabela `riscos`
--

INSERT INTO `riscos` (`id`, `descricao`, `impacto_estimado`, `data_registro`, `criado_em`) VALUES
(6, '❌ Risco: despesas maiores que receitas.', 7449.25, '2025-07-21', '2025-07-21 20:57:05'),
(9, '❌ Risco: despesas maiores que receitas.', 7449.25, '2025-07-23', '2025-07-23 21:23:49'),
(10, '❌ Risco: despesas maiores que receitas.', 7714.55, '2025-07-24', '2025-07-24 19:10:22'),
(15, '❌ Risco: despesas maiores que receitas.', 7714.55, '2025-07-25', '2025-07-25 17:55:07');

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
-- Índices de tabela `meta_financeira`
--
ALTER TABLE `meta_financeira`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `contas_pagar`
--
ALTER TABLE `contas_pagar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de tabela `formas_pagamento`
--
ALTER TABLE `formas_pagamento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `investimentos`
--
ALTER TABLE `investimentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `kits`
--
ALTER TABLE `kits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de tabela `meta_financeira`
--
ALTER TABLE `meta_financeira`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT de tabela `riscos`
--
ALTER TABLE `riscos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
