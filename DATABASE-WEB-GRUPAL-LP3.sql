-- CREATE DATABASE buengustoperuano;

-- USE buengustoperuano;

USE bm12bwjh2ogki5nep1dq;

CREATE TABLE formaspago (
	idformaspago INT NOT NULL AUTO_INCREMENT,
	descripcionformaspago VARCHAR(255),
	CONSTRAINT pk_formaspago PRIMARY KEY (idformaspago)
);

CREATE TABLE tipospedido (
	idtipospedido INT NOT NULL AUTO_INCREMENT,
	descripciontipospedido VARCHAR(255),
	CONSTRAINT pk_tipospedido PRIMARY KEY (idtipospedido)
);

CREATE TABLE sucursal(
   idsucursal INT NOT NULL AUTO_INCREMENT,
   nomsucursal VARCHAR(255),
   direcsucursal VARCHAR(255),
   telefono VARCHAR(20),
   banner VARCHAR(255),
   imgbienvenida VARCHAR(255),
   textobienvenida TEXT,
   imgdestacado1 VARCHAR(255),
   platodestacado1 VARCHAR(255),
   imgdestacado2 VARCHAR(255),
   platodestacado2 VARCHAR(255),
   imgdestacado3 VARCHAR(255),
   platodestacado3 VARCHAR(255),
   horaatencioninicio TIME,
   horaatencioncierre TIME,
   correosucursal VARCHAR(255),
   estado BOOLEAN default 1,
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
	descripcioncategoriaproducto VARCHAR(255),
    estado BOOLEAN default 1,
CONSTRAINT pk_tipoproducto PRIMARY KEY (idcategoriaproducto),
CONSTRAINT fk_sucursal_categoriaproductos FOREIGN KEY (idsucursal) REFERENCES sucursal(idsucursal)
);
CREATE TABLE productos(
   idproducto INT NOT NULL AUTO_INCREMENT,
	idcategoriaproducto INT NOT NULL,
	nomproducto VARCHAR(255),
	precio DECIMAL(10,2),
	stock INT,
    estado BOOLEAN default 1,
    CONSTRAINT pk_productos PRIMARY KEY (idproducto),
    CONSTRAINT fk_categoriaproductos_productos FOREIGN KEY (idcategoriaproducto) REFERENCES categoriaproductos(idcategoriaproducto)
);
	
CREATE TABLE usuario_encargado(
    idusuario_encargado INT NOT NULL AUTO_INCREMENT,
    idsucursal INT NOT NULL,
    emailusuario VARCHAR(255),
    nombreusuario VARCHAR(255),
    apellidousuario VARCHAR(255),
    contrasena VARCHAR(255) NOT NULL,
    telefonousuario NUMERIC,
    direccionusuario VARCHAR(255),
    referenciausuario VARCHAR(255),
    dniusuario VARCHAR(8),
CONSTRAINT pk_usuario_encargado PRIMARY KEY (idusuario_encargado),
CONSTRAINT fk_sucursal_usuario_encargado FOREIGN KEY (idsucursal) REFERENCES sucursal(idsucursal)
);
CREATE TABLE usuario (
    idusuario INT NOT NULL AUTO_INCREMENT,
    emailusuario VARCHAR(255),
    nombreusuario VARCHAR(255),
    apellidousuario VARCHAR(255),
    contrasena VARCHAR(255) NOT NULL,
	telefonousuario NUMERIC,
	direccionusuario VARCHAR(255),
	referenciausuario VARCHAR(255),
	dniusuario VARCHAR(8),
    estado BOOLEAN default 1,
    CONSTRAINT pk_usuario PRIMARY KEY (idusuario)
);

CREATE TABLE pedidos (
	idventa INT NOT NULL AUTO_INCREMENT,
	idformaspago INT NOT NULL,
	idtipospedido INT NOT NULL,
	idusuario INT NOT NUll,
	horapedido DATE,
	estado CHAR(1),
	montopagar VARCHAR(255),
    CONSTRAINT pk_pedidos PRIMARY KEY (idventa),
    CONSTRAINT fk_formaspago_pedidos FOREIGN KEY (idformaspago) REFERENCES formaspago(idformaspago),
    CONSTRAINT fk_tipospedido_pedidos FOREIGN KEY (idtipospedido) REFERENCES tipospedido(idtipospedido),
    CONSTRAINT fk_usuario_pedidos FOREIGN KEY (idusuario) REFERENCES usuario(idusuario)		   
);

CREATE TABLE detallepedido(
   idventa INT NOT NULL,
	idproducto INT NOT NULL,
	idsucursal INT NOT NULL,
CONSTRAINT pk_detallepedido PRIMARY KEY (idventa,idproducto,idsucursal),
CONSTRAINT fk_pedidos_detallepedido FOREIGN KEY (idventa) REFERENCES pedidos(idventa),
CONSTRAINT fk_productos_detallepedido FOREIGN KEY (idproducto) REFERENCES productos(idproducto)
);

-- Ingreso de sucursal
INSERT INTO sucursal (nomsucursal,direcsucursal,telefono,banner,imgbienvenida,textobienvenida, imgdestacado1,platodestacado1,imgdestacado2,platodestacado2,imgdestacado3,platodestacado3,horaatencioninicio,horaatencioncierre,correosucursal) 
VALUES ('El Norteño','Santa María 246, Tarapoto','+51 42 522604','img/bannernorteño.jpg','img/menu.jpg','Hace varios ayeres, en el Perú cambio el concepto del comer; Este gran cambio se ha convertido en toda una filosofía que permite que muchos restaurantes queden como favoritos de la gente.
Esta gran filosofía es; “EL BUEN COMER…” es decir que todos trabajamos con el Mandil bien puesto,  y esto no es sino, mas que el meditado cuidado de todos los detalles”…, porque la intención ha sido siempre tratar a nuestros invitados como tú lo harías en tu propia casa.
Nosotros como empresa gastronómica no podíamos estar ajenos a ello ya que todos los que conformamos Oh…mar, tratamos de personificar esa filosofía valiéndonos de nuestra rica gastronomía, típica y de tradición; admirada y envidiada por muchos, agregándole los ingredientes de calidad del producto, la atención personalizada y el costo proporcionado.
Contamos con un personal especializado en cada una de sus áreas de trabajo, para brindar al cliente fiel una respuesta excelente a la confianza que ha depositado en nosotros, y al nuevo usuario una posibilidad de establecer un lugar con el que se sienta identificado','img/destacado1.jpg','Combinado','img/destacado2.jpg','Ceviche','img/destacado3.jpg','Seco','07:00','21:00','elnorteño@gmail.com');

INSERT INTO sucursal (nomsucursal,direcsucursal,telefono,banner,imgbienvenida,textobienvenida, imgdestacado1,platodestacado1,imgdestacado2,platodestacado2,imgdestacado3,platodestacado3,horaatencioninicio,horaatencioncierre,correosucursal) 
VALUES ('La Collpa','Av. Circunvalación 202, Tarapoto','+51 42 522644','img/bannercollpa.jpg','img/logocollpa.jpg','Cocina rica, hecha con mucha ilusión, para gente que le gusta comer y disfrutar cada bocado de la vida…..
Cinco Sentidos es un lugar íntimo en el que puedes saborear a gusto y conversar de forma relajada. 
Hacemos todo de forma casera y procuramos poner siempre un toque personal en nuestro trabajo diario, por eso somos un restaurante artesanal.
Tenemos una bonita barra para tomar tapas recién hechas, y un salón con siete mesas en el que puedes sentarte a comer tranquilamente. A mediodía es un sitio informal con menú del día, por las noches es una sala de luces bajas y velas en las mesas… Por eso dicen que somos un restaurante con encanto.',
'img/juane.jpg','Juane de Gallina: El Juane​ es uno de los principales platos típicos de la gastronomía de la selva peruana y es muy consumido durante la fiesta de San Juan que se celebra el 24 de junio de cada año en honor a Juan Bautista',
'img/inchicapi.jpg','Inchicapi de Gallina:El inchicapi de gallina es uno de los platos más tradicionales de la selva peruana. Su nombre proviene de los vocablos quechua “Inchik” que significa maní y “api” que quiere decir sopa.',
'img/arrozchaufa.jpg','Arroz Chaufa Regional:Es un plato estilo chifa, una cocina china. Consiste en una mezcla de arroz frito con vegetales, que generalmente incluye cebolletas, huevos y pollo, cocinados rápidamente a fuego alto, a menudo en un wok con salsa de soja y aceite.','07:00','21:00','lacollpa@gmail.com');

INSERT INTO sucursal (nomsucursal,direcsucursal,telefono ,banner,imgbienvenida,textobienvenida, imgdestacado1,platodestacado1,imgdestacado2,platodestacado2,imgdestacado3,platodestacado3,horaatencioninicio,horaatencioncierre,correosucursal) 
VALUES ('Doña Zully','Jr. San Pablo de la Cruz 244, Tarapoto','+51 42 530670','img/bannerzuly.jpg','img/doña.jpg','Modernos en el estilo y clásicos en el sabor.
 Un equipo de profesionales que hemos creado el restaurante donde nos gustaría comer a diario y en las ocasiones especiales. Con menú o a la carta. Con amigos o con clientes, con tiempo para disfrutar o con algo más de prisa porque el trabajo lo requiere.
 Firmes defensores de que calidad no está en el precio, sino en el producto.
 Exigentes porque también somos consumidores y estamos convencidos de que la experiencia debe resultar completa.
 Un buen restaurante ha de serlo por la comida, pero también por el trato y el entorno, por la decoración y el ambiente.
 Somos nuevos, pero también somos expertos. Natural Lunch, nuestro restaurante en La Finca (Pozuelo), nos ha permitido crecer y creer. Sabemos más y queremos demostrarlo',
 'img/sudado.jpg','Sudado de Pescado: El sudado de pescado es una sopa típica de la gastronomía peruana, aunque también se encuentra recogida en las cocinas de otros países latinoamericanos.',
 'img/mixto.jpg','Mixto Regional: Combinacion de varios platillos tradicionales.',
 'img/pescadofrito.jpg','Pescado Frito: Este platillo es altamente nutritivo y de agradable aroma.','08:00','20:00','doñazully@gmail.com');

INSERT INTO sucursal (nomsucursal,direcsucursal,telefono ,banner,imgbienvenida,textobienvenida, imgdestacado1,platodestacado1,imgdestacado2,platodestacado2,imgdestacado3,platodestacado3,horaatencioninicio,horaatencioncierre,correosucursal) 
VALUES ('Chalet Venzia','Jr. Alegría Arias de Morey 293-175, Tarapoto','+51 42 522104','img/bannerchalet.jpg','img/chalet.jpg','La Gastronomía peruana es reconocida a nivel mundial; con más de 250 platos típicos, se ha posicionado como una de las más importantes del planeta.
Sus preparaciones, sabores y  aromas son únicos y datan de añosas recetas. Es en su afán por traspasar estas maravillosas preparaciones que, Jhony oriundo de Perú, pero radicado ya varios años en Curicó, decide abrir en el año 2007, un restaurant  que reúne lo mejor de su cocina.
Fue durante 2017, cuando “Perú Gastronómico” se consolida renovando su carta y su local; actualmente atiende de de lunes a domingo y ofrece servicio de cafetería, menú ejecutivo y a la carta y por cierto, una amplia gama de platos peruanos que día a día fascinan a quienes degustan estas preparaciones.
Es la calidad en los productos utilizados y, por cierto, la destreza de nuestros chefs, la que otorga un producto de la más alta calidad, excelente presentación y exquisito sabor.
El pisco sour, elaborado con la típica receta peruana, es el favorito de muchos, además de los postres hechos en el mismo restaurant.
La invitación es a conocernos y a vivir un verdadero festín al paladar.',
'img/pescado.jpg','Pescado a la Hoja:El misterio en hornear el pescado en hojas de plátanos, viene del secreto para que el pescado no se queme al momento de cocinarse y para que también los sabores se vean resaltados con los sabores de la hoja.',
'img/tacacho.jpg','Tacaho con Cecina:El tacacho con cecina es un plato típico de la gastronomía del Perú popular en la selva peruana​​ y ampliamente difundido en el resto del país.​',
'img/caldo.jpg','Caldo de Gallina:El caldo de pollo es una sopa.​ A menudo se sirve con trozos de carne o con granos de arroz, etc. Se considera también un remedio casero contra los resfríos.','07:00','21:00','chaletvenzia@gmail.com');


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

-- detalles tipo pedido
INSERT INTO detalletipospedido (idtipospedido,idsucursal,disponibilidadtipospedido) 
VALUE (1,1,1);

INSERT INTO detalletipospedido (idtipospedido,idsucursal,disponibilidadtipospedido) 
VALUES (2,1,1);

INSERT INTO detalletipospedido (idtipospedido,idsucursal,disponibilidadtipospedido) 
VALUES (3,1,0);

INSERT INTO detalletipospedido (idtipospedido,idsucursal,disponibilidadtipospedido) 
VALUES (1,2,1);

INSERT INTO detalletipospedido (idtipospedido,idsucursal,disponibilidadtipospedido) 
VALUES (2,2,0);

INSERT INTO detalletipospedido (idtipospedido,idsucursal,disponibilidadtipospedido) 
VALUES (3,2,0);

INSERT INTO detalletipospedido (idtipospedido,idsucursal,disponibilidadtipospedido) 
VALUES (1,3,0);

INSERT INTO detalletipospedido (idtipospedido,idsucursal,disponibilidadtipospedido) 
VALUES (2,3,1);

INSERT INTO detalletipospedido (idtipospedido,idsucursal,disponibilidadtipospedido) 
VALUES (3,3,0);

INSERT INTO detalletipospedido (idtipospedido,idsucursal,disponibilidadtipospedido) 
VALUES (1,4,1);

INSERT INTO detalletipospedido (idtipospedido,idsucursal,disponibilidadtipospedido) 
VALUES (2,4,1);

INSERT INTO detalletipospedido (idtipospedido,idsucursal,disponibilidadtipospedido) 
VALUES (3,4,1);

-- detalle forma de pago

INSERT INTO detalleformaspago (idformaspago ,idsucursal ,disponibilidadformaspago) 
VALUES (1,2,1);

INSERT INTO detalleformaspago (idformaspago ,idsucursal ,disponibilidadformaspago) 
VALUES (2,1,1);

INSERT INTO detalleformaspago (idformaspago ,idsucursal ,disponibilidadformaspago) 
VALUES (3,4,0);

INSERT INTO detalleformaspago (idformaspago ,idsucursal ,disponibilidadformaspago) 
VALUES (2,3,1);

INSERT INTO usuario_encargado (idsucursal, emailusuario, contrasena) VALUE (1, 'prueba.encargado', 'NowPass');
INSERT INTO usuario_encargado (idsucursal, emailusuario, contrasena) VALUE (2, 'harry@gmail.com', 'NowPass1');
INSERT INTO usuario_encargado (idsucursal, emailusuario, contrasena) VALUE (3, 'arian@gmail.com', 'NowPass1');
INSERT INTO usuario_encargado (idsucursal, emailusuario, contrasena) VALUE (4, 'jordi@gmail.com', 'NowPass1');

INSERT INTO usuario (nombreusuario, emailusuario, contrasena) VALUE ('prueba', 'prueba', 'NowPass');
