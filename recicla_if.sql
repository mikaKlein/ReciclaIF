-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 26/11/2024 às 19:38
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `recicla_if`
--

CREATE DATABASE IF NOT EXISTS `recicla_if` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `recicla_if`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `coletor`
--

CREATE TABLE `coletor` (
  `id` int(11) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `icone` varchar(500) NOT NULL,
  `cor` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `coletor`
--

INSERT INTO `coletor` (`id`, `nome`, `icone`, `cor`) VALUES
(8, 'Metal', 'imagensColetores/icone_metal.png', 'Amarelo'),
(9, 'Não Reciclável', 'imagensColetores/icone_nao_reciclavel.png', 'Cinza'),
(10, 'Orgânico', 'imagensColetores/icone_organico.png', 'Marrom'),
(11, 'Outro', 'imagensColetores/icone_outro.png', 'Branco'),
(12, 'Papel', 'imagensColetores/icone_papel.png', 'Azul'),
(13, 'Plástico', 'imagensColetores/icone_plastico.png', 'Vermelho'),
(14, 'Vidro', 'imagensColetores/icone_vidro.png', 'Verde');

-- --------------------------------------------------------

--
-- Estrutura para tabela `residuo`
--

CREATE TABLE `residuo` (
  `id` int(11) NOT NULL,
  `coletor_descarte` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `imagem_residuo` varchar(500) NOT NULL,
  `descricao` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `residuo`
--

INSERT INTO `residuo` (`id`, `coletor_descarte`, `nome`, `imagem_residuo`, `descricao`) VALUES
(4, 12, 'Mikael Odair Klein', 'imagensResiduos/674604ecda99e_Captura de tela 2024-11-26 141412.png', 'lala');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `email` varchar(200) NOT NULL,
  `senha` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `coletor`
--
ALTER TABLE `coletor`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `residuo`
--
ALTER TABLE `residuo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coletor_descarte` (`coletor_descarte`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `coletor`
--
ALTER TABLE `coletor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `residuo`
--
ALTER TABLE `residuo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `residuo`
--
ALTER TABLE `residuo`
  ADD CONSTRAINT `residuo_ibfk_1` FOREIGN KEY (`coletor_descarte`) REFERENCES `coletor` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
