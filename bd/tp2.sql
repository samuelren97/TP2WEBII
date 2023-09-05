-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 07 avr. 2022 à 13:32
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `baie_ourson`
--
DROP DATABASE IF EXISTS tp2_samuel_alexandre;
CREATE DATABASE TP2_Samuel_Alexandre;
USE TP2_Samuel_Alexandre;
-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE IF NOT EXISTS `products` (
  `sku` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `description` text CHARACTER SET latin1 NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `stock` int(11) NOT NULL,
  PRIMARY KEY (`sku`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET latin1 NOT NULL,
  `password` text CHARACTER SET latin1 NOT NULL,
  `first_name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `last_name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `shipping_address` text CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `order`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY `user_id` (`user_id`) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `order_item`
--

CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_sku` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contraintes pour la table `order_item`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_item_ibfk_1` FOREIGN KEY (`product_sku`) REFERENCES `products` (`sku`),
  ADD CONSTRAINT `order_item_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);
COMMIT;


--
-- Déchargement des données de la table `product`
--

INSERT INTO `products` (`sku`, `name`, `description`, `price`, `stock`) VALUES
(154789, 'Schecter Evil Twin SLS-Elite', 'Noir et blanche avec des têtes de mort!', '1799.95', 2),
(612458, 'Jackson King-V', 'Manche en érable et ganirtures chromées', '1999.99', 4),
(887414, 'Solar V1.6 Vinter', 'Logo gravé sur la 12eme touche', '1495.99', 5),
(634920, 'Solar AB1.4JN FLAME BLACK','Basse plus noire que la nuit', '1355.95', 2),
(936421, 'Fender American Ultra Jazz Bass V', 'Basse 5 cordes faite à la main','2455.95', 1),
(238954, 'BC Rich Ironbird MK1', "Basse aussi coupante qu'un rasoir", '1325.95', 5);

-- SELECT * FROM users WHERE email='sam@sam.com' AND password='$2y$10$MIUv1TU0SFMOsljt4RL54uZK9DTU/ASKh7JU9fJ0Pm7yybI9Dd55a';

--
-- Contraintes pour les tables déchargées
--



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
