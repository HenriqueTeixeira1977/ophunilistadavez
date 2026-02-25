-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 25-Fev-2026 às 04:45
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `lista_vez`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `atendimentos`
--

CREATE TABLE `atendimentos` (
  `id` int(11) NOT NULL,
  `vendedor_id` int(11) DEFAULT NULL,
  `cliente` varchar(100) DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `resultado` varchar(50) DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `data_atendimento` datetime DEFAULT current_timestamp(),
  `quantidade` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `atendimentos`
--

INSERT INTO `atendimentos` (`id`, `vendedor_id`, `cliente`, `valor`, `resultado`, `observacoes`, `data_atendimento`, `quantidade`) VALUES
(1, 1, 'João', '1000.00', 'Venda', 'Itens: 1-Tenis Old Skool; 1- Tenis Trinity; ', '2026-02-22 01:41:15', 1),
(2, 2, 'Maria José', '0.00', 'Não comprou', 'Pesquisando', '2026-02-22 01:41:53', 1),
(3, 3, 'Antonio Silva', '30.00', 'Troca', 'TROCA COM DINHEIRO', '2026-02-22 01:42:52', 1),
(4, 4, 'Tiago Silva', '539.98', 'Venda', 'NF:123456', '2026-02-22 03:11:15', 2),
(5, 1, 'Claudio Azeveddo', '1299.99', 'Venda', 'Tenis NB9060-37 Branco/Cinza', '2026-02-22 03:13:42', 1),
(6, 2, 'Cleide das Couves', '999.99', 'Venda', 'Boa', '2026-02-22 03:29:15', 3),
(7, 3, 'Alice Teixeira', '599.99', 'Venda', '', '2026-02-22 09:41:14', 3),
(8, 4, 'Matheus Silva', '489.99', 'Venda', '', '2026-02-22 09:41:54', 5),
(9, 1, 'Maria das Graças', '119.99', 'Venda', '', '2026-02-22 10:03:44', 1),
(10, 2, 'Sirlei Serginho', '199.99', 'Venda', 'NF:123456', '2026-02-23 02:11:16', 1),
(11, 3, 'João Fulano', '299.99', 'Venda', 'rgsdfsg', '2026-02-23 02:47:00', 2),
(12, 4, 'Maria Eduarda', '599.99', 'Venda', '3 CAMISETAS DA VANS;', '2026-02-23 10:24:38', 3),
(13, 1, 'Matheus Teixeira', '1599.99', 'Venda', '7 CAMISAS DA KAYLAND', '2026-02-23 10:26:09', 7),
(14, 1, 'Katarina Guedes', '1000.00', 'Venda', 'gsdfgsdfgsfg', '2026-02-23 10:59:16', 5),
(15, 2, 'Josué Filho', '599.99', 'Venda', 'dsgfdsgsfgsfg', '2026-02-23 12:05:34', 3),
(16, 3, 'Calebe André', '1000.00', 'Venda', '', '2026-02-23 12:07:22', 10),
(17, 4, 'Sergio Carioca', '789.99', 'Venda', 'dlkajhflkajdsfhalkdjf', '2026-02-23 21:39:30', 3),
(18, 1, 'Michele Ferreira', '1000.00', 'Venda', 'lakjdhflkajdshfadkjl', '2026-02-24 11:26:38', 3),
(19, 2, 'Fernanda Melo', '3000.00', 'Venda', 'lkajdshflakd', '2026-02-24 11:41:42', 10),
(20, 3, 'Gabriel Nunes', '500.00', 'Venda', 'HJCHLKDJFH', '2026-02-24 11:43:13', 3),
(21, 1, 'Nicolas Teixeira', '1999.99', 'Venda', 'façlsdfjkçaldsf', '2026-02-24 14:14:54', 3),
(22, 1, 'Flavio Nunes', '1234.98', 'Venda', 'dfksjçlksjgçlsjgk', '2026-02-24 15:17:52', 7),
(23, 4, 'Rafael Duque', '599.99', 'Venda', 'dsgdsfgs', '2026-02-24 15:23:29', 4),
(24, 2, 'Anna Julia', '549.99', 'Venda', 'fgdhsghklsjfhgkjl', '2026-02-24 15:27:34', 3),
(25, 3, 'Gabriela Mattos', '479.99', 'Venda', 'DKGJÇLSDFGHSÇ', '2026-02-24 17:36:46', 2),
(26, 1, 'Paulo Figueroa', '1233.98', 'Não comprou', 'dsgfgsf', '2026-02-24 21:52:51', 3),
(27, 1, 'Matheus Gatti', '1259.99', 'Venda', 'asdjfhalkdsjfh', '2026-02-24 23:12:44', 5),
(28, 4, 'Antonio José', '0.00', 'Venda', 'Procurando Tênis Nike', '2026-02-24 23:16:05', 0),
(29, 2, 'Fernando Filho', '0.00', 'Não comprou', 'dfsgsdfgs', '2026-02-24 23:16:57', 0),
(30, 3, 'Cesar Filho', '0.00', 'Não comprou', 'Procurando Tenis Nike', '2026-02-24 23:18:50', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `fila`
--

CREATE TABLE `fila` (
  `id` int(11) NOT NULL,
  `vendedor_id` int(11) DEFAULT NULL,
  `posicao` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `fila`
--

INSERT INTO `fila` (`id`, `vendedor_id`, `posicao`) VALUES
(1, 1, 1),
(2, 2, 3),
(3, 3, 4),
(4, 4, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `metas_diarias`
--

CREATE TABLE `metas_diarias` (
  `id` int(11) NOT NULL,
  `data_meta` date NOT NULL,
  `meta_vendas` decimal(10,2) DEFAULT NULL,
  `meta_vendas_20` decimal(10,2) DEFAULT NULL,
  `meta_atendimentos` int(11) DEFAULT NULL,
  `meta_convertidos` int(11) DEFAULT NULL,
  `meta_pecas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `metas_diarias`
--

INSERT INTO `metas_diarias` (`id`, `data_meta`, `meta_vendas`, `meta_vendas_20`, `meta_atendimentos`, `meta_convertidos`, `meta_pecas`) VALUES
(2, '2026-02-01', '3290.00', '3948.00', 14, 7, 12),
(3, '2026-02-02', '2590.00', '3108.00', 12, 6, 10),
(4, '2026-02-03', '2240.00', '2688.00', 10, 5, 8),
(5, '2026-02-04', '2380.00', '2856.00', 10, 5, 9),
(6, '2026-02-05', '2660.00', '3192.00', 12, 6, 10),
(7, '2026-02-06', '3500.00', '4200.00', 16, 8, 13),
(8, '2026-02-07', '5740.00', '6888.00', 26, 13, 22),
(9, '2026-02-08', '3640.00', '4368.00', 16, 8, 14),
(10, '2026-02-09', '2100.00', '2520.00', 10, 5, 8),
(11, '2026-02-10', '1890.00', '2268.00', 8, 4, 7),
(12, '2026-02-11', '1540.00', '1848.00', 6, 3, 6),
(13, '2026-02-12', '1820.00', '2184.00', 8, 4, 7),
(14, '2026-02-13', '2450.00', '2940.00', 10, 5, 9),
(15, '2026-02-14', '3500.00', '4200.00', 16, 8, 13),
(16, '2026-02-15', '2100.00', '2520.00', 10, 5, 8),
(17, '2026-02-16', '2380.00', '2856.00', 10, 5, 9),
(18, '2026-02-17', '1820.00', '2184.00', 8, 4, 7),
(19, '2026-02-18', '1750.00', '2100.00', 8, 4, 7),
(20, '2026-02-19', '1680.00', '2016.00', 8, 4, 6),
(21, '2026-02-20', '2380.00', '2856.00', 10, 5, 9),
(22, '2026-02-21', '4340.00', '5208.00', 20, 10, 16),
(23, '2026-02-22', '2450.00', '2940.00', 10, 5, 9),
(24, '2026-02-23', '1400.00', '1680.00', 6, 3, 5),
(25, '2026-02-24', '1330.00', '1596.00', 6, 3, 5),
(26, '2026-02-25', '1540.00', '1848.00', 6, 3, 6),
(27, '2026-02-26', '1680.00', '2016.00', 8, 4, 6),
(28, '2026-02-27', '2310.00', '2772.00', 10, 5, 9),
(29, '2026-02-28', '3500.00', '4200.00', 16, 8, 13);

-- --------------------------------------------------------

--
-- Estrutura da tabela `vendedores`
--

CREATE TABLE `vendedores` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `ativo` tinyint(1) DEFAULT 1,
  `perfil` enum('supervisor','gerente','subgerente','vendedorresponsavel','vendedor','caixa','caixaresponsavel','admin') DEFAULT 'vendedor'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `vendedores`
--

INSERT INTO `vendedores` (`id`, `nome`, `email`, `senha`, `ativo`, `perfil`) VALUES
(1, '5706-Henrique Teixeira', 'henrique@ophicina.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 'vendedor'),
(2, '5986-Mariana Visconti', 'mariana@ophicina.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 'vendedor'),
(3, '6095-Victor Gabriel', 'victor@ophicina.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 'vendedor'),
(4, '6151-Nilton Santos', 'nilton@ophicina.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 'vendedor'),
(6, 'Admin', 'admin@ophicina.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 'admin');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `atendimentos`
--
ALTER TABLE `atendimentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendedor_id` (`vendedor_id`);

--
-- Índices para tabela `fila`
--
ALTER TABLE `fila`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendedor_id` (`vendedor_id`);

--
-- Índices para tabela `metas_diarias`
--
ALTER TABLE `metas_diarias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `data_meta` (`data_meta`);

--
-- Índices para tabela `vendedores`
--
ALTER TABLE `vendedores`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `atendimentos`
--
ALTER TABLE `atendimentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de tabela `fila`
--
ALTER TABLE `fila`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `metas_diarias`
--
ALTER TABLE `metas_diarias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de tabela `vendedores`
--
ALTER TABLE `vendedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `atendimentos`
--
ALTER TABLE `atendimentos`
  ADD CONSTRAINT `atendimentos_ibfk_1` FOREIGN KEY (`vendedor_id`) REFERENCES `vendedores` (`id`);

--
-- Limitadores para a tabela `fila`
--
ALTER TABLE `fila`
  ADD CONSTRAINT `fila_ibfk_1` FOREIGN KEY (`vendedor_id`) REFERENCES `vendedores` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
