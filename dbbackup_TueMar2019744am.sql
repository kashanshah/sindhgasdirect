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

INSERT INTO configurations VALUES("1","Inventory & Sales Management System","Sindh Gas Direct","Sindh Gas Direct","","Hyderabad","kashanshah@hotmail.com","120","150","","03082699249","","","","","","123","logo.jpg","sindhgas138","11138","0","12","2019-03-05 02:19:28");



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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;




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

INSERT INTO cylinders VALUES("51","aa11-a","for demo","test","11","0","2019-02-01","2024-02-01","187","0","187","2019-03-02 12:15:54","2019-03-05 04:02:24");
INSERT INTO cylinders VALUES("52","aa11-b","for demo\r\n","test","11","1","2019-02-01","2024-02-01","187","0","187","2019-03-02 12:16:23","2019-03-05 04:29:56");
INSERT INTO cylinders VALUES("53","aa11-c","for demo\r\n","test","10","1","2019-02-01","2024-02-01","187","0","187","2019-03-02 12:16:40","2019-03-05 04:27:43");
INSERT INTO cylinders VALUES("54","aa11-d","for demo","test","11","0","2019-02-01","2024-02-01","187","0","187","2019-03-02 12:21:51","2019-03-05 00:21:55");
INSERT INTO cylinders VALUES("56","55","","","10","0","2019-03-02","2024-03-02","187","0","187","2019-03-02 12:47:33","2019-03-02 12:47:33");



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
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=latin1;




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
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=latin1;




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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;




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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;




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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;




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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;




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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;




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
) ENGINE=InnoDB AUTO_INCREMENT=215 DEFAULT CHARSET=latin1;

INSERT INTO users VALUES("1","admin","admin","1","","","","","","0","0","0","0","0","","0","1","0","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO users VALUES("187","sg-plant","123","6","","SGD","021","sg@sg.com","khi","0","0","187","0","1","","0","1","1","0000-00-00 00:00:00","2019-03-05 01:47:33");
INSERT INTO users VALUES("199","sg-shop","123","3","","SGD 1","021","sg@sg.com","khi","62","0","187","0","0","","0","1","187","0000-00-00 00:00:00","2019-03-02 12:14:34");
INSERT INTO users VALUES("200","1551740884","T5D477142278GHSSJQWM15517408840XT3","4","","test","03123786999","sg@sg.com","khi","4","199","187","0","1","","0","1","199","2019-03-05 01:18:23","2019-03-05 02:02:17");
INSERT INTO users VALUES("201","1551731031","QCZN34426705716ISG5KL15517310314NTD","4","","demo","03219292414","sg@sg.com","khi","1","199","187","12000","0","","0","1","199","2019-03-05 01:23:51","2019-03-04 01:48:07");
INSERT INTO users VALUES("202","sg-farhan","123","5","","Farhan","0321","sg@sg.com","khi","0","199","0","0","1","","0","1","199","0000-00-00 00:00:00","2019-03-05 02:07:52");
INSERT INTO users VALUES("203","sg-salman","123","2","","Salman","0300","sg@sg.com","khi","0","199","187","0","0","","0","1","187","0000-00-00 00:00:00","2019-03-02 12:51:47");



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



