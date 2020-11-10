CREATE TABLE `users_obituaries` (
  `obituaries_id`          INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `obituaries_uid`         INT(11) UNSIGNED NOT NULL DEFAULT '0',
  `obituaries_date`        DATETIME         NOT NULL ,
  `obituaries_photo`       VARCHAR(255)     NOT NULL,
  `obituaries_description` TEXT             NOT NULL,
  `obituaries_survivors`   TEXT             NOT NULL,
  `obituaries_service`     TEXT             NOT NULL,
  `obituaries_memorial`    TEXT             NOT NULL,
  `obituaries_firstname`   VARCHAR(150)     NOT NULL,
  `obituaries_lastname`    VARCHAR(150)     NOT NULL,
  `obituaries_comments`    INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`obituaries_id`),
  KEY `obituaries_lastname` (`obituaries_lastname`),
  KEY `obituaries_date` (`obituaries_date`),
  KEY `obituaries_uid` (`obituaries_uid`)
)
  ENGINE = MyISAM;
