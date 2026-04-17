USE ecommerce;
-- =========================
-- ROLES
-- =========================
INSERT INTO roles (rolescod, rolesdsc, rolesest) VALUES
('USER', 'Cliente del sistema', 'ACT'),
('AUDITOR', 'Usuario de solo lectura', 'ACT');

-- =========================
-- FUNCIONES
-- =========================
INSERT INTO funciones (fncod, fndsc, fnest, fntyp) VALUES
-- CONTROLADORES
('Controllers\\Products\\Products', 'Listado de productos', 'ACT', 'CTR'),
('Controllers\\Services\\Services', 'Listado de servicios', 'ACT', 'CTR'),
('Controllers\\Citas\\Citas', 'Listado de citas', 'ACT', 'CTR'),
('Controllers\\Citas\\Cita', 'Formulario de cita', 'ACT', 'CTR'),
('Controllers\\Carretilla\\Carretilla', 'Carretilla de compras', 'ACT', 'CTR'),
('Controllers\\Checkout\\Checkout', 'Proceso de checkout', 'ACT', 'CTR'),
-- MENÚS
('Menu_Products', 'Menú productos', 'ACT', 'MNU'),
('Menu_Services', 'Menú servicios', 'ACT', 'MNU'),
('Menu_Citas', 'Menú citas', 'ACT', 'MNU'),
('Menu_PaymentCheckout', 'Menú de carrito de compra', 'ACT', 'MNU'),
-- OPERACIONES
('citas_listado_INS', 'Insertar citas', 'ACT', 'OPR'),
('citas_listado_UPD', 'Actualizar citas', 'ACT', 'OPR'),
-- ACCIONES
('carretilla_add', 'Agregar producto a carretilla', 'ACT', 'ACC'),
('checkout_run', 'Ejecutar checkout', 'ACT', 'ACC');