CREATE TABLE `voting_sys`.`vote_status` (
    `status_id` INT NOT NULL AUTO_INCREMENT COMMENT 'ID DO PAINEL',
    `status` BOOLEAN NOT NULL COMMENT 'STATUS DE VOTAÇÃO',
    `user_id` INT NULL,
    PRIMARY KEY (`status_id`),
    FOREIGN KEY (user_id) REFERENCES Users(user_id)
) ENGINE = InnoDB;

INSERT INTO `vote_status` (`status_id`, `status`) VALUES ('12', '0')

