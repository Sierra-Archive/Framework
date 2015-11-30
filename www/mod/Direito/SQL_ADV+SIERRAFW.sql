-- phpMyAdmin SQL Dump
-- version 3.5.8.1deb1
-- http://www.phpmyadmin.net
--
-- Máquina: localhost
-- Data de Criação: 16-Jul-2013 às 01:45
-- Versão do servidor: 5.5.31-0ubuntu0.13.04.1
-- versão do PHP: 5.4.9-4ubuntu2.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de Dados: `Cliente_Adv`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `agenda`
--

CREATE TABLE IF NOT EXISTS `agenda` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_admin` bigint(20) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `data` datetime NOT NULL,
  `texto` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `agenda`
--

INSERT INTO `agenda` (`id`, `id_admin`, `titulo`, `data`, `texto`) VALUES
(1, 1, 'fh', '2012-07-09 20:00:00', 'hf'),
(2, 1, 'Reunião com diogo', '2012-07-27 23:00:00', 'Reunião sobre o seu celso!');

-- --------------------------------------------------------

--
-- Estrutura da tabela `arquivos`
--

CREATE TABLE IF NOT EXISTS `arquivos` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_processo` bigint(20) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `arquivo` varchar(255) NOT NULL,
  `obs` text NOT NULL,
  `tipo` int(1) NOT NULL DEFAULT '1' COMMENT '1 = processos / 2 = fases',
  `data` datetime NOT NULL,
  `id_admin` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `arquivos2`
--

CREATE TABLE IF NOT EXISTS `arquivos2` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_cliente` bigint(20) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `arquivo` varchar(255) NOT NULL,
  `obs` text NOT NULL,
  `tipo` int(1) NOT NULL DEFAULT '1' COMMENT '1 = processos / 2 = fases',
  `data` datetime NOT NULL,
  `id_admin` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `arquivos2`
--

INSERT INTO `arquivos2` (`id`, `id_cliente`, `titulo`, `arquivo`, `obs`, `tipo`, `data`, `id_admin`) VALUES
(1, 1, 'colubande', '641343230075513488769', '', 1, '2012-07-25 17:27:55', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `artigos`
--

CREATE TABLE IF NOT EXISTS `artigos` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `data` date NOT NULL,
  `texto` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Extraindo dados da tabela `artigos`
--

INSERT INTO `artigos` (`id`, `titulo`, `data`, `texto`) VALUES
(1, 'Titullo noticia', '2012-02-28', 'Jocãoteste126'),
(2, 'Testando 2', '2012-02-24', 'gfdgfd'),
(3, 'Testando de novo', '2012-02-27', 'sdfdsfds'),
(4, 'Testandooo', '2012-02-28', 'Testandooo'),
(5, 'Testandooo', '2012-02-28', 'Testandooo'),
(6, 'Testandooo', '2012-02-27', 'Testandooo');

-- --------------------------------------------------------

--
-- Estrutura da tabela `audiencias`
--

CREATE TABLE IF NOT EXISTS `audiencias` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tipo` bigint(20) NOT NULL,
  `id_processo` bigint(20) NOT NULL,
  `id_colaborador` bigint(20) NOT NULL,
  `data` datetime NOT NULL,
  `obs` text NOT NULL,
  `data2` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `audiencias`
--

INSERT INTO `audiencias` (`id`, `tipo`, `id_processo`, `id_colaborador`, `data`, `obs`, `data2`) VALUES
(2, 2, 2, 6, '2012-07-26 10:00:00', '', '2012-07-25 17:53:34'),
(3, 1, 1, 6, '2012-07-27 20:00:00', '', '2012-07-27 21:17:57');

-- --------------------------------------------------------

--
-- Estrutura da tabela `autores`
--

CREATE TABLE IF NOT EXISTS `autores` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_cliente` bigint(20) NOT NULL,
  `id_processo` bigint(20) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `contato` varchar(100) NOT NULL,
  `cpf` varchar(20) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `bairro` varchar(100) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `estado` varchar(2) NOT NULL,
  `cep` varchar(10) NOT NULL,
  `tel1` varchar(14) NOT NULL,
  `tel2` varchar(14) NOT NULL,
  `data` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `autores`
--

INSERT INTO `autores` (`id`, `id_cliente`, `id_processo`, `nome`, `contato`, `cpf`, `endereco`, `bairro`, `cidade`, `estado`, `cep`, `tel1`, `tel2`, `data`) VALUES
(1, 1, 1, 'Jonathas Guerra Ramos Barbosa', '', '138590527552', 'Rua Cachambi, 244 Apto 202', 'Méier', 'Rio de Janeiro', 'RJ', '22.222-222', '(21) 8294-4545', '(22) 2222-2222', '2012-07-23 06:13:41');

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

CREATE TABLE IF NOT EXISTS `clientes` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `mae` varchar(150) NOT NULL,
  `profissao` varchar(150) NOT NULL,
  `pis` varchar(25) NOT NULL,
  `municipal` varchar(20) NOT NULL,
  `estadual` varchar(20) NOT NULL,
  `ctps` varchar(25) NOT NULL,
  `ctpss` varchar(10) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `nascimento` date NOT NULL,
  `nacionalidade` varchar(60) NOT NULL,
  `estado_civil` varchar(50) NOT NULL,
  `identidade` varchar(50) NOT NULL,
  `orgao` varchar(15) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `endereco` varchar(250) NOT NULL,
  `bairro` varchar(150) NOT NULL,
  `cidade` varchar(150) NOT NULL,
  `estado` varchar(2) NOT NULL,
  `cep` varchar(10) NOT NULL,
  `email` varchar(150) NOT NULL,
  `tel1` varchar(14) NOT NULL,
  `tel2` varchar(14) NOT NULL,
  `tel3` varchar(14) NOT NULL,
  `tel4` varchar(14) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '1 = ativo / 2 = inativo',
  `resumo` longtext NOT NULL,
  `obs` longtext NOT NULL,
  `data` datetime NOT NULL,
  `id_admin` bigint(20) NOT NULL,
  `dataul` datetime NOT NULL,
  `id_admin2` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `clientes`
--

INSERT INTO `clientes` (`id`, `nome`, `mae`, `profissao`, `pis`, `municipal`, `estadual`, `ctps`, `ctpss`, `senha`, `nascimento`, `nacionalidade`, `estado_civil`, `identidade`, `orgao`, `cpf`, `endereco`, `bairro`, `cidade`, `estado`, `cep`, `email`, `tel1`, `tel2`, `tel3`, `tel4`, `status`, `resumo`, `obs`, `data`, `id_admin`, `dataul`, `id_admin2`) VALUES
(1, 'Jônatas Guerra Ramos Barbosa', 'Tânia Ramos Barbosa', 'Programador', '111.11111.11/1', '', '', '', '', '123', '1989-12-01', 'Brasileiro', 'Solteiro(a)', '26688', 'CBM', '13859052710', 'Rua Estevão Silva, 244', 'Méier', 'Rio de Janeiro', 'RJ', '11.111-111', 'jocaesa@gmail.com', '(11) 1111-1111', '(22) 2222-2222', '(33) 3333-3333', '(44) 4444-4444', 1, 'Resumão<br><br>teste', 'Observações<br><br>Observações', '2012-07-03 18:11:50', 1, '2012-07-26 18:29:10', 1),
(2, 'tttttttttttttttttttttttt', 'tttttttttttttttt', 'tttttttttt', '', '', '', '', '', '123', '0000-00-00', 'bbbb', 'Solteiro(a)', '333333', 'vvv', '11111111111111', 'rrrrrrrrrrrrrrr', 'rrrrrrrr', 'rrrrrr', 'RJ', '21.535-100', '', '(12) 2222-2222', '(22) 2222-2222', '', '', 2, '', '', '2012-07-25 17:51:29', 1, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `colaboradores`
--

CREATE TABLE IF NOT EXISTS `colaboradores` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `tel1` varchar(15) NOT NULL,
  `tel2` varchar(15) NOT NULL,
  `tel3` varchar(15) NOT NULL,
  `tel4` varchar(15) NOT NULL,
  `pagamento` int(2) NOT NULL,
  `salario` varchar(8) NOT NULL,
  `carga` int(1) NOT NULL,
  `cargo` varchar(150) NOT NULL,
  `audiencista` int(1) NOT NULL DEFAULT '1',
  `rg` varchar(150) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `cart_trab` varchar(50) NOT NULL,
  `pis` varchar(25) NOT NULL,
  `aob` varchar(25) NOT NULL,
  `admissao` date NOT NULL,
  `endereco` text NOT NULL,
  `obs` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `data` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Extraindo dados da tabela `colaboradores`
--

INSERT INTO `colaboradores` (`id`, `nome`, `email`, `senha`, `tel1`, `tel2`, `tel3`, `tel4`, `pagamento`, `salario`, `carga`, `cargo`, `audiencista`, `rg`, `cpf`, `cart_trab`, `pis`, `aob`, `admissao`, `endereco`, `obs`, `status`, `data`) VALUES
(1, 'Jonathas Guerra Ramos Barbosa', 'jocaesa@gmail.com', '123456', '2132772603', '2147483647', '', '', 5, '100,00', 8, 'Programador', 2, '26688 CBMRJ', '2147483647', '', '', '', '2011-12-01', 'Rua Cachambi, 244 Apto 202 - Cachambi - Rio de Janeiro', '', 1, '2011-12-14 08:29:30'),
(5, 'Rodrigo Toledo', '', '', '', '', '', '', 0, '', 0, '', 2, '', '0', '', '', '', '0000-00-00', '', '', 1, '2011-12-16 21:43:59'),
(6, 'Fabio Ribeiro Galhardo', 'fabio@agenciards.com.br', '', '', '', '', '', 0, '', 0, 'Advogado', 2, '', '', '', '', '', '0000-00-00', '', '', 1, '2011-12-16 21:44:17'),
(7, 'jocao', 'fds', 'fds', '(11) 1111-', '', '', '', 0, '', 0, '', 2, '', '', '', '', '', '1111-11-11', '', '', 2, '2011-12-16 21:45:54');

-- --------------------------------------------------------

--
-- Estrutura da tabela `comarcas`
--

CREATE TABLE IF NOT EXISTS `comarcas` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Extraindo dados da tabela `comarcas`
--

INSERT INTO `comarcas` (`id`, `titulo`) VALUES
(1, 'Capital'),
(2, 'Cabo Frio'),
(3, 'Angra dos Reis'),
(4, 'Búzios'),
(5, 'Meier');

-- --------------------------------------------------------

--
-- Estrutura da tabela `configuracoes`
--

CREATE TABLE IF NOT EXISTS `configuracoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) NOT NULL,
  `empresa` varchar(100) NOT NULL,
  `atuacao` text NOT NULL,
  `descricao` varchar(200) NOT NULL,
  `palavras` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `tel1` varchar(15) NOT NULL,
  `tel2` varchar(15) NOT NULL,
  `tel3` varchar(15) NOT NULL,
  `endereco` varchar(200) NOT NULL,
  `numero` int(8) NOT NULL,
  `complemento` varchar(50) NOT NULL,
  `bairro` varchar(100) NOT NULL,
  `cep` varchar(10) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `estado` varchar(2) NOT NULL,
  `likefacebook` text NOT NULL,
  `facebook` varchar(150) NOT NULL,
  `twitter` varchar(150) NOT NULL,
  `orkut` varchar(150) NOT NULL,
  `googleplus` varchar(150) NOT NULL,
  `youtube` varchar(150) NOT NULL,
  `vimeo` varchar(150) NOT NULL,
  `skype` varchar(50) NOT NULL,
  `titulo_home` varchar(100) NOT NULL,
  `texto_home` text NOT NULL,
  `foto_home` varchar(150) NOT NULL,
  `texto_escritorio` longtext NOT NULL,
  `texto_equipe` longtext NOT NULL,
  `texto_contato` longtext NOT NULL,
  `logo_sistema` varchar(150) NOT NULL,
  `logo_site` varchar(150) NOT NULL,
  `logo_16x16` varchar(150) NOT NULL,
  `logo_57x57` varchar(150) NOT NULL,
  `logo_72x72` varchar(150) NOT NULL,
  `logo_90x90` varchar(150) NOT NULL,
  `logo_114x114` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `configuracoes`
--

INSERT INTO `configuracoes` (`id`, `titulo`, `empresa`, `atuacao`, `descricao`, `palavras`, `email`, `tel1`, `tel2`, `tel3`, `endereco`, `numero`, `complemento`, `bairro`, `cep`, `cidade`, `estado`, `likefacebook`, `facebook`, `twitter`, `orkut`, `googleplus`, `youtube`, `vimeo`, `skype`, `titulo_home`, `texto_home`, `foto_home`, `texto_escritorio`, `texto_equipe`, `texto_contato`, `logo_sistema`, `logo_site`, `logo_16x16`, `logo_57x57`, `logo_72x72`, `logo_90x90`, `logo_114x114`) VALUES
(1, 'Sistema para Advogados e Escritórios de Advocacia.', 'Escritório Modelo SIS ADV', 'Direito Civil<br>Direito do Consumidor<br>Responsabilidade Civil<br>Direito da Família<br>Direito Trabalhista', 'Sistema de gerenciamento de processos jurídicos online.', 'Processos, AOB, Sistema, Online, Grátis, Site, Advogados, Advocacia, Consultas', 'contato@sisadv.com.br', '(21) 2228-3664', '(21) 4102-9999', '(21) 8299-4565', 'Avenida Rio Branco', 126, 'Sala 501', 'Méier', '20.775-182', 'Rio de Janeiro', 'RJ', 'http://www.facebook.com/cupomjr', 'http://www.facebook.com/jocaesa', 'http://www.twitter.com/jonathasjoca', 'http://www.orkut.com.br/Community?rl=cpp&cmm=27821719', 'http://plus.google.com', 'http://www.youtube.com/jocaesa', 'http://www.vimeo.com/jocaesa', 'jocaesa', 'Bem vindo ao Escritório Alberto Souza Advogados Associados.', 'Nosso objetivo é o de oferecer um tratamento diferenciado a Clientes, Colaboradores e Amigos. Visando otimizar tempo e custo, primamos pelo uso de ferramentas da tecnologia da informação, sem esquecer a pessoalidade no atendimento.<br><br>Sempre focando na solução e resultados das demandas e desafios apresentados.', '9813433187389562.jpg', 'Alberto Souza Advodados Associados é um escritório de direito que atua na área cível e empresarial, desde 2007 na cidade do Rio de Janeiro.<br><br>Apesar de jovem, o escirtório conta com a experiência de seus sócios que atuam nas diversas áreas do direito, primando-se por um atendimento pessoal e pautado na ética e total sigilo profissional.<br><br>A sociedade é formada por profissionais experientes que se dividem em cada uma das suas especialidades, com uma preocupação de constante atualização acadêmica, gerando uma advocacia com alto nível técnico, consequentemente, com excelentes resultados.<br><br>A comunicação com nossos clientes é permanente por intermédio do envio de relatórios periódicos, com ampla utilização da tecnologia da informação.', 'Nossa equipe e total formada pro advogados de respeito e bla bla bla Apesar de jovem, o escirtório conta com a experiência de seus sócios que atuam nas diversas áreas do direito, primando-se por um atendimento pessoal e pautado na ética e total sigilo profissional.', 'Texto contato!', '613433140714495.png', '', '3013433164965563.png', '', '', '', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `contraria`
--

CREATE TABLE IF NOT EXISTS `contraria` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_cliente` bigint(20) NOT NULL,
  `id_processo` bigint(20) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `contato` varchar(100) NOT NULL,
  `cpf` varchar(20) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `bairro` varchar(100) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `estado` varchar(2) NOT NULL,
  `cep` varchar(10) NOT NULL,
  `tel1` varchar(14) NOT NULL,
  `tel2` varchar(14) NOT NULL,
  `data` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `contraria`
--

INSERT INTO `contraria` (`id`, `id_cliente`, `id_processo`, `nome`, `contato`, `cpf`, `endereco`, `bairro`, `cidade`, `estado`, `cep`, `tel1`, `tel2`, `data`) VALUES
(1, 1, 1, 'Guanapel', '', '12545263252', 'Rau Bernardo de Figueireido, 53/86', 'Penha', 'Rio de Janeiro', 'RJ', '', '(21) 2561-7949', '', '2012-07-23 06:15:27');

-- --------------------------------------------------------

--
-- Estrutura da tabela `emails`
--

CREATE TABLE IF NOT EXISTS `emails` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `emails`
--

INSERT INTO `emails` (`id`, `email`) VALUES
(1, 'jocaesa@gmail.com'),
(2, 'joca_esa@hotmail.com'),
(3, 'diogo@contato.com.br');

-- --------------------------------------------------------

--
-- Estrutura da tabela `equipe`
--

CREATE TABLE IF NOT EXISTS `equipe` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `texto` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Extraindo dados da tabela `equipe`
--

INSERT INTO `equipe` (`id`, `titulo`, `foto`, `texto`) VALUES
(1, 'Jânio Stefanelli Albuquerque Santos', '861331045212677429199.jpg', 'Advogado formado na Universade Estácio de Sá, com mais de 4 anos de experiência. É pós graduando na Fundação Escola do Ministério Público e Advogado atuante como Assessor Jurídico da Comissão Permanente de Defesa do Consumidor da Câmara Municípal.'),
(2, 'Diogo Marques da Silva Costa', '861331044423859039306.jpg', 'Advogado formado na Universade Estácio de Sá, com mais de 4 anos de experiência. É pós graduando na Fundação Escola do Ministério Público e Advogado atuante como Assessor Jurídico da Comissão Permanente de Defesa do Consumidor da Câmara Municípal.'),
(4, 'Ricardo Leitão Jeijó Cristo', '931331045197246704101.jpg', 'Advogado formado na Universade Estácio de Sá, com mais de 4 anos de experiência. É pós graduando na Fundação Escola do Ministério Público e Advogado atuante como Assessor Jurídico da Comissão Permanente de Defesa do Consumidor da Câmara Municípal.'),
(5, 'Joana da Silva Lindheagler', '', 'Advogado formado na Universade Estácio de Sá, com mais de 4 anos de experiência. É pós graduando na Fundação Escola do Ministério Público e Advogado atuante como Assessor Jurídico da Comissão Permanente de Defesa do Consumidor da Câmara Municípal.'),
(6, 'Paula Silveira da Costa', '441343319542341583251.jpg', 'Advogado formado na Universade Estácio de Sá, com mais de 4 anos de experiência. É pós graduando na Fundação Escola do Ministério Público e Advogado atuante como Assessor Jurídico da Comissão Permanente de Defesa do Consumidor da Câmara Municípal.');

-- --------------------------------------------------------

--
-- Estrutura da tabela `fases`
--

CREATE TABLE IF NOT EXISTS `fases` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tipo` bigint(20) NOT NULL,
  `id_processo` bigint(20) NOT NULL,
  `data` date NOT NULL,
  `obs` text NOT NULL,
  `data2` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `fases`
--

INSERT INTO `fases` (`id`, `tipo`, `id_processo`, `data`, `obs`, `data2`) VALUES
(1, 1, 1, '2012-07-22', '', '2012-07-23 06:05:59'),
(2, 2, 2, '2012-07-26', '', '2012-07-25 17:53:48');

-- --------------------------------------------------------

--
-- Estrutura da tabela `legislacoes`
--

CREATE TABLE IF NOT EXISTS `legislacoes` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `data` date NOT NULL,
  `texto` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Extraindo dados da tabela `legislacoes`
--

INSERT INTO `legislacoes` (`id`, `titulo`, `data`, `texto`) VALUES
(1, 'Teste 2', '2012-02-27', 'CONSTANTE DE TERMO DE ADESÃO INSTITUÍDO PELA LEI COMPLEMENTAR 110/2001'),
(2, 'Teste 1', '2012-02-28', 'Teste texto 1<br>'),
(3, 'Teste 3', '2012-02-14', 'artigos'),
(4, 'Testandooo', '2012-02-21', 'Testandooo'),
(5, 'Testandooo', '2012-02-28', 'Testandooo'),
(6, 'Testandooo', '2012-02-28', 'Testandooo');

-- --------------------------------------------------------

--
-- Estrutura da tabela `links`
--

CREATE TABLE IF NOT EXISTS `links` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `links`
--

INSERT INTO `links` (`id`, `titulo`, `url`) VALUES
(1, 'Google', 'http://www.google.com.br'),
(2, 'Facebook', 'http://fb.com');

-- --------------------------------------------------------

--
-- Estrutura da tabela `log_sql`
--

CREATE TABLE IF NOT EXISTS `log_sql` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `query` text NOT NULL,
  `query_comando` varchar(20) NOT NULL,
  `url` varchar(255) NOT NULL,
  `log_date_add` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `log_url`
--

CREATE TABLE IF NOT EXISTS `log_url` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `tempo` float NOT NULL,
  `log_date_add` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mensagens`
--

CREATE TABLE IF NOT EXISTS `mensagens` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_cliente` bigint(20) NOT NULL,
  `id_admin` bigint(20) NOT NULL,
  `texto` varchar(255) NOT NULL,
  `data` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `mensagens`
--

INSERT INTO `mensagens` (`id`, `id_cliente`, `id_admin`, `texto`, `data`) VALUES
(1, 1, 1, 'teste<br>ação', '2012-07-26 18:53:59'),
(2, 1, 0, 'Teste resposta cliente<br>=)', '2012-07-26 19:48:19');

-- --------------------------------------------------------

--
-- Estrutura da tabela `modelopeticoes`
--

CREATE TABLE IF NOT EXISTS `modelopeticoes` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `data` date NOT NULL,
  `texto` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `noticias`
--

CREATE TABLE IF NOT EXISTS `noticias` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `data` date NOT NULL,
  `texto` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `noticias`
--

INSERT INTO `noticias` (`id`, `titulo`, `data`, `texto`) VALUES
(1, 'Testando notícia', '2012-07-26', 'Testando notícia Testando notíciaTestando notíciaTestando notíciaTestan do notíciaTestando notíciaTestando notíciaTest ando notí ciaTestando notícia Testando notíciaTes tando notíciaTestando notíciaTestando notíciaTestando notíciaTestando notíciaTestando notíciaTestando notí ciaTestando notíciaTestando notíciaT estando notíciaTestando notíciaTes tando notíciaTestando notíciaTestando notíciaTest ando notíciaT estando notíciaTestando notíciaTestando notíciaTes tando notíciaTest ando notíciacia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia cia');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pendrive`
--

CREATE TABLE IF NOT EXISTS `pendrive` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `data` datetime NOT NULL,
  `texto` longtext NOT NULL,
  `arquivo` text NOT NULL,
  `id_admin` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Extraindo dados da tabela `pendrive`
--

INSERT INTO `pendrive` (`id`, `titulo`, `data`, `texto`, `arquivo`, `id_admin`) VALUES
(1, 'renatolince.jpg', '2012-03-06 20:36:55', '', '', 0),
(2, 'vitorlima.jpg', '2012-03-06 20:47:32', '', '', 0),
(3, 'marianna olivaão', '2012-03-06 20:55:17', 'ão', '7413310637177483_a.jpg', 0),
(4, 'proximos.txt', '2012-03-07 17:39:24', '', '1813311383646961_s.txt', 0),
(5, 'adv.rar', '2012-03-07 17:39:25', '', '7013311383657544_v.rar', 0),
(6, 'Email MKT PHP 2010.rar', '2012-03-07 22:59:48', '', '3813311575882214_0.rar', 0),
(7, 'Email MKT PHP 2010.rar', '2012-03-07 23:01:19', '', '521331157679951_0.rar', 0),
(8, 'perfil.jpg', '2012-03-07 23:05:40', '', '5513311579405102_l.jpg', 1),
(9, 'heineken-rio-de-janeiro.jpg', '2012-03-07 23:05:59', '', '3013311579597021_o.jpg', 0),
(10, 'twitter_02.png', '2012-03-07 23:07:12', '', '4413311580321125_2.png', 0),
(11, 'João', '2012-03-07 23:09:12', 'Teste', '4213311581524282_R.jpg', 1),
(12, 'arquivos.png', '2012-07-26 17:55:17', '', '9313433181174049_s.png', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `processos`
--

CREATE TABLE IF NOT EXISTS `processos` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_cliente` bigint(20) NOT NULL,
  `numero` varchar(25) NOT NULL,
  `id_comarca` bigint(20) NOT NULL,
  `id_vara` bigint(20) NOT NULL,
  `distribuicao` date NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '1 = ativo / 2 = inativo',
  `data` datetime NOT NULL,
  `obs` text NOT NULL,
  `id_admin` bigint(20) NOT NULL,
  `dataul` datetime NOT NULL,
  `id_admin2` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `numero` (`numero`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `processos`
--

INSERT INTO `processos` (`id`, `id_cliente`, `numero`, `id_comarca`, `id_vara`, `distribuicao`, `status`, `data`, `obs`, `id_admin`, `dataul`, `id_admin2`) VALUES
(1, 1, '2010225-28.2525.2.22.2255', 3, 2, '2012-07-09', 1, '2012-07-09 19:38:10', 'Gerou apenso: 0009522-55.2010.8.19.0209', 1, '2012-07-27 21:09:26', 1),
(2, 2, '1111111-11.1111.1.11.1111', 3, 4, '2012-07-25', 1, '2012-07-25 17:52:22', '', 1, '0000-00-00 00:00:00', 0),
(3, 1, '8888888-88.8888.8.88.8888', 2, 3, '2012-07-28', 1, '2012-07-26 19:22:26', 'Testando obs<br>açai', 1, '2012-07-26 20:23:53', 1),
(4, 1, '0009522-55.2010.8.19.0209', 3, 4, '2012-07-27', 1, '2012-07-27 21:09:52', '', 1, '2012-07-27 21:09:52', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `telefones`
--

CREATE TABLE IF NOT EXISTS `telefones` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `data` datetime NOT NULL,
  `tel1` varchar(14) NOT NULL,
  `tel2` varchar(14) NOT NULL,
  `tel3` varchar(14) NOT NULL,
  `tel4` varchar(14) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `telefones`
--

INSERT INTO `telefones` (`id`, `nome`, `data`, `tel1`, `tel2`, `tel3`, `tel4`) VALUES
(1, 'Jonathas Guerra Ramos Barbosa (Programador)', '2012-03-07 18:03:33', '(21) 3277-2603', '(21) 4102-9801', '(21) 8105-0905', '(21) 7819-0755'),
(3, 'Agência RDS', '2012-03-07 18:08:37', '(21) 2228-3664', '', '', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipoaudiencias`
--

CREATE TABLE IF NOT EXISTS `tipoaudiencias` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `titulo` (`titulo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `tipoaudiencias`
--

INSERT INTO `tipoaudiencias` (`id`, `titulo`) VALUES
(1, 'Civil'),
(2, 'Criminal'),
(3, 'Tester');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipofases`
--

CREATE TABLE IF NOT EXISTS `tipofases` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `titulo` (`titulo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Extraindo dados da tabela `tipofases`
--

INSERT INTO `tipofases` (`id`, `titulo`) VALUES
(1, 'Acordo'),
(4, 'Agravo'),
(3, 'Agravo Retido'),
(2, 'Apelação'),
(6, 'Retorno');

-- --------------------------------------------------------

--
-- Estrutura da tabela `varas`
--

CREATE TABLE IF NOT EXISTS `varas` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Extraindo dados da tabela `varas`
--

INSERT INTO `varas` (`id`, `titulo`) VALUES
(1, '14º Vara Civil'),
(2, '15º Vara Regional'),
(3, '16º Vara Civil'),
(4, '10º Vara Civil'),
(5, '3º Vara Civil');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
