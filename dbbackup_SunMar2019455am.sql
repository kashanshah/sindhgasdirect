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

INSERT INTO configurations VALUES("1","Inventory & Sales Management System","Sindh Gas Direct","Sindh Gas Direct","","Hyderabad","kashanshah@hotmail.com","120","150","","03219292414","","","","","","admin","logo.jpg","sindhgas138","","0","12","2019-03-02 12:59:49");



DROP TABLE IF EXISTS cylinder_savings;

CREATE TABLE `cylinder_savings` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CylinderID` int(11) NOT NULL,
  `ShopID` int(11) NOT NULL,
  `Savings` float NOT NULL,
  `PerformedBy` int(11) NOT NULL,
  `DateAdded` date NOT NULL,
  `DateModified` date NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

INSERT INTO cylinder_savings VALUES("2","51","199","4","187","2019-03-02","2019-03-02");
INSERT INTO cylinder_savings VALUES("3","52","199","5","187","2019-03-02","2019-03-02");
INSERT INTO cylinder_savings VALUES("4","53","199","7","187","2019-03-02","2019-03-02");



DROP TABLE IF EXISTS cylinders;

CREATE TABLE `cylinders` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `BarCode` text NOT NULL,
  `Description` text NOT NULL,
  `ShortDescription` text NOT NULL,
  `TierWeight` float NOT NULL,
  `ManufacturingDate` date NOT NULL,
  `ExpiryDate` date NOT NULL,
  `PlantID` int(11) NOT NULL,
  `Status` int(11) NOT NULL,
  `PerformedBy` int(11) NOT NULL,
  `DateAdded` datetime NOT NULL,
  `DateModified` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=latin1;

INSERT INTO cylinders VALUES("51","aa11-a","for demo","test","11","2019-02-01","2024-02-01","187","1","187","2019-03-02 12:15:54","2019-03-02 13:32:20");
INSERT INTO cylinders VALUES("52","aa11-b","for demo","test","11","2019-02-01","2024-02-01","187","1","187","2019-03-02 12:16:23","2019-03-02 13:44:42");
INSERT INTO cylinders VALUES("53","aa11-c","for demo","test","11","2019-02-01","2024-02-01","187","0","187","2019-03-02 12:16:40","2019-03-02 14:28:41");
INSERT INTO cylinders VALUES("54","aa11-d","for demo","test","11","2019-02-01","2024-02-01","187","1","187","2019-03-02 12:21:51","2019-03-02 12:21:51");
INSERT INTO cylinders VALUES("56","55","","","10","2019-03-02","2024-03-02","187","1","187","2019-03-02 12:47:33","2019-03-02 12:47:33");



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
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

INSERT INTO cylinderstatus VALUES("1","1","51","187","30","187","2019-03-02 12:16:48");
INSERT INTO cylinderstatus VALUES("2","2","52","187","55","187","2019-03-02 12:17:22");
INSERT INTO cylinderstatus VALUES("3","2","53","187","80","187","2019-03-02 12:17:22");
INSERT INTO cylinderstatus VALUES("4","3","54","187","50","187","2019-03-02 12:22:07");
INSERT INTO cylinderstatus VALUES("5","4","55","187","20","187","2019-03-02 12:46:24");
INSERT INTO cylinderstatus VALUES("6","5","56","187","20","187","2019-03-02 12:47:47");
INSERT INTO cylinderstatus VALUES("7","6","51","203","30","187","2019-03-02 12:52:05");
INSERT INTO cylinderstatus VALUES("8","6","52","203","55","187","2019-03-02 12:52:05");
INSERT INTO cylinderstatus VALUES("9","6","53","203","80","187","2019-03-02 12:52:05");
INSERT INTO cylinderstatus VALUES("10","6","54","203","50","187","2019-03-02 12:52:05");
INSERT INTO cylinderstatus VALUES("11","1","51","199","30","199","2019-03-02 13:06:52");
INSERT INTO cylinderstatus VALUES("12","1","52","199","55","199","2019-03-02 13:06:52");
INSERT INTO cylinderstatus VALUES("13","1","53","199","80","199","2019-03-02 13:06:52");
INSERT INTO cylinderstatus VALUES("14","1","54","199","50","199","2019-03-02 13:06:52");
INSERT INTO cylinderstatus VALUES("15","1","51","200","30","199","2019-03-02 13:08:32");
INSERT INTO cylinderstatus VALUES("16","1","51","199","15","200","2019-03-02 13:14:50");
INSERT INTO cylinderstatus VALUES("17","2","52","200","55","199","2019-03-02 13:16:18");
INSERT INTO cylinderstatus VALUES("18","11","51","203","15","199","2019-03-02 13:20:14");
INSERT INTO cylinderstatus VALUES("20","1","51","187","15","199","2019-03-02 13:32:20");
INSERT INTO cylinderstatus VALUES("21","2","52","199","16","200","2019-03-02 13:39:05");
INSERT INTO cylinderstatus VALUES("22","15","52","203","16","199","2019-03-02 13:39:18");
INSERT INTO cylinderstatus VALUES("23","1","52","187","16","199","2019-03-02 13:44:42");
INSERT INTO cylinderstatus VALUES("24","3","53","201","80","199","2019-03-02 14:20:46");
INSERT INTO cylinderstatus VALUES("25","4","54","200","50","199","2019-03-02 14:26:44");
INSERT INTO cylinderstatus VALUES("26","3","53","199","18","201","2019-03-02 14:27:16");
INSERT INTO cylinderstatus VALUES("27","20","53","203","18","199","2019-03-02 14:28:30");
INSERT INTO cylinderstatus VALUES("28","1","53","187","18","199","2019-03-02 14:28:41");
INSERT INTO cylinderstatus VALUES("29","22","51","187","30","187","2019-03-02 14:29:46");
INSERT INTO cylinderstatus VALUES("30","23","52","187","50","187","2019-03-02 14:29:57");
INSERT INTO cylinderstatus VALUES("31","24","51","203","30","187","2019-03-02 14:30:50");
INSERT INTO cylinderstatus VALUES("32","2","51","199","30","199","2019-03-02 14:31:16");



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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

INSERT INTO invoices VALUES("1","187","0","Refilling","187","2019-03-02 12:16:48","2019-03-02 12:16:48");
INSERT INTO invoices VALUES("2","187","0","Refilling","187","2019-03-02 12:17:22","2019-03-02 12:17:22");
INSERT INTO invoices VALUES("3","187","0","Refilling","187","2019-03-02 12:22:07","2019-03-02 12:22:07");
INSERT INTO invoices VALUES("4","187","0","Refilling","187","2019-03-02 12:46:24","2019-03-02 12:46:24");
INSERT INTO invoices VALUES("5","187","0","Refilling","187","2019-03-02 12:47:47","2019-03-02 12:47:47");
INSERT INTO invoices VALUES("6","203","1","","187","2019-03-02 12:52:05","2019-03-02 12:52:05");
INSERT INTO invoices VALUES("7","199","0","","199","2019-03-02 13:06:52","2019-03-02 13:06:52");
INSERT INTO invoices VALUES("8","200","0","","199","2019-03-02 13:08:32","2019-03-02 13:08:32");
INSERT INTO invoices VALUES("9","199","0","","200","2019-03-02 13:14:50","2019-03-02 13:14:50");
INSERT INTO invoices VALUES("10","200","0","","199","2019-03-02 13:16:18","2019-03-02 13:16:18");
INSERT INTO invoices VALUES("11","203","1","","199","2019-03-02 13:20:14","2019-03-02 13:20:14");
INSERT INTO invoices VALUES("13","187","0","","199","2019-03-02 13:32:20","2019-03-02 13:32:20");
INSERT INTO invoices VALUES("14","199","0","","200","2019-03-02 13:39:05","2019-03-02 13:39:05");
INSERT INTO invoices VALUES("15","203","1","","199","2019-03-02 13:39:18","2019-03-02 13:39:18");
INSERT INTO invoices VALUES("16","187","0","","199","2019-03-02 13:44:42","2019-03-02 13:44:42");
INSERT INTO invoices VALUES("17","201","0","","199","2019-03-02 14:20:46","2019-03-02 14:20:46");
INSERT INTO invoices VALUES("18","200","0","balance will be paid next week","199","2019-03-02 14:26:44","2019-03-02 14:26:44");
INSERT INTO invoices VALUES("19","199","0","","201","2019-03-02 14:27:16","2019-03-02 14:27:16");
INSERT INTO invoices VALUES("20","203","1","","199","2019-03-02 14:28:30","2019-03-02 14:28:30");
INSERT INTO invoices VALUES("21","187","0","","199","2019-03-02 14:28:41","2019-03-02 14:28:41");
INSERT INTO invoices VALUES("22","187","0","Refilling","187","2019-03-02 14:29:46","2019-03-02 14:29:46");
INSERT INTO invoices VALUES("23","187","0","Refilling","187","2019-03-02 14:29:57","2019-03-02 14:29:57");
INSERT INTO invoices VALUES("24","203","1","","187","2019-03-02 14:30:50","2019-03-02 14:30:50");
INSERT INTO invoices VALUES("25","199","0","","199","2019-03-02 14:31:16","2019-03-02 14:31:16");



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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

INSERT INTO purchase_details VALUES("1","1","51","11","30","30","2280","2280","120","0","0","2019-03-02 13:06:52","199","2019-03-02 13:06:52","2019-03-02 13:06:52");
INSERT INTO purchase_details VALUES("2","1","52","11","55","55","5280","5280","120","0","0","2019-03-02 13:06:52","199","2019-03-02 13:06:52","2019-03-02 13:06:52");
INSERT INTO purchase_details VALUES("3","1","53","11","80","80","8280","8280","120","0","0","2019-03-02 13:06:52","199","2019-03-02 13:06:52","2019-03-02 13:06:52");
INSERT INTO purchase_details VALUES("4","1","54","11","50","50","4680","4680","120","0","0","2019-03-02 13:06:52","199","2019-03-02 13:06:52","2019-03-02 13:06:52");
INSERT INTO purchase_details VALUES("5","2","51","11","30","30","2280","2280","120","0","0","2019-03-02 14:31:16","199","2019-03-02 14:31:16","2019-03-02 14:31:16");



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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO purchases VALUES("1","199","120","20520","0","0","20520","CU361KVE6","","199","2019-03-02 13:06:52","2019-03-02 13:06:52");
INSERT INTO purchases VALUES("2","199","120","2280","0","16","360","2MFD2ZC2T","","199","2019-03-02 14:31:16","2019-03-02 14:31:16");



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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO sale_details VALUES("1","1","51","11","30","2850","150","1","15","2019-03-02 13:14:50","199","2019-03-02 13:08:32","2019-03-02 13:08:32");
INSERT INTO sale_details VALUES("2","2","52","11","55","6600","150","1","16","2019-03-02 13:39:05","199","2019-03-02 13:16:18","2019-03-02 13:16:18");
INSERT INTO sale_details VALUES("3","3","53","11","80","10350","150","1","18","2019-03-02 14:27:16","199","2019-03-02 14:20:46","2019-03-02 14:20:46");
INSERT INTO sale_details VALUES("4","4","54","11","50","5850","150","0","0","1970-01-01 00:00:00","199","2019-03-02 14:26:44","2019-03-02 14:26:44");



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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO sales VALUES("1","199","200","150","2850","0","1000","1850","","199","2019-03-02 13:08:32","2019-03-02 13:08:50");
INSERT INTO sales VALUES("2","199","200","150","6600","4","0","6000","","199","2019-03-02 13:16:18","2019-03-02 13:16:18");
INSERT INTO sales VALUES("3","199","201","150","10350","0","0","10350","","199","2019-03-02 14:20:46","2019-03-02 14:20:46");
INSERT INTO sales VALUES("4","199","200","150","5850","5","2000","3100","balance will be paid next week","199","2019-03-02 14:26:44","2019-03-02 14:26:44");



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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

INSERT INTO sales_amount VALUES("1","1","0","2850","199","","2019-03-02 13:08:32","2019-03-02 13:08:32");
INSERT INTO sales_amount VALUES("2","1","1000","1850","199","","2019-03-02 13:08:50","2019-03-02 13:08:50");
INSERT INTO sales_amount VALUES("3","2","0","6000","199","","2019-03-02 13:16:18","2019-03-02 13:16:18");
INSERT INTO sales_amount VALUES("4","3","0","10350","199","","2019-03-02 14:20:46","2019-03-02 14:20:46");
INSERT INTO sales_amount VALUES("5","4","2000","3100","199","balance will be paid next week","2019-03-02 14:26:44","2019-03-02 14:26:44");



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
  `Remarks` text NOT NULL,
  `Status` int(11) NOT NULL,
  `PerformedBy` int(11) NOT NULL,
  `DateModified` datetime NOT NULL,
  `DateAdded` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=204 DEFAULT CHARSET=latin1;

INSERT INTO users VALUES("1","admin","admin","1","","","","","","0","0","0","0","","1","0","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO users VALUES("187","sg-plant","123","6","","SGD","021","sg@sg.com","khi","0","0","187","0","","1","1","0000-00-00 00:00:00","2019-03-02 12:50:56");
INSERT INTO users VALUES("199","sg-shop","123","3","","SGD 1","021","sg@sg.com","khi","0","0","187","0","","1","187","0000-00-00 00:00:00","2019-03-02 12:14:34");
INSERT INTO users VALUES("200","1551558404","K50I799153394EAXJBS541551558404B5BJ","4","","test","03123786999","sg@sg.com","khi","0","199","187","5000","","1","199","2019-03-02 14:26:44","2019-03-02 12:15:06");
INSERT INTO users VALUES("201","1551558046","LWO61656081785PXSRPWUK1551558046EDTJ","4","","demo","03219292414","sg@sg.com","khi","7","199","187","5000","","1","199","2019-03-02 14:20:46","2019-03-02 12:15:27");
INSERT INTO users VALUES("202","sg-farhan","123","5","","Farhan","0321","sg@sg.com","khi","0","199","0","0","","1","199","0000-00-00 00:00:00","2019-03-02 12:18:58");
INSERT INTO users VALUES("203","sg-salman","123","2","","Salman","0300","sg@sg.com","khi","0","0","187","0","","1","187","0000-00-00 00:00:00","2019-03-02 12:51:47");



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



