CREATE TABLE `voting_sys`.`products` (
    `product_id` INT NOT NULL AUTO_INCREMENT COMMENT 'ID DO PRODUTO',
    `product_name` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'NOME DO PRODUTO',
    `product_description` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'DESCRIÇÃO DO PRODUTO',
    `product_number` INT(255) NOT NULL COMMENT 'NUMERO DO PRODUTO',
    `product_image` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'IMAGEM DO PRODUTO',
    `votes` INT NOT NULL COMMENT 'NUM. DE VOTOS DO PRODUTO',
    PRIMARY KEY (`product_id`)
) ENGINE = InnoDB CHARSET = utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT = 'TABELA DE PRODUTOS';


ALTER TABLE products DROP COLUMN votes;