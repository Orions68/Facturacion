-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-11-2022 a las 21:50:56
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `nutraproject`
--
CREATE DATABASE IF NOT EXISTS `nutraproject` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `nutraproject`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pass` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bday` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `clients`
--

INSERT INTO `clients` (`id`, `name`, `address`, `phone`, `email`, `pass`, `bday`) VALUES
(1, 'César Matelat', 'Calle Fermín Morín Nº 2, portal 4, 7º B.', '664774821', 'cesarmatelat@gmail.com', '$2y$10$tlfz5sYugFivUZgLwrAdxujmZEY.OLxj7VyRWb3U7pvmgfzpvxAO.', '1968-04-05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invoice`
--

CREATE TABLE `invoice` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `product_id` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qtty` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` decimal(11,2) NOT NULL,
  `iva` decimal(11,2) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `invoice`
--

INSERT INTO `invoice` (`id`, `client_id`, `product_id`, `qtty`, `total`, `iva`, `date`, `time`) VALUES
(1, 1, '1,2,', '1,2,', '193.66', '33.61', '2022-11-17', '15:47:31'),
(2, 1, '1,2,', '2,2,', '233.89', '40.59', '2022-11-17', '19:26:18'),
(3, 1, '2,', '2,', '153.43', '26.63', '2022-11-17', '19:27:10'),
(4, 1, '2,1,', '3,2,', '310.61', '53.91', '2022-11-17', '19:27:45'),
(5, 1, '1,2,', '2,1,', '157.18', '27.28', '2022-11-18', '18:37:51'),
(6, 1, '1,2,', '2,2,', '233.89', '40.59', '2022-11-20', '13:38:29'),
(7, 1, '1,2,', '3,2,', '274.13', '47.58', '2022-11-20', '13:40:36'),
(8, 1, '1,2,', '9,10,', '1129.23', '195.98', '2022-11-20', '13:57:34'),
(9, 1, '1,2,', '2,2,', '233.89', '40.59', '2022-11-20', '13:58:03'),
(10, 1, '1,', '2,', '80.47', '13.97', '2022-11-20', '18:07:53'),
(11, 1, '2,1,', '2,3,', '274.13', '47.58', '2022-11-21', '02:58:02'),
(12, 1, '1,', '1,', '40.23', '6.98', '2022-11-21', '02:59:11'),
(13, 1, '2,1,', '3,2,', '310.61', '53.91', '2022-11-21', '02:59:51'),
(14, 1, '2,', '1,', '76.71', '13.31', '2022-11-21', '03:00:06'),
(15, 1, '2,', '6,', '460.28', '79.88', '2022-11-21', '03:19:39'),
(16, 1, '1,', '2,', '80.47', '13.97', '2022-11-21', '03:27:03'),
(17, 1, '1,', '1,', '40.23', '6.98', '2022-11-21', '03:27:37'),
(18, 1, '3,1,2,', '1,2,1,', '241.88', '41.98', '2022-11-21', '03:42:12'),
(19, 1, '3,', '1,', '84.70', '14.70', '2022-11-24', '12:00:00'),
(20, 1, '4,', '1,', '30.25', '5.25', '2022-11-24', '12:00:18'),
(21, 1, '3,', '1,', '84.70', '14.70', '2022-11-24', '21:20:31'),
(22, 1, '5,', '1,', '48.40', '8.40', '2022-11-24', '21:20:44'),
(23, 1, '3,4,7,', '2,2,5,', '234.14', '40.64', '2022-11-25', '14:44:22'),
(24, 1, '5,7,', '2,5,', '105.88', '18.38', '2022-11-25', '17:07:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(11,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `img` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kind` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `product`, `price`, `stock`, `img`, `kind`, `brand`) VALUES
(1, 'PSYCHO MODE 480G', '33.25', 11, 'img/PSYCHO-480G.jpg', 'Proteínas', 'SKULL TRAIN'),
(2, 'SUPER 100% WHEY TIRAMISU - 2KG', '63.40', 4, 'img/WHEY-TIRAMISU-2KG.jpg', 'Proteínas', 'NAMEDSPORT'),
(3, 'Carnitina Slim Diet 1Kg.', '70.00', 15, 'img/Carnitina.jpg', 'Aminoácidos', ''),
(4, 'Carbohidratos sin Sabor 1 Kg.', '25.00', 17, 'img/carbo.jpg', 'Carbohidratos', ''),
(5, 'Aceite Omega 3 120 Ml.', '40.00', 17, 'img/Omega.avif', 'Aceites Insaturados', ''),
(6, 'Vitaminas 120 Capsulas', '20.00', 8, 'img/Vitaminas.avif', 'Vitaminas', ''),
(7, 'Barra Energética Vainilla y Miel con Chocolte', '2.50', 10, 'img/Barras.webp', 'Barras de cereales y Proteínas', ''),
(8, 'Pastillas de menta', '5.00', 40, 'img/mentos.png', '3', 'Muscletech'),
(9, 'Chicles de Chocolate', '8.00', 40, 'img/choco.jpg', 'Proteínas', 'My Protein'),
(10, 'Chuletón de Buey', '15.00', 50, 'img/chuleton.png', 'Proteínas', 'Life Pro'),
(11, 'Otra Proteína', '20.00', 20, 'img/carbo.jpg', 'Proteínas', 'My Protein'),
(12, 'Otra Más', '20.00', 20, 'img/carbo.jpg', 'Proteínas', 'My Protein'),
(13, 'Esta está en la otra página.', '20.00', 20, 'img/carbo.jpg', 'Proteínas', 'My Protein');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
