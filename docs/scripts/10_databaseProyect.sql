

-- =====================
-- SERVICIOS
-- =====================
CREATE TABLE servicios (
    servicioId INT NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(150) NOT NULL,
    descripcion VARCHAR(255) NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    estado CHAR(4) NOT NULL COMMENT 'ACT / IACT',
    PRIMARY KEY (servicioId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- =====================
-- CITAS
-- =====================
CREATE TABLE citas (
    citaId INT NOT NULL AUTO_INCREMENT,
    usercod BIGINT(10) NOT NULL,
    servicioId INT NOT NULL,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    estado VARCHAR(20) NOT NULL COMMENT 'pendiente, confirmada, cancelada',
    PRIMARY KEY (citaId),

    KEY fk_citas_usuario_idx (usercod),
    KEY fk_citas_servicio_idx (servicioId),

    CONSTRAINT fk_citas_usuario 
        FOREIGN KEY (usercod) 
        REFERENCES usuario(usercod)
        ON DELETE CASCADE ON UPDATE CASCADE,

    CONSTRAINT fk_citas_servicio 
        FOREIGN KEY (servicioId) 
        REFERENCES servicios(servicioId)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- =====================
-- COMPRAS
-- =====================
CREATE TABLE compras (
    compraId INT NOT NULL AUTO_INCREMENT,
    usercod BIGINT(10) NOT NULL,
    fecha DATETIME NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (compraId),

    KEY fk_compras_usuario_idx (usercod),

    CONSTRAINT fk_compras_usuario
        FOREIGN KEY (usercod)
        REFERENCES usuario(usercod)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- =====================
-- DETALLE COMPRA
-- =====================
CREATE TABLE detalleCompra (
    detalleId INT NOT NULL AUTO_INCREMENT,
    compraId INT NOT NULL,
    productId INT NOT NULL,
    cantidad INT NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (detalleId),

    KEY fk_detalle_compra_idx (compraId),
    KEY fk_detalle_producto_idx (productId),

    CONSTRAINT fk_detalle_compra
        FOREIGN KEY (compraId)
        REFERENCES compras(compraId)
        ON DELETE CASCADE ON UPDATE CASCADE,

    CONSTRAINT fk_detalle_producto
        FOREIGN KEY (productId)
        REFERENCES products(productId)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- =====================
-- PAGOS
-- =====================
CREATE TABLE pagos (
    pagoId INT NOT NULL AUTO_INCREMENT,
    usercod BIGINT(10) NOT NULL,
    monto DECIMAL(10,2) NOT NULL,
    fecha DATETIME NOT NULL,
    tipo ENUM('producto','cita') NOT NULL,
    compraId INT NULL,
    citaId INT NULL,
    PRIMARY KEY (pagoId),

    KEY fk_pagos_usuario_idx (usercod),
    KEY fk_pagos_compra_idx (compraId),
    KEY fk_pagos_cita_idx (citaId),

    CONSTRAINT fk_pagos_usuario
        FOREIGN KEY (usercod)
        REFERENCES usuario(usercod)
        ON DELETE CASCADE ON UPDATE CASCADE,

    CONSTRAINT fk_pagos_compra
        FOREIGN KEY (compraId)
        REFERENCES compras(compraId)
        ON DELETE CASCADE ON UPDATE CASCADE,

    CONSTRAINT fk_pagos_cita
        FOREIGN KEY (citaId)
        REFERENCES citas(citaId)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- =====================
-- HISTORIAL
-- =====================
CREATE TABLE historial (
    historialId INT NOT NULL AUTO_INCREMENT,
    usercod BIGINT(10) NOT NULL,
    accion VARCHAR(255) NOT NULL,
    fecha DATETIME NOT NULL,
    PRIMARY KEY (historialId),

    KEY fk_historial_usuario_idx (usercod),

    CONSTRAINT fk_historial_usuario
        FOREIGN KEY (usercod)
        REFERENCES usuario(usercod)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;