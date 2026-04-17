

-- =========================
-- ASIGNAR ROL ADMIN
-- =========================
INSERT INTO roles_usuarios 
(usercod, rolescod, roleuserest, roleuserfch, roleuserexp)
VALUES
(1, 'ADMIN', 'ACT', NOW(), DATE_ADD(NOW(), INTERVAL 1 YEAR));

-- =========================
-- PERMISOS PARA USER
-- =========================
INSERT INTO funciones_roles (rolescod, fncod, fnrolest, fnexp) VALUES
-- Productos
('USER', 'Controllers\\Products\\Products', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('USER', 'Menu_Products', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
-- Citas
('USER', 'Controllers\\Citas\\Citas', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('USER', 'Controllers\\Citas\\Cita', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('USER', 'Menu_Citas', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('USER', 'citas_listado_INS', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('USER', 'citas_listado_UPD', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
-- Carretilla
('USER', 'Controllers\\Carretilla\\Carretilla', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('USER', 'carretilla_add', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
-- Checkout
('USER', 'Controllers\\Checkout\\Checkout', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('USER', 'checkout_run', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('USER', 'Menu_PaymentCheckout', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR));


-- =========================
-- AUDITOR
-- =========================
INSERT INTO funciones_roles (rolescod, fncod, fnrolest, fnexp) VALUES
-- Productos
('AUDITOR', 'Controllers\\Products\\Products', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('AUDITOR', 'Menu_Products', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
-- Servicios
('AUDITOR', 'Controllers\\Services\\Services', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('AUDITOR', 'Menu_Services', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
-- Citas
('AUDITOR', 'Controllers\\Citas\\Citas', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('AUDITOR', 'Controllers\\Citas\\Cita', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('AUDITOR', 'Menu_Citas', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
-- Carretilla (solo ver)
('AUDITOR', 'Controllers\\Carretilla\\Carretilla', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
-- Checkout (solo acceso visual, sin ejecutar)
('AUDITOR', 'Controllers\\Checkout\\Checkout', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('AUDITOR', 'Menu_PaymentCheckout', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR));

-- =========================
-- VERIFICACIÓN
-- =========================
SELECT * FROM usuario;
SELECT * FROM roles_usuarios;
SELECT * FROM funciones;
SELECT * FROM funciones_roles;