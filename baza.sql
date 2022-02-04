/*
SQLyog Community v13.1.5  (64 bit)
MySQL - 10.4.8-MariaDB : Database - baza_biblioteka
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`baza_biblioteka` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `baza_biblioteka`;

/*Table structure for table `biblioteka` */

DROP TABLE IF EXISTS `biblioteka`;

CREATE TABLE `biblioteka` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `naziv` varchar(50) DEFAULT NULL,
  `adresa` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Data for the table `biblioteka` */

insert  into `biblioteka`(`id`,`naziv`,`adresa`) values 
(1,'prva','a 4'),
(3,'treca','Makenzijeva bb');

/*Table structure for table `biblioteka_knjiga` */
DROP TABLE IF EXISTS `biblioteka_knjiga`;

CREATE TABLE `biblioteka_knjiga` (
  `biblioteka` bigint(20) NOT NULL,
  `knjiga` bigint(20) NOT NULL,
  `broj_primeraka` int(11) DEFAULT NULL,
  PRIMARY KEY (`biblioteka`,`knjiga`),
  KEY `knjiga` (`knjiga`),
  CONSTRAINT `biblioteka_knjiga_ibfk_1` FOREIGN KEY (`biblioteka`) REFERENCES `biblioteka` (`id`),
  CONSTRAINT `biblioteka_knjiga_ibfk_2` FOREIGN KEY (`knjiga`) REFERENCES `knjiga` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `biblioteka_knjiga` */

insert  into `biblioteka_knjiga`(`biblioteka`,`knjiga`,`broj_primeraka`) values 
(1,3,7),
(1,4,5),
(1,5,78),
(3,3,78),
(3,4,78);

/*Table structure for table `kategorija_knjige` */

DROP TABLE IF EXISTS `kategorija_knjige`;

CREATE TABLE `kategorija_knjige` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `naziv` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

/*Data for the table `kategorija_knjige` */

insert  into `kategorija_knjige`(`id`,`naziv`) values 
(1,'sci-fi'),
(2,'roman'),
(3,'pripovetka'),
(4,'horor'),
(5,'za decu');

/*Table structure for table `knjiga` */

DROP TABLE IF EXISTS `knjiga`;

CREATE TABLE `knjiga` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `kategorija` bigint(20) DEFAULT NULL,
  `naziv` varchar(40) DEFAULT NULL,
  `broj_strana` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kategorija` (`kategorija`),
  CONSTRAINT `knjiga_ibfk_1` FOREIGN KEY (`kategorija`) REFERENCES `kategorija_knjige` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

/*Data for the table `knjiga` */

insert  into `knjiga`(`id`,`kategorija`,`naziv`,`broj_strana`) values 
(3,2,'zlocin i kazna  ',502),
(4,2,'bedni ljudi ',250),
(5,3,'Cica gorio   ',45);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
