-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-02-2023 a las 21:36:24
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

Create DATABASE if not EXISTS nutraproject;
USE nutraproject;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `nutraproject`
--

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
(2, 'Test User', 'At The Street', '611111111', '1@1.net', '$2y$10$8G.xO74zN7TBKJY9BeGNJ.AK7/nGW0e9Mljz/KWbCX2jW3Ekkqk6.', '1970-01-01'),
(3, 'Second Test User', 'Lining on the frontline', '622222222', '2@2.com', '$2y$10$qu9r3m22nFgCrsVuq.L7t.maTrHUbHp7PUEPzBLzAF8kSljTW2ylq', '1972-02-02'),
(4, 'Third User', '3th Street', '633333333', '3@3.com', '$2y$10$/W7Q/1QSbkmTb6bzBTG.m.1bKt03wmDBbGlWn1S32dM2.eIge8xQu', '1973-03-03'),
(5, 'Test User 4', 'Calle 4, Nº 4, 4º 4', '644444444', '4@4.com', '$2y$10$HYogZHo08QA1QFqwKklo1OfMNk4UyXVFyHkNKos8pJ4jjpIz5gDni', '1970-04-04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invoice`
--

CREATE TABLE `invoice` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `product_id` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qtty` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `partial` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `iva` decimal(11,2) NOT NULL,
  `total` decimal(11,2) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `invoice`
--

INSERT INTO `invoice` (`id`, `client_id`, `product_id`, `qtty`, `partial`, `iva`, `total`, `date`, `time`) VALUES
(1, NULL, '1,2,', '1,2,', '0.00', '33.61', '193.66', '2022-11-17', '15:47:31'),
(2, 2, '1,2,', '2,2,', '0.00', '40.59', '233.89', '2022-11-17', '19:26:18'),
(3, 3, '2,', '2,', '0.00', '26.63', '153.43', '2022-11-17', '19:27:10'),
(4, 4, '2,1,', '3,2,', '0.00', '53.91', '310.61', '2022-11-17', '19:27:45'),
(5, 5, '1,2,', '2,1,', '0.00', '27.28', '157.18', '2022-11-18', '18:37:51'),
(6, NULL, '1,2,', '2,2,', '0.00', '40.59', '233.89', '2022-11-20', '13:38:29'),
(7, NULL, '1,2,', '3,2,', '0.00', '47.58', '274.13', '2022-11-20', '13:40:36'),
(8, NULL, '1,2,', '9,10,', '0.00', '195.98', '1129.23', '2022-11-20', '13:57:34'),
(9, NULL, '1,2,', '2,2,', '0.00', '40.59', '233.89', '2022-11-20', '13:58:03'),
(10, NULL, '1,', '2,', '0.00', '13.97', '80.47', '2022-11-20', '18:07:53'),
(11, NULL, '2,1,', '2,3,', '0.00', '47.58', '274.13', '2022-11-21', '02:58:02'),
(12, NULL, '1,', '1,', '0.00', '6.98', '40.23', '2022-11-21', '02:59:11'),
(13, NULL, '2,1,', '3,2,', '0.00', '53.91', '310.61', '2022-11-21', '02:59:51'),
(14, NULL, '2,', '1,', '0.00', '13.31', '76.71', '2022-11-21', '03:00:06'),
(15, NULL, '2,', '6,', '0.00', '79.88', '460.28', '2022-11-21', '03:19:39'),
(16, NULL, '1,', '2,', '0.00', '13.97', '80.47', '2022-11-21', '03:27:03'),
(17, NULL, '1,', '1,', '0.00', '6.98', '40.23', '2022-11-21', '03:27:37'),
(18, 3, '3,1,2,', '1,2,1,', '0.00', '41.98', '241.88', '2022-11-21', '03:42:12'),
(19, NULL, '3,', '1,', '0.00', '14.70', '84.70', '2022-11-24', '12:00:00'),
(20, NULL, '4,', '1,', '0.00', '5.25', '30.25', '2022-11-24', '12:00:18'),
(21, NULL, '3,', '1,', '0.00', '14.70', '84.70', '2022-11-24', '21:20:31'),
(22, NULL, '5,', '1,', '0.00', '8.40', '48.40', '2022-11-24', '21:20:44'),
(23, NULL, '1,2,3,4,5,7,', '3,2,2,2,4,5,', '0.00', '40.64', '234.14', '2022-11-25', '14:44:22'),
(24, NULL, '5,7,', '2,5,', '0.00', '18.38', '105.88', '2022-11-25', '17:07:35'),
(26, NULL, '4,1,', '1,1,', '0.00', '12.23', '70.48', '2022-11-29', '21:50:43'),
(27, NULL, '10,3,', '2,1,', '0.00', '21.00', '121.00', '2022-11-30', '17:06:07'),
(28, NULL, '9,1,', '1,2,', '0.00', '15.65', '90.15', '2022-11-30', '17:10:27'),
(29, NULL, '14,9,10,', '2,3,2,', '9.00,3.5,4,', '17.85', '102.85', '2022-12-12', '04:23:40'),
(30, NULL, '9,1,', '2,3,', '8.50,3,4,', '24.31', '140.06', '2022-12-12', '04:27:17'),
(31, NULL, '5,7,', '1,4,', '12.00,3.50,3.50,', '10.50', '60.50', '2022-12-12', '04:31:14'),
(32, NULL, '14,9,3,', '2,5,1,', '0.00', '30.24', '144.00', '2023-02-02', '18:36:39');

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
  `brand` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `product`, `price`, `stock`, `img`, `kind`, `brand`, `description`) VALUES
(1, 'PSYCHO MODE 480G', '33.25', 13, 'img/PSYCHO-480G.webp', 'Proteínas', 'SKULL TRAIN', 'De las Mejores, 90% proteína pura aislada de suero de leche.Con esta proteína la curva de entrenamiento crece exponencialmente.Consulta con los expertos en nutrición, para la dosificación exacta para tu entrenamiento.'),
(2, 'SUPER 100% WHEY TIRAMISU - 2KG', '63.40', 7, 'img/WHEY-TIRAMISU-2KG.webp', 'Proteínas', 'NAMEDSPORT', 'Excelente calidad, más de 80% proteína pura de suero de leche. Con esta proteína la curva de entrenamiento crece linealmente. Consulta con los expertos en nutrición, para la dosificación exacta para tu entrenamiento.'),
(3, 'Carnitina Slim Diet 1Kg.', '70.00', 9, 'img/Carnitina.webp', 'Aminoácidos', 'NutraProject', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.'),
(4, 'Carbohidratos sin Sabor 1 Kg.', '25.00', 17, 'img/carbo.webp', 'Carbohidratos', 'NutraProject', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.'),
(5, 'Aceite Omega 3 120 Ml.', '40.00', 12, 'img/Omega.webp', 'Aceites Insaturados', 'NutraProject', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.'),
(6, 'Vitaminas 120 Capsulas', '20.00', 20, 'img/Vitaminas.webp', 'Vitaminas', 'NutraProject', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.'),
(7, 'Barra Energética Vainilla y Miel con Chocolate', '2.50', 9, 'img/Barras.webp', 'Barras de cereales y Proteínas', 'NutraProject', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.'),
(8, 'Pastillas de menta', '5.00', 38, 'img/mentos.webp', 'Carbohidratos', 'Muscletech', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.'),
(9, 'Chicles de Chocolate', '8.00', 38, 'img/choco.webp', 'Proteínas', 'My Protein', 'Esto seguro que no te lo esperabas, chiclets de proteínas con sabor a chocolate.\r\nSin azucar, más de 75% de proteína pura de huevo entero. Un chute de proteínas para disfrutar antes de empezar a entrenar.\r\nConsulta con los expertos en nutrición, para la dosificación exacta para tu entrenamiento.'),
(10, 'Chuletón de Buey', '15.00', 20, 'img/chuleton.webp', 'Proteínas', 'Life Pro', 'Este es el chuletón de toda la vida.\r\nUn gustito de vez en cuando no hace nada mal.\r\nIgualmente como siempre te recomendamos, consulta con los expertos en nutrición, para la dosificación exacta para tu entrenamiento.'),
(11, 'Otra Proteína', '20.00', 19, 'img/carbo.webp', 'Proteínas', 'My Protein', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.'),
(12, 'Otra Más', '20.00', 15, 'img/carbo.webp', 'Proteínas', 'My Protein', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.'),
(13, 'Esta está en la otra página.', '20.00', 16, 'img/carbo.webp', 'Proteínas', 'My Protein', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.'),
(14, 'Proteína HSN', '17.00', 25, 'img/protein.webp', 'Proteínas', 'Hsn', 'De las mejores Proteínas, Suero Aislado de Leche de Vacas Alimentadas con Pasto naturalmente. 90% Pura. Con esta proteína la curva de entrenamiento crece exponencialmente. Consulta con los expertos en nutrición, para la dosificación exacta para tu entrenamiento.');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
