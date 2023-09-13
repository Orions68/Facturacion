-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-07-2022 a las 09:26:23
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `barbery`
--

CREATE DATABASE IF NOT EXISTS `barbery2` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `barbery2`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(48) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pass` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bday` date NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `clients`
--

INSERT INTO `clients` (`id`, `name`, `address`, `phone`, `email`, `pass`, `bday`, `date`, `time`) VALUES
(1, 'César Matelat', 'Calle Fermín Morín Nº 2, Portal 4, 7º B', '664774821', 'matelat@gmail.com', '$2y$10$wE8iJkd0JOkVBKvDulTFkuig7GuC2RfgJYogQz.fL2eWkYaLmFxB6', '1968-04-05', '2022-07-10', '10:30:00'),
(2, 'Otro Cliente', 'On the street', '611111111', '1@1.com', '$2y$10$hkJA2caVxWaUDxX7GGgNz.ZGULh2klVxVQ9tfViGgJXWW4jVhvQmO', '1970-01-01', '2022-07-10', '09:30:00'),
(4, 'Yo mismo', 'Av. Reyes Católicos 29, 53', '633333333', '3@3.com', '$2y$10$cugCqF9ZXNWT4ttoji.BR.viHM6ZP8/CGdmIw9.rdUHQu/5twVXHq', '1970-01-01', '2022-07-10', '11:00:00'),
(5, 'Cuarto Fourth', 'Calle 1 Nº 1', '644444444', '4@4.com', '$2y$10$T1d/hYzTRZsuVgWxNsCLeOdjzgU5YxHz.He//uVJ.2.CWeY1mGAOm', '1968-04-05', '2022-07-10', '10:00:00'),
(6, 'Quinto Fifth', 'Calle 5, Nº 5, 55', '655555555', '5@5.com', '$2y$10$vMVDDTtZqiYvWrU8c9DDwusObK.jvm0NDidQZoBfDAv80T4I5stoe', '2005-05-05', '2022-07-10', '11:30:00'),
(7, 'Consumidor Final', '', '', '6@6.com', '$2y$10$t1.pfR.x5ZyrotJ3MLqjwurOla/EKfCGiZYsClz4CuUiQNdwQJKoW', '0000-00-00', '2022-07-10', '12:00:00'),
(8, 'Septimo Seventh', 'Calle 7 Nº 7, 7º 77', '677777777', '7@7.com', '$2y$10$Pubd4Zk445wFvb7nuyXNrOKGbqlwvAWC82XwiLrPuDOaXVufupZES', '1977-07-07', '2022-07-10', '12:30:00'),
(9, 'Consumidor Final', '', '', '9@9.com', '$2y$10$CRogUtLdpIB3UtEVbI9HQe.335MZnJf6xwMUdRXrgiyuex6B0kr5C', '0000-00-00', '2022-07-10', '09:00:00'),
(10, 'El Diego Diez', 'Calle 10 Nº 10, 10º 10', '610101010', '10@10.com', '$2y$10$ZMZUAq2Rhru.3f.u/jqrGeYkABKLBJ1CvWvDa8fm/YKH1THXu/fou', '2010-10-10', '2022-07-10', '17:00:00'),
(11, 'Once Eleventh', 'Calle 11 Nº 11, 11 11', '611111110', '11@11.com', '$2y$10$eC0nL52RC7dQGBIldNA.vODAkxUvsuY6OATpGfkF9WUJv9vGD/z9y', '2011-11-11', '2022-07-10', '16:30:00'),
(12, 'Doce Twelveth', 'Calle 12 Nº 12, 12 12', '612121212', '12@12.com', '$2y$10$88MzBNi7rfq0kW3sVfMtAOQ6uD1OAcvOyhm44uadNxqGAUXquZIx6', '2012-12-12', '0000-00-00', '00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invoice`
--

CREATE TABLE `invoice` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `service_id` int(11) NOT NULL,
  `qtty` int(11) NOT NULL,
  `total` decimal(11,2) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `invoice`
--

INSERT INTO `invoice` (`id`, `client_id`, `service_id`, `qtty`, `total`, `date`, `time`) VALUES
(1, 1, 2, 1, '600.00', '2022-07-10', '10:58:24'),
(2, 2, 1, 1, '750.00', '2022-07-07', '14:14:12'),
(3, 2, 4, 1, '400.00', '2022-07-07', '14:14:12'),
(4, NULL, 1, 1, '750.00', '2022-07-08', '12:31:50'),
(5, NULL, 9, 1, '550.00', '2022-07-08', '12:31:50'),
(6, NULL, 10, 1, '1000.00', '2022-07-08', '12:31:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `service` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(11,2) NOT NULL,
  `img` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `services`
--

INSERT INTO `services` (`id`, `service`, `price`, `img`) VALUES
(1, 'Corte a Tijera', '750.00', 'img/corte.jpg'),
(2, 'Corte a Máquina', '600.00', 'img/machine.jpg'),
(3, 'Afeitado con Navaja', '500.00', 'img/shave.jpg'),
(4, 'Arreglo de Barba', '400.00', 'img/fix.jpg'),
(5, 'Peinado', '400.00', 'img/brush.jpg'),
(6, 'Pinceladas de Color', '1000.00', 'img/paint.jpg'),
(7, 'Tintura', '1500.00', 'img/dye.jpg'),
(8, 'Mechas', '1750.00', 'img/reflex.jpg'),
(9, 'Perfilado Cejas y Barba', '550.00', 'img/cejas.jpg'),
(10, 'Cortes Tribales', '1000.00', 'img/draw.jpeg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`,`email`);

--
-- Indices de la tabla `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indices de la tabla `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `invoice_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
