CREATE SCHEMA `ecommerce` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE DATABASE ecommerce;
 CREATE USER 'ecommerce'@'%' IDENTIFIED BY 'ecommerce';
  GRANT SELECT, INSERT, UPDATE, DELETE ON ecommerce.* TO 'ecommerce'@'%';
SELECT user, host FROM mysql.user WHERE user='ecommerce';

USE ecommerce;

-- =====================
-- USUARIO
-- =====================
CREATE TABLE `usuario` (
    `usercod` BIGINT(10) NOT NULL AUTO_INCREMENT,
    `useremail` VARCHAR(80) DEFAULT NULL,
    `username` VARCHAR(80) DEFAULT NULL,
    `userpswd` VARCHAR(128) DEFAULT NULL,
    `userfching` DATETIME DEFAULT NULL,
    `userpswdest` CHAR(3) DEFAULT NULL,
    `userpswdexp` DATETIME DEFAULT NULL,
    `userest` CHAR(3) DEFAULT NULL,
    `useractcod` VARCHAR(128) DEFAULT NULL,
    `userpswdchg` VARCHAR(128) DEFAULT NULL,
    `usertipo` CHAR(3) DEFAULT NULL,
    PRIMARY KEY (`usercod`),
    UNIQUE KEY `useremail_UNIQUE` (`useremail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================
-- ROLES
-- =====================
CREATE TABLE `roles` (
    `rolescod` VARCHAR(128) NOT NULL,
    `rolesdsc` VARCHAR(45) DEFAULT NULL,
    `rolesest` CHAR(3) DEFAULT NULL,
    PRIMARY KEY (`rolescod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================
-- ROLES_USUARIOS
-- =====================
CREATE TABLE `roles_usuarios` (
    `usercod` BIGINT(10) NOT NULL,
    `rolescod` VARCHAR(128) NOT NULL,
    `roleuserest` CHAR(3) DEFAULT NULL,
    `roleuserfch` DATETIME DEFAULT NULL,
    `roleuserexp` DATETIME DEFAULT NULL,
    PRIMARY KEY (`usercod`, `rolescod`),
    FOREIGN KEY (`usercod`) REFERENCES `usuario`(`usercod`),
    FOREIGN KEY (`rolescod`) REFERENCES `roles`(`rolescod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================
-- FUNCIONES
-- =====================
CREATE TABLE `funciones` (
    `fncod` VARCHAR(255) NOT NULL,
    `fndsc` VARCHAR(255) DEFAULT NULL,
    `fnest` CHAR(3) DEFAULT NULL,
    `fntyp` CHAR(3) DEFAULT NULL,
    PRIMARY KEY (`fncod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================
-- FUNCIONES_ROLES
-- =====================
CREATE TABLE `funciones_roles` (
    `rolescod` VARCHAR(128) NOT NULL,
    `fncod` VARCHAR(255) NOT NULL,
    `fnrolest` CHAR(3) DEFAULT NULL,
    `fnexp` DATETIME DEFAULT NULL,
    PRIMARY KEY (`rolescod`, `fncod`),
    FOREIGN KEY (`rolescod`) REFERENCES `roles`(`rolescod`),
    FOREIGN KEY (`fncod`) REFERENCES `funciones`(`fncod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================
-- PRODUCTS
-- =====================
CREATE TABLE `products` (
    `productId` INT NOT NULL AUTO_INCREMENT,
    `productName` VARCHAR(255) NOT NULL,
    `productDescription` TEXT NOT NULL,
    `productPrice` DECIMAL(10,2) NOT NULL,
    `productImgUrl` VARCHAR(255) NOT NULL,
    `productStock` INT NOT NULL DEFAULT 0,
    `productStatus` CHAR(3) NOT NULL,
    PRIMARY KEY (`productId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================
-- CARRETILLA
-- =====================
CREATE TABLE `carretilla` (
    `usercod` BIGINT(10) NOT NULL,
    `productId` INT NOT NULL,
    `crrctd` INT NOT NULL,
    `crrprc` DECIMAL(12,2) NOT NULL,
    `crrfching` DATETIME NOT NULL,
    PRIMARY KEY (`usercod`, `productId`),
    FOREIGN KEY (`usercod`) REFERENCES `usuario`(`usercod`),
    FOREIGN KEY (`productId`) REFERENCES `products`(`productId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================
-- SERVICIOS
-- =====================
CREATE TABLE `servicios` (
    `servicio_id` INT NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(150) NOT NULL,
    `descripcion` VARCHAR(255) NOT NULL,
    `precio` DECIMAL(10,2) NOT NULL,
    `estado` CHAR(4) NOT NULL,
    PRIMARY KEY (`servicio_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================
-- CITAS
-- =====================

CREATE TABLE `citas` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `usercod` BIGINT(10) NOT NULL,
    `servicio_id` INT NOT NULL,
    `fecha` DATE NOT NULL,
    `hora` TIME NOT NULL,
    `estado` VARCHAR(20) NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`usercod`) REFERENCES `usuario`(`usercod`),
    FOREIGN KEY (`servicio_id`) REFERENCES `servicios`(`servicio_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================
-- LOGS
-- =====================
CREATE TABLE `logs` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `usercod` BIGINT(10) NOT NULL,
    `accion` VARCHAR(255) NOT NULL,
    `fecha` DATETIME NOT NULL DEFAULT NOW(),
    PRIMARY KEY (`id`),
    FOREIGN KEY (`usercod`) REFERENCES `usuario`(`usercod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================
-- TRANSACCIONES
-- =====================
CREATE TABLE `transacciones` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `usercod` BIGINT(10) NOT NULL,
    `monto` DECIMAL(10,2) NOT NULL,
    `fecha` DATETIME NOT NULL,
    `tipo` VARCHAR(50) NOT NULL,
    `referencia` VARCHAR(255),
    `estado` VARCHAR(50) NOT NULL DEFAULT 'completado',
    PRIMARY KEY (`id`),
    FOREIGN KEY (`usercod`) REFERENCES `usuario`(`usercod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE historial(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'Primary Key',
    usercod BIGINT(10) NOT NULL COMMENT 'Usuario',
    accion VARCHAR(255) NOT NULL COMMENT 'Accion realizada',
    fecha DATETIME NOT NULL COMMENT 'Fecha',
    FOREIGN KEY (usercod) REFERENCES usuario(usercod)
)