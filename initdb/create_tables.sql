-- Table users

CREATE TABLE `registered_users`.`users`
(
  `id` Int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `login` Varchar(50) NOT NULL,
  `password` Varchar(32) NOT NULL,
  `role_id` Int(11) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

  PRIMARY KEY (`id`),
  INDEX `role_id` (`role_id`),
  UNIQUE `login` (`login`)
) default charset utf8;

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
) default charset utf8;

-- Table roles

CREATE TABLE `registered_users`.`roles`(  
    `id` Int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `role` Varchar(5),
    
    PRIMARY KEY (`id`)
) default charset utf8;

-- Create foreign keys (relationships) section -------------------------------------------------

ALTER TABLE `registered_users`.`users_data` ADD FOREIGN KEY (`user_id`) REFERENCES `registered_users`.`users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
;

ALTER TABLE `registered_users`.`users` ADD FOREIGN KEY (`role_id`) REFERENCES `registered_users`.`roles` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
;

INSERT INTO `registered_users`.`roles`(id, role) VALUES (1, 'user'), (2, 'admin');
INSERT INTO `registered_users`.`users`(login,password,role_id) VALUES('test','admin',2);
INSERT INTO `registered_users`.`users_data`(user_id) VALUES(1);