CREATE TABLE IF NOT EXISTS `{{dbprefix}}_affiliates` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pageName` varchar(255) CHARACTER SET latin1 NOT NULL,
  `pageUrl` varchar(255) CHARACTER SET latin1 NOT NULL,
  `pageAdminName` varchar(255) CHARACTER SET latin1 NOT NULL,
  `pageAdminEmail` varchar(255) CHARACTER SET latin1 NOT NULL,
  `pageButton` varchar(255) CHARACTER SET latin1 NOT NULL,
  `affiliateCategory` varchar(255) CHARACTER SET latin1 NOT NULL,
  `affiliateAddedTime` bigint(20) NOT NULL,
  `affiliateEditedTime` bigint(20) NOT NULL,
  `affiliateIsMarked` tinyint(1) NOT NULL,
  `affiliateIsAccpted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1;
