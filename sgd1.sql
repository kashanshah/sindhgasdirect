DROP TABLE IF EXISTS configurations;

CREATE TABLE `configurations` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `FullName` varchar(50) DEFAULT NULL,
  `CompanyName` varchar(100) DEFAULT NULL,
  `SiteTitle` varchar(255) DEFAULT NULL,
  `Domain` varchar(255) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Email` varchar(150) DEFAULT NULL,
  `GasRate` float NOT NULL,
  `RetailGasRate` float NOT NULL,
  `DropboxEmail` text NOT NULL,
  `AlertReceiver` varchar(255) DEFAULT '',
  `SMTPHost` varchar(255) DEFAULT '',
  `SMTPUser` varchar(255) DEFAULT '',
  `SMTPPassword` varchar(20) DEFAULT '',
  `Number` varchar(20) DEFAULT NULL,
  `FaxNumber` varchar(20) DEFAULT NULL,
  `Password` varchar(15) DEFAULT NULL,
  `Logo` text NOT NULL,
  `SMSUsername` text NOT NULL,
  `SMSPassword` text NOT NULL,
  `CaptchaVerification` int(11) NOT NULL DEFAULT '1',
  `BarCodeLength` int(11) NOT NULL DEFAULT '4',
  `DateModified` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO configurations VALUES("1","Inventory & Sales Management System","Sindh Gas Direct","Sindh Gas Direct","","Suite No. 1, 3rd Floor, Plot No. 88–C, 11th Commercial Street, D.H.A. Phase-II Extension, Karachi–75500, Pakistan.","asg_ali@hotmail.com","150","150","2019-01-26","03453041744","","","","Ph: +92-213-5312021 ","","123","logo.jpg","sindhgas138","11138","0","12","2019-01-26 02:07:53");



DROP TABLE IF EXISTS cylinder_savings;

CREATE TABLE `cylinder_savings` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CylinderID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `PurchaseID` int(11) NOT NULL,
  `SaleID` int(11) NOT NULL,
  `Savings` float NOT NULL,
  `PerformedBy` int(11) NOT NULL,
  `DateAdded` date NOT NULL,
  `DateModified` date NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4;

INSERT INTO cylinder_savings VALUES("1","3","1","1","0","54","216","2019-03-05","2019-03-05");
INSERT INTO cylinder_savings VALUES("2","3","1","1","0","54","216","2019-03-05","2019-03-05");
INSERT INTO cylinder_savings VALUES("3","3","1","1","0","54","216","2019-03-05","2019-03-05");
INSERT INTO cylinder_savings VALUES("4","3","1","1","0","54","216","2019-03-05","2019-03-05");
INSERT INTO cylinder_savings VALUES("5","3","1","1","0","54","216","2019-03-05","2019-03-05");
INSERT INTO cylinder_savings VALUES("6","3","1","1","0","54","216","2019-03-05","2019-03-05");
INSERT INTO cylinder_savings VALUES("7","3","1","1","0","54","216","2019-03-05","2019-03-05");
INSERT INTO cylinder_savings VALUES("8","2","1","1","0","33.2","216","2019-03-05","2019-03-05");
INSERT INTO cylinder_savings VALUES("9","3","1","1","0","54","216","2019-03-05","2019-03-05");
INSERT INTO cylinder_savings VALUES("10","2","1","1","0","33.2","216","2019-03-05","2019-03-05");
INSERT INTO cylinder_savings VALUES("11","3","1","1","0","54","216","2019-03-05","2019-03-05");
INSERT INTO cylinder_savings VALUES("12","2","1","1","0","33.2","216","2019-03-05","2019-03-05");
INSERT INTO cylinder_savings VALUES("13","3","1","1","0","54","216","2019-03-05","2019-03-05");
INSERT INTO cylinder_savings VALUES("14","1","284","0","1","1.2","222","2019-03-05","2019-03-05");
INSERT INTO cylinder_savings VALUES("15","1","284","0","1","1.2","222","2019-03-05","2019-03-05");
INSERT INTO cylinder_savings VALUES("16","3","284","0","2","3","222","2019-03-05","2019-03-05");
INSERT INTO cylinder_savings VALUES("17","1","284","0","4","1.2","222","2019-01-26","2019-01-26");
INSERT INTO cylinder_savings VALUES("18","4","284","0","4","0.2","222","2019-01-26","2019-01-26");
INSERT INTO cylinder_savings VALUES("19","5","1","1","0","6","216","2019-01-26","2019-01-26");
INSERT INTO cylinder_savings VALUES("20","6","1","1","0","6","216","2019-01-26","2019-01-26");
INSERT INTO cylinder_savings VALUES("21","7","1","1","0","11.8","216","2019-01-26","2019-01-26");
INSERT INTO cylinder_savings VALUES("22","8","1","1","0","11.8","216","2019-01-26","2019-01-26");
INSERT INTO cylinder_savings VALUES("23","9","1","1","0","45.4","216","2019-01-26","2019-01-26");
INSERT INTO cylinder_savings VALUES("24","10","1","1","0","45.4","216","2019-01-26","2019-01-26");
INSERT INTO cylinder_savings VALUES("25","5","1","1","0","6","216","2019-01-26","2019-01-26");
INSERT INTO cylinder_savings VALUES("26","6","1","1","0","6","216","2019-01-26","2019-01-26");
INSERT INTO cylinder_savings VALUES("27","7","1","1","0","11.8","216","2019-01-26","2019-01-26");
INSERT INTO cylinder_savings VALUES("28","8","1","1","0","11.8","216","2019-01-26","2019-01-26");
INSERT INTO cylinder_savings VALUES("29","9","1","1","0","45.4","216","2019-01-26","2019-01-26");
INSERT INTO cylinder_savings VALUES("30","10","1","1","0","45.4","216","2019-01-26","2019-01-26");
INSERT INTO cylinder_savings VALUES("31","9","229","0","7","5","222","2019-01-26","2019-01-26");
INSERT INTO cylinder_savings VALUES("32","7","223","0","9","0.1","222","2019-01-26","2019-01-26");



DROP TABLE IF EXISTS cylinders;

CREATE TABLE `cylinders` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `BarCode` text NOT NULL,
  `Description` text NOT NULL,
  `ShortDescription` text NOT NULL,
  `TierWeight` float NOT NULL,
  `CylinderType` int(11) NOT NULL,
  `ManufacturingDate` date NOT NULL,
  `ExpiryDate` date NOT NULL,
  `PlantID` int(11) NOT NULL,
  `Status` int(11) NOT NULL,
  `PerformedBy` int(11) NOT NULL,
  `DateAdded` datetime NOT NULL,
  `DateModified` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

INSERT INTO cylinders VALUES("1","aa11-a","for demo","test","11.8","0","2019-02-01","2024-02-01","216","1","216","2019-03-05 11:04:19","2019-03-05 11:04:19");
INSERT INTO cylinders VALUES("2","aa11-b","for demo","test","11.8","0","2019-02-01","2024-02-01","216","1","216","2019-03-05 11:04:41","2019-03-05 12:26:50");
INSERT INTO cylinders VALUES("3","aa11-c","for demo","test","45","1","2019-02-01","2024-02-01","216","1","216","2019-03-05 11:05:03","2019-03-05 12:26:51");
INSERT INTO cylinders VALUES("4","aa11-d","for demo","test","11.8","0","2019-02-01","2024-02-01","216","1","216","2019-01-26 00:00:00","2019-01-26 00:00:00");
INSERT INTO cylinders VALUES("5","001","","made by  hitek","8.4","1","2019-03-29","2024-03-29","216","1","216","2019-01-26 12:43:29","2019-01-26 04:40:13");
INSERT INTO cylinders VALUES("6","001a","","made by hitek","8.5","1","2019-03-29","2024-03-29","216","1","216","2019-01-26 12:44:14","2019-01-26 04:40:13");
INSERT INTO cylinders VALUES("7","002","","made by fastube","14.1","2","2019-03-29","2024-03-29","216","1","216","2019-01-26 12:44:45","2019-01-26 04:40:13");
INSERT INTO cylinders VALUES("8","002a","","made by fastube","14.2","2","2019-03-29","2024-03-29","216","1","216","2019-01-26 12:45:07","2019-01-26 04:40:13");
INSERT INTO cylinders VALUES("9","003","","made by mehran","42.2","3","2019-03-29","2024-03-29","216","1","216","2019-01-26 12:45:45","2019-01-26 04:40:13");
INSERT INTO cylinders VALUES("10","003a","","made by mehran","42.1","3","2019-03-29","2024-03-29","216","1","216","2019-01-26 12:46:08","2019-01-26 04:40:13");



DROP TABLE IF EXISTS cylinderstatus;

CREATE TABLE `cylinderstatus` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `InvoiceID` int(11) NOT NULL,
  `CylinderID` int(11) NOT NULL,
  `HandedTo` int(11) NOT NULL,
  `Weight` float NOT NULL,
  `PerformedBy` int(11) NOT NULL,
  `DateAdded` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=128 DEFAULT CHARSET=latin1;

INSERT INTO cylinderstatus VALUES("1","1","1","216","40","216","2019-03-05 11:05:40");
INSERT INTO cylinderstatus VALUES("2","1","2","216","45","216","2019-03-05 11:05:40");
INSERT INTO cylinderstatus VALUES("3","1","3","216","99","216","2019-03-05 11:05:40");
INSERT INTO cylinderstatus VALUES("4","2","1","220","40","216","2019-03-05 11:06:50");
INSERT INTO cylinderstatus VALUES("5","2","2","220","45","216","2019-03-05 11:06:50");
INSERT INTO cylinderstatus VALUES("6","1","1","222","40","222","2019-03-05 11:10:52");
INSERT INTO cylinderstatus VALUES("7","4","3","220","99","216","2019-03-05 11:35:03");
INSERT INTO cylinderstatus VALUES("8","1","3","216","99","1","2019-03-05 11:51:40");
INSERT INTO cylinderstatus VALUES("9","1","3","216","99","1","2019-03-05 11:52:34");
INSERT INTO cylinderstatus VALUES("10","1","3","216","99","1","2019-03-05 11:52:39");
INSERT INTO cylinderstatus VALUES("11","8","3","216","99","216","2019-03-05 12:03:40");
INSERT INTO cylinderstatus VALUES("12","9","3","220","99","216","2019-03-05 12:03:50");
INSERT INTO cylinderstatus VALUES("13","1","3","216","99","1","2019-03-05 12:04:59");
INSERT INTO cylinderstatus VALUES("14","1","3","216","99","1","2019-03-05 12:09:20");
INSERT INTO cylinderstatus VALUES("15","12","3","216","99","216","2019-03-05 12:10:34");
INSERT INTO cylinderstatus VALUES("16","13","3","220","99","216","2019-03-05 12:10:42");
INSERT INTO cylinderstatus VALUES("17","1","3","216","99","1","2019-03-05 12:11:10");
INSERT INTO cylinderstatus VALUES("18","15","3","216","99","216","2019-03-05 12:12:30");
INSERT INTO cylinderstatus VALUES("19","16","3","220","99","216","2019-03-05 12:13:53");
INSERT INTO cylinderstatus VALUES("20","1","3","216","99","1","2019-03-05 12:14:52");
INSERT INTO cylinderstatus VALUES("21","18","3","216","99","216","2019-03-05 12:16:02");
INSERT INTO cylinderstatus VALUES("22","19","3","220","99","216","2019-03-05 12:16:09");
INSERT INTO cylinderstatus VALUES("23","1","2","216","45","1","2019-03-05 12:16:56");
INSERT INTO cylinderstatus VALUES("24","1","3","216","99","1","2019-03-05 12:16:56");
INSERT INTO cylinderstatus VALUES("25","22","2","216","45","216","2019-03-05 12:17:28");
INSERT INTO cylinderstatus VALUES("26","22","3","216","99","216","2019-03-05 12:17:28");
INSERT INTO cylinderstatus VALUES("27","23","2","220","45","216","2019-03-05 12:17:38");
INSERT INTO cylinderstatus VALUES("28","23","3","220","99","216","2019-03-05 12:17:38");
INSERT INTO cylinderstatus VALUES("29","1","2","216","45","1","2019-03-05 12:25:04");
INSERT INTO cylinderstatus VALUES("30","1","3","216","99","1","2019-03-05 12:25:04");
INSERT INTO cylinderstatus VALUES("31","26","2","216","45","216","2019-03-05 12:25:48");
INSERT INTO cylinderstatus VALUES("32","26","3","216","99","216","2019-03-05 12:25:48");
INSERT INTO cylinderstatus VALUES("33","27","2","220","45","216","2019-03-05 12:26:00");
INSERT INTO cylinderstatus VALUES("34","27","3","220","99","216","2019-03-05 12:26:00");
INSERT INTO cylinderstatus VALUES("35","1","2","216","45","1","2019-03-05 12:26:50");
INSERT INTO cylinderstatus VALUES("36","1","3","216","99","1","2019-03-05 12:26:51");
INSERT INTO cylinderstatus VALUES("37","30","2","216","45","216","2019-03-05 12:26:58");
INSERT INTO cylinderstatus VALUES("38","30","3","216","99","216","2019-03-05 12:26:58");
INSERT INTO cylinderstatus VALUES("39","31","2","220","45","216","2019-03-05 12:27:06");
INSERT INTO cylinderstatus VALUES("40","31","3","220","99","216","2019-03-05 12:27:06");
INSERT INTO cylinderstatus VALUES("45","4","2","222","45","220","2019-03-05 13:09:37");
INSERT INTO cylinderstatus VALUES("46","5","3","222","99","220","2019-03-05 13:11:05");
INSERT INTO cylinderstatus VALUES("47","1","1","284","40","222","2019-03-05 13:53:46");
INSERT INTO cylinderstatus VALUES("48","2","3","284","99","222","2019-03-05 13:59:56");
INSERT INTO cylinderstatus VALUES("49","1","1","222","13","284","2019-03-05 14:14:28");
INSERT INTO cylinderstatus VALUES("50","1","1","222","13","284","2019-03-05 14:15:04");
INSERT INTO cylinderstatus VALUES("51","2","3","222","48","284","2019-03-05 14:26:14");
INSERT INTO cylinderstatus VALUES("52","3","2","223","40","222","2019-01-26 04:10:05");
INSERT INTO cylinderstatus VALUES("53","3","3","223","99","222","2019-01-26 04:10:05");
INSERT INTO cylinderstatus VALUES("54","42","4","216","32.8","216","2019-01-26 09:55:24");
INSERT INTO cylinderstatus VALUES("55","43","4","220","32.8","216","2019-01-26 09:55:36");
INSERT INTO cylinderstatus VALUES("56","6","4","222","26.8","220","2019-01-26 09:56:50");
INSERT INTO cylinderstatus VALUES("57","4","1","284","40","222","2019-01-26 10:16:03");
INSERT INTO cylinderstatus VALUES("58","4","4","284","26.8","222","2019-01-26 10:16:03");
INSERT INTO cylinderstatus VALUES("59","4","1","222","13","284","2019-01-26 10:30:29");
INSERT INTO cylinderstatus VALUES("60","3","3","222","45","223","2019-01-26 10:30:29");
INSERT INTO cylinderstatus VALUES("61","4","4","222","12.2","284","2019-01-26 10:31:08");
INSERT INTO cylinderstatus VALUES("62","5","1","284","40","222","2019-01-26 10:31:53");
INSERT INTO cylinderstatus VALUES("63","6","3","244","99","222","2019-01-26 03:21:48");
INSERT INTO cylinderstatus VALUES("64","51","5","216","14.4","216","2019-01-26 01:07:35");
INSERT INTO cylinderstatus VALUES("65","51","6","216","14.5","216","2019-01-26 01:07:35");
INSERT INTO cylinderstatus VALUES("66","51","7","216","25.9","216","2019-01-26 01:07:35");
INSERT INTO cylinderstatus VALUES("67","51","8","216","26","216","2019-01-26 01:07:35");
INSERT INTO cylinderstatus VALUES("68","51","9","216","87.6","216","2019-01-26 01:07:35");
INSERT INTO cylinderstatus VALUES("69","51","10","216","87.5","216","2019-01-26 01:07:35");
INSERT INTO cylinderstatus VALUES("70","52","5","220","14.4","216","2019-01-26 01:09:11");
INSERT INTO cylinderstatus VALUES("71","52","6","220","14.5","216","2019-01-26 01:09:11");
INSERT INTO cylinderstatus VALUES("72","52","7","220","25.9","216","2019-01-26 01:09:11");
INSERT INTO cylinderstatus VALUES("73","52","8","220","26","216","2019-01-26 01:09:11");
INSERT INTO cylinderstatus VALUES("74","52","9","220","87.6","216","2019-01-26 01:09:11");
INSERT INTO cylinderstatus VALUES("75","52","10","220","87.5","216","2019-01-26 01:09:11");
INSERT INTO cylinderstatus VALUES("76","1","5","216","14.4","1","2019-01-26 04:38:18");
INSERT INTO cylinderstatus VALUES("77","1","6","216","14.5","1","2019-01-26 04:38:18");
INSERT INTO cylinderstatus VALUES("78","1","7","216","25.9","1","2019-01-26 04:38:18");
INSERT INTO cylinderstatus VALUES("79","1","8","216","26","1","2019-01-26 04:38:18");
INSERT INTO cylinderstatus VALUES("80","1","9","216","87.6","1","2019-01-26 04:38:18");
INSERT INTO cylinderstatus VALUES("81","1","10","216","87.5","1","2019-01-26 04:38:18");
INSERT INTO cylinderstatus VALUES("82","59","5","216","14.4","216","2019-01-26 04:38:57");
INSERT INTO cylinderstatus VALUES("83","59","6","216","14.5","216","2019-01-26 04:38:57");
INSERT INTO cylinderstatus VALUES("84","59","7","216","25.9","216","2019-01-26 04:38:57");
INSERT INTO cylinderstatus VALUES("85","59","8","216","26","216","2019-01-26 04:38:57");
INSERT INTO cylinderstatus VALUES("86","59","9","216","87.6","216","2019-01-26 04:38:57");
INSERT INTO cylinderstatus VALUES("87","59","10","216","87.5","216","2019-01-26 04:38:57");
INSERT INTO cylinderstatus VALUES("88","60","5","220","14.4","216","2019-01-26 04:39:29");
INSERT INTO cylinderstatus VALUES("89","60","6","220","14.5","216","2019-01-26 04:39:29");
INSERT INTO cylinderstatus VALUES("90","60","7","220","25.9","216","2019-01-26 04:39:29");
INSERT INTO cylinderstatus VALUES("91","60","8","220","26","216","2019-01-26 04:39:29");
INSERT INTO cylinderstatus VALUES("92","60","9","220","87.6","216","2019-01-26 04:39:29");
INSERT INTO cylinderstatus VALUES("93","60","10","220","87.5","216","2019-01-26 04:39:29");
INSERT INTO cylinderstatus VALUES("94","1","5","216","14.4","1","2019-01-26 04:40:13");
INSERT INTO cylinderstatus VALUES("95","1","6","216","14.5","1","2019-01-26 04:40:13");
INSERT INTO cylinderstatus VALUES("96","1","7","216","25.9","1","2019-01-26 04:40:13");
INSERT INTO cylinderstatus VALUES("97","1","8","216","26","1","2019-01-26 04:40:13");
INSERT INTO cylinderstatus VALUES("98","1","9","216","87.6","1","2019-01-26 04:40:13");
INSERT INTO cylinderstatus VALUES("99","1","10","216","87.5","1","2019-01-26 04:40:13");
INSERT INTO cylinderstatus VALUES("100","67","5","216","14.4","216","2019-01-26 04:40:42");
INSERT INTO cylinderstatus VALUES("101","67","6","216","14.5","216","2019-01-26 04:40:42");
INSERT INTO cylinderstatus VALUES("102","67","7","216","25.9","216","2019-01-26 04:40:42");
INSERT INTO cylinderstatus VALUES("103","67","8","216","26","216","2019-01-26 04:40:42");
INSERT INTO cylinderstatus VALUES("104","67","9","216","87.6","216","2019-01-26 04:40:42");
INSERT INTO cylinderstatus VALUES("105","67","10","216","87.5","216","2019-01-26 04:40:42");
INSERT INTO cylinderstatus VALUES("106","68","5","220","14.4","216","2019-01-26 04:40:51");
INSERT INTO cylinderstatus VALUES("107","69","6","220","14.5","216","2019-01-26 04:42:09");
INSERT INTO cylinderstatus VALUES("108","69","7","220","25.9","216","2019-01-26 04:42:09");
INSERT INTO cylinderstatus VALUES("109","69","8","220","26","216","2019-01-26 04:42:09");
INSERT INTO cylinderstatus VALUES("110","69","9","220","87.6","216","2019-01-26 04:42:09");
INSERT INTO cylinderstatus VALUES("111","69","10","220","87.5","216","2019-01-26 04:42:09");
INSERT INTO cylinderstatus VALUES("112","7","6","222","14.5","220","2019-01-26 05:25:16");
INSERT INTO cylinderstatus VALUES("113","7","7","222","25.9","220","2019-01-26 05:25:16");
INSERT INTO cylinderstatus VALUES("114","7","8","222","26","220","2019-01-26 05:25:16");
INSERT INTO cylinderstatus VALUES("115","7","9","222","87.6","220","2019-01-26 05:25:16");
INSERT INTO cylinderstatus VALUES("116","7","10","222","87.5","220","2019-01-26 05:25:16");
INSERT INTO cylinderstatus VALUES("117","7","6","229","14.5","222","2019-01-26 05:36:05");
INSERT INTO cylinderstatus VALUES("118","7","7","229","25.9","222","2019-01-26 05:36:05");
INSERT INTO cylinderstatus VALUES("119","7","9","229","87.6","222","2019-01-26 05:36:05");
INSERT INTO cylinderstatus VALUES("120","7","6","222","8.5","229","2019-01-26 05:40:05");
INSERT INTO cylinderstatus VALUES("121","7","7","222","14.1","229","2019-01-26 05:40:05");
INSERT INTO cylinderstatus VALUES("122","7","9","222","47.2","229","2019-01-26 05:40:05");
INSERT INTO cylinderstatus VALUES("123","8","8","229","26","222","2019-01-26 05:42:46");
INSERT INTO cylinderstatus VALUES("124","8","10","229","87.5","222","2019-01-26 05:42:46");
INSERT INTO cylinderstatus VALUES("125","9","7","223","25.9","222","2019-01-26 05:51:17");
INSERT INTO cylinderstatus VALUES("126","9","7","222","14.2","223","2019-01-26 05:53:57");
INSERT INTO cylinderstatus VALUES("127","10","7","223","25.9","222","2019-01-26 05:55:41");



DROP TABLE IF EXISTS cylindertypes;

CREATE TABLE `cylindertypes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` text NOT NULL,
  `Rate` float NOT NULL,
  `Capacity` float NOT NULL,
  `Wastage` float NOT NULL,
  `PerformedBy` int(11) NOT NULL,
  `DateAdded` datetime NOT NULL,
  `DateModified` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO cylindertypes VALUES("1","Type A","106.667","6","0","1","2019-01-26 02:02:41","2019-01-26 12:59:00");
INSERT INTO cylindertypes VALUES("2","Type B","105.932","11.8","0.2","1","2019-01-26 02:03:00","2019-01-26 01:00:37");
INSERT INTO cylindertypes VALUES("3","Type C (Commercial)","105.727","45.4","0.5","1","2019-01-26 02:03:49","2019-01-26 01:02:46");



DROP TABLE IF EXISTS invoices;

CREATE TABLE `invoices` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `IssuedTo` int(11) NOT NULL,
  `VehicleID` int(11) NOT NULL,
  `Note` text NOT NULL,
  `PerformedBy` int(11) NOT NULL,
  `DateAdded` datetime NOT NULL,
  `DateModified` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=latin1;

INSERT INTO invoices VALUES("1","216","0","Refilling","216","2019-03-05 11:05:40","2019-03-05 11:05:40");
INSERT INTO invoices VALUES("2","220","1","","216","2019-03-05 11:06:50","2019-03-05 11:06:50");
INSERT INTO invoices VALUES("3","222","0","","222","2019-03-05 11:10:52","2019-03-05 11:10:52");
INSERT INTO invoices VALUES("4","220","1","","216","2019-03-05 11:35:02","2019-03-05 11:35:02");
INSERT INTO invoices VALUES("5","216","0","","1","2019-03-05 11:51:40","2019-03-05 11:51:40");
INSERT INTO invoices VALUES("6","216","0","","1","2019-03-05 11:52:34","2019-03-05 11:52:34");
INSERT INTO invoices VALUES("7","216","0","","1","2019-03-05 11:52:39","2019-03-05 11:52:39");
INSERT INTO invoices VALUES("8","216","0","Refilling","216","2019-03-05 12:03:40","2019-03-05 12:03:40");
INSERT INTO invoices VALUES("9","220","1","","216","2019-03-05 12:03:50","2019-03-05 12:03:50");
INSERT INTO invoices VALUES("10","216","0","","1","2019-03-05 12:04:59","2019-03-05 12:04:59");
INSERT INTO invoices VALUES("11","216","0","","1","2019-03-05 12:09:20","2019-03-05 12:09:20");
INSERT INTO invoices VALUES("12","216","0","Refilling","216","2019-03-05 12:10:34","2019-03-05 12:10:34");
INSERT INTO invoices VALUES("13","220","1","","216","2019-03-05 12:10:42","2019-03-05 12:10:42");
INSERT INTO invoices VALUES("14","216","0","","1","2019-03-05 12:11:10","2019-03-05 12:11:10");
INSERT INTO invoices VALUES("15","216","0","Refilling","216","2019-03-05 12:12:30","2019-03-05 12:12:30");
INSERT INTO invoices VALUES("16","220","1","","216","2019-03-05 12:13:52","2019-03-05 12:13:52");
INSERT INTO invoices VALUES("17","216","0","","1","2019-03-05 12:14:52","2019-03-05 12:14:52");
INSERT INTO invoices VALUES("18","216","0","Refilling","216","2019-03-05 12:16:02","2019-03-05 12:16:02");
INSERT INTO invoices VALUES("19","220","1","","216","2019-03-05 12:16:09","2019-03-05 12:16:09");
INSERT INTO invoices VALUES("20","216","0","","1","2019-03-05 12:16:56","2019-03-05 12:16:56");
INSERT INTO invoices VALUES("21","216","0","","1","2019-03-05 12:16:56","2019-03-05 12:16:56");
INSERT INTO invoices VALUES("22","216","0","Refilling","216","2019-03-05 12:17:28","2019-03-05 12:17:28");
INSERT INTO invoices VALUES("23","220","1","","216","2019-03-05 12:17:38","2019-03-05 12:17:38");
INSERT INTO invoices VALUES("24","216","0","","1","2019-03-05 12:25:04","2019-03-05 12:25:04");
INSERT INTO invoices VALUES("25","216","0","","1","2019-03-05 12:25:04","2019-03-05 12:25:04");
INSERT INTO invoices VALUES("26","216","0","Refilling","216","2019-03-05 12:25:48","2019-03-05 12:25:48");
INSERT INTO invoices VALUES("27","220","1","","216","2019-03-05 12:26:00","2019-03-05 12:26:00");
INSERT INTO invoices VALUES("28","216","0","","1","2019-03-05 12:26:50","2019-03-05 12:26:50");
INSERT INTO invoices VALUES("29","216","0","","1","2019-03-05 12:26:51","2019-03-05 12:26:51");
INSERT INTO invoices VALUES("30","216","0","Refilling","216","2019-03-05 12:26:58","2019-03-05 12:26:58");
INSERT INTO invoices VALUES("31","220","1","","216","2019-03-05 12:27:06","2019-03-05 12:27:06");
INSERT INTO invoices VALUES("32","222","0","","222","2019-03-05 12:38:10","2019-03-05 12:38:10");
INSERT INTO invoices VALUES("33","222","0","","222","2019-03-05 12:39:26","2019-03-05 12:39:26");
INSERT INTO invoices VALUES("34","222","0","","222","2019-03-05 13:09:37","2019-03-05 13:09:37");
INSERT INTO invoices VALUES("35","222","0","","222","2019-03-05 13:11:05","2019-03-05 13:11:05");
INSERT INTO invoices VALUES("36","284","0","","222","2019-03-05 13:53:46","2019-03-05 13:53:46");
INSERT INTO invoices VALUES("37","284","0","","222","2019-03-05 13:59:56","2019-03-05 13:59:56");
INSERT INTO invoices VALUES("38","222","0","","284","2019-03-05 14:14:28","2019-03-05 14:14:28");
INSERT INTO invoices VALUES("39","222","0","","284","2019-03-05 14:15:04","2019-03-05 14:15:04");
INSERT INTO invoices VALUES("40","222","0","","284","2019-03-05 14:26:14","2019-03-05 14:26:14");
INSERT INTO invoices VALUES("41","223","0","","222","2019-01-26 04:10:05","2019-01-26 04:10:05");
INSERT INTO invoices VALUES("42","216","0","Refilling","216","2019-01-26 09:55:24","2019-01-26 09:55:24");
INSERT INTO invoices VALUES("43","220","1","","216","2019-01-26 09:55:36","2019-01-26 09:55:36");
INSERT INTO invoices VALUES("44","222","0","","222","2019-01-26 09:56:50","2019-01-26 09:56:50");
INSERT INTO invoices VALUES("45","284","0","","222","2019-01-26 10:16:03","2019-01-26 10:16:03");
INSERT INTO invoices VALUES("46","222","0","","284","2019-01-26 10:30:29","2019-01-26 10:30:29");
INSERT INTO invoices VALUES("47","222","0","","223","2019-01-26 10:30:29","2019-01-26 10:30:29");
INSERT INTO invoices VALUES("48","222","0","","284","2019-01-26 10:31:08","2019-01-26 10:31:08");
INSERT INTO invoices VALUES("49","284","0","","222","2019-01-26 10:31:53","2019-01-26 10:31:53");
INSERT INTO invoices VALUES("50","244","0","","222","2019-01-26 03:21:48","2019-01-26 03:21:48");
INSERT INTO invoices VALUES("51","216","0","Refilling","216","2019-01-26 01:07:35","2019-01-26 01:07:35");
INSERT INTO invoices VALUES("52","220","1","29-3-19 \r\ntest","216","2019-01-26 01:09:11","2019-01-26 01:09:11");
INSERT INTO invoices VALUES("53","216","0","","1","2019-01-26 04:38:18","2019-01-26 04:38:18");
INSERT INTO invoices VALUES("54","216","0","","1","2019-01-26 04:38:18","2019-01-26 04:38:18");
INSERT INTO invoices VALUES("55","216","0","","1","2019-01-26 04:38:18","2019-01-26 04:38:18");
INSERT INTO invoices VALUES("56","216","0","","1","2019-01-26 04:38:18","2019-01-26 04:38:18");
INSERT INTO invoices VALUES("57","216","0","","1","2019-01-26 04:38:18","2019-01-26 04:38:18");
INSERT INTO invoices VALUES("58","216","0","","1","2019-01-26 04:38:18","2019-01-26 04:38:18");
INSERT INTO invoices VALUES("59","216","0","Refilling","216","2019-01-26 04:38:57","2019-01-26 04:38:57");
INSERT INTO invoices VALUES("60","220","1","","216","2019-01-26 04:39:29","2019-01-26 04:39:29");
INSERT INTO invoices VALUES("61","216","0","","1","2019-01-26 04:40:13","2019-01-26 04:40:13");
INSERT INTO invoices VALUES("62","216","0","","1","2019-01-26 04:40:13","2019-01-26 04:40:13");
INSERT INTO invoices VALUES("63","216","0","","1","2019-01-26 04:40:13","2019-01-26 04:40:13");
INSERT INTO invoices VALUES("64","216","0","","1","2019-01-26 04:40:13","2019-01-26 04:40:13");
INSERT INTO invoices VALUES("65","216","0","","1","2019-01-26 04:40:13","2019-01-26 04:40:13");
INSERT INTO invoices VALUES("66","216","0","","1","2019-01-26 04:40:13","2019-01-26 04:40:13");
INSERT INTO invoices VALUES("67","216","0","Refilling","216","2019-01-26 04:40:42","2019-01-26 04:40:42");
INSERT INTO invoices VALUES("68","220","1","","216","2019-01-26 04:40:51","2019-01-26 04:40:51");
INSERT INTO invoices VALUES("69","220","1","","216","2019-01-26 04:42:09","2019-01-26 04:42:09");
INSERT INTO invoices VALUES("70","222","0","","222","2019-01-26 05:25:16","2019-01-26 05:25:16");
INSERT INTO invoices VALUES("71","229","0","","222","2019-01-26 05:36:05","2019-01-26 05:36:05");
INSERT INTO invoices VALUES("72","222","0","","229","2019-01-26 05:40:05","2019-01-26 05:40:05");
INSERT INTO invoices VALUES("73","222","0","","229","2019-01-26 05:40:05","2019-01-26 05:40:05");
INSERT INTO invoices VALUES("74","222","0","","229","2019-01-26 05:40:05","2019-01-26 05:40:05");
INSERT INTO invoices VALUES("75","229","0","","222","2019-01-26 05:42:46","2019-01-26 05:42:46");
INSERT INTO invoices VALUES("76","223","0","","222","2019-01-26 05:51:17","2019-01-26 05:51:17");
INSERT INTO invoices VALUES("77","222","0","","223","2019-01-26 05:53:57","2019-01-26 05:53:57");
INSERT INTO invoices VALUES("78","223","0","","222","2019-01-26 05:55:41","2019-01-26 05:55:41");



DROP TABLE IF EXISTS notifications;

CREATE TABLE `notifications` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` text NOT NULL,
  `Description` text NOT NULL,
  `Link` text NOT NULL,
  `UserID` int(11) NOT NULL,
  `RoleID` int(11) NOT NULL,
  `Priority` int(11) NOT NULL,
  `Status` int(11) NOT NULL,
  `DateAdded` datetime NOT NULL,
  `DateModified` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO notifications VALUES("1","Gas Difference","Shopkeeper: SGD Shop-1 (SGD Shop-1)\r\n                    Cylinder ID: aa11-b\r\n				    Weight when received: 45.00KG\r\n				    Weight when sold: 40.00KG","viewsale.php?ID=3","222","0","100","1","2019-01-26 04:10:05","2019-01-26 04:10:05");
INSERT INTO notifications VALUES("2","Gas Difference","Driver: Muhammad Hashim (Muhammad Hashim)\r\n                    Cylinder ID: aa11-d\r\n				    Weight when dispatched: 32.80KG\r\n				    Weight when received: 26.80KG","viewpurchase.php?ID=6","216","0","100","1","2019-01-26 09:56:50","2019-01-26 09:56:50");



DROP TABLE IF EXISTS paymentmethods;

CREATE TABLE `paymentmethods` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` text NOT NULL,
  `Details` text NOT NULL,
  `Status` int(11) NOT NULL,
  `PlantID` int(11) NOT NULL,
  `PerformedBy` int(11) NOT NULL,
  `DateAdded` datetime NOT NULL,
  `DateModified` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO paymentmethods VALUES("1","Jazz Cash Account","Jazz Cash Mobile Account\r\nNumber: 0300-0000000\r\nName: Sindh Gas Direct","1","216","0","2019-03-09 12:36:25","2019-01-27 00:00:00");
INSERT INTO paymentmethods VALUES("2","Bank Al Habib","Bank Al Habib Funds Transfer\r\nAccount Number: 12031293819231\r\nAccount Title: Sindh Gas Direct","1","216","0","2019-03-09 13:14:28","0000-00-00 00:00:00");
INSERT INTO paymentmethods VALUES("3","Easypaise","Easypaisa\r\nNumber: 03451234567","1","216","0","2019-03-09 02:33:31","2019-01-26 00:00:00");



DROP TABLE IF EXISTS payments;

CREATE TABLE `payments` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `MethodID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Amount` float NOT NULL,
  `Details` text NOT NULL,
  `Image` text NOT NULL,
  `PerformedBy` int(11) NOT NULL,
  `DateAdded` datetime NOT NULL,
  `DateModified` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO payments VALUES("1","2","222","10000","xyz","","222","2019-01-26 09:41:05","2019-01-26 09:41:05");



DROP TABLE IF EXISTS purchase_details;

CREATE TABLE `purchase_details` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `PurchaseID` int(11) NOT NULL,
  `CylinderID` int(11) NOT NULL,
  `TierWeight` float NOT NULL,
  `CompanyTotalWeight` float NOT NULL,
  `TotalWeight` float NOT NULL,
  `Price` float NOT NULL,
  `RetailPrice` float NOT NULL,
  `GasRate` float NOT NULL,
  `ReturnStatus` int(11) NOT NULL,
  `ReturnWeight` float NOT NULL,
  `ReturnDate` datetime NOT NULL,
  `PerformedBy` int(11) NOT NULL,
  `DateAdded` datetime NOT NULL,
  `DateModified` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

INSERT INTO purchase_details VALUES("1","1","1","11.8","40","40","4230","4230","150","0","0","2019-03-05 11:10:52","222","2019-03-05 11:10:52","2019-03-05 11:10:52");
INSERT INTO purchase_details VALUES("6","4","2","11.8","45","45","4980","4980","150","0","0","2019-03-05 13:09:37","222","2019-03-05 13:09:37","2019-03-05 13:09:37");
INSERT INTO purchase_details VALUES("7","5","3","45","99","99","8100","8100","150","0","0","2019-03-05 13:11:05","222","2019-03-05 13:11:05","2019-03-05 13:11:05");
INSERT INTO purchase_details VALUES("8","6","4","11.8","32.8","26.8","2250","3150","150","0","0","2019-01-26 09:56:50","222","2019-01-26 09:56:50","2019-01-26 09:56:50");
INSERT INTO purchase_details VALUES("9","7","6","8.5","14.5","14.5","900","900","150","0","0","2019-01-26 05:25:16","222","2019-01-26 05:25:16","2019-01-26 05:25:16");
INSERT INTO purchase_details VALUES("10","7","7","14.1","25.9","25.9","1770","1770","150","0","0","2019-01-26 05:25:16","222","2019-01-26 05:25:16","2019-01-26 05:25:16");
INSERT INTO purchase_details VALUES("11","7","8","14.2","26","26","1770","1770","150","0","0","2019-01-26 05:25:16","222","2019-01-26 05:25:16","2019-01-26 05:25:16");
INSERT INTO purchase_details VALUES("12","7","9","42.2","87.6","87.6","6810","6810","150","0","0","2019-01-26 05:25:16","222","2019-01-26 05:25:16","2019-01-26 05:25:16");
INSERT INTO purchase_details VALUES("13","7","10","42.1","87.5","87.5","6810","6810","150","0","0","2019-01-26 05:25:16","222","2019-01-26 05:25:16","2019-01-26 05:25:16");



DROP TABLE IF EXISTS purchases;

CREATE TABLE `purchases` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ShopID` int(11) NOT NULL,
  `GasRate` float NOT NULL,
  `Total` float NOT NULL,
  `Paid` float NOT NULL,
  `Balance` float NOT NULL,
  `Unpaid` float NOT NULL,
  `RefNum` text NOT NULL,
  `Note` text NOT NULL,
  `PerformedBy` int(11) NOT NULL,
  `DateAdded` datetime NOT NULL,
  `DateModified` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

INSERT INTO purchases VALUES("1","222","150","4230","4230","0","0","Q3P61ERKE,WJTK15ZGW","","222","2019-03-05 11:10:52","2019-01-26 12:26:10");
INSERT INTO purchases VALUES("4","222","150","4980","4980","0","0","VGOC4NHNS,XHXG465M1","","222","2019-03-05 13:09:37","2019-01-26 12:26:17");
INSERT INTO purchases VALUES("5","222","150","8100","90","0","8010","SSM451XDW,443I5N6LW","","222","2019-03-05 13:11:05","2019-01-26 12:26:28");
INSERT INTO purchases VALUES("6","222","150","3150","0","0","3150","RRE16HLUU","","222","2019-01-26 09:56:50","2019-01-26 09:56:50");
INSERT INTO purchases VALUES("7","222","150","18060","0","0","18060","FNCK7BTH6","","222","2019-01-26 05:25:16","2019-01-26 05:25:16");



DROP TABLE IF EXISTS roles;

CREATE TABLE `roles` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` text NOT NULL,
  `Description` text NOT NULL,
  `PerformedBy` int(11) NOT NULL,
  `DateAdded` datetime NOT NULL,
  `DateModified` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

INSERT INTO roles VALUES("1","Admin","","0","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO roles VALUES("2","Driver","","0","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO roles VALUES("3","Shop","","0","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO roles VALUES("4","Customer","","0","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO roles VALUES("5","Sales","","0","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO roles VALUES("6","Plant","","0","0000-00-00 00:00:00","0000-00-00 00:00:00");



DROP TABLE IF EXISTS sale_details;

CREATE TABLE `sale_details` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SaleID` int(11) NOT NULL,
  `CylinderID` int(11) NOT NULL,
  `TierWeight` float NOT NULL,
  `ShopTotalWeight` float NOT NULL,
  `TotalWeight` float NOT NULL,
  `Price` float NOT NULL,
  `GasRate` float NOT NULL,
  `ReturnStatus` int(11) NOT NULL,
  `ReturnWeight` float NOT NULL,
  `ReturnDate` datetime NOT NULL,
  `PerformedBy` int(11) NOT NULL,
  `DateAdded` datetime NOT NULL,
  `DateModified` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

INSERT INTO sale_details VALUES("1","1","1","11.8","0","40","4230","150","1","13","2019-03-05 14:15:04","222","2019-03-05 13:53:46","2019-03-05 13:53:46");
INSERT INTO sale_details VALUES("2","2","3","45","0","99","8100","150","1","48","2019-03-05 14:26:14","222","2019-03-05 13:59:56","2019-03-05 13:59:56");
INSERT INTO sale_details VALUES("3","3","2","11.8","45","40","4230","150","0","0","1970-01-01 00:00:00","222","2019-01-26 04:10:05","2019-01-26 04:10:05");
INSERT INTO sale_details VALUES("4","3","3","45","99","99","8100","150","1","45","2019-01-26 10:30:29","222","2019-01-26 04:10:05","2019-01-26 04:10:05");
INSERT INTO sale_details VALUES("5","4","1","11.8","40","40","3948","140","1","13","2019-01-26 10:30:29","222","2019-01-26 10:16:03","2019-01-26 10:16:03");
INSERT INTO sale_details VALUES("6","4","4","11.8","26.8","26.8","2250","150","1","12","2019-01-26 10:31:08","222","2019-01-26 10:16:03","2019-01-26 10:16:03");
INSERT INTO sale_details VALUES("7","5","1","11.8","40","40","4230","150","0","0","1970-01-01 00:00:00","222","2019-01-26 10:31:53","2019-01-26 10:31:53");
INSERT INTO sale_details VALUES("8","6","3","45","99","99","1000","18.5185","0","0","1970-01-01 00:00:00","222","2019-01-26 03:21:48","2019-01-26 03:21:48");
INSERT INTO sale_details VALUES("9","7","6","8.5","14.5","14.5","640","106.667","1","8.5","2019-01-26 05:40:05","222","2019-01-26 05:36:05","2019-01-26 05:36:05");
INSERT INTO sale_details VALUES("10","7","7","14.1","25.9","25.9","1250","105.932","1","14.1","2019-01-26 05:40:05","222","2019-01-26 05:36:05","2019-01-26 05:36:05");
INSERT INTO sale_details VALUES("11","7","9","42.2","87.6","87.6","4800.01","105.727","1","47.2","2019-01-26 05:40:05","222","2019-01-26 05:36:05","2019-01-26 05:36:05");
INSERT INTO sale_details VALUES("12","8","8","14.2","26","26","1250","105.932","0","0","1970-01-01 00:00:00","222","2019-01-26 05:42:46","2019-01-26 05:42:46");
INSERT INTO sale_details VALUES("13","8","10","42.1","87.5","87.5","4800.01","105.727","0","0","1970-01-01 00:00:00","222","2019-01-26 05:42:46","2019-01-26 05:42:46");
INSERT INTO sale_details VALUES("14","9","7","14.1","25.9","25.9","1250","105.932","1","14.2","2019-01-26 05:53:57","222","2019-01-26 05:51:17","2019-01-26 05:51:17");
INSERT INTO sale_details VALUES("15","10","7","14.1","25.9","25.9","1250","105.932","0","0","1970-01-01 00:00:00","222","2019-01-26 05:55:41","2019-01-26 05:55:41");



DROP TABLE IF EXISTS sales;

CREATE TABLE `sales` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ShopID` int(11) NOT NULL,
  `CustomerID` int(11) NOT NULL,
  `GasRate` float NOT NULL,
  `Total` float NOT NULL,
  `Balance` float NOT NULL,
  `Paid` float NOT NULL,
  `Unpaid` float NOT NULL,
  `Note` text NOT NULL,
  `PerformedBy` int(11) NOT NULL,
  `DateAdded` datetime NOT NULL,
  `DateModified` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

INSERT INTO sales VALUES("1","222","284","150","4230","0","1000","3230","","222","2019-03-05 13:53:46","2019-03-05 13:53:46");
INSERT INTO sales VALUES("2","222","284","150","8100","0","8100","0","","222","2019-03-05 13:59:56","2019-01-26 12:25:47");
INSERT INTO sales VALUES("3","222","223","150","12330","0","12330","0","","222","2019-01-26 04:10:05","2019-01-26 04:10:05");
INSERT INTO sales VALUES("4","222","284","143.472","6198","5.4","5423.25","-0.000000000000909495","","222","2019-01-26 10:16:03","2019-01-26 10:16:03");
INSERT INTO sales VALUES("5","222","284","150","4230","2","3930","0","","222","2019-01-26 10:31:53","2019-01-26 10:31:53");
INSERT INTO sales VALUES("6","222","244","100","1000","0","0","1000","","222","2019-01-26 03:21:48","2019-01-26 03:21:48");
INSERT INTO sales VALUES("7","222","229","105.855","6690.01","0","6690","0.01","","222","2019-01-26 05:36:05","2019-01-26 05:36:05");
INSERT INTO sales VALUES("8","222","229","105.769","6050.01","5","5521","0.162972","","222","2019-01-26 05:42:46","2019-01-26 05:42:46");
INSERT INTO sales VALUES("9","222","223","105.932","1250","0","1250","0","","222","2019-01-26 05:51:17","2019-01-26 05:51:17");
INSERT INTO sales VALUES("10","222","223","105.932","1250","0.1","1239","0.40678","","222","2019-01-26 05:55:41","2019-01-26 05:55:41");



DROP TABLE IF EXISTS sales_amount;

CREATE TABLE `sales_amount` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SaleID` int(11) NOT NULL,
  `Paid` float NOT NULL,
  `Unpaid` float NOT NULL,
  `PerformedBy` int(11) NOT NULL,
  `Note` text NOT NULL,
  `DateAdded` datetime NOT NULL,
  `DateModified` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

INSERT INTO sales_amount VALUES("1","1","1000","3230","222","","2019-03-05 13:53:46","2019-03-05 13:53:46");
INSERT INTO sales_amount VALUES("2","2","6500","1600","222","","2019-03-05 13:59:56","2019-03-05 13:59:56");
INSERT INTO sales_amount VALUES("3","3","12330","0","222","","2019-01-26 04:10:05","2019-01-26 04:10:05");
INSERT INTO sales_amount VALUES("4","4","5423.25","-35.25","222","","2019-01-26 10:16:03","2019-01-26 10:16:03");
INSERT INTO sales_amount VALUES("5","5","3930","0","222","","2019-01-26 10:31:53","2019-01-26 10:31:53");
INSERT INTO sales_amount VALUES("6","2","1600","0","222","","2019-01-26 12:25:47","2019-01-26 12:25:47");
INSERT INTO sales_amount VALUES("7","6","0","1000","222","","2019-01-26 03:21:48","2019-01-26 03:21:48");
INSERT INTO sales_amount VALUES("8","7","6690","0.01","222","","2019-01-26 05:36:05","2019-01-26 05:36:05");
INSERT INTO sales_amount VALUES("9","8","5521","0.162972","222","","2019-01-26 05:42:46","2019-01-26 05:42:46");
INSERT INTO sales_amount VALUES("10","9","1250","0","222","","2019-01-26 05:51:17","2019-01-26 05:51:17");
INSERT INTO sales_amount VALUES("11","10","1239","0.40678","222","","2019-01-26 05:55:41","2019-01-26 05:55:41");



DROP TABLE IF EXISTS users;

CREATE TABLE `users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Username` text NOT NULL,
  `Password` text NOT NULL,
  `RoleID` int(11) NOT NULL,
  `Image` text NOT NULL,
  `Name` text NOT NULL,
  `Number` text NOT NULL,
  `Email` text NOT NULL,
  `Address` text NOT NULL,
  `Commercial` int(11) NOT NULL,
  `Balance` float NOT NULL,
  `Credit` float NOT NULL,
  `ShopID` int(11) NOT NULL,
  `PlantID` int(11) NOT NULL,
  `CreditLimit` float NOT NULL,
  `SendSMS` int(11) NOT NULL,
  `Remarks` text NOT NULL,
  `SecurityDeposite` float NOT NULL,
  `Status` int(11) NOT NULL,
  `PerformedBy` int(11) NOT NULL,
  `LastLogin` datetime NOT NULL,
  `LastActivity` datetime NOT NULL,
  `DateModified` datetime NOT NULL,
  `DateAdded` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=286 DEFAULT CHARSET=latin1;

INSERT INTO users VALUES("1","admin","admin","1","","","","","","0","892.4","0","0","0","0","0","","0","1","0","2019-01-26 12:57:34","2019-01-26 12:31:53","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO users VALUES("216","SG-Plant","123","6","","SGD Plant","03219292414","sgd@sgd.com","Hyd","0","0","0","0","0","0","1","","0","1","1","2019-01-26 12:55:48","2019-01-26 04:42:12","0000-00-00 00:00:00","2019-03-05 11:02:41");
INSERT INTO users VALUES("220","sg-driver1","1234","2","","Muhammad Hashim","03219292414","sgd@sgd.com","Driver - Hyd","0","0","0","0","216","0","1","","0","1","216","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 13:17:37");
INSERT INTO users VALUES("222","sg-shop","789","3","","SGD Shop-1","03123786999","sgd@sgd.com","HYD","0","0","700","0","216","0","1","","0","1","216","2019-01-26 05:52:56","2019-01-26 05:55:44","2019-01-26 12:26:28","2019-03-05 05:47:29");
INSERT INTO users VALUES("223","1553864141","QNE31573294113PXW1VTDE1553864141U6FG","4","","MUHAMMAD MEMON","03008372243","","MARHABA CITY","1","0.00000000149012","0","222","216","1000","0","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-01-26 05:49:58");
INSERT INTO users VALUES("224","1551790122","TE6C1486660262SOBACDLT15517901226J2C","4","","ARBAR ALI","03153696718","","BY PASS","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 06:48:42");
INSERT INTO users VALUES("225","1551790190","LKKK730367846EGHJTZGR1551790190L63D","4","","DOST ALI","03003355428","","ISRA UNIVERSITY","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 06:49:50");
INSERT INTO users VALUES("226","1551790432","H5QO1651692218300WVTM21551790432BZ3I","4","","ASIF GUJJAR","03060546694","","BY PASS","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 06:53:52");
INSERT INTO users VALUES("227","1551790502","EWIW2085304703F24GNWCK1551790502WG6L","4","","MUHAMMAD ZAMAN","03133102145","","MATYARI","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 06:55:02");
INSERT INTO users VALUES("228","1551790551","HBDT5022913046A0NWWSJ1551790551MLH4","4","","MUHAMMAD SHAFIQUE","03332706084","","HALLA NAKA","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 06:55:51");
INSERT INTO users VALUES("229","1553863366","5N2E91538094X6ATGTVL1553863366OJFK","4","","AJEEB UR REHMAN","03023043277","","BY PASS","1","0","0","222","216","1000","0","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-01-26 05:27:59");
INSERT INTO users VALUES("230","1551790691","XPA42084683250Z2T0DJWD1551790691GIWE","4","","ZAIN UL ABIDEEN","03133449943","","ZAFFAR HOUSING SCHEME","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 06:58:11");
INSERT INTO users VALUES("231","1551790770","WR2W18347880124JNPRLE515517907704HWZ","4","","SRI CHAND","03013849322","","QASIMABAD","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 06:59:30");
INSERT INTO users VALUES("232","1551790820","5XCU2078482041KU1I2ERT1551790820I2IR","4","","SAJJID","03111383286","","BANGLA SHAM SING","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 07:00:20");
INSERT INTO users VALUES("233","1551790872","0WKK2018152388Q06SUTCG1551790872ITWI","4","","GULAM RABANI","03133850385","","SAIMA PLAZA","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 07:01:12");
INSERT INTO users VALUES("234","1551790936","KCZ62043553138I5H1H0RN1551790936GNTO","4","","FIDDA HUSAIN","03122572305","","QASIMABAD","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 07:02:16");
INSERT INTO users VALUES("235","1551791015","T1RD1319013994SWOT5U4V1551791015CCEX","4","","MUHAMMAD FAROOQUE","03033538953","","NEW HYDERABAD CITY","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 07:03:35");
INSERT INTO users VALUES("236","1551791074","NGLP1153752786XHU1BCUU15517910744R5B","4","","SYED ULLAH","03452444469","","ISRA VILLAGE","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 07:04:34");
INSERT INTO users VALUES("237","1551791386","I4X6144175502042FWVIQM15517913860DZV","4","","GULZAR","03433205225","","KHYBER WAZIRISTAN","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 07:09:46");
INSERT INTO users VALUES("238","1551791461","P2WG1172766279VMASK1NH1551791461C5TS","4","","HAMZA RESTURANT","03013628519","","ISRA UNIVERSITY","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 07:11:01");
INSERT INTO users VALUES("239","1551791675","4EFM11016902113UE0EUW51551791675NGWW","4","","MUSTAQUE ABRO","03003422161","","ISRA HOSPITAL","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 07:14:35");
INSERT INTO users VALUES("240","1551791738","DSUK1372678133HLLMMK3C1551791738JGIG","4","","SAMEER COTTON FACTORY","03343225434","","ANDHERI MORI","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 07:15:38");
INSERT INTO users VALUES("241","1551791791","IFCH1727029327BDAQCAO315517917913BVD","4","","DAWOOD BILAL TRAVELS ","03454991237","","BY PASS","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 07:16:31");
INSERT INTO users VALUES("242","1551791865","50I61509721063GH33LSUF1551791865OINO","4","","ROSHAN","03013343935","","ISRA UNIVERSITY AL NOOR","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 07:17:45");
INSERT INTO users VALUES("243","1551791931","IJWP318551964FZDGM1JM155179193122DZ","4","","ASGHAR SHAH","03059835818","","ISRA UNIVERSITY","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 07:18:51");
INSERT INTO users VALUES("244","1553638908","AE551691990848WRKD0L3G1553638908IV3N","4","","PREMIUM OIL","03463072357","","KOTRI","1","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-01-26 03:21:23");
INSERT INTO users VALUES("245","1551792046","WFJD8473219845353UZG1551792046IWUJ","4","","MUHAMMAD PUNNAL","03123569541","","MARHABA COLONY","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 07:20:46");
INSERT INTO users VALUES("246","1551792106","PPKS964546372HIQUUKML15517921063QZU","4","","RAJAB ALI","03013513680","","MATYARI","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 07:21:46");
INSERT INTO users VALUES("247","1551792187","XIRW1143424318FKXSWIDI15517921870LWF","4","","GENTLE MAN","03438303508","","BY PASS","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 07:23:07");
INSERT INTO users VALUES("248","1551792248","ZCAT1688366033BJZELUR51551792248D0F1","4","","HASNAIN RAZA","03027888207","","QASIM GHAROO","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 07:24:08");
INSERT INTO users VALUES("249","1551792318","SFCT898349298I5ICCLJB1551792318RWFB","4","","ZAHEER","03023003909","","ISRA UNIVERSITY","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 07:25:18");
INSERT INTO users VALUES("250","1551792392","3UZB817261835QF21XMVI1551792392ETR2","4","","ASIF SHEHZAD","03013564827","","LATEEF SHAH MORI","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 07:26:32");
INSERT INTO users VALUES("251","1551792485","0PNZ13492456344E0U3Q201551792485BHUK","4","","TAJ DAR -E- MADINA HOTEL","03003793565","","BY PASS","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 07:28:05");
INSERT INTO users VALUES("252","1551792563","RIGA12410259996XRBTZI31551792563GOR6","4","","JABIR","03043037273","","TANDO MUHAMMAD KHAN","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 07:29:23");
INSERT INTO users VALUES("253","1551792626","ERMB1908401367LWQGK6MP15517926261Q2V","4","","AHMED MAQBOOL","03333543375","","MARHABA CITY","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 07:30:26");
INSERT INTO users VALUES("254","1551793583","AGUF1803643138HIKSUAEI15517935830QOF","4","","GULAM NABBI","03063041895","","NEW HYDERABAD CITY","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 07:46:23");
INSERT INTO users VALUES("255","1551793825","3C4R1564957711FFM2M2U01551793825DNU3","4","","KHALID","03455155451","","MASOO","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 07:50:25");
INSERT INTO users VALUES("256","1551793909","XAQM21328638686GI2Z4I315517939093WQN","4","","MUHAMMAD MUBEEN","03063545932","","NEW HYDERABAD CITY","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 07:51:49");
INSERT INTO users VALUES("257","1551793986","3CA51489404226WLDIREMJ1551793986J4IP","4","","SINDH AGRO","03322886468","","BY PASS","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 07:53:06");
INSERT INTO users VALUES("258","1551794038","SXKN1485096034LWZ4ETSV1551794038ORQZ","4","","MAROOF","03123142773","","BY PASS","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 07:53:58");
INSERT INTO users VALUES("259","1551794081","JE5N42027961IOUHB6RJ15517940812HVW","4","","AMJAD ALI","03063508348","","BY PASS","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 07:54:41");
INSERT INTO users VALUES("260","1551794142","XIVC1988598947N13ICGIZ155179414264ME","4","","SHABEER AHMED","03033003097","","BY PASS","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 07:55:42");
INSERT INTO users VALUES("261","1551794211","FEAS189508634OF0MTK5P1551794211TLNV","4","","DANISH","03343171509","","MUHAMMAD BUX","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 07:56:51");
INSERT INTO users VALUES("262","1551794277","6M1S1261547582XGHSBT421551794277UZCZ","4","","ISLAMIA PAKWAN CENTER","03113085204","","KALI MORI AKEEL PLAZA","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 07:57:57");
INSERT INTO users VALUES("263","1551794327","JCPH337275115WMQM204P1551794327B3CB","4","","NOOR AHMED","03353134073","","ISRA UNIVERSITY","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 07:58:47");
INSERT INTO users VALUES("264","1551794386","EHJS233584061LS1ENVEF1551794386ZXBW","4","","MUHAMMAD USMAN ","030131522767","","DUBAI CITY","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 07:59:46");
INSERT INTO users VALUES("265","1551794482","POX01729282412SQKVVNKX1551794482S5HW","4","","BUSINESS AND GENTLE MAN","03360397857","","BY PASS","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 08:01:22");
INSERT INTO users VALUES("266","1551794536","RSRA7007732985XBWSOLR15517945365WO0","4","","MATEEULLAH","03136549699","","TANDO JAM","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 08:02:16");
INSERT INTO users VALUES("267","1551794591","NA3A973063660V4IMJBC31551794591MFHG","4","","AMEER BUX","03178951431","","ISRA VILLAGE","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 08:03:11");
INSERT INTO users VALUES("268","1551794637","RUNF1882890896M036SSUX1551794637DNBX","4","","THE INDUS","03452097696","","BY PASS","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 08:03:57");
INSERT INTO users VALUES("269","1551794682","UCXG2094704827DDHZQWWS1551794682AWE5","4","","SHEHZAD","03013525524","","HIGHWAY","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 08:04:42");
INSERT INTO users VALUES("270","1551794730","SLXP1715984505SQ3QS3RJ15517947306FXQ","4","","IRSHAD ALI","03028933280","","BY PASS","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 08:05:30");
INSERT INTO users VALUES("271","1551794838","QBBU533686567MMEZ25CL15517948385RPF","4","","WASEEM SHAH","03023040742","","BY PASS","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 08:07:18");
INSERT INTO users VALUES("272","1551794905","U4OG380027888SSWS1L3J1551794905QJ6P","4","","AKHTAR MUHAMMAD","03070134376","","HALLA NAKA","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 08:08:25");
INSERT INTO users VALUES("273","1551794946","U1IH1950661345FFMUE5LF1551794946GP0D","4","","RIZWAN SHOES","03003036735","","BY PASS","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 08:09:06");
INSERT INTO users VALUES("274","1551795040","OPWH434090645IA3NVWBV1551795040MUNT","4","","NASIR BHATTI","03003038185","","BY PASS","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 08:10:40");
INSERT INTO users VALUES("275","1551795110","WWBW1279167120D15W3FCJ1551795110CPGH","4","","MUHAMMAD ALI","03063253020","","MEHHAR","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 08:11:50");
INSERT INTO users VALUES("276","1551795166","OAWD233380792ORJAJ2E11551795166RKDL","4","","M. YAQOOB JISKANI","03023255194","","MARHABA CITY","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 08:12:46");
INSERT INTO users VALUES("277","1551795266","SM4U1838268486SQCOBBCC1551795266MZF1","4","","ADEEL","03332381901","","ISRA VILLAGE","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 08:14:26");
INSERT INTO users VALUES("278","1551795332","GWUL20392614600RRHI0KA1551795332J4L5","4","","ABDUL RAZZAQUE","03163391668","","BY PASS","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 08:15:32");
INSERT INTO users VALUES("279","1551795378","5MZG371945650VHKB2ZQ61551795378GDWL","4","","ABDUL HAKEEM","03003015171","","MARHABA CITY","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 08:16:18");
INSERT INTO users VALUES("280","1551795457","ET0G11677130631VUHZWZK15517954570T1J","4","","SHAHMEER","03003056056","","MATYARI","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 08:17:37");
INSERT INTO users VALUES("281","1551795718","ZPT0460375246Z0QXFQFT1551795718CQCC","4","","ALI GULL","03045644921","","HAJI UMER PALARI","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 08:21:58");
INSERT INTO users VALUES("282","1551795788","03V41994790434L5F3F04X15517957883EVK","4","","GRAND NASEEM PETROLIUM SERVICE","03349898602","","CHANDAN MORI TOTAL PUMP","0","0","0","222","216","1000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 08:23:08");
INSERT INTO users VALUES("284","1553016713","W33I316506006GMSC6HOK1553016713SXTT","4","","test client","03082699249","sgd@sgd.com","","0","0.000000238419","0","222","216","5000","1","","0","1","222","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-03-05 11:10:26");
INSERT INTO users VALUES("285","testing","123","6","","testing","2312312322","","","0","0","0","0","285","0","1","","0","1","1","0000-00-00 00:00:00","0000-00-00 00:00:00","0000-00-00 00:00:00","2019-01-26 00:00:00");



DROP TABLE IF EXISTS vehicles;

CREATE TABLE `vehicles` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` text COLLATE utf8_unicode_ci NOT NULL,
  `RegistrationNo` text COLLATE utf8_unicode_ci NOT NULL,
  `Details` text COLLATE utf8_unicode_ci NOT NULL,
  `PlantID` int(11) NOT NULL,
  `PerformedBy` int(11) NOT NULL,
  `DateAdded` datetime NOT NULL,
  `DateModified` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO vehicles VALUES("1","Rickshaw","123","Super Star","216","216","2019-03-05 11:06:37","2019-03-05 11:06:37");



