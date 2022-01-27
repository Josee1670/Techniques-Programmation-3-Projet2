-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  sam. 22 jan. 2022 à 23:47
-- Version du serveur :  8.0.18
-- Version de PHP :  7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `forfaits-voyages`
--

-- --------------------------------------------------------

--
-- Structure de la table `forfaits`
--

CREATE TABLE `forfaits` (
  `id` int(11) NOT NULL,
  `destination` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `villeDepart` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `nom` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `nombreEtoiles` decimal(10,0) NOT NULL,
  `nombreChambres` decimal(10,0) NOT NULL,
  `caracteristiques` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `dateDepart` date NOT NULL,
  `duree` decimal(25,0) NOT NULL,
  `prix` decimal(25,0) NOT NULL,
  `rabais` decimal(25,0) NOT NULL,
  `forfaitVedette` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `forfaits`
--

INSERT INTO `forfaits` (`id`, `destination`, `villeDepart`, `nom`, `adresse`, `nombreEtoiles`, `nombreChambres`, `caracteristiques`, `dateDepart`, `duree`, `prix`, `rabais`, `forfaitVedette`) VALUES
(1, 'Guadeloupe, Guadeloupe', 'Montréal', 'Pierre et Vacances Village de Sainte-Anne', 'Seo La Pointe de Helleux Saint-Anne Guadeloupe, 97180', '3', '514', 'Face à la plage;3 piscines;2 Bar;4 restaurants;Wi-Fi : dans tout le complexe;Salle d\'exercice;Coffret de sûreté ($);Plage', '2021-12-29', '7', '2481', '422', 'false'),
(2, 'Holguin, Cuba', 'Québec', 'Paradisus Rio de Oro Resort & Spa', 'Playa Esmeralda, Carretera a Guardalavaca, Rafael Freyre, Holguin, Cuba, 80200', '5', '354', '3 piscines;8 restaurants;8 bars;Wi-Fi : hall, piscine • Spa ($);Boissons 24 h - collations 24 h;Coffret de sûreté;Mariages', '2021-12-29', '7', '3080', '1232', 'true'),
(3, 'Montego Bay, Jamaïque', 'Montréal', 'Holiday Inn Resort Montego Bay', 'P.O. Box 480 Rose Hall Montego Bay Jamaïque', '4', '520', '2 piscines;Wi-Fi : dans tout le complexe;Air climatiser;Animaux acceptés;Navette aéroport;5 restaurants;Salle d\'exercice;Spa ($)', '2022-01-07', '7', '2534', '1295', 'true'),
(4, 'Porto, Portugal', 'Montréal', 'Hotel Dom Henrique', 'Rua do Bolhão 223, Porto, Portugal, 400-112', '4', '112', 'Petit-déjeuner;2 piscines;Wi-Fi : dans tout le complexe;Air climatiser;1 Bar;2 restaurants;Coffret de sûreté ($)', '2022-03-13', '7', '2204', '705', 'true'),
(5, 'Paris, France', 'Vancouver', 'Citadines Maine Montparnasse Paris', '67, avenue du Maine 75014 Paris, France', '3', '98', 'Wi-Fi : hall, chambre;Stationnement ($);1 restaurant;Coffret de sûreté;Accessible;Séchoir à cheveux;Resto-bar', '2022-05-02', '7', '2169', '400', 'false'),
(6, 'Riviera Maya, Mexique', 'Toronto', 'The Fives Beach Hotel & Residences Playa Del Carmen', 'El Limonar 1, Xcalacoco, 77710 Playa del Carmen, Q.R., Mexique', '5', '577', 'Miniclub;6 piscines;9 restaurants;9 bars;Wi-Fi : dans tout le complexe;Spa ($);Salle d\'exercice;Boissons 24 h - collations 24 h;Coffret de sûreté;Mariages', '2022-04-29', '14', '4438', '2219', 'true'),
(7, 'La Romana, République dominicaine', 'Québec', 'Bahia Principe Grand La Romana', 'La Caña 21000, République dominicaine', '4', '400', 'Miniclub;1 piscine;6 restaurants;6 bars;Wi-Fi : dans tout le complexe;Salle d\'exercice;Boissons 24 h - collations 24 h;Coffret de sûreté;Mariages', '2022-05-16', '15', '3278', '695', 'true'),
(8, 'Cancun, Mexique', 'Québec', 'Now Emerald Cancun', 'Blvd. Kukulcan, Zona Hotelera, 77500 Cancún, Q.R., Mexique', '4', '427', 'Tout inclus;Miniclub;3 piscines;8 restaurants;7 bars;Wi-Fi : dans tout le complexe;Spa ($);Salle d\'exercice;Boissons 24 h - collations 24 h;Plage', '2022-04-24', '21', '6118', '807', 'true');

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `de` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `vers` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `date` date NOT NULL,
  `duree` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nombreDePassagersAdultes` int(50) NOT NULL,
  `nombreDePassagersEnfants` int(50) NOT NULL,
  `nombreDeChambres` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id`, `de`, `vers`, `date`, `duree`, `nombreDePassagersAdultes`, `nombreDePassagersEnfants`, `nombreDeChambres`) VALUES
(11, 'Calgary: Canada YYC Aéroport international de Calgary', 'Espagne', '2022-05-16', '3 à 5 jours;6 à 8 jours;9 à 12 jours;13 à 15 jours;16 à 21 jours;22 à 28 jours;14 jours seulement;15 jours seulement;21 jours seulement;28 jours seulement', 1, 2, 2),
(12, 'Halifax: Canada YHZ Aéroport international Stanfield', 'Cuba', '2022-01-21', '3 à 5 jours;6 à 8 jours;9 à 12 jours;13 à 15 jours;16 à 21 jours;22 à 28 jours;14 jours seulement;15 jours seulement;21 jours seulement;28 jours seulement', 2, 4, 2),
(13, 'Hamilton: Canada YHM Aéroport international d\'Hamilton', 'Riviera Maya', '2022-02-09', '3 à 5 jours;6 à 8 jours;9 à 12 jours;13 à 15 jours;16 à 21 jours;22 à 28 jours;14 jours seulement;15 jours seulement;21 jours seulement;28 jours seulement', 4, 2, 3),
(14, 'London: Canada YXU Aéroport international de London', 'République dominicaine', '2022-03-31', '3 à 5 jours;6 à 8 jours;9 à 12 jours;13 à 15 jours;16 à 21 jours;22 à 28 jours;14 jours seulement;15 jours seulement;21 jours seulement;28 jours seulement', 2, 1, 1),
(15, 'Moncton: Canada YQM Aéroport international du Grand', 'Orlando', '2022-01-27', '3 à 5 jours;6 à 8 jours;9 à 12 jours;13 à 15 jours;16 à 21 jours;22 à 28 jours;14 jours seulement;15 jours seulement;21 jours seulement;28 jours seulement', 2, 0, 1),
(16, 'Montréal: Canada YUL Aéroport international Pierre-Elliott-Trudeau de Montréal', 'Portugal', '2022-03-09', '3 à 5 jours;6 à 8 jours;9 à 12 jours;13 à 15 jours;16 à 21 jours;22 à 28 jours;14 jours seulement;15 jours seulement;21 jours seulement;28 jours seulement', 2, 6, 3),
(17, 'Ottawa: Canada YOW Aéroport international Macdonald-Cartier d\'Ottawa', 'Puerto Plata', '2022-02-28', '3 à 5 jours;6 à 8 jours;9 à 12 jours;13 à 15 jours;16 à 21 jours;22 à 28 jours;14 jours seulement;15 jours seulement;21 jours seulement;28 jours seulement', 1, 3, 1),
(18, 'Québec: Canada YQB Aéroport international Jean-Lesage de Québec', 'Rome', '2022-03-04', '3 à 5 jours;6 à 8 jours;9 à 12 jours;13 à 15 jours;16 à 21 jours;22 à 28 jours;14 jours seulement;15 jours seulement;21 jours seulement;28 jours seulement', 1, 0, 1),
(19, 'Toronto: Canada YYZ Aéroport international Pearson de Toronto', 'Barcelone', '2022-04-28', '3 à 5 jours;6 à 8 jours;9 à 12 jours;13 à 15 jours;16 à 21 jours;22 à 28 jours;14 jours seulement;15 jours seulement;21 jours seulement;28 jours seulement', 3, 5, 4),
(20, 'Vancouver: Canada YVR Aéroport international de Vancouver', 'France', '2022-08-11', '3 à 5 jours;6 à 8 jours;9 à 12 jours;13 à 15 jours;16 à 21 jours;22 à 28 jours;14 jours seulement;15 jours seulement;21 jours seulement;28 jours seulement', 2, 0, 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `forfaits`
--
ALTER TABLE `forfaits`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `forfaits`
--
ALTER TABLE `forfaits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
