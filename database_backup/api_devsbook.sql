-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.4.11-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              10.3.0.5771
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Copiando estrutura para tabela project-devsbook.postcomments
CREATE TABLE IF NOT EXISTS `postcomments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_post` int(11) unsigned NOT NULL DEFAULT 0,
  `id_user` int(11) unsigned NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `body` text CHARACTER SET utf8 NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Copiando dados para a tabela project-devsbook.postcomments: ~0 rows (aproximadamente)
DELETE FROM `postcomments`;
/*!40000 ALTER TABLE `postcomments` DISABLE KEYS */;
/*!40000 ALTER TABLE `postcomments` ENABLE KEYS */;

-- Copiando estrutura para tabela project-devsbook.postlikes
CREATE TABLE IF NOT EXISTS `postlikes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_post` int(11) unsigned NOT NULL DEFAULT 0,
  `id_user` int(11) unsigned NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Copiando dados para a tabela project-devsbook.postlikes: ~0 rows (aproximadamente)
DELETE FROM `postlikes`;
/*!40000 ALTER TABLE `postlikes` DISABLE KEYS */;
/*!40000 ALTER TABLE `postlikes` ENABLE KEYS */;

-- Copiando estrutura para tabela project-devsbook.posts
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(20) CHARACTER SET utf8 NOT NULL,
  `created_at` datetime NOT NULL,
  `body` text CHARACTER SET utf8 NOT NULL DEFAULT '',
  `like_count` int(11) NOT NULL DEFAULT 0,
  `id_user` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- Copiando dados para a tabela project-devsbook.posts: ~4 rows (aproximadamente)
DELETE FROM `posts`;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` (`id`, `type`, `created_at`, `body`, `like_count`, `id_user`) VALUES
	(1, 'text', '2020-04-29 19:54:14', 'Post danado', 0, 1),
	(2, 'text', '2020-04-29 14:57:19', 'Teste hora\r\ndsadsa', 0, 1),
	(3, 'text', '2020-04-29 16:39:07', 'Eh menino em', 0, 1),
	(4, 'photo', '2020-04-29 16:58:13', '1.jpg', 0, 1);
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;

-- Copiando estrutura para tabela project-devsbook.userrelations
CREATE TABLE IF NOT EXISTS `userrelations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_from` int(11) NOT NULL DEFAULT 0,
  `user_to` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;

-- Copiando dados para a tabela project-devsbook.userrelations: ~2 rows (aproximadamente)
DELETE FROM `userrelations`;
/*!40000 ALTER TABLE `userrelations` DISABLE KEYS */;
INSERT INTO `userrelations` (`id`, `user_from`, `user_to`) VALUES
	(6, 2, 1),
	(12, 1, 2);
/*!40000 ALTER TABLE `userrelations` ENABLE KEYS */;

-- Copiando estrutura para tabela project-devsbook.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(100) CHARACTER SET utf8 NOT NULL,
  `password` varchar(200) CHARACTER SET utf8 NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `birthdate` date NOT NULL,
  `city` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `work` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `avatar` varchar(50) CHARACTER SET utf8 DEFAULT 'avatar.jpg',
  `cover` varchar(50) CHARACTER SET utf8 DEFAULT 'cover.jpg',
  `token` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Copiando dados para a tabela project-devsbook.users: ~2 rows (aproximadamente)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `email`, `password`, `name`, `birthdate`, `city`, `work`, `avatar`, `cover`, `token`) VALUES
	(1, 'lucaslgr1206@gmail.com', '$2y$10$Xjow6gecutSY.S5DmkpPnu5OND0nc3K4SEbSP1UNYZoPXexHo9XWW', 'Lucas Guimarães da Rocha', '1996-06-12', 'Laranjal', 'Engenheiro', 'avatar.jpg', 'cover.jpg', '2c268895f9f7b82fd770f0d4576fd3f1'),
	(2, 'kaka@gmail.com', '$2y$10$AjJmhITRiKYcqrx.cnBeYedPHhJRPE.n6Twe9YBqtaFvJpRzkaZ/i', 'Karine', '1997-06-18', NULL, NULL, 'avatar.jpg', 'cover.jpg', '5b5c0fb61235b4d3df4f84e0d6a734b7');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
