-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.15 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL version:             7.0.0.4053
-- Date/time:                    2013-07-30 23:49:27
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping structure for table test.fuckcompany
DROP TABLE IF EXISTS `fuckcompany`;
CREATE TABLE IF NOT EXISTS `fuckcompany` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `company_name` varchar(1000) DEFAULT '',
  `reason` varchar(3000) DEFAULT '',
  `date` date DEFAULT '0000-00-00',
  `sub_name` varchar(100) DEFAULT '',
  `other` varchar(3000) DEFAULT '',
  `createdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `flag` tinyint(3) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Dumping data for table test.fuckcompany: ~1 rows (approximately)
DELETE FROM `fuckcompany`;
/*!40000 ALTER TABLE `fuckcompany` DISABLE KEYS */;
INSERT INTO `fuckcompany` (`id`, `company_name`, `reason`, `date`, `sub_name`, `other`, `createdate`, `flag`) VALUES
	(6, '%E9%87%8D%E5%BA%86%E6%90%9C%E7%B4%A2%E7%A7%91%E6%8A%80%E5%8F%91%E5%B1%95%E6%9C%89%E9%99%90%E5%85%AC%E5%8F%B8', '%E6%8B%96%E6%AC%A0%E7%A6%BB%E8%81%8C%E5%91%98%E5%B7%A5%E5%B7%A5%E8%B5%84%EF%BC%8C%E5%85%A5%E8%81%8C%E5%89%8D%E7%9A%84%E5%BE%85%E9%81%87%E5%A4%B8%E7%9A%84%E5%BE%88%E7%BE%8E%E5%A5%BD', '2013-07-30', '%E5%8C%BF%E5%90%8D', '-', '2013-07-30 23:44:05', 1);
/*!40000 ALTER TABLE `fuckcompany` ENABLE KEYS */;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
