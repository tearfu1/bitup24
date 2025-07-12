CREATE TABLE IF NOT EXISTS `b_bitup_roles` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255) NOT NULL,
	`code` VARCHAR(50) NOT NULL,
	PRIMARY KEY (`id`)
	);

CREATE TABLE IF NOT EXISTS `b_bitup_user_points` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`user_id` INT NOT NULL,
	`points_balance` INT NOT NULL DEFAULT 0,
	PRIMARY KEY (`id`)
	);

CREATE TABLE IF NOT EXISTS `b_bitup_user_roles` (
		`user_id` INT NOT NULL,
		`role_id` INT NOT NULL,
	PRIMARY KEY (`user_id`, `role_id`)
	);

CREATE TABLE IF NOT EXISTS `b_bitup_events` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255) NOT NULL,
	`description` TEXT NULL,
	`start_date` DATETIME NOT NULL,
	`end_date` DATETIME NULL,
	`location` VARCHAR(255) NULL,
	`organizer_id` INT NOT NULL,
	`points_for_visit` INT NOT NULL DEFAULT 0,
	`max_participants` INT NULL DEFAULT 0,
	`status`  VARCHAR(255) NOT NULL,
	PRIMARY KEY (`id`)
	);

CREATE TABLE IF NOT EXISTS `b_bitup_event_registrations` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`event_id` INT NOT NULL,
	`user_id` INT NOT NULL,
	`status`  VARCHAR(255) NOT NULL,
	PRIMARY KEY (`id`)
	);
