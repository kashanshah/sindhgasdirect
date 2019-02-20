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

INSERT INTO configurations VALUES("1","Sindh Gas Direct","Sindh Gas Direct","Sindh Gas Direct","","Hyderabad","kashanshah@hotmail.com","500","","03082699249","","","","","","shopone","logo.jpg","sindhgas138","11138","0","12","2019-01-14 02:52:52");



DROP TABLE IF EXISTS cylinders;

CREATE TABLE `cylinders` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `BarCode` text NOT NULL,
  `Description` text NOT NULL,
  `ShortDescription` text NOT NULL,
  `TierWeight` float NOT NULL,
  `ManufacturingDate` date NOT NULL,
  `ExpiryDate` date NOT NULL,
  `PerformedBy` int(11) NOT NULL,
  `DateAdded` datetime NOT NULL,
  `DateModified` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

INSERT INTO cylinders VALUES("11","112323","0","assa","32","2018-12-11","2023-12-11","1","2018-12-11 13:06:44","2018-12-16 03:43:06");
INSERT INTO cylinders VALUES("12","22323231","0","assa","12","2018-12-11","2023-12-11","1","2018-12-11 13:08:27","2018-12-16 03:41:44");
INSERT INTO cylinders VALUES("13","131312312","0","asdas","12","2018-12-08","2023-12-08","1","2018-12-11 13:09:39","2018-12-16 03:41:41");
INSERT INTO cylinders VALUES("14","23232","0","asda","22","2018-12-14","2023-12-14","1","2018-12-11 13:57:45","2018-12-16 03:41:52");
INSERT INTO cylinders VALUES("15","1122334455","0\r\n","","13","2018-12-14","2023-12-14","1","2018-12-14 05:37:02","2018-12-31 03:10:46");
INSERT INTO cylinders VALUES("17","16","0asd\r\n","test","12","2017-01-01","2022-01-01","1","2018-12-16 02:45:28","2018-12-31 03:21:18");
INSERT INTO cylinders VALUES("18","18","0\r\n","alksdma","20","2018-12-01","2023-12-01","1","2018-12-16 02:52:05","2018-12-31 02:50:35");
INSERT INTO cylinders VALUES("19","190","0","updated","10","2013-04-04","2018-04-04","1","2018-12-16 02:55:55","2018-12-17 03:14:18");
INSERT INTO cylinders VALUES("22","22","","Shortdesss","10","2018-12-01","2023-12-01","1","2018-12-24 01:36:18","0000-00-00 00:00:00");
INSERT INTO cylinders VALUES("23","23","test fill","test","10","2017-12-31","2022-12-31","1","2018-12-24 01:40:11","0000-00-00 00:00:00");



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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS invoices;

CREATE TABLE `invoices` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `IssuedTo` int(11) NOT NULL,
  `Note` text NOT NULL,
  `PerformedBy` int(11) NOT NULL,
  `DateAdded` datetime NOT NULL,
  `DateModified` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS roles;

CREATE TABLE `roles` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` text NOT NULL,
  `Description` text NOT NULL,
  `PerformedBy` int(11) NOT NULL,
  `DateAdded` datetime NOT NULL,
  `DateModified` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO roles VALUES("1","Admin","","0","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO roles VALUES("2","Salesman","","0","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO roles VALUES("3","Shop","","0","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO roles VALUES("4","Customer","","0","0000-00-00 00:00:00","0000-00-00 00:00:00");



DROP TABLE IF EXISTS sale_details;

CREATE TABLE `sale_details` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SaleID` int(11) NOT NULL,
  `CylinderID` int(11) NOT NULL,
  `TierWeight` float NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




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
  `Balance` float NOT NULL,
  `Remarks` text NOT NULL,
  `Status` int(11) NOT NULL,
  `PerformedBy` int(11) NOT NULL,
  `DateModified` datetime NOT NULL,
  `DateAdded` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;

INSERT INTO users VALUES("1","admin","admin","1","","Admin","03002022020","admin@sindhgas.com","","0","","1","0","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO users VALUES("2","sales","sales","2","","Salesman 1","03002022020","admin@sindhgas.com","","0","","1","1","0000-00-00 00:00:00","2019-01-15 02:29:12");
INSERT INTO users VALUES("3","shop","sho","3","","Shopkeeper 1","03002022020","admin@sindhgas.com","","0","","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO users VALUES("26","sales2","123","3","","Salesman 2","","sales@admin.com","","0","","1","1","0000-00-00 00:00:00","2018-12-17 03:52:48");
INSERT INTO users VALUES("27","sales3","123","2","","Salesman 3","","sales3@asd.com","","0","","1","1","0000-00-00 00:00:00","2018-12-17 03:56:13");
INSERT INTO users VALUES("31","shopone","shopone","3","","Shop One","","shopone@gmail.com","","0","","1","1","0000-00-00 00:00:00","2018-12-24 01:11:10");
INSERT INTO users VALUES("32","shop2","shop2","3","","Shop Two","","","","0","","1","1","0000-00-00 00:00:00","2018-12-31 02:54:45");
INSERT INTO users VALUES("37","1547504495","KWCZ3266863WISME41547504495GMWD","4","","Kashan Shah","03082699249","kashanshah@hotmail.com","North Karachi","0","","0","31","2019-01-15 03:21:35","0000-00-00 00:00:00");
INSERT INTO users VALUES("38","1547416684","KSXX26874DDHWD6IF154741668411ZO","4","","Anonymous","","","","0","","0","31","2019-01-14 02:58:04","0000-00-00 00:00:00");
INSERT INTO users VALUES("41","1547504862","HJ4M11347TZDL6L451547504862IGIA","4","","Jazil","asdasd","","","0","","0","31","2019-01-15 03:27:42","0000-00-00 00:00:00");



