/*
SQLyog Ultimate v9.50 
MySQL - 5.5.5-10.1.19-MariaDB : Database - k_means
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`k_means` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `k_means`;

/*Table structure for table `tb_admin` */

DROP TABLE IF EXISTS `tb_admin`;

CREATE TABLE `tb_admin` (
  `user` varchar(16) NOT NULL,
  `pass` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_admin` */

insert  into `tb_admin`(`user`,`pass`) values ('admin','admin');

/*Table structure for table `tb_alternatif` */

DROP TABLE IF EXISTS `tb_alternatif`;

CREATE TABLE `tb_alternatif` (
  `id_alternatif` int(11) NOT NULL AUTO_INCREMENT,
  `kode_alternatif` varchar(255) DEFAULT NULL,
  `nama_alternatif` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `centroid` varchar(16) DEFAULT NULL,
  KEY `id_alternatif` (`id_alternatif`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

/*Data for the table `tb_alternatif` */

insert  into `tb_alternatif`(`id_alternatif`,`kode_alternatif`,`nama_alternatif`,`keterangan`,`centroid`) values (1,'A','Aji Purwinarko','-','M1'),(2,'B','Alamsyah','-','M3'),(3,'C','Anggyi Trisnawan Putra','-','M1'),(4,'D','Budi Prasetyo','-','M1'),(5,'E','Endang Sugiharti','-','M3'),(6,'F','Florentina YA','-','M1'),(7,'G','Isa Akhlis','-','M2'),(8,'H','Much Aziz Muslim','-','M3'),(9,'I','Riza Arifudin','-','M2'),(10,'J','Zaenal Abidin','-','M1');

/*Table structure for table `tb_kriteria` */

DROP TABLE IF EXISTS `tb_kriteria`;

CREATE TABLE `tb_kriteria` (
  `id_kriteria` int(11) NOT NULL AUTO_INCREMENT,
  `kode_kriteria` varchar(16) NOT NULL,
  `nama_kriteria` varchar(255) NOT NULL,
  PRIMARY KEY (`id_kriteria`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `tb_kriteria` */

insert  into `tb_kriteria`(`id_kriteria`,`kode_kriteria`,`nama_kriteria`) values (1,'C1','Nasional'),(2,'C2','Internasional');

/*Table structure for table `tb_rel_alternatif` */

DROP TABLE IF EXISTS `tb_rel_alternatif`;

CREATE TABLE `tb_rel_alternatif` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `id_alternatif` int(11) NOT NULL,
  `id_kriteria` int(11) NOT NULL,
  `nilai` double NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=69 DEFAULT CHARSET=latin1;

/*Data for the table `tb_rel_alternatif` */

insert  into `tb_rel_alternatif`(`ID`,`id_alternatif`,`id_kriteria`,`nilai`) values (1,1,1,18),(2,1,2,0),(44,6,2,16),(48,8,2,84),(52,10,2,12),(6,2,1,54),(7,2,2,40),(43,6,1,18),(47,8,1,36),(51,10,1,21),(11,3,1,9),(12,3,2,4),(42,5,2,61),(46,7,2,0),(50,9,2,0),(41,5,1,36),(28,4,2,16),(27,4,1,18),(45,7,1,87),(49,9,1,50);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
