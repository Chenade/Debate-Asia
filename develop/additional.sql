-- Create Competitions table
CREATE TABLE Competitions (
    competition_id INT PRIMARY KEY,
    competition_name VARCHAR(255),
    start_date DATE,
    end_date DATE
);

-- Create Groups table
CREATE TABLE Groups (
    group_id INT PRIMARY KEY,
    competition_id INT,
    group_name VARCHAR(255),
    group_config TEXT,
    FOREIGN KEY (competition_id) REFERENCES Competitions(competition_id)
);

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