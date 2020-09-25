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
   imgbienvenida VARCHAR(150),
   textobienvenida VARCHAR(100),
   imgdestacado1 VARCHAR(150),
	platodestacado1 VARCHAR(100),
	imgdestacado2 VARCHAR(150),
   platodestacado2 VARCHAR(100),
   imgdestacado3 VARCHAR(150),
   platodestacado3 VARCHAR(100),
   horaatencioninicio TIME,
   horaatencioncierre TIME,
   correosucursal VARCHAR(50),
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
	
CREATE TABLE usuario_encargado(
   idusuario_encargado INT NOT NULL AUTO_INCREMENT,
   idsucursal INT NOT NULL,
   emailencargado VARCHAR(50) NOT NULL,
   nombreencargado VARCHAR(50),
   apellidoencargado VARCHAR(50),
   contrasenae VARCHAR(50) NOT NULL,
    CONSTRAINT pk_usuario_encargado PRIMARY KEY (idusuario_encargado),
   CONSTRAINT fk_sucursal_usuario_encargado FOREIGN KEY (idsucursal) REFERENCES sucursal(idsucursal)
);
CREATE TABLE usuario (
    idusuario INT NOT NULL AUTO_INCREMENT,
    idsucursal iNT NOT NULL,
    emailusuario VARCHAR(50),
    nombreusuario VARCHAR(50),
    apellidousuario VARCHAR(50),
    contrasenau VARCHAR(50) NOT NULL,
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
INSERT INTO sucursal (nomsucursal,direcsucursal,telefono,imgbienvenida ,imgbienvenida,imgdestacado1,platodestacado1,imgdestacado2,platodestacado2,imgdestacado3,platodestacado3,horaatencioninicio,horaatencioncierre,correosucursal) 
VALUES ('El Norteño','Santa María 246, Tarapoto','+51 42 522604','img/menu.jpg','Hace varios ayeres, en el Perú cambio el concepto del comer; Este gran cambio se ha convertido en toda una filosofía que permite que muchos restaurantes queden como favoritos de la gente','img/destacado1.jpg','plato1','img/destacado2.jpg','plato2','img/destacado3.jpg','plato3','07:00','21:00','elnorteño@gmail.com');

INSERT INTO sucursal (nomsucursal,direcsucursal,telefono,imgbienvenida,imgbienvenida,imgdestacado1,platodestacado1,imgdestacado2,platodestacado2,imgdestacado3,platodestacado3,horaatencioninicio,horaatencioncierre,correosucursal) 
VALUES ('La Collpa','Av. Circunvalación 202, Tarapoto','+51 42 522644','img/menu.jpg','Hace varios ayeres, en el Perú cambio el concepto del comer; Este gran cambio se ha convertido en toda una filosofía que permite que muchos restaurantes queden como favoritos de la gente','img/destacado1.jpg','plato1','img/destacado2.jpg','plato2','img/destacado3.jpg','plato3','07:00','21:00','lacollpa@gmail.com');

INSERT INTO sucursal (nomsucursal,direcsucursal,telefono,imgbienvenida ,imgbienvenida,imgdestacado1,platodestacado1,imgdestacado2,platodestacado2,imgdestacado3,platodestacado3,horaatencioninicio,horaatencioncierre,correosucursal) 
VALUES ('Doña Zully','Jr. San Pablo de la Cruz 244, Tarapoto','+51 42 530670','img/menu.jpg','Hace varios ayeres, en el Perú cambio el concepto del comer; Este gran cambio se ha convertido en toda una filosofía que permite que muchos restaurantes queden como favoritos de la gente','img/destacado1.jpg','plati1','img/destacado2.jpg','plati2','img/destacado3.jpg','plati3','08:00','20:00','doñazully@gmail.com');

INSERT INTO sucursal (nomsucursal,direcsucursal,telefono,imgbienvenida ,imgbienvenida,imgdestacado1,platodestacado1,imgdestacado2,platodestacado2,imgdestacado3,platodestacado3,horaatencioninicio,horaatencioncierre,correosucursal) 
VALUES ('Chalet Venzia','Jr. Alegría Arias de Morey 293-175, Tarapoto','+51 42 522104','img/menu.jpg','Hace varios ayeres, en el Perú cambio el concepto del comer; Este gran cambio se ha convertido en toda una filosofía que permite que muchos restaurantes queden como favoritos de la gente','img/destacado1.jpg','plaito1','img/destacado2.jpg','platito2','img/destacado3.jpg','platito3','07:00','21:00','chaletvenzia@gmail.com');


-- Consulta
SELECT*FROM sucursal;

-- Ingreso de formas de pago
INSERT INTO formaspago (descripcionformaspago) 
VALUES ('Efectivo');
INSERT INTO formaspago (descripcionformaspago) 
VALUES ('Online');
INSERT INTO formaspago (descripcionformaspago) 
VALUES ('POS');

-- Ingreso de tipos de pedido
INSERT INTO tipospedido (descripciontipospedido) 
VALUES ('Delivery');
INSERT INTO tipospedido (descripciontipospedido) 
VALUES ('Recojo en local');
INSERT INTO tipospedido (descripciontipospedido) 
VALUES ('Reserva');

-- Ingreso de usuarios
INSERT INTO usuario_encargado (idsucursal,emailencargado,nombreencargado,apellidoencargado,contrasenae) 
VALUES (1,'jerryinga12@gmail.com','Jerry Josias','Sobojeda Pinchi','aguantelgtb');
INSERT INTO usuario_encargado (idsucursal,emailencargado,nombreencargado,apellidoencargado,contrasenae) 
VALUES (2,'freddyhidalgo@gmail.com','Freddy Roberto','Culqui Chupingawa','vivaelpubg');
INSERT INTO usuario_encargado (idsucursal,emailencargado,nombreencargado,apellidoencargado,contrasenae) 
VALUES (3,'ariano@gmail.com','Arian','Chuquilin Sanches','vivaellol');
INSERT INTO usuario_encargado (idsucursal,emailencargado,nombreencargado,apellidoencargado,contrasenae) 
VALUES (4,'admin','ElAdmin','Dios Admin','admin');

-- Ingreso de categoria de productos

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

-- Ingreso de productos

-- chalet venzia
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

-- el norteño
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

-- la collpa
INSERT INTO productos (idcategoriaproducto,nomproducto,precio,stock) 
VALUES (12,'Tilapia Frita',30.0,7);
INSERT INTO productos (idcategoriaproducto,nomproducto,precio,stock) 
VALUES (12,'Tacacho con Cecina',25.0,10);
INSERT INTO productos (idcategoriaproducto,nomproducto,precio,stock) 
VALUES (12,'Tacacho con Chorizo',20.0,10);
INSERT INTO productos (idcategoriaproducto,nomproducto,precio,stock) 
VALUES (12,'Avispa Juane',33.0,15);
INSERT INTO productos (idcategoriaproducto,nomproducto,precio,stock) 
VALUES (12,'Inshicapi',25.0,10);

INSERT INTO productos (idcategoriaproducto,nomproducto,precio,stock) 
VALUES (13,'Volcán de Chocolate',10.0,10);
INSERT INTO productos (idcategoriaproducto,nomproducto,precio,stock) 
VALUES (13,'Picarones',5.0,15);
INSERT INTO productos (idcategoriaproducto,nomproducto,precio,stock) 
VALUES (13,'Tarta de Queso',7.0,10);
INSERT INTO productos (idcategoriaproducto,nomproducto,precio,stock) 
VALUES (13,'Brownie',5.0,7);
INSERT INTO productos (idcategoriaproducto,nomproducto,precio,stock) 
VALUES (13,'Surtido de Postres',7.0,3);

-- doña zully
INSERT INTO productos (idcategoriaproducto,nomproducto,precio,stock) 
VALUES (20,'Tilapia Frita',27.0,7);
INSERT INTO productos (idcategoriaproducto,nomproducto,precio,stock) 
VALUES (20,'Tacacho con Cecina',20.0,10);
INSERT INTO productos (idcategoriaproducto,nomproducto,precio,stock) 
VALUES (20,'Tacacho con Chorizo',16.0,10);
INSERT INTO productos (idcategoriaproducto,nomproducto,precio,stock) 
VALUES (20,'Avispa Juane',28.0,15);
INSERT INTO productos (idcategoriaproducto,nomproducto,precio,stock) 
VALUES (20,'Inshicapi',20.0,10);