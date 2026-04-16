-- Active: 1774994373148@@127.0.0.1@3306@nwdb
INSERT INTO usuario
(useremail, username, userpswd, userfching, userpswdest, userpswdexp, userest, useractcod, userpswdchg, usertipo)
VALUES
('admin@caps.com', 'admin', 'admin123', NOW(), 'ACT', , 'ACT', '', '', 'ADM');

INSERT INTO roles (rolescod, rolesdsc, rolesest)
VALUES ('ADMIN', 'Admin', 'ACT');

INSERT INTO roles_usuarios
(usercod, rolescod, roleuserest, roleuserfch, roleuserexp)
VALUES
(1, 'ADMIN', 'ACT', NOW(), );

INSERT INTO funciones (fncod, fndsc, fnest, fntyp) VALUES
('carretilla_add', 'Agregar productos a carretilla', 'ACT', 'FNC'),
('checkout_run', 'Ejecutar checkout', 'ACT', 'ACC'),
('citas_listado_DEL', 'borrar citas', 'ACT', 'FNC'),
('citas_listado_INS', 'Insertar citas', 'ACT', 'FNC'),
('citas_listado_UPD', 'actualizar citas', 'ACT', 'FNC'),
('Controllers\\Admin\\Admin', 'Acceso Panel Admin', 'ACT', 'CTR'),
('Controllers\\Admin\\Logs', 'Acceso Logs', 'ACT', 'CTR'),
('Controllers\\Admin\\Transaccion', 'Acceso Listado Transacciones', 'ACT', 'CTR'),
('Controllers\\Admin\\Transacciones', 'Acceso Detalle Transaccion', 'ACT', 'CTR'),
('Controllers\\Admin\\Users', 'Acceso Listado Usuarios', 'ACT', 'CTR'),
('Controllers\\Admin\\User', 'Acceso Formulario Usuario', 'ACT', 'CTR'),
('Controllers\\Carretilla\\Carretilla', 'Controllers\\Carretilla\\Carretilla', 'ACT', 'CTR'),
('Controllers\\Checkout\\Checkout', 'Controllers\\Checkout\\Checkout', 'ACT', 'CTR'),
('Controllers\\Citas\\Cita', 'Listado de Citas', 'ACT', 'CTR'),
('Controllers\\Citas\\Citas', 'Formulario de Cita', 'ACT', 'CTR'),
('Controllers\\Products\\Products', 'Listado de Productos', 'ACT', 'CTR'),
('Controllers\\Products\\Product', 'Formulario de Producto', 'ACT', 'CTR'),
('Controllers\\Services\\Service', 'Services', 'ACT', 'CTR'),
('Controllers\\Services\\Services', 'Services', 'ACT', 'CTR'),
('Menu_Admin', 'Menu Admin', 'ACT', 'MNU'),
('Menu_Citas', 'Menu_Citas', 'ACT', 'MNU'),
('Menu_PaymentCheckout', 'Menu_PaymentCheckout', 'ACT', 'MNU'),
('Menu_Products', 'Menu_Products', 'ACT', 'MNU'),
('Menu_Services', 'Menu_Services', 'ACT', 'MNU'),
('productos_listado_DEL', 'productos_listado_DEL', 'ACT', 'FNC'),
('productos_listado_INS', 'productos_listado_INS', 'ACT', 'FNC'),
('productos_listado_UPD', 'productos_listado_UPD', 'ACT', 'FNC'),
('Products_Product_EDIT', 'Products_Product_EDIT', 'ACT', 'FNC'),
('services_listado_DEL', 'services_listado_DEL', 'ACT', 'FNC'),
('services_listado_INS', 'services_listado_INS', 'ACT', 'FNC'),
('services_listado_UPD', 'services_listado_UPD', 'ACT', 'FNC'),
('transacciones_listado_DSP', 'Ver Transaccion', 'ACT', 'OPR'),
('transacciones_listado_DEL', 'Eliminar Transaccion', 'ACT', 'OPR'),
('usuarios_listado_UPD', 'Editar Usuario', 'ACT', 'OPR'),
('usuarios_listado_DEL', 'Eliminar Usuario', 'ACT', 'OPR'),
('usuarios_listado_ROL', 'Gestionar Roles', 'ACT', 'OPR');



/* USUARIO */

INSERT INTO funciones_roles (rolescod, fncod, fnrolest) VALUES
('USER', 'carretilla_add', 'ACT'),
('USER', 'checkout_run', 'ACT'),
('USER', 'citas_listado_INS', 'ACT'),
('USER', 'Controllers\\Admin\\User', 'ACT'),
('USER', 'Controllers\\Carretilla\\Carretilla', 'ACT'),
('USER', 'Controllers\\Checkout\\Checkout', 'ACT'),
('USER', 'Controllers\\Citas\\Cita', 'ACT'),
('USER', 'Controllers\\Citas\\Citas', 'ACT'),
('USER', 'Controllers\\Products\\Products', 'ACT'),
('USER', 'Menu_Citas', 'ACT'),
('USER', 'Menu_PaymentCheckout', 'ACT'),
('USER', 'Menu_Products', 'ACT');

/* AUDITOR */
INSERT INTO funciones_roles (rolescod, fncod, fnrolest) VALUES
('AUDITOR', 'Controllers\\Admin\\User', 'ACT'),
('AUDITOR', 'Controllers\\Carretilla\\Carretilla', 'ACT'),
('AUDITOR', 'Controllers\\Checkout\\Checkout', 'ACT'),
('AUDITOR', 'Controllers\\Citas\\Cita', 'ACT'),
('AUDITOR', 'Controllers\\Citas\\Citas', 'ACT'),
('AUDITOR', 'Controllers\\Products\\Product', 'ACT'),
('AUDITOR', 'Controllers\\Products\\Products', 'ACT'),
('AUDITOR', 'Controllers\\Services\\Service', 'ACT'),
('AUDITOR', 'Controllers\\Services\\Service', 'ACT'),
('USER', 'Menu_Citas', 'ACT'),
('USER', 'Menu_Services', 'ACT'),
('USER', 'Menu_Products', 'ACT');


INSERT INTO funciones_roles (rolescod, fncod, fnrolest) VALUES
('ADMIN', 'Menu_Admin', 'ACT'),
('ADMIN', 'Controllers\\Admin\\Admin', 'ACT'),
('ADMIN', 'Controllers\\Products\\Products', 'ACT'),
('ADMIN', 'Controllers\\Products\\Product', 'ACT'),
('ADMIN', 'Controllers\\Citas\\Citas', 'ACT'),
('ADMIN', 'Controllers\\Citas\\Cita', 'ACT'),
('ADMIN', 'Controllers\\Services\\Services', 'ACT'),
('ADMIN', 'Controllers\\Services\\Service', 'ACT'),
('ADMIN', 'Menu_Products', 'ACT'),
('ADMIN', 'Menu_Services', 'ACT'),
('ADMIN', 'productos_listado_INS', 'ACT'),
('ADMIN', 'productos_listado_UPD', 'ACT'),
('ADMIN', 'productos_listado_DEL', 'ACT'),
('ADMIN', 'services_listado_INS', 'ACT'),
('ADMIN', 'services_listado_UPD', 'ACT'),
('ADMIN', 'services_listado_DEL', 'ACT'),
('ADMIN', 'Controllers\\Admin\\Users', 'ACT'),
('ADMIN', 'Controllers\\Admin\\User', 'ACT'),
('ADMIN', 'usuarios_listado_UPD', 'ACT'),
('ADMIN', 'usuarios_listado_DEL', 'ACT'),
('ADMIN', 'usuarios_listado_ROL', 'ACT'),
('ADMIN', 'services_listado_INS', 'ACT'),
('ADMIN', 'services_listado_UPD', 'ACT'),
('ADMIN', 'services_listado_DEL', 'ACT'),
('ADMIN', 'citas_listado_INS', 'ACT'),
('ADMIN', 'citas_listado_UPD', 'ACT'),
('ADMIN', 'citas_listado_DEL', 'ACT'),
('ADMIN', 'Menu_Citas', 'ACT'),
('ADMIN', 'carretilla_add', 'ACT'),
('ADMIN', 'Controllers\\Checkout\\Checkout', 'ACT'),
('ADMIN', 'Controllers\\Admin\\Transacciones', 'ACT'),
('ADMIN', 'Controllers\\Admin\\Transaccion', 'ACT'),
('ADMIN', 'transacciones_listado_DSP', 'ACT'),
('ADMIN', 'transacciones_listado_DEL', 'ACT'),
('ADMIN', 'Controllers\\Admin\\Logs', 'ACT'),
('ADMIN', 'Menu_PaymentCheckout', 'ACT'),

/* Registro de compras */ 

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

select * from funciones_roles;