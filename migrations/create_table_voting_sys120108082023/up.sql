-- TABLE DE USUARIOS ADMINISTRADORES--
CREATE TABLE `voting_sys`.`admins` (`admin_id` INT NOT NULL AUTO_INCREMENT COMMENT 'ID DA CONTA',
 `admin_email` TEXT NOT NULL COMMENT 'EMAIL DA CONTA',
 `admin_password` TEXT NOT NULL COMMENT 'SENHA DA CONTA',
 `admin_type` TEXT NOT NULL COMMENT 'TIPO DA CONTA',
 PRIMARY KEY (`admin_id`))
 ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT = 'TABELA DE CONTAS DE USUARIO';