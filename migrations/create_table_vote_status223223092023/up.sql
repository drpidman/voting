CREATE TABLE `voting_sys`.`vote_status` (
    `id` INT NOT NULL AUTO_INCREMENT COMMENT 'ID DO PAINEL',
    `status` BOOLEAN NOT NULL COMMENT 'STATUS DE VOTAÇÃO',
    `user` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'USUARIO PERMITIDO',
    `cpf` TEXT NOT NULL COMMENT 'CPF DO USUARIO PERMITIDO',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

INSERT INTO `vote_status` (`id`, `status`, `user`, `cpf`) VALUES ('12', '0', '', '')

