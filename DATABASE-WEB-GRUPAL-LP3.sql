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
CREATE TABLE detalleformaspago(
	idformaspago INT NOT NULL,
	idsucursal INT NOT NULL,
	disponibilidadformaspago BOOLEAN,
CONSTRAINT pk_detalleformaspago PRIMARY KEY (idformaspago,idsucursal),
CONSTRAINT fk_formaspago_detalle FOREIGN KEY (idformaspago) REFERENCES formaspago(idformaspago),
CONSTRAINT fk_sucursal_detalle FOREIGN KEY (idsucursal) REFERENCES sucursal(idsucursal)
);

CREATE TABLE detalletipospedido(
	idtipospedido INT NOT NULL,
	idsucursal INT NOT NULL,
	disponibilidadtipospedido BOOLEAN,
CONSTRAINT pk_detalletipospedido PRIMARY KEY (idtipospedido,idsucursal),
CONSTRAINT fk_tipospedido_detalle FOREIGN KEY (idtipospedido) REFERENCES tipospedido(idtipospedido),
CONSTRAINT fk_sucursal_detalle2 FOREIGN KEY (idsucursal) REFERENCES sucursal(idsucursal)
);
CREATE TABLE categoriaproductos(
	idcategoriaproducto INT NOT NULL AUTO_INCREMENT,
	idsucursal INT NOT NULL,
	descripcioncategoriaproducto VARCHAR(50),
CONSTRAINT pk_tipoproducto PRIMARY KEY (idcategoriaproducto),
CONSTRAINT fk_sucursal_categoriaproductos FOREIGN KEY (idsucursal) REFERENCES sucursal(idsucursal)
);
CREATE TABLE productos(
   idproducto INT NOT NULL AUTO_INCREMENT,
	idcategoriaproducto INT NOT NULL,
	nomproducto VARCHAR(50),
	precio DECIMAL(10.2),
	stock INT,
	CONSTRAINT pk_productos PRIMARY KEY (idproducto),
	CONSTRAINT fk_categoriaproductos_productos FOREIGN KEY (idcategoriaproducto) REFERENCES categoriaproductos(idcategoriaproducto)
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

--Ingreso de categoria de productos

INSERT INTO categoriaproductos (idsucursal,descripcioncategoriaproducto) 
VALUES (1,'Desayuno');
INSERT INTO categoriaproductos (idsucursal,descripcioncategoriaproducto) 
VALUES (1,'Entrada');
INSERT INTO categoriaproductos (idsucursal,descripcioncategoriaproducto) 
VALUES (1,'Menú');
INSERT INTO categoriaproductos (idsucursal,descripcioncategoriaproducto) 
VALUES (1,'Cena');
INSERT INTO categoriaproductos (idsucursal,descripcioncategoriaproducto) 
VALUES (1,'Postres');
INSERT INTO categoriaproductos (idsucursal,descripcioncategoriaproducto) 
VALUES (1,'Guarniciones');
INSERT INTO categoriaproductos (idsucursal,descripcioncategoriaproducto) 
VALUES (1,'Otros');
INSERT INTO categoriaproductos (idsucursal,descripcioncategoriaproducto) 
VALUES (1,'Bebidas');
INSERT INTO categoriaproductos (idsucursal,descripcioncategoriaproducto) 
VALUES (2,'Desayuno');
INSERT INTO categoriaproductos (idsucursal,descripcioncategoriaproducto) 
VALUES (2,'Entrada');
INSERT INTO categoriaproductos (idsucursal,descripcioncategoriaproducto) 
VALUES (2,'Menú');
INSERT INTO categoriaproductos (idsucursal,descripcioncategoriaproducto) 
VALUES (2,'Cena');
INSERT INTO categoriaproductos (idsucursal,descripcioncategoriaproducto) 
VALUES (2,'Postres');
INSERT INTO categoriaproductos (idsucursal,descripcioncategoriaproducto) 
VALUES (2,'Guarniciones');
INSERT INTO categoriaproductos (idsucursal,descripcioncategoriaproducto) 
VALUES (2,'Otros');
INSERT INTO categoriaproductos (idsucursal,descripcioncategoriaproducto) 
VALUES (2,'Bebidas');
INSERT INTO categoriaproductos (idsucursal,descripcioncategoriaproducto) 
VALUES (3,'Desayuno');
INSERT INTO categoriaproductos (idsucursal,descripcioncategoriaproducto) 
VALUES (3,'Entrada');
INSERT INTO categoriaproductos (idsucursal,descripcioncategoriaproducto) 
VALUES (3,'Menú');
INSERT INTO categoriaproductos (idsucursal,descripcioncategoriaproducto) 
VALUES (3,'Cena');
INSERT INTO categoriaproductos (idsucursal,descripcioncategoriaproducto) 
VALUES (3,'Postres');
INSERT INTO categoriaproductos (idsucursal,descripcioncategoriaproducto) 
VALUES (3,'Guarniciones');
INSERT INTO categoriaproductos (idsucursal,descripcioncategoriaproducto) 
VALUES (3,'Otros');
INSERT INTO categoriaproductos (idsucursal,descripcioncategoriaproducto) 
VALUES (3,'Bebidas');
INSERT INTO categoriaproductos (idsucursal,descripcioncategoriaproducto) 
VALUES (4,'Desayuno');
INSERT INTO categoriaproductos (idsucursal,descripcioncategoriaproducto) 
VALUES (4,'Entrada');
INSERT INTO categoriaproductos (idsucursal,descripcioncategoriaproducto) 
VALUES (4,'Menú');
INSERT INTO categoriaproductos (idsucursal,descripcioncategoriaproducto) 
VALUES (4,'Cena');
INSERT INTO categoriaproductos (idsucursal,descripcioncategoriaproducto) 
VALUES (4,'Postres');
INSERT INTO categoriaproductos (idsucursal,descripcioncategoriaproducto) 
VALUES (4,'Guarniciones');
INSERT INTO categoriaproductos (idsucursal,descripcioncategoriaproducto) 
VALUES (4,'Otros');
INSERT INTO categoriaproductos (idsucursal,descripcioncategoriaproducto) 
VALUES (4,'Bebidas');

SELECT*FROM categoriaproductos

--Ingreso de productos
INSERT INTO productos (idcategoriaproducto,nomproducto,precio,stock) 
VALUES (25,'Desayuno Americano',16.0,5);
INSERT INTO productos (idcategoriaproducto,nomproducto,precio,stock) 
VALUES (25,'Desayuno Francés',17.0,2);
INSERT INTO productos (idcategoriaproducto,nomproducto,precio,stock) 
VALUES (25,'Omelette Regional',19.0,10);
INSERT INTO productos (idcategoriaproducto,nomproducto,precio,stock) 
VALUES (25,'Omelette Vegetariano',17.0,7);
INSERT INTO productos (idcategoriaproducto,nomproducto,precio,stock) 
VALUES (25,'Sandwich',6.0,3);

INSERT INTO productos (idcategoriaproducto,nomproducto,precio,stock) 
VALUES (26,'Papa a la Huancaína',16.0,10);
INSERT INTO productos (idcategoriaproducto,nomproducto,precio,stock) 
VALUES (26,'Ensalada mixta',17.0,5);
INSERT INTO productos (idcategoriaproducto,nomproducto,precio,stock) 
VALUES (26,'Ensalada de palta y palmito',22.0,8);
INSERT INTO productos (idcategoriaproducto,nomproducto,precio,stock) 
VALUES (26,'Salpicón de pollo',22.0,6);
INSERT INTO productos (idcategoriaproducto,nomproducto,precio,stock) 
VALUES (26,'Ensalada de atún',22.0,12);

INSERT INTO productos (idcategoriaproducto,nomproducto,precio,stock) 
VALUES (3,'Chupe de camarones',33.0,5);
INSERT INTO productos (idcategoriaproducto,nomproducto,precio,stock) 
VALUES (3,'Sudado de conchas negras',22.0,2);
INSERT INTO productos (idcategoriaproducto,nomproducto,precio,stock) 
VALUES (3,'Ceviche de pescado',25.0,10);
INSERT INTO productos (idcategoriaproducto,nomproducto,precio,stock) 
VALUES (3,'Ceviche de corvina',35.0,7);
INSERT INTO productos (idcategoriaproducto,nomproducto,precio,stock) 
VALUES (3,'Tiradito de pescado',30.0,3);

INSERT INTO productos (idcategoriaproducto,nomproducto,precio,stock) 
VALUES (8,'Inka Cola',8.0,5);
INSERT INTO productos (idcategoriaproducto,nomproducto,precio,stock) 
VALUES (8,'Coca Cola',8.0,2);
INSERT INTO productos (idcategoriaproducto,nomproducto,precio,stock) 
VALUES (8,'1 Litro de Refresco Maiz Morado',7.0,10);
INSERT INTO productos (idcategoriaproducto,nomproducto,precio,stock) 
VALUES (8,'Agua San Luis',3.0,7);
INSERT INTO productos (idcategoriaproducto,nomproducto,precio,stock) 
VALUES (8,'1 Litro de Refresco Cocona',7.0,3);




