-- PS: This is an example dump of the structure of my database
-- Backup of skyduino (12-Jun-2012)

DROP TABLE `groupes`;

CREATE TABLE `groupes` (
  `groupe_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`groupe_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 

INSERT INTO `groupes` VALUES('1', 'Test');

DROP TABLE `publications`;

CREATE TABLE `publications` (
  `article_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `permalink` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `publish_date` datetime NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `content_ref` char(13) NOT NULL,
  PRIMARY KEY (`article_id`),
  UNIQUE KEY `permalink` (`permalink`,`content_ref`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 


DROP TABLE `tickets`;

CREATE TABLE `tickets` (
  `user_id` int(11) unsigned NOT NULL,
  `ticket` char(13) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 


DROP TABLE `users`;

CREATE TABLE `users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nickname` varchar(25) NOT NULL,
  `display_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(64) NOT NULL,
  `inscription_date` date NOT NULL,
  `birthday` date NOT NULL,
  `last_seen_date` datetime NOT NULL,
  `sexe` char(1) NOT NULL,
  `region` varchar(50) NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `slogan` varchar(140) DEFAULT NULL,
  `website_name` varchar(50) DEFAULT NULL,
  `website_url` varchar(100) DEFAULT NULL,
  `groupe_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `nickname` (`nickname`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 

INSERT INTO `users` VALUES('1', 'toto', 'toto', 'toto@toto.com', '31f7a65e315586ac198bd798b6629ce4903d0899476d5741a9f32e2e521b6a66', '2012-05-02', '2012-05-10', '2012-05-02 00:00:00', 'M', 'Paradise', '1', 'I\'m toto !', 'Toto online', 'toto.com', '1');
INSERT INTO `users` VALUES('2', 'master', 'Chuk Norris', 'god@life.com', '73475cb40a568e8da8a045ced110137e159f890ac4da883b6b17dc651b3a8049', '2012-05-13', '2012-05-08', '2012-05-13 12:35:49', 'M', 'France', '255', 'Headshoot !', 'The life', 'life.com', '1');
INSERT INTO `users` VALUES('3', 'plop', 'plop', 'plop@plop.com', '18496197305510df22af763507c99219ea08e08414383ae1abf1cb156d961a03', '2012-05-16', '2012-05-14', '2012-05-16 09:08:21', 'X', 'Groland', '4', 'plop', 'plop', 'plop.com', '4');

