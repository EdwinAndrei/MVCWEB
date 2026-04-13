
CREATE TABLE citas(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'Primary Key',
    usercod BIGINT(10) NOT NULL COMMENT 'Usuario que agenda la cita',
    servicio_id INT NOT NULL COMMENT 'Servicio seleccionado',
    fecha DATE NOT NULL COMMENT 'Fecha de la cita',
    hora TIME NOT NULL COMMENT 'Hora de la cita',
    estado VARCHAR(50) NOT NULL COMMENT 'pendiente, confirmada, cancelada',
    FOREIGN KEY (usercod) REFERENCES usuario(usercod),
    FOREIGN KEY (servicio_id) REFERENCES servicios(servicio_id)
);



CREATE TABLE compras(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'Primary Key',
    usercod BIGINT(10) NOT NULL COMMENT 'Usuario que compra',
    fecha DATETIME NOT NULL COMMENT 'Fecha de la compra',
    total DECIMAL(10,2) NOT NULL COMMENT 'Total de la compra',
    FOREIGN KEY (usercod) REFERENCES usuario(usercod)
) 



CREATE TABLE detalle_compra(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'Primary Key',
    compra_id INT NOT NULL COMMENT 'ID de la compra',
    productId INT NOT NULL COMMENT 'Producto comprado',
    cantidad INT NOT NULL COMMENT 'Cantidad',
    precio DECIMAL(10,2) NOT NULL COMMENT 'Precio del producto',
    FOREIGN KEY (compra_id) REFERENCES compras(id),
    FOREIGN KEY (productId) REFERENCES products(productId)
) 



CREATE TABLE pagos(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'Primary Key',
    usercod BIGINT(10) NOT NULL COMMENT 'Usuario que paga',
    monto DECIMAL(10,2) NOT NULL COMMENT 'Monto',
    fecha DATETIME NOT NULL COMMENT 'Fecha del pago',
    tipo VARCHAR(50) NOT NULL COMMENT 'producto o cita',
    referencia INT NULL COMMENT 'ID de compra o cita',
    FOREIGN KEY (usercod) REFERENCES usuario(usercod)
) 



CREATE TABLE historial(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'Primary Key',
    usercod BIGINT(10) NOT NULL COMMENT 'Usuario',
    accion VARCHAR(255) NOT NULL COMMENT 'Accion realizada',
    fecha DATETIME NOT NULL COMMENT 'Fecha',
    FOREIGN KEY (usercod) REFERENCES usuario(usercod)
)


CREATE TABLE servicios(
    servicio_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'Primary Key',
    nombre VARCHAR(150) NOT NULL COMMENT 'Nombre del servicio',
    descripcion VARCHAR(255) NOT NULL COMMENT 'Descripcion del servicio',
    precio DECIMAL(10,2) NOT NULL COMMENT 'Precio del servicio',
    estado VARCHAR(50) NOT NULL COMMENT 'ACT o IACT'
);