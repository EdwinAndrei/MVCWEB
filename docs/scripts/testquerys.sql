/* inserts para permiso de visualización de controlador productos, citas y servicios - ADMIN */
use ecommerce;

INSERT INTO funciones_roles (rolescod, fncod, fnrolest, fnexp)
VALUES
('ADMIN', 'Controllers\\Products\\Products', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('ADMIN', 'Controllers\\Products\\Product', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('ADMIN', 'Controllers\\Citas\\Citas', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('ADMIN', 'Controllers\\Citas\\Cita', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('ADMIN', 'Controllers\\Services\\Services', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('ADMIN', 'Controllers\\Services\\Service', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR));

/* inserts para visualización de navbar ADMIN */
INSERT INTO funciones_roles (rolescod, fncod, fnrolest, fnexp)
VALUES
('ADMIN', 'Menu_Products', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('ADMIN', 'Menu_Services', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('ADMIN', 'Menu_Citas', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR));


/* permisos CRUD Admin */
INSERT INTO funciones_roles (rolescod, fncod, fnrolest, fnexp) VALUES
('ADMIN', 'productos_listado_INS', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('ADMIN', 'productos_listado_UPD', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('ADMIN', 'productos_listado_DEL', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('ADMIN', 'services_listado_INS', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('ADMIN', 'services_listado_UPD', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('ADMIN', 'services_listado_DEL', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('ADMIN', 'citas_listado_INS', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('ADMIN', 'citas_listado_UPD', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('ADMIN', 'citas_listado_DEL', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR));


INSERT INTO products (productName, productDescription, productPrice, productImgUrl, productStock, productStatus) VALUES
('Juguete - Carrito', 'Carrito pequeño para niños', 150.00, 'https://placehold.co/300x220?text=Carrito', 20, 'ACT'),
('Juguete - Muñeca', 'Muñeca sencilla de plástico', 200.00, 'https://placehold.co/300x220?text=Muneca', 15, 'ACT'),
('Juguete - Pelota', 'Pelota liviana para niños', 80.00, 'https://placehold.co/300x220?text=Pelota', 30, 'ACT'),
('Juguete - Bloques', 'Bloques básicos de construcción', 250.00, 'https://placehold.co/300x220?text=Bloques', 10, 'ACT'),
('Manual - Uso Básico', 'Guía sencilla de uso', 50.00, 'https://placehold.co/300x220?text=Manual+Uso', 50, 'ACT'),
('Manual - Armado', 'Instrucciones básicas de armado', 120.00, 'https://placehold.co/300x220?text=Manual+Armado', 12, 'ACT');

ALTER TABLE products ADD productStock INT NOT NULL DEFAULT 0;

INSERT INTO servicios (nombre, descripcion, precio, estado) VALUES
('Evaluación Inicial', 'Primera evaluación del niño', 500.00, 'ACT'),
('Seguimiento Escolar', 'Sesión de seguimiento', 450.00, 'ACT'),
('Orientación a Padres', 'Asesoría para padres de familia', 400.00, 'ACT'),
('Terapia de Lenguaje', 'Sesión de apoyo en lenguaje', 550.00, 'ACT'),
('Apoyo Pedagógico', 'Atención en dificultades de aprendizaje', 600.00, 'ACT'),
('Estimulación Temprana', 'Sesión para desarrollo infantil temprano', 480.00, 'ACT');

INSERT INTO citas (usercod, servicioId, fecha, hora, estado) VALUES
(1, 1, '2026-04-12', '09:00:00', 'pendiente'),
(1, 2, '2026-04-13', '10:30:00', 'confirmada'),
(1, 3, '2026-04-14', '14:00:00', 'cancelada'),
(9, 1, '2026-04-15', '08:30:00', 'pendiente'),
(9, 4, '2026-04-16', '11:00:00', 'confirmada'),
(3, 2, '2026-04-17', '15:30:00', 'pendiente');

INSERT INTO compras (usercod, fecha, total) VALUES
(1, NOW(), 350.00),
(9, NOW(), 500.00),
(3, NOW(), 200.00);

INSERT INTO detalleCompra (compraId, productId, cantidad, precio) VALUES
(1, 1, 2, 150.00),
(1, 3, 1, 50.00),
(2, 2, 2, 200.00),
(3, 4, 1, 200.00);

INSERT INTO pagos (usercod, monto, fecha, tipo, compraId, citaId) VALUES
(1, 350.00, NOW(), 'producto', 1, NULL),
(2, 500.00, NOW(), 'producto', 2, NULL),
(1, 500.00, NOW(), 'cita', NULL, 1),
(2, 450.00, NOW(), 'cita', NULL, 2);

INSERT INTO historial (usercod, accion, fecha) VALUES
(1, 'Creó una cita', NOW()),
(1, 'Realizó una compra', NOW()),
(2, 'Pagó un servicio', NOW()),
(3, 'Canceló una cita', NOW());


-->Los Usuarios
INSERT INTO roles (rolescod, rolesdsc, rolesest) VALUES
('ADMIN', 'Administrador del sistema', 'ACT');
INSERT INTO roles (rolescod, rolesdsc, rolesest) VALUES
('CLIENTE', 'Cliente del sistema', 'ACT'),
('CONSULTOR', 'Consultor', 'ACT');

SELECT fncod FROM funciones;
-->Funciones
INSERT IGNORE INTO funciones (fncod, fndsc, fnest, fntyp) VALUES
('Controllers\\Products\\Products', 'Listado de productos', 'ACT', 'CTR'),
('Controllers\\Products\\Product', 'Formulario de producto', 'ACT', 'CTR'),
('Controllers\\Citas\\Citas', 'Listado de citas', 'ACT', 'CTR'),
('Controllers\\Citas\\Cita', 'Formulario de cita', 'ACT', 'CTR'),
('Controllers\\Services\\Services', 'Listado de servicios', 'ACT', 'CTR'),
('Controllers\\Services\\Service', 'Formulario de servicio', 'ACT', 'CTR'),

('Menu_Products', 'Menú productos', 'ACT', 'MNU'),
('Menu_Services', 'Menú servicios', 'ACT', 'MNU'),
('Menu_Citas', 'Menú citas', 'ACT', 'MNU'),

('productos_listado_INS', 'Insertar productos', 'ACT', 'ACC'),
('productos_listado_UPD', 'Actualizar productos', 'ACT', 'ACC'),
('productos_listado_DEL', 'Eliminar productos', 'ACT', 'ACC'),

('services_listado_INS', 'Insertar servicios', 'ACT', 'ACC'),
('services_listado_UPD', 'Actualizar servicios', 'ACT', 'ACC'),
('services_listado_DEL', 'Eliminar servicios', 'ACT', 'ACC'),

('citas_listado_INS', 'Insertar citas', 'ACT', 'ACC'),
('citas_listado_UPD', 'Actualizar citas', 'ACT', 'ACC'),
('citas_listado_DEL', 'Eliminar citas', 'ACT', 'ACC');

INSERT INTO funciones_roles (rolescod, fncod, fnrolest, fnexp)
VALUES
('ADMIN', 'Controllers\\Products\\Products', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('ADMIN', 'Controllers\\Products\\Product', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('ADMIN', 'Controllers\\Citas\\Citas', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('ADMIN', 'Controllers\\Citas\\Cita', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('ADMIN', 'Controllers\\Services\\Services', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('ADMIN', 'Controllers\\Services\\Service', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),

('ADMIN', 'Menu_Products', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('ADMIN', 'Menu_Services', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('ADMIN', 'Menu_Citas', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),

('ADMIN', 'productos_listado_INS', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('ADMIN', 'productos_listado_UPD', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('ADMIN', 'productos_listado_DEL', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('ADMIN', 'services_listado_INS', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('ADMIN', 'services_listado_UPD', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('ADMIN', 'services_listado_DEL', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('ADMIN', 'citas_listado_INS', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('ADMIN', 'citas_listado_UPD', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('ADMIN', 'citas_listado_DEL', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR));

INSERT IGNORE INTO roles_usuarios 
(usercod, rolescod, roleuserest, roleuserfch, roleuserexp)
VALUES
(12, 'ADMIN', 'ACT', NOW(), DATE_ADD(NOW(), INTERVAL 1 YEAR)),
(11, 'CLIENTE', 'ACT', NOW(), DATE_ADD(NOW(), INTERVAL 1 YEAR)),
(3, 'CLIENTE', 'ACT', NOW(), DATE_ADD(NOW(), INTERVAL 1 YEAR)),
(9, 'CONSULTOR', 'ACT', NOW(), DATE_ADD(NOW(), INTERVAL 1 YEAR));

SELECT * FROM usuario;
SELECT * FROM roles;

SELECT fr.fncod
FROM roles_usuarios ru
JOIN funciones_roles fr ON ru.rolescod = fr.rolescod
WHERE ru.usercod = 12;

--> NUevo Usurio
INSERT INTO usuario 
(useremail, username, userpswd, userfching, userpswdest, userpswdexp, userest, usertipo)
VALUES
('cliente13@mail.com', 'cliente13', '123456', NOW(), 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR), 'ACT', 'CLI');

INSERT INTO roles_usuarios 
(usercod, rolescod, roleuserest, roleuserfch, roleuserexp)
VALUES
(13, 'CLIENTE', 'ACT', NOW(), DATE_ADD(NOW(), INTERVAL 1 YEAR));

INSERT INTO roles_usuarios 
(usercod, rolescod, roleuserest, roleuserfch, roleuserexp)
VALUES
(LAST_INSERT_ID(), 'CLIENTE', 'ACT', NOW(), DATE_ADD(NOW(), INTERVAL 1 YEAR));

SELECT * FROM usuario WHERE usercod = 13;

SELECT * FROM roles_usuarios WHERE usercod = 15;

SELECT * FROM servicios

SELECT * FROM usuario

INSERT INTO usuario 
(useremail, username, userpswd, userfching, userpswdest, userpswdexp, userest, usertipo)
VALUES
('cliente14@mail.com', 'cliente14', 'ese$123456', NOW(), 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR), 'ACT', 'CLI');