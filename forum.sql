-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mar 30 Janvier 2018 à 14:01
-- Version du serveur :  5.7.11
-- Version de PHP :  7.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `forum`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `cat_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `categories`
--

INSERT INTO `categories` (`id`, `cat_name`) VALUES
(1, 'C++'),
(2, 'PHP'),
(3, 'AUTO / MOTO'),
(4, 'JEUX VIDEO'),
(5, 'JARDINAGE'),
(6, 'LINUX'),
(7, 'WINDOWS'),
(8, 'IPHONE'),
(9, 'MATERIEL INFORMATIQUE'),
(10, 'ELECTRICITE'),
(11, 'BRICOLAGE'),
(12, 'CUISINE'),
(13, 'CINEMA'),
(14, 'MUSIQUE'),
(15, 'PHOTO'),
(17, 'VTT'),
(18, 'JAVASCRIPT'),
(19, 'AUTRE');

-- --------------------------------------------------------

--
-- Structure de la table `grants`
--

CREATE TABLE `grants` (
  `id` int(11) NOT NULL,
  `grant_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `grants`
--

INSERT INTO `grants` (`id`, `grant_name`) VALUES
(1, 'CREATE_SUBJECT'),
(2, 'CREATE_POST'),
(3, 'EDIT_HIS_POST'),
(4, 'REMOVE_HIS_POST'),
(5, 'REMOVE_POST'),
(6, 'REMOVE_SUBJECT'),
(7, 'CREATE_CATEGORIE'),
(8, 'CLOSE_SUBJECT'),
(9, 'REOPEN_SUBJECT');

-- --------------------------------------------------------

--
-- Structure de la table `link_role_grant`
--

CREATE TABLE `link_role_grant` (
  `id_role` int(11) NOT NULL,
  `id_grant` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `link_role_grant`
--

INSERT INTO `link_role_grant` (`id_role`, `id_grant`) VALUES
(1, 1),
(2, 1),
(3, 1),
(1, 2),
(2, 2),
(3, 2),
(1, 3),
(2, 3),
(3, 3),
(1, 4),
(2, 4),
(3, 4),
(1, 5),
(2, 5),
(1, 6),
(1, 7),
(1, 8),
(2, 8),
(1, 9),
(2, 9);

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `id_subject` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `post_content` varchar(1000) NOT NULL,
  `date_post` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `posts`
--

INSERT INTO `posts` (`id`, `id_subject`, `id_user`, `post_content`, `date_post`) VALUES
(116, 42, 6, 'Nunc vitae purus imperdiet, pharetra orci ac, laoreet purus. Suspendisse euismod posuere nulla, sed blandit ipsum luctus et. Morbi lorem mi, consequat eu eleifend eget, porta a nibh. Aenean ante eros, congue quis ultricies in, consequat non lorem. Aliquam ut porttitor nisi. Nunc malesuada diam odio, non cursus mauris volutpat sit amet. Maecenas iaculis velit elit, in cursus neque venenatis eu. Morbi non erat nec dolor tincidunt lacinia quis eget justo. Sed tempus, dolor nec lobortis porttitor, ipsum enim condimentum felis, eu commodo ipsum ligula eu neque. Vivamus rutrum sem neque. Praesent at blandit velit, nec viverra purus. Vivamus sit amet ipsum imperdiet, fringilla massa sed, lacinia libero. Nunc venenatis ac purus vel porttitor. Praesent aliquam velit urna, et dictum elit lacinia in. Fusce vitae accumsan lectus, auctor placerat metus.', '2018-01-30 11:44:03'),
(117, 43, 6, 'PHP', '2018-01-30 11:45:06'),
(118, 44, 6, 'coucou', '2018-01-30 11:45:26'),
(120, 46, 6, 'Coucou,\r\n\r\nC&#039;est la loose !', '2018-01-30 11:46:26'),
(121, 43, 4, 'coucou PHP', '2018-01-30 11:48:12'),
(122, 42, 4, 'Nunc pellentesque dignissim odio, at placerat tortor varius vitae. Maecenas fermentum arcu quis justo volutpat, vitae efficitur dui vestibulum. Etiam et ipsum turpis. Nulla aliquet velit nec tortor tincidunt, non dignissim dui volutpat. Nullam placerat enim quis mattis condimentum. Praesent commodo et ipsum vel tincidunt. Phasellus elementum, mauris quis efficitur eleifend, lectus tortor tincidunt ligula, in fringilla dui elit facilisis ante. Nullam vitae mattis ipsum. Curabitur ac urna tempor, ullamcorper turpis id, euismod enim. Donec accumsan rutrum elementum. In dictum lorem ligula, eget ultricies justo mattis in. FusceMERDEcongue non mauris ut semper. Nulla facilisi. Nam blandit ipsum dui, nec feugiat quam suscipit quis. Nullam a mauris id risus ultricies cursus. Proin pharetra accumsan malesuada. ', '2018-01-30 11:48:50'),
(123, 47, 4, 'Bonjour,\r\n\r\nOn m&#039;a volÃ© mon VTT place Cassagne il y 2 jours. Quelqu&#039;un a t-il vu mon Lapierre Titane trainÃ© dans les parages ?', '2018-01-30 11:50:32'),
(124, 47, 5, 'Bonjour,\r\n\r\nNon pas vu...\r\nA mon avis il est dÃ©jÃ  trop tard.\r\nDÃ©solÃ© et bon courage Ã  toi !', '2018-01-30 11:51:12'),
(125, 48, 5, '&lt;script&gt;\r\nalert (&quot;ERREUR SYSTEM PLZ FORMAT YOuR HARd DRIVE DISK&quot;)\r\n&lt;/script&gt;', '2018-01-30 11:52:43'),
(126, 48, 5, 'Encore un qui tente de l&#039;injection...\r\n\r\nVa falloir travailler sur un moyen de vous bloquer pour de bon...', '2018-01-30 11:53:19'),
(127, 49, 5, 'Alors on danse !!!!!', '2018-01-30 11:55:23'),
(128, 49, 6, 'la la la la la la la la la la\r\npapa ou t&#039;es ? ', '2018-01-30 11:55:55'),
(129, 50, 7, 'A chier !', '2018-01-30 11:57:20'),
(130, 50, 7, 'De la merde en boite !\r\n\r\nPire que les autres !', '2018-01-30 11:57:39'),
(131, 50, 7, 'A mort Disney !', '2018-01-30 11:57:48'),
(132, 50, 7, 'Aller tous mourir avec vos films de merde !!', '2018-01-30 11:58:03'),
(133, 50, 6, 'Il va se calmer le rageux ?', '2018-01-30 11:58:25'),
(134, 50, 6, 'Ou il veut mon poing dans la gueule ? ', '2018-01-30 11:58:47'),
(135, 51, 6, 'Bienvenue sur le forum de Windaube !', '2018-01-30 11:59:31'),
(136, 51, 6, 'Ici on dit du mal de Windows ! Alors on y va balancez vos critiques nÃ©gatives !!! ', '2018-01-30 12:00:11'),
(137, 52, 7, 'coucou les gars !', '2018-01-30 13:35:58'),
(138, 53, 7, 'On mange quoi ?', '2018-01-30 13:36:24'),
(139, 53, 4, 'Du pain et de l&#039;eau, j&#039;ai plus de tune...', '2018-01-30 13:37:08'),
(140, 53, 5, 'Je clos ce sujet qui sert Ã  rien !', '2018-01-30 13:37:38'),
(141, 54, 5, 'Y&#039;a quelqu&#039;un ?', '2018-01-30 13:42:20'),
(142, 50, 5, 'En plein dans sa mouille le con !', '2018-01-30 14:14:05'),
(143, 54, 7, 'oui je suis lÃ ', '2018-01-30 14:14:54'),
(144, 54, 7, 'Je m&#039;appelle PERCEVAL. Mais on m&#039;appelle gros faisan au sud. Et au Nord c&#039;est juste ducon...\r\n', '2018-01-30 14:15:30'),
(145, 54, 4, 'Salut ducon :-D', '2018-01-30 14:15:55'),
(146, 54, 6, 'Salut le gros faisan !\r\nL&#039;Ã©quipe ADMIN te souhaite la bienvenue', '2018-01-30 14:16:35'),
(147, 50, 6, 'test test', '2018-01-30 14:17:07'),
(148, 50, 6, 'Phasellus sollicitudin felis faucibus ex dapibus laoreet. In nec gravida urna. Nunc commodo, urna quis aliquam tempor, urna eros laoreet dolor, eget pulvinar dui arcu a diam. Sed a consectetur sem, nec cursus ex. Morbi quis tincidunt enim, vitae eleifend nisl. Suspendisse potenti. Cras pellentesque at risus pretium consequat. Ut dolor massa, fringilla in erat eu, sodales malesuada lectus. Vestibulum egestas maximus ornare. Fusce non tincidunt neque, in sagittis elit. Curabitur id enim vestibulum, rutrum sem ac, iaculis magna. Praesent pharetra elementum ligula in porta. Sed tempor, augue vitae bibendum gravida, ante erat dictum ante, a laoreet nibh elit vehicula tortor. Nam luctus sit amet ligula ut lobortis. Quisque vehicula sollicitudin imperdiet. ', '2018-01-30 14:17:18'),
(149, 50, 6, '&lt;!DOCTYPE html&gt;\r\n&lt;html&gt;\r\n&lt;body&gt;\r\n\r\n&lt;p&gt;This is a paragraph.&lt;/p&gt;\r\n&lt;p&gt;This is another paragraph.&lt;/p&gt;\r\n\r\n&lt;/body&gt;\r\n&lt;/html&gt;\r\n', '2018-01-30 14:17:46'),
(150, 43, 6, 'Je vais mettre des exemples', '2018-01-30 14:18:10'),
(152, 43, 6, 'html, body {\r\n margin: 0;\r\n padding: 0;\r\n }\r\nbody {\r\n background-color: white; \r\n font-family: Verdana, sans-serif; \r\n font-size: 100%;\r\n }\r\nh1 {\r\n font-size: 200%; \r\n color: navy; \r\n text-align: center;\r\n }\r\nh2 {\r\n font-size: 150%; \r\n color: red; \r\n padding-left: 15px;\r\n }\r\np,ul,li,td {\r\n color: black; \r\n }\r\na:link {\r\n color: green;\r\n text-decoration: underline;\r\n }\r\na:visited {\r\n color: gray;\r\n }\r\na:hover {\r\n color: red;\r\n text-decoration: none;\r\n}\r\na:active, a:focus {\r\n color: red;\r\n}', '2018-01-30 14:19:47'),
(155, 43, 6, '<script>\r\nalert("test)\r\n</script>\r\n<html>\r\n <head>\r\n  <title>Test PHP</title>\r\n </head>\r\n <body>\r\n <?php echo \'<p>Bonjour le monde</p>\'; ?>\r\n </body>\r\n</html>', '2018-01-30 14:27:16'),
(161, 42, 6, '&lt;li class=\'sidebar_service_space\'&gt;&amp;nbsp;&lt;/li&gt;\r\n            &lt;li class=\'sidebar_service_title\'&gt;About Malware&lt;/li&gt;\r\n            &lt;li&gt;&lt;a href=\'&lt;?php echo \'$home\' ?&gt;/services/malware/what-is-malware.html\'&gt;What is Malware?&lt;/a&gt;&lt;/li&gt;\r\n            &lt;li&gt;&lt;a href=\'&lt;?php echo \'$home\' ?&gt;/services/malware/common-signs.html\'&gt;Common Signs of Malware&lt;/a&gt;&lt;/li&gt;\r\n            &lt;li class=\'sidebar_service_space\'&gt;&amp;nbsp;&lt;/li&gt;\r\n', '2018-01-30 14:47:48'),
(162, 42, 6, 'document.getElementById(&quot;demo&quot;).style.fontSize = &quot;25px&quot;;\r\ndocument.getElementById(&quot;demo&quot;).style.color = &quot;red&quot;;\r\ndocument.getElementById(&quot;demo&quot;).style.backgroundColor = &quot;yellow&quot;; ', '2018-01-30 14:50:51'),
(163, 42, 6, '&lt;script&gt;\r\n\r\nalert (&quot;ERREUR&quot;);\r\n&lt;/script&gt;', '2018-01-30 14:51:40');

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `roles`
--

INSERT INTO `roles` (`id`, `role_name`) VALUES
(1, 'ADMIN'),
(2, 'MODERATOR'),
(3, 'USER');

-- --------------------------------------------------------

--
-- Structure de la table `subject`
--

CREATE TABLE `subject` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `id_cat` int(11) NOT NULL,
  `close` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `subject`
--

INSERT INTO `subject` (`id`, `id_user`, `title`, `id_cat`, `close`) VALUES
(42, 6, 'lorem ipsum', 6, 0),
(43, 6, 'PHP', 2, 0),
(44, 6, 'VROUM !', 3, 0),
(46, 6, '125 CBR moto cassÃ© !', 3, 0),
(47, 4, 'Lapierre titane 96 help !', 17, 0),
(48, 5, 'Test du javascript', 18, 0),
(49, 5, 'Stromae', 14, 0),
(50, 7, 'STAR WARS 8', 13, 0),
(51, 6, 'WINDOWS', 7, 1),
(52, 7, 'Leroy Merlin', 11, 0),
(53, 7, 'Pause dÃ©jeuner', 12, 1),
(54, 5, 'Envie de causer', 19, 0);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_role` int(11) NOT NULL DEFAULT '3'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `id_role`) VALUES
(4, 'lafouine', '4f31add61a503ec0cd22ff38c93180216129d05a', 3),
(5, 'dragonball', '22fc59e6f928be48ccd28959bec607b2582a5704', 2),
(6, 'administrator', 'b4db7cc3c4ac42b7f2b70a9fff4632b6df7eb415', 1),
(7, 'lafouine1', '3afaa67dd098a1508410e257ff0b1e70a3665315', 3);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `grants`
--
ALTER TABLE `grants`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `link_role_grant`
--
ALTER TABLE `link_role_grant`
  ADD PRIMARY KEY (`id_role`,`id_grant`),
  ADD KEY `id_grant` (`id_grant`);

--
-- Index pour la table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`,`id_subject`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `post_content` (`post_content`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`id`,`id_user`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_cat` (`id_cat`),
  ADD KEY `title` (`title`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_role` (`id_role`),
  ADD KEY `username` (`username`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT pour la table `grants`
--
ALTER TABLE `grants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;
--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `link_role_grant`
--
ALTER TABLE `link_role_grant`
  ADD CONSTRAINT `link_role_grant_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `link_role_grant_ibfk_2` FOREIGN KEY (`id_grant`) REFERENCES `grants` (`id`);

--
-- Contraintes pour la table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `subject`
--
ALTER TABLE `subject`
  ADD CONSTRAINT `subject_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `subject_ibfk_2` FOREIGN KEY (`id_cat`) REFERENCES `categories` (`id`);

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
