-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 17-Dez-2021 às 15:55
-- Versão do servidor: 10.4.10-MariaDB
-- versão do PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `conta`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `conta`
--

CREATE TABLE `conta` (
  `id` int(11) NOT NULL,
  `chave` text NOT NULL,
  `nome` varchar(50) NOT NULL,
  `apelido` varchar(50) NOT NULL,
  `genero` varchar(2) NOT NULL,
  `dia_nascimento` int(2) NOT NULL,
  `mes_nascimento` int(2) NOT NULL,
  `ano_nascimento` int(4) NOT NULL,
  `telefone` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `palavra_passe` text NOT NULL,
  `dia_entrada` int(2) NOT NULL,
  `mes_entrada` int(2) NOT NULL,
  `ano_entrada` int(4) NOT NULL,
  `codigo_renova` int(6) NOT NULL,
  `pais` varchar(50) NOT NULL,
  `provincia` varchar(50) NOT NULL,
  `municipio` varchar(50) NOT NULL,
  `bairro_rua` text NOT NULL,
  `foto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `conta`
--

INSERT INTO `conta` (`id`, `chave`, `nome`, `apelido`, `genero`, `dia_nascimento`, `mes_nascimento`, `ano_nascimento`, `telefone`, `email`, `palavra_passe`, `dia_entrada`, `mes_entrada`, `ano_entrada`, `codigo_renova`, `pais`, `provincia`, `municipio`, `bairro_rua`, `foto`) VALUES
(1, '61b7450c4f96e', 'Caetano', 'Wambembe', 'M', 15, 8, 1996, '921797626', 'cmcaetanoborges@gmail.com', 'f7ebbd8bfdd4face91eae94386ec3be00394b4bf748dc507bfb126c0e13286f62093f4a564a2aa06bd4a886f48aa75917626a07dede80a5192dfa53429437194', 13, 12, 2021, 0, '', 'Huíla', 'Lubango', 'Casa Verde', 'PicsArt_1419676045998.jpg');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `conta`
--
ALTER TABLE `conta`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `conta`
--
ALTER TABLE `conta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
