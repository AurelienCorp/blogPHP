-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 04 juin 2024 à 15:06
-- Version du serveur : 8.2.0
-- Version de PHP : 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `blogphp`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Art'),
(2, 'Politique'),
(3, 'Faits divers'),
(4, 'Informatique'),
(5, 'Sciences'),
(6, 'Nature'),
(7, 'Littérature'),
(8, 'Cinéma');

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  `content` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `state` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pending',
  `user_id` int NOT NULL,
  `post_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `comment_User_FK` (`user_id`),
  KEY `comment_Post0_FK` (`post_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `created_at`, `updated_at`, `content`, `state`, `user_id`, `post_id`) VALUES
(37, '2024-06-04', '2024-06-04', 'mon test de commentaire', 'validated', 170, 1),
(39, '2024-06-04', '2024-06-04', 'J\'aime beaucoup cette article', 'validated', 170, 28),
(40, '2024-06-04', '2024-06-04', 'cet article est génial', 'validated', 170, 1);

-- --------------------------------------------------------

--
-- Structure de la table `contactform`
--

DROP TABLE IF EXISTS `contactform`;
CREATE TABLE IF NOT EXISTS `contactform` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `firstname` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `lastname` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `message` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `send_at` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `contactform`
--

INSERT INTO `contactform` (`id`, `email`, `firstname`, `lastname`, `message`, `send_at`) VALUES
(1, 'testContact@testcontact.fr', 'aurelien', 'demblans', 'bonjour je voudrais vous contacter', '2024-02-01');

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `chapo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date DEFAULT NULL,
  `category_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Post_Category_FK` (`category_id`),
  KEY `Post_User0_FK` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id`, `title`, `chapo`, `content`, `created_at`, `updated_at`, `category_id`, `user_id`) VALUES
(1, 'L\'art dans la civilisation Maya', 'une histoire mouvementée', '<p>L\'<strong>art maya</strong> est considéré par certains comme étant le plus sophistiqué et le plus beau de toute l\'Amérique précolombienne. Le style distinct de l\'art maya qui se développe durant la période préclassique (1500 av. J.-C. à 250 apr. J.-C.), lors de l\'Époque I et II, reçut les influences de la civilisation olmèque. D\'autres civilisations mésoaméricaines, incluant Teotihuacan et les Toltèques, affectèrent l\'art maya, qui atteignit son apogée durant la période de la civilisation classique ou Époque III (environ 200 à 900 apr. J.-C.). Les Mayas sont célèbres pour leur utilisation du jade, de l\'obsidienne et du stuc.</p><h2>Style et caractère</h2><p>Quelques pièces de l\'art maya sont de nature spirituelle, destinés à apaiser ou à s\'attirer la faveur divine. La plupart des objets mayas qui sont parvenus jusqu\'à nous sont d\'origine funéraire ou rituelle. Les Mayas n\'utilisaient pas d\'outils métalliques ni de tour de potier&nbsp;; cependant ils réussirent à créer des</p><figure class=\"image\"><img style=\"aspect-ratio:150/225;\" src=\"https://upload.wikimedia.org/wikipedia/commons/thumb/a/a4/Lombards_Museum_043.JPG/150px-Lombards_Museum_043.JPG\" srcset=\"//upload.wikimedia.org/wikipedia/commons/thumb/a/a4/Lombards_Museum_043.JPG/225px-Lombards_Museum_043.JPG 1.5x, //upload.wikimedia.org/wikipedia/commons/thumb/a/a4/Lombards_Museum_043.JPG/300px-Lombards_Museum_043.JPG 2x\" sizes=\"100vw\" width=\"150\" height=\"225\"></figure><p>Vase peint, style Chama<br>700-850 apr. J.-C.<br><i>Lombards Museum</i></p><p>œuvres d\'art hautement belles et détaillées. Souvent, l\'art maya dépeint les divinités, les grands dirigeants, les héros légendaires, les scènes religieuses et la vie quotidienne occasionnellement. Le centre d\'intérêt des œuvres d\'art mayas se situe dans les figures humaines (que ce soit les divinités ou les mortels). Les animaux et les motifs stylisés sont destinés habituellement à décorer la poterie et d\'autres objets. L\'écriture maya, qui peut être considérée comme une forme d\'art elle-même, apparaît sur la plupart des statues et des sculptures.</p>', '2024-06-04', '2024-06-04', 1, 2),
(2, 'L\'art Etrusque', 'aux origine de l\'art romain', '<p><strong>L\'art étrusque</strong> est l\'art produit par la civilisation étrusque du ixe au ier&nbsp;siècle av. J.-C..</p><p>L\'art produit par cette civilisation est d\'une grande richesse. Les Étrusques furent d\'habiles artisans et eurent de grands artistes, peintres de fresques dans les tombes - comme celles de Tarquinia par exemple - peintres sur vases ou sculpteurs qui réalisèrent des chefs-d\'œuvre tant en bronze qu\'en terre cuite. Ils furent également d\'excellents joailliers et de bons métallurgistes. On peut voir leurs œuvres dans les grands musées italiens, par exemple ceux de Florence, du Vatican ou de Volterra.</p><h2>Périodes historiques</h2><p>On peut distinguer différentes périodes&nbsp;:</p><ul><li><i>Époque villanovienne</i> (xe au viiie&nbsp;siècle av. J.-C.). Prémices de la civilisation étrusque, notamment via la pratique de l\'incinération et non de l\'inhumation&nbsp;;</li><li><i>Période orientalisante</i> (au viie&nbsp;siècle&nbsp;av. J.-C.). Du fait d\'échanges avec les civilisations méditerranéennes, dont la Grèce, l\'art étrusque voit apparaître une culture figurative, influencée par les modèles grecs;</li><li><i>Période archaïque</i> (entre -600 et -480 environ). La structuration de la société étrusque et la multiplication des échanges font émerger de nouvelles techniques artistiques. En particulier la peinture connaît un développement spectaculaire&nbsp;: de la décoration des tuiles et la coroplathie, elle obtient un statut décoratif et s\'applique sur les vases et les fresques&nbsp;;</li><li><i>Époque classique</i> (entre -470 et -350 environ). Au ve&nbsp;siècle&nbsp;av. J.-C. les Étrusques connaissent de graves crises politiques et militaires, et leur art en subit les conséquences. La production artistique diminue, à l\'exception des bronzes de Vulci&nbsp;;</li><li><i>L’hellénisme et la romanisation</i> (de -340 environ jusqu’à Auguste).</li></ul><h3><strong>viiie au viie&nbsp;siècle&nbsp;av. J.-C.</strong></h3><ul><li><figure class=\"image\"><img style=\"aspect-ratio:150/200;\" src=\"https://upload.wikimedia.org/wikipedia/commons/thumb/2/2e/Ny_Carlsberg_Glyptothek_-_Etrusker_Kopfurne.jpg/225px-Ny_Carlsberg_Glyptothek_-_Etrusker_Kopfurne.jpg\" alt=\"Canope de Chiusi, VIIe&nbsp;– VIe&nbsp;siècle&nbsp;av. J.-C.\" srcset=\"//upload.wikimedia.org/wikipedia/commons/thumb/2/2e/Ny_Carlsberg_Glyptothek_-_Etrusker_Kopfurne.jpg/337px-Ny_Carlsberg_Glyptothek_-_Etrusker_Kopfurne.jpg 1.5x, //upload.wikimedia.org/wikipedia/commons/thumb/2/2e/Ny_Carlsberg_Glyptothek_-_Etrusker_Kopfurne.jpg/450px-Ny_Carlsberg_Glyptothek_-_Etrusker_Kopfurne.jpg 2x\" sizes=\"100vw\" width=\"150\" height=\"200\"></figure><p>Canope de Chiusi,viie&nbsp;– vie&nbsp;siècle&nbsp;av. J.-C.</p></li><li><figure class=\"image\"><img style=\"aspect-ratio:150/200;\" src=\"https://upload.wikimedia.org/wikipedia/commons/thumb/c/ca/Ny_Carlsberg_Glyptothek_-_Etrusker_Bronzekopf.jpg/225px-Ny_Carlsberg_Glyptothek_-_Etrusker_Bronzekopf.jpg\" alt=\"Tête d\'homme en bronze, époque incertaine.\" srcset=\"//upload.wikimedia.org/wikipedia/commons/thumb/c/ca/Ny_Carlsberg_Glyptothek_-_Etrusker_Bronzekopf.jpg/337px-Ny_Carlsberg_Glyptothek_-_Etrusker_Bronzekopf.jpg 1.5x, //upload.wikimedia.org/wikipedia/commons/thumb/c/ca/Ny_Carlsberg_Glyptothek_-_Etrusker_Bronzekopf.jpg/450px-Ny_Carlsberg_Glyptothek_-_Etrusker_Bronzekopf.jpg 2x\" sizes=\"100vw\" width=\"150\" height=\"200\"></figure><p>Tête d\'homme en bronze, époque incertaine.</p></li><li><figure class=\"image\"><img style=\"aspect-ratio:134/200;\" src=\"https://upload.wikimedia.org/wikipedia/commons/thumb/e/ed/Lion_ail%C3%A9_Vulci_Louvre.JPG/200px-Lion_ail%C3%A9_Vulci_Louvre.JPG\" alt=\"Lion ailé de Vulci, VIe&nbsp;siècle&nbsp;av. J.-C.\" srcset=\"//upload.wikimedia.org/wikipedia/commons/thumb/e/ed/Lion_ail%C3%A9_Vulci_Louvre.JPG/300px-Lion_ail%C3%A9_Vulci_Louvre.JPG 1.5x, //upload.wikimedia.org/wikipedia/commons/thumb/e/ed/Lion_ail%C3%A9_Vulci_Louvre.JPG/400px-Lion_ail%C3%A9_Vulci_Louvre.JPG 2x\" sizes=\"100vw\" width=\"134\" height=\"200\"></figure><p>Lion ailé de Vulci, vie&nbsp;siècle&nbsp;av. J.-C.</p></li></ul><p>Pendant une première phase allant du viiie au viie&nbsp;siècle&nbsp;av. J.-C., l\'art étrusque s’inspire d\'expressions orientalisantes avec l\'importation d\'objets en provenance d\'Égypte et de Phénicie. Les pièces d\'orfèvrerie à filigrane, poussière et granulation de fabrication locale sont inspirées de modèles étrangers. La technique du bronze se développe avec la production de trônes, sièges, boucliers, miroirs et laminé bosselée pour décoration de chars. En céramique, à côté des imitations grecques, prend corps une production originale locale&nbsp;: vases en bucchero, en style italico-géometrique, grands vases avec support, ornés de figures de monstres et animaux.</p>', '2024-06-04', '2024-06-04', 1, 2),
(28, 'Alan Turing', 'génie méconnu', '<p><strong>Alan Mathison Turing</strong>, né le 23 juin 1912 à Londres et mort le 7 juin 1954 à Wilmslow, est un mathématicien et cryptologue britannique, auteur de travaux qui fondent scientifiquement l\'informatique. Il est aussi un des pionniers de l\'Intelligence artificielle.</p><p>Pour résoudre le problème fondamental de la décidabilité en arithmétique, il présente en 1936 une expérience de pensée que l\'on nommera ensuite machine de Turing et des concepts de programme et de programmation, qui prendront tout leur sens avec la diffusion des ordinateurs, dans la seconde moitié du xxe&nbsp;siècle. Son modèle a contribué à établir la thèse de Church, qui définit le concept mathématique intuitif de fonction calculable.</p><p>Durant la Seconde Guerre mondiale, il joue un rôle majeur dans la cryptanalyse de la machine Enigma utilisée par les armées allemandes&nbsp;: l\'invention de machines usant de procédés électroniques, les bombes, fera passer le décryptage à plusieurs milliers de messages par jour. Mais tout ce travail doit forcément rester secret, et ne sera connu du public que dans les années 1970. Après la guerre, il travaille sur un des tout premiers ordinateurs, puis contribue au débat sur la possibilité de l\'intelligence artificielle, en proposant le test de Turing. Vers la fin de sa vie, il s\'intéresse à des modèles de morphogenèse du vivant conduisant aux «&nbsp;structures de Turing&nbsp;».</p><p>Poursuivi en justice en 1952 pour homosexualité, il choisit, pour éviter la prison, la castration chimique par prise d\'œstrogènes. Il est retrouvé mort par empoisonnement au cyanure le 8 juin 1954 dans la chambre de sa maison à Wilmslow. La reine Élisabeth II le reconnaît comme héros de guerre et lui accorde une grâce royale à titre posthume en 2013.</p>', '2024-06-04', '2024-06-04', 4, 170);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pseudo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `logo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `firstname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `lastname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=177 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `pseudo`, `password`, `logo`, `firstname`, `lastname`, `role`) VALUES
(2, 'alice.smith@example.com', 'AliceSmith', 'mdp1234', '', 'Alice', 'Smith', 'subscriber'),
(3, 'john.doe@example.com', 'JohnDoe', 'mdp5678', '', 'John', 'Doe', 'subscriber'),
(4, 'emily.jones@example.com', 'EmilyJones', 'mdp9012', '', 'Emily', 'Jones', 'subscriber'),
(5, 'michael.brown@example.com', 'MichaelBrown', 'mdp3456', '', 'Alice', 'Brown', 'subscriber'),
(6, 'sarah.wilson@example.com', 'SarahWilson', 'mdp7890', '', 'Sarah', 'Wilson', 'subscriber'),
(7, 'david.johnson@example.com', 'DavidJohnson', 'mdp2345', '', 'David', 'Johnson', 'admin'),
(8, 'lisa.miller@example.com', 'LisaMiller', 'mdp6789', '', 'Lisa', 'Miller', 'admin'),
(170, 'a.demblans@hotmail.fr', 'Pempi', '$2y$10$QNC3n8C30xw6YljmD9Gc5.DGtA6I8T3oMLkSEYsaF6a4vO8ySXLJG', '', 'fdfdf', 'fdfdfdf', 'admin'),
(176, 'test@test.com', 'test', '$2y$10$upY585HcUK5tDDcpbgJugeidFZOAT9Hsop54lU3Fb.jcHWd3Il0i6', NULL, 'test', 'test', 'subscriber');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_Post0_FK` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comment_User_FK` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `Post_Category_FK` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Post_User0_FK` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
