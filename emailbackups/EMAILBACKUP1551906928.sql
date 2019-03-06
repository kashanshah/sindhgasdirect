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

INSERT INTO configurations VALUES("1","Inventory & Sales Management System","Sindh Gas Direct","Sindh Gas Direct","","Hyderabad","kashanshah@hotmail.com","120","150","","03082699249","mail.kashanshah.tk","pos@kashanshah.tk","poscis123?","","","123","logo.jpg","sindhgas138","11138","0","12","0000-00-00 00:00:00");



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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;

INSERT INTO cylinder_savings VALUES("1","51","1","1","0","10","187","2019-03-05","2019-03-05");
INSERT INTO cylinder_savings VALUES("2","51","1","1","0","10","187","2019-03-05","2019-03-05");
INSERT INTO cylinder_savings VALUES("3","51","1","1","0","10","187","2019-03-05","2019-03-05");
INSERT INTO cylinder_savings VALUES("4","51","1","1","0","10","187","2019-03-05","2019-03-05");
INSERT INTO cylinder_savings VALUES("5","51","1","1","0","10","187","2019-03-05","2019-03-05");
INSERT INTO cylinder_savings VALUES("6","51","1","1","0","10","187","2019-03-05","2019-03-05");
INSERT INTO cylinder_savings VALUES("7","51","1","1","0","10","187","2019-03-05","2019-03-05");
INSERT INTO cylinder_savings VALUES("8","51","1","1","0","10","187","2019-03-05","2019-03-05");
INSERT INTO cylinder_savings VALUES("9","53","1","1","0","10","187","2019-03-05","2019-03-05");
INSERT INTO cylinder_savings VALUES("10","54","1","1","0","9","187","2019-03-05","2019-03-05");
INSERT INTO cylinder_savings VALUES("11","54","1","1","0","9","187","2019-03-05","2019-03-05");
INSERT INTO cylinder_savings VALUES("12","54","1","1","0","9","187","2019-03-05","2019-03-05");



DROP TABLE IF EXISTS cylinders;

CREATE TABLE `cylinders` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `BarCode` text NOT NULL,
  `Description` text NOT NULL,
  `ShortDescription` text NOT NULL,
  `TierWeight` float NOT NULL,
  `Commercial` int(11) NOT NULL,
  `ManufacturingDate` date NOT NULL,
  `ExpiryDate` date NOT NULL,
  `PlantID` int(11) NOT NULL,
  `Status` int(11) NOT NULL,
  `PerformedBy` int(11) NOT NULL,
  `DateAdded` datetime NOT NULL,
  `DateModified` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=latin1;

INSERT INTO cylinders VALUES("51","aa11-a","for demo","test","11","0","2019-02-01","2024-02-01","187","0","187","2019-03-02 12:15:54","2019-03-05 23:09:49");
INSERT INTO cylinders VALUES("52","aa11-b","for demo\r\n","test","11","1","2019-02-01","2024-02-01","187","1","187","2019-03-02 12:16:23","2019-03-05 04:29:56");
INSERT INTO cylinders VALUES("53","aa11-c","for demo\r\n","test","10","1","2019-02-01","2024-02-01","187","0","187","2019-03-02 12:16:40","2019-03-05 23:18:06");
INSERT INTO cylinders VALUES("54","aa11-d","for demo","test","11","0","2019-02-01","2024-02-01","187","0","187","2019-03-02 12:21:51","2019-03-05 23:19:30");
INSERT INTO cylinders VALUES("56","55","","","10","0","2019-03-02","2024-03-02","187","1","187","2019-03-02 12:47:33","2019-03-02 12:47:33");



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
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=latin1;

INSERT INTO cylinderstatus VALUES("7","3","51","203","21","187","2019-03-05 22:59:30");
INSERT INTO cylinderstatus VALUES("8","4","51","203","21","187","2019-03-05 22:59:39");
INSERT INTO cylinderstatus VALUES("9","5","51","203","21","187","2019-03-05 22:59:49");
INSERT INTO cylinderstatus VALUES("10","6","51","203","21","187","2019-03-05 22:59:53");
INSERT INTO cylinderstatus VALUES("11","7","51","203","21","187","2019-03-05 22:59:57");
INSERT INTO cylinderstatus VALUES("12","8","51","203","21","187","2019-03-05 23:00:00");
INSERT INTO cylinderstatus VALUES("13","9","51","203","21","187","2019-03-05 23:00:03");
INSERT INTO cylinderstatus VALUES("14","10","51","203","21","187","2019-03-05 23:00:07");
INSERT INTO cylinderstatus VALUES("15","11","51","203","21","187","2019-03-05 23:00:12");
INSERT INTO cylinderstatus VALUES("16","12","51","203","21","187","2019-03-05 23:00:18");
INSERT INTO cylinderstatus VALUES("17","13","51","203","21","187","2019-03-05 23:00:22");
INSERT INTO cylinderstatus VALUES("18","14","51","203","21","187","2019-03-05 23:00:30");
INSERT INTO cylinderstatus VALUES("19","15","51","203","21","187","2019-03-05 23:00:42");
INSERT INTO cylinderstatus VALUES("20","16","51","203","21","187","2019-03-05 23:00:47");
INSERT INTO cylinderstatus VALUES("21","17","51","203","21","187","2019-03-05 23:00:51");
INSERT INTO cylinderstatus VALUES("22","18","51","203","21","187","2019-03-05 23:01:02");
INSERT INTO cylinderstatus VALUES("23","19","51","203","21","187","2019-03-05 23:01:14");
INSERT INTO cylinderstatus VALUES("24","20","51","203","21","187","2019-03-05 23:01:19");
INSERT INTO cylinderstatus VALUES("25","21","51","203","21","187","2019-03-05 23:01:27");
INSERT INTO cylinderstatus VALUES("26","22","51","203","21","187","2019-03-05 23:01:32");
INSERT INTO cylinderstatus VALUES("27","23","51","203","21","187","2019-03-05 23:01:37");
INSERT INTO cylinderstatus VALUES("28","24","51","203","21","187","2019-03-05 23:01:59");
INSERT INTO cylinderstatus VALUES("29","25","51","203","21","187","2019-03-05 23:02:09");
INSERT INTO cylinderstatus VALUES("30","26","51","203","21","187","2019-03-05 23:02:21");
INSERT INTO cylinderstatus VALUES("31","27","51","203","21","187","2019-03-05 23:02:31");
INSERT INTO cylinderstatus VALUES("32","28","51","203","21","187","2019-03-05 23:03:01");
INSERT INTO cylinderstatus VALUES("33","29","51","203","21","187","2019-03-05 23:03:11");
INSERT INTO cylinderstatus VALUES("42","38","53","203","20","187","2019-03-05 23:17:58");
INSERT INTO cylinderstatus VALUES("43","38","54","203","20","187","2019-03-05 23:17:58");
INSERT INTO cylinderstatus VALUES("44","38","56","203","20","187","2019-03-05 23:17:58");
INSERT INTO cylinderstatus VALUES("53","3","56","199","20","203","2019-03-06 00:28:34");
INSERT INTO cylinderstatus VALUES("54","3","56","201","20","199","2019-03-06 00:52:10");



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
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;

INSERT INTO invoices VALUES("1","187","0","Refilling","187","2019-03-05 22:58:25","2019-03-05 22:58:25");
INSERT INTO invoices VALUES("2","203","1","","187","2019-03-05 22:59:14","2019-03-05 22:59:14");
INSERT INTO invoices VALUES("3","203","1","","187","2019-03-05 22:59:30","2019-03-05 22:59:30");
INSERT INTO invoices VALUES("4","203","1","","187","2019-03-05 22:59:39","2019-03-05 22:59:39");
INSERT INTO invoices VALUES("5","203","1","","187","2019-03-05 22:59:49","2019-03-05 22:59:49");
INSERT INTO invoices VALUES("6","203","1","","187","2019-03-05 22:59:53","2019-03-05 22:59:53");
INSERT INTO invoices VALUES("7","203","1","","187","2019-03-05 22:59:57","2019-03-05 22:59:57");
INSERT INTO invoices VALUES("8","203","1","","187","2019-03-05 23:00:00","2019-03-05 23:00:00");
INSERT INTO invoices VALUES("9","203","1","","187","2019-03-05 23:00:03","2019-03-05 23:00:03");
INSERT INTO invoices VALUES("10","203","1","","187","2019-03-05 23:00:07","2019-03-05 23:00:07");
INSERT INTO invoices VALUES("11","203","1","","187","2019-03-05 23:00:12","2019-03-05 23:00:12");
INSERT INTO invoices VALUES("12","203","1","","187","2019-03-05 23:00:18","2019-03-05 23:00:18");
INSERT INTO invoices VALUES("13","203","1","","187","2019-03-05 23:00:22","2019-03-05 23:00:22");
INSERT INTO invoices VALUES("14","203","1","","187","2019-03-05 23:00:30","2019-03-05 23:00:30");
INSERT INTO invoices VALUES("15","203","1","","187","2019-03-05 23:00:42","2019-03-05 23:00:42");
INSERT INTO invoices VALUES("16","203","1","","187","2019-03-05 23:00:47","2019-03-05 23:00:47");
INSERT INTO invoices VALUES("17","203","1","","187","2019-03-05 23:00:51","2019-03-05 23:00:51");
INSERT INTO invoices VALUES("18","203","1","","187","2019-03-05 23:01:02","2019-03-05 23:01:02");
INSERT INTO invoices VALUES("19","203","1","","187","2019-03-05 23:01:14","2019-03-05 23:01:14");
INSERT INTO invoices VALUES("20","203","1","","187","2019-03-05 23:01:19","2019-03-05 23:01:19");
INSERT INTO invoices VALUES("21","203","1","","187","2019-03-05 23:01:27","2019-03-05 23:01:27");
INSERT INTO invoices VALUES("22","203","1","","187","2019-03-05 23:01:32","2019-03-05 23:01:32");
INSERT INTO invoices VALUES("23","203","1","","187","2019-03-05 23:01:37","2019-03-05 23:01:37");
INSERT INTO invoices VALUES("24","203","1","","187","2019-03-05 23:01:59","2019-03-05 23:01:59");
INSERT INTO invoices VALUES("25","203","1","","187","2019-03-05 23:02:09","2019-03-05 23:02:09");
INSERT INTO invoices VALUES("26","203","1","","187","2019-03-05 23:02:21","2019-03-05 23:02:21");
INSERT INTO invoices VALUES("27","203","1","","187","2019-03-05 23:02:31","2019-03-05 23:02:31");
INSERT INTO invoices VALUES("28","203","1","","187","2019-03-05 23:03:01","2019-03-05 23:03:01");
INSERT INTO invoices VALUES("29","203","1","","187","2019-03-05 23:03:11","2019-03-05 23:03:11");
INSERT INTO invoices VALUES("30","187","0","","1","2019-03-05 23:05:12","2019-03-05 23:05:12");
INSERT INTO invoices VALUES("31","187","0","","1","2019-03-05 23:06:02","2019-03-05 23:06:02");
INSERT INTO invoices VALUES("32","187","0","","1","2019-03-05 23:06:11","2019-03-05 23:06:11");
INSERT INTO invoices VALUES("33","187","0","","1","2019-03-05 23:07:59","2019-03-05 23:07:59");
INSERT INTO invoices VALUES("34","187","0","","1","2019-03-05 23:08:20","2019-03-05 23:08:20");
INSERT INTO invoices VALUES("35","187","0","","1","2019-03-05 23:08:34","2019-03-05 23:08:34");
INSERT INTO invoices VALUES("36","187","0","","1","2019-03-05 23:08:53","2019-03-05 23:08:53");
INSERT INTO invoices VALUES("37","187","0","","1","2019-03-05 23:09:49","2019-03-05 23:09:49");
INSERT INTO invoices VALUES("38","203","1","","187","2019-03-05 23:17:58","2019-03-05 23:17:58");
INSERT INTO invoices VALUES("39","187","0","","1","2019-03-05 23:18:06","2019-03-05 23:18:06");
INSERT INTO invoices VALUES("40","187","0","","1","2019-03-05 23:18:23","2019-03-05 23:18:23");
INSERT INTO invoices VALUES("41","187","0","","1","2019-03-05 23:19:10","2019-03-05 23:19:10");
INSERT INTO invoices VALUES("42","187","0","","1","2019-03-05 23:19:30","2019-03-05 23:19:30");
INSERT INTO invoices VALUES("43","199","0","","199","2019-03-05 23:48:18","2019-03-05 23:48:18");
INSERT INTO invoices VALUES("44","199","0","","199","2019-03-05 23:48:35","2019-03-05 23:48:35");
INSERT INTO invoices VALUES("45","201","0","","199","2019-03-05 23:48:52","2019-03-05 23:48:52");
INSERT INTO invoices VALUES("46","201","0","","199","2019-03-05 23:57:52","2019-03-05 23:57:52");
INSERT INTO invoices VALUES("47","199","0","","199","2019-03-06 00:28:34","2019-03-06 00:28:34");
INSERT INTO invoices VALUES("48","201","0","","199","2019-03-06 00:52:10","2019-03-06 00:52:10");



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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO purchase_details VALUES("2","2","56","10","20","20","1200","1200","120","0","0","2019-03-05 23:48:35","199","2019-03-05 23:48:35","2019-03-05 23:48:35");
INSERT INTO purchase_details VALUES("3","3","56","10","20","20","1200","1200","120","0","0","2019-03-06 00:28:34","199","2019-03-06 00:28:34","2019-03-06 00:28:34");



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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO purchases VALUES("2","199","120","1200","0","0","1200","DDET2LDRA","","199","2019-03-05 23:48:35","2019-03-05 23:48:35");
INSERT INTO purchases VALUES("3","199","120","1200","600","0","600","OGGQ3LN3C,L5V335STD","","199","2019-03-06 00:28:34","2019-03-06 00:41:13");



DROP TABLE IF EXISTS roles;

CREATE TABLE `roles` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` text NOT NULL,
  `Description` text NOT NULL,
  `PerformedBy` int(11) NOT NULL,
  `DateAdded` datetime NOT NULL,
  `DateModified` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

INSERT INTO roles VALUES("1","Admin","","0","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO roles VALUES("2","Driver","","0","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO roles VALUES("3","Shop","","0","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO roles VALUES("4","Customer","","0","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO roles VALUES("5","Sales","","0","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO roles VALUES("6","Plant","","0","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO roles VALUES("7","User","","0","0000-00-00 00:00:00","0000-00-00 00:00:00");



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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO sale_details VALUES("3","3","56","10","20","1500","150","0","0","1970-01-01 00:00:00","199","2019-03-06 00:52:10","2019-03-06 00:52:10");



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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO sales VALUES("3","199","201","150","1500","0","0","1500","","199","2019-03-06 00:52:10","2019-03-06 00:52:10");



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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO sales_amount VALUES("3","3","0","1500","199","","2019-03-06 00:52:10","2019-03-06 00:52:10");



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
  `ShopID` int(11) NOT NULL,
  `PlantID` int(11) NOT NULL,
  `CreditLimit` float NOT NULL,
  `SendSMS` int(11) NOT NULL,
  `Remarks` text NOT NULL,
  `SecurityDeposite` float NOT NULL,
  `Status` int(11) NOT NULL,
  `PerformedBy` int(11) NOT NULL,
  `DateModified` datetime NOT NULL,
  `DateAdded` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=205 DEFAULT CHARSET=latin1;

INSERT INTO users VALUES("1","admin","admin","1","","","","","","180","0","0","0","0","","0","1","0","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO users VALUES("187","sg-plant","123","6","","SGD","021","sg@sg.com","khi","0","0","187","0","1","","0","1","1","0000-00-00 00:00:00","2019-03-05 01:47:33");
INSERT INTO users VALUES("199","sg-shop","123","3","","SGD 1","03082699249","sg@sg.com","khi","0","0","187","0","1","","0","1","187","0000-00-00 00:00:00","2019-03-05 22:58:43");
INSERT INTO users VALUES("200","1551740884","T5D477142278GHSSJQWM15517408840XT3","4","","test","03123786999","sg@sg.com","khi","4","199","187","0","1","","0","1","199","2019-03-05 01:18:23","2019-03-05 02:02:17");
INSERT INTO users VALUES("201","1551815530","TE5T374018251NWSZR5WC15518155305LZO","4","","demo","03219292414","sg@sg.com","khi","0","199","187","12000","0","","0","1","199","2019-03-05 01:23:51","2019-03-04 01:48:07");
INSERT INTO users VALUES("202","sg-farhan","123","5","","Farhan","0321","sg@sg.com","khi","0","199","0","0","1","","0","1","199","0000-00-00 00:00:00","2019-03-05 02:07:52");
INSERT INTO users VALUES("203","sg-salman","123","2","","Salman","03219292414","sg@sg.com","khi","0","199","187","0","0","","0","1","187","0000-00-00 00:00:00","2019-03-05 22:59:06");
INSERT INTO users VALUES("204","1551817806","ZKQW1002830401MOE65WWQ1551817806MLLT","4","","2345","dfghjk","","","0","199","187","1000","1","","0","1","199","0000-00-00 00:00:00","0000-00-00 00:00:00");



DROP TABLE IF EXISTS vehicles;

CREATE TABLE `vehicles` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` text COLLATE utf8_unicode_ci NOT NULL,
  `RegistrationNo` text COLLATE utf8_unicode_ci NOT NULL,
  `Details` text COLLATE utf8_unicode_ci NOT NULL,
  `PlantID` int(11) NOT NULL,
  `DateAdded` datetime NOT NULL,
  `DateModified` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO vehicles VALUES("1","Suzuki Bolan","JF-1101","","187","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO vehicles VALUES("2","Blue Suzuki Bolan","JF-1102","","187","0000-00-00 00:00:00","0000-00-00 00:00:00");



