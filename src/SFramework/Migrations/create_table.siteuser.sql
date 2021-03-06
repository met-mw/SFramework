CREATE TABLE `siteuser` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(100) NOT NULL,
	`surname` VARCHAR(100) NOT NULL,
	`login` VARCHAR(100) NOT NULL,
	`email` VARCHAR(100) NOT NULL,
	`password` VARCHAR(255) NOT NULL,
	`date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `email` (`email`),
	UNIQUE INDEX `login` (`login`),
	INDEX `date` (`date`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=1
;