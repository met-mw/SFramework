START TRANSACTION;

CREATE TABLE `example` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`text` TEXT NOT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=1;

INSERT INTO `example` (`text`) VALUES
  ('example 1'),
  ('example 2'),
  ('example 3'),
  ('example 4'),
  ('example 5');

COMMIT;