

CREATE TABLE `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pass` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bday` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone` (`phone`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO clients VALUES("1","César Matelat","Calle Fermín Morín Nº 2, portal 4, 7º B.","664774821","cesarmatelat@gmail.com","$2y$10$tlfz5sYugFivUZgLwrAdxujmZEY.OLxj7VyRWb3U7pvmgfzpvxAO.","1968-04-05");



CREATE TABLE `invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) DEFAULT NULL,
  `product_id` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qtty` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` decimal(11,2) NOT NULL,
  `iva` decimal(11,2) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`),
  CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO invoice VALUES("1","1","1,2,","1,2,","193.66","33.61","2022-11-17","15:47:31");
INSERT INTO invoice VALUES("2","1","1,2,","2,2,","233.89","40.59","2022-11-17","19:26:18");
INSERT INTO invoice VALUES("3","1","2,","2,","153.43","26.63","2022-11-17","19:27:10");
INSERT INTO invoice VALUES("4","1","2,1,","3,2,","310.61","53.91","2022-11-17","19:27:45");
INSERT INTO invoice VALUES("5","1","1,2,","2,1,","157.18","27.28","2022-11-18","18:37:51");
INSERT INTO invoice VALUES("6","1","1,2,","2,2,","233.89","40.59","2022-11-20","13:38:29");
INSERT INTO invoice VALUES("7","1","1,2,","3,2,","274.13","47.58","2022-11-20","13:40:36");
INSERT INTO invoice VALUES("8","1","1,2,","9,10,","1129.23","195.98","2022-11-20","13:57:34");
INSERT INTO invoice VALUES("9","1","1,2,","2,2,","233.89","40.59","2022-11-20","13:58:03");
INSERT INTO invoice VALUES("10","1","1,","2,","80.47","13.97","2022-11-20","18:07:53");
INSERT INTO invoice VALUES("11","1","2,1,","2,3,","274.13","47.58","2022-11-21","02:58:02");
INSERT INTO invoice VALUES("12","1","1,","1,","40.23","6.98","2022-11-21","02:59:11");
INSERT INTO invoice VALUES("13","1","2,1,","3,2,","310.61","53.91","2022-11-21","02:59:51");
INSERT INTO invoice VALUES("14","1","2,","1,","76.71","13.31","2022-11-21","03:00:06");
INSERT INTO invoice VALUES("15","1","2,","6,","460.28","79.88","2022-11-21","03:19:39");
INSERT INTO invoice VALUES("16","1","1,","2,","80.47","13.97","2022-11-21","03:27:03");
INSERT INTO invoice VALUES("17","1","1,","1,","40.23","6.98","2022-11-21","03:27:37");
INSERT INTO invoice VALUES("18","1","3,1,2,","1,2,1,","241.88","41.98","2022-11-21","03:42:12");
INSERT INTO invoice VALUES("19","1","3,","1,","84.70","14.70","2022-11-24","12:00:00");
INSERT INTO invoice VALUES("20","1","4,","1,","30.25","5.25","2022-11-24","12:00:18");
INSERT INTO invoice VALUES("21","1","3,","1,","84.70","14.70","2022-11-24","21:20:31");
INSERT INTO invoice VALUES("22","1","5,","1,","48.40","8.40","2022-11-24","21:20:44");
INSERT INTO invoice VALUES("23","1","3,4,7,","2,2,5,","234.14","40.64","2022-11-25","14:44:22");
INSERT INTO invoice VALUES("24","1","5,7,","2,5,","105.88","18.38","2022-11-25","17:07:35");
INSERT INTO invoice VALUES("26","","4,1,","1,1,","70.48","12.23","2022-11-29","21:50:43");



CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(11,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `img` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kind` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO products VALUES("1","PSYCHO MODE 480G","33.25","10","img/PSYCHO-480G.jpg","Proteínas","SKULL TRAIN");
INSERT INTO products VALUES("2","SUPER 100% WHEY TIRAMISU - 2KG","63.40","4","img/WHEY-TIRAMISU-2KG.jpg","Proteínas","NAMEDSPORT");
INSERT INTO products VALUES("3","Carnitina Slim Diet 1Kg.","70.00","15","img/Carnitina.jpg","Aminoácidos","NutraProject");
INSERT INTO products VALUES("4","Carbohidratos sin Sabor 1 Kg.","25.00","16","img/carbo.jpg","Carbohidratos","NutraProject");
INSERT INTO products VALUES("5","Aceite Omega 3 120 Ml.","40.00","16","img/Omega.avif","Aceites Insaturados","NutraProject");
INSERT INTO products VALUES("6","Vitaminas 120 Capsulas","20.00","6","img/Vitaminas.avif","Vitaminas","NutraProject");
INSERT INTO products VALUES("7","Barra Energética Vainilla y Miel con Chocolte","2.50","10","img/Barras.webp","Barras de cereales y Proteínas","NutraProject");
INSERT INTO products VALUES("8","Pastillas de menta","5.00","40","img/mentos.png","Carbohidratos","Muscletech");
INSERT INTO products VALUES("9","Chicles de Chocolate","8.00","40","img/choco.jpg","Proteínas","My Protein");
INSERT INTO products VALUES("10","Chuletón de Buey","15.00","48","img/chuleton.png","Proteínas","Life Pro");
INSERT INTO products VALUES("11","Otra Proteína","20.00","20","img/carbo.jpg","Proteínas","My Protein");
INSERT INTO products VALUES("12","Otra Más","20.00","20","img/carbo.jpg","Proteínas","My Protein");
INSERT INTO products VALUES("13","Esta está en la otra página.","20.00","20","img/carbo.jpg","Proteínas","My Protein");

