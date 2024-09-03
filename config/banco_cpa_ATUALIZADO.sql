-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2024 at 05:22 PM
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
  `nome_arquivo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `formulario`
--

INSERT INTO `formulario` (`id`, `json_formulario`, `disponivel`, `indisponivel`, `descongelado`, `congelado`, `nome_arquivo`) VALUES
(67, '[{\"type\":\"Texto\",\"label\":\"Qual seu nome?\",\"questionVar\":\"nome\",\"qid\":\"qid_1\",\"condicao\":\"sempre\",\"var\":\"nome\",\"explicacao\":\"\"},{\"type\":\"MEscolha\",\"label\":\"Qual seu setor?\",\"questionVar\":\"seuSetor\",\"opcoes\":[\"Tecnologico\",\"Educacional\",\"Administrativo\"],\"qid\":\"qid_2\",\"condicao\":\"sempre\",\"var\":\"seuSetor\",\"explicacao\":\"\"},{\"type\":\"Section\",\"label\":\"Tecnologico\",\"qid\":\"qid_3\",\"condicao\":\"seuSetor=Tecnologico\",\"var\":\"\",\"explicacao\":\"\"},{\"type\":\"Texto\",\"label\":\"O que você acha do setor Tecnologico na UPE?\",\"questionVar\":\"op_tecnologico\",\"qid\":\"qid_4\",\"condicao\":\"seuSetor=Tecnologico\",\"var\":\"op_tecnologico\",\"explicacao\":\"\"},{\"type\":\"Texto\",\"label\":\"Quem é a chefia imediata do seu setor?\",\"questionVar\":\"chefia_tecnologico\",\"qid\":\"qid_5\",\"condicao\":\"seuSetor=Tecnologico\",\"var\":\"chefia_tecnologico\",\"explicacao\":\"\"},{\"type\":\"Section\",\"label\":\"Educacional\",\"qid\":\"qid_6\",\"condicao\":\"seuSetor=Educacional\",\"var\":\"\",\"explicacao\":\"\"},{\"type\":\"Texto\",\"label\":\"O que você acha do setor Educacional na UPE?\",\"questionVar\":\"op_educacional\",\"qid\":\"qid_7\",\"condicao\":\"seuSetor=Educacional\",\"var\":\"op_educacional\",\"explicacao\":\"\"},{\"type\":\"Texto\",\"label\":\"Quem é a chefia imediata do seu setor?\",\"questionVar\":\"chefia_educacional\",\"qid\":\"qid_8\",\"condicao\":\"seuSetor=Educacional\",\"var\":\"chefia_educacional\",\"explicacao\":\"\"},{\"type\":\"Section\",\"label\":\"Administrativo\",\"qid\":\"qid_9\",\"condicao\":\"seuSetor=Administrativo\",\"var\":\"\",\"explicacao\":\"\"},{\"type\":\"Texto\",\"label\":\"O que você acha do setor Administrativo na UPE?\",\"questionVar\":\"op_administrativo\",\"qid\":\"qid_10\",\"condicao\":\"seuSetor=Administrativo\",\"var\":\"op_administrativo\",\"explicacao\":\"\"},{\"type\":\"Texto\",\"label\":\"Quem é a chefia imediata do seu setor?\",\"questionVar\":\"chefia_administrativo\",\"qid\":\"qid_11\",\"condicao\":\"seuSetor=Administrativo\",\"var\":\"chefia_administrativo\",\"explicacao\":\"\"}]', 0, 1, 1, 1, 'RonaldoFenomenoATT'),
(69, '[{\"type\":\"Section\",\"questionVar\":\"secao\",\"label\":\"Avaliação Geral\",\"formulario\":\"\",\"qid\":\"qid_1\",\"condicao\":\"sempre\",\"externo\":\"undefined\",\"explicacao\":\"\"},{\"type\":\"Escolha1\",\"label\":\"Como você classificaria sua experiência geral com a plataforma ?\",\"questionVar\":\"QEscolhaUnicaCombobox\",\"opcoes\":[\"Muito bom\",\"Bom\",\"Intermediário\",\"Ruim\",\"Muito Ruim\"],\"qid\":\"qid_2\",\"condicao\":\"sempre\",\"var\":\"undefined\",\"explicacao\":\"\"},{\"type\":\"Escolha2\",\"label\":\"O website foi fácil de navegar?\",\"questionVar\":\"QEscolhaUnica\",\"opcoes\":[\"Sim\",\"Não\"],\"qid\":\"qid_3\",\"condicao\":\"sempre\",\"var\":\"undefined\",\"explicacao\":\"\"},{\"type\":\"Escolha2\",\"label\":\"Encontrou facilmente o que estava procurando?\",\"questionVar\":\"QEscolhaUnica\",\"opcoes\":[\"Sim\",\"Não\"],\"qid\":\"qid_4\",\"condicao\":\"sempre\",\"var\":\"undefined\",\"explicacao\":\"\"},{\"type\":\"Texto\",\"label\":\"Houve algum ponto no site que você achou confuso ou difícil de entender?\",\"questionVar\":\"QDiscursiva\",\"qid\":\"qid_5\",\"condicao\":\"sempre\",\"var\":\"undefined\",\"explicacao\":\"\"},{\"type\":\"Escolha2\",\"label\":\"A plataforma carregou rapidamente para você?\",\"questionVar\":\"QEscolhaUnica\",\"opcoes\":[\"Muito bom\",\"Bom\",\"Intermediário\",\"Ruim\",\"Muito ruim\"],\"qid\":\"qid_6\",\"condicao\":\"sempre\",\"var\":\"undefined\",\"explicacao\":\"\"},{\"type\":\"Escolha2\",\"label\":\"Teve algum problema técnico enquanto usava a plataforma?\",\"questionVar\":\"QEscolhaUnica\",\"opcoes\":[\"Sim\",\"Não\"],\"qid\":\"qid_7\",\"condicao\":\"sempre\",\"var\":\"problema_tecnico\",\"explicacao\":\"\"},{\"type\":\"Texto\",\"label\":\"Explique seu problema técnico\",\"questionVar\":\"QDiscursiva\",\"qid\":\"qid_8\",\"condicao\":\"problema_tecnico=Sim\",\"var\":\"resposta_problema_tecnico\",\"explicacao\":\"\"},{\"type\":\"Escolha2\",\"label\":\"Como você classificaria o design visual da nossa plataforma?\",\"questionVar\":\"QEscolhaUnica\",\"opcoes\":[\"Muito bom\",\"Bom\",\"Intermediário\",\"Ruim\",\"Muito ruim\"],\"qid\":\"qid_9\",\"condicao\":\"sempre\",\"var\":\"undefined\",\"explicacao\":\"\"},{\"type\":\"Escolha2\",\"label\":\"O design da plataforma é agradável e atraente?\",\"questionVar\":\"QEscolhaUnica\",\"opcoes\":[\"Sim\",\"Não\"],\"qid\":\"qid_10\",\"condicao\":\"sempre\",\"var\":\"design_site\",\"explicacao\":\"\"},{\"type\":\"Texto\",\"label\":\"Como acha que podemos melhorar o design?\",\"questionVar\":\"QDiscursiva\",\"qid\":\"qid_11\",\"condicao\":\"design_site=Não\",\"var\":\"resposta_design_site\",\"explicacao\":\"\"},{\"type\":\"Escolha2\",\"label\":\"Você se sentiu incentivado a interagir mais com a plataforma?\",\"questionVar\":\"QEscolhaUnica\",\"opcoes\":[\"Sim\",\"Não\"],\"qid\":\"qid_12\",\"condicao\":\"sempre\",\"var\":\"undefined\",\"explicacao\":\"\"},{\"type\":\"Texto\",\"label\":\"Há algo que você gostaria de sugerir para melhorar nossa plataforma?\",\"questionVar\":\"QDiscursiva\",\"qid\":\"qid_13\",\"condicao\":\"sempre\",\"var\":\"undefined\",\"explicacao\":\"\"}]', 1, 0, 1, 0, 'AvaliacaoWebsite'),
(70, '[{\"type\":\"Texto\",\"label\":\"Questao de teste1\",\"questionVar\":\"QDiscursiva\",\"qid\":\"qid_1\",\"condicao\":\"sempre\",\"var\":\"teste1\",\"explicacao\":\"\"},{\"type\":\"Texto\",\"label\":\"Questao de teste2\",\"questionVar\":\"QDiscursiva\",\"qid\":\"qid_2\",\"condicao\":\"sempre\",\"var\":\"teste2\",\"explicacao\":\"\"},{\"type\":\"MEscolha\",\"label\":\"Questao teste3\",\"questionVar\":\"QEscolhaUnicaCombobox\",\"opcoes\":[\"opcaoteste1\",\"opcaoteste2\",\"opcaoteste3\"],\"qid\":\"qid_3\",\"condicao\":\"sempre\",\"var\":\"teste3\",\"explicacao\":\"\"}]', 1, 0, 1, 0, 'auto-save-test');

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
(88, 70, '{\"qid_1_QDiscursiva\":\"teste1\",\"qid_2_QDiscursiva\":\"teste2\",\"QEscolhaUnicaCombobox\":[\"opcaoteste3\"]}', '2024-07-12 15:50:50', 6, 'complete'),
(89, 69, '{\"qid_2_QEscolhaUnicaCombobox\":\"Bom\",\"qid_3_QEscolhaUnica\":\"Sim\",\"qid_4_QEscolhaUnica\":\"Sim\",\"qid_5_QDiscursiva\":\"Nenhum ponto dificil\",\"qid_6_QEscolhaUnica\":\"Muito bom\",\"qid_7_QEscolhaUnica\":\"N\\u00e3o\",\"qid_8_QDiscursiva\":\"\",\"qid_9_QEscolhaUnica\":\"Muito bom\",\"qid_10_QEscolhaUnica\":\"Sim\",\"qid_11_QDiscursiva\":\"\",\"qid_12_QEscolhaUnica\":\"Sim\",\"qid_13_QDiscursiva\":\"Nada a melhorar por hora.\"}', '2024-07-12 16:56:29', 6, 'complete');

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
  `login_method` enum('google','traditional') NOT NULL DEFAULT 'google'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `first_name`, `last_name`, `gender`, `full_name`, `picture`, `verifiedEmail`, `token`, `user_type`, `password`, `login_method`) VALUES
(1, 'luis.gcnascimento@upe.br', 'Luis ', 'Gabriel Correia do Nascimento', '', 'Luis Gabriel Correia do Nascimento', 'https://lh3.googleusercontent.com/a/ACg8ocLkmG_vcCxWh-b8oML6HE9dD3ctR6nCMjPsE-rv5S5GnpyRkw=s96-c', 1, '117326451071431042510', 'user', NULL, 'google'),
(2, 'luisgabrieltech@gmail.com', 'Luis Gabriel', 'Correia do Nascimento', '', 'Luis Gabriel Correia do Nascimento', 'https://lh3.googleusercontent.com/a/ACg8ocLtTlsHQlcZUy3P3_LJ9svPGKiMhlZudD3wZgAQDSmGUAC9RQ=s96-c', 1, '111571378791851563973', 'admin', NULL, 'google'),
(3, 'correialuis2005@gmail.com', 'Luis Gabriel', 'Correia do Nascimento', '', 'Luis Gabriel Correia do Nascimento', 'https://lh3.googleusercontent.com/a/ACg8ocLVyIQeTukHcKNDSr4t9qWUWnhkdX9ahj0xoYtWmW5pK8A9ctec=s96-c', 1, '109991736349554301905', 'admin', NULL, 'google'),
(4, 'devluisgabriel@gmail.com', 'Luis Gabriel', 'Correia do Nascimento', '', 'Luis Gabriel Correia do Nascimento', 'https://lh3.googleusercontent.com/a/ACg8ocKABuvIJmiEVdX2sVXErsyHJwqG5CKwCOh6TNw34xMMsmCE_Q=s96-c', 1, '102295188984795183931', 'user', NULL, 'google'),
(6, 'aronguejotv@gmail.com', '', '', '', 'Luis Gabriel Correia do Nascimento', '', 0, '02b68e289e549a37c204809f906f89eb', 'user', '$2y$10$hz3uviwgvZi5KYAKEGIBfeQ3YE0ls2xWd/m24f34doNIda2ElHKlO', 'traditional'),
(7, 'Jose200Alprado@gmail.com', '', '', '', 'Jose Almeida Prado', '', 0, '99318d870c76d86d43c909f251009aeb', 'user', '$2y$10$QmaXekewWvDOy0H0EroTRe9q.VyBSm5sLQKo82dUjskv9gpfduQXW', 'traditional');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `formulario`
--
ALTER TABLE `formulario`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `formulario`
--
ALTER TABLE `formulario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `respostas`
--
ALTER TABLE `respostas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `respostas`
--
ALTER TABLE `respostas`
  ADD CONSTRAINT `fk_respostas_formulario` FOREIGN KEY (`form_id`) REFERENCES `formulario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_respostas_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
