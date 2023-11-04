-- Create Competitions table
CREATE TABLE Competitions (competition_id INT PRIMARY KEY,competition_name VARCHAR(255),start_date DATE,end_date DATE,created_at DATETIME,updated_at DATETIME,);

-- Create Groups table
CREATE TABLE Groups (group_id INT PRIMARY KEY,competition_id INT,group_name VARCHAR(255),group_config TEXT,FOREIGN KEY (competition_id) REFERENCES Competitions(competition_id));

-- Create Sessions table
CREATE TABLE Sessions (
    session_id INT PRIMARY KEY,
    group_id INT,
    session_name VARCHAR(255),
    session_config TEXT,
    FOREIGN KEY (group_id) REFERENCES Groups(group_id)
);

-- Create Rounds table
CREATE TABLE Rounds (
    round_id INT PRIMARY KEY,
    session_id INT,
    round_number INT,
    candidate_quantity INT,
    round_config TEXT,
    FOREIGN KEY (session_id) REFERENCES Sessions(session_id)
);

-- Create Articles table
CREATE TABLE Articles (
    article_id INT PRIMARY KEY,
    user_id INT,
    article_content TEXT,
    FOREIGN KEY (user_id) REFERENCES Users(user_id)
);

ALTER TABLE `users` CHANGE `token` `token` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `users` ADD `name_en` VARCHAR(255) NOT NULL AFTER `name_zh`;
ALTER TABLE `users` ADD `gender` VARCHAR(10) NOT NULL AFTER `name_en`;
ALTER TABLE `users` ADD `address` TEXT NOT NULL AFTER `account`;

ALTER TABLE `competition_log` ADD `date` JSON NOT NULL AFTER `groupId`, ADD `language` JSON NOT NULL AFTER `date`, ADD `invoice_name` VARCHAR(50) NULL AFTER `language`, ADD `invoice_no` VARCHAR(20) NULL AFTER `invoice_name`;

ALTER TABLE `competition_log` CHANGE `language` `language` VARCHAR(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL;
ALTER TABLE `competition_log` ADD `updated_at` DATE NOT NULL AFTER `approval`, ADD `created_at` DATE NOT NULL AFTER `updated_at`;
ALTER TABLE `users` ADD `mentor` TEXT NOT NULL AFTER `email`;
ALTER TABLE `users` ADD `region` TEXT NOT NULL AFTER `email`;
ALTER TABLE `competition_log` ADD `competition_id` INT NOT NULL DEFAULT '1' AFTER `userId`;
ALTER TABLE `groups` ADD `t_write` INT NULL AFTER `group_config`, ADD `t_read` INT NULL AFTER `t_write`, ADD `t_debate` INT NULL AFTER `t_read`;
ALTER TABLE `groups` CHANGE `group_id` `id` INT(11) NOT NULL;

ALTER TABLE `sessions` ADD `updated_at` DATE NOT NULL AFTER `session_config`, ADD `created_at` DATE NOT NULL AFTER `updated_at`;
ALTER TABLE `sessions` CHANGE `session_id` `id` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `sessions` ADD `date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `session_config`;
ALTER TABLE `competition_log` CHANGE `groupId` `group_id` INT(11) NOT NULL;
ALTER TABLE `rounds` CHANGE `round_id` `id` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `rounds` CHANGE `candidate_quantity` `user_id` INT(11) NULL DEFAULT NULL;
ALTER TABLE `rounds` ADD `updated_at` DATE NOT NULL AFTER `rounds_config`, ADD `created_at` DATE NOT NULL AFTER `updated_at`;
ALTER TABLE `sessions` ADD `pos_title` VARCHAR(50) NULL AFTER `session_config`, ADD `neg_title` VARCHAR(50) NULL AFTER `pos_title`;
ALTER TABLE `sessions` CHANGE `date` `date` INT NOT NULL DEFAULT CURRENT_TIMESTAMP;

DROP TABLE `debateasia`.`groups`;
CREATE TABLE `groups` ( `id` int(11) NOT NULL, `competition_id` int(11) DEFAULT NULL, `group_name` varchar(255) DEFAULT NULL, `group_config` text DEFAULT NULL, `t_write` int(11) DEFAULT NULL, `t_read` int(11) DEFAULT NULL, `t_debate` int(11) DEFAULT NULL, `updated_at` datetime NOT NULL DEFAULT current_timestamp(), `created_at` datetime NOT NULL DEFAULT current_timestamp() ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `groups` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`id`);
ALTER TABLE `rounds` ADD `status` INT NOT NULL DEFAULT '0' AFTER `round_config`;

ALTER TABLE `rounds` ADD `role` INT NOT NULL DEFAULT '0' AFTER `round_number`;

ALTER TABLE `articles` CHANGE `user_id` `round_id` INT(11) NULL DEFAULT NULL;
ALTER TABLE `articles` ADD `type` INT NOT NULL AFTER `round_id`;
ALTER TABLE `articles` CHANGE `article_content` `content` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL;
ALTER TABLE `rounds` ADD `camera` VARCHAR(120) NULL AFTER `user_id`, ADD `camera_ts` INT NULL AFTER `camera`;
