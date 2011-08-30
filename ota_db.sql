CREATE TABLE IF NOT EXISTS `devices` (
  `id` int(11) NOT NULL auto_increment COMMENT 'Unique index id',
  `device` varchar(50) NOT NULL COMMENT 'Devices manufacturer id e.g. crespo',
  `board` varchar(50) NOT NULL COMMENT 'Hardware board name e.g. herring',
  `name` varchar(255) NOT NULL,
  `version` varchar(20) NOT NULL COMMENT 'Files version id',
  `checksum` varchar(255) NOT NULL COMMENT 'Files MD5 checksum',
  `filename` varchar(255) NOT NULL COMMENT 'Filename of ROM e.g. miuiandroid_NS-1.8.17.zip',
  `filesize` varchar(10) NOT NULL COMMENT 'Filesize of ROM',
  `branch` varchar(5) NOT NULL default 'X' COMMENT 'Stable or Development',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;