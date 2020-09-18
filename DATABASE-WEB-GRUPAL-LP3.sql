CREATE DATABASE buengustoperuano;

USE buengustoperuano;

CREATE TABLE formaspago (
	idformaspago INT NOT NULL AUTO_INCREMENT,
	descripcionformaspago VARCHAR(50),
	CONSTRAINT pk_formaspago PRIMARY KEY (idformaspago)
);

CREATE TABLE tipospedido (
	idtipospedido INT NOT NULL AUTO_INCREMENT,
	descripciontipospedido VARCHAR(50),
	CONSTRAINT pk_tipospedido PRIMARY KEY (idtipospedido)
);

CREATE TABLE sucursal(
   idsucursal INT NOT NULL AUTO_INCREMENT,
   nomsucursal VARCHAR(50),
   direcsucursal VARCHAR(50),
   telefono VARCHAR(50),
   horaatencion TIME,
  	CONSTRAINT pk_sucursal PRIMARY KEY (idsucursal)
);

CREATE TABLE productos(
   idproducto INT NOT NULL AUTO_INCREMENT,
	idsucursal INT NOT NULL,
	nomproducto VARCHAR(50),
	precio DECIMAL(10.2),
	stock INT,
	CONSTRAINT pk_productos PRIMARY KEY (idproducto,idsucursal),
	CONSTRAINT fk_sucursal_productos FOREIGN KEY (idsucursal) REFERENCES sucursal(idsucursal)
);
	
CREATE TABLE usuario(
   idusuario INT NOT NULL AUTO_INCREMENT,
   idsucursal INT NOT NULL,
   email VARCHAR(50) NOT NULL,
   nombreencargado VARCHAR(50),
   apellidoencargado VARCHAR(50),
   contraseña VARCHAR(50) NOT NULL,
	CONSTRAINT pk_usuario PRIMARY KEY (idusuario),
   CONSTRAINT fk_sucursal_usuario FOREIGN KEY (idsucursal) REFERENCES sucursal(idsucursal)
);

CREATE TABLE pedidos (
	idventa INT NOT NULL AUTO_INCREMENT,
	idformaspago INT NOT NULL,
	idtipospedido INT NOT NULL,
	horapedido DATE,
	estado CHAR(1),
	montopagar VARCHAR(50),
	nombreconsumidor VARCHAR(50),
	apellidoconsumidor VARCHAR(50),
	correoconsumidor VARCHAR(50),
	telefonoconsumidor NUMERIC,
	direccionconsumidor VARCHAR(50),
	referenciaconsumidor VARCHAR(50),
	dniconsumidor VARCHAR(8),
   CONSTRAINT pk_pedidos PRIMARY KEY (idventa),
   CONSTRAINT fk_formaspago_pedidos FOREIGN KEY (idformaspago) REFERENCES formaspago(idformaspago),
	CONSTRAINT fk_tipospedido_pedidos FOREIGN KEY (idtipospedido) REFERENCES tipospedido(idtipospedido)	   
);

CREATE TABLE detalleventa(
   idventa INT NOT NULL,
	idproducto INT NOT NULL,
	idsucursal INT NOT NULL,
	cantidad VARCHAR(50),
	CONSTRAINT pk_detalleventa PRIMARY KEY (idventa,idproducto,idsucursal),
	CONSTRAINT fk_pedidos_detalleventa FOREIGN KEY (idventa) REFERENCES pedidos(idventa),
	CONSTRAINT fk_productos_detalleventa FOREIGN KEY (idproducto) REFERENCES productos(idproducto),
	CONSTRAINT fk_sucursal_detalleventa FOREIGN KEY (idsucursal) REFERENCES sucursal(idsucursal)
	);

-- Ingreso de sucursal
INSERT INTO sucursal (nomsucursal,direcsucursal,telefono) 
VALUES ('El Norteño','Santa María 246, Tarapoto','+51 42 522604');
INSERT INTO sucursal (nomsucursal,direcsucursal,telefono) 
VALUES ('La Collpa','Av. Circunvalación 202, Tarapoto','+51 42 522644');
INSERT INTO sucursal (nomsucursal,direcsucursal,telefono) 
VALUES ('Doña Zully','Jr. San Pablo de la Cruz 244, Tarapoto','+51 42 530670');
INSERT INTO sucursal (nomsucursal,direcsucursal,telefono) 
VALUES ('Chalet Venzia','Jr. Alegría Arias de Morey 293-175, Tarapoto','+51 42 522104');


-- Consulta
SELECT*FROM sucursal;

--Ingreso de formas de pago
INSERT INTO formaspago (descripcionformaspago) 
VALUES ('Efectivo');
INSERT INTO formaspago (descripcionformaspago) 
VALUES ('Online');
INSERT INTO formaspago (descripcionformaspago) 
VALUES ('POS');

--Ingreso de tipos de pedido
INSERT INTO tipospedido (descripciontipospedido) 
VALUES ('Delivery');
INSERT INTO tipospedido (descripciontipospedido) 
VALUES ('Recojo en local');
INSERT INTO tipospedido (descripciontipospedido) 
VALUES ('Reserva');

--Ingreso de usuarios
INSERT INTO usuario (idsucursal,email,nombreencargado,apellidoencargado,contraseña) 
VALUES (1,'jerryinga12@gmail.com','Jerry Josias','Sobojeda Pinchi','aguantelgtb');
INSERT INTO usuario (idsucursal,email,nombreencargado,apellidoencargado,contraseña) 
VALUES (2,'freddyhidalgo@gmail.com','Freddy Roberto','Culqui Chupingawa','vivaelpubg');
INSERT INTO usuario (idsucursal,email,nombreencargado,apellidoencargado,contraseña) 
VALUES (3,'ariano@gmail.com','Arian','Chuquilin Sanches','vivaellol');
INSERT INTO usuario (idsucursal,email,nombreencargado,apellidoencargado,contraseña) 
VALUES (4,'jordidrox@gmail.com','Jordi','Panduro Valverde','vivaelclash');




