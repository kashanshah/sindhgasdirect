DROP TABLE IF EXISTS admins;

CREATE TABLE `admins` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `RoleID` int(11) NOT NULL,
  `UserName` varchar(15) NOT NULL,
  `Password` text NOT NULL,
  `Email` text NOT NULL,
  `Image` text NOT NULL,
  `Name` varchar(50) NOT NULL,
  `FatherName` varchar(50) NOT NULL,
  `NIC` varchar(13) NOT NULL,
  `Number` varchar(50) NOT NULL,
  `Address` varchar(200) NOT NULL,
  `City` varchar(50) NOT NULL,
  `Country` varchar(50) NOT NULL,
  `DOB` datetime NOT NULL,
  `BirthPlace` varchar(30) NOT NULL,
  `Gender` varchar(6) NOT NULL,
  `Religion` varchar(50) NOT NULL,
  `AdmissionDate` datetime NOT NULL,
  `Status` tinyint(4) NOT NULL,
  `Remarks` text NOT NULL,
  `PerformedBy` int(11) NOT NULL,
  `DateModified` datetime NOT NULL,
  `DateAdded` datetime NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `UserName` (`UserName`)
) ENGINE=InnoDB AUTO_INCREMENT=276 DEFAULT CHARSET=latin1;

INSERT INTO admins VALUES("265","1","admin","admin","kashan@kashan.com","S265.jpg","Admin","Admin","Admin","03082699249","North Karachi","Karachi","Pakistan","2015-12-31 00:00:00","Karachi","Male","Islam","2015-10-16 21:33:45","1","Done","0","2015-10-16 21:33:45","2015-10-13 22:04:44");
INSERT INTO admins VALUES("274","2","manager","123","","","Manager","","","","","","","0000-00-00 00:00:00","","0","","2016-11-03 10:25:14","1","","265","0000-00-00 00:00:00","2016-11-03 10:25:14");
INSERT INTO admins VALUES("275","3","salesman","123","","","Salesman","","","","","","","0000-00-00 00:00:00","","0","","2016-11-03 10:25:33","1","","265","0000-00-00 00:00:00","2016-11-03 10:25:33");



DROP TABLE IF EXISTS categories;

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` text NOT NULL,
  `Description` text NOT NULL,
  `PerformedBy` int(11) NOT NULL,
  `DateAdded` datetime NOT NULL,
  `DateModified` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

INSERT INTO categories VALUES("1","Grossery","","0","2016-11-03 11:11:09","0000-00-00 00:00:00");
INSERT INTO categories VALUES("2","Biscuits","","0","2016-11-03 11:13:45","0000-00-00 00:00:00");
INSERT INTO categories VALUES("3","Paparr","","0","2016-11-03 11:14:08","0000-00-00 00:00:00");
INSERT INTO categories VALUES("4","Chips","","0","2016-11-03 11:14:15","0000-00-00 00:00:00");
INSERT INTO categories VALUES("5","Soft Drinks","","0","2016-11-03 11:14:20","0000-00-00 00:00:00");
INSERT INTO categories VALUES("6","Chocolates","","0","2016-11-03 11:18:24","0000-00-00 00:00:00");
INSERT INTO categories VALUES("7","Jelly","","0","2016-11-03 11:18:39","0000-00-00 00:00:00");
INSERT INTO categories VALUES("8","Juices","","0","2016-11-03 11:18:45","0000-00-00 00:00:00");
INSERT INTO categories VALUES("9","Cosmetics","","0","2016-11-03 11:19:29","0000-00-00 00:00:00");



DROP TABLE IF EXISTS configurations;

CREATE TABLE `configurations` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `FullName` varchar(50) DEFAULT NULL,
  `CompanyName` varchar(100) DEFAULT NULL,
  `SiteTitle` varchar(255) DEFAULT NULL,
  `Domain` varchar(255) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Email` varchar(150) DEFAULT NULL,
  `DropboxEmail` text NOT NULL,
  `AlertReceiver` varchar(255) DEFAULT '',
  `SMTPHost` varchar(255) DEFAULT '',
  `SMTPUser` varchar(255) DEFAULT '',
  `SMTPPassword` varchar(20) DEFAULT '',
  `Number` varchar(20) DEFAULT NULL,
  `FaxNumber` varchar(20) DEFAULT NULL,
  `Password` varchar(15) DEFAULT NULL,
  `Logo` text NOT NULL,
  `SMSUserName` text NOT NULL,
  `SMSPassword` text NOT NULL,
  `CaptchaVerification` int(11) NOT NULL DEFAULT '1',
  `BarCodeLength` int(11) NOT NULL DEFAULT '4',
  `DateModified` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO configurations VALUES("1","Point of Sales","Cloud Innovators Solution","POS","pos","DHA Phase VIII,\r\nKarachi","info@cloud-innovator.com","","","","","","03082699249","","","logo.jpg","","","0","12","2016-11-07 11:39:01");



DROP TABLE IF EXISTS events;

CREATE TABLE `events` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Title` text NOT NULL,
  `StartDate` datetime NOT NULL,
  `EndDate` datetime NOT NULL,
  `Details` text NOT NULL,
  `DateAdded` datetime NOT NULL,
  `DateModified` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS mails;

CREATE TABLE `mails` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SentFrom` text NOT NULL,
  `SentTo` text NOT NULL,
  `Subject` text NOT NULL,
  `Body` text NOT NULL,
  `Readed` tinyint(4) NOT NULL,
  `DateAdded` datetime NOT NULL,
  `SentBy` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS products;

CREATE TABLE `products` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `BarCode` text NOT NULL,
  `Name` text NOT NULL,
  `CategoryID` int(11) NOT NULL,
  `ShortDescription` text NOT NULL,
  `Description` text NOT NULL,
  `WholePrice` float NOT NULL,
  `RetailPrice` float NOT NULL,
  `Stock` int(11) NOT NULL,
  `Image` text NOT NULL,
  `PerformedBy` int(11) NOT NULL,
  `DateAdded` datetime NOT NULL,
  `DateModified` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

INSERT INTO products VALUES("1","PEPSI","Pepsi 250ml","5","","","21","25","54","","265","2016-11-07 17:32:16","2016-11-07 17:32:16");
INSERT INTO products VALUES("2","FANTA","Fanta 25ml","5","","","20","25","-17","","265","2016-11-07 17:32:19","2016-11-07 17:32:19");
INSERT INTO products VALUES("3","COKE","Coca cola","5","","","20","25","-4","","265","2016-11-07 17:36:58","2016-11-07 17:36:58");
INSERT INTO products VALUES("4","SPRITE","Sprite 250ml","5","","","20","25","-6","","265","2016-11-07 17:32:29","2016-11-07 17:32:29");
INSERT INTO products VALUES("5","7UPSD","7up 250ml","5","","","20","25","-2","","265","2016-11-07 17:32:09","2016-11-07 17:32:09");



DROP TABLE IF EXISTS purchases;

CREATE TABLE `purchases` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ProductID` int(11) NOT NULL,
  `SupplierID` int(11) NOT NULL,
  `Price` float NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Discount` float NOT NULL,
  `Total` float NOT NULL,
  `Paid` float NOT NULL,
  `Unpaid` float NOT NULL,
  `RefNum` text NOT NULL,
  `Note` text NOT NULL,
  `PerformedBy` int(11) NOT NULL,
  `DateAdded` datetime NOT NULL,
  `DateModified` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO purchases VALUES("1","1","1","21","100","0","2100","2100","0","OHBN10IGS,0XK014KFJ","","265","2016-11-03 11:59:58","2016-11-03 12:00:34");
INSERT INTO purchases VALUES("2","1","1","21","10","0","210","160","50","0V3L2PH4U,60WD2XK0K,JT1W2UONR","","265","2016-11-03 16:39:58","2016-11-03 16:42:50");



DROP TABLE IF EXISTS roles;

CREATE TABLE `roles` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` text NOT NULL,
  `Description` text NOT NULL,
  `PerformedBy` int(11) NOT NULL,
  `DateAdded` datetime NOT NULL,
  `DateModified` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO roles VALUES("1","Admin","","0","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO roles VALUES("2","Manager","","0","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO roles VALUES("3","Salesman","","0","0000-00-00 00:00:00","0000-00-00 00:00:00");



DROP TABLE IF EXISTS sales;

CREATE TABLE `sales` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CustomerID` int(11) NOT NULL,
  `Total` float NOT NULL,
  `Discount` float NOT NULL,
  `Paid` float NOT NULL,
  `Unpaid` float NOT NULL,
  `Note` text NOT NULL,
  `PerformedBy` int(11) NOT NULL,
  `DateAdded` datetime NOT NULL,
  `DateModified` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

INSERT INTO sales VALUES("1","2","300","0","300","0","","265","2016-11-03 12:03:12","0000-00-00 00:00:00");
INSERT INTO sales VALUES("2","3","300","0","300","0","","265","2016-11-03 12:07:31","0000-00-00 00:00:00");
INSERT INTO sales VALUES("3","4","300","0","300","0","","265","2016-11-03 12:07:37","0000-00-00 00:00:00");
INSERT INTO sales VALUES("4","5","100","20","60","20","","265","2016-11-03 12:23:23","0000-00-00 00:00:00");
INSERT INTO sales VALUES("5","6","50","4","46","0","","275","2016-11-05 13:01:11","0000-00-00 00:00:00");
INSERT INTO sales VALUES("6","7","0","0","0","0","","265","2016-11-05 17:48:36","0000-00-00 00:00:00");
INSERT INTO sales VALUES("7","8","0","0","0","0","","265","2016-11-05 17:48:37","0000-00-00 00:00:00");
INSERT INTO sales VALUES("8","9","25","0","0","25","","265","2016-11-05 17:48:47","0000-00-00 00:00:00");
INSERT INTO sales VALUES("9","10","25","0","0","25","","265","2016-11-05 17:50:19","0000-00-00 00:00:00");
INSERT INTO sales VALUES("10","11","200","0","200","0","","265","2016-11-05 17:52:37","0000-00-00 00:00:00");
INSERT INTO sales VALUES("11","12","300","0","300","0","","265","2016-11-05 18:14:38","0000-00-00 00:00:00");
INSERT INTO sales VALUES("12","13","0","0","123","-123","","265","2016-11-05 18:24:48","0000-00-00 00:00:00");
INSERT INTO sales VALUES("13","14","50","0","50","0","","265","2016-11-05 18:29:11","0000-00-00 00:00:00");
INSERT INTO sales VALUES("14","15","25","0","25","0","","265","2016-11-07 11:13:08","0000-00-00 00:00:00");
INSERT INTO sales VALUES("15","16","75","0","100","-25","","265","2016-11-07 11:39:24","0000-00-00 00:00:00");
INSERT INTO sales VALUES("16","17","75","15","60","0","","265","2016-11-07 13:39:42","0000-00-00 00:00:00");
INSERT INTO sales VALUES("17","18","50","10","40","0","","265","2016-11-07 13:40:08","0000-00-00 00:00:00");
INSERT INTO sales VALUES("18","19","400","50","400","-50","","265","2016-11-07 17:16:58","0000-00-00 00:00:00");
INSERT INTO sales VALUES("19","20","50","0","50","0","","265","2016-11-07 17:17:15","0000-00-00 00:00:00");
INSERT INTO sales VALUES("20","21","200","0","250","-50","","265","2016-11-07 17:17:53","0000-00-00 00:00:00");
INSERT INTO sales VALUES("21","22","250","10","250","-10","","274","2016-11-07 17:38:43","0000-00-00 00:00:00");



DROP TABLE IF EXISTS sales_amount;

CREATE TABLE `sales_amount` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SaleID` int(11) NOT NULL,
  `Paid` float NOT NULL,
  `PerformedBy` int(11) NOT NULL,
  `DateAdded` datetime NOT NULL,
  `DateModified` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

INSERT INTO sales_amount VALUES("1","1","300","265","2016-11-03 12:03:12","0000-00-00 00:00:00");
INSERT INTO sales_amount VALUES("2","2","300","265","2016-11-03 12:07:31","0000-00-00 00:00:00");
INSERT INTO sales_amount VALUES("3","3","300","265","2016-11-03 12:07:37","0000-00-00 00:00:00");
INSERT INTO sales_amount VALUES("4","4","60","265","2016-11-03 12:23:23","0000-00-00 00:00:00");
INSERT INTO sales_amount VALUES("5","5","46","275","2016-11-05 13:01:11","0000-00-00 00:00:00");
INSERT INTO sales_amount VALUES("6","6","0","265","2016-11-05 17:48:36","0000-00-00 00:00:00");
INSERT INTO sales_amount VALUES("7","7","0","265","2016-11-05 17:48:37","0000-00-00 00:00:00");
INSERT INTO sales_amount VALUES("8","8","0","265","2016-11-05 17:48:47","0000-00-00 00:00:00");
INSERT INTO sales_amount VALUES("9","9","0","265","2016-11-05 17:50:19","0000-00-00 00:00:00");
INSERT INTO sales_amount VALUES("10","10","200","265","2016-11-05 17:52:37","0000-00-00 00:00:00");
INSERT INTO sales_amount VALUES("11","11","300","265","2016-11-05 18:14:38","0000-00-00 00:00:00");
INSERT INTO sales_amount VALUES("12","12","123","265","2016-11-05 18:24:48","0000-00-00 00:00:00");
INSERT INTO sales_amount VALUES("13","13","50","265","2016-11-05 18:29:11","0000-00-00 00:00:00");
INSERT INTO sales_amount VALUES("14","14","25","265","2016-11-07 11:13:08","0000-00-00 00:00:00");
INSERT INTO sales_amount VALUES("15","15","100","265","2016-11-07 11:39:24","0000-00-00 00:00:00");
INSERT INTO sales_amount VALUES("16","16","60","265","2016-11-07 13:39:42","0000-00-00 00:00:00");
INSERT INTO sales_amount VALUES("17","17","40","265","2016-11-07 13:40:08","0000-00-00 00:00:00");
INSERT INTO sales_amount VALUES("18","18","400","265","2016-11-07 17:16:59","0000-00-00 00:00:00");
INSERT INTO sales_amount VALUES("19","19","50","265","2016-11-07 17:17:15","0000-00-00 00:00:00");
INSERT INTO sales_amount VALUES("20","20","250","265","2016-11-07 17:17:53","0000-00-00 00:00:00");
INSERT INTO sales_amount VALUES("21","21","250","274","2016-11-07 17:38:43","0000-00-00 00:00:00");



DROP TABLE IF EXISTS sales_details;

CREATE TABLE `sales_details` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SaleID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Price` float NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Discount` float NOT NULL,
  `Total` float NOT NULL,
  `PerformedBy` int(11) NOT NULL,
  `DateAdded` datetime NOT NULL,
  `DateModified` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

INSERT INTO sales_details VALUES("1","1","1","25","10","0","250","265","2016-11-03 12:03:12","0000-00-00 00:00:00");
INSERT INTO sales_details VALUES("2","1","2","25","2","0","50","265","2016-11-03 12:03:13","0000-00-00 00:00:00");
INSERT INTO sales_details VALUES("3","2","1","25","10","0","250","265","2016-11-03 12:07:31","0000-00-00 00:00:00");
INSERT INTO sales_details VALUES("4","3","1","25","10","0","250","265","2016-11-03 12:07:37","0000-00-00 00:00:00");
INSERT INTO sales_details VALUES("5","3","2","25","2","0","50","265","2016-11-03 12:07:37","0000-00-00 00:00:00");
INSERT INTO sales_details VALUES("6","4","4","25","4","5","100","265","2016-11-03 12:23:23","0000-00-00 00:00:00");
INSERT INTO sales_details VALUES("7","5","1","25","2","2","50","275","2016-11-05 13:01:11","0000-00-00 00:00:00");
INSERT INTO sales_details VALUES("8","6","1","25","0","0","0","265","2016-11-05 17:48:36","0000-00-00 00:00:00");
INSERT INTO sales_details VALUES("9","7","1","25","0","0","0","265","2016-11-05 17:48:37","0000-00-00 00:00:00");
INSERT INTO sales_details VALUES("10","8","1","25","1","0","25","265","2016-11-05 17:48:47","0000-00-00 00:00:00");
INSERT INTO sales_details VALUES("11","9","1","25","1","0","25","265","2016-11-05 17:50:19","0000-00-00 00:00:00");
INSERT INTO sales_details VALUES("12","10","1","25","6","0","150","265","2016-11-05 17:52:37","0000-00-00 00:00:00");
INSERT INTO sales_details VALUES("13","10","2","25","2","0","50","265","2016-11-05 17:52:37","0000-00-00 00:00:00");
INSERT INTO sales_details VALUES("14","11","1","25","12","0","300","265","2016-11-05 18:14:38","0000-00-00 00:00:00");
INSERT INTO sales_details VALUES("15","13","1","25","2","0","50","265","2016-11-05 18:29:11","0000-00-00 00:00:00");
INSERT INTO sales_details VALUES("16","14","1","25","1","0","25","265","2016-11-07 11:13:08","0000-00-00 00:00:00");
INSERT INTO sales_details VALUES("17","15","1","25","1","0","25","265","2016-11-07 11:39:24","0000-00-00 00:00:00");
INSERT INTO sales_details VALUES("18","15","3","25","2","0","50","265","2016-11-07 11:39:24","0000-00-00 00:00:00");
INSERT INTO sales_details VALUES("19","16","1","25","3","5","75","265","2016-11-07 13:39:42","0000-00-00 00:00:00");
INSERT INTO sales_details VALUES("20","17","1","25","2","5","50","265","2016-11-07 13:40:08","0000-00-00 00:00:00");
INSERT INTO sales_details VALUES("21","18","1","25","10","5","250","265","2016-11-07 17:16:59","0000-00-00 00:00:00");
INSERT INTO sales_details VALUES("22","18","2","25","6","0","150","265","2016-11-07 17:16:59","0000-00-00 00:00:00");
INSERT INTO sales_details VALUES("23","19","1","25","2","0","50","265","2016-11-07 17:17:15","0000-00-00 00:00:00");
INSERT INTO sales_details VALUES("24","20","1","25","1","0","25","265","2016-11-07 17:17:53","0000-00-00 00:00:00");
INSERT INTO sales_details VALUES("25","20","2","25","7","0","175","265","2016-11-07 17:17:53","0000-00-00 00:00:00");
INSERT INTO sales_details VALUES("26","21","2","25","2","1","50","274","2016-11-07 17:38:43","0000-00-00 00:00:00");
INSERT INTO sales_details VALUES("27","21","1","25","2","1","50","274","2016-11-07 17:38:44","0000-00-00 00:00:00");
INSERT INTO sales_details VALUES("28","21","4","25","2","1","50","274","2016-11-07 17:38:44","0000-00-00 00:00:00");
INSERT INTO sales_details VALUES("29","21","3","25","2","1","50","274","2016-11-07 17:38:44","0000-00-00 00:00:00");
INSERT INTO sales_details VALUES("30","21","5","25","2","1","50","274","2016-11-07 17:38:44","0000-00-00 00:00:00");



DROP TABLE IF EXISTS users;

CREATE TABLE `users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Image` text NOT NULL,
  `Name` text NOT NULL,
  `NIC` text NOT NULL,
  `Number` text NOT NULL,
  `Address` text NOT NULL,
  `Email` text NOT NULL,
  `Remarks` text NOT NULL,
  `PerformedBy` int(11) NOT NULL,
  `DateModified` datetime NOT NULL,
  `DateAdded` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

INSERT INTO users VALUES("1","","Muhammad Zeeshan","","","","","","265","2016-11-03 16:39:58","0000-00-00 00:00:00");
INSERT INTO users VALUES("2","","Anonymous","","","","","","265","2016-11-03 12:03:12","0000-00-00 00:00:00");
INSERT INTO users VALUES("3","","Anonymous","","","","","","265","2016-11-03 12:07:30","0000-00-00 00:00:00");
INSERT INTO users VALUES("4","","Anonymous","","","","","","265","2016-11-03 12:07:37","0000-00-00 00:00:00");
INSERT INTO users VALUES("5","","Anonymous","","","","","","265","2016-11-03 12:23:22","0000-00-00 00:00:00");
INSERT INTO users VALUES("6","","Anonymous","","","","","","275","2016-11-05 13:01:10","0000-00-00 00:00:00");
INSERT INTO users VALUES("7","","Anonymous","","","","","","265","2016-11-05 17:48:36","0000-00-00 00:00:00");
INSERT INTO users VALUES("8","","Anonymous","","","","","","265","2016-11-05 17:48:37","0000-00-00 00:00:00");
INSERT INTO users VALUES("9","","Anonymous","","","","","","265","2016-11-05 17:48:47","0000-00-00 00:00:00");
INSERT INTO users VALUES("10","","Anonymous","","","","","","265","2016-11-05 17:50:19","0000-00-00 00:00:00");
INSERT INTO users VALUES("11","","Anonymous","","","","","","265","2016-11-05 17:52:37","0000-00-00 00:00:00");
INSERT INTO users VALUES("12","","Anonymous","","","","","","265","2016-11-05 18:14:38","0000-00-00 00:00:00");
INSERT INTO users VALUES("13","","Anonymous","","","","","","265","2016-11-05 18:24:47","0000-00-00 00:00:00");
INSERT INTO users VALUES("14","","Anonymous","","","","","","265","2016-11-05 18:29:11","0000-00-00 00:00:00");
INSERT INTO users VALUES("15","","Anonymous","","","","","","265","2016-11-07 11:13:08","0000-00-00 00:00:00");
INSERT INTO users VALUES("16","","Anonymous","","","","","","265","2016-11-07 11:39:24","0000-00-00 00:00:00");
INSERT INTO users VALUES("17","","Anonymous","","","","","","265","2016-11-07 13:39:42","0000-00-00 00:00:00");
INSERT INTO users VALUES("18","","Anonymous","","","","","","265","2016-11-07 13:40:08","0000-00-00 00:00:00");
INSERT INTO users VALUES("19","","Anonymous","","","","","","265","2016-11-07 17:16:58","0000-00-00 00:00:00");
INSERT INTO users VALUES("20","","Anonymous","","","","","","265","2016-11-07 17:17:14","0000-00-00 00:00:00");
INSERT INTO users VALUES("21","","Anonymous","","","","","","265","2016-11-07 17:17:53","0000-00-00 00:00:00");
INSERT INTO users VALUES("22","","Anonymous","","","","","","274","2016-11-07 17:38:43","0000-00-00 00:00:00");



