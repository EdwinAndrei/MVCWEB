Permisos de admin usuarios



INSERT INTO funciones (fncod, fndsc, fnest, fntyp) VALUES
('Menu_Admin', 'Menu Admin', 'ACT', 'MNU'),
('Controllers\\Admin\\Admin', 'Acceso Panel Admin', 'ACT', 'CTR');

INSERT INTO funciones_roles (rolescod, fncod, fnrolest) VALUES
('ADMIN', 'Menu_Admin', 'ACT'),
('ADMIN', 'Controllers\\Admin\\Admin', 'ACT');


INSERT INTO funciones (fncod, fndsc, fnest, fntyp) VALUES
('Controllers\\Admin\\Users', 'Acceso Listado Usuarios', 'ACT', 'CTR'),
('Controllers\\Admin\\User', 'Acceso Formulario Usuario', 'ACT', 'CTR'),
('usuarios_listado_UPD', 'Editar Usuario', 'ACT', 'OPR'),
('usuarios_listado_DEL', 'Eliminar Usuario', 'ACT', 'OPR'),
('usuarios_listado_ROL', 'Gestionar Roles', 'ACT', 'OPR');

INSERT INTO funciones_roles (rolescod, fncod, fnrolest) VALUES
('ADMIN', 'Controllers\\Admin\\Users', 'ACT'),
('ADMIN', 'Controllers\\Admin\\User', 'ACT'),
('ADMIN', 'usuarios_listado_UPD', 'ACT'),
('ADMIN', 'usuarios_listado_DEL', 'ACT'),
('ADMIN', 'usuarios_listado_ROL', 'ACT');


Registro de compras 

CREATE TABLE `transacciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usercod` bigint(10) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `fecha` datetime NOT NULL,
  `tipo` varchar(50) NOT NULL COMMENT 'producto o cita',
  `referencia` varchar(255) NULL COMMENT 'ID de orden PayPal',
  `estado` varchar(50) NOT NULL DEFAULT 'completado',
  PRIMARY KEY (`id`),
  FOREIGN KEY (`usercod`) REFERENCES `usuario`(`usercod`)
);




Permisos de admin


INSERT INTO funciones (fncod, fndsc, fnest, fntyp) VALUES
('Controllers\\Admin\\Transacciones', 'Acceso Listado Transacciones', 'ACT', 'CTR'),
('Controllers\\Admin\\Transaccion', 'Acceso Detalle Transaccion', 'ACT', 'CTR'),
('transacciones_listado_DSP', 'Ver Transaccion', 'ACT', 'OPR'),
('transacciones_listado_DEL', 'Eliminar Transaccion', 'ACT', 'OPR');

INSERT INTO funciones_roles (rolescod, fncod, fnrolest) VALUES
('ADMIN', 'Controllers\\Admin\\Transacciones', 'ACT'),
('ADMIN', 'Controllers\\Admin\\Transaccion', 'ACT'),
('ADMIN', 'transacciones_listado_DSP', 'ACT'),
('ADMIN', 'transacciones_listado_DEL', 'ACT');



LOGS 

CREATE TABLE `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usercod` bigint(10) NOT NULL,
  `accion` varchar(255) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT NOW(),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`usercod`) REFERENCES `usuario`(`usercod`)
);

INSERT IGNORE INTO funciones (fncod, fndsc, fnest, fntyp) VALUES
('Controllers\\Admin\\Logs', 'Acceso Logs', 'ACT', 'CTR');

INSERT IGNORE INTO funciones_roles (rolescod, fncod, fnrolest) VALUES
('ADMIN', 'Controllers\\Admin\\Logs', 'ACT');