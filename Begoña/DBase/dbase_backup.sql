CREATE TABLE `invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pat_id` int(11) NOT NULL,
  `concept` varchar(2048) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qtty` int(11) NOT NULL,
  `partial` decimal(11,2) NOT NULL,
  `irpf` decimal(11,2) NOT NULL,
  `total` decimal(11,2) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO invoice VALUES("1","3","Consulta del 14/02/2023","1","50.00","7.50","42.50","2023-02-14","17:00:00");
INSERT INTO invoice VALUES("2","1","Consulta del 15/02/2023","1","50.00","7.50","42.50","2023-02-15","07:49:40");
INSERT INTO invoice VALUES("3","2","Consulta del 15/02/2023","1","50.00","7.50","42.50","2023-02-15","07:49:54");
INSERT INTO invoice VALUES("4","3","Consulta del 15/02/2023","2","50.00","15.00","85.00","2023-02-15","07:50:29");



CREATE TABLE `patients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO patients VALUES("1","Paciente Uno","611111111","1@1.com");
INSERT INTO patients VALUES("2","Paciente Dos","622222222","2@2.com");
INSERT INTO patients VALUES("3","Paciente Tres","633333333","3@3.com");
INSERT INTO patients VALUES("4","Paciente Cuatro","644444444","4@4.com");
INSERT INTO patients VALUES("5","Paciente Quinto","655555555","5@5.com");
INSERT INTO patients VALUES("6","Paciente Seis","666666666","6@6.com");
INSERT INTO patients VALUES("7","Paciente Uno","611111111","1@1.com");
INSERT INTO patients VALUES("8","Paciente Dos","622222222","2@2.com");
INSERT INTO patients VALUES("9","Paciente Tres","633333333","3@3.com");
INSERT INTO patients VALUES("10","Paciente Cuatro","644444444","4@4.com");
INSERT INTO patients VALUES("11","Paciente Quinto","655555555","5@5.com");
INSERT INTO patients VALUES("12","Paciente Seis","666666666","6@6.com");
INSERT INTO patients VALUES("13","Paciente Uno","611111111","1@1.com");
INSERT INTO patients VALUES("14","Paciente Dos","622222222","2@2.com");
INSERT INTO patients VALUES("15","Paciente Tres","633333333","3@3.com");
INSERT INTO patients VALUES("16","Paciente Cuatro","644444444","4@4.com");
INSERT INTO patients VALUES("17","Paciente Quinto","655555555","5@5.com");
INSERT INTO patients VALUES("18","Paciente Seis","666666666","6@6.com");
INSERT INTO patients VALUES("19","Paciente Uno","611111111","1@1.com");
INSERT INTO patients VALUES("20","Paciente Dos","622222222","2@2.com");
INSERT INTO patients VALUES("21","Paciente Tres","633333333","3@3.com");
INSERT INTO patients VALUES("22","Paciente Cuatro","644444444","4@4.com");
INSERT INTO patients VALUES("23","Paciente Quinto","655555555","5@5.com");
INSERT INTO patients VALUES("24","Paciente Seis","666666666","6@6.com");
INSERT INTO patients VALUES("25","Paciente Uno","611111111","1@1.com");
INSERT INTO patients VALUES("26","Paciente Dos","622222222","2@2.com");
INSERT INTO patients VALUES("27","Paciente Tres","633333333","3@3.com");
INSERT INTO patients VALUES("28","Paciente Cuatro","644444444","4@4.com");
INSERT INTO patients VALUES("29","Paciente Quinto","655555555","5@5.com");
INSERT INTO patients VALUES("30","Paciente Seis","666666666","6@6.com");