-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Lun 29 Janvier 2018 à 15:39
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
(17, 'VTT');

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
(37, 21, 4, 'Nulla imperdiet, tellus quis pretium consequat, odio augue rutrum massa, et ullamcorper lorem enim pretium magna. Pellentesque euismod nisi ut magna eleifend rhoncus. Aenean condimentum pretium turpis vel pulvinar. Vestibulum augue nibh, gravida non pretium sit amet, semper sed tellus.&lt;br&gt;\n&lt;br&gt;\nMauris orci massa, gravida ut auctor efficitur, cursus at felis. Cras tellus nisi, ultrices eu eleifend quis, porttitor sed mi. Maecenas feugiat interdum sem. Vestibulum in pretium ipsum, nec vehicula turpis. Praesent dapibus, ipsum vitae condimentum tristique, ipsum sapien pretium metus, et mattis velit velit in enim. Mauris vel urna lobortis, porttitor nibh a, gravida nisl. Phasellus vel mollis arcu, ut pretium diam. Maecenas accumsan auctor libero, vitae egestas nibh dictum in. Nunc eget gravida ex. ', '2018-01-26 16:34:25'),
(38, 22, 4, 'Donec aliquet ante ut dui laoreet, non condimentum nulla elementum. Nullam et blandit metus. Donec sit amet felis convallis, consectetur erat ut, sagittis risus. Nulla in lectus tempor, semper lectus sed, gravida nisi. Mauris iaculis tincidunt leo, sit amet volutpat sem accumsan in. Proin dapibus metus id libero imperdiet sollicitudin. Aliquam nibh sapien, posuere sed euismod quis, porttitor vulputate lorem.&lt;br&gt;\nUt semper augue sed mi tristique, vel pharetra nunc interdum.&lt;br&gt;\nMaecenas dictum risus tellus, eu tincidunt nisl lacinia ac. Sed hendrerit et arcu vel tempus. Fusce viverra nec eros vitae feugiat. Sed dapibus turpis at sem gravida, nec porta magna volutpat. ', '2018-01-26 16:35:12'),
(39, 23, 4, 'Bonjour,&lt;br&gt;\n&lt;br&gt;\nQui veut de mon super dÃ©tecteur de fumÃ©e ? &lt;br&gt;\n&lt;br&gt;\nIl est cool !', '2018-01-26 16:39:33'),
(40, 24, 4, 'Cras viverra, massa id bibendum commodo, ante ligula hendrerit nunc, eu laoreet mi orci in ante. Aenean eget suscipit enim. Proin et sapien est. Pellentesque sit amet pretium eros. Sed lobortis tempor magna eu placerat. Proin viverra arcu blandit ligula dictum, ut tristique eros tristique. Vivamus dignissim vitae odio eget dictum. Pellentesque et vestibulum sem. Sed ac massa vel diam ultrices molestie. Fusce eget augue lobortis, efficitur urna sit amet, faucibus lectus. Donec mattis libero nec nibh feugiat sollicitudin. Vivamus ante metus, aliquam varius nisi at, ultricies feugiat dolor. ', '2018-01-26 16:40:14'),
(41, 25, 7, 'On se rÃ©galer !', '2018-01-26 16:41:50'),
(42, 21, 7, 'Sed quis vestibulum lorem, ut mollis tortor. Quisque molestie turpis in risus dignissim vehicula. Sed consectetur, massa quis lobortis hendrerit, nibh quam volutpat nibh, ut ultricies sapien ipsum ultrices ipsum. Phasellus lobortis ex non euismod pharetra. Suspendisse dignissim nisl risus, sit amet porta massa euismod sit amet. Nulla sed feugiat justo. Cras cursus cursus ornare. Vestibulum posuere tristique nisi, quis venenatis mauris. Phasellus purus metus, pulvinar consectetur congue nec, porttitor non mauris. Mauris euismod egestas justo ac laoreet. Nullam at malesuada risus. Nunc libero mauris, rutrum sed pulvinar quis, rhoncus vel felis. Donec vel odio vehicula, mollis turpis ut, ultricies risus. Vestibulum dictum aliquet sem vel tincidunt. ', '2018-01-26 16:42:04'),
(43, 21, 7, 'C\'est tout bon bon !', '2018-01-26 16:42:13'),
(44, 21, 7, 'tu comfirmes ?', '2018-01-26 16:42:20'),
(45, 22, 7, 'Demain si tu veux, je ne peux pas ce soir... J\'ai poney aquatique...', '2018-01-26 16:42:42'),
(46, 26, 7, 'Pellentesque placerat sem ac condimentum luctus. Duis tempor fringilla blandit. Nam dapibus mi id elit elementum tempor. Pellentesque ut ante ante. Proin suscipit lobortis nibh id ultricies. Phasellus bibendum accumsan dictum. Ut vel convallis lacus, non dapibus lorem. Nulla pellentesque, augue vitae rhoncus laoreet, quam lorem hendrerit purus, nec posuere libero est at risus. Suspendisse tellus nulla, auctor et eros vel, molestie malesuada arcu. Cras mattis aliquet erat in laoreet. Donec erat felis, ultricies ut sagittis sed, placerat eget dolor. Vivamus aliquet blandit dui, nec vehicula arcu. Donec efficitur dictum tortor quis rhoncus. Curabitur iaculis tortor diam, sit amet rutrum libero bibendum sit amet. Etiam feugiat, augue sed fermentum ultricies, eros metus ornare quam, sed semper augue orci et odio. ', '2018-01-26 16:43:14'),
(47, 27, 7, 'Help plz !', '2018-01-26 16:43:52'),
(48, 27, 6, 'Bonjour, \r\n\r\nVoici le lien vers la documentation officielle de PHP :\r\nhttp://php.net/\r\n\r\nCordialement,\r\nL\'Ã©quipe Admin', '2018-01-26 16:45:13'),
(49, 26, 6, 'Tant qu\'il trouve des cons pour payer...\r\n\r\nCordialement,\r\nL\'Ã©quipe ADMIN', '2018-01-26 16:46:12'),
(50, 23, 6, 'On s\'en fout !', '2018-01-26 16:46:22'),
(51, 29, 6, ' Sed in volutpat turpis. Quisque magna enim, gravida nec diam ac, interdum rutrum mauris. Sed magna odio, consectetur et auctor quis, semper non quam. Cras pulvinar nisl ac purus molestie porta. Cras auctor lectus vitae rhoncus laoreet. Nunc imperdiet, enim egestas consectetur mollis, sapien justo placerat ipsum, ut commodo turpis diam vitae sem. Phasellus varius urna non est accumsan placerat ut nec mauris. Maecenas pellentesque mi eget justo efficitur, et bibendum quam placerat. Morbi lorem arcu, rhoncus dapibus nulla ut, scelerisque laoreet tellus. Donec sagittis tincidunt leo eget fermentum. Ut quis congue felis. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.&lt;br&gt;\n&lt;br&gt;\nIn hac habitasse platea dictumst. &lt;br&gt;\n&lt;br&gt;\nNam ornare lectus et dui imperdiet tristique. Suspendisse sit amet erat molestie erat finibus ultricies. &lt;br&gt;\nPhasellus quis sapien a diam gravida pharetra.', '2018-01-26 16:52:42'),
(52, 29, 4, 'Cras viverra, massa id bibendum commodo, ante ligula hendrerit nunc, eu laoreet mi orci in ante. Aenean eget suscipit enim. Proin et sapien est.', '2018-01-26 16:53:31'),
(53, 29, 4, 'mysql select retour chariot', '2018-01-26 16:53:39'),
(54, 22, 4, 'Va pour demain !', '2018-01-26 16:54:03'),
(55, 22, 5, 'PrÃ©sent aussi demain ! Je vous dÃ©fonce :-) !', '2018-01-26 16:55:06'),
(56, 21, 6, 'Nunc justo magna, finibus non pharetra ac, accumsan non mauris. Fusce at purus a dui tristique auctor. Suspendisse suscipit quam in dui aliquam, tristique consequat arcu ultrices. Curabitur vulputate, turpis ut accumsan maximus, ante diam suscipit odio, non ultricies mauris enim ut nisl. Nam quis quam eget est posuere pretium at nec eros. Nulla pharetra euismod consequat. Nunc sed convallis velit, sed posuere nisl. Nam vitae mauris est. Etiam sapien diam, sollicitudin eget lorem quis, auctor iaculis lorem. Duis a quam elementum risus viverra pulvinar. Mauris sed semper ex. Praesent suscipit, enim nec vestibulum eleifend, risus lectus egestas lacus, ut ornare eros metus et metus. Vestibulum interdum lectus vitae mattis congue. ', '2018-01-29 09:07:21'),
(77, 21, 6, '&lt;div class=&quot;tablecontent&quot;&gt;\r\n                &lt;table cellpadding=&quot;0&quot; cellspacing=&quot;0&quot; border=&quot;0&quot;&gt;\r\n                    &lt;tbody class=&quot;tablecontent&quot;&gt;\r\n                        &lt;?php echo $stafftable?&gt;\r\n                    &lt;/tbody&gt;        \r\n                &lt;/table&gt;\r\n            &lt;/div&gt;', '2018-01-29 09:50:40'),
(98, 38, 6, '&lt;div class=&quot;tablecontent&quot;&gt;\r\n                &lt;table cellpadding=&quot;0&quot; cellspacing=&quot;0&quot; border=&quot;0&quot;&gt;\r\n                    &lt;tbody class=&quot;tablecontent&quot;&gt;\r\n                        &lt;?php echo $stafftable?&gt;\r\n                    &lt;/tbody&gt;        \r\n                &lt;/table&gt;\r\n            &lt;/div&gt;', '2018-01-29 10:19:04'),
(99, 38, 6, '&lt;div class=&quot;tablecontent&quot;&gt;\r\n                &lt;table cellpadding=&quot;0&quot; cellspacing=&quot;0&quot; border=&quot;0&quot;&gt;\r\n                    &lt;tbody class=&quot;tablecontent&quot;&gt;\r\n                        &lt;?php echo $stafftable?&gt;\r\n                    &lt;/tbody&gt;        \r\n                &lt;/table&gt;\r\n            &lt;/div&gt;', '2018-01-29 10:19:13'),
(100, 39, 5, 'klkl', '2018-01-29 11:35:18'),
(101, 21, 7, 'toto\r\nest\r\nbeau', '2018-01-29 12:44:21'),
(102, 39, 5, 'coucou', '2018-01-29 14:31:14'),
(103, 39, 5, 'ouais youpi le sujet est de nouveau ouvert !!!!!!!', '2018-01-29 14:40:34'),
(104, 38, 6, 'gls,glkgdkrdkr', '2018-01-29 15:19:00'),
(105, 24, 6, 'Parle franÃ§ais bordel !', '2018-01-29 16:29:07'),
(106, 24, 6, 'Parle franÃ§ais bordel !', '2018-01-29 16:29:08');

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
(21, 4, 'ProblÃ¨me en C++ j\'ai besoin d\'aide !', 1, 0),
(22, 4, 'Cherche du monde pour un zombie COD 3 !', 4, 0),
(23, 4, 'DÃ©tecteur de fumÃ©e pas cher !', 11, 0),
(24, 4, 'Cherche les coordonnÃ©es d\'un bon electricien Ã  Perpignan !', 10, 0),
(25, 7, 'Recette de nouilles sautÃ©es sauce aigre douce tÃ© tÃ© bon ^^', 12, 0),
(26, 7, 'Question sur le remake de StartCraft premier du nom', 4, 0),
(27, 7, 'Cherche de la documentation sur PHP !', 2, 0),
(29, 6, 'Windows Server 2012', 7, 0),
(38, 6, 'test', 2, 0),
(39, 5, 'kkllkk', 1, 0);

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
  ADD KEY `id_user` (`id_user`);

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
  ADD KEY `id_cat` (`id_cat`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_role` (`id_role`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT pour la table `grants`
--
ALTER TABLE `grants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;
--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
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
