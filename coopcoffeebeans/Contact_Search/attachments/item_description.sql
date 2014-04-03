# phpMyAdmin MySQL-Dump
# version 2.4.0
# http://www.phpmyadmin.net/ (download page)
#
# Host: mysql9.siteprotect.com
# Generation Time: Jan 02, 2004 at 11:22 AM
# Server version: 3.23.54
# PHP Version: 4.3.2
# Database : `greenbeans`
# --------------------------------------------------------

#
# Table structure for table `item_description`
#

CREATE TABLE item_description (
  item_code varchar(10) NOT NULL default '',
  item_description varchar(100) default NULL,
  weight float NOT NULL default '0',
  rank int(11) NOT NULL default '0',
  category char(1) default '1',
  item_active smallint(1) default '0',
  desc_notes varchar(255) default NULL,
  total_pur int(11) default '0',
  PRIMARY KEY  (item_code),
  UNIQUE KEY item_code (item_code)
) TYPE=MyISAM;

#
# Dumping data for table `item_description`
#

INSERT INTO item_description VALUES ('COC', 'Colombia Excelso Fair Trade Organic Coffee', '154.32', 3, '1', 0, '51+250', 301);
INSERT INTO item_description VALUES ('CRL', 'Costa Rica Tarrazu Fair Trade Coffee', '152.12', 1, '1', 0, '29+150', 179);
INSERT INTO item_description VALUES ('ETS', 'Ethiopia Sidamo FT Org Coffee', '132.28', 9, '1', 0, '133+170+170', 473);
INSERT INTO item_description VALUES ('ETY', 'Ethiopia Yirgacheffe FT Org Coffee', '132.28', 10, '1', 0, '105+130+130', 365);
INSERT INTO item_description VALUES ('GUA', 'Guatemala San Marcos SHB Org FT Coffee', '152.12', 5, '1', 0, '56+250+250+250+250', 1056);
INSERT INTO item_description VALUES ('GUD', 'Guatemala Decaf SWP Organic Fair Trade Coffee', '132', 15, '2', 0, '26+50', 76);
INSERT INTO item_description VALUES ('TIR', 'East Timor Organic FT Coffee', '132.28', 27, '3', 1, '', 1);
INSERT INTO item_description VALUES ('MEM', 'Mexico Chiapas \'Mut Vitz\' FT Org Coffee', '152.12', 6, '1', 0, '24+250+250+250+250', 1024);
INSERT INTO item_description VALUES ('MEV', 'Mexico Chiapas Maya Vinic FT Coffee', '152.12', 7, '1', 0, '40+175', 215);
INSERT INTO item_description VALUES ('NIC', 'Nicaragua SHG \'Matagalpa\' FT Org Coffee', '152.12', 8, '1', 0, '23+20+220+220+250', 733);
INSERT INTO item_description VALUES ('SUG', 'Sumatra Gayo Mtn Org FT Coffee', '132.28', 12, '1', 0, '199+275+225+275+275', 1249);
INSERT INTO item_description VALUES ('SUR', 'Sumatra Gayo Robusta Organic Fair Trade', '132.28', 13, '1', 0, '28+50', 78);
INSERT INTO item_description VALUES ('TIM', 'East Timor Maubisse Organic Fair Trade Coffee', '132.28', 14, '1', 0, '159+250', 409);
INSERT INTO item_description VALUES ('CRG', 'Costa Rica Gaucamayo Organic Fair Trade', '152.12', 2, '1', 0, '2+100+150', 252);
INSERT INTO item_description VALUES ('COT', 'Colombia Excelso Fair Trade Coffee', '154.32', 4, '1', 0, '69', 69);
INSERT INTO item_description VALUES ('ETL', 'Ethiopia Limu Org FT Coffee', '132.28', 26, '3', 1, '', 7);
INSERT INTO item_description VALUES ('MED', 'Mexico Decaf SWP Organic Fair Trade Coffee', '132', 16, '2', 0, '50+50+50+3', 153);
INSERT INTO item_description VALUES ('PED', 'Peru Decaf SWP Organic Fair Trade Coffee', '132', 17, '2', 0, '30+50+50+50+100', 280);
INSERT INTO item_description VALUES ('NIS', 'Nicaragua Sandino SHG FT Coffee', '152.12', 18, '3', 0, '55', 55);
INSERT INTO item_description VALUES ('NIR', 'Nicaragua Prodecoop SHG FT Org Coffee', '152.12', 19, '3', 1, '20+30', 50);
INSERT INTO item_description VALUES ('CRS', 'Costa Rica Solar HB FT Coffee', '152.12', 20, '3', 0, '', 0);
INSERT INTO item_description VALUES ('GUH', 'Guatemala Huehuetenango', '152.12', 21, '3', 0, '', 18);
INSERT INTO item_description VALUES ('GUG', 'Guatemala Antigua', '152.12', 22, '3', 0, '', 9);
INSERT INTO item_description VALUES ('MEU', 'Mexico Oaxaca Altura UCIRI FT Org Coffee', '152.12', 23, '1', 0, '26', 26);
INSERT INTO item_description VALUES ('EQE', 'Equador Decaf Fair Trade Organic', '132', 24, '3', 1, '', 16);
INSERT INTO item_description VALUES ('PEI', 'Peru SWP Decaf Organic Coffee', '132', 25, '3', 0, '', 7);
INSERT INTO item_description VALUES ('MEH', 'Mexico Chiapas ISMAM FT Org', '152.12', 28, '3', 1, '', 7);
INSERT INTO item_description VALUES ('CRD', 'Costa Rica Gaucamayo Organic Fair Trade', '152.12', 29, '3', 1, '', 5);
INSERT INTO item_description VALUES ('SUI', 'Sumatra Gayo Organic Fair Trade IA', '132.28', 30, '3', 0, '3+10+10+80+30+20+15', 168);
INSERT INTO item_description VALUES ('NIL', 'Nicaragua La Esperanza FT Org Coffee', '152.12', 29, '3', 0, '55', 55);
INSERT INTO item_description VALUES ('PNK', 'Papua New Guinea KWAY FT Org', '132.28', 1, '1', 0, '', 250);
INSERT INTO item_description VALUES ('GUM', 'Guatemala San Marcos Maya Civil FT Org', '152.12', 1, '1', 0, '', 250);

