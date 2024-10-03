-- Generation time: Mon, 29 Jan 2024 13:07:34 +0100
-- Host: localhost
-- DB name: artify
/*!40030 SET NAMES UTF8 */;
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext NOT NULL,
  `email` longtext NOT NULL,
  `password` longtext NOT NULL,
  `level` longtext NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `admin` VALUES ('1','Mr. Admin','admin@example.com','1234','1'); 


DROP TABLE IF EXISTS `advertisement`;
CREATE TABLE `advertisement` (
  `ad_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ad_title` varchar(255) NOT NULL,
  `ad_description` varchar(255) NOT NULL,
  `ad_category` varchar(200) NOT NULL,
  `country` varchar(200) NOT NULL,
  `featured_image1` varchar(255) NOT NULL,
  `featured_image2` varchar(255) NOT NULL,
  PRIMARY KEY (`ad_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



DROP TABLE IF EXISTS `appointment`;
CREATE TABLE `appointment` (
  `appointment_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(250) NOT NULL,
  `last_name` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `phone_number` varchar(250) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `reason` varchar(250) NOT NULL,
  `status` varchar(100) NOT NULL,
  PRIMARY KEY (`appointment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



DROP TABLE IF EXISTS `attendance`;
CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(11) NOT NULL COMMENT '0 undefined , 1 present , 2  absent',
  `student_id` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`attendance_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



DROP TABLE IF EXISTS `audition`;
CREATE TABLE `audition` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `performance_title` varchar(250) NOT NULL,
  `performer_name` varchar(255) NOT NULL,
  `length_of_performance` varchar(255) NOT NULL,
  `style` varchar(255) NOT NULL,
  `instruments` varchar(255) NOT NULL,
  `prop` varchar(255) NOT NULL,
  `microphones` varchar(255) NOT NULL,
  `cd` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `age` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `audition` VALUES ('4','tt','tt','tt','1','0','1','0','1','1','tt','tt','tt@g.com','ghgh'),
('5','uu','uu','uu','1','1','0','1','0','0','uu','uu','uu!@g.m','jhgjgh'),
('6','tt','tt','tt','1','0','1','0','1','1','tt','tt','tt@g.com','ghgh'); 


DROP TABLE IF EXISTS `book`;
CREATE TABLE `book` (
  `book_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `author` varchar(250) NOT NULL,
  `price` float NOT NULL,
  `sale_price` float NOT NULL,
  PRIMARY KEY (`book_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `book` VALUES ('12','Angles &amp; Demons','DB','600','624'); 


DROP TABLE IF EXISTS `booking_status_master`;
CREATE TABLE `booking_status_master` (
  `booking_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `status_text` varchar(200) NOT NULL,
  PRIMARY KEY (`booking_status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



DROP TABLE IF EXISTS `bookroom`;
CREATE TABLE `bookroom` (
  `booking_Id` int(11) NOT NULL AUTO_INCREMENT,
  `room_Id` int(11) NOT NULL,
  `first_name` varchar(250) NOT NULL,
  `last_name` varchar(250) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `no_of_adult` int(11) NOT NULL,
  `no_of_child` int(11) NOT NULL,
  `email` varchar(200) NOT NULL,
  `phone_number` varchar(200) NOT NULL,
  `booking_amount` double NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  `booking_status` int(11) NOT NULL,
  PRIMARY KEY (`booking_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `bookroom` VALUES ('1','1','jon','Snow','2016-11-04','2016-11-11','2','2','someemai@gmail.com','+919977848644','100','Paypal','0'); 


DROP TABLE IF EXISTS `car_booking`;
CREATE TABLE `car_booking` (
  `booking_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pick_up_location` varchar(255) NOT NULL,
  `drop_off_location` varchar(255) NOT NULL,
  `car_type` varchar(200) NOT NULL,
  `car_with` varchar(255) NOT NULL,
  `first_name` varchar(200) NOT NULL,
  `last_name` varchar(200) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `additional_request` varchar(255) NOT NULL,
  PRIMARY KEY (`booking_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



DROP TABLE IF EXISTS `checkout`;
CREATE TABLE `checkout` (
  `checkout_id` bigint(20) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  `name_on_card` varchar(250) NOT NULL,
  `card_number` varchar(50) NOT NULL,
  `cvv_number` varchar(50) NOT NULL,
  `expiration_date` date NOT NULL,
  `expiration_year` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



DROP TABLE IF EXISTS `ci_sessions`;
CREATE TABLE `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT 0,
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



DROP TABLE IF EXISTS `city`;
CREATE TABLE `city` (
  `city_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `state_id` bigint(20) NOT NULL,
  `country_id` bigint(20) NOT NULL,
  `city_code` varchar(250) NOT NULL,
  `city_name` varchar(250) NOT NULL,
  PRIMARY KEY (`city_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `city` VALUES ('1','1','1','10001','Athens'),
('2','2','1','10002','Los Angeles'),
('3','5','1','10003','Houston'),
('4','4','1','10004','Phoenix'); 


DROP TABLE IF EXISTS `class`;
CREATE TABLE `class` (
  `class_id` int(11) NOT NULL AUTO_INCREMENT,
  `class_name` varchar(250) NOT NULL,
  `code` varchar(250) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`class_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `class` VALUES ('1','first','111','1'),
('2','second','2','5'),
('3','third','3','5'),
('4','fourth','4','5'); 


DROP TABLE IF EXISTS `class_routine`;
CREATE TABLE `class_routine` (
  `class_routine_id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `time_start` int(11) NOT NULL,
  `time_end` int(11) NOT NULL,
  `day` longtext NOT NULL,
  PRIMARY KEY (`class_routine_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



DROP TABLE IF EXISTS `contact`;
CREATE TABLE `contact` (
  `contact_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `address` varchar(250) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `zip/postal_code` varchar(50) NOT NULL,
  `fax` varchar(50) NOT NULL,
  `subject` varchar(250) NOT NULL,
  `message` text NOT NULL,
  `country` varchar(50) NOT NULL,
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



DROP TABLE IF EXISTS `country`;
CREATE TABLE `country` (
  `country_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `country_name` varchar(250) NOT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `country` VALUES ('1','USA'),
('2','INDIA'),
('3','Australia'),
('4','Newzealand'); 


DROP TABLE IF EXISTS `cruises_booking`;
CREATE TABLE `cruises_booking` (
  `cruises_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cruise_destination` varchar(200) NOT NULL,
  `cruise_length` varchar(255) NOT NULL,
  `departure_month` varchar(200) NOT NULL,
  `day` varchar(200) NOT NULL,
  `cruise_departure_port` varchar(255) NOT NULL,
  `cruise_line` varchar(255) NOT NULL,
  `where_do_you_live?` varchar(255) NOT NULL,
  PRIMARY KEY (`cruises_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `cruises_booking` VALUES ('1','ttt','tut','6','6','766','767',''); 


DROP TABLE IF EXISTS `customer_feedback`;
CREATE TABLE `customer_feedback` (
  `customer_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `products_quality_rating` varchar(250) NOT NULL,
  `products_interested` varchar(250) NOT NULL,
  `service_satisfraction` varchar(250) NOT NULL,
  `recommendation` varchar(250) NOT NULL,
  `how_long_have_you_been_a_customer_of_our_company` varchar(250) NOT NULL,
  `comments` text NOT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



DROP TABLE IF EXISTS `customer_support_request`;
CREATE TABLE `customer_support_request` (
  `request_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `your_full_name` varchar(11) NOT NULL,
  `your_email` varchar(11) NOT NULL,
  `category` varchar(200) NOT NULL,
  `importance` varchar(200) NOT NULL,
  `brief_description` varchar(255) NOT NULL,
  `comments` varchar(255) NOT NULL,
  `send_a_copy` varchar(100) NOT NULL,
  PRIMARY KEY (`request_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



DROP TABLE IF EXISTS `customertable`;
CREATE TABLE `customertable` (
  `customer_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(100) DEFAULT NULL,
  `customer_contact_number` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `customer_address` varchar(200) DEFAULT NULL,
  `customer_city` varchar(50) DEFAULT NULL,
  `customer_state` varchar(50) DEFAULT NULL,
  `customer_country` varchar(50) DEFAULT NULL,
  `postal_code` int(10) DEFAULT NULL,
  `comment` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `customertable` VALUES ('1','Jacobs','0342 172 3852','Duis.ac.arcu@acliberonec.ca','293-7062 Mauris. Av.','Posina','VEN','Wallis and Futuna','43957','et netus et malesuada fames ac turpis'),
('2','Valentine','(0111) 376 7616','Phasellus.dapibus.quam@eu.com','P.O. Box 167, 5555 Justo Avenue','Kalgoorlie-Boulder','Western Australia','Guam','0','et netus et malesuada fames ac turpis'),
('3','Wade','055 1052 3067','Aliquam.ultrices@Proin.ca','650-4617 Duis Rd.','Hamburg','Hamburg','Norway','6776','vulputate, lacus. Cras interdum. Nunc sollicitudin commodo ipsum.'),
('4','Jacob','0342 172 3852','Duis.ac.arcu@acliberonec.ca','293-7062 Mauris. Av.','Posina','VEN','Wallis and Futuna','43957','et netus et malesuada fames ac turpis'),
('5','Hilel','070 1043 8126','fermentum.arcu.Vestibulum@blanditNam.edu','1364 Elit. Rd.','Cz?stochowa','Sl?skie','Timor-Leste','427335','sapien. Nunc pulvinar arcu et pede.'),
('6','Norman','0800 778 7355','Nullam.suscipit@tellus.edu','P.O. Box 117, 952 Dolor Road','Drumheller','AB','Korea, North','900326','Aenean eget'),
('7','Josiah','(027) 9515 2604','eget.metus@ac.ca','P.O. Box 698, 3491 Est, St.','Pozant?','Adana','Svalbard and Jan Mayen Islands','81954','cursus luctus, ipsum leo elementum sem, vitae'),
('8','Amos','(01413) 04893','mauris.eu@tinciduntDonec.ca','721-397 Lectus. Road','Pontevedra','GA','Kazakhstan','7351','purus, in molestie tortor'),
('9','Oscar','0334 254 8662','Etiam.vestibulum@tempor.co.uk','5139 Metus Rd.','Ramara','ON','Syria','0','malesuada malesuada. Integer id magna et ipsum cursus vestibulum. Mauris'),
('10','Samson','0800 408606','et.ultrices.posuere@aliquetmolestietellus.net','P.O. Box 759, 9227 Nec, Rd.','Aylmer','QC','Viet Nam','8864','non ante bibendum ullamcorper. Duis cursus, diam at'),
('11','Norman','076 4891 0563','nisi.nibh.lacinia@metus.co.uk','Ap #433-4893 Amet Road','Waiheke Island','NI','Pakistan','13854','Sed diam lorem, auctor quis, tristique ac, eleifend vitae,'),
('12','Len','(01578) 601244','feugiat@vulputatelacus.co.uk','750-7366 Cursus Avenue','Gaspé','Quebec','Cyprus','339712','Aliquam'),
('13','Calvin','(011400) 74471','Mauris@imperdietdictummagna.org','545-1060 Cras Ave','Bida','Niger','Micronesia','0','tellus faucibus leo, in'),
('14','Kasper','055 2139 3298','sem@Maurisut.co.uk','6559 Semper. St.','Hattem','Gl','Trinidad and Tobago','0','molestie arcu. Sed eu nibh vulputate mauris sagittis placerat. Cras'),
('15','Nolan','0329 902 1031','posuere@odio.org','5115 Mauris St.','Cork','M','Oman','12','fames ac turpis egestas. Aliquam fringilla'),
('16','Quinlan','(0151) 197 3080','accumsan@necurna.ca','Ap #731-8556 Nibh St.','Lowell','Massachusetts','Argentina','585556','metus facilisis lorem tristique aliquet. Phasellus fermentum convallis ligula.'),
('17','Sean','(01995) 88745','Nullam.enim.Sed@pharetraQuisque.co.uk','P.O. Box 870, 6709 Pede, St.','Ancud','X','Syria','958164','eget metus eu erat'),
('18','Akeem','0500 158269','nisl@eteuismod.co.uk','P.O. Box 307, 168 Morbi Rd.','Castanhal','Pará','New Zealand','9661','Aliquam adipiscing lobortis risus. In mi'),
('19','Emery','(015186) 12458','non@vestibulum.org','P.O. Box 535, 9407 Nec Rd.','Herstappe','L.','Nepal','25750','et, euismod et, commodo at, libero.'),
('20','Shad','(0111) 709 1132','Maecenas@egettincidunt.co.uk','3102 Dapibus St.','Oakham','Rutland','Madagascar','1350','dolor, nonummy'),
('21','Tanner','(012651) 13225','diam.Pellentesque@sagittisaugue.org','848 Ullamcorper, Ave','Hamburg','Hamburg','Japan','68155','rutrum. Fusce dolor'),
('22','Adrian','(019347) 57734','gravida@sedtortor.ca','7480 Nulla Avenue','Carterton','OX','Lesotho','770739','Donec consectetuer mauris id sapien.'),
('23','Wylie','07000 020530','ridiculus.mus.Proin@sagittislobortis.com','824 Molestie Rd.','Galway','Connacht','Malaysia','9558','non justo.'),
('24','Joel','(0181) 866 2932','Vivamus.euismod.urna@elitpede.net','2531 Fusce Ave','Guadalupe','San José','Colombia','205106','in faucibus orci luctus et ultrices'),
('25','Cairo','(0111) 522 2497','turpis@Duisgravida.net','P.O. Box 868, 2071 Diam Avenue','Westerlo','AN','Cook Islands','935647','ornare lectus'),
('26','Leroy','0912 717 5586','condimentum.eget@molestie.com','8661 Tincidunt, Street','Gulfport','Mississippi','Marshall Islands','19612','Donec at arcu. Vestibulum ante ipsum primis'),
('27','Josiah','(016977) 0886','penatibus.et.magnis@Mauriseu.net','4563 Penatibus Av.','Putre','XV','Qatar','0','velit in aliquet lobortis,'),
('28','Dominic','(0131) 789 8041','libero@magnaNamligula.co.uk','7271 Molestie Street','Vitória da Conquista','Bahia','Bosnia and Herzegovina','6099','Nunc ac sem ut dolor dapibus gravida. Aliquam'),
('29','Rigel','(01003) 070423','auctor@velitin.ca','391-9632 Tincidunt St.','Sikar','RJ','Kuwait','9030','lacinia at, iaculis quis, pede. Praesent eu dui.'),
('30','Harding','0845 46 45','Aenean.egestas.hendrerit@accumsansed.edu','P.O. Box 623, 8290 In, Street','Allappuzha','Kerala','Saint Martin','7800','Curabitur consequat, lectus sit amet luctus vulputate, nisi sem semper'),
('31','Zeus','070 4503 3869','fermentum@atlacusQuisque.edu','P.O. Box 553, 5667 Sodales St.','Alacant','Comunitat Valenciana','Lebanon','53899','ullamcorper eu, euismod'),
('32','Brandon','0383 332 7877','Donec.tincidunt@scelerisquesed.net','9848 Scelerisque St.','Gboko','BE','Jersey','54723','dictum sapien. Aenean'),
('33','Uriel','0800 1111','eu@sitametfaucibus.org','Ap #425-1146 Lacus. Avenue','Follina','VEN','Croatia','53492','eu nulla at sem molestie'),
('34','Theodore','056 2469 1864','enim@purusaccumsaninterdum.co.uk','P.O. Box 416, 3378 Faucibus Road','San Rafael','A','Singapore','217324','diam lorem, auctor quis, tristique ac, eleifend'),
('35','Ahmed','(011040) 32391','vel@acfeugiatnon.org','430-3742 Eu St.','Bauchi','Bauchi','Croatia','58259','parturient montes, nascetur ridiculus mus. Proin'),
('36','Jelani','0800 1111','arcu.imperdiet.ullamcorper@loremDonecelementum.edu','Ap #771-2423 Nonummy. Rd.','Vannes','BR','Singapore','42538','non, hendrerit id, ante. Nunc mauris'),
('37','Nero','(016977) 3574','iaculis.odio@dapibusligula.net','9706 Sed St.','Vienna','Wie','Cameroon','0','sed libero. Proin sed'),
('38','Sebastian','(0161) 643 2096','ornare@Duisa.co.uk','1723 Est. Rd.','Santander','CA','Yemen','78','nec tempus scelerisque, lorem'),
('39','Cameron','0982 838 3526','malesuada.ut.sem@eutempor.com','Ap #194-6594 Eu, Street','Bridgeport','CT','Bulgaria','87789','at arcu. Vestibulum'),
('40','Chaney','0908 915 8835','Phasellus.in@euelit.ca','7815 Donec Rd.','Baie-D\'Urfé','QC','Guadeloupe','44450','non'),
('41','Gage','0800 1111','tellus@aultriciesadipiscing.ca','603-9699 Ornare, Av.','Ravenstein','N.','Sao Tome and Principe','75445','ac, eleifend vitae, erat. Vivamus nisi. Mauris'),
('42','Vladimir','(017633) 97739','Curabitur.massa@enimMauris.co.uk','Ap #380-5397 A, St.','Segni','Lazio','Pakistan','1643','tellus. Suspendisse sed dolor. Fusce'),
('43','Gannon','07624 978816','placerat.velit@tincidunttempusrisus.com','Ap #721-5315 Ridiculus Av.','Wanneroo','WA','Madagascar','694988','libero. Donec consectetuer mauris id'),
('44','Ezekiel','0800 492724','Sed.nulla@molestiearcuSed.co.uk','6835 Sit Avenue','Cork','M','Slovenia','37055','Proin dolor. Nulla semper tellus'),
('45','Hector','(0111) 324 5916','neque.et@odioEtiam.edu','1348 Cum Rd.','Santa Inês','Maranhão','Poland','8674','in, cursus et, eros. Proin ultrices. Duis volutpat nunc sit'),
('46','Aristotle','(010708) 72750','enim.nisl@Proinultrices.co.uk','595-9145 Fringilla Ave','Welland','ON','Slovakia','891984','arcu. Curabitur ut odio vel est tempor bibendum.'),
('47','Aidan','0500 593017','mollis@etrutrum.org','2025 Vitae, Rd.','Nandyal','Andhra Pradesh','Saudi Arabia','9353','natoque'),
('48','Tyler','(0118) 937 4839','elit.sed.consequat@magna.ca','P.O. Box 464, 7967 Consequat Rd.','Alajuela','A','Maldives','49662','in, dolor. Fusce feugiat. Lorem ipsum'),
('49','Nathaniel','0800 157 1770','sagittis.semper@CrasinterdumNunc.edu','Ap #612-9463 Lobortis Road','Galway','Connacht','Barbados','752977','sodales purus, in molestie tortor'),
('50','Ryan','(026) 0188 9025','a.aliquet@scelerisquesed.org','Ap #761-8854 Pede Rd.','Ipatinga','Minas Gerais','Mongolia','1289','dolor, nonummy ac, feugiat non, lobortis quis,'),
('51','Herman','07624 908554','pede@tincidunttempusrisus.co.uk','P.O. Box 300, 1178 Sit Ave','Evere','Brussels Hoofdstedelijk Gewest','Marshall Islands','37365','lobortis mauris. Suspendisse'),
('52','Blaze','(01260) 523935','diam.nunc.ullamcorper@massaMaurisvestibulum.net','616-3566 In Street','Pontarlier','FC','Hungary','61348','fringilla, porttitor vulputate, posuere'),
('53','Grady','07125 424439','mauris.Morbi@nisl.edu','Ap #768-9391 Parturient Avenue','Salt Lake City','UT','Mali','38379','nunc ac mattis ornare, lectus ante dictum'),
('54','Sylvester','0958 006 0187','bibendum.Donec.felis@inhendrerit.com','9869 Diam. Av.','Vienna','Wie','British Indian Ocean Territory','44008','luctus felis purus'),
('55','Palmer','056 1131 0571','arcu.Vestibulum@maurissapiencursus.org','761-5460 Vitae Rd.','Gillette','Wyoming','Cyprus','7257','odio. Nam interdum enim non'),
('56','Porter','0800 1111','Aenean.massa.Integer@nonenim.edu','5241 Tellus Street','Warszawa','MA','Serbia','26357','nonummy. Fusce fermentum fermentum arcu. Vestibulum'),
('57','Norman','(0151) 801 9257','augue@Donectempor.ca','P.O. Box 468, 6994 Dolor St.','Butte','MT','Samoa','0','nunc. Quisque ornare tortor'),
('58','Raymond','(0111) 251 2423','orci.Ut@lectusantedictum.ca','P.O. Box 287, 4541 Consequat, Road','Meldert','Oost-Vlaanderen','Western Sahara','0','iaculis'),
('59','Otto','(01690) 56867','nisl.Maecenas.malesuada@anteipsumprimis.edu','Ap #889-4544 Facilisis St.','Bodmin','CO','Nigeria','2003','aliquet odio. Etiam ligula'),
('60','Seth','0927 975 6260','Mauris@ornarelectus.edu','Ap #551-2602 Nibh. St.','Berlin','Berlin','Tajikistan','11915','ante.'),
('61','Ira','(010034) 65362','Vestibulum.ante.ipsum@duilectus.com','Ap #274-3102 Diam. Avenue','Meerut','UP','Palestine, State of','9','dignissim tempor arcu. Vestibulum ut eros'),
('62','Michael','(016977) 8049','elit@enim.co.uk','Ap #296-5222 Rutrum Street','Gebze','Koc','Belarus','25062','primis in faucibus orci luctus et ultrices posuere'),
('63','Keaton','(0171) 246 5450','ornare.Fusce.mollis@augue.co.uk','P.O. Box 813, 9452 Ante Av.','Tiltil','Metropolitana de Santiago','Puerto Rico','9156','ut mi. Duis risus odio, auctor vitae, aliquet'),
('64','Dante','07444 371399','Nullam.scelerisque@CrasinterdumNunc.net','239-382 Lacus. Ave','Millesimo','LIG','Gambia','39','Donec est.'),
('65','Erasmus','0871 539 3463','interdum.enim@ligulaNullam.edu','P.O. Box 251, 2540 Neque. Rd.','Drancy','Île-de-France','Ethiopia','35870','enim. Sed nulla ante, iaculis'),
('66','Scott','0800 1111','elit@ipsum.com','Ap #741-1325 Odio. Street','Geraldton-Greenough','WA','Bahrain','20839','Mauris eu turpis. Nulla aliquet. Proin velit. Sed malesuada'),
('67','Driscoll','056 4287 5376','tristique.ac.eleifend@Donecfeugiat.edu','Ap #722-3564 Fringilla, St.','Pointe-du-Lac','QC','Ethiopia','0','condimentum eget, volutpat ornare, facilisis'),
('68','Grady','070 2218 7053','libero.Proin@sed.ca','Ap #245-9808 Elit, Rd.','Ñuñoa','Metropolitana de Santiago','Dominica','70062','egestas. Aliquam fringilla cursus purus. Nullam scelerisque'),
('69','Shad','070 6101 3006','Donec@sedhendrerita.edu','6627 At, St.','Sete Lagoas','Minas Gerais','Cameroon','37578','gravida sagittis. Duis gravida. Praesent eu nulla at'),
('70','Oren','07624 471397','nec.diam.Duis@luctus.net','9028 Arcu. Av.','Laval','Pays de la Loire','Guinea-Bissau','0','ut cursus luctus, ipsum leo elementum sem, vitae'),
('71','Slade','0800 603365','enim@magna.edu','P.O. Box 156, 301 Faucibus Rd.','Rio Marina','TOS','Singapore','0','aliquet, metus'),
('72','Emerson','(027) 5546 8276','sem.Pellentesque.ut@maurissapiencursus.ca','P.O. Box 938, 4820 Laoreet Street','Worcester','MA','Papua New Guinea','658626','sapien imperdiet ornare. In'),
('73','Channing','(0101) 226 4826','sit.amet@nulla.org','Ap #516-4779 Velit Avenue','Salem','Tamil Nadu','Botswana','856550','Curabitur massa.'),
('74','Amos','076 3888 1588','sem.vitae.aliquam@ante.net','Ap #257-252 Pellentesque St.','Che?m','LU','Bulgaria','7211','a, aliquet vel, vulputate eu, odio. Phasellus at augue id'),
('75','Emmanuel','0800 293 5246','sem@malesuadaiderat.ca','845-8343 Elit Rd.','Río Hurtado','Coquimbo','Burundi','51','a nunc. In at pede. Cras vulputate velit'),
('76','Gage','076 6534 8929','ipsum.porta@risusNulla.co.uk','5765 Montes, Rd.','Åkersberga','Stockholms län','Antarctica','0','eu, odio. Phasellus at augue id ante dictum cursus.'),
('77','Joshua','(0101) 345 2627','faucibus@atpretiumaliquet.ca','125-5328 Elit, Ave','Vienna','Wie','Yemen','65553','semper cursus. Integer mollis. Integer tincidunt aliquam arcu.'),
('78','Daniel','070 6539 4824','erat.neque@ullamcorper.co.uk','P.O. Box 778, 3947 In Av.','Saint-Denis','IL','French Southern Territories','57865','placerat,'),
('79','Avram','055 0528 6976','nec@vitae.org','1182 Quisque Ave','Vienna','Wie','United States','77536','dignissim pharetra. Nam'),
('80','Jarrod','0845 46 49','elementum@utlacusNulla.com','186-734 Consectetuer Road','Aserrí','San José','Sudan','3938','massa. Suspendisse eleifend. Cras'),
('81','Chancellor','07299 706191','convallis@Sedmolestie.edu','P.O. Box 301, 2234 Tempor Rd.','Vienna','Wie','Tuvalu','6228','tristique senectus et netus et malesuada fames ac'),
('82','Grady','056 7648 9850','magna.Suspendisse.tristique@enimdiam.edu','P.O. Box 326, 7880 Aliquam Rd.','Marbella','AN','Lithuania','37','nibh. Phasellus nulla. Integer vulputate,'),
('83','Amal','0800 741 1981','Suspendisse.sagittis@Sedeget.org','Ap #183-2333 Ipsum. St.','Sikar','Rajasthan','Paraguay','71155','orci, consectetuer'),
('84','Brian','(0116) 378 4907','Donec.nibh@aenimSuspendisse.ca','756 Velit Road','San Vicente','SJ','Palau','68394','Phasellus nulla. Integer vulputate, risus a ultricies adipiscing, enim mi'),
('85','Colin','0800 1111','rutrum.magna.Cras@velsapienimperdiet.net','5798 Convallis Ave','Negrete','VII','Marshall Islands','74257','dolor vitae dolor. Donec fringilla. Donec feugiat metus sit'),
('86','Tarik','056 8022 8047','lorem.lorem.luctus@neque.com','P.O. Box 961, 4530 Turpis. St.','Tranås','Jönköpings län','Estonia','87848','odio tristique pharetra. Quisque ac libero nec ligula consectetuer'),
('87','Lev','07309 781187','Fusce.mollis@justonec.net','P.O. Box 642, 3421 Lacinia St.','Bremen','HB','Turks and Caicos Islands','84377','ac'),
('88','Camden','(013422) 65795','metus.Vivamus.euismod@hendrerit.co.uk','745-7943 Sollicitudin Rd.','Vreren','L.','Nepal','5918','sodales at,'),
('89','Wyatt','(016977) 2718','non.lacinia@orcilacus.co.uk','P.O. Box 489, 6490 Montes, Av.','Guadalupe','San José','Mauritania','53890','Sed dictum. Proin eget odio. Aliquam vulputate'),
('90','Ashton','0398 678 9642','velit.Cras@vestibulumloremsit.com','285-3442 Mi. Av.','Suwa?ki','PD','Croatia','0','Suspendisse'),
('91','Caldwell','0800 721798','Phasellus.ornare.Fusce@fermentum.com','198-3076 Viverra. Avenue','Vijayawada','Andhra Pradesh','Liechtenstein','6030','sem ut cursus luctus, ipsum leo'),
('92','Kato','07275 177771','risus.Nunc@justosit.com','P.O. Box 284, 5936 Eget Rd.','Belfast','U','Trinidad and Tobago','517699','Curabitur egestas nunc sed libero. Proin sed turpis nec'),
('93','Lucian','(0111) 611 6481','ac@ipsumnuncid.edu','7133 Vitae Rd.','St. Catharines','Ontario','Libya','0','nisl elementum purus, accumsan interdum libero dui'),
('94','Harper','(01517) 60951','mollis@scelerisqueduiSuspendisse.com','764-257 Integer Av.','Dubbo','New South Wales','Uruguay','7256','odio tristique pharetra.'),
('95','Sylvester','(016977) 4317','risus@Phasellus.co.uk','4635 At St.','Honolulu','HI','Togo','28317','bibendum'),
('96','Barrett','0500 296854','In@risusDuisa.co.uk','1675 Eget Rd.','Whyalla','SA','Italy','63509','nisl elementum'),
('97','Damon','(01642) 779083','Aenean.euismod.mauris@ac.net','P.O. Box 365, 9647 Rutrum St.','Hall in Tirol','Tyrol','Heard Island and Mcdonald Islands','3','scelerisque dui. Suspendisse ac metus vitae velit egestas lacinia. Sed'),
('98','Dustin','(0181) 285 3968','vestibulum@AliquamnislNulla.edu','Ap #602-9292 Enim St.','Puente Alto','Metropolitana de Santiago','Morocco','12121','luctus'),
('99','Carson','(0116) 768 2106','purus.Maecenas.libero@mollisneccursus.com','958-6104 Facilisi. Rd.','Huntly','North Island','Dominican Republic','44071','Aenean sed pede nec ante blandit viverra.'),
('100','Mason','0500 693253','feugiat@elita.edu','3538 Placerat Street','Gloucester','GL','Marshall Islands','35102','ultrices'),
('101','bob',NULL,'builder@gmail.com',NULL,NULL,NULL,NULL,'99423',NULL),
('102','bob',NULL,'builder@gmail.com',NULL,NULL,NULL,NULL,'99423',NULL),
('103','bob',NULL,'builder@gmail.com',NULL,NULL,NULL,NULL,'99423',NULL),
('104','bob',NULL,'builder@gmail.com',NULL,NULL,NULL,NULL,'99423',NULL),
('105','bob',NULL,'builder@gmail.com',NULL,NULL,NULL,NULL,'99423',NULL); 


DROP TABLE IF EXISTS `document`;
CREATE TABLE `document` (
  `document_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` longtext NOT NULL,
  `description` longtext NOT NULL,
  `file_name` longtext NOT NULL,
  `file_type` longtext NOT NULL,
  `class_id` longtext NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `timestamp` longtext NOT NULL,
  PRIMARY KEY (`document_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



DROP TABLE IF EXISTS `donation`;
CREATE TABLE `donation` (
  `donation_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL,
  `donation_amount` varchar(200) NOT NULL,
  `payment_mode` varchar(255) NOT NULL,
  PRIMARY KEY (`donation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



DROP TABLE IF EXISTS `dormitory`;
CREATE TABLE `dormitory` (
  `dormitory_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext NOT NULL,
  `number_of_room` longtext NOT NULL,
  `description` longtext NOT NULL,
  PRIMARY KEY (`dormitory_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



DROP TABLE IF EXISTS `employee`;
CREATE TABLE `employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `City` varchar(50) DEFAULT NULL,
  `State` varchar(50) DEFAULT NULL,
  `Zip` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=114 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `employee` VALUES ('8','Florence','Merrill','999 Eget Avenue','Pawtucket','AL','56012'),
('9','Vernonx','Klein','Ap #638-2444 Sem. Rd.','Wynne','VA','14715'),
('11','Susan','Floyd less','2138 Mauris Rd.','Kent ','SD','94619'),
('12','Ocean','Welch','Ap #328-4231 Aliquam Ave','Durango','MN','34848'),
('13','Olympia','Reid','Ap #119-6421 Vulputate St.','Laconia','AL','42649'),
('14','Leigh','Madden','1134 Commodo St.','Jeannette','IN','64702'),
('15','Jenna','Sims','Ap #188-3087 Semper Rd.','White Plains','CO','51000'),
('16','Marsden','Mcknight','891-2555 Ligula Av.','Peekskill','VT','38453'),
('17','Demetria','Mooney','Ap #400-7304 Vehicula Ave','Signal Hill','GA','32448'),
('18','April','Copeland','P.O. Box 940, 1713 Nunc Rd.','White Plains','CA','98831'),
('19','Jason','Hale','Ap #667-483 Vulputate, St.','Ventura','SC','09689'),
('20','Tana','Malone','640-9421 Arcu. Avenue','Modesto','CA','90815'),
('21','Dillon','Andrews','Ap #775-8997 Nunc Avenue','Juneau','GA','18307'),
('22','Stone','Kirkland','P.O. Box 686, 9425 Morbi Road','Colorado Springs','UT','93246'),
('23','Edward','Burton','5310 Vel, Avenue','Harrisburg','AK','15122'),
('24','Adam','Ramsey','6383 Euismod Road','Fulton','AZ','14148'),
('25','Serina','Randolph','Ap #832-9968 Cras Rd.','Baltimore','VT','02934'),
('26','Abraham','Beasley','1146 Scelerisque, Road','Pierre','WV','10668'),
('27','Kerry','Grant','P.O. Box 613, 193 Nullam St.','Bloomington','MN','59983'),
('28','Wyoming','Sullivan','9747 Volutpat Road','Auburn Hills','OR','85244'),
('29','Reese','Singleton','7322 Sagittis. Av.','Schaumburg','WY','97495'),
('30','Rosalyn','Spencer','P.O. Box 296, 6612 Est. Ave','Eatontown','WV','88032'),
('31','Shelby','Cohen','P.O. Box 196, 4793 Volutpat. Rd.','Basin','IA','03952'),
('32','Quinn','Wiley','P.O. Box 599, 2455 Accumsan Avenue','Centennial','SC','61389'),
('33','Kameko','Cox','181-6497 At Rd.','Nenana','AK','45163'),
('34','Brody','Mccarty','P.O. Box 588, 4717 Tellus. Street','Vicksburg','NJ','67362'),
('35','Lana','England','576-4991 Enim Av.','Johnstown','FL','72504'),
('36','Cassandra','Graves','1951 Turpis. Street','Dickinson','MS','14187'),
('37','Nicholas','Brock','222-910 Amet Rd.','Tonawanda','IA','04308'),
('38','Kuame','Huffman','793-1081 In, Av.','South El Monte','MA','80857'),
('39','Xenos','Clarke','437-3387 Arcu Road','Newburgh','NV','05780'),
('40','Cooper','Jensen','P.O. Box 138, 4309 Non Rd.','Opelousas','VA','93062'),
('41','Deacon','Tyson','156-1937 Ultrices Rd.','Spokane Valley','FL','76778'),
('42','Dawn','Potter','8472 Pellentesque Rd.','Chesapeake','OH','66729'),
('43','Zane','Calderon','739-7377 Nascetur Rd.','Elsmere','VA','62940'),
('44','Cecilia','Carney','3243 Lorem Ave','Shawnee','NM','22241'),
('45','Connor','Marquez','5263 Purus Ave','Lockport','ID','40334'),
('46','Gillian','Kirk','P.O. Box 570, 1525 Magna Av.','Ada','CT','30771'),
('47','Wallace','Gillespie','550-2279 Tellus, Ave','Missoula','WA','96349'),
('48','Risa','Ayers','Ap #948-9845 Mi Avenue','Pass Christian','OH','72881'),
('49','Callum','Solomon','178-516 Ultrices. Rd.','Fall River','MD','03691'),
('50','Nola','Rojas','Ap #185-9503 Sed Street','Juneau','NH','77099'),
('51','Talon','Rowland','4575 Massa. Street','Marquette','IN','37429'),
('52','Cheryl','Bowers','1348 Ut Rd.','Hutchinson','IL','44144'),
('53','Bree','Gaines','Ap #190-9800 Facilisi. Rd.','Bowling Green','ME','62391'),
('54','Lacota','Bonner','3229 Felis. St.','Jenks','DE','54999'),
('55','Bradley','Freeman','2339 Sit Rd.','New Orleans','WY','83323'),
('56','Jasper','Santiago','2990 Malesuada Rd.','Williamsport','IL','00409'),
('57','Hilary','Conner','2000 Diam. Rd.','Roanoke','MN','50683'),
('58','Zena','Fox','9604 Dolor Road','Palm Springs','WA','93143'),
('59','Britanni','Schmidt','485-6357 Dictum Road','Bradbury','VT','48121'),
('60','Caleb','Lynn','Ap #318-2121 Sapien Rd.','Kettering','MS','74815'),
('61','Madeson','Robbins','P.O. Box 690, 861 Magna. Avenue','Bismarck','MN','37748'),
('62','Emily','Richmond','P.O. Box 629, 2724 Velit. Av.','Las Cruces','VA','34490'),
('63','Damian','Wilson','Ap #209-5365 Pulvinar Road','Boulder','ND','37920'),
('64','Mikayla','Mendez','P.O. Box 244, 1762 Libero. Ave','Buffalo','SD','28431'),
('65','Igor','Gutierrez','192-1646 Hendrerit. St.','Chicopee','CT','94701'),
('66','Heather','Terrell','P.O. Box 107, 7190 Augue, Rd.','Statesboro','MI','36440'),
('67','Rose','Barry','P.O. Box 358, 4774 Sagittis Street','Fairmont','UT','37251'),
('68','Bernard','Gilmore','546-292 Venenatis St.','Sandpoint','OH','35643'),
('69','Meghan','Mack','1845 Consectetuer Av.','Blacksburg','OH','09551'),
('70','Lillith','Terrell','P.O. Box 495, 7797 Leo. Ave','Augusta','DE','44898'),
('71','Jaquelyn','James','795-3722 Lectus. Street','Alpharetta','WI','91617'),
('72','Karly','Beard','370-8115 Mus. Ave','Norfolk','GA','78062'),
('73','Kareem','Cooke','9070 Ante, Av.','Somersworth','WA','87594'),
('74','Amethyst','Bass','Ap #387-6244 Malesuada Av.','Clarksville','NE','24386'),
('75','Silas','Bates','P.O. Box 220, 5319 Faucibus Ave','West Lafayette','OH','49890'),
('76','Sybil','Watts','502-6016 Ultrices, Road','Santa Clarita','AK','42911'),
('77','Warren','Hays','Ap #387-9280 Dui, Avenue','Dover','PA','75674'),
('78','Kirsten','Martin','P.O. Box 548, 6344 Sit Av.','Benton Harbor','MD','65775'),
('79','Cade','Lowe','4356 Lorem, Ave','Valdez','NM','37102'),
('80','Penelope','Moss','Ap #705-2124 Phasellus Rd.','Reedsport','AK','74040'),
('81','Chase','Andrews','9353 Rutrum Av.','Salt Lake City','MO','89592'),
('82','Fatima','Mcconnell','P.O. Box 144, 1027 Aliquam Avenue','Yazoo City','CT','84334'),
('83','Kelly','Garcia','P.O. Box 902, 1916 Vel, Road','Plymouth','AK','91414'),
('84','Aubrey','Leblanc','Ap #479-3210 Magnis Street','Phoenix','MD','89834'),
('85','Cassidy','Dyer','P.O. Box 169, 959 Et, Road','Clarksville','NY','71212'),
('86','Rina','Lawrence','8469 Eu Road','Berkeley','KY','14459'),
('87','Malcolm','Richard','8826 Erat St.','Boston','CA','22844'),
('88','Avye','Fowler','Ap #942-4652 Aliquam Rd.','Roseville','IN','43892'),
('89','Jeremy','Randolph','Ap #939-5888 Mollis. Rd.','Rolling Hills Estates','MI','72412'),
('90','Ray','Clayton','P.O. Box 422, 2469 Curabitur Rd.','Hope','IN','64889'),
('91','Lynn','Turner','249 Sed Street','Austin','IN','05518'),
('92','Eric','Guzman','173-245 Arcu. Ave','Temecula','LA','91680'),
('93','Daphne','Preston','Ap #542-5775 Nibh Rd.','Sun Valley','TN','31014'),
('94','Ivy','Vazquez','P.O. Box 292, 8217 Vel Avenue','Half Moon Bay','TX','92194'),
('95','Teegan','Jimenez','5503 Odio, Rd.','GuÃ¡nica','SC','12336'),
('96','Quemby','Floyd','200-5264 Laoreet Ave','Orangeburg','WI','93197'),
('97','Aristotle','Harris','348-9080 Ultrices Rd.','Cheyenne','MA','74732'),
('98','avel','Floyd','502-9689 Ante Street','Hartland','NV','81261'),
('99','Liberty','Gomez','Ap #685-1260 Velit Avenue','Baltimore','SC','21141'),
('100','Ivy','Hebert','4393 Sodales Av.','Des Moines','MD','25787'),
('101','adan ','rivera','ad','heredia','he','1'),
('110','segdsf','dgsdfgs','dfgsdfgsdfg','sdfgsdfg','mo','12312'); 


DROP TABLE IF EXISTS `empsalary`;
CREATE TABLE `empsalary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Department` varchar(255) DEFAULT NULL,
  `Salary` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=101 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `empsalary` VALUES ('1','Sales and Marketing','281'),
('2','Legal Department','737'),
('3','Tech Support','808'),
('4','Sales and Marketing','670'),
('5','Asset Management','937'),
('6','Asset Management','581'),
('7','Payroll','621'),
('8','Advertising','919'),
('9','Quality Assurance','717'),
('10','Quality Assurance','875'),
('11','Public Relations','554'),
('12','Legal Department','775'),
('13','Payroll','434'),
('14','Public Relations','765'),
('15','Public Relations','667'),
('16','Human Resources','339'),
('17','Quality Assurance','691'),
('18','Asset Management','970'),
('19','Tech Support','849'),
('20','Asset Management','935'),
('21','Customer Relations','463'),
('22','Sales and Marketing','981'),
('23','Media Relations','906'),
('24','Asset Management','842'),
('25','Asset Management','339'),
('26','Payroll','241'),
('27','Media Relations','946'),
('28','Asset Management','510'),
('29','Tech Support','855'),
('30','Research and Development','401'),
('31','Accounting','576'),
('32','Legal Department','758'),
('33','Customer Service','996'),
('34','Accounting','597'),
('35','Customer Service','823'),
('36','Payroll','973'),
('37','Asset Management','427'),
('38','Human Resources','739'),
('39','Tech Support','960'),
('40','Asset Management','485'),
('41','Public Relations','777'),
('42','Accounting','807'),
('43','Tech Support','283'),
('44','Human Resources','216'),
('45','Public Relations','327'),
('46','Quality Assurance','586'),
('47','Research and Development','717'),
('48','Advertising','472'),
('49','Customer Service','938'),
('50','Accounting','309'),
('51','Sales and Marketing','751'),
('52','Media Relations','278'),
('53','Quality Assurance','355'),
('54','Media Relations','827'),
('55','Customer Relations','257'),
('56','Asset Management','247'),
('57','Customer Service','525'),
('58','Accounting','664'),
('59','Customer Service','260'),
('60','Finances','395'),
('61','Sales and Marketing','296'),
('62','Media Relations','847'),
('63','Quality Assurance','993'),
('64','Payroll','732'),
('65','Human Resources','263'),
('66','Human Resources','804'),
('67','Advertising','502'),
('68','Legal Department','571'),
('69','Advertising','266'),
('70','Finances','979'),
('71','Accounting','655'),
('72','Finances','944'),
('73','Customer Relations','399'),
('74','Public Relations','241'),
('75','Research and Development','858'),
('76','Human Resources','577'),
('77','Customer Service','810'),
('78','Sales and Marketing','482'),
('79','Media Relations','390'),
('80','Quality Assurance','247'),
('81','Customer Service','258'),
('82','Human Resources','382'),
('83','Research and Development','636'),
('84','Sales and Marketing','261'),
('85','Public Relations','984'),
('86','Quality Assurance','852'),
('87','Sales and Marketing','557'),
('88','Legal Department','271'),
('89','Public Relations','684'),
('90','Legal Department','920'),
('91','Payroll','293'),
('92','Customer Relations','979'),
('93','Payroll','983'),
('94','Advertising','573'),
('95','Finances','868'),
('96','Research and Development','643'),
('97','Media Relations','220'),
('98','Media Relations','903'),
('99','Accounting','963'),
('100','Research and Development','488'); 


DROP TABLE IF EXISTS `event`;
CREATE TABLE `event` (
  `event_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `event_title` varchar(250) NOT NULL,
  `event_location` text NOT NULL,
  `event_date_and_time` date NOT NULL,
  `description_of_event` varchar(250) NOT NULL,
  `link_to_url/website` varchar(255) NOT NULL,
  `include_youtube_video` varchar(255) NOT NULL,
  `event_image` varchar(255) NOT NULL,
  `no_of_tickets` varchar(200) NOT NULL,
  `cost_per_ticket` varchar(200) NOT NULL,
  `first_name` varchar(250) NOT NULL,
  `last_name` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `phone` varchar(250) NOT NULL,
  `paypal_account` varchar(255) NOT NULL,
  `paypal_currency` varchar(255) NOT NULL,
  `voucher_code` varchar(250) NOT NULL,
  `ZIP` varchar(200) NOT NULL,
  `city` varchar(200) NOT NULL,
  `state` varchar(200) NOT NULL,
  `country` varchar(200) NOT NULL,
  `event_laguage_option` varchar(200) NOT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `event` VALUES ('14','df','fff','2016-08-17','dff','dfsf','fsdf','fdf','dfdf','dff','ff','dfd','ff@j.vom','dfdf','fdfds','fdsf','Fdsf','','1','1','1','0,1,2'),
('15','gvv','vv','2016-08-10','vv','vv','vv','1472215796Desired Output (Edit).docx','vv','vv','vv','vv','ff@j.vom','gfg','fgfg','fdgdf','g4543','','1','1','1','0,1'),
('16','hh','hhh','2016-08-09','hh','hh','hh','1472288950export1.png','55','55','fdg','gfg','g@g.b','6565','fg','fg','566','','2','1','1','0,1'),
('17','=','=','0000-00-00','=','==http://www.s-pravami.com/kupit-prava-na-lodku/ ','','','==8429','','==winue','winueTD','=idristimll@list.ru','=88325525479','=','','winue','','==','=3','==4','[]=4'); 


DROP TABLE IF EXISTS `eventtable`;
CREATE TABLE `eventtable` (
  `event_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `event_title` varchar(250) NOT NULL,
  `event_location` varchar(250) NOT NULL,
  `event_date_and_time` date NOT NULL,
  `event_end_date_time` date NOT NULL,
  `description_of_event` varchar(250) NOT NULL,
  `link_to_url/website` varchar(255) NOT NULL,
  `include_youtube_video` varchar(255) NOT NULL,
  `event_image` varchar(255) NOT NULL,
  `no._of_tickets` varchar(200) NOT NULL,
  `cost_per_ticket` varchar(200) NOT NULL,
  `first_name` varchar(250) NOT NULL,
  `last_name` varchar(250) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `paypal_account` varchar(255) NOT NULL,
  `paypal_currency` varchar(255) NOT NULL,
  `voucher_code` varchar(250) NOT NULL,
  `telephone/mobile` varchar(250) NOT NULL,
  `ZIP` varchar(200) NOT NULL,
  `city` varchar(200) NOT NULL,
  `state` varchar(200) NOT NULL,
  `country` varchar(200) NOT NULL,
  `event_laguage_option` varchar(200) NOT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `eventtable` VALUES ('1','birthday','home','2017-05-31','2017-05-31','birthday','','','','','','','','','','','','','','','','',''),
('2','marriage','garden','2017-05-18','2017-05-31','','','','','','','','','','','','','','','','','',''); 


DROP TABLE IF EXISTS `exam`;
CREATE TABLE `exam` (
  `exam_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext NOT NULL,
  `date` longtext NOT NULL,
  `comment` longtext NOT NULL,
  PRIMARY KEY (`exam_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



DROP TABLE IF EXISTS `expense_category`;
CREATE TABLE `expense_category` (
  `expense_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext NOT NULL,
  `amount` float NOT NULL,
  PRIMARY KEY (`expense_category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `expense_category` VALUES ('1','Teacher Salary','100'),
('2','Classroom Equipments','200'),
('3','Classroom Decorations','300'),
('4','Inventory Purchase','400'),
('5','Exam Accessories','500'); 


DROP TABLE IF EXISTS `feedback`;
CREATE TABLE `feedback` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `products_quality_rating` varchar(250) NOT NULL,
  `products_interested` varchar(250) NOT NULL,
  `service_satisfaction` varchar(250) NOT NULL,
  `recommendation` varchar(250) NOT NULL,
  `how_long_have_you_been_a_customer_of_our_company` varchar(250) NOT NULL,
  `comments` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `feedback` VALUES ('1','Jon','snow','builder@gmail.com','7894561230','','','0','','','hello'),
('2','gg','gg','gg@h.bon','8647534','','','0','','','fgdfgdfg'),
('3','uu','uu','uu@g','5446','','','0','','','vgfgdfg'),
('4','uu','uu','uu@g','5446','','','2','','','vgfgdfg'); 


DROP TABLE IF EXISTS `field_types`;
CREATE TABLE `field_types` (
  `field_id` int(11) NOT NULL,
  `int_field` int(11) NOT NULL,
  `float_field` float NOT NULL,
  `double_field` double NOT NULL,
  `text_varchar` varchar(100) NOT NULL,
  `textarea_text` text NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `datetime` datetime NOT NULL,
  `enum` enum('Option 1','Option 2','Option 3','Option 4') NOT NULL,
  `set` set('Option 1','Option 2','Option 3','Option 4') NOT NULL,
  `first_name` text NOT NULL,
  `password` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



DROP TABLE IF EXISTS `flight_booking`;
CREATE TABLE `flight_booking` (
  `booking_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `type` varchar(100) NOT NULL,
  `city/airport_from` varchar(200) NOT NULL,
  `city/airport_to` varchar(200) NOT NULL,
  `depart_on` date NOT NULL,
  `return_on` date NOT NULL,
  `class` varchar(100) NOT NULL,
  `adults` int(10) NOT NULL,
  `children` int(10) NOT NULL,
  `senior` int(10) NOT NULL,
  `person` varchar(50) NOT NULL,
  PRIMARY KEY (`booking_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



DROP TABLE IF EXISTS `grade`;
CREATE TABLE `grade` (
  `grade_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext NOT NULL,
  `grade_point` longtext NOT NULL,
  `mark_from` int(11) NOT NULL,
  `mark_upto` int(11) NOT NULL,
  `comment` longtext NOT NULL,
  PRIMARY KEY (`grade_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



DROP TABLE IF EXISTS `gym_membership`;
CREATE TABLE `gym_membership` (
  `membership_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `membership_person_wise` varchar(255) NOT NULL,
  `member_type` varchar(200) NOT NULL,
  `full_name` varchar(200) NOT NULL,
  `gender` varchar(150) NOT NULL,
  `age` varchar(20) NOT NULL,
  `email` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `designation` varchar(200) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  PRIMARY KEY (`membership_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `gym_membership` VALUES ('2','0,1','0','dvcv','0','45','gf@h.no','856856','nhfgh','gdfg','fgdfg','gfg','gdfg'),
('5','0','0','tt','0','tt','tt@g.com','5687698796','gdfg','tt','tt','tt','tt'); 


DROP TABLE IF EXISTS `hobbies`;
CREATE TABLE `hobbies` (
  `hobby_id` int(11) NOT NULL,
  `hobby_name` varchar(200) NOT NULL,
  `hobby_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `hobbies` VALUES ('1','Sports','1'),
('2','Reading','1'),
('3','Dance','1'),
('4','Watching Movies','1'),
('5','Travelling','1'); 


DROP TABLE IF EXISTS `invoice`;
CREATE TABLE `invoice` (
  `invoice_id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `title` longtext NOT NULL,
  `description` longtext NOT NULL,
  `amount` int(11) NOT NULL,
  `amount_paid` longtext NOT NULL,
  `due` longtext NOT NULL,
  `creation_timestamp` int(11) NOT NULL,
  `payment_timestamp` longtext NOT NULL,
  `payment_method` longtext NOT NULL,
  `payment_details` longtext NOT NULL,
  `status` longtext NOT NULL COMMENT 'paid or unpaid',
  PRIMARY KEY (`invoice_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



DROP TABLE IF EXISTS `jm_users`;
CREATE TABLE `jm_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(400) NOT NULL DEFAULT '',
  `username` varchar(150) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(100) NOT NULL DEFAULT '',
  `block` tinyint(4) NOT NULL DEFAULT 0,
  `sendEmail` tinyint(4) DEFAULT 0,
  `registerDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lastvisitDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `activation` varchar(100) NOT NULL DEFAULT '',
  `params` text NOT NULL,
  `lastResetTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Date of last password reset',
  `resetCount` int(11) NOT NULL DEFAULT 0 COMMENT 'Count of password resets since lastResetTime',
  `otpKey` varchar(1000) NOT NULL DEFAULT '' COMMENT 'Two factor authentication encrypted keys',
  `otep` varchar(1000) NOT NULL DEFAULT '' COMMENT 'One time emergency passwords',
  `requireReset` tinyint(4) NOT NULL DEFAULT 0 COMMENT 'Require user to reset password on next login',
  `user_image` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_name` (`name`(100)),
  KEY `idx_block` (`block`),
  KEY `username` (`username`),
  KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `jm_users` VALUES ('1','','test','','','0','0','0000-00-00 00:00:00','0000-00-00 00:00:00','','','0000-00-00 00:00:00','0','','','0','http://artify.com/script/uploads/1481931260_parte1.jpg'),
('2','','sdsqDQ','','','0','0','0000-00-00 00:00:00','0000-00-00 00:00:00','','','0000-00-00 00:00:00','0','','','0','http://artify.com/script/uploads/1482153211_monte-melqonyani-ynt-na88597.1.jpg'),
('3','','azerty','','','0','0','0000-00-00 00:00:00','0000-00-00 00:00:00','','','0000-00-00 00:00:00','0','','','0','1472896582icone_site.png'),
('4','','111','','','0','0','0000-00-00 00:00:00','0000-00-00 00:00:00','','','0000-00-00 00:00:00','0','','','0','1473306357a1.jpg'),
('5','','jj','','','0','0','0000-00-00 00:00:00','0000-00-00 00:00:00','','','0000-00-00 00:00:00','0','','','0','1473706378aus.jpg'),
('6','','jj','','','0','0','0000-00-00 00:00:00','0000-00-00 00:00:00','','','0000-00-00 00:00:00','0','','','0','1473706381aus.jpg'),
('7','','dddd','','','0','0','0000-00-00 00:00:00','0000-00-00 00:00:00','','','0000-00-00 00:00:00','0','','','0','1473754742temp.jpg'),
('8','','Test','','','0','0','0000-00-00 00:00:00','0000-00-00 00:00:00','','','0000-00-00 00:00:00','0','','','0',''),
('9','','Test','','','0','0','0000-00-00 00:00:00','0000-00-00 00:00:00','','','0000-00-00 00:00:00','0','','','0','http://artify.com/script/uploads/1481663564_Imatge_Breu Presentacio.jpg'),
('10','','asdasdas','','','0','0','0000-00-00 00:00:00','0000-00-00 00:00:00','','','0000-00-00 00:00:00','0','','','0','http://localhost:81/artify/script/uploads/1556534188_aVqGmby_700b_v1.jpg'),
('11','','ssdfsdf','','','0','0','0000-00-00 00:00:00','0000-00-00 00:00:00','','','0000-00-00 00:00:00','0','','','0',''),
('12','','assd','','','0','0','0000-00-00 00:00:00','0000-00-00 00:00:00','','','0000-00-00 00:00:00','0','','','0',''),
('13','','assd','','','0','0','0000-00-00 00:00:00','0000-00-00 00:00:00','','','0000-00-00 00:00:00','0','','','0','http://artify.com/script/uploads/1481797254_zebravett.png'),
('14','','dsfsdf','','','0','0','0000-00-00 00:00:00','0000-00-00 00:00:00','','','0000-00-00 00:00:00','0','','','0','http://artify.com/script/uploads/1481890247_Untitled.jpg'),
('15','','test','','','0','0','0000-00-00 00:00:00','0000-00-00 00:00:00','','','0000-00-00 00:00:00','0','','','0','http://artify.com/script/uploads/1482006408_2.png'); 


DROP TABLE IF EXISTS `job`;
CREATE TABLE `job` (
  `job_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `job_title` varchar(200) NOT NULL,
  `job_description` text NOT NULL,
  `salary_range` varchar(200) NOT NULL,
  `expiration_date` date NOT NULL,
  PRIMARY KEY (`job_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



DROP TABLE IF EXISTS `job_application`;
CREATE TABLE `job_application` (
  `application_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(200) NOT NULL,
  `state` varchar(200) NOT NULL,
  `country` varchar(200) NOT NULL,
  `zip/pin_code` varchar(100) NOT NULL,
  `education` varchar(200) NOT NULL,
  `resume` varchar(255) NOT NULL,
  `comments` varchar(255) NOT NULL,
  PRIMARY KEY (`application_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `job_application` VALUES ('1','k','j','2016-09-02','test@test.com','9999999999','m','789 far road','tou','NB','Sweden','07978','BA','life','testin'); 


DROP TABLE IF EXISTS `language`;
CREATE TABLE `language` (
  `phrase_id` int(11) NOT NULL AUTO_INCREMENT,
  `phrase` longtext NOT NULL,
  `english` longtext NOT NULL,
  `bengali` longtext NOT NULL,
  `spanish` longtext NOT NULL,
  `arabic` longtext NOT NULL,
  `dutch` longtext NOT NULL,
  `russian` longtext NOT NULL,
  `chinese` longtext NOT NULL,
  `turkish` longtext NOT NULL,
  `portuguese` longtext NOT NULL,
  `hungarian` longtext NOT NULL,
  `french` longtext NOT NULL,
  `greek` longtext NOT NULL,
  `german` longtext NOT NULL,
  `italian` longtext NOT NULL,
  `thai` longtext NOT NULL,
  `urdu` longtext NOT NULL,
  `hindi` longtext NOT NULL,
  `latin` longtext NOT NULL,
  `indonesian` longtext NOT NULL,
  `japanese` longtext NOT NULL,
  `korean` longtext NOT NULL,
  PRIMARY KEY (`phrase_id`)
) ENGINE=MyISAM AUTO_INCREMENT=372 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `language` VALUES ('1','login','login','লগইন','login','دخول','login','Войти','注册','giriş','login','bejelentkezés','Connexion','σύνδεση','Login','login','เข้าสู่ระบบ','لاگ ان','लॉगिन','login','login','ログイン','로그인'),
('2','account_type','account type','অ্যাকাউন্ট টাইপ','tipo de cuenta','نوع الحساب','type account','тип счета','账户类型','hesap türü','tipo de conta','fiók típusát','Type de compte','τον τύπο του λογαριασμού','Kontotyp','tipo di account','ประเภทบัญชี','اکاؤنٹ کی قسم','खाता प्रकार','propter speciem','Jenis akun','口座の種類','계정 유형'),
('3','admin','admin','অ্যাডমিন','administración','مشرف','admin','админ','管理','yönetim','administrador','admin','administrateur','το admin','Admin','Admin','ผู้ดูแลระบบ','منتظم','प्रशासन','Lorem ipsum dolor sit','admin','管理者','관리자'),
('4','teacher','teacher','শিক্ষক','profesor','معلم','leraar','учитель','老师','öğretmen','professor','tanár','professeur','δάσκαλος','Lehrer','insegnante','ครู','استاد','शिक्षक','Magister','guru','教師','선생'),
('5','student','student','ছাত্র','estudiante','طالب','student','студент','学生','öğrenci','estudante','diák','étudiant','φοιτητής','Schüler','studente','นักเรียน','طالب علم','छात्र','discipulo','mahasiswa','学生','학생'),
('6','parent','parent','পিতা বা মাতা','padre','أصل','ouder','родитель','亲','ebeveyn','parente','szülő','mère','μητρική εταιρεία','Elternteil','genitore','ผู้ปกครอง','والدین','माता - पिता','parente','induk','親','부모의'),
('7','email','email','ইমেইল','email','البريد الإلكتروني','e-mail','по электронной почте','电子邮件','E-posta','e-mail','E-mail','email','e-mail','E-Mail-','e-mail','อีเมล์','ای میل','ईमेल','email','email','メール','이메일'),
('8','password','password','পাসওয়ার্ড','contraseña','كلمة السر','wachtwoord','пароль','密码','şifre','senha','jelszó','mot de passe','τον κωδικό','Passwort','password','รหัสผ่าน','پاس','पासवर्ड','Signum','kata sandi','パスワード','암호'),
('9','forgot_password ?','forgot password ?','পাসওয়ার্ড ভুলে গেছেন?','¿Olvidó su contraseña?','نسيت كلمة المرور؟','wachtwoord vergeten?','забыли пароль?','忘记密码？','Şifremi unuttum?','Esqueceu a senha?','Elfelejtett jelszó?','Mot de passe oublié?','Ξεχάσατε τον κωδικό;','Passwort vergessen?','dimenticato la password?','ลืมรหัสผ่าน','پاس ورڈ بھول گیا؟','क्या संभावनाएं हैं?','oblitus esne verbi?','lupa password?','パスワードを忘れた？','비밀번호를 잊으 셨나요?'),
('10','reset_password','reset password','পাসওয়ার্ড রিসেট','restablecer la contraseña','إعادة تعيين كلمة المرور','reset wachtwoord','сбросить пароль','重设密码','şifrenizi sıfırlamak','redefinir a senha','Jelszó visszaállítása','réinitialiser le mot de passe','επαναφέρετε τον κωδικό πρόσβασης','Kennwort zurücksetzen','reimpostare la password','ตั้งค่ารหัสผ่าน','پاس ورڈ ری سیٹ','पासवर्ड रीसेट','Duis adipiscing','reset password','パスワードを再設定する','암호를 재설정'),
('11','reset','reset','রিসেট করুন','reajustar','إعادة تعيين','reset','сброс','重置','ayarlamak','restabelecer','vissza','remettre','επαναφορά','rücksetzen','reset','ตั้งใหม่','ری سیٹ','रीसेट करें','Duis','ulang','リセット','재설정'),
('12','admin_dashboard','admin dashboard','অ্যাডমিন ড্যাশবোর্ড','administrador salpicadero','المشرف وحة القيادة','admin dashboard','админ панель','管理面板','Admin paneli','Admin Dashboard','admin műszerfal','administrateur tableau de bord','πίνακα ελέγχου του διαχειριστή','Admin-Dashboard','Admin Dashboard','แผงควบคุมของผู้ดูแลระบบ','ایڈمن ڈیش بورڈ','व्यवस्थापक डैशबोर्ड','Lorem ipsum dolor sit Dashboard','admin dashboard','管理ダッシュボード','관리자 대시 보드'),
('13','account','account','হিসাব','cuenta','حساب','rekening','счет','帐户','hesap','conta','számla','compte','λογαριασμός','Konto','conto','บัญชี','اکاؤنٹ','खाता','propter','rekening','アカウント','계정'),
('14','profile','profile','পরিলেখ','perfil','ملف','profiel','профиль','轮廓','profil','perfil','profil','profil','προφίλ','Profil','profilo','โปรไฟล์','پروفائل','रूपरेखा','profile','profil','プロフィール','프로필'),
('15','change_password','change password','পাসওয়ার্ড পরিবর্তন','cambiar la contraseña','تغيير كلمة المرور','wachtwoord wijzigen','изменить пароль','更改密码','şifresini değiştirmek','alterar a senha','jelszó megváltoztatása','changer le mot de passe','αλλάξετε τον κωδικό πρόσβασης','Kennwort ändern','cambiare la password','เปลี่ยนรหัสผ่าน','پاس ورڈ تبدیل','पासवर्ड परिवर्तित','mutare password','mengubah password','パスワードを変更する','암호를 변경'),
('16','logout','logout','লগ আউট','logout','تسجيل الخروج','logout','выход','注销','logout','Sair','logout','Déconnexion','αποσύνδεση','logout','Esci','ออกจากระบบ','لاگ آؤٹ کریں','लॉगआउट','logout','logout','ログアウト','로그 아웃'),
('17','panel','panel','প্যানেল','panel','لوحة','paneel','панель','面板','panel','painel','bizottság','panneau','πίνακας','Platte','pannello','แผงหน้าปัด','پینل','पैनल','panel','panel','パネル','패널'),
('18','dashboard_help','dashboard help','ড্যাশবোর্ড সহায়তা','salpicadero ayuda','لوحة القيادة مساعدة','dashboard hulp','Приборная панель помощь','仪表板帮助','pano yardım','dashboard ajuda','műszerfal help','tableau de bord aide','ταμπλό βοήθεια','Dashboard-Hilfe','dashboard aiuto','แผงควบคุมความช่วยเหลือ','ڈیش بورڈ مدد','डैशबोर्ड मदद','Dashboard auxilium','dashboard bantuan','ダッシュボードヘルプ','대시 보드 도움말'),
('19','dashboard','dashboard','ড্যাশবোর্ড','salpicadero','لوحة القيادة','dashboard','приборная панель','仪表盘','gösterge paneli','painel de instrumentos','műszerfal','tableau de bord','ταμπλό','Armaturenbrett','cruscotto','หน้าปัด','ڈیش بورڈ','डैशबोर्ड','Dashboard','dasbor','ダッシュボード','계기판'),
('20','student_help','student help','শিক্ষার্থীর সাহায্য','ayuda estudiantil','مساعدة الطالب','student hulp','студент помощь','学生的帮助','Öğrenci yardım','ajuda estudante','diák segítségével','aide aux étudiants','φοιτητής βοήθεια','Schüler-Hilfe','help studente','ช่วยเหลือนักเรียน','طالب علم کی مدد','छात्र मदद','Discipulus auxilium','membantu siswa','学生のヘルプ','학생 도움말'),
('21','teacher_help','teacher help','শিক্ষক সাহায্য','ayuda del maestro','مساعدة المعلم','leraar hulp','Учитель помощь','老师的帮助','öğretmen yardım','ajuda de professores','tanár segítségével','aide de l\'enseignant','βοήθεια των εκπαιδευτικών','Lehrer-Hilfe','aiuto dell\'insegnante','ครูช่วยเหลือ','استاد کی مدد','शिक्षक मदद','doctor auxilium','bantuan guru','教師のヘルプ','교사의 도움'),
('22','subject_help','subject help','বিষয় সাহায্য','ayuda sujeto','مساعدة الموضوع','Onderwerp hulp','Заголовок помощь','主题帮助','konusu yardım','ajuda assunto','tárgy segítségével','l\'objet de l\'aide','υπόκεινται βοήθεια','Thema Hilfe','Aiuto Subject','ความช่วยเหลือเรื่อง','موضوع مدد','विषय मदद','agitur salus','bantuan subjek','件名ヘルプ','주제 도움'),
('23','subject','subject','বিষয়','sujeto','موضوع','onderwerp','тема','主题','konu','assunto','tárgy','sujet','θέμα','Thema','soggetto','เรื่อง','موضوع','विषय','agitur','subyek','テーマ','제목'),
('24','class_help','class help','বর্গ সাহায্য','clase de ayuda','الطبقة مساعدة','klasse hulp','Класс помощь','类的帮助','sınıf yardım','classe ajuda','osztály segítségével','aide de la classe','Κατηγορία βοήθεια','Klasse Hilfe','help classe','ความช่วยเหลือในชั้นเรียน','کلاس مدد','कक्षा मदद','genus auxilii','kelas bantuan','クラスのヘルプ','클래스 도움'),
('25','class','class','বর্গ','clase','فئة','klasse','класс','类','sınıf','classe','osztály','classe','κατηγορία','Klasse','classe','ชั้น','کلاس','वर्ग','class','kelas','クラス','클래스'),
('26','exam_help','exam help','পরীক্ষায় সাহায্য','ayuda examen','امتحان مساعدة','examen hulp','Экзамен помощь','考试帮助','sınav yardım','exame ajuda','vizsga help','aide à l\'examen','εξετάσεις βοήθεια','Prüfung Hilfe','esame di guida','การสอบความช่วยเหลือ','امتحان مدد','परीक्षा मदद','ipsum Auxilium','ujian bantuan','試験ヘルプ','시험에 도움'),
('27','exam','exam','পরীক্ষা','examen','امتحان','tentamen','экзамен','考试','sınav','exame','vizsgálat','exam','εξέταση','Prüfung','esame','การสอบ','امتحان','परीक्षा','Lorem ipsum','ujian','試験','시험'),
('28','marks_help','marks help','চিহ্ন সাহায্য','marcas ayudan','علامات مساعدة','markeringen helpen','метки помогают','标记帮助','işaretleri yardım','marcas ajudar','jelek segítenek','marques aident','σήματα βοηθήσει','Markierungen helfen','segni aiutano','เครื่องหมายช่วย','نمبر مدد','निशान मदद','notas auxilio','tanda membantu','マークのヘルプ','마크는 데 도움이'),
('29','marks-attendance','marks-attendance','চিহ্ন-উপস্থিতির','marcas-asistencia','علامات-الحضور','merken-deelname','знаки-посещаемости','标记缺席','işaretleri-katılım','marcas de comparecimento','jelek-ellátás','marques-participation','σήματα προσέλευση','Marken-Teilnahme','marchi-presenze','เครื่องหมายการเข้าร่วม','نمبر حاضری','निशान उपस्थिति','signa eius ministrabant,','tanda-pertemuan','マーク·出席','마크 출석'),
('30','grade_help','grade help','গ্রেড সাহায্য','ayuda de grado','مساعدة الصف','leerjaar hulp','оценка помощь','级帮助','sınıf yardım','ajuda grau','fokozat help','aide de qualité','βαθμού βοήθεια','Grade-Hilfe','aiuto grade','ช่วยเหลือเกรด','گریڈ مدد','ग्रेड मदद','gradus ope','kelas bantuan','グレードのヘルプ','급 도움'),
('31','exam-grade','exam-grade','পরীক্ষার শ্রেণী','examen de grado','امتحان الصف','examen-grade','экзамен класса','考试级别','sınav notu','exame de grau','vizsga-grade','examen de qualité','εξετάσεις ποιότητας','Prüfung-Grade','esami-grade','สอบเกรด','امتحان گریڈ','परीक्षा ग्रेड','ipsum turpis,','ujian-grade','試験グレード','시험 등급'),
('32','class_routine_help','class routine help','ক্লাসের রুটিন সাহায্য','clase ayuda rutina','الطبقة مساعدة روتينية','klasroutine hulp','класс рутина помощь','类常规帮助','sınıf rutin yardım','classe ajuda rotina','osztály rutin segít','classe aide routine','κατηγορία ρουτίνας βοήθεια','Klasse Routine Hilfe','Classe aiuto di routine','ระดับความช่วยเหลือตามปกติ','کلاس معمول مدد','वर्ग दिनचर्या मदद','uno genere auxilium','kelas bantuan rutin','クラスルーチンのヘルプ','클래스 루틴 도움'),
('33','class_routine','class routine','ক্লাসের রুটিন','rutina de la clase','فئة الروتينية','klasroutine','класс подпрограмм','常规类','sınıf rutin','rotina classe','osztály rutin','routine de classe','Κατηγορία ρουτίνα','Klasse Routine','classe di routine','ประจำชั้น','کلاس معمول','वर्ग दिनचर्या','in genere uno,','rutin kelas','クラス·ルーチン','클래스 루틴'),
('34','invoice_help','invoice help','চালান সাহায্য','ayuda factura','مساعدة الفاتورة','factuur hulp','счет-фактура помощь','发票帮助','fatura yardım','ajuda factura','számla segítségével','aide facture','τιμολόγιο βοήθεια','Rechnungs Hilfe','help fattura','ช่วยเหลือใบแจ้งหนี้','انوائس مدد','चालान सहायता','auxilium cautionem','bantuan faktur','送り状ヘルプ','송장 도움'),
('35','payment','payment','প্রদান','pago','دفع','betaling','оплата','付款','ödeme','pagamento','fizetés','paiement','πληρωμή','Zahlung','pagamento','การชำระเงิน','ادائیگی','भुगतान','pecunia','pembayaran','支払い','지불'),
('36','book_help','book help','বইয়ের সাহায্য','libro de ayuda','كتاب المساعدة','boek hulp','Книга помощь','本书帮助','kitap yardımı','livro ajuda','könyv segít','livre aide','βοήθεια του βιβλίου','Buch-Hilfe','della guida','ช่วยเหลือหนังสือ','کتاب مدد','पुस्तक मदद','auxilium libro,','Buku bantuan','ブックのヘルプ','책 도움말'),
('37','library','library','লাইব্রেরি','biblioteca','مكتبة','bibliotheek','библиотека','文库','kütüphane','biblioteca','könyvtár','bibliothèque','βιβλιοθήκη','Bibliothek','biblioteca','ห้องสมุด','لائبریری','पुस्तकालय','library','perpustakaan','図書館','도서관'),
('38','transport_help','transport help','যানবাহনের সাহায্য','ayuda de transporte','مساعدة النقل','vervoer help','транспорт помощь','运输帮助','ulaşım yardım','ajuda de transporte','szállítás Súgó','le transport de l\'aide','βοηθούν τη μεταφορά','Transport Hilfe','help trasporti','ช่วยเหลือการขนส่ง','نقل و حمل مدد','परिवहन मदद','auxilium onerariis','transportasi bantuan','輸送のヘルプ','전송 도움'),
('39','transport','transport','পরিবহন','transporte','نقل','vervoer','транспорт','运输','taşıma','transporte','szállítás','transport','μεταφορά','Transport','trasporto','การขนส่ง','نقل و حمل','परिवहन','onerariis','angkutan','輸送','수송'),
('40','dormitory_help','dormitory help','আস্তানা সাহায্য','dormitorio de ayuda','عنبر المساعدة','slaapzaal hulp','общежитие помощь','宿舍帮助','yatakhane yardım','dormitório ajuda','kollégiumi help','dortoir aide','κοιτώνα βοήθεια','Wohnheim Hilfe','dormitorio aiuto','หอพักช่วยเหลือ','شیناگار مدد','छात्रावास मदद','dormitorium auxilium','asrama bantuan','寮のヘルプ','기숙사 도움말'),
('41','dormitory','dormitory','শ্রমিক - আস্তানা','dormitorio','المهجع','slaapzaal','спальня','宿舍','yatakhane','dormitório','hálóterem','dortoir','κοιτώνα','Wohnheim','dormitorio','หอพัก','شیناگار','छात्रावास','dormitorium','asrama mahasiswa','寮','기숙사'),
('42','noticeboard_help','noticeboard help','নোটিশবোর্ড সাহায্য','tablón de anuncios de la ayuda','اللافتة مساعدة','prikbord hulp','доска для объявлений помощь','布告帮助','noticeboard yardım','avisos ajuda','üzenőfalán help','panneau d\'aide','ανακοινώσεων βοήθεια','Brett-Hilfe','bacheca aiuto','ป้ายประกาศความช่วยเหลือ','noticeboard مدد','Noticeboard मदद','auxilium noticeboard','pengumuman bantuan','伝言板のヘルプ','의 noticeboard 도움말'),
('43','noticeboard-event','noticeboard-event','নোটিশবোর্ড-ইভেন্ট','tablón de anuncios de eventos','اللافتة الحدث','prikbord-event','доска для объявлений-событие','布告牌事件','noticeboard olay','avisos de eventos','üzenőfalán esemény','panneau d\'événement','ανακοινώσεων εκδήλωση','Brett-Ereignis','bacheca-evento','ป้ายประกาศของเหตุการณ์','noticeboard ایونٹ','Noticeboard घटना','noticeboard eventus,','pengumuman-acara','伝言板イベント','의 noticeboard 이벤트'),
('44','bed_ward_help','bed ward help','বিছানা ওয়ার্ড সাহায্য','cama ward ayuda','جناح سرير المساعدة','bed ward hulp','кровать подопечный помощь','床病房的帮助','yatak koğuş yardım','ajuda cama enfermaria','ágy Ward help','lit salle de l\'aide','κρεβάτι πτέρυγα βοήθεια','Betten-Station Hilfe','Letto reparto aiuto','วอร์ดเตียงช่วยเหลือ','بستر وارڈ مدد','बिस्तर वार्ड मदद','lectum stans auxilium','tidur bangsal bantuan','ベッド病棟のヘルプ','침대 병동 도움'),
('45','settings','settings','সেটিংস','configuración','إعدادات','instellingen','настройки','设置','ayarları','definições','beállítások','paramètres','Ρυθμίσεις','Einstellungen','Impostazioni','การตั้งค่า','ترتیبات','सेटिंग्स','occasus','Pengaturan','設定','설정'),
('46','system_settings','system settings','সিস্টেম সেটিংস','configuración del sistema','إعدادات النظام','systeeminstellingen','настройки системы','系统设置','sistem ayarları','configurações do sistema','rendszerbeállításokat','les paramètres du système','ρυθμίσεις του συστήματος','Systemeinstellungen','impostazioni di sistema','การตั้งค่าระบบ','نظام کی ترتیبات','प्रणाली सेटिंग्स','ratio occasus','pengaturan sistem','システム設定','시스템 설정'),
('47','manage_language','manage language','ভাষা ও পরিচালনা','gestionar idioma','إدارة اللغة','beheren taal','управлять язык','管理语言','dil yönetmek','gerenciar língua','kezelni nyelv','gérer langue','διαχείριση γλώσσα','verwalten Sprache','gestire lingua','จัดการภาษา','زبان کا انتظام','भाषा का प्रबंधन','moderari linguam,','mengelola bahasa','言語を管理','언어를 관리'),
('48','backup_restore','backup restore','ব্যাকআপ পুনঃস্থাপন','copia de seguridad a restaurar','استعادة النسخ الاحتياطي','backup terugzetten','восстановить резервного копирования','备份还原','yedekleme geri','de backup restaurar','Backup Restore','restauration de sauvegarde','επαναφοράς αντιγράφων ασφαλείας','Backup wiederherstellen','ripristino di backup','การสำรองข้อมูลเรียกคืน','بیک اپ بحال','बैकअप बहाल','tergum restituunt','backup restore','バックアップは、リストア','백업 복원'),
('49','profile_help','profile help','সাহায্য প্রোফাইল','Perfil Ayuda','ملف المساعدة','profile hulp','анкета помощь','简介帮助','yardım profile','Perfil ajuda','profile help','profil aide','προφίλ βοήθεια','Profil Hilfe','profilo di aiuto','โปรไฟล์ความช่วยเหลือ','مدد پروفائل','प्रोफाइल में','Auctor nullam opem','Profil bantuan','プロフィールヘルプ','도움 프로필'),
('50','manage_student','manage student','শিক্ষার্থী ও পরিচালনা','gestionar estudiante','إدارة الطلبة','beheren student','управлять студента','管理学生','öğrenci yönetmek','gerenciar estudante','kezelni diák','gérer étudiant','διαχείριση των φοιτητών','Schüler verwalten','gestire studente','การจัดการศึกษา','طالب علم کا انتظام','छात्र का प्रबंधन','curo alumnorum','mengelola siswa','生徒を管理','학생 관리'),
('51','manage_teacher','manage teacher','শিক্ষক ও পরিচালনা','gestionar maestro','إدارة المعلم','beheren leraar','управлять учителя','管理老师','öğretmen yönetmek','gerenciar professor','kezelni tanár','gérer enseignant','διαχείριση των εκπαιδευτικών','Lehrer verwalten','gestire insegnante','จัดการครู','ٹیچر کا انتظام','शिक्षक का प्रबंधन','magister curo','mengelola guru','教師を管理','교사 관리'),
('52','noticeboard','noticeboard','নোটিশবোর্ড','tablón de anuncios','اللافتة','prikbord','доска для объявлений','布告','noticeboard','quadro de avisos','üzenőfalán','panneau d\'affichage','ανακοινώσεων','Brett','bacheca','ป้ายประกาศ','noticeboard','Noticeboard','noticeboard','pengumuman','伝言板','의 noticeboard'),
('53','language','language','ভাষা','idioma','لغة','taal','язык','语','dil','língua','nyelv','langue','γλώσσα','Sprache','lingua','ภาษา','زبان','भाषा','Lingua','bahasa','言語','언어'),
('54','backup','backup','ব্যাকআপ','reserva','دعم','reservekopie','резервный','备用','yedek','backup','mentés','sauvegarde','εφεδρικός','Sicherungskopie','di riserva','การสำรองข้อมูล','بیک اپ','बैकअप','tergum','backup','バックアップ','지원'),
('55','calendar_schedule','calendar schedule','ক্যালেন্ডার সময়সূচী','horario de calendario','الجدول الزمني','kalender schema','Календарь Расписание','日历日程','takvim programı','agenda calendário','naptári ütemezés','calendrier calendrier','χρονοδιαγράμματος του ημερολογίου','Kalender Zeitplan','programma di calendario','ปฏิทินตารางนัดหมาย','کیلنڈر شیڈول','कैलेंडर अनुसूची','kalendarium ipsum','jadwal kalender','カレンダーのスケジュール','캘린더 일정'),
('56','select_a_class','select a class','একটি শ্রেণী নির্বাচন','seleccionar una clase','حدد فئة','selecteer een class','выберите класс','选择一个类','bir sınıf seçin','selecionar uma classe','válasszon ki egy osztályt','sélectionner une classe','επιλέξτε μια κατηγορία','Wählen Sie eine Klasse','selezionare una classe','เลือกชั้น','ایک کلاس منتخب کریں','एक वर्ग का चयन करें','eligere genus','pilih kelas','クラスを選択','클래스를 선택'),
('57','student_list','student list','শিক্ষার্থীর তালিকা','lista de alumnos','قائمة الطلاب','student lijst','Список студент','学生名单','öğrenci listesi','lista de alunos','diák lista','liste des étudiants','κατάλογο των φοιτητών','Schülerliste','elenco degli studenti','รายชื่อนักเรียน','طالب علم کی فہرست','छात्र सूची','Discipulus album','daftar mahasiswa','学生のリスト','학생 목록'),
('58','add_student','add student','ছাত্র যোগ','añadir estudiante','إضافة طالب','voeg student','добавить студента','新增学生','öğrenci eklemek','adicionar estudante','hozzá hallgató','ajouter étudiant','προσθέστε φοιτητής','Student hinzufügen','aggiungere studente','เพิ่มนักเรียน','طالب علم شامل','छात्र जोड़','adde elit','menambahkan mahasiswa','学生を追加','학생을 추가'),
('59','roll','roll','রোল','rollo','لفة','broodje','рулон','滚','rulo','rolo','tekercs','rouleau','ρολό','Rolle','rotolo','ม้วน','رول','रोल','volumen','gulungan','ロール','롤'),
('60','photo','photo','ছবি','foto','صور','foto','фото','照片','fotoğraf','foto','fénykép','photo','φωτογραφία','Foto','foto','ภาพถ่าย','تصویر','फ़ोटो','Lorem ipsum','foto','写真','사진'),
('61','student_name','student name','শিক্ষার্থীর নাম','Nombre del estudiante','اسم الطالب','naam van de leerling','Имя студента','学生姓名','Öğrenci adı','nome do aluno','tanuló nevét','nom de l\'étudiant','το όνομα του μαθητή','Studentennamen','nome dello studente','ชื่อนักเรียน','طالب علم کے نام','छात्र का नाम','ipsum est nomen','nama siswa','学生の名前','학생의 이름'),
('62','address','address','ঠিকানা','dirección','عنوان','adres','адрес','地址','adres','endereço','cím','adresse','διεύθυνση','Adresse','indirizzo','ที่อยู่','ایڈریس','पता','Oratio','alamat','アドレス','주소'),
('63','options','options','অপশন','Opciones','خيارات','opties','опции','选项','seçenekleri','opções','lehetőségek','les options','Επιλογές','Optionen','Opzioni','ตัวเลือก','اختیارات','विकल्प','options','Pilihan','オプション','옵션'),
('64','marksheet','marksheet','marksheet','marksheet','marksheet','Marksheet','marksheet','marksheet','Marksheet','marksheet','Marksheet','relevé de notes','Marksheet','marksheet','Marksheet','marksheet','marksheet','अंकपत्र','marksheet','marksheet','marksheet','marksheet'),
('65','id_card','id card','আইডি কার্ড','carnet de identidad','بطاقة الهوية','id-kaart','удостоверение личности','身份证','kimlik kartı','carteira de identidade','személyi igazolvány','carte d\'identité','id κάρτα','Ausweis','carta d\'identità','บัตรประชาชน','شناختی کارڈ','औ डी कार्ड','id ipsum','id card','IDカード','신분증'),
('66','edit','edit','সম্পাদন করা','editar','تحرير','uitgeven','редактировать','编辑','düzenleme','editar','szerkeszt','modifier','edit','bearbeiten','modifica','แก้ไข','میں ترمیم کریں','संपादित करें','edit','mengedit','編集','편집'),
('67','delete','delete','মুছে ফেলা','borrar','حذف','verwijderen','удалять','删除','silmek','excluir','töröl','effacer','διαγραφή','löschen','cancellare','ลบ','خارج','हटाना','vel deleri,','menghapus','削除する','삭제'),
('68','personal_profile','personal profile','ব্যক্তিগত প্রোফাইল','perfil personal','ملف شخصي','persoonlijk profiel','личный профиль','个人简介','kişisel profil','perfil pessoal','személyes profil','profil personnel','προσωπικό προφίλ','persönliches Profil','profilo personale','รายละเอียดข้อมูลส่วนตัว','ذاتی پروفائل','व्यक्तिगत प्रोफाइल','personal profile','profil pribadi','人物点描','개인 프로필'),
('69','academic_result','academic result','একাডেমিক ফলাফল','resultado académico','نتيجة الأكاديمية','academische resultaat','академический результат','学术成果','akademik sonuç','resultado acadêmico','tudományos eredmény','résultat académique','ακαδημαϊκή αποτέλεσμα','Studienergebnis','risultato accademico','ผลการศึกษา','تعلیمی نتیجہ','शैक्षिक परिणाम','Ex academicis','Hasil akademik','学術結果','학습 결​​과'),
('70','name','name','নাম','nombre','اسم','naam','название','名称','isim','nome','név','nom','όνομα','Name','nome','ชื่อ','نام','नाम','nomen,','nama','名前','이름'),
('71','birthday','birthday','জন্মদিন','cumpleaños','عيد ميلاد','verjaardag','день рождения','生日','doğum günü','aniversário','születésnap','anniversaire','γενέθλια','Geburtstag','compleanno','วันเกิด','سالگرہ','जन्मदिन','natalis','ulang tahun','誕生日','생일'),
('72','sex','sex','লিঙ্গ','sexo','جنس','seks','секс','性别','seks','sexo','szex','sexe','φύλο','Sex','sesso','เพศ','جنسی','लिंग','sex','seks','セックス','섹스'),
('73','male','male','পুরুষ','masculino','ذكر','mannelijk','мужской','男性','erkek','masculino','férfi','mâle','αρσενικός','männlich','maschio','เพศชาย','پروفائل','नर','masculus','laki-laki','男性','남성'),
('74','female','female','মহিলা','femenino','أنثى','vrouw','женский','女','kadın','feminino','női','femelle','θηλυκός','weiblich','femminile','เพศหญิง','خواتین','महिला','femina,','perempuan','女性','여성'),
('75','religion','religion','ধর্ম','religión','دين','religie','религия','宗教','din','religião','vallás','religion','θρησκεία','Religion','religione','ศาสนา','مذہب','धर्म','religionis,','agama','宗教','종교'),
('76','blood_group','blood group','রক্তের বিভাগ','grupo sanguíneo','فصيلة الدم','bloedgroep','группа крови','血型','kan grubu','grupo sanguíneo','vércsoport','groupe sanguin','ομάδα αίματος','Blutgruppe','gruppo sanguigno','กรุ๊ปเลือด','خون کے گروپ','रक्त वर्ग','sanguine coetus','golongan darah','血液型','혈액형'),
('77','phone','phone','ফোন','teléfono','هاتف','telefoon','телефон','电话','telefon','telefone','telefon','téléphone','τηλέφωνο','Telefon','telefono','โทรศัพท์','فون','फ़ोन','Praesent','telepon','電話','전화'),
('78','father_name','father name','পিতার নাম','Nombre del padre','اسم الأب','naam van de vader','отчество','父亲姓名','baba adı','nome pai','apa név','nom de père','Το όνομα του πατέρα','Der Name des Vaters','nome del padre','ชื่อพ่อ','والد کا نام','पिता का नाम','nomine Patris,','Nama ayah','父親の名前','아버지의 이름'),
('79','mother_name','mother name','মায়ের নাম','Nombre de la madre','اسم الأم','moeder naam','Имя матери','母亲的名字','anne adı','Nome mãe','anyja név','nom de la mère','το όνομα της μητέρας','Name der Mutter','Nome madre','ชื่อแม่','ماں کا نام','माता का नाम','matris nomen,','Nama ibu','母の名前','어머니 이름'),
('80','edit_student','edit student','সম্পাদনা ছাত্র','edit estudiante','تحرير الطالب','bewerk student','редактирования студент','编辑学生','edit öğrenci','edição aluno','szerkesztés diák','modifier étudiant','επεξεργασία των φοιτητών','Schüler bearbeiten','modifica dello studente','แก้ไขนักเรียน','ترمیم کے طالب علم','संपादित छात्र','edit studiosum','mengedit siswa','編集学生','편집 학생'),
('81','teacher_list','teacher list','শিক্ষক তালিকা','lista maestra','قائمة المعلم','leraar lijst','Список учителей','老师名单','öğretmen listesi','lista de professores','tanár lista','Liste des enseignants','Λίστα των εκπαιδευτικών','Lehrer-Liste','elenco degli insegnanti','รายชื่อครู','استاد فہرست','शिक्षक सूची','magister album','daftar guru','教員リスト','교사의 목록'),
('82','add_teacher','add teacher','শিক্ষক যোগ','añadir profesor','إضافة المعلم','voeg leraar','добавить учителя','加上老师','öğretmen ekle','adicionar professor','hozzá tanár','ajouter enseignant','προσθέστε δάσκαλος','Lehrer hinzufügen','aggiungere insegnante','เพิ่มครู','استاد شامل','शिक्षक जोड़','Magister addit','menambah guru','先生を追加','교사를 추가'),
('83','teacher_name','teacher name','শিক্ষক নাম','Nombre del profesor','اسم المعلم','leraarsnaam','Имя учителя','老师姓名','öğretmen adı','nome professor','tanár név','nom des enseignants','όνομα των εκπαιδευτικών','Lehrer Name','Nome del docente','ชื่อครู','استاد کا نام','शिक्षक का नाम','magister nomine','nama guru','教員名','교사 이름'),
('84','edit_teacher','edit teacher','সম্পাদনা শিক্ষক','edit maestro','تحرير المعلم','leraar bewerken','править учитель','编辑老师','edit öğretmen','editar professor','szerkesztés tanár','modifier enseignant','edit εκπαιδευτικών','edit Lehrer','modifica insegnante','แก้ไขครู','ترمیم استاد','संपादित करें शिक्षक','edit magister','mengedit guru','編集の先生','편집 교사'),
('85','manage_parent','manage parent','অভিভাবক ও পরিচালনা','gestionar los padres','إدارة الأم','beheren ouder','управлять родителей','母公司管理','ebeveyn yönetmek','gerenciar pai','kezelni szülő','gérer parent','διαχείριση μητρική','verwalten Mutter','gestione genitore','จัดการปกครอง','والدین کا انتظام','माता - पिता का प्रबंधन','curo parent','mengelola orang tua','親を管理','부모 관리'),
('86','parent_list','parent list','মূল তালিকা','lista primaria','قائمة الوالد','ouder lijst','родительского списка','父列表','ebeveyn listesi','lista pai','szülő lista','liste parent','μητρική λίστα','geordneten Liste','elenco padre','รายชื่อผู้ปกครอง','والدین کی فہرست','माता - पिता सूची','parente album','daftar induk','親リスト','상위 목록'),
('87','parent_name','parent name','মূল নাম','Nombre del padre','اسم الوالد','oudernaam','родитель название','父名','ebeveyn isim','nome do pai','szülő név','nom du parent','μητρικό όνομα','Mutternamen','nome del padre','ชื่อผู้ปกครอง','والدین کے نام','माता - पिता का नाम','Nomen parentis,','nama orang tua','親の名前','부모 이름'),
('88','relation_with_student','relation with student','ছাত্রদের সঙ্গে সম্পর্ক','relación con el estudiante','العلاقة مع الطالب','relatie met student','отношения с учеником','与学生关系','öğrenci ile ilişkisi','relação com o aluno','kapcsolatban diák','relation avec l\'élève','σχέση με τον μαθητή','Zusammenhang mit Studenten','rapporto con lo studente','ความสัมพันธ์กับนักเรียน','طالب علم کے ساتھ تعلق','छात्रा के साथ संबंध','cum inter ipsum','hubungan dengan siswa','学生との関係','학생과의 관계'),
('89','parent_email','parent email','মূল ইমেইল','correo electrónico de los padres','البريد الإلكتروني الأم','ouder email','родитель письмо','父母的电子邮件','ebeveyn email','e-mail dos pais','szülő e-mail','parent email','email του γονέα','Eltern per E-Mail','email genitore','อีเมล์ผู้ปกครอง','والدین کا ای میل','माता - पिता ईमेल','parente email','email induk','親電子メール','부모의 이메일'),
('90','parent_phone','parent phone','ঊর্ধ্বতন ফোন','teléfono de los padres','الهاتف الوالدين','ouder telefoon','родитель телефон','家长电话','ebeveyn telefon','telefone dos pais','szülő telefon','mère de téléphone','μητρική τηλέφωνο','Elterntelefon','telefono genitore','โทรศัพท์ของผู้ปกครอง','والدین فون','माता - पिता को फोन','parentis phone','telepon orang tua','親の携帯電話','부모 전화'),
('91','parrent_address','parrent address','parrent ঠিকানা','Dirección Parrent','عنوان parrent','parrent adres','Parrent адрес','parrent地址','parrent adresi','endereço Parrent','parrent cím','adresse Parrent','parrent διεύθυνση','parrent Adresse','Indirizzo parrent','ที่อยู่ parrent','parrent ایڈریس','parrent पता','oratio parrent','alamat parrent','parrentアドレス','parrent 주소'),
('92','parrent_occupation','parrent occupation','parrent বৃত্তি','ocupación Parrent','الاحتلال parrent','parrent bezetting','Parrent оккупация','parrent职业','parrent işgal','ocupação Parrent','parrent Foglalkozás','occupation Parrent','parrent επάγγελμα','parrent Beruf','occupazione parrent','อาชีพ parrent','parrent قبضے','parrent कब्जे','opus parrent','pendudukan parrent','parrent職業','parrent 직업'),
('93','add','add','যোগ করা','añadir','إضافة','toevoegen','добавлять','加','eklemek','adicionar','hozzáad','ajouter','προσθήκη','hinzufügen','aggiungere','เพิ่ม','شامل','जोड़ना','Adde','menambahkan','加える','추가'),
('94','parent_of','parent of','অভিভাবক','matriz de','الأم ل','ouder van','родитель','父','ebeveyn','pai','szülő','parent d\'','γονέας','Muttergesellschaft der','madre di','ผู้ปกครองของ','والدین','के माता - पिता','parentem,','induk dari','の親','의 부모'),
('95','profession','profession','পেশা','profesión','مهنة','beroep','профессия','职业','meslek','profissão','szakma','profession','επάγγελμα','Beruf','professione','อาชีพ','پیشہ','व्यवसाय','professio','profesi','職業','직업'),
('96','edit_parent','edit parent','সম্পাদনা ঊর্ধ্বতন','edit padres','تحرير الوالدين','bewerk ouder','править родитель','编辑父','edit ebeveyn','edição pai','szerkesztés szülő','modifier parent','edit γονέα','edit Mutter','modifica genitore','แก้ไขผู้ปกครอง','میں ترمیم کریں والدین','संपादित जनक','edit parent','mengedit induk','編集親','편집 부모'),
('97','add_parent','add parent','ঊর্ধ্বতন যোগ','añadir los padres','إضافة الوالد','Voeg een ouder','добавить родителя','添加父','ebeveyn ekle','adicionar pai','hozzá szülő','ajouter parent','προσθέστε μητρική','Mutter hinzufügen','aggiungere genitore','เพิ่มผู้ปกครอง','والدین شامل','माता - पिता जोड़','adde parent','menambahkan orang tua','親を追加','부모를 추가'),
('98','manage_subject','manage subject','বিষয় ও পরিচালনা','gestionar sujeto','إدارة الموضوع','beheren onderwerp','управлять тему','管理主题','konuyu yönetmek','gerenciar assunto','kezelni tárgy','gérer sujet','διαχείριση υπόκειται','Thema verwalten','gestire i soggetti','การจัดการเรื่อง','موضوع کا انتظام','विषय का प्रबंधन','subiectum disponat','mengelola subjek','対象を管理','대상 관리'),
('99','subject_list','subject list','বিষয় তালিকা','lista por materia','قائمة الموضوع','Onderwerp lijst','Список подлежит','主题列表','konu listesi','lista por assunto','téma lista','liste de sujets','υπόκεινται λίστα','Themenliste','lista soggetto','รายการเรื่อง','موضوع کی فہرست','विषय सूची','subiectum album','daftar subjek','サブジェクトリスト','주제 목록'),
('100','add_subject','add subject','বিষয় যোগ','Añadir asunto','إضافة الموضوع','Onderwerp toevoegen','добавить тему','新增主题','konu ekle','adicionar assunto','Tárgy hozzáadása','ajouter l\'objet','Προσθήκη θέματος','Thema hinzufügen','aggiungere soggetto','เพิ่มเรื่อง','موضوع','जोड़ें विषय','re addere','menambahkan subjek','件名を追加','제목을 추가'),
('101','subject_name','subject name','বিষয় নাম','nombre del sujeto','اسم الموضوع','Onderwerp naam','имя субъекта','主题名称','konu adı','nome do assunto','tárgy megnevezése','nom du sujet','υπόκεινται όνομα','Thema Namen','nome del soggetto','ชื่อเรื่อง','موضوع کے نام','विषय का नाम','agitur nomine','nama subjek','サブジェクト名','주체 이름'),
('102','edit_subject','edit subject','সম্পাদনা বিষয়','Editar asunto','تحرير الموضوع','Onderwerp bewerken','Изменить тему','编辑主题','düzenleme konusu','Editar assunto','Tárgy szerkesztése','modifier l\'objet','edit θέμα','Betreff bearbeiten','Modifica oggetto','แก้ไขเรื่อง','موضوع میں ترمیم کریں','विषय संपादित करें','edit subiecto','mengedit subjek','編集対象','제목 수정'),
('103','manage_class','manage class','ক্লাস ও পরিচালনা','gestionar clase','إدارة الصف','beheren klasse','управлять класс','管理类','sınıf yönetmek','gerenciar classe','kezelni osztály','gérer classe','διαχείριση τάξης','Klasse verwalten','gestione della classe','การจัดการชั้นเรียน','کلاس کا انتظام','वर्ग का प्रबंधन','genus regendi','mengelola kelas','クラスを管理','클래스에게 관리'),
('104','class_list','class list','বর্গ তালিকা','lista de la clase','قائمة فئة','klasse lijst','Список класс','类列表','sınıf listesi','lista de classe','class lista','liste de classe','πίνακας αποτελεσμάτων','Klassenliste','elenco di classe','รายการชั้น','کلاس فہرست','कक्षा सूची','genus album','daftar kelas','クラスリスト','클래스 목록'),
('105','add_class','add class','ক্লাসে যোগ','agregar la clase','إضافة فئة','voeg klasse','добавить класс','添加类','sınıf eklemek','adicionar classe','hozzá osztály','ajouter la classe','προσθέσετε τάξη','Klasse hinzufügen','aggiungere classe','เพิ่มระดับ','کلاس شامل کریں','वर्ग जोड़','adde genus','menambahkan kelas','クラスを追加','클래스를 추가'),
('106','class_name','class name','শ্রেণীর নাম','nombre de la clase','اسم الفئة','class naam','Имя класса','类名','sınıf adı','nome da classe','osztály neve','nom de la classe','όνομα της κλάσης','Klassennamen','nome della classe','ชื่อชั้น','کلاس نام','वर्ग के नाम','Classis nomine','nama kelas','クラス名','클래스 이름'),
('107','numeric_name','numeric name','সাংখ্যিক নাম','nombre numérico','اسم رقمية','numerieke naam','числовое имя','数字名称','Sayısal isim','nome numérico','numerikus név','nom numérique','αριθμητικό όνομα','numerischen Namen','nome numerico','ชื่อตัวเลข','عددی نام','सांख्यिक नाम','secundum numerum est secundum nomen,','Nama numerik','数値の名前','숫자 이름'),
('108','name_numeric','name numeric','সাংখ্যিক নাম দিন','nombre numérico','تسمية رقمية','naam numerieke','назвать числовой','数字命名','sayısal isim','nome numérico','név numerikus','nommer numérique','όνομα αριθμητικό','nennen numerischen','nome numerico','ชื่อตัวเลข','عددی نام','सांख्यिक का नाम','secundum numerum est secundum nomen,','nama numerik','数値に名前を付ける','숫자 이름을'),
('109','edit_class','edit class','সম্পাদনা বর্গ','clase de edición','الطبقة تحرير','bewerken klasse','править класс','编辑类','sınıf düzenle','edição classe','szerkesztés osztály','modifier la classe','edit κατηγορία','Klasse bearbeiten','modifica della classe','แก้ไขระดับ','ترمیم کلاس','संपादित वर्ग','edit genere','mengedit kelas','編集クラス','편집 클래스'),
('110','manage_exam','manage exam','পরীক্ষা পরিচালনা','gestionar examen','إدارة الامتحان','beheren examen','управлять экзамен','考试管理','sınavı yönetmek','gerenciar exame','kezelni vizsga','gérer examen','διαχείριση εξετάσεις','Prüfung verwalten','gestire esame','การจัดการสอบ','امتحان کا انتظام','परीक्षा का प्रबंधन','curo ipsum','mengelola ujian','試験を管理','시험 관리'),
('111','exam_list','exam list','পরীক্ষার তালিকা','lista de exámenes','قائمة الامتحان','examen lijst','Список экзамен','考试名单','sınav listesi','lista de exames','vizsga lista','liste d\'examen','Λίστα εξετάσεις','Prüfungsliste','elenco esami','รายการสอบ','امتحان فہرست','परीक्षा सूची','Lorem ipsum album','daftar ujian','試験のリスト','시험 목록'),
('112','add_exam','add exam','পরীক্ষার যোগ','agregar examen','إضافة امتحان','voeg examen','добавить экзамен','新增考试','sınav eklemek','adicionar exame','hozzá vizsga','ajouter examen','προσθέσετε εξετάσεις','Prüfung hinzufügen','aggiungere esame','เพิ่มการสอบ','امتحان میں شامل کریں','परीक्षा जोड़','adde ipsum','menambahkan ujian','試験を追加','시험에 추가'),
('113','exam_name','exam name','পরীক্ষার নাম','nombre del examen','اسم الامتحان','examen naam','Название экзамен','考试名称','sınav adı','nome do exame','Vizsga neve','nom de l\'examen','Το όνομά εξετάσεις','Prüfungsnamen','nome dell\'esame','ชื่อสอบ','امتحان کے نام','परीक्षा का नाम','ipsum nomen,','Nama ujian','試験名','시험 이름'),
('114','date','date','তারিখ','fecha','تاريخ','datum','дата','日期','tarih','data','dátum','date','ημερομηνία','Datum','data','วันที่','تاریخ','तारीख','date','tanggal','日付','날짜'),
('115','comment','comment','মন্তব্য','comentario','تعليق','commentaar','комментарий','评论','yorum','comentário','megjegyzés','commentaire','σχόλιο','Kommentar','commento','ความเห็น','تبصرہ','टिप्पणी','comment','komentar','コメント','논평'),
('116','edit_exam','edit exam','সম্পাদনা পরীক্ষা','examen de edición','امتحان تحرير','bewerk examen','править экзамен','编辑考试','edit sınavı','edição do exame','szerkesztés vizsga','modifier examen','edit εξετάσεις','edit Prüfung','modifica esame','แก้ไขการสอบ','ترمیم امتحان','संपादित परीक्षा','edit ipsum','mengedit ujian','編集試験','편집 시험'),
('117','manage_exam_marks','manage exam marks','পরীক্ষা চিহ্ন ও পরিচালনা','gestionar marcas de examen','إدارة علامات الامتحان','beheren examencijfers','управлять экзаменационные отметки','管理考试痕','sınav işaretleri yönetmek','gerenciar marcas exame','kezelni vizsga jelek','gérer les marques d\'examen','διαχείριση των σημάτων εξετάσεις','Prüfungsnoten verwalten','gestire i voti degli esami','จัดการสอบเครื่องหมาย','امتحان کے نشانات کا انتظام','परीक्षा के निशान का प्रबंधन','ipsum curo indicia','mengelola nilai ujian','試験マークを管理','시험 점수를 관리'),
('118','manage_marks','manage marks','চিহ্ন ও পরিচালনা','gestionar marcas','إدارة علامات','beheren merken','управлять знаки','商标管理','işaretleri yönetmek','gerenciar marcas','kezelni jelek','gérer les marques','διαχείριση των σημάτων','Markierungen verwalten','gestire i marchi','จัดการเครื่องหมาย','نمبروں کا انتظام','निशान का प्रबंधन','curo indicia','mengelola tanda','マークを管理','마크를 관리'),
('119','select_exam','select exam','পরীক্ষার নির্বাচন','seleccione examen','حدد الامتحان','selecteer examen','выбрать экзамен','选择考试','sınavı seçin','selecionar exame','válassza ki a vizsga','sélectionnez examen','επιλέξτε εξετάσεις','Prüfung wählen','seleziona esame','เลือกสอบ','امتحان منتخب کریں','परीक्षा का चयन','velit ipsum','pilih ujian','受験を選択','시험을 선택'),
('120','select_class','select class','বর্গ নির্বাচন','seleccione clase','حدد فئة','selecteren klasse','выбрать класс','选择产品类别','sınıf seçin','selecionar classe','válassza osztály','sélectionnez classe','Επιλέξτε κατηγορία','Klasse wählen','seleziona classe','เลือกชั้น','کلاس منتخب کریں','वर्ग का चयन करें','genus eligere,','pilih kelas','クラスを選択','클래스를 선택'),
('121','select_subject','select subject','বিষয় নির্বাচন করুন','seleccione tema','حدد الموضوع','Selecteer onderwerp','выберите тему','选择主题','konu seçin','selecionar assunto','Válassza a Tárgy','sélectionner le sujet','επιλέξτε θέμα','Thema wählen','seleziona argomento','เลือกเรื่อง','موضوع منتخب کریں','विषय का चयन','eligere subditos','pilih subjek','件名を選択','주제를 선택'),
('122','select_an_exam','select an exam','একটি পরীক্ষা নির্বাচন','seleccione un examen','حدد الامتحان','selecteer een examen','выбрать экзамен','选择考试','Bir sınav seçin','selecionar um exame','válasszon ki egy vizsga','sélectionner un examen','επιλέξτε μια εξέταση','Wählen Sie eine Prüfung','selezionare un esame','เลือกสอบ','امتحان منتخب کریں','एक परीक्षा का चयन','Eligebatur autem ipsum','pilih ujian','受験を選択','시험을 선택'),
('123','mark_obtained','mark obtained','চিহ্নিত প্রাপ্ত','calificación obtenida','بمناسبة الحصول على','markeren verkregen','отметить получены','获得标','işaretlemek elde','marca obtida','jelölje kapott','marquer obtenu','σήμα που λαμβάνεται','Markieren Sie erhalten','contrassegnare ottenuto','ทำเครื่องหมายที่ได้รับ','نشان زد حاصل','अंक प्राप्त','attende obtinuit','menandai diperoleh','マークが得','마크 획득'),
('124','attendance','attendance','উপস্থিতি','asistencia','الحضور','opkomst','посещаемость','护理','katılım','comparecimento','részvétel','présence','παρουσία','Teilnahme','partecipazione','การดูแลรักษา','حاضری','उपस्थिति','auscultant','kehadiran','出席','출석'),
('125','manage_grade','manage grade','গ্রেড পরিচালনা','gestión de calidad','إدارة الصف','beheren leerjaar','управлять класс','管理级','notu yönetmek','gerenciar grau','kezelni fokozat','gérer de qualité','διαχείριση ποιότητας','Klasse verwalten','gestione grade','จัดการเกรด','گریڈ کا انتظام','ग्रेड का प्रबंधन','moderari gradu','mengelola kelas','グレードを管理','등급 관리'),
('126','grade_list','grade list','গ্রেড তালিকা','Lista de grado','قائمة الصف','cijferlijst','Список класса','等级列表','sınıf listesi','lista grau','fokozat lista','liste de qualité','Λίστα βαθμού','Notenliste','elenco grade','รายการเกรด','گریڈ فہرست','ग्रेड की सूची','gradus album','daftar kelas','グレード一覧','등급 목록'),
('127','add_grade','add grade','গ্রেড যোগ করুন','añadir grado','إضافة الصف','voeg leerjaar','добавить класс','添加级','not eklemek','adicionar grau','hozzá fokozat','ajouter note','προσθήκη βαθμού','Klasse hinzufügen','aggiungere grade','เพิ่มเกรด','گریڈ میں شامل کریں','ग्रेड जोड़','adde gradum,','menambahkan kelas','グレードを追加','등급을 추가'),
('128','grade_name','grade name','গ্রেড নাম','Nombre de grado','اسم الصف','rangnaam','Название сорта','等级名称','sınıf adı','nome da classe','fokozat név','nom de la catégorie','Όνομα βαθμού','Klasse Name','nome del grado','ชื่อชั้น','گریڈ نام','ग्रेड का नाम','nomen, gradus,','nama kelas','グレード名','등급 이름'),
('129','grade_point','grade point','গ্রেড পয়েন্ট','de calificaciones','تراكمي','rangpunt','балл','成绩','not','ponto de classe','fokozatú pont','cumulative','βαθμών','Noten','punto di grado','จุดเกรด','گریڈ پوائنٹ','ग्रेड बिंदु','gradus punctum','indeks prestasi','成績評価点','학점'),
('130','mark_from','mark from','চিহ্ন থেকে','marca de','علامة من','mark uit','знак от','从商标','mark dan','marca de','jelölést','marque de','σήμα από','Marke aus','segno da','เครื่องหมายจาก','نشان سے','मार्क से','marcam','mark dari','マークから','표에서'),
('131','mark_upto','mark upto','পর্যন্ত চিহ্নিত','marcar hasta','بمناسبة تصل','mark tot','отметить ДО','高达标记','kadar işaretlemek','marcar até','jelölje upto','marquer jusqu\'à','σήμα μέχρι','Markieren Sie bis zu','contrassegnare fino a','ทำเครื่องหมายเกิน','تک کے موقع','तक चिह्नित','Genitus est notare','menandai upto','点で最大マーク','표까지'),
('132','edit_grade','edit grade','সম্পাদনা গ্রেড','edit grado','تحرير الصف','Cijfer bewerken','править класса','编辑等级','edit notu','edição grau','szerkesztés fokozat','edit qualité','edit βαθμού','edit Grad','modifica grade','แก้ไขเกรด','ترمیم گریڈ','संपादित ग्रेड','edit gradu','mengedit kelas','編集グレード','편집 등급'),
('133','manage_class_routine','manage class routine','ক্লাসের রুটিন পরিচালনা','gestionar rutina de la clase','إدارة الطبقة الروتينية','beheren klasroutine','управлять рутину класса','管理类常规','sınıf rutin yönetmek','gerenciar rotina classe','kezelni class rutin','gérer la routine de classe','διαχειρίζονται τάξη ρουτίνα','verwalten Klasse Routine','gestione classe di routine','การจัดการชั้นเรียนตามปกติ','کلاس معمول کا انتظام','वर्ग दिनचर्या का प्रबंधन','uno in genere tractare','mengelola rutinitas kelas','クラスルーチンを管理','수준의 일상적인 관리'),
('134','class_routine_list','class routine list','ক্লাসের রুটিন তালিকা','clase de lista de rutina','قائمة الروتينية الطبقة','klasroutine lijst','класс рутина список','班级常规列表','sınıf rutin listesi','classe de lista de rotina','osztály rutin lista','classe liste routine','κλάση list ρουτίνας','Klasse Routine Liste','classe lista di routine','รายการประจำชั้น','کلاس معمول کے مطابق فہرست','वर्ग दिनचर्या सूची','uno genere album','Daftar rutin kelas','クラスルーチン一覧','클래스 루틴 목록'),
('135','add_class_routine','add class routine','ক্লাসের রুটিন যুক্ত','añadir rutina de la clase','إضافة فئة الروتينية','voeg klasroutine','добавить подпрограмму класса','添加类常规','sınıf rutin eklemek','adicionar rotina classe','hozzá class rutin','ajouter routine de classe','προσθέσετε τάξη ρουτίνα','Klasse hinzufügen Routine','aggiungere classe di routine','เพิ่มระดับตามปกติ','کلاس معمول میں شامل کریں','वर्ग दिनचर्या जोड़','adde genus moris','menambahkan rutin kelas','クラス·ルーチンを追加','클래스 루틴을 추가'),
('136','day','day','দিন','día','يوم','dag','день','日','gün','dia','nap','jour','ημέρα','Tag','giorno','วัน','دن','दिन','die,','hari','日','일'),
('137','starting_time','starting time','সময়ের শুরু','tiempo de inicio','بدءا الوقت','starttijd','время начала','开始时间','başlangıç ​​zamanı','tempo começando','indítási idő','temps de démarrage','ώρα έναρξης','Startzeit','tempo di avviamento','เวลาเริ่มต้น','وقت شروع ہونے','समय की शुरुआत के','tum satus','waktu mulai','起動時間','시작 시간'),
('138','ending_time','ending time','সময় শেষ','hora de finalización','تنتهي الساعة','eindtijd','время окончания','结束时间','bitiş zamanını','tempo final','befejezési időpont','heure de fin','ώρα λήξης','Endzeit','ora finale','สิ้นสุดเวลา','وقت ختم','समय समाप्त होने के','et finis temporis,','akhir waktu','終了時刻','종료 시간'),
('139','edit_class_routine','edit class routine','সম্পাদনা ক্লাস রুটিন','rutina de la clase de edición','الطبقة تحرير الروتينية','bewerk klasroutine','Процедура редактирования класс','编辑类常规','sınıf düzenle rutin','rotina de edição de classe','szerkesztés osztály rutin','routine modifier de classe','edit τάξη ρουτίνα','edit Klasse Routine','modifica della classe di routine','แก้ไขชั้นเรียนตามปกติ','ترمیم کلاس معمول','संपादित वर्ग दिनचर्या','edit uno genere','rutin mengedit kelas','編集クラスのルーチン','편집 클래스 루틴'),
('140','manage_invoice/payment','manage invoice/payment','চালান / পেমেন্ট পরিচালনা','gestionar factura / pago','إدارة فاتورة / دفع','beheren factuur / betaling','управлять счета / оплата','管理发票/付款','fatura / ödeme yönetmek','gerenciar fatura / pagamento','kezelni számla / fizetési','gérer facture / paiement','διαχείριση τιμολογίου / πληρωμής','Verwaltung Rechnung / Zahlung','gestione fattura / pagamento','จัดการใบแจ้งหนี้ / การชำระเงิน','انوائس / ادائیگی کا انتظام','चालान / भुगतान का प्रबंधन','curo cautionem / solutionem','mengelola tagihan / pembayaran','請求書/支払管理','인보이스 / 결제 관리'),
('141','invoice/payment_list','invoice/payment list','চালান / পেমেন্ট তালিকা','lista de facturas / pagos','قائمة فاتورة / دفع','factuur / betaling lijst','Список счета / оплата','发票/付款清单','fatura / ödeme listesi','lista de fatura / pagamento','számla / fizetési lista','liste facture / paiement','Λίστα τιμολογίου / πληρωμής','Rechnung / Zahlungsliste','elenco fattura / pagamento','รายการใบแจ้งหนี้ / การชำระเงิน','انوائس / ادائیگی کی فہرست','चालान / भुगतान सूची','cautionem / list pretium','daftar tagihan / pembayaran','請求書/支払一覧','인보이스 / 결제리스트'),
('142','add_invoice/payment','add invoice/payment','চালান / পেমেন্ট যোগ','añadir factura / pago','إضافة فاتورة / دفع','voeg factuur / betaling','добавить счета / оплата','添加发票/付款','fatura / ödeme eklemek','adicionar factura / pagamento','hozzá számla / fizetési','ajouter facture / paiement','προσθήκη τιμολογίου / πληρωμής','hinzufügen Rechnung / Zahlung','aggiungere fatturazione / pagamento','เพิ่มใบแจ้งหนี้ / การชำระเงิน','انوائس / ادائیگی شامل','चालान / भुगतान जोड़ें','add cautionem / solutionem','menambahkan tagihan / pembayaran','請求書/支払を追加','송장 / 지불을 추가'),
('143','title','title','খেতাব','título','لقب','titel','название','标题','başlık','título','cím','titre','τίτλος','Titel','titolo','ชื่อเรื่อง','عنوان','शीर्षक','title','judul','タイトル','표제'),
('144','description','description','বিবরণ','descripción','وصف','beschrijving','описание','描述','tanım','descrição','leírás','description','περιγραφή','Beschreibung','descrizione','ลักษณะ','تفصیل','विवरण','description','deskripsi','説明','기술'),
('145','amount','amount','পরিমাণ','cantidad','مبلغ','bedrag','количество','量','miktar','quantidade','mennyiség','montant','ποσό','Menge','importo','จำนวน','رقم','राशि','tantum','jumlah','額','양'),
('146','status','status','অবস্থা','estado','حالة','toestand','статус','状态','durum','estado','állapot','statut','κατάσταση','Status','stato','สถานะ','درجہ','हैसियत','status','status','ステータス','지위'),
('147','view_invoice','view invoice','দেখুন চালান','vista de la factura','عرض الفاتورة','view factuur','вид счета-фактуры','查看发票','view fatura','vista da fatura','view számla','vue facture','προβολή τιμολόγιο','Ansicht Rechnung','vista fattura','ดูใบแจ้งหนี้','دیکھیں انوائس','देखें चालान','propter cautionem','lihat faktur','ビュー請求書','보기 송장'),
('148','paid','paid','পরিশোধ','pagado','مدفوع','betaald','оплаченный','支付','ücretli','pago','fizetett','payé','καταβληθεί','bezahlt','pagato','ต้องจ่าย','ادا کیا','प्रदत्त','solutis','dibayar','支払われた','지급'),
('149','unpaid','unpaid','অবৈতনিক','no pagado','غير مدفوع','onbetaald','неоплаченный','未付','ödenmemiş','não remunerado','kifizetetlen','non rémunéré','απλήρωτη','unbezahlt','non pagato','ยังไม่ได้ชำระ','بلا معاوضہ','अवैतनिक','non est constitutus,','dibayar','未払い','지불하지 않은'),
('150','add_invoice','add invoice','চালান যোগ','añadir factura','إضافة الفاتورة','voeg factuur','добавить счет','添加发票','faturayı eklemek','adicionar fatura','hozzá számla','ajouter facture','προσθέστε τιμολόγιο','Rechnung hinzufügen','aggiungere fattura','เพิ่มใบแจ้งหนี้','انوائس میں شامل','चालान जोड़','add cautionem','menambahkan faktur','請求書を追加','송장을 추가'),
('151','payment_to','payment to','পেমেন্ট','pago a','دفع ل','betaling aan','оплата','支付','için ödeme','pagamento','fizetés','paiement','πληρωμή','Zahlung an','pagamento','ชำระเงินให้กับ','ادائیگی','को भुगतान','pecunia','pembayaran kepada','への支払い','에 지불'),
('152','bill_to','bill to','বিল','proyecto de ley para','مشروع قانون ل','wetsvoorstel om','Законопроект о','法案','bill','projeto de lei para','törvényjavaslat','projet de loi','νομοσχέδιο για την','Gesetzentwurf zur','disegno di legge per','บิล','بل','बिल के लिए','latumque','RUU untuk','請求する','법안'),
('153','invoice_title','invoice title','চালান শিরোনাম','Título de la factura','عنوان الفاتورة','factuur titel','Название счета','发票抬头','fatura başlık','título fatura','számla cím','titre de la facture','Τίτλος τιμολόγιο','Rechnungs Titel','title fattura','ชื่อใบแจ้งหนี้','انوائس عنوان','चालान शीर्षक','title cautionem','judul faktur','請求書のタイトル','송장 제목'),
('154','invoice_id','invoice id','চালান আইডি','Identificación de la factura','فاتورة معرف','factuur id','счет-фактура ID','发票编号','fatura id','id fatura','számla id','Identifiant facture','id τιμολόγιο','Rechnung-ID','fattura id','ใบแจ้งหนี้หมายเลข','انوائس ID','चालान आईडी','id cautionem','faktur id','請求書ID','송장 ID'),
('155','edit_invoice','edit invoice','সম্পাদনা চালান','edit factura','تحرير الفاتورة','bewerk factuur','редактирования счета-фактуры','编辑发票','edit fatura','edição fatura','szerkesztés számla','modifier la facture','edit τιμολόγιο','edit Rechnung','modifica fattura','แก้ไขใบแจ้งหนี้','ترمیم انوائس','संपादित चालान','edit cautionem','mengedit faktur','編集送り状','편집 송장'),
('156','manage_library_books','manage library books','লাইব্রেরির বই ও পরিচালনা','gestionar libros de la biblioteca','إدارة مكتبة الكتب','beheren bibliotheekboeken','управлять библиотечные книги','管理图书','kitapları kütüphane yönetmek','gerenciar os livros da biblioteca','kezelni könyvtári könyvek','gérer des livres de bibliothèque','διαχειριστείτε τα βιβλία της βιβλιοθήκης','Bücher aus der Bibliothek verwalten','gestire i libri della biblioteca','จัดการหนั​​งสือห้องสมุด','کتب خانے کی کتابیں منظم','पुस्तकालय की पुस्तकों का प्रबंधन','curo bibliotheca librorum,','mengelola buku perpustakaan','図書館の本を管理','도서관 책 관리'),
('157','book_list','book list','পাঠ্যতালিকা','lista de libros','قائمة الكتب','boekenlijst','Список книг','书单','kitap listesi','lista de livros','book lista','liste de livres','λίστα βιβλίων','Buchliste','elenco libri','รายการหนั​​งสือ','کتاب کی فہرست','पुस्तक सूची','album','daftar buku','ブックリスト','도서 목록'),
('158','add_book','add book','বই যোগ','Añadir libro','إضافة كتاب','boek toevoegen','добавить книгу','加入书','kitap eklemek','adicionar livro','Könyv hozzáadása','ajouter livre','προσθέστε το βιβλίο','Buch hinzufügen','aggiungere il libro','เพิ่มหนังสือ','کتاب شامل','पुस्तक जोड़','adde libri','menambahkan buku','本を追加','책을 추가'),
('159','book_name','book name','বইয়ের নাম','Nombre del libro','اسم الكتاب','boeknaam','Название книги','书名','kitap adı','nome livro','book név','nom de livre','το όνομα του βιβλίου','Buchnamen','nome del libro','ชื่อหนังสือ','کتاب کا نام','किताब का नाम','librum nomine','nama buku','ブック名','책 이름'),
('160','author','author','লেখক','autor','الكاتب','auteur','автор','作者','yazar','autor','szerző','auteur','συγγραφέας','Autor','autore','ผู้เขียน','مصنف','लेखक','auctor','penulis','著者','저자'),
('161','price','price','দাম','precio','السعر','prijs','цена','价格','fiyat','preço','ár','prix','τιμή','Preis','prezzo','ราคา','قیمت','कीमत','price','harga','価格','가격'),
('162','available','available','উপলব্ধ','disponible','متاح','beschikbaar','доступный','可用的','mevcut','disponível','rendelkezésre álló','disponible','διαθέσιμος','verfügbar','disponibile','สามารถใช้ได้','دستیاب','उपलब्ध','available','tersedia','利用できる','유효한'),
('163','unavailable','unavailable','অপ্রাপ্য','indisponible','غير متاح','niet beschikbaar','недоступен','不可用','yok','indisponível','érhető el','indisponible','διαθέσιμο','nicht verfügbar','non disponibile','ไม่มี','دستیاب نہیں','अनुपलब्ध','unavailable','tidak tersedia','利用できない','없는'),
('164','edit_book','edit book','সম্পাদনা বই','libro de edición','كتاب تحرير','bewerk boek','править книга','编辑本书','edit kitap','edição do livro','edit könyv','edit livre','επεξεργαστείτε το βιβλίο','edit Buch','modifica book','แก้ไขหนังสือ','ترمیم کتاب','संपादित पुस्तक','edit Liber','mengedit buku','編集の本','편집 책'),
('165','manage_transport','manage transport','পরিবহন ও পরিচালনা','gestionar el transporte','إدارة النقل','beheren van vervoerssystemen','управлять транспортом','运输管理','ulaşım yönetmek','gerenciar o transporte','kezelni a közlekedés','la gestion du transport','διαχείριση των μεταφορών','Transport verwalten','gestire i trasporti','การจัดการการขนส่ง','نقل و حمل کے انتظام','परिवहन का प्रबंधन','curo onerariis','mengelola transportasi','輸送を管理','교통 관리'),
('166','transport_list','transport list','পরিবহন তালিকা','Lista de transportes','قائمة النقل','lijst vervoer','лист транспорт','运输名单','taşıma listesi','Lista de transportes','szállítás lista','liste de transport','Λίστα των μεταφορών','Transportliste','elenco trasporti','รายการการขนส่ง','نقل و حمل کی فہرست','परिवहन सूची','turpis album','daftar transport','輸送一覧','전송 목록'),
('167','add_transport','add transport','পরিবহন যোগ করুন','añadir el transporte','إضافة النقل','voeg vervoer','добавить транспорт','加上运输','taşıma ekle','adicionar transporte','hozzá a közlekedés','ajouter transports','προσθέστε μεταφορών','add-Transport','aggiungere il trasporto','เพิ่มการขนส่ง','نقل و حمل شامل','परिवहन जोड़','adde onerariis','tambahkan transportasi','トランスポートを追加','전송을 추가'),
('168','route_name','route name','রুট নাম','nombre de la ruta','اسم توجيه','naam van de route','Имя маршрут','路由名称','rota ismi','nome da rota','útvonal nevét','nom de la route','Όνομα διαδρομής','Routennamen','nome del percorso','ชื่อเส้นทาง','راستے نام','मार्ग का नाम','iter nomine','Nama rute','ルートの名前','경로 이름'),
('169','number_of_vehicle','number of vehicle','গাড়ীর সংখ্যা','número de vehículo','عدد من المركبات','aantal voertuigkilometers','количество автомобиля','车辆的数量','Aracın sayısı','número de veículo','számú gépjármű','nombre de véhicules','αριθμός των οχημάτων','Anzahl der Fahrzeug','numero di veicolo','จำนวนของยานพาหนะ','گاڑی کی تعداد','वाहन की संख्या','de numero scilicet vehiculum','jumlah kendaraan','車両の数','차량의 수'),
('170','route_fare','route fare','রুট করবেন','ruta hacer','المسار تفعل','route doen','маршрут делать','路线做','yol yapmak','rota fazer','útvonal do','itinéraire faire','διαδρομή κάνει','Route zu tun','r','เส้นทางทำ','راستے کرتے','मार्ग करना','iter faciunt,','rute lakukan','ルートか','경로는 할'),
('171','edit_transport','edit transport','সম্পাদনা পরিবহন','transporte de edición','النقل تحرير','vervoer bewerken','править транспорт','编辑运输','edit ulaşım','edição transporte','szerkesztés szállítás','transport modifier','edit μεταφορών','edit Transport','modifica dei trasporti','แก้ไขการขนส่ง','ترمیم نقل و حمل','संपादित परिवहन','edit onerariis','mengedit transportasi','編集輸送','편집 전송'),
('172','manage_dormitory','manage dormitory','আস্তানা ও পরিচালনা','gestionar dormitorio','إدارة مهجع','beheren slaapzaal','управлять общежитие','宿舍管理','yurt yönetmek','gerenciar dormitório','kezelni kollégiumi','gérer dortoir','διαχείριση κοιτώνα','Schlafsaal verwalten','gestione dormitorio','จัดการหอพัก','شیناگار کا انتظام','छात्रावास का प्रबंधन','curo dormitorio','mengelola asrama','寮を管理','기숙사를 관리'),
('173','dormitory_list','dormitory list','আস্তানা তালিকা','lista dormitorio','قائمة مهجع','slaapzaal lijst','Список общежитие','宿舍名单','yurt listesi','lista dormitório','kollégiumi lista','liste de dortoir','Λίστα κοιτώνα','Schlafsaal Liste','elenco dormitorio','รายชื่อหอพัก','شیناگار فہرست','छात्रावास सूची','dormitorium album','daftar asrama','寮のリスト','기숙사 목록'),
('174','add_dormitory','add dormitory','আস্তানা যোগ','añadir dormitorio','إضافة مهجع','voeg slaapzaal','добавить общежитие','添加宿舍','yurt ekle','adicionar dormitório','hozzá kollégiumi','ajouter dortoir','προσθήκη κοιτώνα','Schlaf hinzufügen','aggiungere dormitorio','เพิ่มหอพัก','شیناگار شامل','छात्रावास जोड़','adde dormitorio','menambahkan asrama','寮を追加','기숙사를 추가'),
('175','dormitory_name','dormitory name','আস্তানা নাম','Nombre del dormitorio','اسم المهجع','slaapzaal naam','Имя общежитие','宿舍名','yurt adı','nome dormitório','kollégiumi név','nom de dortoir','Όνομα κοιτώνα','Schlaf Namen','Nome dormitorio','ชื่อหอพัก','شیناگار نام','छात्रावास नाम','dormitorium nomine','Nama asrama','寮名','기숙사 이름'),
('176','number_of_room','number of room','ঘরের সংখ্যা','número de habitación','عدد الغرف','aantal kamer','число комнате','房间数量','oda sayısı','número de quarto','száma szobában','nombre de salle','τον αριθμό των δωματίων','Anzahl der Zimmer','numero delle camera','จำนวนห้องพัก','کمرے کی تعداد','कमरे की संख्या','numerus locus','Jumlah kamar','お部屋数','객실 수'),
('177','manage_noticeboard','manage noticeboard','নোটিশবোর্ড পরিচালনা','gestionar tablón de anuncios','إدارة اللافتة','beheren prikbord','управлять доске объявлений','管理布告','Noticeboard yönetmek','gerenciar avisos','kezelni üzenőfalán','gérer panneau d\'affichage','διαχείριση ανακοινώσεων','Brett verwalten','gestione bacheca','จัดการป้ายประกาศ','noticeboard کا انتظام','Noticeboard का प्रबंधन','curo noticeboard','mengelola pengumuman','伝言板を管理','의 noticeboard 관리'),
('178','noticeboard_list','noticeboard list','নোটিশবোর্ড তালিকা','tablón de anuncios de la lista','قائمة اللافتة','prikbord lijst','Список доска для объявлений','布告名单','noticeboard listesi','lista de avisos','üzenőfalán lista','liste de panneau d\'affichage','λίστα ανακοινώσεων','Brett-Liste','elenco bacheca','รายการป้ายประกาศ','noticeboard فہرست','Noticeboard सूची','noticeboard album','daftar pengumuman','伝言板一覧','의 noticeboard 목록'),
('179','add_noticeboard','add noticeboard','নোটিশবোর্ড যোগ','añadir tablón de anuncios','إضافة اللافتة','voeg prikbord','добавить доске объявлений','添加布告','Noticeboard ekle','adicionar avisos','hozzá üzenőfalán','ajouter panneau d\'affichage','προσθήκη ανακοινώσεων','Brett hinzufügen','aggiungere bacheca','เพิ่มป้ายประกาศ','noticeboard شامل','Noticeboard जोड़','adde noticeboard','menambahkan pengumuman','伝言板を追加','의 noticeboard 추가'),
('180','notice','notice','বিজ্ঞপ্তি','aviso','إشعار','kennisgeving','уведомление','通知','uyarı','aviso','értesítés','délai','ειδοποίηση','Bekanntmachung','avviso','แจ้งให้ทราบ','نوٹس','नोटिस','Observa','pemberitahuan','予告','통지'),
('181','add_notice','add notice','নোটিশ যোগ করুন','añadir aviso','إضافة إشعار','voeg bericht','добавить уведомление','添加通知','haber ekle','adicionar aviso','hozzá értesítés','ajouter un avis','προσθέστε ανακοίνωση','Hinweis hinzufügen','aggiungere preavviso','เพิ่มแจ้งให้ทราบล่วงหน้า','نوٹس کا اضافہ کریں','नोटिस जोड़','addunt et titulum','tambahkan pemberitahuan','通知を追加','통지를 추가'),
('182','edit_noticeboard','edit noticeboard','সম্পাদনা নোটিশবোর্ড','edit tablón de anuncios','تحرير اللافتة','bewerk prikbord','править доска для объявлений','编辑布告','edit noticeboard','edição de avisos','szerkesztés üzenőfalán','modifier panneau d\'affichage','edit ανακοινώσεων','Brett bearbeiten','modifica bacheca','แก้ไขป้ายประกาศ','میں ترمیم کریں noticeboard','संपादित Noticeboard','edit noticeboard','mengedit pengumuman','編集伝言板','편집의 noticeboard'),
('183','system_name','system name','সিস্টেমের নাম','Nombre del sistema','اسم النظام','Name System','Имя системы','系统名称','sistemi adı','nome do sistema','rendszer neve','nom du système','όνομα του συστήματος','Systemnamen','nome del sistema','ชื่อระบบ','نظام کا نام','सिस्टम नाम','ratio nominis','Nama sistem','システム名','시스템 이름'),
('184','save','save','রক্ষা','guardar','حفظ','besparen','экономить','节省','kurtarmak','salvar','kivéve','sauver','εκτός','sparen','salvare','ประหยัด','کو بچانے کے','बचाना','salvum','menyimpan','保存','저장'),
('185','system_title','system title','সিস্টেম শিরোনাম','Título de sistema','عنوان النظام','systeem titel','Название системы','系统标题','Sistem başlık','título sistema','rendszer cím','titre du système','Τίτλος του συστήματος','System-Titel','titolo di sistema','ชื่อระบบ','نظام عنوان','सिस्टम शीर्षक','ratio title','title sistem','システムのタイトル','시스템 제목'),
('186','paypal_email','paypal email','PayPal ইমেইল','paypal email','باي بال البريد الإلكتروني','paypal e-mail','PayPal по электронной почте','PayPal电子邮件','paypal e-posta','paypal e-mail','paypal email','paypal email','paypal ηλεκτρονικό ταχυδρομείο','paypal E-Mail','paypal-mail','paypal อีเมล์','پے پال ای میل','पेपैल ईमेल','Paypal email','email paypal','Paypalのメール','페이팔 이메일'),
('187','currency','currency','মুদ্রা','moneda','عملة','valuta','валюта','货币','para','moeda','valuta','monnaie','νόμισμα','Währung','valuta','เงินตรา','کرنسی','मुद्रा','currency','mata uang','通貨','통화'),
('188','phrase_list','phrase list','ফ্রেজ তালিকা','lista de frases','قائمة جملة','zinnenlijst','Список фраза','短语列表','ifade listesi','lista de frases','kifejezés lista','liste de phrase','Λίστα φράση','Phrasenliste','elenco frasi','รายการวลี','جملہ فہرست','वाक्यांश सूची','dicitur album','Daftar frase','フレーズリスト','문구 목록'),
('189','add_phrase','add phrase','শব্দগুচ্ছ যুক্ত','añadir la frase','إضافة عبارة','voeg zin','добавить фразу','添加词组','ifade eklemek','adicionar frase','adjunk kifejezést','ajouter la phrase','προσθέστε φράση','Begriff hinzufügen','aggiungere la frase','เพิ่มวลี','جملہ شامل','वाक्यांश जोड़ना','addere phrase','menambahkan frase','フレーズを追加','문구를 추가'),
('190','add_language','add language','ভাষা যুক্ত','añadir idioma','إضافة لغة','add taal','добавить язык','新增语言','dil ekle','adicionar língua','nyelv hozzáadása','ajouter la langue','προσθέστε γλώσσα','Sprache hinzufügen','aggiungere la lingua','เพิ่มภาษา','زبان کو شامل','भाषा जोड़ना','addere verbis','menambahkan bahasa','言語を追加','언어를 추가'),
('191','phrase','phrase','বাক্য','frase','العبارة','frase','фраза','短语','ifade','frase','kifejezés','phrase','φράση','Ausdruck','frase','วลี','جملہ','वाक्यांश','phrase','frasa','フレーズ','구'),
('192','manage_backup_restore','manage backup restore','ব্যাকআপ পুনঃস্থাপন ও পরিচালনা','gestionar copias de seguridad a restaurar','إدارة استعادة النسخ الاحتياطي','beheer van back-up herstellen','управлять восстановить резервного копирования','管理备份恢复','yedekleme geri yönetmek','gerenciar o backup de restauração','kezelni a biztonsági mentés visszaállítása','gérer de restauration de sauvegarde','διαχείριση επαναφοράς αντιγράφων ασφαλείας','verwalten Backup wiederherstellen','gestire il ripristino di backup','จัดการการสำรองข้อมูลเรียกคืน','بیک اپ بحال انتظام','बैकअप बहाल का प्रबंधन','curo tergum restituunt','mengelola backup restore','バックアップ、リストアを管理','백업 복원 관리'),
('193','restore','restore','প্রত্যর্পণ করা','restaurar','استعادة','herstellen','восстановление','恢复','geri','restaurar','visszaad','restaurer','επαναφέρετε','wiederherstellen','ripristinare','ฟื้นฟู','بحال','बहाल','reddite','mengembalikan','復元する','복원'),
('194','mark','mark','ছাপ','marca','علامة','mark','знак','标志','işaret','marca','jel','marque','σημάδι','Marke','marchio','เครื่องหมาย','نشان','निशान','Marcus','tanda','マーク','표'),
('195','grade','grade','গ্রেড','grado','درجة','graad','класс','等级','sınıf','grau','fokozat','grade','βαθμός','Klasse','grado','เกรด','گریڈ','ग्रेड','gradus,','kelas','グレード','학년'),
('196','invoice','invoice','চালান','factura','فاتورة','factuur','счет-фактура','发票','fatura','fatura','számla','facture','τιμολόγιο','Rechnung','fattura','ใบกำกับสินค้า','انوائس','बीजक','cautionem','faktur','インボイス','송장'),
('197','book','book','বই','libro','كتاب','boek','книга','书','kitap','livro','könyv','livre','βιβλίο','Buch','libro','หนังสือ','کتاب','किताब','Liber','buku','本','책'),
('198','all','all','সব','todo','كل','alle','все','所有','tüm','tudo','minden','tout','όλα','alle','tutto','ทั้งหมด','تمام','सब','omnes','semua','すべて','모든'),
('199','upload_&_restore_from_backup','upload & restore from backup','আপলোড &amp; ব্যাকআপ থেকে পুনঃস্থাপন','cargar y restaurar copia de seguridad','تحميل واستعادة من النسخة الاحتياطية','uploaden en terugzetten van een backup','загрузить и восстановить из резервной копии','上传及从备份中恢复','yükleyebilir ve yedekten geri yükleme','fazer upload e restauração de backup','feltölteni és visszaállítani backup','télécharger et restauration de la sauvegarde','ανεβάσετε και επαναφορά από backup','Upload &amp; Wiederherstellung von Backups','caricare e ripristinare dal backup','อัปโหลดและเรียกคืนจากการสำรองข้อมูล','اپ لوڈ کریں اور بیک اپ سے بحال','अपलोड और बैकअप से बहाल','restituo ex tergum upload,','meng-upload &amp; restore dari backup','アップロード＆バックアップから復元','업로드 및 백업에서 복원'),
('200','manage_profile','manage profile','প্রফাইলটি পরিচালনা','gestionar el perfil','إدارة الملف الشخصي','te beheren!','управлять профилем','管理配置文件','profilini yönetmek','gerenciar o perfil','Profil kezelése','gérer le profil','διαχειριστείτε το προφίλ','Profil verwalten','gestire il profilo','จัดการรายละเอียด','پروفائل کا نظم کریں','प्रोफाइल का प्रबंधन','curo profile','mengelola profil','プロファイル（個人情報）の管理','프로필 (내 정보) 관리'),
('201','update_profile','update profile','প্রোফাইল আপডেট','actualizar el perfil','تحديث الملف الشخصي','Profiel bijwerken','обновить профиль','更新个人资料','profilinizi güncelleyin','atualizar o perfil','frissíteni profil','mettre à jour le profil','ενημερώσετε το προφίλ','Profil aktualisieren','aggiornare il profilo','อัปเดตโปรไฟล์','پروفائل کو اپ ڈیٹ','प्रोफ़ाइल अपडेट','magna eget ipsum','memperbarui profil','プロファイルを更新','프로필을 업데이트'),
('202','new_password','new password','নতুন পাসওয়ার্ড','nueva contraseña','كلمة مرور جديدة','nieuw wachtwoord','новый пароль','新密码','Yeni şifre','nova senha','Új jelszó','nouveau mot de passe','νέο κωδικό','Neues Passwort','nuova password','รหัสผ่านใหม่','نیا پاس ورڈ','नया पासवर्ड','novum password','kata sandi baru','新しいパスワード','새 암호'),
('203','confirm_new_password','confirm new password','নতুন পাসওয়ার্ড নিশ্চিত করুন','confirmar nueva contraseña','تأكيد كلمة المرور الجديدة','Bevestig nieuw wachtwoord','подтвердить новый пароль','确认新密码','yeni parolayı onaylayın','confirmar nova senha','erősítse meg az új jelszót','confirmer le nouveau mot de passe','επιβεβαιώσετε το νέο κωδικό','Bestätigen eines neuen Kennwortes','conferma la nuova password','ยืนยันรหัสผ่านใหม่','نئے پاس ورڈ کی توثیق','नए पासवर्ड की पुष्टि','confirma novum password','konfirmasi password baru','新しいパスワードを確認','새 암호를 확인합니다'),
('204','update_password','update password','পাসওয়ার্ড আপডেট','actualizar la contraseña','تحديث كلمة السر','updaten wachtwoord','обновить пароль','更新密码','Parolanızı güncellemek','atualizar senha','frissíti jelszó','mettre à jour le mot de passe','ενημερώσετε τον κωδικό πρόσβασης','Kennwort aktualisieren','aggiornare la password','ปรับปรุงรหัสผ่าน','پاس اپ ڈیٹ','पासवर्ड अद्यतन','scelerisque eget','memperbarui sandi','パスワードを更新','암호를 업데이트'),
('205','teacher_dashboard','teacher dashboard','শিক্ষক ড্যাশবোর্ড','tablero maestro','لوحة أجهزة القياس المعلم','leraar dashboard','учитель приборной панели','老师仪表板','öğretmen pano','dashboard professor','tanár műszerfal','enseignant tableau de bord','ταμπλό των εκπαιδευτικών','Lehrer-Dashboard','dashboard insegnante','กระดานครู','استاد ڈیش بورڈ','शिक्षक डैशबोर्ड','magister Dashboard','dashboard guru','教師のダッシュボード','교사 대시 보드'),
('206','backup_restore_help','backup restore help','ব্যাকআপ পুনঃস্থাপন সাহায্য','copia de seguridad restaurar ayuda','استعادة النسخ الاحتياطي المساعدة','backup helpen herstellen','восстановить резервную копию помощь','备份恢复的帮助','yedekleme yardım geri','de backup restaurar ajuda','Backup Restore segítségével','restauration de sauvegarde de l\'aide','επαναφοράς αντιγράφων ασφαλείας βοήθεια','Backup wiederherstellen Hilfe','Backup Restore aiuto','การสำรองข้อมูลเรียกคืนความช่วยเหลือ','بیک اپ کی مدد بحال','बैकअप मदद बहाल','auxilium tergum restituunt','backup restore bantuan','バックアップヘルプを復元','백업 도움을 복원'),
('207','student_dashboard','student dashboard','ছাত্র ড্যাশবোর্ড','salpicadero estudiante','لوحة القيادة الطلابية','student dashboard','студент приборной панели','学生的仪表板','Öğrenci paneli','dashboard estudante','tanuló műszerfal','tableau de bord de l\'élève','ταμπλό των φοιτητών','Schüler Armaturenbrett','studente dashboard','แผงควบคุมนักเรียน','طالب علم کے ڈیش بورڈ','छात्र डैशबोर्ड','Discipulus Dashboard','dashboard mahasiswa','学生のダッシュボード','학생 대시 보드'),
('208','parent_dashboard','parent dashboard','অভিভাবক ড্যাশবোর্ড','salpicadero padres','لوحة أجهزة القياس الأم','ouder dashboard','родитель приборной панели','家长仪表板','ebeveyn kontrol paneli','dashboard pai','szülő műszerfal','parent tableau de bord','μητρική ταμπλό','Mutter Armaturenbrett','dashboard genitore','แผงควบคุมของผู้ปกครอง','والدین کے ڈیش بورڈ','माता - पिता डैशबोर्ड','Dashboard parent','orangtua dashboard','親ダッシュ','부모 대시 보드'),
('209','view_marks','view marks','দেখুন চিহ্ন','Vista marcas','علامات رأي','view merken','вид знаки','鉴于商标','görünümü işaretleri','vista marcas','view jelek','Vue marques','σήματα άποψη','Ansicht Marken','Vista marchi','เครื่องหมายมุมมอง','دیکھیں نشانات','देखने के निशान','propter signa','lihat tanda','ビューマーク','보기 마크'),
('210','delete_language','delete language','ভাষা মুছতে','eliminar el lenguaje','حذف اللغة','verwijderen taal','удалить язык','删除语言','dili silme','excluir língua','törlése nyelv','supprimer la langue','διαγραφή γλώσσα','Sprache löschen','eliminare lingua','ลบภาษา','زبان کو خارج کر دیں','भाषा को हटाना','linguam turpis','menghapus bahasa','言語を削除する','언어를 삭제'),
('211','settings_updated','settings updated','সেটিংস আপডেট','configuración actualizado','الإعدادات المحدثة','instellingen bijgewerkt','Настройки обновлены','设置更新','ayarları güncellendi','definições atualizadas','beállítások frissítve','paramètres mis à jour','Ρυθμίσεις ενημέρωση','Einstellungen aktualisiert','impostazioni aggiornate','การตั้งค่าการปรับปรุง','ترتیبات کی تازہ کاری','सेटिंग्स अद्यतन','venenatis eu','pengaturan diperbarui','設定が更新','설정이 업데이트'),
('212','update_phrase','update phrase','আপডেট ফ্রেজ','actualización de la frase','تحديث العبارة','Update zin','обновление фраза','更新短语','güncelleme ifade','atualização frase','frissítést kifejezés','mise à jour phrase','ενημέρωση φράση','Update Begriff','aggiornamento frase','ปรับปรุงวลี','اپ ڈیٹ جملہ','अद्यतन वाक्यांश','eget dictum','frase pembaruan','更新フレーズ','업데이트 구문'),
('213','login_failed','login failed','লগইন ব্যর্থ হয়েছে','Error de acceso','فشل تسجيل الدخول','inloggen is mislukt','Ошибка входа','登录失败','giriş başarısız oldu','Falha no login','bejelentkezés sikertelen','Échec de la connexion','Είσοδος απέτυχε','Fehler bei der Anmeldung','Accesso non riuscito','เข้าสู่ระบบล้มเหลว','لاگ ان ناکام','लॉगिन विफल','tincidunt defecit','Login gagal','ログインに失敗しました','로그인 실패'),
('214','live_chat','live chat','লাইভ চ্যাট','chat en vivo','الدردشة الحية','live chat','Онлайн-чат','即时聊天','canlı sohbet','chat ao vivo','élő chat','chat en direct','live chat','Live-Chat','live chat','อยู่สนทนา','لائیو چیٹ','लाइव चैट','Vivamus nibh','live chat','ライブチャット','라이브 채팅'),
('215','client 1','client 1','ক্লায়েন্টের 1','cliente 1','العميل 1','client 1','Клиент 1','客户端1','istemcisi 1','cliente 1','ügyfél 1','client 1','πελάτη 1','Client 1','client 1','ลูกค้า 1','کلائنٹ 1','ग्राहक 1','I huius','client 1','クライアント1','클라이언트 1'),
('216','buyer','buyer','ক্রেতা','comprador','مشتر','koper','покупатель','买方','alıcı','comprador','vevő','acheteur','αγοραστής','Käufer','compratore','ผู้ซื้อ','خریدار','खरीददार','qui emit,','pembeli','バイヤー','구매자'),
('217','purchase_code','purchase code','ক্রয় কোড','código de compra','كود الشراء','aankoop code','покупка код','申购代码','satın alma kodu','código de compra','vásárlási kódot','code d\'achat','Κωδικός αγορά','Kauf-Code','codice di acquisto','รหัสการสั่งซื้อ','خریداری کے کوڈ','खरीद कोड','Mauris euismod','kode pembelian','購入コード','구매 코드'),
('218','system_email','system email','সিস্টেম ইমেইল','correo electrónico del sistema','نظام البريد الإلكتروني','systeem e-mail','система электронной почты','邮件系统','sistem e-posta','e-mail do sistema','a rendszer az e-mail','email de système','e-mail συστήματος','E-Mail-System','email sistema','อีเมล์ระบบ','نظام کی ای میل','प्रणाली ईमेल','Praesent sit amet','email sistem','システムの電子メール','시스템 전자 메일'),
('219','option','option','বিকল্প','opción','خيار','optie','вариант','选项','seçenek','opção','opció','option','επιλογή','Option','opzione','ตัวเลือกที่','آپشن','विकल्प','optio','pilihan','オプション','선택권'),
('220','edit_phrase','edit phrase','সম্পাদনা ফ্রেজ','edit frase','تحرير العبارة','bewerk zin','править фраза','编辑语','edit ifade','edição frase','szerkesztés kifejezés','modifier phrase','edit φράση','edit Begriff','modifica frase','แก้ไขวลี','ترمیم کے جملہ','संपादित वाक्यांश','edit phrase','mengedit frase','編集フレーズ','편집 구'),
('221','forgot_your_password','Forgot Your Password','','','','','','','','','','','','','','','','','','','',''),
('222','forgot_password','Forgot Password','','','','','','','','','','','','','','','','','','','',''),
('223','back_to_login','Back To Login','','','','','','','','','','','','','','','','','','','',''),
('224','return_to_login_page','Return to Login Page','','','','','','','','','','','','','','','','','','','',''),
('225','admit_student','Admit Student','','','','','','','','','','','','','','','','','','','',''),
('226','admit_bulk_student','Admit Bulk Student','','','','','','','','','','','','','','','','','','','',''),
('227','student_information','Student Information','','','','','','','','','','','','','','','','','','','',''),
('228','student_marksheet','Student Mark Sheet','','','','','','','','','','','','','','','','','','','',''),
('229','daily_attendance','Daily Attendance','','','','','','','','','','','','','','','','','','','',''),
('230','exam_grades','','','','','','','','','','','','','','','','','','','','',''),
('231','message','','','','','','','','','','','','','','','','','','','','',''),
('232','general_settings','','','','','','','','','','','','','','','','','','','','',''),
('233','language_settings','','','','','','','','','','','','','','','','','','','','',''),
('234','edit_profile','','','','','','','','','','','','','','','','','','','','',''),
('235','event_schedule','','','','','','','','','','','','','','','','','','','','',''),
('236','cancel','','','','','','','','','','','','','','','','','','','','',''),
('237','addmission_form','','','','','','','','','','','','','','','','','','','','',''),
('238','value_required','','','','','','','','','','','','','','','','','','','','',''),
('239','select','','','','','','','','','','','','','','','','','','','','',''),
('240','gender','','','','','','','','','','','','','','','','','','','','',''),
('241','add_bulk_student','','','','','','','','','','','','','','','','','','','','',''),
('242','student_bulk_add_form','','','','','','','','','','','','','','','','','','','','',''),
('243','select_excel_file','','','','','','','','','','','','','','','','','','','','',''),
('244','upload_and_import','','','','','','','','','','','','','','','','','','','','',''),
('245','manage_classes','','','','','','','','','','','','','','','','','','','','',''),
('246','manage_sections','','','','','','','','','','','','','','','','','','','','',''),
('247','add_new_teacher','','','','','','','','','','','','','','','','','','','','',''),
('248','section_name','','','','','','','','','','','','','','','','','','','','',''),
('249','nick_name','','','','','','','','','','','','','','','','','','','','',''),
('250','add_new_section','','','','','','','','','','','','','','','','','','','','',''),
('251','add_section','','','','','','','','','','','','','','','','','','','','',''),
('252','update','','','','','','','','','','','','','','','','','','','','',''),
('253','section','','','','','','','','','','','','','','','','','','','','',''),
('254','select_class_first','','','','','','','','','','','','','','','','','','','','',''),
('255','parent_information','','','','','','','','','','','','','','','','','','','','',''),
('256','relation','','','','','','','','','','','','','','','','','','','','',''),
('257','add_form','','','','','','','','','','','','','','','','','','','','',''),
('258','all_parents','','','','','','','','','','','','','','','','','','','','',''),
('259','parents','','','','','','','','','','','','','','','','','','','','',''),
('260','add_new_parent','','','','','','','','','','','','','','','','','','','','',''),
('261','add_new_student','','','','','','','','','','','','','','','','','','','','',''),
('262','all_students','','','','','','','','','','','','','','','','','','','','',''),
('263','view_marksheet','','','','','','','','','','','','','','','','','','','','',''),
('264','text_align','','','','','','','','','','','','','','','','','','','','',''),
('265','clickatell_username','','','','','','','','','','','','','','','','','','','','',''),
('266','clickatell_password','','','','','','','','','','','','','','','','','','','','',''),
('267','clickatell_api_id','','','','','','','','','','','','','','','','','','','','',''),
('268','sms_settings','','','','','','','','','','','','','','','','','','','','',''),
('269','data_updated','','','','','','','','','','','','','','','','','','','','',''),
('270','data_added_successfully','','','','','','','','','','','','','','','','','','','','',''),
('271','edit_notice','','','','','','','','','','','','','','','','','','','','',''),
('272','private_messaging','','','','','','','','','','','','','','','','','','','','',''),
('273','messages','','','','','','','','','','','','','','','','','','','','',''),
('274','new_message','','','','','','','','','','','','','','','','','','','','',''),
('275','write_new_message','','','','','','','','','','','','','','','','','','','','',''),
('276','recipient','','','','','','','','','','','','','','','','','','','','',''),
('277','select_a_user','','','','','','','','','','','','','','','','','','','','',''),
('278','write_your_message','','','','','','','','','','','','','','','','','','','','',''),
('279','send','','','','','','','','','','','','','','','','','','','','',''),
('280','current_password','','','','','','','','','','','','','','','','','','','','',''),
('281','exam_marks','','','','','','','','','','','','','','','','','','','','',''),
('282','marks_obtained','','','','','','','','','','','','','','','','','','','','',''),
('283','total_marks','','','','','','','','','','','','','','','','','','','','',''),
('284','comments','','','','','','','','','','','','','','','','','','','','',''),
('285','theme_settings','','','','','','','','','','','','','','','','','','','','',''),
('286','select_theme','','','','','','','','','','','','','','','','','','','','',''),
('287','theme_selected','','','','','','','','','','','','','','','','','','','','',''),
('288','language_list','','','','','','','','','','','','','','','','','','','','',''),
('289','payment_cancelled','','','','','','','','','','','','','','','','','','','','',''),
('290','study_material','','','','','','','','','','','','','','','','','','','','',''),
('291','download','','','','','','','','','','','','','','','','','','','','',''),
('292','select_a_theme_to_make_changes','','','','','','','','','','','','','','','','','','','','',''),
('293','manage_daily_attendance','','','','','','','','','','','','','','','','','','','','',''),
('294','select_date','','','','','','','','','','','','','','','','','','','','',''),
('295','select_month','','','','','','','','','','','','','','','','','','','','',''),
('296','select_year','','','','','','','','','','','','','','','','','','','','',''),
('297','manage_attendance','','','','','','','','','','','','','','','','','','','','',''),
('298','twilio_account','','','','','','','','','','','','','','','','','','','','',''),
('299','authentication_token','','','','','','','','','','','','','','','','','','','','',''),
('300','registered_phone_number','','','','','','','','','','','','','','','','','','','','',''),
('301','select_a_service','','','','','','','','','','','','','','','','','','','','',''),
('302','active','','','','','','','','','','','','','','','','','','','','',''),
('303','disable_sms_service','','','','','','','','','','','','','','','','','','','','',''),
('304','not_selected','','','','','','','','','','','','','','','','','','','','',''),
('305','disabled','','','','','','','','','','','','','','','','','','','','',''),
('306','present','','','','','','','','','','','','','','','','','','','','',''),
('307','absent','','','','','','','','','','','','','','','','','','','','',''),
('308','accounting','','','','','','','','','','','','','','','','','','','','',''),
('309','income','','','','','','','','','','','','','','','','','','','','',''),
('310','expense','','','','','','','','','','','','','','','','','','','','',''),
('311','incomes','','','','','','','','','','','','','','','','','','','','',''),
('312','invoice_informations','','','','','','','','','','','','','','','','','','','','',''),
('313','payment_informations','','','','','','','','','','','','','','','','','','','','',''),
('314','total','','','','','','','','','','','','','','','','','','','','',''),
('315','enter_total_amount','','','','','','','','','','','','','','','','','','','','',''),
('316','enter_payment_amount','','','','','','','','','','','','','','','','','','','','',''),
('317','payment_status','','','','','','','','','','','','','','','','','','','','',''),
('318','method','','','','','','','','','','','','','','','','','','','','',''),
('319','cash','','','','','','','','','','','','','','','','','','','','',''),
('320','check','','','','','','','','','','','','','','','','','','','','',''),
('321','card','','','','','','','','','','','','','','','','','','','','',''),
('322','data_deleted','','','','','','','','','','','','','','','','','','','','',''),
('323','total_amount','','','','','','','','','','','','','','','','','','','','',''),
('324','take_payment','','','','','','','','','','','','','','','','','','','','',''),
('325','payment_history','','','','','','','','','','','','','','','','','','','','',''),
('326','amount_paid','','','','','','','','','','','','','','','','','','','','',''),
('327','due','','','','','','','','','','','','','','','','','','','','',''),
('328','payment_successfull','','','','','','','','','','','','','','','','','','','','',''),
('329','creation_date','','','','','','','','','','','','','','','','','','','','',''),
('330','invoice_entries','','','','','','','','','','','','','','','','','','','','',''),
('331','paid_amount','','','','','','','','','','','','','','','','','','','','',''),
('332','send_sms_to_all','','','','','','','','','','','','','','','','','','','','',''),
('333','yes','','','','','','','','','','','','','','','','','','','','',''),
('334','no','','','','','','','','','','','','','','','','','','','','',''),
('335','activated','','','','','','','','','','','','','','','','','','','','',''),
('336','sms_service_not_activated','','','','','','','','','','','','','','','','','','','','',''),
('337','add_study_material','','','','','','','','','','','','','','','','','','','','',''),
('338','file','','','','','','','','','','','','','','','','','','','','',''),
('339','file_type','','','','','','','','','','','','','','','','','','','','',''),
('340','select_file_type','','','','','','','','','','','','','','','','','','','','',''),
('341','image','','','','','','','','','','','','','','','','','','','','',''),
('342','doc','','','','','','','','','','','','','','','','','','','','',''),
('343','pdf','','','','','','','','','','','','','','','','','','','','',''),
('344','excel','','','','','','','','','','','','','','','','','','','','',''),
('345','other','','','','','','','','','','','','','','','','','','','','',''),
('346','expenses','','','','','','','','','','','','','','','','','','','','',''),
('347','add_new_expense','','','','','','','','','','','','','','','','','','','','',''),
('348','add_expense','','','','','','','','','','','','','','','','','','','','',''),
('349','edit_expense','','','','','','','','','','','','','','','','','','','','',''),
('350','total_mark','','','','','','','','','','','','','','','','','','','','',''),
('351','send_marks_by_sms','','','','','','','','','','','','','','','','','','','','',''),
('352','send_marks','','','','','','','','','','','','','','','','','','','','',''),
('353','select_receiver','','','','','','','','','','','','','','','','','','','','',''),
('354','students','','','','','','','','','','','','','','','','','','','','',''),
('355','marks_of','','','','','','','','','','','','','','','','','','','','',''),
('356','for','','','','','','','','','','','','','','','','','','','','',''),
('357','message_sent','','','','','','','','','','','','','','','','','','','','',''),
('358','expense_category','','','','','','','','','','','','','','','','','','','','',''),
('359','add_new_expense_category','','','','','','','','','','','','','','','','','','','','',''),
('360','add_expense_category','','','','','','','','','','','','','','','','','','','','',''),
('361','category','','','','','','','','','','','','','','','','','','','','',''),
('362','select_expense_category','','','','','','','','','','','','','','','','','','','','',''),
('363','message_sent!','','','','','','','','','','','','','','','','','','','','',''),
('364','reply_message','','','','','','','','','','','','','','','','','','','','',''),
('365','account_updated','','','','','','','','','','','','','','','','','','','','',''),
('366','upload_logo','','','','','','','','','','','','','','','','','','','','',''),
('367','upload','Upload','','','','','','','','','','','','','','','','','','','',''),
('368','study_material_info_saved_successfuly','','','','','','','','','','','','','','','','','','','','',''),
('369','edit_study_material','','','','','','','','','','','','','','','','','','','','',''),
('370','default_theme','','','','','','','','','','','','','','','','','','','','',''),
('371','default','','','','','','','','','','','','','','','','','','','','',''); 


DROP TABLE IF EXISTS `library_membership`;
CREATE TABLE `library_membership` (
  `membership_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(200) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `date_issue` date NOT NULL,
  `membership_categories` varchar(100) NOT NULL,
  `membership_is` varchar(200) NOT NULL,
  `decalaration` varchar(255) NOT NULL,
  PRIMARY KEY (`membership_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `library_membership` VALUES ('1','uu','0','uu@g.com','656546','2016-08-09','nhgh','gfdg','fgd'); 


DROP TABLE IF EXISTS `login`;
CREATE TABLE `login` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `role` varchar(200) NOT NULL,
  `last_login_date` date NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `login` VALUES ('1','dave','dave@test.com','dave','admin','2018-05-09','1'),
('2','John','john@test.com','john','developer','2018-05-09','1'); 


DROP TABLE IF EXISTS `mark`;
CREATE TABLE `mark` (
  `mark_id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `mark_obtained` int(11) NOT NULL DEFAULT 0,
  `mark_total` int(11) NOT NULL DEFAULT 100,
  `comment` longtext NOT NULL,
  PRIMARY KEY (`mark_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `message_thread_code` longtext NOT NULL,
  `message` longtext NOT NULL,
  `sender` longtext NOT NULL,
  `timestamp` longtext NOT NULL,
  `read_status` int(11) NOT NULL DEFAULT 0 COMMENT '0 unread 1 read',
  `message_date` date NOT NULL,
  `message_url` varchar(255) NOT NULL DEFAULT 'http://artify.com',
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `message` VALUES ('1','x0001','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.','john','','0','2019-03-01','http://artify.com'),
('2','x0002','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.','john','','0','2019-03-02','http://artify.com'),
('3','x0003','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.','john','','0','2019-03-03','http://artify.com'),
('4','x0004','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.','john','','0','2019-03-04','http://artify.com'); 


DROP TABLE IF EXISTS `message_thread`;
CREATE TABLE `message_thread` (
  `message_thread_id` int(11) NOT NULL AUTO_INCREMENT,
  `message_thread_code` longtext NOT NULL,
  `sender` longtext NOT NULL,
  `reciever` longtext NOT NULL,
  `last_message_timestamp` longtext NOT NULL,
  PRIMARY KEY (`message_thread_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



DROP TABLE IF EXISTS `multi_lang`;
CREATE TABLE `multi_lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `multi_lang` VALUES ('3','כותרת','כותרת\r\n'),
('4','título','título'),
('5','заглавие','заглавие\r\n'),
('6','عنوان','عنوان'),
('7','otsikko','otsikko'),
('8','cím','cím'),
('9','표제','표제\r\n'); 


DROP TABLE IF EXISTS `multilang`;
CREATE TABLE `multilang` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;



DROP TABLE IF EXISTS `multilang_myisam`;
CREATE TABLE `multilang_myisam` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `descripption` varchar(255) CHARACTER SET utf16 COLLATE utf16_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



DROP TABLE IF EXISTS `noticeboard`;
CREATE TABLE `noticeboard` (
  `notice_id` int(11) NOT NULL AUTO_INCREMENT,
  `notice_title` longtext NOT NULL,
  `notice` longtext NOT NULL,
  `create_timestamp` int(11) NOT NULL,
  PRIMARY KEY (`notice_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



DROP TABLE IF EXISTS `order_change`;
CREATE TABLE `order_change` (
  `order_id` bigint(20) NOT NULL,
  `exchange_id` bigint(20) NOT NULL,
  `order_number` bigint(20) NOT NULL,
  `requisition_number` bigint(20) NOT NULL,
  `company_name` varchar(200) NOT NULL,
  `contact_name` varchar(200) NOT NULL,
  `contact_number` varchar(200) NOT NULL,
  `address` varchar(200) NOT NULL,
  `address_line2` varchar(200) NOT NULL,
  `ciry` varchar(100) NOT NULL,
  `zip_code` varchar(50) NOT NULL,
  `your_name` varchar(100) NOT NULL,
  `email_address` varchar(200) NOT NULL,
  `reason_for_change` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



DROP TABLE IF EXISTS `orderdetails`;
CREATE TABLE `orderdetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_no` int(11) NOT NULL,
  `productCode` varchar(15) NOT NULL,
  `quantityOrdered` int(11) NOT NULL,
  `priceEach` double NOT NULL,
  `orderLineNumber` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `orderdetails` VALUES ('1','12336','34','34','3','33'),
('2','12336','24','34','3','33'),
('3','12336','14','34','3','33'),
('4','578','198409','46','545','0'),
('5','93062','9089','89','9080','0'),
('6','76778','8903_G','32','332','0'),
('7','66729','h_9090','22','322','0'),
('8','72881','F_23','333','5','0'),
('9','96349','S18409','331','212','0'); 


DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `order_no` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `customer_name` varchar(250) NOT NULL,
  `order_amount` decimal(10,0) NOT NULL,
  `order_status` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=142 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `orders` VALUES ('39','578','2016-09-30','Xenos Clarke','943','Completed'),
('40','93062','2016-09-08','Cooper Jensen','32','qsdCompleted'),
('41','76778','2016-09-08','Deacon Tyson','77','Pending'),
('42','66729','2024-01-09','Dawn Potter','45','Completed'),
('43','62940','2016-09-08','Zane Calderon','20','Completed'),
('44','22241','2016-09-08','Cecilia Carney','29','Completed'),
('45','40334','2016-09-08','Connor Marquez','87','Completed'),
('46','30771','2016-09-08','Gillian Kirk','461','Completed'),
('47','96349','2016-09-08','Wallace Gillespie','71','Completed'),
('48','72881','2016-09-08','Risa Ayers','18','Completed'),
('49','3691','2016-09-08','Callum Solomon','75','Completed'),
('50','77099','2016-09-08','Nola Rojas','20','Completed'),
('51','37429','2016-09-08','Talon Rowland','77','Completed'),
('52','44144','2016-09-08','Cheryl Bowers','26','Completed'),
('53','62391','2016-09-08','Bree Gaines','96','Completed'),
('54','54999','2016-09-08','Lacota Bonner','5','Completed'),
('55','83323','2016-09-08','Bradley Freeman','37','Completed'),
('56','409','2016-09-08','Jasper Santiago','68','Completed'),
('57','50683','2016-09-08','Hilary Conner','28','Completed'),
('58','931435','2016-09-08','Zena Fox','37','Completed'),
('59','48121','2016-09-08','Britanni Schmidt','1','Completed'),
('60','74815','2016-09-08','Caleb Lynn','95','Completed'),
('61','37748','2016-09-08','Madeson Robbins','73','Completed'),
('62','34490','2016-09-08','Emily Richmond','77','Completed'),
('63','37920','2016-09-08','Damian Wilson','67','Completed'),
('64','28431','2016-09-08','Mikayla Mendez','5','Completed'),
('65','94701','2016-09-08','Igor Gutierrez','25','Completed'),
('66','36440','2016-09-08','Heather Terrell','8','Completed'),
('67','37251','2016-09-08','Rose Barry','64','Completed'),
('68','35643','2016-09-08','Bernard Gilmore','95','Completed'),
('69','9551','2016-09-08','Meghan Mack','89','Completed'),
('70','44898','2016-09-08','Lillith Terrell','43','Completed'),
('71','91617','2016-09-08','Jaquelyn James','57','Completed'),
('72','78062','2016-09-08','Karly Beard','56','Completed'),
('73','87594','2016-09-08','Kareem Cooke','7','Completed'),
('74','24386','2016-09-08','Amethyst Bass','70','Completed'),
('75','49890','2016-09-08','Silas Bates','27','Completed'),
('76','42911','2016-09-08','Sybil Watts','24','Completed'),
('77','75674','2016-09-08','Warren Hays','39','Completed'),
('78','65775','2016-09-08','Kirsten Martin','25','Completed'),
('79','37102','2016-09-08','Cade Lowe','7','Completed'),
('80','74040','2016-09-08','Penelope Moss','59','Completed'),
('81','89592','2016-09-08','Chase Andrews','76','Completed'),
('82','84334','2016-09-08','Fatima Mcconnell','4','Completed'),
('83','91414','2016-09-08','Kelly Garcia','91','Completed'),
('84','89834','2016-09-08','Aubrey Leblanc','41','Completed'),
('85','71212','2016-09-08','Cassidy Dyer','33','Completed'),
('86','14459','2016-09-08','Rina Lawrence','43','Completed'),
('87','22844','2016-09-08','Malcolm Richard','17','Completed'),
('88','43892','2016-09-08','Avye Fowler','55','Completed'),
('89','72412','2016-09-08','Jeremy Randolph','22','Completed'),
('90','64889','2016-09-08','Ray Clayton','46','Completed'),
('91','5518','2016-09-08','Lynn Turner','64','Completed'),
('92','91680','2016-09-08','Eric Guzman','84','Completed'),
('93','31014','2016-09-08','Daphne Preston','27','Completed'),
('94','92194','2016-09-08','Ivy Vazquez','81','Completed'),
('95','12336','2016-09-08','Teegan Jimenez','26','Completed'),
('96','93197','2016-09-08','Quemby Floyd','88','Completed'),
('97','74732','2016-09-08','Aristotle Harris','62','Completed'),
('98','81261','2016-09-08','Abel Floyd','43','Completed'),
('99','21141','2016-09-08','Liberty Gomez','32','Completed'),
('128','5','2016-09-09','44','55','33'),
('131','2222','2016-12-08','sdfsdfc','0','yxcyxc'),
('134','20','2016-12-07','ason','200','ok'),
('135','1','2016-12-15','qsd','0','0'),
('138','444','2016-12-01','ppp','10','0'),
('140','1','2019-04-24','111','1','1'),
('141','1','2019-04-01','a','1','Pending'); 


DROP TABLE IF EXISTS `ordertable`;
CREATE TABLE `ordertable` (
  `orderId` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `first_name` varchar(250) NOT NULL,
  `last_name` varchar(250) NOT NULL,
  `contact_no` varchar(100) NOT NULL,
  `email` varchar(250) NOT NULL,
  `billing_address_line_1` varchar(250) NOT NULL,
  `billing_address_line_2` varchar(250) NOT NULL,
  `billing_city` varchar(250) NOT NULL,
  `billing_state` varchar(250) NOT NULL,
  `billing_country` varchar(250) NOT NULL,
  `shipping_address_line_1` varchar(250) NOT NULL,
  `shipping_address_line_2` varchar(250) NOT NULL,
  `shipping_city` varchar(250) NOT NULL,
  `shipping_state` varchar(250) NOT NULL,
  `shipping_country` varchar(250) NOT NULL,
  `order_amount` double NOT NULL,
  `order_date` date NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  `order_status` varchar(100) NOT NULL,
  PRIMARY KEY (`orderId`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `ordertable` VALUES ('1','4','Jacob','Laurel','(015746) 89038','pellentesque@mattis.co.uk','Ap #194-2394 Mauris. Street','Ap #454-7794 Diam. Road','Municipal District','Nova Scotia','Egypt','test','test','Indore','Madhya Pradesh','India','91.57620052953828','2018-02-02','cash','Completed'),
('2','3','Macaulay','Fleur','070 7621 1879','ante.Maecenas@congueelit.com','9216 Nec Avenue','190-2947 Nec St.','Jacksonville','Florida','Nepal','','','','','','63.71605448770901','2018-02-02','cash','Completed'),
('3','7','Norman','Rhiannon','(015198) 71963','sagittis.Duis.gravida@metus.org','P.O. Box 147, 9839 Mi. Rd.','307 Massa St.','Anchorage','Alaska','Gambia','','','','','','43.85167392329469','2018-02-02','cash','Completed'),
('4','10','Dane','Mona','07624 036677','elit@imperdiet.org','Ap #417-366 Praesent Rd.','628 Consectetuer Rd.','Ananindeua','PA','Vanuatu','','','','','','28.110209226710918','2018-02-02','cash','Completed'),
('5','1','Hilel','Kim','055 5404 2631','erat.eget.ipsum@atvelitPellentesque.edu','P.O. Box 171, 7773 Sollicitudin Rd.','P.O. Box 503, 4617 Odio. Rd.','Perpignan','LA','Ethiopia','','','','','','8.99602743703502','2018-02-02','cash','Completed'),
('6','5','Fritz','Carolyn','0500 956952','pellentesque@molestiedapibus.edu','Ap #926-643 Eu, Road','7085 Ultrices Av.','Chiguayante','VII','Bouvet Island','','','','','','60.64951257840685','2018-02-02','cash','Completed'),
('7','9','Edan','Constance','070 3725 3504','enim.consequat@diam.org','928 Neque Road','150 Vivamus St.','Okene','KO','Honduras','','','','','','76.25948365429367','2018-02-02','cash','Completed'),
('8','1','Ali','Orla','0800 300 1817','tellus.non@lacus.edu','248-1387 Montes, St.','314-1855 Laoreet Av.','Berlin','Berlin','Palau','','','','','','99.34888360961236','2018-02-02','cash','Completed'),
('9','3','Jacob','Sharon','07055 742912','fringilla.purus.mauris@ametfaucibusut.edu','7530 Dictum St.','Ap #906-8323 Amet Ave','Townsville','Queensland','San Marino','','','','','','67.96597015854528','2018-02-02','cash','Completed'),
('10','2','Warren','McKenzie','(0110) 386 7822','sem.consequat.nec@infaucibus.edu','1880 Aliquam Avenue','7885 Ut, Street','Guarapuava','PR','Slovakia','','','','','','41.78320303725377','2018-02-02','cash','Completed'),
('11','3','Reece','Tana','0800 1111','Vivamus@egetodio.edu','2999 Morbi Ave','Ap #542-7415 Quam, St.','Tumba','Stockholms län','Laos','','','','','','5.018107783997531','2018-02-02','cash','Completed'),
('12','3','Jasper','Hanna','0500 142091','lacus.Quisque@PraesentluctusCurabitur.co.uk','Ap #450-344 Ante, Road','P.O. Box 279, 5034 Aenean Avenue','Kapolei','HI','Samoa','','','','','','99.74093288159085','2018-02-02','cash','Completed'),
('13','5','Rudyard','Hillary','(0119) 043 2756','scelerisque.scelerisque@convallisestvitae.co.uk','8106 Eleifend. Street','141-9609 Euismod Avenue','Bremen','HB','Mongolia','','','','','','83.65034412932614','2018-02-02','cash','Completed'),
('14','6','Marshall','Leah','055 0178 2540','mauris.elit.dictum@tinciduntorciquis.org','Ap #164-2933 Arcu. Street','995-4292 Sed Road','Brandon','Manitoba','Mauritius','','','','','','19.02892507522267','2018-02-02','cash','Completed'),
('15','3','Cade','Astra','07624 617661','massa.Suspendisse.eleifend@porttitorinterdum.co.uk','Ap #974-5271 Dictum Av.','673-8553 Rutrum. St.','Castlegar','British Columbia','French Polynesia','','','','','','44.19359606149941','2018-02-02','cash','Completed'),
('16','3','Caesar','Ciara','055 1193 8666','turpis.egestas@utsemNulla.edu','235 Aliquam St.','Ap #284-6418 Rhoncus Street','Osasco','São Paulo','Switzerland','','','','','','63.88120815519356','2018-02-02','cash','Completed'),
('17','10','Herrod','Alana','0831 391 2609','nec@neque.ca','905-6788 Tempus Rd.','3422 Mi Avenue','Lakeshore','Ontario','Namibia','','','','','','86.82525566483406','2018-02-02','cash','Completed'),
('18','9','Bradley','Blaine','0800 1111','nunc.id@eulacus.edu','265-2927 Dui Rd.','6350 Aliquam Road','Budaun','UP','Belarus','','','','','','42.48265693195412','2018-02-02','cash','Completed'),
('19','3','Perry','Desirae','0845 46 45','netus.et@vulputateeu.edu','4707 Id, Road','5109 Sagittis St.','Issy-les-Moulineaux','IL','Kyrgyzstan','','','','','','51.937520738632905','2018-02-02','cash','Completed'),
('20','3','Coby','Athena','0800 255126','vehicula.aliquet@Aliquamnisl.com','237-4958 Iaculis Street','415-961 Justo Road','Eluru','AP','Barbados','','','','','','32.23963597066666','2018-02-02','cash','Completed'),
('21','7','Mufutau','Amethyst','0894 262 4695','Fusce@quam.edu','3815 Tempus, Rd.','1408 Ac Ave','Yerbas Buenas','Maule','Lithuania','','','','','','5.385620710799118','2018-02-02','cash','Completed'),
('22','10','Walker','Mona','0991 512 2135','eu@idenimCurabitur.org','7146 Vitae, Av.','410-7970 Mauris, Rd.','Katowice','Sl?skie','Trinidad and Tobago','','','','','','30.209198715360092','2018-02-02','cash','Completed'),
('23','4','Otto','Joelle','055 2276 1449','faucibus.orci@purus.ca','2351 Curabitur Road','P.O. Box 371, 9988 At, Street','Laren','Noord Holland','Georgia','','','','','','34.88913451776759','2018-02-02','cash','Completed'),
('24','1','Eric','Mariko','(01930) 56134','hymenaeos.Mauris@risusat.edu','847-3412 Mauris Rd.','824-6566 Mi. Avenue','Krishnanagar','West Bengal','Italy','','','','','','83.8180795161222','2018-02-02','cash','Completed'),
('25','10','Zachery','Kirsten','0800 323 5612','Cum.sociis@hendrerita.ca','Ap #572-2921 Vestibulum Av.','P.O. Box 489, 2749 Gravida Rd.','Gonnosnò','Sardegna','Namibia','','','','','','14.422997100672683','2018-02-02','cash','Completed'),
('26','7','Thane','Callie','0845 46 44','Sed@pedeetrisus.net','849-959 Proin Avenue','2000 Ac Rd.','Cañas','G','Cocos (Keeling) Islands','','','','','','20.66075002836133','2018-02-02','cash','Completed'),
('27','6','Valentine','Chanda','0800 1111','vitae@consectetueradipiscing.edu','1015 Lobortis Av.','Ap #637-8293 Est Street','Hartford','Connecticut','Turks and Caicos Islands','','','','','','60.034761913153126','2018-02-02','cash','Completed'),
('28','8','Quentin','Chastity','055 4583 1259','eros.nec.tellus@interdumNuncsollicitudin.net','736-2819 Tellus Road','Ap #511-1945 Mauris Rd.','Independencia','Metropolitana de Santiago','Croatia','','','','','','38.19156255404611','2018-02-02','cash','Completed'),
('29','6','Acton','Catherine','0999 446 9788','cursus@tempusnonlacinia.edu','5758 Dictum Av.','P.O. Box 269, 3109 Ac Street','Vitacura','Metropolitana de Santiago','Paraguay','','','','','','10.853530104135658','2018-02-02','cash','Completed'),
('30','6','Aquila','Neve','0974 262 8371','habitant@imperdietnec.ca','500-2633 Quis, Avenue','Ap #374-5075 Etiam St.','Marbella','AN','Burkina Faso','','','','','','39.692965931904475','2018-02-02','cash','Completed'),
('31','8','Melvin','Wendy','0800 1111','enim@litoratorquent.co.uk','P.O. Box 343, 178 Ullamcorper, Road','1869 Metus. Ave','Sosnowiec','Sl?skie','Madagascar','','','','','','65.90424242047989','2018-02-02','cash','Completed'),
('32','4','Quinn','Pearl','0800 475 3836','rhoncus.Donec.est@auctor.edu','9319 Sapien, Ave','849-2949 Aenean Avenue','Bremerhaven','HB','France','','','','','','10.442317380050493','2018-02-02','cash','Completed'),
('33','4','Upton','Abigail','0949 971 0042','Maecenas.ornare.egestas@aliquet.ca','P.O. Box 830, 7909 Phasellus Street','P.O. Box 911, 9522 Orci. St.','Port Hope','Ontario','Afghanistan','','','','','','54.49886271217732','2018-02-02','cash','Completed'),
('34','8','Bruce','Stephanie','0800 237 4378','diam.dictum.sapien@nullavulputatedui.ca','626-9650 Mauris Rd.','363-9445 Vitae, St.','Salon-de-Provence','Provence-Alpes-Côte d\'Azur','Maldives','','','','','','41.16736449409962','2018-02-02','cash','Completed'),
('35','6','Baxter','Victoria','076 2134 2105','eget.dictum@nullaIn.com','799-2896 Ante. Ave','103-7198 Non Ave','Hamburg','HH','Estonia','','','','','','42.34023740733065','2018-02-02','cash','Completed'),
('36','7','Castor','Wynter','07624 098680','Nullam@id.edu','P.O. Box 873, 810 Odio, Ave','351 Lectus, Av.','San Isidro','San José','Uruguay','','','','','','88.19909662771886','2018-02-02','cash','Completed'),
('37','2','Blaze','Nyssa','076 6401 9824','sed.sapien.Nunc@non.co.uk','Ap #887-1831 Vulputate Ave','P.O. Box 439, 4234 Eros Street','Bihar Sharif','Bihar','Montenegro','','','','','','13.97477398996686','2018-02-02','cash','Completed'),
('38','8','Ulric','Hadassah','(01220) 987957','imperdiet@euduiCum.com','5245 Auctor, Ave','7146 Fermentum St.','Harrisburg','PA','Togo','','','','','','5.276583140042222','2018-02-02','cash','Completed'),
('39','4','Dylan','Sopoline','0845 46 40','tellus.lorem.eu@Sedeueros.ca','9709 Cras St.','P.O. Box 245, 8536 Quis Rd.','Rennes','Bretagne','Papua New Guinea','','','','','','84.45859680367504','2018-02-02','cash','Completed'),
('40','2','Silas','Suki','07808 205856','arcu.Sed@consectetuereuismod.co.uk','898-2096 Elementum St.','P.O. Box 622, 6919 Nullam Ave','?negöl','Bursa','Indonesia','','','','','','6.4632376716129825','2018-02-02','cash','Completed'),
('41','10','Omar','Abra','055 2348 6860','sodales.at.velit@magnaa.com','9909 Sed Street','Ap #878-740 Sit Ave','Göteborg','O','Mali','','','','','','78.94040102040432','2018-02-02','cash','Completed'),
('42','8','Dustin','Melyssa','(0171) 577 7066','Ut.tincidunt.vehicula@pedeultricesa.ca','Ap #634-1594 Dui, Rd.','5376 Donec Street','Toru?','KP','French Polynesia','','','','','','75.31229516054717','2018-02-02','cash','Completed'),
('43','10','Kennedy','Jessamine','0800 535318','pretium@mauriseuelit.net','Ap #556-2644 Fermentum St.','157-6129 Ipsum Ave','Fairbanks','AK','Israel','','','','','','39.7402758148874','2018-02-02','cash','Completed'),
('44','3','Hakeem','Jordan','070 1756 8223','orci.in@lacinia.co.uk','P.O. Box 590, 1938 Risus. Rd.','419 Scelerisque Avenue','Vienna','Wie','Azerbaijan','','','','','','72.76449666615994','2018-02-02','cash','Completed'),
('45','1','Dylan','Dorothy','(020) 8635 5904','velit@eusem.edu','Ap #454-7447 Consectetuer, St.','P.O. Box 705, 8434 Interdum. Street','Etobicoke','Ontario','Argentina','','','','','','44.60165895950204','2018-02-02','cash','Completed'),
('46','6','Dalton','Echo','0500 855113','congue.In.scelerisque@nondapibus.edu','Ap #891-1112 Nulla Rd.','7989 Ipsum Street','Colina','RM','Pitcairn Islands','','','','','','4.714807872394852','2018-02-02','cash','Completed'),
('47','2','Kato','Jordan','(01533) 290767','commodo@molestieSed.com','596-563 Ornare, Road','458-2589 Blandit Rd.','Hamburg','HH','Cook Islands','','','','','','89.76906555683264','2018-02-02','cash','Completed'),
('48','10','Addison','Ariel','(01433) 00951','volutpat.ornare@temporarcuVestibulum.edu','7267 At, St.','Ap #798-9722 Cras Street','Newcastle','New South Wales','Faroe Islands','','','','','','34.70090724034319','2018-02-02','cash','Completed'),
('49','1','Zeus','Zia','0800 895 1413','ipsum.dolor.sit@nonmagnaNam.com','3192 Semper. Rd.','Ap #539-8927 Phasellus Av.','Linlithgow','WL','Macedonia','','','','','','4.197342604582517','2018-02-02','cash','Completed'),
('50','5','Berk','Phoebe','(01583) 281307','dolor.Fusce.mi@bibendumfermentum.org','967-2907 Sagittis Road','888-2562 Eu Ave','Vienna','Vienna','Gabon','','','','','','16.883994375247504','2018-02-02','cash','Completed'),
('51','10','Kane','Ramona','0843 261 4304','vulputate.ullamcorper@Morbisit.edu','715 Nunc Avenue','Ap #746-2005 Quam Rd.','Henis','L.','Åland Islands','','','','','','71.82794713585446','2018-02-02','cash','Completed'),
('52','2','Yuli','Jenna','0800 1111','ac@euismodest.org','Ap #807-2227 Sollicitudin St.','P.O. Box 753, 2604 Dolor Av.','Lidköping','O','Albania','','','','','','8.487755626894305','2018-02-02','cash','Completed'),
('53','4','Wyatt','Iris','(0181) 071 8738','in.hendrerit@maurisblandit.org','Ap #237-5388 Felis Ave','Ap #330-461 Ipsum Av.','Artena','LAZ','Sri Lanka','','','','','','26.954939800272637','2018-02-02','cash','Completed'),
('54','4','George','Shafira','(01627) 626254','luctus@acturpisegestas.co.uk','829-2569 Purus, Ave','Ap #830-7803 Vulputate Road','Dublin','L','Martinique','','','','','','9.311435194044778','2018-02-02','cash','Completed'),
('55','10','Brenden','Inga','0800 967977','tellus.id@egetmetus.com','Ap #427-5833 Magnis St.','996-8824 Arcu. St.','Cork','M','Maldives','','','','','','65.69235964277048','2018-02-02','cash','Completed'),
('56','6','Erich','Summer','(01405) 47771','Integer@malesuadaiderat.com','461-7068 Ad Rd.','563 Pede. Rd.','Santa Maria','Rio Grande do Sul','Chile','','','','','','0.527495705082543','2018-02-02','cash','Completed'),
('57','6','Edward','Ainsley','0895 956 1101','dictum@nectellusNunc.edu','122-5836 Metus. Av.','424-3436 Nunc Av.','Warszawa','Mazowieckie','Australia','','','','','','5.560402670465785','2018-02-02','cash','Completed'),
('58','1','Brendan','Lisandra','(020) 5772 7686','dolor@ultricesmaurisipsum.net','Ap #171-9795 Cursus. Street','5764 Erat. Avenue','Desamparados','San José','United States','','','','','','26.219529310445793','2018-02-02','cash','Completed'),
('59','4','Aladdin','Dora','0323 824 2164','massa.Integer@Sed.com','2813 Arcu. Rd.','3997 Molestie St.','Bunbury','Western Australia','Uzbekistan','','','','','','14.416441614196115','2018-02-02','cash','Completed'),
('60','7','Tanner','Shelby','0800 1111','Phasellus.dapibus@mattis.org','9257 Facilisis, St.','P.O. Box 127, 3296 Duis St.','Redlands','QLD','Cambodia','','','','','','93.4236232130077','2018-02-02','cash','Completed'),
('61','8','Cadman','Whilemina','0500 295400','interdum.Sed@placeratorcilacus.ca','8124 Tellus. Ave','332-2653 Nec St.','Ife','OS','Antarctica','','','','','','23.868794295814627','2018-02-02','cash','Completed'),
('62','6','Branden','Neve','07490 024133','Donec.egestas.Duis@rutrummagnaCras.edu','P.O. Box 750, 7749 Mauris Avenue','Ap #397-6551 Donec Rd.','Timaru','South Island','Latvia','','','','','','39.073104913414554','2018-02-02','cash','Completed'),
('63','1','Darius','Maia','(01175) 59462','turpis@cursusNuncmauris.edu','3482 Suspendisse St.','1148 Orci Rd.','Salisbury','WI','Belize','','','','','','23.759144752993382','2018-02-02','cash','Completed'),
('64','2','Ryan','Fallon','0834 778 4552','sociis@Duisat.org','P.O. Box 130, 7739 Ipsum Av.','1405 Tincidunt Rd.','Balclutha','South Island','Kuwait','','','','','','1.5764120980877543','2018-02-02','cash','Completed'),
('65','4','Demetrius','Imogene','0800 1111','amet.consectetuer@nec.com','P.O. Box 907, 4959 Euismod Road','Ap #220-565 A, Avenue','Belfast','Ulster','Morocco','','','','','','36.60462930482312','2018-02-02','cash','Completed'),
('66','7','Jacob','Winter','0852 056 0760','Cum.sociis.natoque@quisdiam.ca','6798 Nunc Road','3324 Pellentesque, Road','Belfast','U','Netherlands','','','','','','78.29391330321684','2018-02-02','cash','Completed'),
('67','9','Barclay','Astra','0845 46 46','Donec.tincidunt@acorci.edu','P.O. Box 833, 6034 Arcu Rd.','344-1655 Integer St.','Parramatta','NSW','Estonia','','','','','','81.65568167497933','2018-02-02','cash','Completed'),
('68','10','Hayden','Callie','0961 352 5961','tempus.lorem@accumsan.edu','Ap #177-8215 Torquent St.','236-1520 Vestibulum. Av.','Bayswater','Western Australia','Lithuania','','','','','','73.39667153861063','2018-02-02','cash','Completed'),
('69','4','Shad','Zelda','0800 1111','hendrerit.a.arcu@tinciduntnunc.edu','224-8080 Mauris Rd.','5347 Augue Ave','Colchane','I','Albania','','','','','','22.01631574147969','2018-02-02','cash','Completed'),
('70','9','Yardley','Hilary','0890 003 2261','eu.tempor.erat@nequeSedeget.co.uk','Ap #698-2348 Eros Rd.','Ap #925-8910 Pellentesque Avenue','Pierrefonds','QC','Georgia','','','','','','89.89156716493105','2018-02-02','cash','Completed'),
('71','6','Colin','Leilani','070 3689 8062','lobortis@porttitortellusnon.ca','P.O. Box 288, 2130 Quisque Rd.','Ap #721-5559 Nulla Rd.','Heilbronn','Baden','Tokelau','','','','','','83.40889167358064','2018-02-02','cash','Completed'),
('72','8','Kermit','Sheila','070 0397 7333','quam@erosnonenim.ca','P.O. Box 631, 2444 Donec St.','P.O. Box 393, 1890 At, Ave','Slough','BK','Swaziland','','','','','','47.36975994647458','2018-02-02','cash','Completed'),
('73','6','Talon','Bell','0800 611200','Sed@Donec.net','P.O. Box 326, 4389 Sed Ave','617-6745 Ut St.','Sluis','Zl','Nigeria','','','','','','86.62212778499548','2018-02-02','cash','Completed'),
('74','10','Zephania','Latifah','(029) 6002 8193','Curae@magnaLoremipsum.co.uk','P.O. Box 653, 297 Aenean Street','Ap #882-1663 Libero. Rd.','Tauranga','NI','Martinique','','','','','','91.00136215891817','2018-02-02','cash','Completed'),
('75','8','Lucas','Tallulah','07624 418404','sollicitudin.adipiscing.ligula@iaculislacuspede.ca','237-4551 Id Street','Ap #344-8012 Nulla Road','Leoben','Stm','Malta','','','','','','95.14043051296885','2018-02-02','cash','Completed'),
('76','10','Oscar','Eleanor','0912 245 3029','Donec.consectetuer@et.ca','5840 Nullam Av.','8990 Tincidunt Av.','Alajuela','Alajuela','New Caledonia','','','','','','2.69806916145428','2018-02-02','cash','Completed'),
('77','5','Blaze','Alice','(01538) 228414','ipsum@disparturient.org','Ap #934-3786 Amet Road','Ap #855-5981 Sodales Road','Heerlen','L.','Nauru','','','','','','28.06905734172934','2018-02-02','cash','Completed'),
('78','8','Solomon','Diana','(019207) 73460','id.ante.Nunc@dolortempusnon.ca','P.O. Box 613, 2662 Sed Av.','800-1693 Consectetuer Ave','Lecce','Puglia','French Southern Territories','','','','','','32.25108229764838','2018-02-02','cash','Completed'),
('79','7','Timothy','Amethyst','0800 354473','nibh.Donec@loremeu.co.uk','975-7734 Rhoncus. Road','374-1494 Lorem Rd.','Zierikzee','Zeeland','Germany','','','','','','77.04824253641837','2018-02-02','cash','Completed'),
('80','10','Galvin','Kalia','(016977) 0383','pede@ami.org','P.O. Box 368, 7472 Libero. St.','5914 Velit. Street','Zamora','Castilla y León','Congo (Brazzaville)','','','','','','88.4879688625112','2018-02-02','cash','Completed'),
('81','1','Uriel','Desirae','0926 730 2024','fermentum@fames.co.uk','Ap #269-4487 Malesuada Rd.','7315 Magna Rd.','Vienna','Wie','American Samoa','','','','','','11.295119776665345','2018-02-02','cash','Completed'),
('82','2','Curran','Sylvia','(015233) 09926','aliquam.enim.nec@euturpisNulla.edu','3183 Blandit Av.','Ap #652-7852 Amet, Street','Palena','X','Malawi','','','','','','91.01169536915765','2018-02-02','cash','Completed'),
('83','6','Brent','Zelda','0355 014 4016','elit@iaculis.net','P.O. Box 229, 8839 Sit Avenue','P.O. Box 748, 8172 Phasellus St.','Salem','OR','Portugal','','','','','','21.173120589156746','2018-02-02','cash','Completed'),
('84','8','Elmo','Nyssa','(01629) 562741','eu@Quisqueimperdieterat.com','P.O. Box 615, 4970 Auctor, St.','P.O. Box 236, 1534 Tellus. Ave','San Cristóbal de la Laguna','CN','Gabon','','','','','','32.83051991167527','2018-02-02','cash','Completed'),
('85','5','Basil','Wynne','07253 453524','convallis.erat.eget@Ut.ca','291-9390 Vehicula Ave','313-3101 Et, Street','Raymond','Alberta','Niue','','','','','','0.633240864270591','2018-02-02','cash','Completed'),
('86','1','Ray','Katelyn','0336 619 9967','nulla@magnatellus.org','546-7866 Nunc Rd.','578-4120 Dui. Street','H?rouxville','QC','Ecuador','','','','','','4.6746476596916535','2018-02-02','cash','Completed'),
('87','5','Adrian','Lara','0500 694157','Cras.dolor@faucibuslectus.com','1326 Etiam St.','P.O. Box 665, 8033 Ut Road','Poggiorsini','PUG','Belgium','','','','','','21.473518779010995','2018-02-02','cash','Completed'),
('88','3','Maxwell','Jael','(017439) 27229','nunc.risus.varius@lectus.net','905-8180 Donec Rd.','142-4557 Gravida St.','Kieldrecht','OV','Mexico','','','','','','93.34365398934452','2018-02-02','cash','Completed'),
('89','6','Tarik','Bianca','070 0157 4797','nunc.Quisque@Nullamvitaediam.ca','P.O. Box 195, 2536 Interdum. St.','Ap #217-673 Rhoncus. Road','Concepción','SJ','Mauritius','','','','','','2.297716683054079','2018-02-02','cash','Completed'),
('90','3','Victor','Breanna','0800 687 1898','sociis.natoque.penatibus@sit.com','P.O. Box 809, 8593 Et, Road','8097 Ornare, Rd.','Dublin','L','Djibouti','','','','','','31.457624520601357','2018-02-02','cash','Completed'),
('91','5','Ahmed','Anika','(01097) 39818','et.arcu.imperdiet@tortor.com','755-3965 Cursus Rd.','3228 Nec Street','Bundaberg','QLD','Togo','','','','','','50.394975627209035','2018-02-02','cash','Completed'),
('92','10','Holmes','Jael','07324 704125','adipiscing@leoCras.org','Ap #279-8673 Tincidunt, Av.','828-5715 Purus Ave','Albury','NSW','Namibia','','','','','','57.602007647605625','2018-02-02','cash','Completed'),
('93','9','Declan','Sylvia','07153 318063','et.rutrum@nequeet.ca','Ap #817-7720 Erat, St.','P.O. Box 760, 1755 Nunc Road','Gulfport','MS','Croatia','','','','','','36.825114429765485','2018-02-02','cash','Completed'),
('94','10','Alvin','Miriam','(017633) 99488','faucibus.orci.luctus@amet.ca','1633 Vel, Av.','P.O. Box 476, 4579 Accumsan Avenue','Tambaram','TN','Benin','','','','','','11.319552279375076','2018-02-02','cash','Completed'),
('95','4','Reese','Kessie','(026) 5363 9118','arcu.Nunc.mauris@perinceptos.edu','8776 Orci, Av.','2266 Arcu. Road','Alandur','Tamil Nadu','Chad','','','','','','46.12242118094342','2018-02-02','cash','Completed'),
('96','8','Rafael','Camilla','0906 309 4853','adipiscing@nonummy.org','6843 Et Ave','Ap #748-8486 Eget Street','Reus','Catalunya','Albania','','','','','','96.65345213995636','2018-02-02','cash','Completed'),
('97','2','Rafael','Illiana','0372 747 1664','ultricies.sem@ultricesposuere.net','Ap #891-2860 Metus Rd.','384-8225 Dolor. Road','Liberia','G','China','','','','','','44.900000230316074','2018-02-02','cash','Completed'),
('98','8','Seth','Sonya','070 5082 7973','nec@ultrices.ca','312 Nisi St.','Ap #995-3951 Nunc St.','Henley-on-Thames','OX','United Arab Emirates','','','','','','34.53964780507576','2018-02-02','cash','Completed'),
('99','4','Lionel','Bryar','0845 46 44','et.magnis.dis@vel.edu','5072 Eget St.','P.O. Box 435, 5557 Amet, St.','Rimouski','QC','Sierra Leone','','','','','','37.9982414077951','2018-02-02','cash','Completed'),
('100','2','Wayne','Ginger','(0171) 524 0640','tempor@nasceturridiculus.ca','190 Rhoncus. St.','2718 Quisque Street','Reading','Pennsylvania','Egypt','','','','','','86.37226669711272','2018-02-02','cash','Completed'); 


DROP TABLE IF EXISTS `parent`;
CREATE TABLE `parent` (
  `parent_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext NOT NULL,
  `email` longtext NOT NULL,
  `password` longtext NOT NULL,
  `phone` longtext NOT NULL,
  `address` longtext NOT NULL,
  `profession` longtext NOT NULL,
  PRIMARY KEY (`parent_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



DROP TABLE IF EXISTS `payment`;
CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` longtext NOT NULL,
  `student_id` int(11) NOT NULL,
  `expense_category_id` int(11) NOT NULL,
  `amount` float NOT NULL,
  PRIMARY KEY (`payment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



DROP TABLE IF EXISTS `post`;
CREATE TABLE `post` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_title` varchar(100) NOT NULL,
  `post_content` varchar(255) NOT NULL,
  `post_category` varchar(200) NOT NULL,
  `featured_image` varchar(255) NOT NULL,
  `add_file` varchar(255) NOT NULL,
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



DROP TABLE IF EXISTS `pricetable`;
CREATE TABLE `pricetable` (
  `price_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) NOT NULL,
  `price_title` varchar(100) NOT NULL,
  `price_type` varchar(100) DEFAULT NULL,
  `price_value` varchar(100) NOT NULL,
  `price_currency` varchar(50) NOT NULL,
  `price_interval` varchar(100) NOT NULL,
  PRIMARY KEY (`price_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



DROP TABLE IF EXISTS `product_colors`;
CREATE TABLE `product_colors` (
  `color_id` int(11) NOT NULL AUTO_INCREMENT,
  `colors` set('Blue','Black','Orange','Red','White') NOT NULL,
  PRIMARY KEY (`color_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `product_colors` VALUES ('1','Blue,Black,Orange,Red'),
('2','Black,Orange'); 


DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `product_id` varchar(15) NOT NULL,
  `product_name` varchar(70) NOT NULL,
  `product_line` varchar(50) NOT NULL,
  `productScale` varchar(10) NOT NULL,
  `productVendor` varchar(50) NOT NULL,
  `product_description` text NOT NULL,
  `product_image` varchar(250) NOT NULL,
  `product_url` varchar(255) NOT NULL,
  `qty_available` smallint(6) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `product_sell_price` decimal(10,2) NOT NULL,
  `tax` float NOT NULL,
  `product_discount` float NOT NULL,
  `added_date` date NOT NULL,
  `product_cat` varchar(250) NOT NULL DEFAULT 'Electronics',
  PRIMARY KEY (`product_id`),
  KEY `productLine` (`product_line`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `products` VALUES ('S10_1678','1969 Harley Davidson Ultimate Chopper','Motorcycles','1:10','Min Lin Diecast','This replica features working kickstand, front suspension, gear-shift lever, footbrake lever, drive chain, wheels and steering. All parts are particularly delicate due to their precise scale and require special care and attention.','http://findicons.com/files/icons/590/motorola/128/razr_product_red.png','http://artify.com/demo/pages','7933','48.81','95.70','0','5','2016-12-20','Electronics'),
('S10_1949','1952 Alpine Renault 1300','Classic Cars','1:10','Classic Metal Creations','Turnable front wheels; steering function; detailed interior; detailed engine; opening hood; opening trunk; opening doors; and detailed chassis.','http://findicons.com/files/icons/1673/diagram_part_2/96/diagram_v2_17.png','http://demo.digitaldreamstech.com/formdoid/script/documentation/formdoid/','7305','50.00','214.30','0','0','2016-12-20','Fashion'),
('S10_2016','1996 Moto Guzzi 1100i','Motorcycles','1:10','Highway 66 Mini Classics','Official Moto Guzzi logos and insignias, saddle bags located on side of motorcycle, detailed engine, working steering, working suspension, two leather seats, luggage rack, dual exhaust pipes, small saddle bag located on handle bars, two-tone paint with chrome accents, superior die-cast detail , rotating wheels , working kick stand, diecast metal with plastic parts and baked enamel finish.','http://findicons.com/files/icons/53/cats/128/drive_product_red_usb.png','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','6625','68.99','118.94','0','0','2016-12-20','Electronics'),
('S10_4698','2003 Harley-Davidson Eagle Drag Bike','Motorcycles','1:10','Red Start Diecast','Model features, official Harley Davidson logos and insignias, detachable rear wheelie bar, heavy diecast metal with resin parts, authentic multi-color tampo-printed graphics, separate engine drive belts, free-turning front fork, rotating tires and rear racing slick, certificate of authenticity, detailed engine, display stand\r\n, precision diecast replica, baked enamel finish, 1:10 scale model, removable fender, seat and tank cover piece for displaying the superior detail of the v-twin engine','http://findicons.com/files/icons/2738/pretty_office_icon_set_part_9/128/product_documentation.png','http://demo.digitaldreamstech.com/SimplifiedDB/documentation/PDO/pdo-transactions.php','5582','91.02','193.66','0','0','2016-12-20','Electronics'),
('S10_4757','1972 Alfa Romeo GTA','Classic Cars','1:10','Motor City Art Classics','Features include: Turnable front wheels; steering function; detailed interior; detailed engine; opening hood; opening trunk; opening doors; and detailed chassis.','http://findicons.com/files/icons/2834/flatastic_part_2/128/product.png','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','3252','85.68','136.00','0','0','2016-12-20','Fashion'),
('S10_4962','1962 LanciaA Delta 16V','Classic Cars','1:10','Second Gear Diecast','Features include: Turnable front wheels; steering function; detailed interior; detailed engine; opening hood; opening trunk; opening doors; and detailed chassis.','http://displays2go.com.au/slir/w144-h144/images/product_images/1369184182.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','6791','103.42','147.74','0','0','2016-12-20','Electronics'),
('S12_1099','1968 Ford Mustang','Classic Cars','1:12','Autoart Studio Design','Hood, doors and trunk all open to reveal highly detailed interior features. Steering wheel actually turns the front wheels. Color dark green.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/item/wordpress-awesome-import-export-plugin/12896266','68','95.34','194.57','0','0','2016-12-20','Electronics'),
('S12_1108','2001 Ferrari Enzo','Classic Cars','1:12','Second Gear Diecast','Turnable front wheels; steering function; detailed interior; detailed engine; opening hood; opening trunk; opening doors; and detailed chassis.','http://displays2go.com.au/slir/w144-h144/images/product_images/1392593620.jpeg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','3619','95.59','207.80','0','0','2016-12-20','Fashion'),
('S12_1666','1958 Setra Bus','Trucks and Buses','1:12','Welly Diecast Productions','Model features 30 windows, skylights & glare resistant glass, working steering system, original logos','http://displays2go.com.au/slir/w144-h144/images/product_images/1369181990.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','1579','77.90','136.67','0','0','2016-12-20','Electronics'),
('S12_2823','2002 Suzuki XREO','Motorcycles','1:12','Unimax Art Galleries','Official logos and insignias, saddle bags located on side of motorcycle, detailed engine, working steering, working suspension, two leather seats, luggage rack, dual exhaust pipes, small saddle bag located on handle bars, two-tone paint with chrome accents, superior die-cast detail , rotating wheels , working kick stand, diecast metal with plastic parts and baked enamel finish.','http://displays2go.com.au/slir/w144-h144/images/product_images/1392609013.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','9997','66.27','150.62','0','0','2016-12-20','Electronics'),
('S12_3148','1969 Corvair Monza','Classic Cars','1:18','Welly Diecast Productions','1:18 scale die-cast about 10\" long doors open, hood opens, trunk opens and wheels roll','http://displays2go.com.au/images/product_images/1392665476.gif','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','6906','89.14','151.08','0','0','2016-12-20','Electronics'),
('S12_3380','1968 Dodge Charger','Classic Cars','1:12','Welly Diecast Productions','1:12 scale model of a 1968 Dodge Charger. Hood, doors and trunk all open to reveal highly detailed interior features. Steering wheel actually turns the front wheels. Color black','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','http://demo.digitaldreamstech.com/wp-awesome-import-export-documentation','9123','75.16','117.44','0','0','2016-12-20','Electronics'),
('S12_3891','1969 Ford Falcon','Classic Cars','1:12','Second Gear Diecast','Turnable front wheels; steering function; detailed interior; detailed engine; opening hood; opening trunk; opening doors; and detailed chassis.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','1049','83.05','173.02','0','0','2016-12-20','Electronics'),
('S12_3990','1970 Plymouth Hemi Cuda','Classic Cars','1:12','Studio M Art Models','Very detailed 1970 Plymouth Cuda model in 1:12 scale. The Cuda is generally accepted as one of the fastest original muscle cars from the 1970s. This model is a reproduction of one of the orginal 652 cars built in 1970. Red color.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','5663','31.92','79.80','0','0','2016-12-20','Fashion'),
('S12_4473','1957 Chevy Pickup','Trucks and Buses','1:12','Exoto Designs','1:12 scale die-cast about 20\" long Hood opens, Rubber wheels','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','6125','55.70','118.50','0','0','2016-12-20','Fashion'),
('S12_4675','1969 Dodge Charger','Classic Cars','1:12','Welly Diecast Productions','Detailed model of the 1969 Dodge Charger. This model includes finely detailed interior and exterior features. Painted in red and white.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','7323','58.73','115.16','0','0','2016-12-20','Electronics'),
('S18_1097','1940 Ford Pickup Truck','Trucks and Buses','1:18','Studio M Art Models','This model features soft rubber tires, working steering, rubber mud guards, authentic Ford logos, detailed undercarriage, opening doors and hood,  removable split rear gate, full size spare mounted in bed, detailed interior with opening glove box','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','2613','58.33','116.67','0','0','2016-12-20','Electronics'),
('S18_1129','1993 Mazda RX-7','Classic Cars','1:18','Highway 66 Mini Classics','This model features, opening hood, opening doors, detailed engine, rear spoiler, opening trunk, working steering, tinted windows, baked enamel finish. Color red.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','http://demo.digitaldreamstech.com/formdoid/','3975','83.51','141.54','0','0','2016-12-20','Electronics'),
('S18_1342','1937 Lincoln Berline','Vintage Cars','1:18','Motor City Art Classics','Features opening engine cover, doors, trunk, and fuel filler cap. Color black','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','8693','60.62','102.74','0','0','2016-12-20','Electronics'),
('S18_1367','1936 Mercedes-Benz 500K Special Roadster','Vintage Cars','1:18','Studio M Art Models','This 1:18 scale replica is constructed of heavy die-cast metal and has all the features of the original: working doors and rumble seat, independent spring suspension, detailed interior, working steering system, and a bifold hood that reveals an engine so accurate that it even includes the wiring. All this is topped off with a baked enamel finish. Color white.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','8635','24.26','53.91','0','0','2016-12-20','Electronics'),
('S18_1589','1965 Aston Martin DB5','Classic Cars','1:18','Classic Metal Creations','Die-cast model of the silver 1965 Aston Martin DB5 in silver. This model includes full wire wheels and doors that open with fully detailed passenger compartment. In 1:18 scale, this model measures approximately 10 inches/20 cm long.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','9042','65.96','124.44','0','0','2016-12-20','Fashion'),
('S18_1662','1980s Black Hawk Helicopter','Planes','1:18','Red Start Diecast','1:18 scale replica of actual Army\'s UH-60L BLACK HAWK Helicopter. 100% hand-assembled. Features rotating rotor blades, propeller blades and rubber wheels.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','5330','77.27','157.69','0','0','2016-12-20','Electronics'),
('S18_1749','1917 Grand Touring Sedan','Vintage Cars','1:18','Welly Diecast Productions','This 1:18 scale replica of the 1917 Grand Touring car has all the features you would expect from museum quality reproductions: all four doors and bi-fold hood opening, detailed engine and instrument panel, chrome-look trim, and tufted upholstery, all topped off with a factory baked-enamel finish.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/item/pdomodel-database-abstraction-and-helper-php-class/15832775','2724','86.70','170.00','0','0','2016-12-20','Fashion'),
('S18_1889','1948 Porsche 356-A Roadster','Classic Cars','1:18','Gearbox Collectibles','This precision die-cast replica features opening doors, superb detail and craftsmanship, working steering system, opening forward compartment, opening rear trunk with removable spare, 4 wheel independent spring suspension as well as factory baked enamel finish.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','8826','53.90','77.00','0','0','2016-12-20','Electronics'),
('S18_1984','1995 Honda Civic','Classic Cars','1:18','Min Lin Diecast','This model features, opening hood, opening doors, detailed engine, rear spoiler, opening trunk, working steering, tinted windows, baked enamel finish. Color yellow.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','9772','93.89','142.25','0','0','2016-12-20','Fashion'),
('S18_2238','1998 Chrysler Plymouth Prowler','Classic Cars','1:18','Gearbox Collectibles','Turnable front wheels; steering function; detailed interior; detailed engine; opening hood; opening trunk; opening doors; and detailed chassis.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','4724','101.51','163.73','0','0','2016-12-20','Electronics'),
('S18_2248','1911 Ford Town Car','Vintage Cars','1:18','Motor City Art Classics','Features opening hood, opening doors, opening trunk, wide white wall tires, front door arm rests, working steering system.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','540','33.30','60.54','0','0','2016-12-20','Electronics'),
('S18_2319','1964 Mercedes Tour Bus','Trucks and Buses','1:18','Unimax Art Galleries','Exact replica. 100+ parts. working steering system, original logos','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','8258','74.86','122.73','0','0','2016-12-20','Electronics'),
('S18_2325','1932 Model A Ford J-Coupe','Vintage Cars','1:18','Autoart Studio Design','This model features grille-mounted chrome horn, lift-up louvered hood, fold-down rumble seat, working steering system, chrome-covered spare, opening doors, detailed and wired engine','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','9354','58.48','127.13','0','0','2016-12-20','Electronics'),
('S18_2432','1926 Ford Fire Engine','Trucks and Buses','1:18','Carousel DieCast Legends','Gleaming red handsome appearance. Everything is here the fire hoses, ladder, axes, bells, lanterns, ready to fight any inferno.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','2018','24.92','60.77','0','0','2016-12-20','Electronics'),
('S18_2581','P-51-D Mustang','Planes','1:72','Gearbox Collectibles','Has retractable wheels and comes with a stand','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','992','49.00','84.48','0','0','2016-12-20','Electronics'),
('S18_2625','1936 Harley Davidson El Knucklehead','Motorcycles','1:18','Welly Diecast Productions','Intricately detailed with chrome accents and trim, official die-struck logos and baked enamel finish.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','4357','24.23','60.57','0','0','2016-12-20','Electronics'),
('S18_2795','1928 Mercedes-Benz SSK','Vintage Cars','1:18','Gearbox Collectibles','This 1:18 replica features grille-mounted chrome horn, lift-up louvered hood, fold-down rumble seat, working steering system, chrome-covered spare, opening doors, detailed and wired engine. Color black.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','548','72.56','168.75','0','0','2016-12-20','Electronics'),
('S18_2870','1999 Indy 500 Monte Carlo SS','Classic Cars','1:18','Red Start Diecast','Features include opening and closing doors. Color: Red','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','8164','56.76','132.00','0','0','2016-12-20','Electronics'),
('S18_2949','1913 Ford Model T Speedster','Vintage Cars','1:18','Carousel DieCast Legends','This 250 part reproduction includes moving handbrakes, clutch, throttle and foot pedals, squeezable horn, detailed wired engine, removable water, gas, and oil cans, pivoting monocle windshield, all topped with a baked enamel red finish. Each replica comes with an Owners Title and Certificate of Authenticity. Color red.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','4189','60.78','101.31','0','0','2016-12-20','Electronics'),
('S18_2957','1934 Ford V8 Coupe','Vintage Cars','1:18','Min Lin Diecast','Chrome Trim, Chrome Grille, Opening Hood, Opening Doors, Opening Trunk, Detailed Engine, Working Steering System','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','5649','34.35','62.46','0','0','2016-12-20','Electronics'),
('S18_3029','1999 Yamaha Speed Boat','Ships','1:18','Min Lin Diecast','Exact replica. Wood and Metal. Many extras including rigging, long boats, pilot house, anchors, etc. Comes with three masts, all square-rigged.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','4259','51.61','86.02','0','0','2016-12-20','Electronics'),
('S18_3136','18th Century Vintage Horse Carriage','Vintage Cars','1:18','Red Start Diecast','Hand crafted diecast-like metal horse carriage is re-created in about 1:18 scale of antique horse carriage. This antique style metal Stagecoach is all hand-assembled with many different parts.\r\n\r\nThis collectible metal horse carriage is painted in classic Red, and features turning steering wheel and is entirely hand-finished.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','5992','60.74','104.72','0','0','2016-12-20','Electronics'),
('S18_3140','1903 Ford Model A','Vintage Cars','1:18','Unimax Art Galleries','Features opening trunk,  working steering system','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','3913','68.30','136.59','0','0','2016-12-20','Electronics'),
('S18_3232','1992 Ferrari 360 Spider red','Classic Cars','1:18','Unimax Art Galleries','his replica features opening doors, superb detail and craftsmanship, working steering system, opening forward compartment, opening rear trunk with removable spare, 4 wheel independent spring suspension as well as factory baked enamel finish.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','8347','77.90','169.34','0','0','2016-12-20','Electronics'),
('S18_3233','1985 Toyota Supra','Classic Cars','1:18','Highway 66 Mini Classics','This model features soft rubber tires, working steering, rubber mud guards, authentic Ford logos, detailed undercarriage, opening doors and hood, removable split rear gate, full size spare mounted in bed, detailed interior with opening glove box','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','7733','57.01','107.57','0','0','2016-12-20','Electronics'),
('S18_3259','Collectable Wooden Train','Trains','1:18','Carousel DieCast Legends','Hand crafted wooden toy train set is in about 1:18 scale, 25 inches in total length including 2 additional carts, of actual vintage train. This antique style wooden toy train model set is all hand-assembled with 100% wood.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','6450','67.56','100.84','0','0','2016-12-20','Electronics'),
('S18_3278','1969 Dodge Super Bee','Classic Cars','1:18','Min Lin Diecast','This replica features opening doors, superb detail and craftsmanship, working steering system, opening forward compartment, opening rear trunk with removable spare, 4 wheel independent spring suspension as well as factory baked enamel finish.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','1917','49.05','80.41','0','0','2016-12-20','Electronics'),
('S18_3320','1917 Maxwell Touring Car','Vintage Cars','1:18','Exoto Designs','Features Gold Trim, Full Size Spare Tire, Chrome Trim, Chrome Grille, Opening Hood, Opening Doors, Opening Trunk, Detailed Engine, Working Steering System','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','7913','57.54','99.21','0','0','2016-12-20','Electronics'),
('S18_3482','1976 Ford Gran Torino','Classic Cars','1:18','Gearbox Collectibles','Highly detailed 1976 Ford Gran Torino \"Starsky and Hutch\" diecast model. Very well constructed and painted in red and white patterns.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','9127','73.49','146.99','0','0','2016-12-20','Electronics'),
('S18_3685','1948 Porsche Type 356 Roadster','Classic Cars','1:18','Gearbox Collectibles','This model features working front and rear suspension on accurately replicated and actuating shock absorbers as well as opening engine cover, rear stabilizer flap,  and 4 opening doors.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','8990','62.16','141.28','0','0','2016-12-20','Electronics'),
('S18_3782','1957 Vespa GS150','Motorcycles','1:18','Studio M Art Models','Features rotating wheels , working kick stand. Comes with stand.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','7689','32.95','62.17','0','0','2016-12-20','Electronics'),
('S18_3856','1941 Chevrolet Special Deluxe Cabriolet','Vintage Cars','1:18','Exoto Designs','Features opening hood, opening doors, opening trunk, wide white wall tires, front door arm rests, working steering system, leather upholstery. Color black.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','2378','64.58','105.87','0','0','2016-12-20','Electronics'),
('S18_4027','1970 Triumph Spitfire','Classic Cars','1:18','Min Lin Diecast','Features include opening and closing doors. Color: White.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','5545','91.92','143.62','0','0','2016-12-20','Electronics'),
('S18_4409','1932 Alfa Romeo 8C2300 Spider Sport','Vintage Cars','1:18','Exoto Designs','This 1:18 scale precision die cast replica features the 6 front headlights of the original, plus a detailed version of the 142 horsepower straight 8 engine, dual spares and their famous comprehensive dashboard. Color black.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','6553','43.26','92.03','0','0','2016-12-20','Electronics'),
('S18_4522','1904 Buick Runabout','Vintage Cars','1:18','Exoto Designs','Features opening trunk,  working steering system','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','8290','52.66','87.77','0','0','2016-12-20','Electronics'),
('S18_4600','1940s Ford truck','Trucks and Buses','1:18','Motor City Art Classics','This 1940s Ford Pick-Up truck is re-created in 1:18 scale of original 1940s Ford truck. This antique style metal 1940s Ford Flatbed truck is all hand-assembled. This collectible 1940\'s Pick-Up truck is painted in classic dark green color, and features rotating wheels.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','3128','84.76','121.08','0','0','2016-12-20','Electronics'),
('S18_4668','1939 Cadillac Limousine','Vintage Cars','1:18','Studio M Art Models','Features completely detailed interior including Velvet flocked drapes,deluxe wood grain floor, and a wood grain casket with seperate chrome handles','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','6645','23.14','50.31','0','0','2016-12-20','Electronics'),
('S18_4721','1957 Corvette Convertible','Classic Cars','1:18','Classic Metal Creations','1957 die cast Corvette Convertible in Roman Red with white sides and whitewall tires. 1:18 scale quality die-cast with detailed engine and underbvody. Now you can own The Classic Corvette.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','1249','69.93','148.80','0','0','2016-12-20','Electronics'),
('S18_4933','1957 Ford Thunderbird','Classic Cars','1:18','Studio M Art Models','This 1:18 scale precision die-cast replica, with its optional porthole hardtop and factory baked-enamel Thunderbird Bronze finish, is a 100% accurate rendition of this American classic.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','3209','34.21','71.27','0','0','2016-12-20','Electronics'),
('S24_1046','1970 Chevy Chevelle SS 454','Classic Cars','1:24','Unimax Art Galleries','This model features rotating wheels, working streering system and opening doors. All parts are particularly delicate due to their precise scale and require special care and attention. It should not be picked up by the doors, roof, hood or trunk.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','1005','49.24','73.49','0','0','2016-12-20','Electronics'),
('S24_1444','1970 Dodge Coronet','Classic Cars','1:24','Highway 66 Mini Classics','1:24 scale die-cast about 18\" long doors open, hood opens and rubber wheels','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','4074','32.37','57.80','0','0','2016-12-20','Electronics'),
('S24_1578','1997 BMW R 1100 S','Motorcycles','1:24','Autoart Studio Design','Detailed scale replica with working suspension and constructed from over 70 parts','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','7003','60.86','112.70','0','0','2016-12-20','Electronics'),
('S24_1628','1966 Shelby Cobra 427 S/C','Classic Cars','1:24','Carousel DieCast Legends','This diecast model of the 1966 Shelby Cobra 427 S/C includes many authentic details and operating parts. The 1:24 scale model of this iconic lighweight sports car from the 1960s comes in silver and it\'s own display case.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','8197','29.18','50.31','0','0','2016-12-20','Electronics'),
('S24_1785','1928 British Royal Navy Airplane','Planes','1:24','Classic Metal Creations','Official logos and insignias','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','3627','66.74','109.42','0','0','2016-12-20','Electronics'),
('S24_1937','1939 Chevrolet Deluxe Coupe','Vintage Cars','1:24','Motor City Art Classics','This 1:24 scale die-cast replica of the 1939 Chevrolet Deluxe Coupe has the same classy look as the original. Features opening trunk, hood and doors and a showroom quality baked enamel finish.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','7332','22.57','33.19','0','0','2016-12-20','Electronics'),
('S24_2000','1960 BSA Gold Star DBD34','Motorcycles','1:24','Highway 66 Mini Classics','Detailed scale replica with working suspension and constructed from over 70 parts','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','15','37.32','76.17','0','0','2016-12-20','Electronics'),
('S24_2011','18th century schooner','Ships','1:24','Carousel DieCast Legends','All wood with canvas sails. Many extras including rigging, long boats, pilot house, anchors, etc. Comes with 4 masts, all square-rigged.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','1898','82.34','122.89','0','0','2016-12-20','Electronics'),
('S24_2022','1938 Cadillac V-16 Presidential Limousine','Vintage Cars','1:24','Classic Metal Creations','This 1:24 scale precision die cast replica of the 1938 Cadillac V-16 Presidential Limousine has all the details of the original, from the flags on the front to an opening back seat compartment complete with telephone and rifle. Features factory baked-enamel black finish, hood goddess ornament, working jump seats.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','2847','20.61','44.80','0','0','2016-12-20','Electronics'),
('S24_2300','1962 Volkswagen Microbus','Trucks and Buses','1:24','Autoart Studio Design','This 1:18 scale die cast replica of the 1962 Microbus is loaded with features: A working steering system, opening front doors and tailgate, and famous two-tone factory baked enamel finish, are all topped of by the sliding, real fabric, sunroof.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','2327','61.34','127.79','0','0','2016-12-20','Electronics'),
('S24_2360','1982 Ducati 900 Monster','Motorcycles','1:24','Highway 66 Mini Classics','Features two-tone paint with chrome accents, superior die-cast detail , rotating wheels , working kick stand','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','6840','47.10','69.26','0','0','2016-12-20','Electronics'),
('S24_2766','1949 Jaguar XK 120','Classic Cars','1:24','Classic Metal Creations','Precision-engineered from original Jaguar specification in perfect scale ratio. Features opening doors, superb detail and craftsmanship, working steering system, opening forward compartment, opening rear trunk with removable spare, 4 wheel independent spring suspension as well as factory baked enamel finish.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','2350','47.25','90.87','0','0','2016-12-20','Electronics'),
('S24_2840','1958 Chevy Corvette Limited Edition','Classic Cars','1:24','Carousel DieCast Legends','The operating parts of this 1958 Chevy Corvette Limited Edition are particularly delicate due to their precise scale and require special care and attention. Features rotating wheels, working streering, opening doors and trunk. Color dark green.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','2542','15.91','35.36','0','0','2016-12-20','Electronics'),
('S24_2841','1900s Vintage Bi-Plane','Planes','1:24','Autoart Studio Design','Hand crafted diecast-like metal bi-plane is re-created in about 1:24 scale of antique pioneer airplane. All hand-assembled with many different parts. Hand-painted in classic yellow and features correct markings of original airplane.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','5942','34.25','68.51','0','0','2016-12-20','Electronics'),
('S24_2887','1952 Citroen-15CV','Classic Cars','1:24','Exoto Designs','Precision crafted hand-assembled 1:18 scale reproduction of the 1952 15CV, with its independent spring suspension, working steering system, opening doors and hood, detailed engine and instrument panel, all topped of with a factory fresh baked enamel finish.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','1452','72.82','117.44','0','0','2016-12-20','Electronics'),
('S24_2972','1982 Lamborghini Diablo','Classic Cars','1:24','Second Gear Diecast','This replica features opening doors, superb detail and craftsmanship, working steering system, opening forward compartment, opening rear trunk with removable spare, 4 wheel independent spring suspension as well as factory baked enamel finish.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','7723','16.24','37.76','0','0','2016-12-20','Electronics'),
('S24_3151','1912 Ford Model T Delivery Wagon','Vintage Cars','1:24','Min Lin Diecast','This model features chrome trim and grille, opening hood, opening doors, opening trunk, detailed engine, working steering system. Color white.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','9173','46.91','88.51','0','0','2016-12-20','Electronics'),
('S24_3191','1969 Chevrolet Camaro Z28','Classic Cars','1:24','Exoto Designs','1969 Z/28 Chevy Camaro 1:24 scale replica. The operating parts of this limited edition 1:24 scale diecast model car 1969 Chevy Camaro Z28- hood, trunk, wheels, streering, suspension and doors- are particularly delicate due to their precise scale and require special care and attention.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','4695','50.51','85.61','0','0','2016-12-20','Electronics'),
('S24_3371','1971 Alpine Renault 1600s','Classic Cars','1:24','Welly Diecast Productions','This 1971 Alpine Renault 1600s replica Features opening doors, superb detail and craftsmanship, working steering system, opening forward compartment, opening rear trunk with removable spare, 4 wheel independent spring suspension as well as factory baked enamel finish.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','7995','38.58','61.23','0','0','2016-12-20','Electronics'),
('S24_3420','1937 Horch 930V Limousine','Vintage Cars','1:24','Autoart Studio Design','Features opening hood, opening doors, opening trunk, wide white wall tires, front door arm rests, working steering system','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','2902','26.30','65.75','0','0','2016-12-20','Electronics'),
('S24_3432','2002 Chevy Corvette','Classic Cars','1:24','Gearbox Collectibles','The operating parts of this limited edition Diecast 2002 Chevy Corvette 50th Anniversary Pace car Limited Edition are particularly delicate due to their precise scale and require special care and attention. Features rotating wheels, poseable streering, opening doors and trunk.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','9446','62.11','107.08','0','0','2016-12-20','Electronics'),
('S24_3816','1940 Ford Delivery Sedan','Vintage Cars','1:24','Carousel DieCast Legends','Chrome Trim, Chrome Grille, Opening Hood, Opening Doors, Opening Trunk, Detailed Engine, Working Steering System. Color black.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','6621','48.64','83.86','0','0','2016-12-20','Electronics'),
('S24_3856','1956 Porsche 356A Coupe','Classic Cars','1:18','Classic Metal Creations','Features include: Turnable front wheels; steering function; detailed interior; detailed engine; opening hood; opening trunk; opening doors; and detailed chassis.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','6600','98.30','140.43','0','0','2016-12-20','Electronics'),
('S24_3949','Corsair F4U ( Bird Cage)','Planes','1:24','Second Gear Diecast','Has retractable wheels and comes with a stand. Official logos and insignias.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','6812','29.34','68.24','0','0','2016-12-20','Electronics'),
('S24_3969','1936 Mercedes Benz 500k Roadster','Vintage Cars','1:24','Red Start Diecast','This model features grille-mounted chrome horn, lift-up louvered hood, fold-down rumble seat, working steering system and rubber wheels. Color black.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','2081','21.75','41.03','0','0','2016-12-20','Electronics'),
('S24_4048','1992 Porsche Cayenne Turbo Silver','Classic Cars','1:24','Exoto Designs','This replica features opening doors, superb detail and craftsmanship, working steering system, opening forward compartment, opening rear trunk with removable spare, 4 wheel independent spring suspension as well as factory baked enamel finish.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','6582','69.78','118.28','0','0','2016-12-20','Electronics'),
('S24_4258','1936 Chrysler Airflow','Vintage Cars','1:24','Second Gear Diecast','Features opening trunk,  working steering system. Color dark green.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','4710','57.46','97.39','0','0','2016-12-20','Electronics'),
('S24_4278','1900s Vintage Tri-Plane','Planes','1:24','Unimax Art Galleries','Hand crafted diecast-like metal Triplane is Re-created in about 1:24 scale of antique pioneer airplane. This antique style metal triplane is all hand-assembled with many different parts.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','2756','36.23','72.45','0','0','2016-12-20','Electronics'),
('S24_4620','1961 Chevrolet Impala','Classic Cars','1:18','Classic Metal Creations','This 1:18 scale precision die-cast reproduction of the 1961 Chevrolet Impala has all the features-doors, hood and trunk that open; detailed 409 cubic-inch engine; chrome dashboard and stick shift, two-tone interior; working steering system; all topped of with a factory baked-enamel finish.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','7869','32.33','80.84','0','0','2016-12-20','Electronics'),
('S32_1268','1980’s GM Manhattan Express','Trucks and Buses','1:32','Motor City Art Classics','This 1980’s era new look Manhattan express is still active, running from the Bronx to mid-town Manhattan. Has 35 opeining windows and working lights. Needs a battery.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','5099','53.93','96.31','0','0','2016-12-20','Electronics'),
('S32_1374','1997 BMW F650 ST','Motorcycles','1:32','Exoto Designs','Features official die-struck logos and baked enamel finish. Comes with stand.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','178','66.92','99.89','0','0','2016-12-20','Electronics'),
('S32_2206','1982 Ducati 996 R','Motorcycles','1:32','Gearbox Collectibles','Features rotating wheels , working kick stand. Comes with stand.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','9241','24.14','40.23','0','0','2016-12-20','Electronics'),
('S32_2509','1954 Greyhound Scenicruiser','Trucks and Buses','1:32','Classic Metal Creations','Model features bi-level seating, 50 windows, skylights & glare resistant glass, working steering system, original logos','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','2874','25.98','54.11','0','0','2016-12-20','Electronics'),
('S32_3207','1950\'s Chicago Surface Lines Streetcar','Trains','1:32','Gearbox Collectibles','This streetcar is a joy to see. It has 80 separate windows, electric wire guides, detailed interiors with seats, poles and drivers controls, rolling and turning wheel assemblies, plus authentic factory baked-enamel finishes (Green Hornet for Chicago and Cream and Crimson for Boston).','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','8601','26.72','62.14','0','0','2016-12-20','Electronics'),
('S32_3522','1996 Peterbilt 379 Stake Bed with Outrigger','Trucks and Buses','1:32','Red Start Diecast','This model features, opening doors, detailed engine, working steering, tinted windows, detailed interior, die-struck logos, removable stakes operating outriggers, detachable second trailer, functioning 360-degree self loader, precision molded resin trailer and trim, baked enamel finish on cab','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','814','33.61','64.64','0','0','2016-12-20','Electronics'),
('S32_4289','1928 Ford Phaeton Deluxe','Vintage Cars','1:32','Highway 66 Mini Classics','This model features grille-mounted chrome horn, lift-up louvered hood, fold-down rumble seat, working steering system','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','136','33.02','68.79','0','0','2016-12-20','Electronics'),
('S32_4485','1974 Ducati 350 Mk3 Desmo','Motorcycles','1:32','Second Gear Diecast','This model features two-tone paint with chrome accents, superior die-cast detail , rotating wheels , working kick stand','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','3341','56.13','102.05','0','0','2016-12-20','Electronics'),
('S50_1341','1930 Buick Marquette Phaeton','Vintage Cars','1:50','Studio M Art Models','Features opening trunk,  working steering system','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','7062','27.06','43.64','0','0','2016-12-20','Electronics'),
('S50_1392','Diamond T620 Semi-Skirted Tanker','Trucks and Buses','1:50','Highway 66 Mini Classics','This limited edition model is licensed and perfectly scaled for Lionel Trains. The Diamond T620 has been produced in solid precision diecast and painted with a fire baked enamel finish. It comes with a removable tanker and is a perfect model to add authenticity to your static train or car layout or to just have on display.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','1016','68.29','115.75','0','0','2016-12-20','Electronics'),
('S50_1514','1962 City of Detroit Streetcar','Trains','1:50','Classic Metal Creations','This streetcar is a joy to see. It has 99 separate windows, electric wire guides, detailed interiors with seats, poles and drivers controls, rolling and turning wheel assemblies, plus authentic factory baked-enamel finishes (Green Hornet for Chicago and Cream and Crimson for Boston).','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','1645','37.49','58.58','0','0','2016-12-20','Electronics'),
('S50_4713','2002 Yamaha YZR M1','Motorcycles','1:50','Autoart Studio Design','Features rotating wheels , working kick stand. Comes with stand.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','600','34.17','81.36','0','0','2016-12-20','Electronics'),
('S700_1138','The Schooner Bluenose','Ships','1:700','Autoart Studio Design','All wood with canvas sails. Measures 31 1/2 inches in Length, 22 inches High and 4 3/4 inches Wide. Many extras.\r\nThe schooner Bluenose was built in Nova Scotia in 1921 to fish the rough waters off the coast of Newfoundland. Because of the Bluenose racing prowess she became the pride of all Canadians. Still featured on stamps and the Canadian dime, the Bluenose was lost off Haiti in 1946.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','1897','34.00','66.67','0','0','2016-12-20','Electronics'),
('S700_1691','American Airlines: B767-300','Planes','1:700','Min Lin Diecast','Exact replia with official logos and insignias and retractable wheels','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','5841','51.15','91.34','0','0','2016-12-20','Electronics'),
('S700_1938','The Mayflower','Ships','1:700','Studio M Art Models','Measures 31 1/2 inches Long x 25 1/2 inches High x 10 5/8 inches Wide\r\nAll wood with canvas sail. Extras include long boats, rigging, ladders, railing, anchors, side cannons, hand painted, etc.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','737','43.30','86.61','0','0','2016-12-20','Electronics'),
('S700_2047','HMS Bounty','Ships','1:700','Unimax Art Galleries','Measures 30 inches Long x 27 1/2 inches High x 4 3/4 inches Wide. \r\nMany extras including rigging, long boats, pilot house, anchors, etc. Comes with three masts, all square-rigged.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','3501','39.83','90.52','0','0','2016-12-20','Electronics'),
('S700_2466','America West Airlines B757-200','Planes','1:700','Motor City Art Classics','Official logos and insignias. Working steering system. Rotating jet engines','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','9653','68.80','99.72','0','0','2016-12-20','Electronics'),
('S700_2610','The USS Constitution Ship','Ships','1:700','Red Start Diecast','All wood with canvas sails. Measures 31 1/2\" Length x 22 3/8\" High x 8 1/4\" Width. Extras include 4 boats on deck, sea sprite on bow, anchors, copper railing, pilot houses, etc.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','7083','33.97','72.28','0','0','2016-12-20','Electronics'),
('S700_2824','1982 Camaro Z28','Classic Cars','1:18','Carousel DieCast Legends','Features include opening and closing doors. Color: White. \r\nMeasures approximately 9 1/2\" Long.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','6934','46.53','101.15','0','0','2016-12-20','Electronics'),
('S700_2834','ATA: B757-300','Planes','1:700','Highway 66 Mini Classics','Exact replia with official logos and insignias and retractable wheels','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','7106','59.33','118.65','0','0','2016-12-20','Electronics'),
('S700_3167','F/A 18 Hornet 1/72','Planes','1:72','Motor City Art Classics','10\" Wingspan with retractable landing gears.Comes with pilot','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','551','54.40','80.00','0','0','2016-12-20','Electronics'),
('S700_3505','The Titanic','Ships','1:700','Carousel DieCast Legends','Completed model measures 19 1/2 inches long, 9 inches high, 3inches wide and is in barn red/black. All wood and metal.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','1956','51.09','100.17','0','0','2016-12-20','Electronics'),
('S700_3962','The Queen Mary','Ships','1:700','Welly Diecast Productions','Exact replica. Wood and Metal. Many extras including rigging, long boats, pilot house, anchors, etc. Comes with three masts, all square-rigged.','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','5088','53.63','99.31','0','0','2016-12-20','Electronics'),
('S700_4002','American Airlines: MD-11S','Planes','1:700','Second Gear Diecast','Polished finish. Exact replia with official logos and insignias and retractable wheels','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','8820','36.27','74.03','0','0','2016-12-20','Electronics'),
('S72_1253','Boeing X-32A JSF','Planes','1:72','Motor City Art Classics','10\" Wingspan with retractable landing gears.Comes with pilot','http://displays2go.com.au/slir/w144-h144/images/product_images/1384248587.jpg','https://codecanyon.net/user/ddeveloper/portfolio?ref=ddeveloper','4857','32.77','49.66','0','0','2016-12-20','Electronics'); 


DROP TABLE IF EXISTS `productsizes`;
CREATE TABLE `productsizes` (
  `size_id` int(11) NOT NULL AUTO_INCREMENT,
  `size` enum('x-small','small','medium','large','x-large') NOT NULL,
  PRIMARY KEY (`size_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `productsizes` VALUES ('6','x-small'),
('7','medium'),
('8','x-large'),
('9','small'); 


DROP TABLE IF EXISTS `producttable`;
CREATE TABLE `producttable` (
  `product_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(250) NOT NULL,
  `product_price` double NOT NULL,
  `product_sell_price` double NOT NULL,
  `discount` decimal(10,0) NOT NULL,
  `product_description` varchar(250) NOT NULL,
  `product_image` varchar(250) NOT NULL,
  `qty_available` int(11) NOT NULL,
  `added_date` datetime NOT NULL,
  `product_rating` int(11) NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `producttable` VALUES ('1','pp','250','300','10000','this is description about product','f','232','0000-00-00 00:00:00','2'),
('3','sfsdf','222','300','100','sfd','f','232','2016-12-14 10:34:00','2'),
('4','ppp','300','2522','12','df','2','22','0000-00-00 00:00:00','21'),
('5','ppp','300','2522','12','df','2','22','0000-00-00 00:00:00','21'),
('6','ppp','300','2522','12','df','2','22','0000-00-00 00:00:00','21'),
('7','pP','909','990','90','SD','dsf','232','0000-00-00 00:00:00','2'),
('8','pP','909','990','90','SD','dsf','232','0000-00-00 00:00:00','2'),
('9','pP','909','990','90','SD','dsf','232','0000-00-00 00:00:00','2'),
('10','neha','201','333','333','3','3','33','0000-00-00 00:00:00','3'),
('11','neha','33','333','333','3','3','33','0000-00-00 00:00:00','3'),
('12','neha','33','333','333','3','3','33','0000-00-00 00:00:00','3'),
('13','sadf','324','3434','34','34','df','324','0000-00-00 00:00:00','34'),
('15','Test prod','1000','12000','2','dfs','sfd','23','2016-08-31 00:00:00','34'),
('16','Test prod','34','3333','333','fds','dsf','234','2016-08-31 00:00:00','3'),
('17','fgfdfdg','500','300','25','gfdgdfg','jjhjhj','33','2016-09-15 00:00:00','5'),
('18','test','2','123','12','sadfsdf','asd','213','2016-09-20 00:00:00','1'),
('19','??','5','3','0','????','222','1','2016-09-28 00:00:00','1'),
('20','rf','66','879','7',',n,n','n,','76','2016-09-28 00:00:00','3'),
('21','','0','0','0','','','87','0000-00-00 00:00:00','0'),
('22','0','45','44','0','devesh','11','11','2016-12-01 00:00:00','5'),
('23','xasasd','0','0','0','','','0','0000-00-00 00:00:00','0'),
('24','','0','0','0','','','56','0000-00-00 00:00:00','0'),
('25','','0','0','0','','','79','0000-00-00 00:00:00','0'),
('26','yyyy','5565','-4','3','3333','5555','4','2016-12-18 00:00:00','5'),
('27','xcvxcv','344','333','33','33','33','33','2016-12-06 00:00:00','33'); 


DROP TABLE IF EXISTS `registration_1`;
CREATE TABLE `registration_1` (
  `reg_id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `about_yourself` text NOT NULL,
  PRIMARY KEY (`reg_id`)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

INSERT INTO `registration_1` VALUES ('80','aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa','admin@gmail.com','1234','sdff'),
('81','sdf','adminsdf@sdfsadf.dfgdf','admin@ddt2016','dsf'),
('82','pritesh','pritesh@gmail.com','1234qwer','sdsdf'),
('83','pritesh','ss@fff.com','sdf','sdf'),
('84','d','admin@gmail.com','admin@ddt2016','dfdss'),
('85','asd','admin@sdfsdaf.com','12346','sdf'),
('86','asd','admin@sdfsdaf.com','12346','sdf'),
('87','sdf','pfa@gmail.com','admin@ddt2016','sdf'),
('88','ff','admin@fddfs.gg','admin@ddt2016','dsd'),
('89','sd','admin@sdf.ff','admin@ddt2016','f'); 


DROP TABLE IF EXISTS `reservation`;
CREATE TABLE `reservation` (
  `reservation_id` bigint(20) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `address` varchar(250) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `zip/postal_code` varchar(50) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `booking_date` date NOT NULL,
  `class` varchar(250) NOT NULL,
  `adults` varchar(50) NOT NULL,
  `infants` varchar(50) NOT NULL,
  `children` varchar(50) NOT NULL,
  `amount` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



DROP TABLE IF EXISTS `roomtable`;
CREATE TABLE `roomtable` (
  `room_id` int(11) NOT NULL AUTO_INCREMENT,
  `room_no` varchar(200) NOT NULL,
  `room_type` varchar(200) NOT NULL,
  `room_desc` varchar(250) NOT NULL,
  PRIMARY KEY (`room_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



DROP TABLE IF EXISTS `section`;
CREATE TABLE `section` (
  `section_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `class_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `user_id` varchar(250) NOT NULL,
  PRIMARY KEY (`section_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `section` VALUES ('7','a','1','1','03:00:00','06:00:00','2'),
('8','b','2','1','08:00:00','09:00:00','1'),
('9','c5','3','2','10:00:00','16:00:00','1'),
('10','b','1','2','06:00:00','04:00:00','1'),
('11','c','2','3','04:10:00','20:00:00','1'),
('12','d','2','3','16:00:00','06:35:00','1'),
('13','c','4','3','04:00:00','10:00:00','1'),
('14','a','3','3','04:00:00','06:00:00','1'),
('15','b','3','1','03:00:00','04:00:00','1'),
('16','a','4','2','05:00:00','06:00:00','1'); 


DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `settings_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`settings_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `settings` VALUES ('1','system_name','Ekattor School Management System Pro'),
('2','system_title','Ekattor School'),
('3','address','Dhaka, Bangladesh'),
('4','phone','+8012654159'),
('5','paypal_email','payment@school.com'),
('6','currency','usd'),
('7','system_email','school@ekattor.com'),
('20','active_sms_service','disabled'),
('11','language','english'),
('12','text_align','left-to-right'),
('13','clickatell_user',''),
('14','clickatell_password',''),
('15','clickatell_api_id',''),
('16','skin_colour','default'),
('17','twilio_account_sid',''),
('18','twilio_auth_token',''),
('19','twilio_sender_phone_number',''); 


DROP TABLE IF EXISTS `state`;
CREATE TABLE `state` (
  `state_id` int(11) NOT NULL AUTO_INCREMENT,
  `state_name` varchar(250) NOT NULL,
  `country_id` int(11) NOT NULL,
  PRIMARY KEY (`state_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `state` VALUES ('1','MP','2'),
('2','UP','2'),
('3','Texas','1'),
('4','Victoria','1'); 


DROP TABLE IF EXISTS `student`;
CREATE TABLE `student` (
  `student_id` int(11) NOT NULL AUTO_INCREMENT,
  `register_number` varchar(255) NOT NULL,
  `joining_date` date NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(250) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(120) NOT NULL,
  `present_address` varchar(255) NOT NULL,
  `permanent_address` varchar(255) NOT NULL,
  `pin_code` varchar(250) NOT NULL,
  `city` varchar(250) NOT NULL,
  `state` varchar(250) NOT NULL,
  `country` varchar(250) NOT NULL,
  `blood_group` varchar(200) NOT NULL,
  `birth_place` varchar(255) NOT NULL,
  `nationality` varchar(255) NOT NULL,
  `roll_number` varchar(255) NOT NULL,
  `mother_tongue` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `religion` varchar(250) NOT NULL,
  `previous_school` varchar(250) NOT NULL,
  `previous_school_address` varchar(255) NOT NULL,
  `previous_qualification` varchar(250) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `transport_id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `login_status` varchar(100) NOT NULL,
  `session_id` int(11) NOT NULL,
  PRIMARY KEY (`student_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `student` VALUES ('13','R0001','2019-04-01','Jon','D','Duo','Male','2019-04-02','testemail@gmail.com','+911343213233','Lorep ipsum address','Lorep ipsum address','452005','ca','ca','USA','o+','Cal','USA','100001','English','1','1','none','Lorep ipsum address','na','1','8','0','1','xyz','1','1'),
('14','R0002','2019-04-01','David','D','Mars','Male','2019-04-02','testemail@gmail.com','+911343213233','Lorep ipsum address','Lorep ipsum address','452005','ca','ca','USA','o+','Cal','USA','100001','English','1','1','none','Lorep ipsum address','na','2','13','0','1','xyz','1','1'),
('15','R0003','2019-04-01','Mark','D','Tasr','Male','2019-04-02','testemail@gmail.com','+911343213233','Lorep ipsum address','Lorep ipsum address','452005','ca','ca','USA','o+','Cal','USA','100001','English','1','1','none','Lorep ipsum address','na','3','15','0','1','xyz','1','1'),
('16','R0004','2019-04-01','Kelvin','D','Kale','Male','2019-04-02','testemail@gmail.com','+911343213233','Lorep ipsum address','Lorep ipsum address','452005','ca','ca','USA','o+','Cal','USA','100001','English','1','1','none','Lorep ipsum address','na','4','16','0','1','xyz','1','1'); 


DROP TABLE IF EXISTS `subject`;
CREATE TABLE `subject` (
  `subject_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext NOT NULL,
  `class_id` int(11) NOT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`subject_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



DROP TABLE IF EXISTS `teacher`;
CREATE TABLE `teacher` (
  `teacher_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext NOT NULL,
  `birthday` longtext NOT NULL,
  `sex` longtext NOT NULL,
  `religion` longtext NOT NULL,
  `blood_group` longtext NOT NULL,
  `address` longtext NOT NULL,
  `phone` longtext NOT NULL,
  `email` longtext NOT NULL,
  `password` longtext NOT NULL,
  PRIMARY KEY (`teacher_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



DROP TABLE IF EXISTS `transport`;
CREATE TABLE `transport` (
  `transport_id` int(11) NOT NULL AUTO_INCREMENT,
  `route_name` longtext NOT NULL,
  `number_of_vehicle` longtext NOT NULL,
  `description` longtext NOT NULL,
  `route_fare` longtext NOT NULL,
  PRIMARY KEY (`transport_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



DROP TABLE IF EXISTS `user_meta`;
CREATE TABLE `user_meta` (
  `user_meta_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `meta_key` varchar(250) NOT NULL,
  `meta_value` text NOT NULL,
  PRIMARY KEY (`user_meta_id`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

INSERT INTO `user_meta` VALUES ('31','19','2432re32d23r34r','43rfewrfasdfdsaf'),
('32','21','m1','v1'),
('33','21','m2','v2'),
('60','27','My Meta','hello'),
('61','27','Second Meta','how are you'),
('62','28','My Meta','hello'),
('63','28','Second Meta','how are you'),
('64','26','Total Experience1','5 years22'),
('65','26','Total Experience2','5 years33'),
('66','26','Total Experience3','5 years44'),
('67','26','Total Experience4','5 years55'),
('68','26','Total Experience5','5 years66'),
('69','26','Total Experience6','5 years77'),
('70','26','Total Experience7','5 years88'),
('71','26','Total Experience8','5 years99'),
('74','31','k1','v1'),
('75','31','k2','v2'),
('76','31','k3','v3'); 


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `user_name` varchar(50) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(50) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `birth_date` date NOT NULL,
  `hobbies` varchar(200) NOT NULL,
  `educational_status` varchar(200) NOT NULL,
  `company_name` varchar(100) DEFAULT NULL,
  `address` varchar(250) NOT NULL,
  `city` varchar(250) NOT NULL,
  `state` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `zip_code` varchar(50) NOT NULL,
  `about_yourself` text DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `users` VALUES ('26','Jon ','Snow','jon','$2y$10$GFimDf/8rXjHOymcXi6cpOOkC30BYNA6KJgUNWNhJHDuC.Rx0OsPi','jon@gmail.com','99009900','male','2016-11-11','Footbal, volleyball, dddd','BE','DDT','USA','newyork','0','3','452005','about desc.'),
('31','Dev','Smith','admin','$2y$10$3wKVVgNew1R1cbuQ2g4MjOkC1dd/7BDMJh7DwMFyBpJjqIKS2kvNy','dev.ddtech@gmail.com','09977848644','male','2019-03-29','Chess','BA','Digital Dreams Technology','A 106 leeds Enclave','CA','CA','USA','45200','lorep ipisusm'); 


DROP TABLE IF EXISTS `vehicle`;
CREATE TABLE `vehicle` (
  `vehicle_id` int(11) NOT NULL AUTO_INCREMENT,
  `vehicle_number` varchar(200) NOT NULL,
  `number_of_seats` int(11) NOT NULL,
  `maximum_allowed` int(11) NOT NULL,
  `vehicle_type` varchar(120) NOT NULL,
  `contact_person` varchar(120) NOT NULL,
  `insurance_renewal_date` date NOT NULL,
  `user_id` varchar(250) NOT NULL,
  PRIMARY KEY (`vehicle_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `vehicle` VALUES ('1','1','20','19','busss','driver1','2016-10-12','1'),
('2','mp09-2434','30','30','bus','sunail','2016-11-30','5'); 


DROP TABLE IF EXISTS `website_design_request`;
CREATE TABLE `website_design_request` (
  `request_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `type_of_website` varchar(200) NOT NULL,
  `service_you_need` varchar(200) NOT NULL,
  `website_reference_links` varchar(255) NOT NULL,
  `your_name` varchar(200) NOT NULL,
  `your_email` varchar(200) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `ask/suggest` varchar(255) NOT NULL,
  `upload_file1` varchar(255) NOT NULL,
  `upload_file2` varchar(255) NOT NULL,
  `upload_file3` varchar(255) NOT NULL,
  PRIMARY KEY (`request_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



DROP TABLE IF EXISTS `wp_users`;
CREATE TABLE `wp_users` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_login` varchar(60) NOT NULL DEFAULT '',
  `user_pass` varchar(64) NOT NULL DEFAULT '',
  `user_nicename` varchar(50) NOT NULL DEFAULT '',
  `user_email` varchar(100) NOT NULL DEFAULT '',
  `user_url` varchar(100) NOT NULL DEFAULT '',
  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_activation_key` varchar(60) NOT NULL DEFAULT '',
  `user_status` varchar(50) NOT NULL DEFAULT '',
  `display_name` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`),
  KEY `user_login_key` (`user_login`),
  KEY `user_nicename` (`user_nicename`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `wp_users` VALUES ('1','admin','$P$B9OuhJ738rLcCB3ItvVH2CsKSYm2H4/','admin','vaishali.ddtech@gmail.com','','2016-04-06 13:04:39','','0','admin'),
('3','','','','','','0000-00-00 00:00:00','','',''); 


DROP TABLE IF EXISTS `x0t2u_users`;
CREATE TABLE `x0t2u_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(400) NOT NULL DEFAULT '',
  `username` varchar(150) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(100) NOT NULL DEFAULT '',
  `block` tinyint(4) NOT NULL DEFAULT 0,
  `sendEmail` tinyint(4) DEFAULT 0,
  `registerDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lastvisitDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `activation` varchar(100) NOT NULL DEFAULT '',
  `params` text NOT NULL,
  `lastResetTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Date of last password reset',
  `resetCount` int(11) NOT NULL DEFAULT 0 COMMENT 'Count of password resets since lastResetTime',
  `otpKey` varchar(1000) NOT NULL DEFAULT '' COMMENT 'Two factor authentication encrypted keys',
  `otep` varchar(1000) NOT NULL DEFAULT '' COMMENT 'One time emergency passwords',
  `requireReset` tinyint(4) NOT NULL DEFAULT 0 COMMENT 'Require user to reset password on next login',
  PRIMARY KEY (`id`),
  KEY `idx_name` (`name`(100)),
  KEY `idx_block` (`block`),
  KEY `username` (`username`),
  KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=722 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `x0t2u_users` VALUES ('721','Super User','j351','j351@g.c','$2y$10$rQwOGiYdFcPonc231OsCYOJ/qLghLad/heaUgQleaHOk9VaAeDSza','0','1','2016-04-19 06:40:09','2016-05-02 08:35:41','0','','0000-00-00 00:00:00','0','','','0'); 




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

