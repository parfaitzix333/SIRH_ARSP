-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mer. 23 sep. 2026 à 23:48
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bd_arsp`
--

-- --------------------------------------------------------

--
-- Structure de la table `affectations`
--

CREATE TABLE `affectations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employe_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `categorie_id` bigint(20) UNSIGNED DEFAULT NULL,
  `poste_id` bigint(20) UNSIGNED DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `annee_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `affectations`
--

INSERT INTO `affectations` (`id`, `employe_id`, `service_id`, `categorie_id`, `poste_id`, `date_debut`, `date_fin`, `annee_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 3, 1, '2026-09-12', NULL, 3, '2026-09-11 22:59:38', '2026-09-11 22:59:38');

-- --------------------------------------------------------

--
-- Structure de la table `annees`
--

CREATE TABLE `annees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `annee` year(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `statut` enum('active','inactive') NOT NULL DEFAULT 'inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `annees`
--

INSERT INTO `annees` (`id`, `annee`, `created_at`, `updated_at`, `statut`) VALUES
(3, '2026', '2026-09-11 16:41:45', '2026-09-11 20:54:10', 'active'),
(4, '2025', '2026-09-11 18:55:49', '2026-09-11 18:56:23', 'inactive'),
(5, '2024', '2026-09-11 18:56:37', '2026-09-11 18:56:37', 'inactive');

-- --------------------------------------------------------

--
-- Structure de la table `archives`
--

CREATE TABLE `archives` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employe_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type_document` varchar(150) NOT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `fichier` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `date_archivage` date NOT NULL,
  `archive_par` bigint(20) UNSIGNED DEFAULT NULL,
  `annee_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `archives`
--

INSERT INTO `archives` (`id`, `employe_id`, `type_document`, `titre`, `fichier`, `description`, `date_archivage`, `archive_par`, `annee_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'electronique', 'archive 1', 'archives/UciwdygyCRmupCTuzaibaRWvBh4c54yZ56mcpCrR.pdf', '-', '2026-09-13', 1, 3, '2026-09-12 22:34:50', '2026-09-12 22:34:50');

-- --------------------------------------------------------

--
-- Structure de la table `audits`
--

CREATE TABLE `audits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employe_id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(100) NOT NULL,
  `ordre` int(11) NOT NULL,
  `date_debut_service` date DEFAULT NULL,
  `date_fin_service` date DEFAULT NULL,
  `annee_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `audits`
--

INSERT INTO `audits` (`id`, `employe_id`, `role`, `ordre`, `date_debut_service`, `date_fin_service`, `annee_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'chargé de saisie', 4, '2026-09-12', NULL, 3, '2026-09-12 21:53:41', '2026-09-12 21:53:41'),
(2, 3, 'chargé de maintenance', 4, '2026-09-02', NULL, 3, '2026-09-20 11:15:26', '2026-09-20 11:15:26');

-- --------------------------------------------------------

--
-- Structure de la table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `designation` varchar(150) NOT NULL,
  `annee_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `designation`, `annee_id`, `created_at`, `updated_at`) VALUES
(1, 'Menoeuvre', 3, '2026-09-11 21:02:05', '2026-09-11 21:02:05'),
(2, 'Travailleur Semi-Qualifié', 3, '2026-09-11 21:15:03', '2026-09-11 21:15:03'),
(3, 'Travailleur Qualifié', 3, '2026-09-11 21:15:27', '2026-09-11 21:15:27');

-- --------------------------------------------------------

--
-- Structure de la table `communiques`
--

CREATE TABLE `communiques` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titre` varchar(255) NOT NULL,
  `contenu` text NOT NULL,
  `piece_jointe` varchar(255) DEFAULT NULL,
  `role_cible` varchar(100) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `date_publication` datetime DEFAULT NULL,
  `annee_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `communiques`
--

INSERT INTO `communiques` (`id`, `titre`, `contenu`, `piece_jointe`, `role_cible`, `user_id`, `date_publication`, `annee_id`, `created_at`, `updated_at`) VALUES
(6, 'Communiqué 1', 'Contenu 1 vvvvvvvvvvvvvvv dddddd ggggggggg rrrrrrrrrrrrrrrrrrrr kk', NULL, 'Employe', 2, '2026-09-03 11:01:00', 3, '2026-09-14 22:39:49', '2026-09-14 22:47:34'),
(7, 'Communiqué 2', 'Doooo fuuuu ffffff sjjjj ddff f   r ttttttttttj hhhhhhhhh', 'communiques/0GyxjyvRIfoVizy2axfNJHRANu8H3Q9VQXt8QP4p.pdf', 'tous', 2, '2026-09-09 11:11:00', 3, '2026-09-14 22:40:58', '2026-09-15 00:20:44'),
(8, 'Communiqué 3', 'ffffffffffffffffff dddddddddddddddddddddddddddd ssssssssssssssssssssssssssss', NULL, 'tous', 2, '2026-09-13 23:00:00', 3, '2026-09-14 22:44:41', '2026-09-14 22:47:16'),
(9, 'Communiqué 4', 'fffffffffffffffffffffffffff nnnnnnnnnnnnnnn rrrrrrrrrrrrrrrrrrrr ttttttttttttttttttt yyyyyyyyyyyyyy o', NULL, 'tous', 2, '2026-09-13 03:03:00', 3, '2026-09-14 22:47:06', '2026-09-14 22:47:06');

-- --------------------------------------------------------

--
-- Structure de la table `conges`
--

CREATE TABLE `conges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `designation` varchar(150) NOT NULL,
  `TYPE` enum('paye','non_paye') NOT NULL,
  `indice` enum('++','--') NOT NULL,
  `actif` tinyint(1) NOT NULL DEFAULT 1,
  `annee_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `conges`
--

INSERT INTO `conges` (`id`, `designation`, `TYPE`, `indice`, `actif`, `annee_id`, `created_at`, `updated_at`) VALUES
(1, 'congé maladit', 'paye', '++', 1, 3, '2026-09-11 22:14:08', '2026-09-15 16:53:08'),
(2, 'Congé sabatique', 'paye', '++', 1, 3, '2026-09-15 08:14:08', '2026-09-15 08:14:08');

-- --------------------------------------------------------

--
-- Structure de la table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `whatsapp` varchar(50) DEFAULT NULL,
  `tel` varchar(50) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `annee_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `contacts`
--

INSERT INTO `contacts` (`id`, `email`, `whatsapp`, `tel`, `adresse`, `longitude`, `latitude`, `annee_id`, `created_at`, `updated_at`) VALUES
(1, 'parfaitzix333@gmail.com', '+243900182599', '+243999385123', 'Av du 30 juin.comm annexs/Lubumbashi', 27.4955355, -11.6536973, 3, '2026-09-12 21:56:36', '2026-09-12 21:56:36');

-- --------------------------------------------------------

--
-- Structure de la table `demandes_conges`
--

CREATE TABLE `demandes_conges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employe_id` bigint(20) UNSIGNED NOT NULL,
  `conge_id` bigint(20) UNSIGNED NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `nombre_jour` int(11) NOT NULL,
  `motif` text DEFAULT NULL,
  `statut` enum('brouillon','soumise','validee','refusee','annulee') NOT NULL DEFAULT 'soumise',
  `valide_par` bigint(20) UNSIGNED DEFAULT NULL,
  `date_validation` datetime DEFAULT NULL,
  `commentaire_validation` text DEFAULT NULL,
  `annee_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `valide_national` tinyint(1) NOT NULL DEFAULT 0,
  `valide_secDg` tinyint(1) NOT NULL DEFAULT 0,
  `valide_serv` tinyint(1) NOT NULL DEFAULT 0,
  `piece_justificative` varchar(255) DEFAULT NULL,
  `interimaire_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `demandes_conges`
--

INSERT INTO `demandes_conges` (`id`, `employe_id`, `conge_id`, `date_debut`, `date_fin`, `nombre_jour`, `motif`, `statut`, `valide_par`, `date_validation`, `commentaire_validation`, `annee_id`, `created_at`, `updated_at`, `valide_national`, `valide_secDg`, `valide_serv`, `piece_justificative`, `interimaire_id`) VALUES
(4, 1, 1, '2026-09-24', '2026-09-26', 3, 'dfdfdfggfg', 'soumise', NULL, NULL, NULL, 3, '2026-09-22 17:46:41', '2026-09-22 22:15:03', 0, 1, 1, NULL, NULL),
(5, 1, 2, '2026-09-25', '2026-10-24', 30, 'Pause annuel', 'soumise', NULL, NULL, NULL, 3, '2026-09-22 17:48:40', '2026-09-22 17:48:40', 0, 0, 0, NULL, NULL),
(6, 1, 1, '2026-09-28', '2026-10-02', 5, 'ddddd', 'soumise', NULL, NULL, NULL, 3, '2026-09-22 18:26:42', '2026-09-22 18:26:42', 0, 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `disciplines`
--

CREATE TABLE `disciplines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employe_id` bigint(20) UNSIGNED NOT NULL,
  `sanction_id` bigint(20) UNSIGNED DEFAULT NULL,
  `etat` enum('declaree','levee') NOT NULL DEFAULT 'declaree',
  `DATE` date NOT NULL,
  `contenu` text NOT NULL,
  `annee_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `disciplines`
--

INSERT INTO `disciplines` (`id`, `employe_id`, `sanction_id`, `etat`, `DATE`, `contenu`, `annee_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'levee', '2026-09-12', 'Mumba Boaz est mise a pied avec éffet immediat.', 3, '2026-09-11 22:48:20', '2026-09-15 16:20:54');

-- --------------------------------------------------------

--
-- Structure de la table `dossiers_etude`
--

CREATE TABLE `dossiers_etude` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type_document` varchar(100) NOT NULL,
  `fichier` varchar(255) NOT NULL,
  `annee_id` bigint(20) UNSIGNED NOT NULL,
  `employe_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `employes`
--

CREATE TABLE `employes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `matricule` varchar(50) NOT NULL,
  `nom` varchar(150) NOT NULL,
  `grade_id` bigint(20) UNSIGNED DEFAULT NULL,
  `service_id` bigint(20) UNSIGNED DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `lieu_naissance` varchar(150) DEFAULT NULL,
  `province_origine` varchar(150) DEFAULT NULL,
  `territoire` varchar(150) DEFAULT NULL,
  `localite` varchar(150) DEFAULT NULL,
  `niveau_etude` varchar(150) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `annee_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `emploiyeur` varchar(50) NOT NULL DEFAULT 'ARSP',
  `date_engagement` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `employes`
--

INSERT INTO `employes` (`id`, `matricule`, `nom`, `grade_id`, `service_id`, `date_naissance`, `lieu_naissance`, `province_origine`, `territoire`, `localite`, `niveau_etude`, `user_id`, `annee_id`, `created_at`, `updated_at`, `emploiyeur`, `date_engagement`) VALUES
(1, '201', 'Mumba Kisimba Boaz', 1, 1, '2026-09-10', 'Likasi', 'Tanganyika', 'Kabalo', 'Mwenga', NULL, 4, 3, '2026-09-11 22:23:13', '2026-09-18 21:10:58', 'ARSP', '2025-10-08'),
(2, '202', 'Benjamain Hemedi', NULL, 1, '2025-12-03', 'Likasi', 'Tanganyika', 'Kabalo', 'Mwenga', 'Master/Licence(AS)', 5, 3, '2026-09-14 22:43:35', '2026-09-14 22:45:34', 'ARSP', NULL),
(3, '203', 'Bliss Ngoie', 3, 1, '2000-09-01', 'Lubumbashi', 'Haut-Lomami', 'Bukama', 'Kinkonja', 'Master/Licence(AS)', 7, 3, '2026-09-15 20:18:29', '2026-09-15 20:18:57', 'ARSP', NULL),
(4, '204', 'Numbi Kabange Guelord', 1, 1, '1996-12-25', 'Lubumbashi', 'Tanganyika', 'Kabalo', 'Mwenga', 'Master/Licence(AS)', 1, 3, '2026-09-22 18:57:32', '2026-09-22 18:57:32', 'ARSP', '2026-09-22');

-- --------------------------------------------------------

--
-- Structure de la table `face_templates`
--

CREATE TABLE `face_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employe_id` bigint(20) UNSIGNED NOT NULL,
  `face_embedding1` blob NOT NULL,
  `face_embedding2` blob DEFAULT NULL,
  `face_embedding3` blob DEFAULT NULL,
  `face_embedding4` blob DEFAULT NULL,
  `face_embedding5` blob DEFAULT NULL,
  `mouvement` enum('entree','sortie') NOT NULL,
  `heure` time NOT NULL,
  `DATE` date NOT NULL,
  `annee_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `formations`
--

CREATE TABLE `formations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `domaine` varchar(150) DEFAULT NULL,
  `intitule` varchar(200) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `nb_jour` int(11) DEFAULT NULL,
  `annee_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `formations`
--

INSERT INTO `formations` (`id`, `domaine`, `intitule`, `date_debut`, `date_fin`, `nb_jour`, `annee_id`, `created_at`, `updated_at`) VALUES
(1, 'Informatique', 'Initiation sur le leadership des equipes de terrain.', '2026-09-19', '2026-09-25', 7, 3, '2026-09-12 19:12:52', '2026-09-12 19:12:52');

-- --------------------------------------------------------

--
-- Structure de la table `formation_employes`
--

CREATE TABLE `formation_employes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `formation_id` bigint(20) UNSIGNED NOT NULL,
  `employe_id` bigint(20) UNSIGNED NOT NULL,
  `statut` varchar(100) DEFAULT NULL,
  `resultat` varchar(100) DEFAULT NULL,
  `certificat` varchar(255) DEFAULT NULL,
  `annee_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `formation_employes`
--

INSERT INTO `formation_employes` (`id`, `formation_id`, `employe_id`, `statut`, `resultat`, `certificat`, `annee_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL, NULL, 3, '2026-09-12 19:57:32', '2026-09-12 19:57:32'),
(2, 1, 1, NULL, 'excellent', 'formations-employes/vdBEv2Lpo3XigtHmBSiVN5BUZoQqFAD7XSV7h5Zo.pdf', 3, '2026-09-12 22:30:49', '2026-09-12 22:30:49');

-- --------------------------------------------------------

--
-- Structure de la table `grades`
--

CREATE TABLE `grades` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `numero` int(11) NOT NULL,
  `designation` varchar(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `grades`
--

INSERT INTO `grades` (`id`, `numero`, `designation`, `created_at`, `updated_at`) VALUES
(1, 1, 'CC', '2026-09-15 13:04:49', '2026-09-15 13:04:49'),
(2, 2, 'CS', '2026-09-15 13:08:40', '2026-09-15 13:08:40'),
(3, 3, 'CB', '2026-09-15 13:22:46', '2026-09-15 13:22:46'),
(4, 3, 'CD', '2026-09-15 13:24:18', '2026-09-15 13:24:18');

-- --------------------------------------------------------

--
-- Structure de la table `historiques`
--

CREATE TABLE `historiques` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `annee_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `historiques`
--

INSERT INTO `historiques` (`id`, `user_id`, `action`, `ip`, `annee_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'Création d\'une année : 2026', NULL, 3, '2026-09-11 16:41:45', '2026-09-11 16:41:45'),
(2, 1, 'Mise à jour de l\'année : 2026', NULL, 3, '2026-09-11 16:41:54', '2026-09-11 16:41:54'),
(3, 1, 'Mise à jour de l\'année : 2026', NULL, 3, '2026-09-11 16:42:05', '2026-09-11 16:42:05'),
(4, 1, 'Mise à jour de l\'année : 2026', NULL, 3, '2026-09-11 16:48:20', '2026-09-11 16:48:20'),
(5, 1, 'Mise à jour de l\'année : 2026', NULL, 3, '2026-09-11 16:50:37', '2026-09-11 16:50:37'),
(6, 1, 'Mise à jour de l\'année : 2026', NULL, 3, '2026-09-11 16:50:40', '2026-09-11 16:50:40'),
(7, 1, 'Mise à jour de l\'année : 2026', NULL, 3, '2026-09-11 16:50:43', '2026-09-11 16:50:43'),
(8, 1, 'Mise à jour de l\'utilisateur : dg', NULL, 3, '2026-09-11 18:50:37', '2026-09-11 18:50:37'),
(9, 1, 'Mise à jour de l\'utilisateur : dg', NULL, 3, '2026-09-11 18:51:51', '2026-09-11 18:51:51'),
(10, 1, 'Mise à jour de l\'utilisateur : dg', NULL, 3, '2026-09-11 18:52:09', '2026-09-11 18:52:09'),
(11, 1, 'Mise à jour de l\'utilisateur : dg', NULL, 3, '2026-09-11 18:52:57', '2026-09-11 18:52:57'),
(12, 1, 'Création d\'une année : 2024', NULL, 3, '2026-09-11 18:55:49', '2026-09-11 18:55:49'),
(13, 1, 'Mise à jour de l\'année : 2025', NULL, 3, '2026-09-11 18:56:23', '2026-09-11 18:56:23'),
(14, 1, 'Création d\'une année : 2024', NULL, 3, '2026-09-11 18:56:37', '2026-09-11 18:56:37'),
(16, 1, 'Création de la catégorie : Menoeuvre', NULL, 3, '2026-09-11 21:02:05', '2026-09-11 21:02:05'),
(17, 1, 'Création de la catégorie : Travailleur Semi-Qualifié', NULL, 3, '2026-09-11 21:15:03', '2026-09-11 21:15:03'),
(18, 1, 'Création de la catégorie : Travailleur Qualifié', NULL, 3, '2026-09-11 21:15:27', '2026-09-11 21:15:27'),
(22, 1, 'Suppression de tous les historiques sélectionnées parDirecteur JONAS', '127.0.0.1', 3, '2026-09-11 22:06:15', '2026-09-11 22:06:15'),
(23, 1, 'Mise à jour de la catégorie : Menoeuvre', '127.0.0.1', 3, '2026-09-11 22:10:59', '2026-09-11 22:10:59'),
(24, 1, 'Mise à jour du service : Supervision de ponctualité', '127.0.0.1', 3, '2026-09-11 22:12:09', '2026-09-11 22:12:09'),
(25, 1, 'Création du type de congé : congé maladit', '127.0.0.1', 3, '2026-09-11 22:14:08', '2026-09-11 22:14:08'),
(26, 1, 'Mise à jour du type de congé : congé maladit', '127.0.0.1', 3, '2026-09-11 22:14:35', '2026-09-11 22:14:35'),
(27, 1, 'Mise à jour du type de congé : congé maladit', '127.0.0.1', 3, '2026-09-11 22:14:44', '2026-09-11 22:14:44'),
(28, 1, 'Création de l’employé : Mumba Kisimba Boaz', '127.0.0.1', 3, '2026-09-11 22:23:13', '2026-09-11 22:23:13'),
(29, 1, 'Mise à jour de l’employé : Mumba Kisimba Boaz', '127.0.0.1', 3, '2026-09-11 22:34:35', '2026-09-11 22:34:35'),
(30, 1, 'Mise à jour de l’employé : Mumba Kisimba Boaz', '127.0.0.1', 3, '2026-09-11 22:34:44', '2026-09-11 22:34:44'),
(31, 1, 'Création de la sanction : Mise à pied', '127.0.0.1', 3, '2026-09-11 22:47:04', '2026-09-11 22:47:04'),
(32, 1, 'Création de la discipline #1', '127.0.0.1', 3, '2026-09-11 22:48:20', '2026-09-11 22:48:20'),
(33, 1, 'Création du poste : Operateur de saisie', '127.0.0.1', 3, '2026-09-11 22:50:03', '2026-09-11 22:50:03'),
(34, 1, 'Création de l’affectation #1', '127.0.0.1', 3, '2026-09-11 22:59:38', '2026-09-11 22:59:38'),
(35, 1, 'Création de la formation : Initiation sur le leadership des equipes de terrain.', '127.0.0.1', 3, '2026-09-12 19:12:52', '2026-09-12 19:12:52'),
(36, 1, 'Création de l’inscription à la formation #1', '127.0.0.1', 3, '2026-09-12 19:57:32', '2026-09-12 19:57:32'),
(37, 1, 'Création du mouvement #1', '127.0.0.1', 3, '2026-09-12 20:05:25', '2026-09-12 20:05:25'),
(38, 1, 'Mise à jour du mouvement #1', '127.0.0.1', 3, '2026-09-12 20:20:58', '2026-09-12 20:20:58'),
(39, 1, 'Mise à jour du mouvement #1', '127.0.0.1', 3, '2026-09-12 20:21:03', '2026-09-12 20:21:03'),
(40, 1, 'Mise à jour du mouvement #1', '127.0.0.1', 3, '2026-09-12 20:27:17', '2026-09-12 20:27:17'),
(41, 1, 'Création du communiqué : Communiqué 1', '127.0.0.1', 3, '2026-09-12 21:06:36', '2026-09-12 21:06:36'),
(42, 1, 'Création du communiqué : Communiqué 2', '127.0.0.1', 3, '2026-09-12 21:10:43', '2026-09-12 21:10:43'),
(43, 1, 'Création du communiqué : Communiqué 3', '127.0.0.1', 3, '2026-09-12 21:18:32', '2026-09-12 21:18:32'),
(44, 1, 'Mise à jour du communiqué : Communiqué 3', '127.0.0.1', 3, '2026-09-12 21:18:58', '2026-09-12 21:18:58'),
(45, 1, 'Mise à jour du communiqué : Communiqué 3', '127.0.0.1', 3, '2026-09-12 21:41:30', '2026-09-12 21:41:30'),
(46, 1, 'Mise à jour du communiqué : Communiqué 2', '127.0.0.1', 3, '2026-09-12 21:44:59', '2026-09-12 21:44:59'),
(47, 1, 'Création de l’audit #1', '127.0.0.1', 3, '2026-09-12 21:53:41', '2026-09-12 21:53:41'),
(48, 1, 'Mise à jour de l’audit #1', '127.0.0.1', 3, '2026-09-12 21:53:49', '2026-09-12 21:53:49'),
(49, 1, 'Ajout d\'un contact : parfaitzix333@gmail.com', '127.0.0.1', 3, '2026-09-12 21:56:36', '2026-09-12 21:56:36'),
(50, 1, 'Création de la propriété : A propos de nous', '127.0.0.1', 3, '2026-09-12 22:04:24', '2026-09-12 22:04:24'),
(51, 1, 'Création du règlement #1', '127.0.0.1', 3, '2026-09-12 22:08:53', '2026-09-12 22:08:53'),
(52, 1, 'Mise à jour du règlement #1', '127.0.0.1', 3, '2026-09-12 22:09:20', '2026-09-12 22:09:20'),
(53, 1, 'Mise à jour du règlement #1', '127.0.0.1', 3, '2026-09-12 22:09:55', '2026-09-12 22:09:55'),
(54, 1, 'Mise à jour du règlement #1', '127.0.0.1', 3, '2026-09-12 22:19:25', '2026-09-12 22:19:25'),
(55, 1, 'Création de l’inscription à la formation #2', '127.0.0.1', 3, '2026-09-12 22:30:49', '2026-09-12 22:30:49'),
(56, 1, 'Création de l’archive #1', '127.0.0.1', 3, '2026-09-12 22:34:50', '2026-09-12 22:34:50'),
(57, 1, 'Mise à jour de l\'utilisateur : Directeur JONAS', NULL, 3, '2026-09-13 00:08:17', '2026-09-13 00:08:17'),
(58, 1, 'Mise à jour de l\'utilisateur : Directeur JONAS', NULL, 3, '2026-09-13 00:09:27', '2026-09-13 00:09:27'),
(59, 1, 'Mise à jour de l\'utilisateur : Directeur JONAS', NULL, 3, '2026-09-13 00:09:33', '2026-09-13 00:09:33'),
(60, 1, 'Mise à jour de l\'utilisateur : Directeur JONAS', NULL, 3, '2026-09-13 00:09:47', '2026-09-13 00:09:47'),
(61, 1, 'Mise à jour de l\'utilisateur : Directeur JONAS', NULL, 3, '2026-09-13 00:11:52', '2026-09-13 00:11:52'),
(62, 1, 'Mise à jour de l\'utilisateur : Directeur JONAS', NULL, 3, '2026-09-13 00:11:56', '2026-09-13 00:11:56'),
(63, 1, 'Mise à jour de l\'utilisateur : Abigael', NULL, 3, '2026-09-13 10:37:08', '2026-09-13 10:37:08'),
(64, 1, 'Mise à jour de l\'utilisateur : Abigael', NULL, 3, '2026-09-13 12:49:36', '2026-09-13 12:49:36'),
(65, 1, 'Mise à jour de l\'utilisateur : Abigael', NULL, 3, '2026-09-13 12:50:25', '2026-09-13 12:50:25'),
(66, 1, 'Mise à jour de l\'utilisateur : Abigael', NULL, 3, '2026-09-13 13:08:36', '2026-09-13 13:08:36'),
(67, 1, 'Mise à jour de l\'utilisateur : Abigael', NULL, 3, '2026-09-13 13:09:40', '2026-09-13 13:09:40'),
(68, 1, 'Mise à jour de l\'utilisateur : Abigael', NULL, 3, '2026-09-13 13:12:41', '2026-09-13 13:12:41'),
(69, 2, 'Mise à jour de l’affectation #1', '127.0.0.1', 3, '2026-09-13 13:13:27', '2026-09-13 13:13:27'),
(70, 2, 'Mise à jour de l\'utilisateur : numbi', NULL, 3, '2026-09-13 20:42:46', '2026-09-13 20:42:46'),
(71, 1, 'Mise à jour de l\'utilisateur : numbi', NULL, 3, '2026-09-13 21:59:01', '2026-09-13 21:59:01'),
(72, 1, 'Mise à jour de l\'utilisateur : Mumba Kisimba Boaz', NULL, 3, '2026-09-13 23:45:07', '2026-09-13 23:45:07'),
(73, 2, 'Suppression du communiqué : Communiqué 1', '127.0.0.1', 3, '2026-09-14 21:47:37', '2026-09-14 21:47:37'),
(74, 2, 'Suppression du communiqué : Communiqué 2', '127.0.0.1', 3, '2026-09-14 21:47:39', '2026-09-14 21:47:39'),
(75, 2, 'Suppression du communiqué : Communiqué 3', '127.0.0.1', 3, '2026-09-14 21:47:56', '2026-09-14 21:47:56'),
(76, 2, 'Création du communiqué : Titre 2', '127.0.0.1', 3, '2026-09-14 22:34:26', '2026-09-14 22:34:26'),
(77, 2, 'Suppression du communiqué : Titre 2', '127.0.0.1', 3, '2026-09-14 22:39:07', '2026-09-14 22:39:07'),
(78, 2, 'Suppression du communiqué : Titre 1', '127.0.0.1', 3, '2026-09-14 22:39:10', '2026-09-14 22:39:10'),
(79, 2, 'Création du communiqué : Communiqué 1', '127.0.0.1', 3, '2026-09-14 22:39:49', '2026-09-14 22:39:49'),
(80, 2, 'Création du communiqué : Communiqué 2', '127.0.0.1', 3, '2026-09-14 22:40:58', '2026-09-14 22:40:58'),
(81, 2, 'Création de l’employé : Benjamain Hemedi', '127.0.0.1', 3, '2026-09-14 22:43:35', '2026-09-14 22:43:35'),
(82, 2, 'Création du communiqué : Communiqué 3', '127.0.0.1', 3, '2026-09-14 22:44:41', '2026-09-14 22:44:41'),
(83, 2, 'Création du communiqué : Communiqué 4', '127.0.0.1', 3, '2026-09-14 22:47:06', '2026-09-14 22:47:06'),
(84, 2, 'Mise à jour du communiqué : Communiqué 3', '127.0.0.1', 3, '2026-09-14 22:47:16', '2026-09-14 22:47:16'),
(85, 2, 'Mise à jour du communiqué : Communiqué 2', '127.0.0.1', 3, '2026-09-14 22:47:25', '2026-09-14 22:47:25'),
(86, 2, 'Mise à jour du communiqué : Communiqué 1', '127.0.0.1', 3, '2026-09-14 22:47:34', '2026-09-14 22:47:34'),
(87, 2, 'Mise à jour du communiqué : Communiqué 2', '127.0.0.1', 3, '2026-09-15 00:20:44', '2026-09-15 00:20:44'),
(88, 4, 'Soumission de la demande de congé #1', '127.0.0.1', 3, '2026-09-15 08:14:08', '2026-09-15 08:14:08'),
(89, 3, 'Validation de la demande de congé #1 par le Chef Service', '127.0.0.1', 3, '2026-09-15 09:05:00', '2026-09-15 09:05:00'),
(90, 3, 'Rejet de la demande de congé #1 par le Chef Service', '127.0.0.1', 3, '2026-09-15 09:05:16', '2026-09-15 09:05:16'),
(91, 3, 'Validation de la demande de congé #1 par le Chef Service', '127.0.0.1', 3, '2026-09-15 09:05:21', '2026-09-15 09:05:21'),
(92, 2, 'Validation de la demande de congé #1 par le SecDG', '127.0.0.1', 3, '2026-09-15 09:36:03', '2026-09-15 09:36:03'),
(93, 4, 'Soumission de la demande de congé #2', '127.0.0.1', 3, '2026-09-15 10:35:23', '2026-09-15 10:35:23'),
(94, 3, 'Validation de la demande de congé #2 par le Chef Service', '127.0.0.1', 3, '2026-09-15 10:35:44', '2026-09-15 10:35:44'),
(95, 2, 'Validation niveau SecDG de la demande #2', '127.0.0.1', 3, '2026-09-15 10:40:39', '2026-09-15 10:40:39'),
(96, 2, 'Création du grade : CC', '127.0.0.1', 3, '2026-09-15 13:04:49', '2026-09-15 13:04:49'),
(97, 2, 'Création du grade : CS', '127.0.0.1', 3, '2026-09-15 13:08:40', '2026-09-15 13:08:40'),
(98, 2, 'Création du grade : CB', '127.0.0.1', 3, '2026-09-15 13:22:46', '2026-09-15 13:22:46'),
(99, 2, 'Création du grade : CD', '127.0.0.1', 3, '2026-09-15 13:24:18', '2026-09-15 13:24:18'),
(100, 2, 'Mise à jour de l’employé : Mumba Kisimba Boaz', '127.0.0.1', 3, '2026-09-15 13:31:03', '2026-09-15 13:31:03'),
(101, 2, 'Validation nationale de la demande #2', '127.0.0.1', 3, '2026-09-15 16:12:10', '2026-09-15 16:12:10'),
(102, 2, 'Mise à jour de la discipline #1', '127.0.0.1', 3, '2026-09-15 16:20:54', '2026-09-15 16:20:54'),
(103, 2, 'Mise à jour du type de congé : congé maladit', '127.0.0.1', 3, '2026-09-15 16:52:20', '2026-09-15 16:52:20'),
(104, 2, 'Mise à jour du type de congé : congé maladit', '127.0.0.1', 3, '2026-09-15 16:53:08', '2026-09-15 16:53:08'),
(105, 2, 'Mise à jour de l\'utilisateur : Ruth Mputu', NULL, 3, '2026-09-15 19:20:49', '2026-09-15 19:20:49'),
(106, 2, 'Création de l’employé : Bliss Ngoie', '127.0.0.1', 3, '2026-09-15 20:18:29', '2026-09-15 20:18:29'),
(107, 2, 'Mise à jour de l\'utilisateur : Bliss Ngoie', NULL, 3, '2026-09-15 20:22:42', '2026-09-15 20:22:42'),
(108, 7, 'Soumission de la demande de congé #3', '127.0.0.1', 3, '2026-09-15 20:32:46', '2026-09-15 20:32:46'),
(109, 3, 'Validation de la demande de congé #3 par le Chef Service', '127.0.0.1', 3, '2026-09-15 20:35:36', '2026-09-15 20:35:36'),
(110, 2, 'Validation niveau SecDG de la demande #3', '127.0.0.1', 3, '2026-09-15 20:43:24', '2026-09-15 20:43:24'),
(111, 1, 'Mise à jour de l\'utilisateur : Abigael', NULL, 3, '2026-09-18 17:08:18', '2026-09-18 17:08:18'),
(112, 1, 'Mise à jour de l’employé : Mumba Kisimba Boaz', '127.0.0.1', 3, '2026-09-18 21:10:58', '2026-09-18 21:10:58'),
(113, 1, 'Mise à jour de l\'utilisateur : Abigael', NULL, 3, '2026-09-19 21:38:38', '2026-09-19 21:38:38'),
(114, 1, 'Mise à jour de l\'utilisateur : Directeur JONAS', NULL, 3, '2026-09-19 21:38:51', '2026-09-19 21:38:51'),
(115, 1, 'Mise à jour de l\'utilisateur : Directeur JONAS', NULL, 3, '2026-09-19 21:38:57', '2026-09-19 21:38:57'),
(116, 1, 'Mise à jour de l\'utilisateur : Abigael', NULL, 3, '2026-09-19 21:39:04', '2026-09-19 21:39:04'),
(117, 1, 'Mise à jour de l\'utilisateur : Ruth Mputu', NULL, 3, '2026-09-19 22:16:35', '2026-09-19 22:16:35'),
(118, 2, 'Mise à jour de la demande de congé #2', '127.0.0.1', 3, '2026-09-20 09:24:25', '2026-09-20 09:24:25'),
(119, 2, 'Mise à jour de l’intérim #1', '127.0.0.1', 3, '2026-09-20 10:57:36', '2026-09-20 10:57:36'),
(120, 2, 'Mise à jour de la demande de congé #2', '127.0.0.1', 3, '2026-09-20 11:11:58', '2026-09-20 11:11:58'),
(121, 2, 'Création de l’audit #2', '127.0.0.1', 3, '2026-09-20 11:15:26', '2026-09-20 11:15:26'),
(122, 2, 'Mise à jour de la demande de congé #2', '127.0.0.1', 3, '2026-09-20 11:38:07', '2026-09-20 11:38:07'),
(123, 2, 'Mise à jour de l’intérim #1', '127.0.0.1', 3, '2026-09-20 11:40:15', '2026-09-20 11:40:15'),
(124, 2, 'Mise à jour de la demande de congé #2', '127.0.0.1', 3, '2026-09-20 11:40:53', '2026-09-20 11:40:53'),
(125, 2, 'Suppression de l’intérim #2', '127.0.0.1', 3, '2026-09-20 11:41:57', '2026-09-20 11:41:57'),
(126, 2, 'Mise à jour de la demande de congé #2', '127.0.0.1', 3, '2026-09-20 11:42:10', '2026-09-20 11:42:10'),
(127, 1, 'Mise à jour de l\'utilisateur : Abigael', NULL, 3, '2026-09-22 17:41:33', '2026-09-22 17:41:33'),
(128, 1, 'Mise à jour de l\'utilisateur : Abigael', NULL, 3, '2026-09-22 17:42:51', '2026-09-22 17:42:51'),
(129, 4, 'Soumission de la demande de congé #4', '127.0.0.1', 3, '2026-09-22 17:46:41', '2026-09-22 17:46:41'),
(130, 2, 'Suppression de la demande de congé #3', '127.0.0.1', 3, '2026-09-22 17:48:20', '2026-09-22 17:48:20'),
(131, 2, 'Suppression de la demande de congé #2', '127.0.0.1', 3, '2026-09-22 17:48:22', '2026-09-22 17:48:22'),
(132, 4, 'Soumission de la demande de congé #5', '127.0.0.1', 3, '2026-09-22 17:48:40', '2026-09-22 17:48:40'),
(133, 4, 'Soumission de la demande de congé #6', '127.0.0.1', 3, '2026-09-22 18:26:42', '2026-09-22 18:26:42'),
(134, 2, 'Création de l’employé : Numbi Kabange Guelord', '127.0.0.1', 3, '2026-09-22 18:57:32', '2026-09-22 18:57:32'),
(135, 3, 'Validation de la demande de congé #4 par le Chef Service', '127.0.0.1', 3, '2026-09-22 20:41:05', '2026-09-22 20:41:05'),
(136, 2, 'Validation niveau SecDG de la demande #4', '127.0.0.1', 3, '2026-09-22 22:15:03', '2026-09-22 22:15:03'),
(138, 1, 'Mise à jour de l\'utilisateur : Directeur JONAS', NULL, 3, '2026-09-22 22:28:06', '2026-09-22 22:28:06'),
(139, 1, 'Mise à jour de l\'utilisateur : Directeur JONAS', NULL, 3, '2026-09-22 22:28:15', '2026-09-22 22:28:15'),
(140, 1, 'Suppression de tous les historiques sélectionnées par Directeur JONAS', '127.0.0.1', 3, '2026-09-22 22:30:28', '2026-09-22 22:30:28'),
(141, 1, 'Mise à jour de l\'utilisateur : Abigael', NULL, 3, '2026-09-23 12:57:16', '2026-09-23 12:57:16'),
(142, 1, 'Mise à jour de l\'utilisateur : Abigael', NULL, 3, '2026-09-23 13:41:19', '2026-09-23 13:41:19'),
(143, 6, 'Mise à jour de l\'utilisateur : Ruth Mputu xxxx', NULL, 3, '2026-09-23 14:47:19', '2026-09-23 14:47:19'),
(144, 6, 'Mise à jour de l\'utilisateur : Ruth Mputu', NULL, 3, '2026-09-23 14:47:26', '2026-09-23 14:47:26'),
(145, 1, 'Mise à jour de l\'utilisateur : Directeur JONAS X', NULL, 3, '2026-09-23 14:48:25', '2026-09-23 14:48:25'),
(146, 1, 'Mise à jour de l\'utilisateur : Directeur JONAS', NULL, 3, '2026-09-23 14:48:35', '2026-09-23 14:48:35'),
(147, 1, 'Mise à jour de l\'utilisateur : Ruth Mputu', NULL, 3, '2026-09-23 15:22:54', '2026-09-23 15:22:54');

-- --------------------------------------------------------

--
-- Structure de la table `interimes`
--

CREATE TABLE `interimes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employe_id` bigint(20) UNSIGNED NOT NULL,
  `interimaire_id` bigint(20) UNSIGNED DEFAULT NULL,
  `annee_id` bigint(20) UNSIGNED NOT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `interimes`
--

INSERT INTO `interimes` (`id`, `employe_id`, `interimaire_id`, `annee_id`, `date_debut`, `date_fin`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 3, NULL, NULL, '2026-09-20 09:24:25', '2026-09-20 11:40:15');

-- --------------------------------------------------------

--
-- Structure de la table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `lectures`
--

CREATE TABLE `lectures` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employe_id` bigint(20) UNSIGNED NOT NULL,
  `communique_id` bigint(20) UNSIGNED NOT NULL,
  `lu` tinyint(1) NOT NULL DEFAULT 0,
  `lu_a` timestamp NULL DEFAULT NULL,
  `annee_id` bigint(20) UNSIGNED NOT NULL DEFAULT 3,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `lectures`
--

INSERT INTO `lectures` (`id`, `employe_id`, `communique_id`, `lu`, `lu_a`, `annee_id`, `created_at`, `updated_at`) VALUES
(1, 1, 6, 1, '2026-09-15 10:34:52', 3, '2026-09-14 22:39:49', '2026-09-15 10:34:52'),
(3, 1, 8, 0, NULL, 3, '2026-09-14 22:44:41', '2026-09-14 22:44:41'),
(4, 1, 9, 1, '2026-09-15 00:15:47', 3, '2026-09-14 22:47:06', '2026-09-15 00:15:47'),
(5, 2, 9, 0, NULL, 3, '2026-09-14 22:47:06', '2026-09-14 22:47:06'),
(6, 1, 7, 1, '2026-09-15 00:21:36', 3, '2026-09-15 00:20:44', '2026-09-15 00:21:36'),
(7, 2, 7, 0, NULL, 3, '2026-09-15 00:20:44', '2026-09-15 00:20:44');

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(121, '0001_01_01_000000_create_users_table', 1),
(122, '0001_01_01_000001_create_cache_table', 1),
(123, '0001_01_01_000002_create_jobs_table', 1),
(124, '2026_09_10_214517_create_annees_table', 1),
(125, '2026_09_10_215308_create_services_table', 1),
(126, '2026_09_10_215328_create_categories_table', 1),
(127, '2026_09_10_215340_create_postes_table', 1),
(128, '2026_09_10_215405_create_employes_table', 1),
(129, '2026_09_10_215515_create_affectations_table', 1),
(130, '2026_09_10_215551_create_dossiers_etudes_table', 1),
(131, '2026_09_10_220031_create_sanctions_table', 1),
(132, '2026_09_10_220052_create_disciplines_table', 1),
(133, '2026_09_10_220852_create_formations_table', 1),
(134, '2026_09_10_220904_create_formation_employes_table', 1),
(135, '2026_09_10_220952_create_audits_table', 1),
(136, '2026_09_10_221140_create_performances_table', 1),
(137, '2026_09_10_221205_create_communiques_table', 1),
(138, '2026_09_10_221236_create_archives_table', 1),
(139, '2026_09_10_221309_create_face_templates_table', 1),
(140, '2026_09_10_221337_create_presences_table', 1),
(141, '2026_09_10_221442_create_conges_table', 1),
(142, '2026_09_10_221556_create_demandes_conges_table', 1),
(143, '2026_09_10_221636_create_proprietes_table', 1),
(144, '2026_09_10_221713_create_contacts_table', 1),
(145, '2026_09_10_221734_create_retours_table', 1),
(146, '2026_09_10_221754_create_historiques_table', 1),
(147, '2026_09_10_223640_create_reglements_table', 1),
(148, '2026_09_10_224650_create_mouvements_table', 1),
(149, '2026_09_10_230650_create_grades_table', 1),
(151, '2026_09_14_232615_create_lectures_table', 2),
(152, '2026_09_20_003728_create_interimes_table', 3),
(153, '2026_09_20_010000_make_interimaire_nullable', 4);

-- --------------------------------------------------------

--
-- Structure de la table `mouvements`
--

CREATE TABLE `mouvements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mouvement` enum('Entrée','Sortie') NOT NULL,
  `employe_id` bigint(20) UNSIGNED NOT NULL,
  `heure` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `annee_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `mouvements`
--

INSERT INTO `mouvements` (`id`, `mouvement`, `employe_id`, `heure`, `created_at`, `updated_at`, `annee_id`) VALUES
(1, 'Entrée', 1, '07:00:00', '2026-09-12 20:05:25', '2026-09-12 20:27:17', 3);

-- --------------------------------------------------------

--
-- Structure de la table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `performances`
--

CREATE TABLE `performances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employe_id` bigint(20) UNSIGNED NOT NULL,
  `evaluateur_id` bigint(20) UNSIGNED DEFAULT NULL,
  `periode_debut` date NOT NULL,
  `periode_fin` date NOT NULL,
  `objectifs` text DEFAULT NULL,
  `qualite_travail` decimal(5,2) DEFAULT NULL,
  `productivite` decimal(5,2) DEFAULT NULL,
  `ponctualite` decimal(5,2) DEFAULT NULL,
  `assiduite` decimal(5,2) DEFAULT NULL,
  `comportement` decimal(5,2) DEFAULT NULL,
  `travail_equipe` decimal(5,2) DEFAULT NULL,
  `cote_generale` decimal(5,2) DEFAULT NULL,
  `appreciation` text DEFAULT NULL,
  `recommandations` text DEFAULT NULL,
  `statut` enum('brouillon','soumise','validee') NOT NULL DEFAULT 'brouillon',
  `annee_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `performances`
--

INSERT INTO `performances` (`id`, `employe_id`, `evaluateur_id`, `periode_debut`, `periode_fin`, `objectifs`, `qualite_travail`, `productivite`, `ponctualite`, `assiduite`, `comportement`, `travail_equipe`, `cote_generale`, `appreciation`, `recommandations`, `statut`, `annee_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2026-08-01', '2026-08-31', '-', 8.00, 9.50, 0.20, 7.30, 9.00, 6.00, 40.00, 'Excellent', '-', 'brouillon', 3, '2026-09-12 23:37:50', '2026-09-12 23:46:31');

-- --------------------------------------------------------

--
-- Structure de la table `postes`
--

CREATE TABLE `postes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `intitule` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `annee_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `postes`
--

INSERT INTO `postes` (`id`, `intitule`, `description`, `annee_id`, `created_at`, `updated_at`) VALUES
(1, 'Operateur de saisie', 'Prise en charge de saisie.', 3, '2026-09-11 22:50:03', '2026-09-11 22:50:03');

-- --------------------------------------------------------

--
-- Structure de la table `presences`
--

CREATE TABLE `presences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employe_id` bigint(20) UNSIGNED NOT NULL,
  `DATE` date NOT NULL,
  `heure` time NOT NULL,
  `mouvement` enum('entree','sortie') NOT NULL,
  `score_reconnaissance` decimal(6,5) DEFAULT NULL,
  `SOURCE` varchar(50) NOT NULL DEFAULT 'desktop',
  `synchronise` tinyint(1) NOT NULL DEFAULT 0,
  `synced_at` datetime DEFAULT NULL,
  `annee_id` bigint(20) UNSIGNED NOT NULL,
  `autorisation` enum('oui','non') NOT NULL DEFAULT 'non',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `presences`
--

INSERT INTO `presences` (`id`, `employe_id`, `DATE`, `heure`, `mouvement`, `score_reconnaissance`, `SOURCE`, `synchronise`, `synced_at`, `annee_id`, `autorisation`, `created_at`, `updated_at`) VALUES
(1, 1, '2026-09-13', '07:00:00', 'entree', 1.00000, 'desktop', 1, NULL, 3, 'oui', '2026-09-12 22:57:16', '2026-09-12 22:57:16');

-- --------------------------------------------------------

--
-- Structure de la table `proprietes`
--

CREATE TABLE `proprietes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titre` varchar(200) NOT NULL,
  `nos_info` text DEFAULT NULL,
  `annee_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `proprietes`
--

INSERT INTO `proprietes` (`id`, `titre`, `nos_info`, `annee_id`, `created_at`, `updated_at`) VALUES
(1, 'A propos de nous', 'Nos information...', 3, '2026-09-12 22:04:24', '2026-09-12 22:04:24');

-- --------------------------------------------------------

--
-- Structure de la table `reglements`
--

CREATE TABLE `reglements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `numero` int(11) NOT NULL,
  `designation` varchar(500) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `titre` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `reglements`
--

INSERT INTO `reglements` (`id`, `numero`, `designation`, `created_at`, `updated_at`, `titre`) VALUES
(1, 1, 'Tout agent est tenu de respecter les heures de travail fixées par la société et de signaler toute absence ou tout retard à son supérieur hiérarchique.', '2026-09-12 22:08:53', '2026-09-12 22:19:25', 'Ponctualité et assiduité :');

-- --------------------------------------------------------

--
-- Structure de la table `retours`
--

CREATE TABLE `retours` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `retour_utilisateur` text NOT NULL,
  `annee_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sanctions`
--

CREATE TABLE `sanctions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `designation` varchar(200) NOT NULL,
  `annee_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sanctions`
--

INSERT INTO `sanctions` (`id`, `designation`, `annee_id`, `created_at`, `updated_at`) VALUES
(1, 'Mise à pied', 3, '2026-09-11 22:47:04', '2026-09-11 22:47:04');

-- --------------------------------------------------------

--
-- Structure de la table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom_service` varchar(150) NOT NULL,
  `domaine` varchar(150) DEFAULT NULL,
  `annee_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `services`
--

INSERT INTO `services` (`id`, `nom_service`, `domaine`, `annee_id`, `created_at`, `updated_at`) VALUES
(1, 'Supervision de ponctualité', 'Informatique', 3, '2026-09-11 21:19:19', '2026-09-11 21:19:19');

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('DXGSuLVdClh8DeOiI69RwGKf3wlh9Zv17cyq6Xpc', 4, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 15; Pixel 9) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Mobile Safari/537.36', 'eyJfdG9rZW4iOiJzWXRYMHBEemRRbmZkdEl2RkVIeXZUMmRqbFl3QmRwMkE3Q3RiTnVLIiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL21lc19jb25nZXMifSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9wcm9maWxlX2VtcCIsInJvdXRlIjoicHJvZmlsZV9lbXAifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6NH0=', 1790194302),
('ksGtRzluAxNHnhmWuOrP8vTmk3ChX1Q9vwhaGubn', 1, '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJXd3ZNRFZZN0t3QzRLalg3WHZlUk5LVTRrWjZTc2hyN29ibjZxTkI4IiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2xlc191dGlsaXNhdGV1cnMiLCJyb3V0ZSI6Imxlc191dGlsaXNhdGV1cnMifSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjF9', 1790184174),
('y2IvRxnBAt8OKvwrb9ijvUcCocA1X8CcCg5xo7bD', 6, '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:147.0) Gecko/20100101 Firefox/147.0', 'eyJfdG9rZW4iOiJvdndwQ1hIRnFpWWdYSmxFMTBjc2tmSHlneHZ0U0NRWURKaGxCVlVlIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2xlc19lbXBsb3llc19DRCIsInJvdXRlIjoibGVzX2VtcGxveWVzX0NEIn0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjo2fQ==', 1790191004);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `annee_id` bigint(20) DEFAULT NULL,
  `autorisation` tinyint(1) NOT NULL DEFAULT 0,
  `matricule` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `role`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `annee_id`, `autorisation`, `matricule`) VALUES
(1, 'Directeur JONAS', 'DP', 'dg@gmail.com', NULL, '$2y$12$U9xAv2VFC2.YnBuuAkRg2O/P24SZJPvtVSwJV2gxjFhZufBzKOo1u', NULL, '2026-09-10 23:09:11', '2026-09-23 14:48:35', 3, 0, NULL),
(2, 'Abigael', 'SecDG', 'aby@gmail.com', NULL, '$2y$12$HXeEfAjyQIRdg6.QvOP3H.jpyKPIVH7WnYzRkdkJp7JZIUdIUq6CC', NULL, '2026-09-12 22:53:43', '2026-09-23 13:41:19', 3, 1, NULL),
(3, 'numbi', 'Chef-Service', 'numbi@gmail.com', NULL, '$2y$12$eDrpBbWEa7V.gUGqD8aO2.JTCxklN3hwAyZfPr4lUNmzVQaZxKSQ.', NULL, '2026-09-13 20:41:49', '2026-09-13 21:59:01', 3, 1, NULL),
(4, 'Mumba Kisimba Boaz', 'Employe', 'boaz@gmail.com', NULL, '$2y$12$DMKCJBBilTe5HC2nIMA6huyZctOs.lZhXOPWp2xkPa8s/CLBkgry.', NULL, '2026-09-13 23:16:22', '2026-09-23 14:42:49', NULL, 0, '201'),
(5, 'Benjamain Hemedi', 'Employe', 'ben@gmail.com', NULL, '$2y$12$Hc2z757QR.8Jy2ntdcBpp.vbsQzJCiFwHI.AT0/0ogAnnxRfnyNTC', 'XbnIy4pNQVih4Tif9NiNtUAm51P80eNi9yPYQdSWESIz6VqTrE0rVtcq3BxX', '2026-09-14 22:45:34', '2026-09-14 22:45:34', NULL, 0, '202'),
(6, 'Ruth Mputu', 'Chef-Division', 'ruth@gmail.com', NULL, '$2y$12$3vUWj24NvQ6CP8j0ebw2vO.fP5N2hclohttQaDzWI42xnVqmD3fUW', NULL, '2026-09-15 19:17:22', '2026-09-23 15:22:54', NULL, 1, NULL),
(7, 'Bliss Ngoie', 'Chef-Bureau1', 'bliss@gmail.com', NULL, '$2y$12$Xsv/2gggCBxEV2Vtr0pJ7uWJciITQnK/YZZy.CneL0W/Isr3LItSW', NULL, '2026-09-15 20:18:57', '2026-09-15 20:22:42', NULL, 0, '203');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `affectations`
--
ALTER TABLE `affectations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `affectations_employe_id_foreign` (`employe_id`),
  ADD KEY `affectations_service_id_foreign` (`service_id`),
  ADD KEY `affectations_categorie_id_foreign` (`categorie_id`),
  ADD KEY `affectations_poste_id_foreign` (`poste_id`),
  ADD KEY `affectations_annee_id_foreign` (`annee_id`);

--
-- Index pour la table `annees`
--
ALTER TABLE `annees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `annees_annee_unique` (`annee`);

--
-- Index pour la table `archives`
--
ALTER TABLE `archives`
  ADD PRIMARY KEY (`id`),
  ADD KEY `archives_employe_id_foreign` (`employe_id`),
  ADD KEY `archives_archive_par_foreign` (`archive_par`),
  ADD KEY `archives_annee_id_foreign` (`annee_id`);

--
-- Index pour la table `audits`
--
ALTER TABLE `audits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audits_employe_id_foreign` (`employe_id`),
  ADD KEY `audits_annee_id_foreign` (`annee_id`);

--
-- Index pour la table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Index pour la table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_annee_id_foreign` (`annee_id`);

--
-- Index pour la table `communiques`
--
ALTER TABLE `communiques`
  ADD PRIMARY KEY (`id`),
  ADD KEY `communiques_user_id_foreign` (`user_id`),
  ADD KEY `communiques_annee_id_foreign` (`annee_id`);

--
-- Index pour la table `conges`
--
ALTER TABLE `conges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conges_annee_id_foreign` (`annee_id`);

--
-- Index pour la table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contacts_annee_id_foreign` (`annee_id`);

--
-- Index pour la table `demandes_conges`
--
ALTER TABLE `demandes_conges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `demandes_conges_employe_id_foreign` (`employe_id`),
  ADD KEY `demandes_conges_conge_id_foreign` (`conge_id`),
  ADD KEY `demandes_conges_valide_par_foreign` (`valide_par`),
  ADD KEY `demandes_conges_annee_id_foreign` (`annee_id`);

--
-- Index pour la table `disciplines`
--
ALTER TABLE `disciplines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `disciplines_employe_id_foreign` (`employe_id`),
  ADD KEY `disciplines_sanction_id_foreign` (`sanction_id`),
  ADD KEY `disciplines_annee_id_foreign` (`annee_id`);

--
-- Index pour la table `dossiers_etude`
--
ALTER TABLE `dossiers_etude`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dossiers_etude_annee_id_foreign` (`annee_id`),
  ADD KEY `dossiers_etude_employe_id_foreign` (`employe_id`);

--
-- Index pour la table `employes`
--
ALTER TABLE `employes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employes_matricule_unique` (`matricule`),
  ADD KEY `employes_user_id_foreign` (`user_id`),
  ADD KEY `employes_annee_id_foreign` (`annee_id`);

--
-- Index pour la table `face_templates`
--
ALTER TABLE `face_templates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `face_templates_employe_id_foreign` (`employe_id`),
  ADD KEY `face_templates_annee_id_foreign` (`annee_id`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `formations`
--
ALTER TABLE `formations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `formations_annee_id_foreign` (`annee_id`);

--
-- Index pour la table `formation_employes`
--
ALTER TABLE `formation_employes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `formation_employes_formation_id_foreign` (`formation_id`),
  ADD KEY `formation_employes_employe_id_foreign` (`employe_id`),
  ADD KEY `formation_employes_annee_id_foreign` (`annee_id`);

--
-- Index pour la table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `historiques`
--
ALTER TABLE `historiques`
  ADD PRIMARY KEY (`id`),
  ADD KEY `historiques_user_id_foreign` (`user_id`),
  ADD KEY `historiques_annee_id_foreign` (`annee_id`);

--
-- Index pour la table `interimes`
--
ALTER TABLE `interimes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `interimes_employe_id_foreign` (`employe_id`),
  ADD KEY `interimes_interimaire_id_foreign` (`interimaire_id`),
  ADD KEY `interimes_annee_id_foreign` (`annee_id`);

--
-- Index pour la table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Index pour la table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `lectures`
--
ALTER TABLE `lectures`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `mouvements`
--
ALTER TABLE `mouvements`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Index pour la table `performances`
--
ALTER TABLE `performances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `performances_employe_id_foreign` (`employe_id`),
  ADD KEY `performances_evaluateur_id_foreign` (`evaluateur_id`),
  ADD KEY `performances_annee_id_foreign` (`annee_id`);

--
-- Index pour la table `postes`
--
ALTER TABLE `postes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `postes_annee_id_foreign` (`annee_id`);

--
-- Index pour la table `presences`
--
ALTER TABLE `presences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `presences_employe_id_foreign` (`employe_id`),
  ADD KEY `presences_annee_id_foreign` (`annee_id`);

--
-- Index pour la table `proprietes`
--
ALTER TABLE `proprietes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proprietes_annee_id_foreign` (`annee_id`);

--
-- Index pour la table `reglements`
--
ALTER TABLE `reglements`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `retours`
--
ALTER TABLE `retours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `retours_user_id_foreign` (`user_id`),
  ADD KEY `retours_annee_id_foreign` (`annee_id`);

--
-- Index pour la table `sanctions`
--
ALTER TABLE `sanctions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sanctions_annee_id_foreign` (`annee_id`);

--
-- Index pour la table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `services_annee_id_foreign` (`annee_id`);

--
-- Index pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `affectations`
--
ALTER TABLE `affectations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `annees`
--
ALTER TABLE `annees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `archives`
--
ALTER TABLE `archives`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `audits`
--
ALTER TABLE `audits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `communiques`
--
ALTER TABLE `communiques`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `conges`
--
ALTER TABLE `conges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `demandes_conges`
--
ALTER TABLE `demandes_conges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `disciplines`
--
ALTER TABLE `disciplines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `dossiers_etude`
--
ALTER TABLE `dossiers_etude`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `employes`
--
ALTER TABLE `employes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `face_templates`
--
ALTER TABLE `face_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `formations`
--
ALTER TABLE `formations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `formation_employes`
--
ALTER TABLE `formation_employes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `historiques`
--
ALTER TABLE `historiques`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;

--
-- AUTO_INCREMENT pour la table `interimes`
--
ALTER TABLE `interimes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `lectures`
--
ALTER TABLE `lectures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT pour la table `mouvements`
--
ALTER TABLE `mouvements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `performances`
--
ALTER TABLE `performances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `postes`
--
ALTER TABLE `postes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `presences`
--
ALTER TABLE `presences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `proprietes`
--
ALTER TABLE `proprietes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `reglements`
--
ALTER TABLE `reglements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `retours`
--
ALTER TABLE `retours`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `sanctions`
--
ALTER TABLE `sanctions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `affectations`
--
ALTER TABLE `affectations`
  ADD CONSTRAINT `affectations_annee_id_foreign` FOREIGN KEY (`annee_id`) REFERENCES `annees` (`id`),
  ADD CONSTRAINT `affectations_categorie_id_foreign` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `affectations_employe_id_foreign` FOREIGN KEY (`employe_id`) REFERENCES `employes` (`id`),
  ADD CONSTRAINT `affectations_poste_id_foreign` FOREIGN KEY (`poste_id`) REFERENCES `postes` (`id`),
  ADD CONSTRAINT `affectations_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`);

--
-- Contraintes pour la table `archives`
--
ALTER TABLE `archives`
  ADD CONSTRAINT `archives_annee_id_foreign` FOREIGN KEY (`annee_id`) REFERENCES `annees` (`id`),
  ADD CONSTRAINT `archives_archive_par_foreign` FOREIGN KEY (`archive_par`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `archives_employe_id_foreign` FOREIGN KEY (`employe_id`) REFERENCES `employes` (`id`);

--
-- Contraintes pour la table `audits`
--
ALTER TABLE `audits`
  ADD CONSTRAINT `audits_annee_id_foreign` FOREIGN KEY (`annee_id`) REFERENCES `annees` (`id`),
  ADD CONSTRAINT `audits_employe_id_foreign` FOREIGN KEY (`employe_id`) REFERENCES `employes` (`id`);

--
-- Contraintes pour la table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_annee_id_foreign` FOREIGN KEY (`annee_id`) REFERENCES `annees` (`id`);

--
-- Contraintes pour la table `communiques`
--
ALTER TABLE `communiques`
  ADD CONSTRAINT `communiques_annee_id_foreign` FOREIGN KEY (`annee_id`) REFERENCES `annees` (`id`),
  ADD CONSTRAINT `communiques_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `conges`
--
ALTER TABLE `conges`
  ADD CONSTRAINT `conges_annee_id_foreign` FOREIGN KEY (`annee_id`) REFERENCES `annees` (`id`);

--
-- Contraintes pour la table `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `contacts_annee_id_foreign` FOREIGN KEY (`annee_id`) REFERENCES `annees` (`id`);

--
-- Contraintes pour la table `demandes_conges`
--
ALTER TABLE `demandes_conges`
  ADD CONSTRAINT `demandes_conges_annee_id_foreign` FOREIGN KEY (`annee_id`) REFERENCES `annees` (`id`),
  ADD CONSTRAINT `demandes_conges_conge_id_foreign` FOREIGN KEY (`conge_id`) REFERENCES `conges` (`id`),
  ADD CONSTRAINT `demandes_conges_employe_id_foreign` FOREIGN KEY (`employe_id`) REFERENCES `employes` (`id`),
  ADD CONSTRAINT `demandes_conges_valide_par_foreign` FOREIGN KEY (`valide_par`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `disciplines`
--
ALTER TABLE `disciplines`
  ADD CONSTRAINT `disciplines_annee_id_foreign` FOREIGN KEY (`annee_id`) REFERENCES `annees` (`id`),
  ADD CONSTRAINT `disciplines_employe_id_foreign` FOREIGN KEY (`employe_id`) REFERENCES `employes` (`id`),
  ADD CONSTRAINT `disciplines_sanction_id_foreign` FOREIGN KEY (`sanction_id`) REFERENCES `sanctions` (`id`);

--
-- Contraintes pour la table `dossiers_etude`
--
ALTER TABLE `dossiers_etude`
  ADD CONSTRAINT `dossiers_etude_annee_id_foreign` FOREIGN KEY (`annee_id`) REFERENCES `annees` (`id`),
  ADD CONSTRAINT `dossiers_etude_employe_id_foreign` FOREIGN KEY (`employe_id`) REFERENCES `employes` (`id`);

--
-- Contraintes pour la table `employes`
--
ALTER TABLE `employes`
  ADD CONSTRAINT `employes_annee_id_foreign` FOREIGN KEY (`annee_id`) REFERENCES `annees` (`id`),
  ADD CONSTRAINT `employes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `face_templates`
--
ALTER TABLE `face_templates`
  ADD CONSTRAINT `face_templates_annee_id_foreign` FOREIGN KEY (`annee_id`) REFERENCES `annees` (`id`),
  ADD CONSTRAINT `face_templates_employe_id_foreign` FOREIGN KEY (`employe_id`) REFERENCES `employes` (`id`);

--
-- Contraintes pour la table `formations`
--
ALTER TABLE `formations`
  ADD CONSTRAINT `formations_annee_id_foreign` FOREIGN KEY (`annee_id`) REFERENCES `annees` (`id`);

--
-- Contraintes pour la table `formation_employes`
--
ALTER TABLE `formation_employes`
  ADD CONSTRAINT `formation_employes_annee_id_foreign` FOREIGN KEY (`annee_id`) REFERENCES `annees` (`id`),
  ADD CONSTRAINT `formation_employes_employe_id_foreign` FOREIGN KEY (`employe_id`) REFERENCES `employes` (`id`),
  ADD CONSTRAINT `formation_employes_formation_id_foreign` FOREIGN KEY (`formation_id`) REFERENCES `formations` (`id`);

--
-- Contraintes pour la table `historiques`
--
ALTER TABLE `historiques`
  ADD CONSTRAINT `historiques_annee_id_foreign` FOREIGN KEY (`annee_id`) REFERENCES `annees` (`id`),
  ADD CONSTRAINT `historiques_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `interimes`
--
ALTER TABLE `interimes`
  ADD CONSTRAINT `interimes_annee_id_foreign` FOREIGN KEY (`annee_id`) REFERENCES `annees` (`id`),
  ADD CONSTRAINT `interimes_employe_id_foreign` FOREIGN KEY (`employe_id`) REFERENCES `employes` (`id`),
  ADD CONSTRAINT `interimes_interimaire_id_foreign` FOREIGN KEY (`interimaire_id`) REFERENCES `employes` (`id`);

--
-- Contraintes pour la table `performances`
--
ALTER TABLE `performances`
  ADD CONSTRAINT `performances_annee_id_foreign` FOREIGN KEY (`annee_id`) REFERENCES `annees` (`id`),
  ADD CONSTRAINT `performances_employe_id_foreign` FOREIGN KEY (`employe_id`) REFERENCES `employes` (`id`),
  ADD CONSTRAINT `performances_evaluateur_id_foreign` FOREIGN KEY (`evaluateur_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `postes`
--
ALTER TABLE `postes`
  ADD CONSTRAINT `postes_annee_id_foreign` FOREIGN KEY (`annee_id`) REFERENCES `annees` (`id`);

--
-- Contraintes pour la table `presences`
--
ALTER TABLE `presences`
  ADD CONSTRAINT `presences_annee_id_foreign` FOREIGN KEY (`annee_id`) REFERENCES `annees` (`id`),
  ADD CONSTRAINT `presences_employe_id_foreign` FOREIGN KEY (`employe_id`) REFERENCES `employes` (`id`);

--
-- Contraintes pour la table `proprietes`
--
ALTER TABLE `proprietes`
  ADD CONSTRAINT `proprietes_annee_id_foreign` FOREIGN KEY (`annee_id`) REFERENCES `annees` (`id`);

--
-- Contraintes pour la table `retours`
--
ALTER TABLE `retours`
  ADD CONSTRAINT `retours_annee_id_foreign` FOREIGN KEY (`annee_id`) REFERENCES `annees` (`id`),
  ADD CONSTRAINT `retours_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `sanctions`
--
ALTER TABLE `sanctions`
  ADD CONSTRAINT `sanctions_annee_id_foreign` FOREIGN KEY (`annee_id`) REFERENCES `annees` (`id`);

--
-- Contraintes pour la table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_annee_id_foreign` FOREIGN KEY (`annee_id`) REFERENCES `annees` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
