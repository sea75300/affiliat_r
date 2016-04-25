CREATE TABLE IF NOT EXISTS `{{dbprefix}}_logins` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sessionId` varchar(255) COLLATE utf8_bin NOT NULL,
  `login` bigint(20) NOT NULL,
  `logout` bigint(20) NOT NULL,
  `ip` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1;