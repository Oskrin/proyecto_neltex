
CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;
COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';
SET search_path = public, pg_catalog;
SET client_encoding=LATIN1;
CREATE FUNCTION fn_log_audit() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    IF (TG_OP = 'DELETE') THEN
      INSERT INTO tbl_audit ("nombre_tabla", "operacion", "valor_anterior", "valor_nuevo", "fecha_cambio", "usuario")
             VALUES (TG_TABLE_NAME, 'D', OLD, NULL, now(), USER);
      RETURN OLD;
    ELSIF (TG_OP = 'UPDATE') THEN
      INSERT INTO tbl_audit ("nombre_tabla", "operacion", "valor_anterior", "valor_nuevo", "fecha_cambio", "usuario")
             VALUES (TG_TABLE_NAME, 'U', OLD, NEW, now(), USER);
      RETURN NEW;
    ELSIF (TG_OP = 'INSERT') THEN
      INSERT INTO tbl_audit ("nombre_tabla", "operacion", "valor_anterior", "valor_nuevo", "fecha_cambio", "usuario")
             VALUES (TG_TABLE_NAME, 'I', NULL, NEW, now(), USER);
      RETURN NEW;
    END IF;
    RETURN NULL;
END;
$$;
LANGUAGE 'plpgsql' VOLATILE COST 100;
ALTER FUNCTION public.fn_log_audit() OWNER TO postgres;
--
-- Estrutura de la tabla 'c_cobrarexternas'
--

DROP TABLE c_cobrarexternas CASCADE;
CREATE TABLE c_cobrarexternas (
id_c_cobrarexternas int4 NOT NULL,
id_cliente int4,
id_empresa int4,
id_usuario int4,
comprobante text,
fecha_actual text,
hora_actual text,
num_factura text,
tipo_documento text,
total text,
saldo text,
estado text
);

--
-- Creating data for 'c_cobrarexternas'
--



--
-- Creating index for 'c_cobrarexternas'
--

ALTER TABLE ONLY  c_cobrarexternas  ADD CONSTRAINT  c_cobrarexternas_pkey  PRIMARY KEY  (id_c_cobrarexternas);

--
-- Estrutura de la tabla 'c_pagarexternas'
--

DROP TABLE c_pagarexternas CASCADE;
CREATE TABLE c_pagarexternas (
id_c_pagarexternas int4 NOT NULL,
id_proveedor int4,
id_empresa int4,
id_usuario int4,
comprobante text,
fecha_actual text,
hora_actual text,
num_factura text,
tipo_documento text,
total text,
saldo text,
estado text
);

--
-- Creating data for 'c_pagarexternas'
--



--
-- Creating index for 'c_pagarexternas'
--

ALTER TABLE ONLY  c_pagarexternas  ADD CONSTRAINT  c_pagarexternas_pkey  PRIMARY KEY  (id_c_pagarexternas);

--
-- Estrutura de la tabla 'categoria'
--

DROP TABLE categoria CASCADE;
CREATE TABLE categoria (
id_categoria int4 NOT NULL,
nombre_categoria text,
estado text
);

--
-- Creating data for 'categoria'
--

INSERT INTO categoria VALUES ('2','MEDIAS','Activo');
INSERT INTO categoria VALUES ('1','RES','Activo');
INSERT INTO categoria VALUES ('3','TT','Activo');
INSERT INTO categoria VALUES ('4','TTT','Activo');
INSERT INTO categoria VALUES ('5','QQQQ','Activo');
INSERT INTO categoria VALUES ('6',NULL,'Activo');


--
-- Creating index for 'categoria'
--

ALTER TABLE ONLY  categoria  ADD CONSTRAINT  categoria_pkey  PRIMARY KEY  (id_categoria);

--
-- Estrutura de la tabla 'clientes'
--

DROP TABLE clientes CASCADE;
CREATE TABLE clientes (
id_cliente int4 NOT NULL,
tipo_documento text,
identificacion text,
nombres_cli text,
tipo_cliente text,
direccion_cli text,
telefono text,
celular text,
pais text,
ciudad text,
correo text,
credito_cupo text,
notas text,
estado text
);

--
-- Creating data for 'clientes'
--

INSERT INTO clientes VALUES ('1','Cedula','1004358584','OSCAR TROYA','natural','obelisco',NULL,NULL,'ECUADOR','IBARRA',NULL,'0.00',NULL,'Activo','1');


--
-- Creating index for 'clientes'
--

ALTER TABLE ONLY  clientes  ADD CONSTRAINT  clientes_pkey  PRIMARY KEY  (id_cliente);

--
-- Estrutura de la tabla 'color
--

DROP TABLE color CASCADE;
CREATE TABLE color (
id_color int4 NOT NULL,
nombre_color text,
estado text
);

--
-- Creating data for 'color'
--



--
-- Creating index for 'color'
--

ALTER TABLE ONLY  color  ADD CONSTRAINT  color_pkey  PRIMARY KEY  (id_color);

--
-- Estrutura de la tabla  'detalle_devolucion_compra'
--

DROP TABLE detalle_devolucion_compra CASCADE;
CREATE TABLE detalle_devolucion_compra (
id_detalle_devcompra int4 NOT NULL,
id_devolucion_compra int4,
cod_productos int4,
cantidad text,
precio_compra text,
descuento_producto text,
total_compra text,
estado text
);

--
-- Creating data for 'detalle_devolucion_compra'
--



--
-- Creating index for 'detalle_devolucion_compra'
--

ALTER TABLE ONLY  detalle_devolucion_compra  ADD CONSTRAINT  detalle_devolucion_compra_pkey  PRIMARY KEY  (id_detalle_devcompra);

--
-- Estrutura de la tabla 'detalle_devolucion_venta'
--

DROP TABLE detalle_devolucion_venta CASCADE;
CREATE TABLE detalle_devolucion_venta (
id_detalle_deventa int4 NOT NULL,
id_devolucion_venta int4,
cod_productos int4,
cantidad text,
precio_venta text,
descuento_producto text,
total_venta text,
estado text
);

--
-- Creating data for 'detalle_devolucion_venta'
--



--
-- Creating index for 'detalle_devolucion_venta'
--

ALTER TABLE ONLY  detalle_devolucion_venta  ADD CONSTRAINT  detalle_devolucion_venta_pkey  PRIMARY KEY  (id_detalle_deventa);

--
-- Estrutura de la tabla 'detalle_egreso'
--

DROP TABLE detalle_egreso CASCADE;
CREATE TABLE detalle_egreso (
id_detalle_egreso int4 NOT NULL,
id_egresos int4,
cod_productos int4,
cantidad text,
precio_costo text,
descuento text,
total text,
estado text
);

--
-- Creating data for 'detalle_egreso'
--



--
-- Creating index for 'detalle_egreso'
--

ALTER TABLE ONLY  detalle_egreso  ADD CONSTRAINT  detalle_egreso_pkey  PRIMARY KEY  (id_detalle_egreso);

--
-- Estrutura de la tabla 'detalle_factura_compra'
--

DROP TABLE detalle_factura_compra CASCADE;
CREATE TABLE detalle_factura_compra (
id_detalle_compra int4 NOT NULL,
id_factura_compra int4,
cod_productos int4,
cantidad text,
precio_compra text,
descuento_producto text,
total_compra text,
estado text
);

--
-- Creating data for 'detalle_factura_compra'
--

INSERT INTO detalle_factura_compra VALUES ('1','1','1','45','0.80','0','36.00','Activo');


--
-- Creating index for 'detalle_factura_compra'
--

ALTER TABLE ONLY  detalle_factura_compra  ADD CONSTRAINT  detalle_factura_compra_pkey  PRIMARY KEY  (id_detalle_compra);

--
-- Estrutura de la tabla 'detalle_factura_venta'
--

DROP TABLE detalle_factura_venta CASCADE;
CREATE TABLE detalle_factura_venta (
id_detalle_venta int4 NOT NULL,
id_factura_venta int4,
cod_productos int4,
cantidad text,
precio_venta text,
descuento_producto text,
total_venta text,
estado text,
pendientes text
);

--
-- Creating data for 'detalle_factura_venta'
--

INSERT INTO detalle_factura_venta VALUES ('1','1','3','3','1.50','0','4.50','Activo','0');


--
-- Creating index for 'detalle_factura_venta'
--

ALTER TABLE ONLY  detalle_factura_venta  ADD CONSTRAINT  detalle_factura_venta_pkey  PRIMARY KEY  (id_detalle_venta);

--
-- Estrutura de la tabla 'detalle_ingreso'
--

DROP TABLE detalle_ingreso CASCADE;
CREATE TABLE detalle_ingreso (
id_detalle_ingreso int4 NOT NULL,
id_ingresos int4,
cod_productos int4,
cantidad text,
precio_costo text,
descuento text,
total text,
estado text
);

--
-- Creating data for 'detalle_ingreso'
--



--
-- Creating index for 'detalle_ingreso'
--

ALTER TABLE ONLY  detalle_ingreso  ADD CONSTRAINT  detalle_ingreso_pkey  PRIMARY KEY  (id_detalle_ingreso);

--
-- Estrutura de la tabla 'detalle_inventario'
--

DROP TABLE detalle_inventario CASCADE;
CREATE TABLE detalle_inventario (
id_detalle_inventario int4 NOT NULL,
id_inventario int4,
cod_productos int4,
p_costo text,
p_venta text,
disponibles text,
existencia text,
diferencia text,
estado text
);

--
-- Creating data for 'detalle_inventario'
--



--
-- Creating index for 'detalle_inventario'
--

ALTER TABLE ONLY  detalle_inventario  ADD CONSTRAINT  detalle_inventario_pkey  PRIMARY KEY  (id_detalle_inventario);

--
-- Estrutura de la tabla ' detalle_pagos_venta'
--

DROP TABLE  detalle_pagos_venta CASCADE;
CREATE TABLE  detalle_pagos_venta (
id_detalle_pagos_venta int4 NOT NULL,
id_pagos_venta int4,
fecha_pago text,
cuota text,
saldo text,
estado text
);

--
-- Creating data for ' detalle_pagos_venta'
--

INSERT INTO  detalle_pagos_venta VALUES ('1','1','2015-02-12','7.00','7.00','Activo');
INSERT INTO  detalle_pagos_venta VALUES ('2','1','2015-03-12','7.00','7.00','Activo');
INSERT INTO  detalle_pagos_venta VALUES ('3','1','2015-04-12','7.00','7.00','Activo');
INSERT INTO  detalle_pagos_venta VALUES ('4','2','2015-03-24','1.00','1.00','Activo');
INSERT INTO  detalle_pagos_venta VALUES ('5','2','2015-04-24','1.00','1.00','Activo');
INSERT INTO  detalle_pagos_venta VALUES ('6','2','2015-05-24','1.00','1.00','Activo');

--
-- Estrutura de la tabla 'detalle_proforma'
--

DROP TABLE detalle_proforma CASCADE;
CREATE TABLE detalle_proforma (
id_detalle_proforma int4 NOT NULL,
id_proforma int4,
cod_productos int4,
cantidad text,
precio_venta text,
descuento_venta text,
total_venta text,
estado text
);

--
-- Creating data for 'detalle_proforma'
--



--
-- Creating index for 'detalle_proforma'
--

ALTER TABLE ONLY  detalle_proforma  ADD CONSTRAINT  detalle_proforma_pkey  PRIMARY KEY  (id_detalle_proforma);

--
-- Estrutura de la tabla 'detalles_ordenes'
--

DROP TABLE detalles_ordenes CASCADE;
CREATE TABLE detalles_ordenes (
id_detalles_ordenes int4 NOT NULL,
id_ordenes int4,
cod_productos int4,
cantidad text,
precio_costo text,
total_costo text,
estado text
);

--
-- Creating data for 'detalles_ordenes'
--



--
-- Creating index for 'detalles_ordenes'
--

ALTER TABLE ONLY  detalles_ordenes  ADD CONSTRAINT  detalles_ordenes_pkey  PRIMARY KEY  (id_detalles_ordenes);

--
-- Estrutura de la tabla 'detalles_pagos_internos'
--

DROP TABLE detalles_pagos_internos CASCADE;
CREATE TABLE detalles_pagos_internos (
id_detalles_pagos_interna int4 NOT NULL,
id_cuentas_cobrar int4,
fecha_pago_actual text,
total_pagos text,
saldo text,
estado text
);

--
-- Creating data for 'detalles_pagos_internos'
--



--
-- Creating index for 'detalles_pagos_internos'
--

ALTER TABLE ONLY  detalles_pagos_internos  ADD CONSTRAINT  id_detalles_pagos_internos_pkey  PRIMARY KEY  (id_detalles_pagos_interna);

--
-- Estrutura de la tabla 'detalles_trabajo'
--

DROP TABLE detalles_trabajo CASCADE;
CREATE TABLE detalles_trabajo (
id_detalle int4 NOT NULL,
nombre_detalle text,
valor_detalle text,
id_trabajotecnico int4,
codigo text,
cantidad text,
tipo text
);

--
-- Creating data for 'detalles_trabajo'
--


--
-- Estrutura de la tabla 'devolucion_compra'
--

DROP TABLE devolucion_compra CASCADE;
CREATE TABLE devolucion_compra (
id_devolucion_compra int4 NOT NULL,
id_empresa int4,
id_proveedor int4,
id_usuario int4,
comprobante text,
fecha_actual text,
hora_actual text,
tipo_comprobante text,
num_serie text,
num_autorizacion text,
tarifa0 text,
tarifa12 text,
iva_compra text,
descuento_compra text,
total_compra text,
observaciones text,
estado text
);

--
-- Creating data for 'devolucion_compra'
--



--
-- Creating index for 'devolucion_compra'
--

ALTER TABLE ONLY  devolucion_compra  ADD CONSTRAINT  devolucion_compra_pkey  PRIMARY KEY  (id_devolucion_compra);

--
-- Estrutura de la tabla 'devolucion_venta'
--

DROP TABLE devolucion_venta CASCADE;
CREATE TABLE devolucion_venta (
id_devolucion_venta int4 NOT NULL,
id_empresa int4,
id_cliente int4,
id_usuario int4,
comprobante text,
fecha_actual text,
hora_actual text,
tipo_comprobante text,
num_serie text,
tarifa0 text,
tarifa12 text,
iva_venta text,
descuento_venta text,
total_venta text,
observaciones text,
estado text
);

--
-- Creating data for 'devolucion_venta'
--



--
-- Creating index for 'devolucion_venta'
--

ALTER TABLE ONLY  devolucion_venta  ADD CONSTRAINT  devolucion_venta_pkey  PRIMARY KEY  (id_devolucion_venta);

--
-- Estrutura de la tabla 'egresos'
--

DROP TABLE egresos CASCADE;
CREATE TABLE egresos (
id_egresos  int4 NOT NULL,
id_empresa int4,
id_usuario int4,
comprobante text,
fecha_actual text,
hora_actual text,
origen text,
destino text,
tarifa0 text,
tarifa12 text,
iva_egreso text,
descuento_egreso text,
total_egreso text,
observaciones text,
estado text
);

--
-- Creating data for 'egresos'
--



--
-- Creating index for 'egresos'
--

ALTER TABLE ONLY  egresos  ADD CONSTRAINT  egresos_pkey  PRIMARY KEY  (id_egresos);

--
-- Estrutura de la tabla 'empresa'
--

DROP TABLE empresa CASCADE;
CREATE TABLE empresa (
id_empresa int4 NOT NULL,
nombre_empresa text,
ruc_empresa text,
direccion_empresa text,
telefono_empresa text,
celular_empresa text,
fax_empresa text,
email_empresa text,
pagina_web text,
estado text
);

--
-- Creating data for 'empresa'
--

INSERT INTO empresa VALUES ('1','NELTEX','9999999999999','Comunidad huascara via parque el cóndor Simón Bolívar ','0620635022','0997179084','ECUADOR','OTAVALO',NULL,NULL,NULL,'FABRICA DE MEDIAS DE ALTA CALIDAD','Nelson Castañeda',NULL,'Activo');


--
-- Creating index for 'empresa'
--

ALTER TABLE ONLY  empresa  ADD CONSTRAINT  empresa_pkey  PRIMARY KEY  (id_empresa);

--
-- Estrutura de la tabla 'factura_compra'
--

DROP TABLE factura_compra CASCADE;
CREATE TABLE factura_compra (
id_factura_compra int4 NOT NULL,
id_empresa int4,
id_proveedor int4,
id_usuario int4,
comprobante text,
fecha_actual text,
hora_actual text,
fecha_registro text,
fecha_emision text,
fecha_caducidad text,
tipo_comprobante text,
num_serie text,
num_autorizacion text,
fecha_cancelacion text,
forma_pago text,
tarifa0 text,
tarifa12 text,
iva_compra text,
descuento_compra text,
total_compra text,
estado text
);

--
-- Creating data for 'factura_compra'
--

INSERT INTO factura_compra VALUES ('1','1','1','1','1','2015-02-27','10:39:53 AM','2015-02-27','2015-02-27','2015-02-27','Factura','001-001-000004335','4353','2015-02-27','Contado','0.00','36.00','4.32','0.00','40.32','Activo');


--
-- Creating index for 'factura_compra'
--

ALTER TABLE ONLY  factura_compra  ADD CONSTRAINT  factura_compra_pkey  PRIMARY KEY  (id_factura_compra);

--
-- Estrutura de la tabla 'factura_venta'
--

DROP TABLE factura_venta CASCADE;
CREATE TABLE factura_venta (
id_factura_venta int4 NOT NULL,
id_empresa int4,
id_cliente int4,
id_usuario int4,
comprobante text,
num_factura text,
fecha_actual text,
hora_actual text,
fecha_cancelacion text,
tipo_precio text,
forma_pago text,
num_autorizacion text,
fecha_autorizacion text,
fecha_caducidad text,
tarifa0 text,
tarifa12 text,
iva_venta text,
descuento_venta text,
total_venta text,
estado text,
fecha_anulacion text
);

--
-- Creating data for 'factura_venta'
--

INSERT INTO factura_venta VALUES ('1','1','1','1','1','001-001-000000001','2015-02-27','10:40:33 AM','2015-02-27','MINORISTA','Contado',NULL,'2015-02-27','2015-02-27','0.00','4.018','0.482','0.00','4.50','Activo',NULL);


--
-- Creating index for 'factura_venta'
--

ALTER TABLE ONLY  factura_venta  ADD CONSTRAINT  factura_venta_pkey  PRIMARY KEY  (id_factura_venta);

--
-- Estrutura de la tabla 'gastos'
--

DROP TABLE gastos CASCADE;
CREATE TABLE gastos (
id_gastos int4 NOT NULL,
id_usuario int4,
id_factura_venta int4,
comprobante text,
fecha_actual text,
hora_actual text,
descripcion text,
valor text,
saldo text,
acumulado text,
estado text
);

--
-- Creating data for 'gastos'
--

INSERT INTO gastos VALUES ('1','1','1','1','2015-03-06','6:06:28 PM','ew','1.00','3.50','1.00','Activo');


--
-- Creating index for 'gastos'
--

ALTER TABLE ONLY  gastos  ADD CONSTRAINT  gastos_pkey  PRIMARY KEY  (id_gastos);

--
-- Estrutura de la tabla 'gastos_internos'
--

DROP TABLE gastos_internos CASCADE;
CREATE TABLE gastos_internos (
id_gastos int4 NOT NULL,
id_usuario int4,
id_proveedor int4,
comprobante text,
fecha_actual text,
hora_actual text,
num_factura text,
descripcion text,
total text,
estado text
);

--
-- Creating data for 'gastos_internos'
--



--
-- Creating index for 'gastos_internos'
--

ALTER TABLE ONLY  gastos_internos  ADD CONSTRAINT  gastos_internos_pkey  PRIMARY KEY  (id_gastos);

--
-- Estrutura de la tabla 'ingresos'
--

DROP TABLE ingresos CASCADE;
CREATE TABLE ingresos (
id_ingresos int4 NOT NULL,
id_empresa int4,
id_usuario int4,
comprobante text,
fecha_actual text,
hora_actual text,
origen text,
destino text,
tarifa0 text,
tarifa12 text,
iva_ingreso text,
descuento_ingreso text,
total_ingreso text,
observaciones text,
estado text
);

--
-- Creating data for 'ingresos'
--



--
-- Creating index for 'ingresos'
--

ALTER TABLE ONLY  ingresos  ADD CONSTRAINT  ingresos_pkey  PRIMARY KEY  (id_ingresos);

--
-- Estrutura de la tabla 'inventario'
--

DROP TABLE inventario CASCADE;
CREATE TABLE inventario (
id_inventario int4 NOT NULL,
id_usuario int4,
id_empresa int4,
comprobante text,
fecha_actual text,
hora_actual text,
estado text
);

--
-- Creating data for 'inventario'
--

INSERT INTO inventario VALUES ('1','1','1','1',NULL,'3:28:59 PM','Activo');


--
-- Creating index for 'inventario'
--

ALTER TABLE ONLY  inventario  ADD CONSTRAINT  inventario_pkey  PRIMARY KEY  (id_inventario);

--
-- Estrutura de la tabla 'kardex'
--

DROP TABLE kardex CASCADE;
CREATE TABLE kardex (
id_kardex int4 NOT NULL,
fecha_kardex text,
detalle text,
cantidad_c text,
valor_unitario_c text,
total_c text,
cantidad_v text,
valor_unitario_v text,
total_v  text,
cod_productos  int4,
transaccion  text,
estado text
);

--
-- Creating data for 'kardex'
--

INSERT INTO kardex VALUES ('1','2015-02-24','Factura Compra:001-001-000000001','2','0.80','1.60','1','Activo','1');
INSERT INTO kardex VALUES ('3','2015-02-24','Factura Venta:001-001-000000001','1','1.50','1.50','3','Activo','2');
INSERT INTO kardex VALUES ('2','2015-02-24','Factura Compra:001-001-000000002','3','0.80','2.40','2','Activo','1');
INSERT INTO kardex VALUES ('4','2015-02-24','Factura Venta:001-001-000000002','2','1.50','3.00','2','Activo','2');
INSERT INTO kardex VALUES ('5','2015-02-26','Factura Venta:001-001-000000003','1','1.50','1.50','4','Activo','2');
INSERT INTO kardex VALUES ('6','2015-02-26','Factura Venta:001-001-000000004','1','1.50','1.50','1','Activo','2');
INSERT INTO kardex VALUES ('7','2015-02-26','Factura Venta:001-001-000000005','1','1.50','1.50','3','Activo','2');
INSERT INTO kardex VALUES ('8','2015-02-26','Factura Venta:001-001-000000006','3','1.50','4.50','4','Activo','2');
INSERT INTO kardex VALUES ('9','2015-02-26','Factura Venta:001-001-000000007','2','1.50','3.00','2','Activo','2');
INSERT INTO kardex VALUES ('10','2015-02-27','Factura Compra:001-001-000001234','1','0.80','0.80','3','Activo','1');
INSERT INTO kardex VALUES ('11','2015-02-27','Factura Compra:001-213-000000234','1','0.80','0.80','1','Activo','1');
INSERT INTO kardex VALUES ('12','2015-02-27','Factura Compra:001-001-000000213','2','0.80','1.60','3','Activo','1');
INSERT INTO kardex VALUES ('13','2015-02-27','Factura Compra:001-001-000004335','45','0.80','36.00','1','Activo','1');
INSERT INTO kardex VALUES ('14','2015-02-27','Factura Venta:001-001-000000001','3','1.50','4.50','3','Activo','2');


--
-- Creating index for 'kardex'
--

ALTER TABLE ONLY  kardex  ADD CONSTRAINT  kardex_pkey  PRIMARY KEY  (id_kardex);

--
-- Estrutura de la tabla 'kardex_valorizado'
--

DROP TABLE kardex_valorizado CASCADE;
CREATE TABLE kardex_valorizado (
id_kardex int4 NOT NULL,
cod_productos int4,
fecha_transaccion text,
concepto text,
entrada text,
salida text,
existencia text,
costo_unitario text,
costo_promedio text,
debe text,
haber text,
saldo text,
estado text
);

--
-- Creating data for 'kardex_valorizado'
--



--
-- Creating index for 'kardex_valorizado'
--

ALTER TABLE ONLY  kardex_valorizado  ADD CONSTRAINT  kardex_valorizado_pkey  PRIMARY KEY  (id_kardex);

--
-- Estrutura de la tabla 'marcas'
--

DROP TABLE marcas CASCADE;
CREATE TABLE marcas (
id_marca int4 NOT NULL,
nombre_marca text,
estado text
);

--
-- Creating data for 'marcas'
--

INSERT INTO marcas VALUES ('1','POLO','Activo');
INSERT INTO marcas VALUES ('2','ADIDAS','Activo');
INSERT INTO marcas VALUES ('3','TTTT','Activo');


--
-- Creating index for 'marcas'
--

ALTER TABLE ONLY  marcas  ADD CONSTRAINT  marcas_pkey  PRIMARY KEY  (id_marca);

--
-- Estrutura de la tabla 'ordenes_produccion'
--

DROP TABLE ordenes_produccion CASCADE;
CREATE TABLE ordenes_produccion (
id_ordenes int4 NOT NULL,
id_usuario int4,
comprobante text,
fecha_actual text,
hora_actual text,
cod_productos int4,
cantidad text,
sub_total text,
 estado text
);

--
-- Creating data for 'ordenes_produccion'
--



--
-- Creating index for 'ordenes_produccion'
--

ALTER TABLE ONLY  ordenes_produccion  ADD CONSTRAINT  ordenes_produccion_pkey  PRIMARY KEY  (id_ordenes);

--
-- Estrutura de la tabla 'pagos_cobrar'
--

DROP TABLE pagos_cobrar CASCADE;
CREATE TABLE pagos_cobrar (
id_cuentas_cobrar int4 NOT NULL,
id_cliente int4,
id_usuario int4,
comprobante text,
fecha_actual text,
hora_actual text,
forma_pago text,
tipo_pago text,
num_factura text,
tipo_factura text,
fecha_factura text,
total_factura text,
valor_pagado text,
saldo_factura text,
observaciones text,
 estado text
);

--
-- Creating data for 'pagos_cobrar'
--



--
-- Creating index for 'pagos_cobrar'
--

ALTER TABLE ONLY  pagos_cobrar  ADD CONSTRAINT  pagos_cobrar_externa_pkey  PRIMARY KEY  (id_cuentas_cobrar);

--
-- Estrutura de la tabla 'pagos_compra'
--

DROP TABLE pagos_compra CASCADE;
CREATE TABLE pagos_compra (
id_pagos_compra int4 NOT NULL,
id_proveedor int4,
id_factura_compra int4,
id_usuario int4,
fecha_credito text,
adelanto text,
meses text,
tipo_documento text,
monto_credito text,
saldo text,
 estado text
);

--
-- Creating data for 'pagos_compra'
--



--
-- Creating index for 'pagos_compra'
--

ALTER TABLE ONLY  pagos_compra  ADD CONSTRAINT  pagos_compra_pkey  PRIMARY KEY  (id_pagos_compra);

--
-- Estrutura de la tabla 'pagos_pagar'
--

DROP TABLE pagos_pagar CASCADE;
CREATE TABLE pagos_pagar (
id_cuentas_pagar int4 NOT NULL,
id_proveedor int4,
id_usuario int4,
comprobante text,
fecha_actual text,
hora_actual text,
forma_pago text,
tipo_pago text,
num_factura text,
tipo_factura text,
fecha_factura text,
total_factura text,
valor_pagado text,
saldo_factura text,
observaciones text,
 estado text
);

--
-- Creating data for 'pagos_pagar'
--



--
-- Creating index for 'pagos_pagar'
--

ALTER TABLE ONLY  pagos_pagar  ADD CONSTRAINT  pagos_pagar_pkey  PRIMARY KEY  (id_cuentas_pagar);

--
-- Estrutura de la tabla 'pagos_venta'
--

DROP TABLE pagos_venta CASCADE;
CREATE TABLE pagos_venta (
id_pagos_venta int4 NOT NULL,
id_cliente int4,
id_factura_venta int4,
id_usuario int4,
fecha_credito text,
adelanto text,
meses text,
tipo_documento text,
monto_credito text,
saldo text,
 estado text
);

--
-- Creating data for 'pagos_venta'
--

INSERT INTO pagos_venta VALUES ('1','1','1','1','2015-01-12','0','3','Factura','21.00','21.00','Activo');
INSERT INTO pagos_venta VALUES ('2','1','2','1','2015-02-24','0','3','Factura','3.00','3.00','Activo');


--
-- Creating index for 'pagos_venta'
--

ALTER TABLE ONLY  pagos_venta  ADD CONSTRAINT  pagos_venta_pkey  PRIMARY KEY  (id_pagos_venta);

--
-- Estrutura de la tabla 'parametros'
--

DROP TABLE parametros CASCADE;
CREATE TABLE parametros (
id_parametro int4 NOT NULL,
nombre_empresa text,
ruc_empresa text,
telefono_empresa text,
direccion_empresa text,
 propietario text
);

--
-- Creating data for 'parametros'
--


--
-- Estrutura de la tabla 'productos'
--

DROP TABLE productos CASCADE;
CREATE TABLE productos (
cod_productos int4 NOT NULL,
codigo text,
cod_barras text,
articulo text,
iva text,
series text,
precio_compra text,
utilidad_minorista text,
utilidad_mayorista text,
iva_minorista text,
iva_mayorista text,
categoria text,
marca text,
stock text,
stock_minimo text,
stock_maximo text,
fecha_creacion text,
caracteristicas text,
observaciones text,
descuento text,
estado text,
inventariable text,
existencia text,
 diferencia text
);

--
-- Creating data for 'productos'
--

INSERT INTO productos VALUES ('1','1212-3','12','MEDIAS ROJAS','Si','No','0.80',NULL,NULL,'1.50','1.40','MEDIAS','ADIDAS','57','1','1','2014-12-30',NULL,NULL,'0','Activo','Si','0','0','1.png',NULL);
INSERT INTO productos VALUES ('3','1212-1',NULL,'MEDIAS BLANCAS','Si','No','0.80',NULL,NULL,'1.50','1.40',NULL,NULL,'1','1','1000','30-12-2014',NULL,NULL,'0','Activo','Si','0','0','3.png',NULL);
INSERT INTO productos VALUES ('4','1212-2',NULL,'MEDIAS AMARILLAS','Si','No','0.80',NULL,NULL,'1.50','1.40',NULL,NULL,'6','1','1000','30-12-2014',NULL,NULL,'0','Activo','Si','0','0','4.png',NULL);
INSERT INTO productos VALUES ('2','1212-0',NULL,'MEDIAS AZULEZ','Si','No','0.80',NULL,NULL,'1.50','1.40',NULL,NULL,'2','1','1000','30-12-2014',NULL,NULL,'0','Activo','Si','0','0','2.png',NULL);
INSERT INTO productos VALUES ('5','r',NULL,'RET','Si','No','67.00',NULL,NULL,'6.00','7.00',NULL,NULL,'0','1','1','2015-03-12',NULL,NULL,'0','Activo','Si','0','0','5.jpg','1');


--
-- Creating index for 'productos'
--

ALTER TABLE ONLY  productos  ADD CONSTRAINT  productos_pkey  PRIMARY KEY  (cod_productos);

--
-- Estrutura de la tabla 'proforma'
--

DROP TABLE proforma CASCADE;
CREATE TABLE proforma (
id_proforma int4 NOT NULL,
id_cliente int4,
id_usuario int4,
id_empresa int4,
comprobante text,
fecha_actual text,
hora_actual text,
tipo_precio text,
tarifa0 text,
tarifa12 text,
iva_proforma text,
descuento_proforma text,
total_proforma text,
observaciones text,
 estado text
);

--
-- Creating data for 'proforma'
--



--
-- Creating index for 'proforma'
--

ALTER TABLE ONLY  proforma  ADD CONSTRAINT  proforma_pkey  PRIMARY KEY  (id_proforma);

--
-- Estrutura de la tabla 'proveedores'
--

DROP TABLE proveedores CASCADE;
CREATE TABLE proveedores (
id_proveedor int4 NOT NULL,
tipo_documento text,
identificacion_pro text,
empresa_pro text,
representante_legal text,
visitador text,
direccion_pro text,
telefono text,
celular text,
fax text,
pais text,
ciudad text,
forma_pago text,
correo text,
principal text,
observaciones text,
 estado text
);

--
-- Creating data for 'proveedores'
--

INSERT INTO proveedores VALUES ('1','Cedula','1004358584','LANA Y MODA','YO',NULL,'Miguel Egas','0629234566',NULL,NULL,'ECUADOR','IBARRA','Contado','lana@gmail.com','Si',NULL,'Activo',NULL);


--
-- Creating index for 'proveedores'
--

ALTER TABLE ONLY  proveedores  ADD CONSTRAINT  proveedores_pkey  PRIMARY KEY  (id_proveedor);

--
-- Estrutura de la tabla 'registro_equipo'
--

DROP TABLE registro_equipo CASCADE;
CREATE TABLE registro_equipo (
id_registro int4 NOT NULL,
id_color int4,
id_marca int4,
id_cliente int4,
nro_serie text,
observaciones text,
detalles text,
estado text,
id_usuario int4,
fecha_ingreso text,
id_categoria int4,
modelo text,
fecha_salida text,
descuento text,
 tecnico text
);

--
-- Creating data for 'registro_equipo'
--


--
-- Estrutura de la tabla 'seguridad'
--

DROP TABLE seguridad CASCADE;
CREATE TABLE seguridad (
id_seguridad int4 NOT NULL,
clave text,
 estado text
);

--
-- Creating data for 'seguridad'
--

INSERT INTO seguridad VALUES ('1','123','Activo');


--
-- Creating index for 'seguridad'
--

ALTER TABLE ONLY  seguridad  ADD CONSTRAINT  seguridad_pkey  PRIMARY KEY  (id_seguridad);

--
-- Estrutura de la tabla 'serie_venta'
--

DROP TABLE serie_venta CASCADE;
CREATE TABLE serie_venta (
id_serie_venta int4 NOT NULL,
cod_productos int4,
id_factura_venta int4,
serie text,
observacion text,
 estado text
);

--
-- Creating data for 'serie_venta'
--



--
-- Creating index for 'serie_venta'
--

ALTER TABLE ONLY  serie_venta  ADD CONSTRAINT  serie_venta_pkey  PRIMARY KEY  (id_serie_venta);

--
-- Estrutura de la tabla 'series_compra'
--

DROP TABLE series_compra CASCADE;
CREATE TABLE series_compra (
id_serie int4 NOT NULL,
cod_productos int4,
id_factura_compra int4,
serie text,
observacion text,
 estado text
);

--
-- Creating data for 'series_compra'
--



--
-- Creating index for 'series_compra'
--

ALTER TABLE ONLY  series_compra  ADD CONSTRAINT  series_pkey  PRIMARY KEY  (id_serie);

--
-- Estrutura de la tabla '"tipoProducto"'
--

DROP TABLE "tipoProducto" CASCADE;
CREATE TABLE "tipoProducto" (
"id_tipoProducto" int4 NOT NULL,
"nombreTipo" text,
 estado text
);

--
-- Creating data for '"tipoProducto"'
--


--
-- Estrutura de la tabla 'trabajo'
--

DROP TABLE trabajo CASCADE;
CREATE TABLE trabajo (
id_trabajo int4 NOT NULL,
nombre_trabajo text,
precio_trabajo text,
 estado text
);

--
-- Creating data for 'trabajo'
--


--
-- Estrutura de la tabla 'trabajo_tecnico'
--

DROP TABLE trabajo_tecnico CASCADE;
CREATE TABLE trabajo_tecnico (
id_trabajotecnico int4 NOT NULL,
id_tecnico int4,
id_registro int4,
total_reparaciones text,
 detalles text
);

--
-- Creating data for 'trabajo_tecnico'
--


--
-- Estrutura de la tabla 'usuario'
--

DROP TABLE usuario CASCADE;
CREATE TABLE usuario (
id_usuario int4 NOT NULL,
nombre_usuario text,
apellido_usuario text,
ci_usuario text,
telefono_usuario text,
celular_usuario text,
cargo_usuario text,
clave text,
email_usuario text,
direccion_usuario text,
 usuario text
);

--
-- Creating data for 'usuario'
--

INSERT INTO usuario VALUES ('1','Admin','Admin','9999999999','062922670','0989912241','1','21232f297a57a5a743894a0e4a801fc3',NULL,'Otavalo','Admin','Activo');
INSERT INTO usuario VALUES ('2','OSCAR','TROYA','1004358584','','0989475676','2','81dc9bdb52d04dc20036dbd8313ed055','','','oskr','Activo');


--
-- Creating index for 'usuario'
--

ALTER TABLE ONLY  usuario  ADD CONSTRAINT  usuario_pkey  PRIMARY KEY  (id_usuario);

--
-- Estrutura de la tabla 'tbl_audit'
--

DROP TABLE tbl_audit CASCADE;
CREATE SEQUENCE tbl_audit_pk_audit_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
CREATE TABLE tbl_audit (
pk_audit int4 NOT NULL DEFAULT nextval('tbl_audit_pk_audit_seq'::regclass) ,
nombre_tabla text NOT NULL,
operacion character(1) NOT NULL,
valor_anterior text,
valor_nuevo text,
fecha_cambio timestamp NOT NULL,
usuario text NOT NULL
);

--
-- Creating data for 'tbl_audit'
--


CREATE TRIGGER c_cobrarexternas_tg_audit AFTER INSERT OR UPDATE OR DELETE ON c_cobrarexternas FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER c_pagarexternas_tg_audit AFTER INSERT OR UPDATE OR DELETE ON c_pagarexternas FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER categoria_tg_audit AFTER INSERT OR UPDATE OR DELETE ON categoria FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER clientes_tg_audit AFTER INSERT OR UPDATE OR DELETE ON clientes FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER color_tg_audit AFTER INSERT OR UPDATE OR DELETE ON color FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER detalle_devolucion_compra_tg_audit AFTER INSERT OR UPDATE OR DELETE ON detalle_devolucion_compra FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER detalle_devolucion_venta_tg_audit AFTER INSERT OR UPDATE OR DELETE ON detalle_devolucion_venta FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER detalle_egreso_tg_audit AFTER INSERT OR UPDATE OR DELETE ON detalle_egreso FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER detalle_factura_compra_tg_audit AFTER INSERT OR UPDATE OR DELETE ON detalle_factura_compra FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER detalle_factura_venta_tg_audit AFTER INSERT OR UPDATE OR DELETE ON detalle_factura_venta FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER detalle_ingreso_tg_audit AFTER INSERT OR UPDATE OR DELETE ON detalle_ingreso FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER detalle_inventario_tg_audit AFTER INSERT OR UPDATE OR DELETE ON detalle_inventario FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER detalle_pagos_venta_tg_audit AFTER INSERT OR UPDATE OR DELETE ON detalle_pagos_venta FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER detalle_proforma_tg_audit AFTER INSERT OR UPDATE OR DELETE ON detalle_proforma FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER detalles_ordenes_tg_audit AFTER INSERT OR UPDATE OR DELETE ON detalles_ordenes FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER detalles_pagos_internos_tg_audit AFTER INSERT OR UPDATE OR DELETE ON detalles_pagos_internos FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER detalles_trabajo_tg_audit AFTER INSERT OR UPDATE OR DELETE ON detalles_trabajo FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER devolucion_compra_tg_audit AFTER INSERT OR UPDATE OR DELETE ON devolucion_compra FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER devolucion_venta_tg_audit AFTER INSERT OR UPDATE OR DELETE ON devolucion_venta FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER egresos_tg_audit AFTER INSERT OR UPDATE OR DELETE ON egresos FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER empresa_tg_audit AFTER INSERT OR UPDATE OR DELETE ON empresa FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER factura_compra_tg_audit AFTER INSERT OR UPDATE OR DELETE ON factura_compra FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER factura_venta_tg_audit AFTER INSERT OR UPDATE OR DELETE ON factura_venta FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER gastos_tg_audit AFTER INSERT OR UPDATE OR DELETE ON gastos FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER gastos_internos_tg_audit AFTER INSERT OR UPDATE OR DELETE ON gastos_internos FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER ingresos_tg_audit AFTER INSERT OR UPDATE OR DELETE ON ingresos FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER inventario_tg_audit AFTER INSERT OR UPDATE OR DELETE ON inventario FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER kardex_tg_audit AFTER INSERT OR UPDATE OR DELETE ON kardex FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER kardex_valorizado_tg_audit AFTER INSERT OR UPDATE OR DELETE ON kardex_valorizado FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER marcas_tg_audit AFTER INSERT OR UPDATE OR DELETE ON marcas FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER ordenes_produccion_tg_audit AFTER INSERT OR UPDATE OR DELETE ON ordenes_produccion FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER pagos_cobrar_tg_audit AFTER INSERT OR UPDATE OR DELETE ON pagos_cobrar FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER pagos_compra_tg_audit AFTER INSERT OR UPDATE OR DELETE ON pagos_compra FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER pagos_pagar_tg_audit AFTER INSERT OR UPDATE OR DELETE ON pagos_pagar FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER pagos_venta_tg_audit AFTER INSERT OR UPDATE OR DELETE ON pagos_venta FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER parametros_tg_audit AFTER INSERT OR UPDATE OR DELETE ON parametros FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER productos_tg_audit AFTER INSERT OR UPDATE OR DELETE ON productos FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER proforma_tg_audit AFTER INSERT OR UPDATE OR DELETE ON proforma FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER proveedores_tg_audit AFTER INSERT OR UPDATE OR DELETE ON proveedores FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER registro_equipo_tg_audit AFTER INSERT OR UPDATE OR DELETE ON registro_equipo FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER seguridad_tg_audit AFTER INSERT OR UPDATE OR DELETE ON seguridad FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER serie_venta_tg_audit AFTER INSERT OR UPDATE OR DELETE ON serie_venta FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER series_compra_tg_audit AFTER INSERT OR UPDATE OR DELETE ON series_compra FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER tipoproducto_tg_audit AFTER INSERT OR UPDATE OR DELETE ON "tipoProducto" FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER trabajo_tg_audit AFTER INSERT OR UPDATE OR DELETE ON trabajo FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER trabajo_tecnico_tg_audit AFTER INSERT OR UPDATE OR DELETE ON trabajo_tecnico FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER usuario_tg_audit AFTER INSERT OR UPDATE OR DELETE ON usuario FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();