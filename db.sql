
CREATE DATABASE IF NOT EXISTS `kabum`;
USE `kabum`;


CREATE TABLE IF NOT EXISTS `customer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `birth_date` date DEFAULT NULL,
  `cpf` varchar(11) DEFAULT NULL,
  `rg` varchar(9) DEFAULT NULL,
  `phone_number` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cpf` (`cpf`),
  UNIQUE KEY `rg` (`rg`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;


INSERT INTO `customer` (`id`, `name`, `birth_date`, `cpf`, `rg`, `phone_number`) VALUES
	(1, 'Edson Ribeiro', '1995-04-05', '4445554444', '444444444', '14981667837');

CREATE TABLE IF NOT EXISTS `customer_address` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `address` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `client` (`customer_id`),
  CONSTRAINT `client` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;


INSERT INTO `customer_address` (`id`, `customer_id`, `address`) VALUES
	(1, 1, 'Rua João Gomes Ballera, 341');

CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `name` varchar(150) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO `user` (`id`, `username`, `password`, `name`) VALUES
	(2, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'Administrator');

