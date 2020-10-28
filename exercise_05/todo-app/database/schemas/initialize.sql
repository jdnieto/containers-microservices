CREATE TABLE IF NOT EXISTS `tareas` 
(
  `id` tinyint(5) unsigned NOT NULL AUTO_INCREMENT,
  `tarea` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
