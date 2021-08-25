-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 25 août 2021 à 10:16
-- Version du serveur :  10.4.17-MariaDB
-- Version de PHP : 7.3.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `g_courrier`
--

-- --------------------------------------------------------

--
-- Structure de la table `courrier`
--

CREATE TABLE `courrier` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `recipient_id` int(11) DEFAULT NULL,
  `date_envoie` datetime NOT NULL,
  `objet_courrier` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_courrier` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_valid` tinyint(1) NOT NULL,
  `is_read` tinyint(1) NOT NULL,
  `is_archived` tinyint(1) DEFAULT NULL,
  `is_in_trashed` tinyint(1) DEFAULT NULL,
  `is_send` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `courrier`
--

INSERT INTO `courrier` (`id`, `sender_id`, `recipient_id`, `date_envoie`, `objet_courrier`, `message`, `type_courrier`, `is_valid`, `is_read`, `is_archived`, `is_in_trashed`, `is_send`) VALUES
(5, 1, 4, '2021-08-25 00:59:56', 'Demande d\'embaucher un personnel', '<p>Bonjour,</p>', 'Courrier administration personnel', 0, 1, 0, 0, 0),
(6, 1, 4, '2021-08-25 07:54:16', 'Demande d\'embaucher un personnel', '<p>Bonjour,</p>', 'Courrier administration personnel', 0, 0, 1, 1, 0),
(7, 1, 4, '2021-08-25 08:55:50', 'Demande de validation de courrier', '<p>Bonjour,</p>', 'Courrier admin', 1, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `departement`
--

CREATE TABLE `departement` (
  `id` int(11) NOT NULL,
  `nom_departement` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `departement`
--

INSERT INTO `departement` (`id`, `nom_departement`) VALUES
(1, 'Département administration réseau'),
(2, 'Département administration personnel');

-- --------------------------------------------------------

--
-- Structure de la table `direction`
--

CREATE TABLE `direction` (
  `id` int(11) NOT NULL,
  `nom_direction` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descr_dir` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `direction`
--

INSERT INTO `direction` (`id`, `nom_direction`, `descr_dir`) VALUES
(5, 'DSI', 'Direction Système d\'Information'),
(6, 'DRH', 'Direction Ressources Humaines');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20210602173555', '2021-07-25 14:30:20', 4888),
('DoctrineMigrations\\Version20210607060348', '2021-07-25 14:30:25', 496),
('DoctrineMigrations\\Version20210607060828', '2021-07-25 14:30:26', 135),
('DoctrineMigrations\\Version20210609063959', '2021-07-25 14:30:26', 431),
('DoctrineMigrations\\Version20210725153817', '2021-07-25 15:38:31', 1170),
('DoctrineMigrations\\Version20210821131306', '2021-08-23 14:54:47', 1329),
('DoctrineMigrations\\Version20210823125439', '2021-08-23 14:54:48', 1620),
('DoctrineMigrations\\Version20210823132141', '2021-08-23 15:21:48', 188),
('DoctrineMigrations\\Version20210823142507', '2021-08-23 16:25:25', 425),
('DoctrineMigrations\\Version20210823143329', '2021-08-23 16:33:36', 321),
('DoctrineMigrations\\Version20210823143445', '2021-08-23 16:34:50', 401),
('DoctrineMigrations\\Version20210824090755', '2021-08-24 11:08:02', 1121),
('DoctrineMigrations\\Version20210824181808', '2021-08-24 20:18:22', 337);

-- --------------------------------------------------------

--
-- Structure de la table `dossier`
--

CREATE TABLE `dossier` (
  `id` int(11) NOT NULL,
  `nom_dossier` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `fonction`
--

CREATE TABLE `fonction` (
  `id` int(11) NOT NULL,
  `nom_fonction` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `fonction`
--

INSERT INTO `fonction` (`id`, `nom_fonction`) VALUES
(1, 'Développeur web'),
(2, 'Administrateur réseau');

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `titre_role` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id`, `titre_role`) VALUES
(1, 'ROLE_ADMIN'),
(3, 'ROLE_RESPONSABLE');

-- --------------------------------------------------------

--
-- Structure de la table `type_dossier`
--

CREATE TABLE `type_dossier` (
  `id` int(11) NOT NULL,
  `libelle_type_dossier` varchar(90) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `type_dossier`
--

INSERT INTO `type_dossier` (`id`, `libelle_type_dossier`) VALUES
(1, 'Dossier jurididique'),
(3, 'Dossier Systeme d\'Information');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fonction` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `nom`, `prenom`, `telephone`, `email`, `adresse`, `fonction`, `username`, `password`, `roles`) VALUES
(1, 'admin', 'admin', 'admin', 'user@gmail.com', 'admin', 'admin', 'Freddino', '$2y$13$RtvHJN3XKCfpLVPD3ojZhuakd2VOqSO0p2..hNiEkECqID7NsIhai', '[]'),
(4, 'RABARISON', 'Lewis', '034 78 945 25', 'lewis@gmail.com', 'Adiresy', 'dff', 'Lewis', '$2y$13$RtvHJN3XKCfpLVPD3ojZhuakd2VOqSO0p2..hNiEkECqID7NsIhai', '[\"ROLE_ADMIN\"]');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `courrier`
--
ALTER TABLE `courrier`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_BEF47CAAF624B39D` (`sender_id`),
  ADD KEY `IDX_BEF47CAAE92F8F78` (`recipient_id`);

--
-- Index pour la table `departement`
--
ALTER TABLE `departement`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `direction`
--
ALTER TABLE `direction`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `dossier`
--
ALTER TABLE `dossier`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `fonction`
--
ALTER TABLE `fonction`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `type_dossier`
--
ALTER TABLE `type_dossier`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `courrier`
--
ALTER TABLE `courrier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `departement`
--
ALTER TABLE `departement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `direction`
--
ALTER TABLE `direction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `dossier`
--
ALTER TABLE `dossier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `fonction`
--
ALTER TABLE `fonction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `type_dossier`
--
ALTER TABLE `type_dossier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `courrier`
--
ALTER TABLE `courrier`
  ADD CONSTRAINT `FK_BEF47CAAE92F8F78` FOREIGN KEY (`recipient_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_BEF47CAAF624B39D` FOREIGN KEY (`sender_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
