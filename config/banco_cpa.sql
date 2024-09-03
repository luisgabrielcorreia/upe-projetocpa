-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 29/05/2024 às 16:33
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
-- Banco de dados: `banco_cpa`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `formulario`
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
-- Despejando dados para a tabela `formulario`
--

INSERT INTO `formulario` (`id`, `json_formulario`, `disponivel`, `indisponivel`, `descongelado`, `congelado`, `nome_arquivo`) VALUES
(57, '[{\"type\":\"Section\",\"questionVar\":\"secao\",\"label\":\"DISCENTES - PERFIL SOCIOECONÔMICO\",\"formulario\":\"\",\"qid\":\"qid_1\",\"condicao\":\"sempre\",\"externo\":\"undefined\",\"explicacao\":\"\"},{\"type\":\"Escolha2\",\"label\":\"Qual a sua faixa etária?\",\"questionVar\":\"QEscolhaUnica\",\"opcoes\":[\"Até 20 anos\",\" De 21 a 30 anos\",\" De 31 a 40 anos\",\" De 41 a 50 anos\",\" De 51 a 60 anos\",\" De 61 a 70 anos\",\" Mais de 70 anos\"],\"qid\":\"qid_2\",\"condicao\":\"sempre\",\"var\":\"undefined\",\"explicacao\":\"\"},{\"type\":\"Escolha2\",\"label\":\"Como você se identifica em relação ao gênero? (*Cis - Identidade de gênero que corresponde ao sexo biológico *Trans - Identidade de gênero oposta ao sexo biológico *Não binário - Identidade de gênero não estabelecida)\",\"questionVar\":\"QEscolhaUnica\",\"opcoes\":[\" Homem CIS\",\" Homem Trans\",\" Mulher CIS\",\" Mulher Trans\",\" Não binário\",\" Outro\",\" Não quero declarar\"],\"qid\":\"qid_3\",\"condicao\":\"sempre\",\"var\":\"undefined\",\"explicacao\":\"\"},{\"type\":\"Escolha2\",\"label\":\"Como se declara em relação a sua cor\\/raça\\/etnia?\",\"questionVar\":\"QEscolhaUnica\",\"opcoes\":[\"Amarela\",\" Branca\",\" Indígena\",\" Parda\",\" Preta\",\" Não sei\",\" Não quero declarar\"],\"qid\":\"qid_4\",\"condicao\":\"sempre\",\"var\":\"undefined\",\"explicacao\":\"\"},{\"type\":\"Escolha2\",\"label\":\"Qual a sua renda familiar atual? (*Somando a renda de todas as pessoas que moram com você, inclusive a sua)\",\"questionVar\":\"QEscolhaUnica\",\"opcoes\":[\"Até 1.320,00 (1 salário mínimo)\",\" De 1.320,01 a 2.640,00 (Mais de 1 a 2 salários mínimos)\",\" De 2.260,01 a 3.960,00 (Mais de 2 a 3 salários mínimos)\",\" De 3.960,01 a 6.600,00 (Mais de 3 a 5 salários mínimos)\",\" De 6.600,01 a 13.200,00 (Mais de 5 a 10 salários mínimos)\",\" De 13.200,01 a 26.400,00 (Mais de 10 a 20 salários mínimos)\",\" De 26.400,01 acima (Mais de 20 salários mínimos)\",\" Não sei\",\" Não quero declarar\"],\"qid\":\"qid_5\",\"condicao\":\"sempre\",\"var\":\"undefined\",\"explicacao\":\"\"},{\"type\":\"Escolha2\",\"label\":\"E qual a sua renda pessoal mensal? (*Considere todas as suas fontes de renda)\",\"questionVar\":\"QEscolhaUnica\",\"opcoes\":[\" Até 1.320,00 (1 salário mínimo)\",\" De 1.320,01 a 2.640,00 (Mais de 1 a 2 salários mínimos)\",\" De 2.260,01 a 3.960,00 (Mais de 2 a 3 salários mínimos)\",\" De 3.960,01 a 6.600,00 (Mais de 3 a 5 salários mínimos)\",\" De 6.600,01 a 13.200,00 (Mais de 5 a 10 salários mínimos)\",\" De 13.200,01 a 26.400,00 (Mais de 10 a 20 salários mínimos)\",\" De 26.400,01 acima (Mais de 20 salários mínimos)\",\" Não sei\",\" Não quero declarar\"],\"qid\":\"qid_6\",\"condicao\":\"sempre\",\"var\":\"undefined\",\"explicacao\":\"\"},{\"type\":\"Escolha2\",\"label\":\"Quantas pessoas moram na sua casa, incluindo você?\",\"questionVar\":\"QEscolhaUnica\",\"opcoes\":[\" Moro só\",\" Eu e mais uma pessoa\",\" Eu e mais duas pessoas\",\" Eu e mais três pessoas\",\" Eu e mais quatro pessoas\",\" Eu e mais cinco pessoas\",\" Eu e mais seis pessoas\",\" Eu e mais de sete pessoas\",\" Não quero declarar\"],\"qid\":\"qid_7\",\"condicao\":\"sempre\",\"var\":\"undefined\",\"explicacao\":\"\"},{\"type\":\"MEscolha\",\"label\":\"Atualmente você possui diagnóstico médico de:\",\"questionVar\":\"QMultiplaEscolha\",\"opcoes\":[\"Deficiência Visual\",\" Deficiência Auditiva\",\" Deficiência Física\",\" Deficiência Intelectual\",\" Transtorno do Espectro Autista (TEA)\",\" Transtorno de Ansiedade Generalizada (TAG)\",\" Transtorno do Déficit de Atenção com Hiperatividade (TDAH)\",\" Mobilidade reduzida\",\" Não possuo nenhum desses diagnósticos citados acima\",\" Não quero declarar\"],\"qid\":\"qid_8\",\"condicao\":\"sempre\",\"var\":\"undefined\",\"explicacao\":\"\"},{\"type\":\"Grade\",\"label\":\"Com relação ao seu perfil, marque os itens abaixo:\",\"questionVar\":\"QGrade\",\"questoes\":[\"Cursou o Ensino Médio em escola pública?\",\"Ingressou na UPE por meio de cotas?\",\"Possui ou possuiu algum vínculo empregatício durante o curso?\"],\"opcoes\":[\"Sim\",\"Não\"],\"qid\":\"qid_9\",\"condicao\":\"sempre\",\"var\":\"undefined\",\"explicacao\":\"\"},{\"type\":\"Escolha1\",\"label\":\"Qual o ano de ingresso no curso na UPE?\",\"questionVar\":\"QEscolhaUnicaCombobox\",\"opcoes\":[\"2023\",\"2022\",\"2021\",\"2020\",\"2019\",\"2018\",\"2017\",\"2016\",\"2015\",\"2014\",\"2013\",\"2012\",\"2011\",\"2010 ou ano anterior\"],\"qid\":\"qid_10\",\"condicao\":\"sempre\",\"var\":\"undefined\",\"explicacao\":\"\"},{\"type\":\"Escolha2\",\"label\":\"Na UPE, você é estudante de graduação ou pós-graduação?\",\"questionVar\":\"QEscolhaUnica\",\"opcoes\":[\" Graduação\",\" Pós-graduação\",\" Ambos\"],\"qid\":\"qid_11\",\"condicao\":\"sempre\",\"var\":\"undefined\",\"explicacao\":\"\"},{\"type\":\"Escolha1\",\"label\":\"Discente, selecione o Campus e a Unidade onde você está matriculado(a):\",\"questionVar\":\"QEscolhaUnicaCombobox\",\"opcoes\":[\"Campus Arcoverde\",\"Campus Poli\",\"Outros\"],\"qid\":\"qid_12\",\"condicao\":\"sempre\",\"var\":\"undefined\",\"explicacao\":\"\"},{\"type\":\"Escolha1\",\"label\":\"Na GRADUAÇÃO, qual curso você está cursando?\",\"questionVar\":\"QEscolhaUnicaCombobox\",\"opcoes\":[\"Mestrado em Ciências da Saúde\",\"Mestrado em Engenharia Civil\",\"Mestrado em Enfermagem\",\"Outros\"],\"qid\":\"qid_13\",\"condicao\":\"sempre\",\"var\":\"undefined\",\"explicacao\":\"\"},{\"type\":\"Escolha1\",\"label\":\"Na PÓS-GRADUAÇÃO, qual curso você está cursando?\",\"questionVar\":\"QEscolhaUnicaCombobox\",\"opcoes\":[\"Não sou aluno da Pós-Graduação\",\"Especialização ou MBA\",\"Residência\",\"Mestrado em Enfermagem\",\"Mestrado em Educação Fisica\",\"Outros\"],\"qid\":\"qid_14\",\"condicao\":\"sempre\",\"var\":\"undefined\",\"explicacao\":\"\"},{\"type\":\"Section\",\"questionVar\":\"secao\",\"label\":\"ORGANIZAÇÃO E GESTÃO INSTITUCIONAL\",\"formulario\":\"\",\"qid\":\"qid_15\",\"condicao\":\"sempre\",\"externo\":\"undefined\",\"explicacao\":\"\"},{\"type\":\"Escolha2\",\"label\":\"Você conhece como está organizada a gestão da unidade da UPE em que estuda, ou seja, a hierarquia da gestão, coordenação de curso, coordenação setorial, direção?\",\"questionVar\":\"QEscolhaUnica\",\"opcoes\":[\" Conheço totalmente\",\" Conheço parcialmente\",\" Desconheço\"],\"qid\":\"qid_16\",\"condicao\":\"sempre\",\"var\":\"undefined\",\"explicacao\":\"\"},{\"type\":\"Grade\",\"label\":\"Sobre sua participação em espaços de representação estudantil, responda:\",\"questionVar\":\"QGrade\",\"questoes\":[\"Você participou da eleição para o seu representante de sala?\",\"Você participou da eleição para o seu representante do DA?\",\"Você participou da eleição para o seu representante do DCE?\",\"\\t\"],\"opcoes\":[\"Sim\",\"Não\",\"Não sabia dessa possibilidade\"],\"qid\":\"qid_17\",\"condicao\":\"sempre\",\"var\":\"undefined\",\"explicacao\":\"\"}]', 1, 0, 1, 0, 'FormularioTeste');

-- --------------------------------------------------------

--
-- Estrutura para tabela `respostas`
--

CREATE TABLE `respostas` (
  `id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  `respostas` text NOT NULL,
  `data_resposta` datetime NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `respostas`
--

INSERT INTO `respostas` (`id`, `form_id`, `respostas`, `data_resposta`, `user_id`) VALUES
(32, 57, '{\"qid_2_QEscolhaUnica\":\"At\\u00e9 20 anos\",\"qid_3_QEscolhaUnica\":\" Homem CIS\",\"qid_4_QEscolhaUnica\":\" Parda\",\"qid_5_QEscolhaUnica\":\" De 13.200,01 a 26.400,00 (Mais de 10 a 20 sal\\u00e1rios m\\u00ednimos)\",\"qid_6_QEscolhaUnica\":\" At\\u00e9 1.320,00 (1 sal\\u00e1rio m\\u00ednimo)\",\"qid_7_QEscolhaUnica\":\" Eu e mais duas pessoas\",\"qid_8_QMultiplaEscolha\":[\" N\\u00e3o possuo nenhum desses diagn\\u00f3sticos citados acima\"],\"qid_9_0_QGrade\":\"Sim\",\"qid_9_1_QGrade\":\"N\\u00e3o\",\"qid_9_2_QGrade\":\"Sim\",\"qid_10_QEscolhaUnicaCombobox\":\"2023\",\"qid_11_QEscolhaUnica\":\" Gradua\\u00e7\\u00e3o\",\"qid_12_QEscolhaUnicaCombobox\":\"Outros\",\"qid_13_QEscolhaUnicaCombobox\":\"Outros\",\"qid_14_QEscolhaUnicaCombobox\":\"N\\u00e3o sou aluno da P\\u00f3s-Gradua\\u00e7\\u00e3o\",\"qid_16_QEscolhaUnica\":\" Desconhe\\u00e7o\",\"qid_17_0_QGrade\":\"Sim\",\"qid_17_1_QGrade\":\"N\\u00e3o sabia dessa possibilidade\",\"qid_17_2_QGrade\":\"N\\u00e3o sabia dessa possibilidade\"}', '2024-05-29 07:10:03', 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
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
  `user_type` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `email`, `first_name`, `last_name`, `gender`, `full_name`, `picture`, `verifiedEmail`, `token`, `user_type`) VALUES
(1, 'luis.gcnascimento@upe.br', 'Luis ', 'Gabriel Correia do Nascimento', '', 'Luis Gabriel Correia do Nascimento', 'https://lh3.googleusercontent.com/a/ACg8ocLkmG_vcCxWh-b8oML6HE9dD3ctR6nCMjPsE-rv5S5GnpyRkw=s96-c', 1, '117326451071431042510', 'user'),
(2, 'luisgabrieltech@gmail.com', 'Luis Gabriel', 'Correia do Nascimento', '', 'Luis Gabriel Correia do Nascimento', 'https://lh3.googleusercontent.com/a/ACg8ocLtTlsHQlcZUy3P3_LJ9svPGKiMhlZudD3wZgAQDSmGUAC9RQ=s96-c', 1, '111571378791851563973', 'user'),
(3, 'correialuis2005@gmail.com', 'Luis Gabriel', 'Correia do Nascimento', '', 'Luis Gabriel Correia do Nascimento', 'https://lh3.googleusercontent.com/a/ACg8ocLVyIQeTukHcKNDSr4t9qWUWnhkdX9ahj0xoYtWmW5pK8A9ctec=s96-c', 1, '109991736349554301905', 'admin'),
(4, 'devluisgabriel@gmail.com', 'Luis Gabriel', 'Correia do Nascimento', '', 'Luis Gabriel Correia do Nascimento', 'https://lh3.googleusercontent.com/a/ACg8ocKABuvIJmiEVdX2sVXErsyHJwqG5CKwCOh6TNw34xMMsmCE_Q=s96-c', 1, '102295188984795183931', 'user');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `formulario`
--
ALTER TABLE `formulario`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `respostas`
--
ALTER TABLE `respostas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `form_id` (`form_id`),
  ADD KEY `fk_respostas_users` (`user_id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `formulario`
--
ALTER TABLE `formulario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de tabela `respostas`
--
ALTER TABLE `respostas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `respostas`
--
ALTER TABLE `respostas`
  ADD CONSTRAINT `fk_respostas_formulario` FOREIGN KEY (`form_id`) REFERENCES `formulario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_respostas_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
