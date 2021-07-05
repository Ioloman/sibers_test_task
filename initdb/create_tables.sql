-- Table users

CREATE TABLE `registered_users`.`users`
(
  `id` Int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `login` Varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` Varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `role` Varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

  PRIMARY KEY (`id`),
  UNIQUE `login` (`login`)
)
;

-- Table users_data

CREATE TABLE `registered_users`.`users_data`
(
  `id` Int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` Varchar(50),
  `last_name` Varchar(50),
  `birth_date` Date,
  `gender` Varchar(10),
  `user_id` Int(11) UNSIGNED NOT NULL,

  INDEX `user_id` (`user_id`),
  PRIMARY KEY (`id`)
)
;

-- Create foreign keys (relationships) section -------------------------------------------------

ALTER TABLE `registered_users`.`users_data` ADD FOREIGN KEY (`user_id`) REFERENCES `registered_users`.`users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
;

INSERT INTO users(login,password,role) VALUES('test','admin','admin');