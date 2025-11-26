-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 26/11/2025 às 23:50
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
-- Banco de dados: `eventia_db`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `eventos`
--

CREATE TABLE `eventos` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `data` varchar(255) NOT NULL,
  `local` varchar(255) NOT NULL,
  `preco` double NOT NULL,
  `descricao` text NOT NULL,
  `imagemUrl` varchar(512) DEFAULT NULL,
  `imagem_url` varchar(512) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `categoria` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `eventos`
--

INSERT INTO `eventos` (`id`, `nome`, `data`, `local`, `preco`, `descricao`, `imagemUrl`, `imagem_url`, `id_usuario`, `categoria`) VALUES
(1, 'teste', '2025-11-03 19:59:00', 'aqui', 0, 'oi', NULL, 'https://images.pexels.com/photos/1190298/pexels-photo-1190298.jpeg', 1, NULL),
(2, 'oi', '2025-11-03 21:06:00', 'maracana', 0, 'oi', NULL, 'https://images.pexels.com/photos/1105666/pexels-photo-1105666.jpeg', 1, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` varchar(10) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `name`, `email`, `password`, `created_at`, `role`) VALUES
(10, 'Gui', 'eu@gmail.comm', '$2y$10$AJbaFnpZDgs4TlbM9zgGau2JJiAt9aWatsUot7hyl8Bd1MCZd51vS', '2025-11-04 04:21:47', '\'user\''),
(13, 'Gui', 'eu@gmail.com', '$2y$10$XtJCcN4M6k3qgUrN3wvgsufWgqHW7LLlJMsMU2WaJwWPyj0iJ07hS', '2025-11-05 18:49:56', 'admin'),
(14, 'biel', 'biel@gmail.com', '$2y$10$2on0ARS/TpnL4wH.VqnCfe6vhaMbQEycQlttolj0pajZ6vP36oBuC', '2025-11-05 19:28:42', 'user');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
