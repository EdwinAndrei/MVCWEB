use ecommerce;

INSERT INTO funciones_roles (rolescod, fncod, fnrolest, fnexp)
('CLIENTE', 'Controllers\\Products\\Products', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('CLIENTE', 'Controllers\\Services\\Services', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('CLIENTE', 'Controllers\\Citas\\Citas', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('CLIENTE', 'Controllers\\Citas\\Cita', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),

('CLIENTE', 'Menu_Products', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('CLIENTE', 'Menu_Services', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('CLIENTE', 'Menu_Citas', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),

('CLIENTE', 'citas_listado_INS', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('CLIENTE', 'citas_listado_UPD', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR));

INSERT INTO funciones_roles (rolescod, fncod, fnrolest, fnexp)
VALUES
('CLIENTE', 'Controllers\\Products\\Products', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('CLIENTE', 'Controllers\\Services\\Services', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('CLIENTE', 'Controllers\\Citas\\Citas', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('CLIENTE', 'Controllers\\Citas\\Cita', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),

('CLIENTE', 'Menu_Products', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('CLIENTE', 'Menu_Services', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('CLIENTE', 'Menu_Citas', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),

('CLIENTE', 'citas_listado_INS', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR)),
('CLIENTE', 'citas_listado_UPD', 'ACT', DATE_ADD(NOW(), INTERVAL 1 YEAR));

INSERT INTO roles_usuarios 
(usercod, rolescod, roleuserest, roleuserfch, roleuserexp)
VALUES
(15, 'CLIENTE', 'ACT', NOW(), DATE_ADD(NOW(), INTERVAL 1 YEAR));

SELECT * FROM roles_usuarios