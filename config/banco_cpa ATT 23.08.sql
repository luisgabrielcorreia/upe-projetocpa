-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 23, 2024 at 06:02 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `banco_cpa`
--

-- --------------------------------------------------------

--
-- Table structure for table `formulario`
--

CREATE TABLE `formulario` (
  `id` int(11) NOT NULL,
  `json_formulario` text NOT NULL,
  `disponivel` tinyint(1) NOT NULL DEFAULT 1,
  `indisponivel` tinyint(1) NOT NULL DEFAULT 0,
  `descongelado` tinyint(1) NOT NULL DEFAULT 1,
  `congelado` tinyint(1) NOT NULL DEFAULT 0,
  `nome_arquivo` varchar(255) DEFAULT NULL,
  `afiliacoes` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `formulario`
--

INSERT INTO `formulario` (`id`, `json_formulario`, `disponivel`, `indisponivel`, `descongelado`, `congelado`, `nome_arquivo`, `afiliacoes`) VALUES
(75, '[{\"type\":\"Section\",\"questionVar\":\"secao\",\"label\":\"Avaliação Geral\",\"formulario\":\"\",\"qid\":\"qid_1\",\"condicao\":\"sempre\",\"externo\":\"undefined\",\"explicacao\":\"\"},{\"type\":\"Escolha1\",\"label\":\"Como você classificaria sua experiência geral com a plataforma ?\",\"questionVar\":\"QEscolhaUnicaCombobox\",\"opcoes\":[\"Muito bom\",\"Bom\",\"Intermediário\",\"Ruim\",\"Muito Ruim\"],\"qid\":\"qid_2\",\"condicao\":\"sempre\",\"var\":\"undefined\",\"explicacao\":\"\"},{\"type\":\"Escolha2\",\"label\":\"O website foi fácil de navegar?\",\"questionVar\":\"QEscolhaUnica\",\"opcoes\":[\"Sim\",\"Não\"],\"qid\":\"qid_3\",\"condicao\":\"sempre\",\"var\":\"undefined\",\"explicacao\":\"\"},{\"type\":\"Escolha2\",\"label\":\"Encontrou facilmente o que estava procurando?\",\"questionVar\":\"QEscolhaUnica\",\"opcoes\":[\"Sim\",\"Não\"],\"qid\":\"qid_4\",\"condicao\":\"sempre\",\"var\":\"undefined\",\"explicacao\":\"\"},{\"type\":\"Texto\",\"label\":\"Houve algum ponto no site que você achou confuso ou difícil de entender?\",\"questionVar\":\"QDiscursiva\",\"qid\":\"qid_5\",\"condicao\":\"sempre\",\"var\":\"undefined\",\"explicacao\":\"\"},{\"type\":\"Escolha2\",\"label\":\"A plataforma carregou rapidamente para você?\",\"questionVar\":\"QEscolhaUnica\",\"opcoes\":[\"Muito bom\",\"Bom\",\"Intermediário\",\"Ruim\",\"Muito ruim\"],\"qid\":\"qid_6\",\"condicao\":\"sempre\",\"var\":\"undefined\",\"explicacao\":\"\"},{\"type\":\"Escolha2\",\"label\":\"Teve algum problema técnico enquanto usava a plataforma?\",\"questionVar\":\"QEscolhaUnica\",\"opcoes\":[\"Sim\",\"Não\"],\"qid\":\"qid_7\",\"condicao\":\"sempre\",\"var\":\"problema_tecnico\",\"explicacao\":\"\"},{\"type\":\"Texto\",\"label\":\"Explique seu problema técnico\",\"questionVar\":\"QDiscursiva\",\"qid\":\"qid_8\",\"condicao\":\"problema_tecnico=Sim\",\"var\":\"resposta_problema_tecnico\",\"explicacao\":\"\"},{\"type\":\"Escolha2\",\"label\":\"Como você classificaria o design visual da nossa plataforma?\",\"questionVar\":\"QEscolhaUnica\",\"opcoes\":[\"Muito bom\",\"Bom\",\"Intermediário\",\"Ruim\",\"Muito ruim\"],\"qid\":\"qid_9\",\"condicao\":\"sempre\",\"var\":\"undefined\",\"explicacao\":\"\"},{\"type\":\"Escolha2\",\"label\":\"O design da plataforma é agradável e atraente?\",\"questionVar\":\"QEscolhaUnica\",\"opcoes\":[\"Sim\",\"Não\"],\"qid\":\"qid_10\",\"condicao\":\"sempre\",\"var\":\"design_site\",\"explicacao\":\"\"},{\"type\":\"Texto\",\"label\":\"Como acha que podemos melhorar o design?\",\"questionVar\":\"QDiscursiva\",\"qid\":\"qid_11\",\"condicao\":\"design_site=Não\",\"var\":\"resposta_design_site\",\"explicacao\":\"\"},{\"type\":\"Escolha2\",\"label\":\"Você se sentiu incentivado a interagir mais com a plataforma?\",\"questionVar\":\"QEscolhaUnica\",\"opcoes\":[\"Sim\",\"Não\"],\"qid\":\"qid_12\",\"condicao\":\"sempre\",\"var\":\"undefined\",\"explicacao\":\"\"},{\"type\":\"Texto\",\"label\":\"Há algo que você gostaria de sugerir para melhorar nossa plataforma?\",\"questionVar\":\"QDiscursiva\",\"qid\":\"qid_13\",\"condicao\":\"sempre\",\"var\":\"undefined\",\"explicacao\":\"\"}]', 1, 0, 1, 0, 'arquivo_67', 'Estudante');

-- --------------------------------------------------------

--
-- Table structure for table `opcoes_voto`
--

CREATE TABLE `opcoes_voto` (
  `id` int(11) NOT NULL,
  `votacao_id` int(11) DEFAULT NULL,
  `opcao` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `opcoes_voto`
--

INSERT INTO `opcoes_voto` (`id`, `votacao_id`, `opcao`) VALUES
(12, 4, 'Acayne'),
(13, 4, 'Luis'),
(14, 4, 'Ana'),
(15, 4, 'Amelia');

-- --------------------------------------------------------

--
-- Table structure for table `respostas`
--

CREATE TABLE `respostas` (
  `id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  `respostas` text NOT NULL,
  `data_resposta` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(20) DEFAULT 'incomplete'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `respostas`
--

INSERT INTO `respostas` (`id`, `form_id`, `respostas`, `data_resposta`, `user_id`, `status`) VALUES
(93, 75, '{\"qid_2_QEscolhaUnicaCombobox\":\"Bom\",\"qid_3_QEscolhaUnica\":\"Sim\",\"qid_4_QEscolhaUnica\":\"Sim\",\"qid_5_QDiscursiva\":\"Nenhum ponto\",\"qid_6_QEscolhaUnica\":\"Muito bom\",\"qid_7_QEscolhaUnica\":\"N\\u00e3o\",\"qid_8_QDiscursiva\":\"\",\"qid_9_QEscolhaUnica\":\"Muito bom\",\"qid_10_QEscolhaUnica\":\"Sim\",\"qid_11_QDiscursiva\":\"\",\"qid_12_QEscolhaUnica\":\"Sim\",\"qid_13_QDiscursiva\":\"Por enquanto nada.\"}', '2024-08-23 17:35:56', 11, 'complete');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL DEFAULT '',
  `first_name` varchar(50) NOT NULL DEFAULT '',
  `last_name` varchar(50) NOT NULL DEFAULT '',
  `gender` varchar(50) NOT NULL DEFAULT '',
  `full_name` varchar(100) NOT NULL DEFAULT '',
  `picture` varchar(255) NOT NULL DEFAULT '',
  `verifiedEmail` int(11) NOT NULL DEFAULT 0,
  `token` varchar(255) NOT NULL DEFAULT '',
  `user_type` enum('admin','user') NOT NULL DEFAULT 'user',
  `password` varchar(255) DEFAULT NULL,
  `login_method` enum('google','traditional') NOT NULL DEFAULT 'google',
  `afiliacoes` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `first_name`, `last_name`, `gender`, `full_name`, `picture`, `verifiedEmail`, `token`, `user_type`, `password`, `login_method`, `afiliacoes`) VALUES
(2, 'luisgabrieltech@gmail.com', 'Luis Gabriel', 'Correia do Nascimento', '', 'Luis Gabriel Correia do Nascimento', 'https://lh3.googleusercontent.com/a/ACg8ocLtTlsHQlcZUy3P3_LJ9svPGKiMhlZudD3wZgAQDSmGUAC9RQ=s96-c', 1, '111571378791851563973', 'admin', NULL, 'google', ''),
(11, 'aronguejotv@gmail.com', '', '', '', 'Dev Gabriel', 'https://lh3.googleusercontent.com/a/ACg8ocJKhhfDw402YYXKn225QnWfFvOJPuEFsZGLL_LYwnQyMhaVDM4=s96-c', 1, '106934743880281201072', 'user', NULL, 'google', 'Docente,Estudante'),
(12, 'teste@teste', '', '', '', 'teste', '', 0, 'a99fef0bd20898b61982c6bb16f37cab', 'user', '$2y$10$Mmv9lFe5g6bMJgVTPaFBd.NzJkN7t7WfdzsqsfHQYTqqtaJBgbocq', 'traditional', 'Estudante');

-- --------------------------------------------------------

--
-- Table structure for table `votacoes`
--

CREATE TABLE `votacoes` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `data_inicio` datetime DEFAULT NULL,
  `data_fim` datetime DEFAULT NULL,
  `aberta` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `votacoes`
--

INSERT INTO `votacoes` (`id`, `titulo`, `descricao`, `data_inicio`, `data_fim`, `aberta`) VALUES
(4, 'Eleicoes CPA 2024', '', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `votos`
--

CREATE TABLE `votos` (
  `id` int(11) NOT NULL,
  `votacao_id` int(11) NOT NULL,
  `opcao_id` int(11) NOT NULL,
  `data_voto` datetime DEFAULT current_timestamp(),
  `user_token` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `votos`
--

INSERT INTO `votos` (`id`, `votacao_id`, `opcao_id`, `data_voto`, `user_token`) VALUES
(6, 4, 15, '2024-08-23 12:26:49', '526fd257499c2506aac1300ddf586c6c');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `formulario`
--
ALTER TABLE `formulario`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `opcoes_voto`
--
ALTER TABLE `opcoes_voto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `votacao_id` (`votacao_id`);

--
-- Indexes for table `respostas`
--
ALTER TABLE `respostas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `form_id` (`form_id`),
  ADD KEY `fk_respostas_users` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `votacoes`
--
ALTER TABLE `votacoes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `votos`
--
ALTER TABLE `votos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `votacao_id` (`votacao_id`),
  ADD KEY `opcao_id` (`opcao_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `formulario`
--
ALTER TABLE `formulario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `opcoes_voto`
--
ALTER TABLE `opcoes_voto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `respostas`
--
ALTER TABLE `respostas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `votacoes`
--
ALTER TABLE `votacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `votos`
--
ALTER TABLE `votos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `opcoes_voto`
--
ALTER TABLE `opcoes_voto`
  ADD CONSTRAINT `opcoes_voto_ibfk_1` FOREIGN KEY (`votacao_id`) REFERENCES `votacoes` (`id`);

--
-- Constraints for table `respostas`
--
ALTER TABLE `respostas`
  ADD CONSTRAINT `fk_respostas_formulario` FOREIGN KEY (`form_id`) REFERENCES `formulario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_respostas_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `votos`
--
ALTER TABLE `votos`
  ADD CONSTRAINT `votos_ibfk_1` FOREIGN KEY (`votacao_id`) REFERENCES `votacoes` (`id`),
  ADD CONSTRAINT `votos_ibfk_2` FOREIGN KEY (`opcao_id`) REFERENCES `opcoes_voto` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
