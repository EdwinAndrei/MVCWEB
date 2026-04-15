Permisos



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