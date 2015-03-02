/*Script de creación de la base de datos del Sistema de Control de Notas
--Creado por Johan Alamo y estudiantes de proyecto sociotecnológico 
--Comenzado en 2012
--Retomado en febrero de 2014
--Dpto de informática del IUT-RC "Dr. Federico Rivero Palacio"

--Version del script: 2.0
Algoritmo
* crear la base de datos bd_scnfinal
* conectarse a ésta y crear las tablas 
* crear las vistas necesarias
*/

-- CREACION DE LA BASE DE DATOS   *********************************************
\connect postgres;

-- consulta para limpiar el buffer, no borrar.
select 'consulta para limpiar el buffer, no borrar.';

-- Borrar la base de datos en caso de existir
drop database  bd_scnfinal;

drop user usuarioscn;
create user usuarioscn password '123';


-- Crear de nuevo la base de datos
CREATE DATABASE bd_scnfinal
  WITH OWNER = usuarioscn
       ENCODING = 'UTF8'
  CONNECTION LIMIT = -1;

-- Conectarse a la nueva base de datos
\connect bd_scnfinal usuarioscn;



--crear el esquema de las tablas del sistema  ****************************************************
create schema sis;


grant usage on schema sis to usuarioscn;

--creación de la tabla pensum
create table sis.t_pensum(
   codigo integer,
   nombre varchar(100) not null,
   nom_corto varchar(20) not null,
   observaciones varchar(200),
   constraint cp_pensum primary key (codigo),
   constraint ca_pensum unique(nom_corto)
);
comment on table sis.t_pensum is 'Tabla padre de un pensum';
comment on column sis.t_pensum.codigo is 'Código del pensum';
comment on column sis.t_pensum.nombre is 'Nombre largo del pensum';
comment on column sis.t_pensum.nom_corto is 'Abreviación del nombre del pensum';
comment on column sis.t_pensum.observaciones is 'Alguna otra información relevante del pensum';
--alter table sis.t_pensum owner to usuarioscn;

--creación de la tabla trayecto
create table sis.t_trayecto(
	codigo integer,
	cod_pensum integer not null,
	num_trayecto smallint not null,
	certificado varchar(150),
	min_credito smallint not null,
	constraint cp_trayecto primary key(codigo),
	constraint cf_trayecto__pensum foreign key (cod_pensum) 
		references sis.t_pensum(codigo),
	constraint ca_trayecto unique(num_trayecto,cod_pensum),
	constraint chk_trayecto_01 check (codigo > 0),
	constraint chk_trayecto_02 check (num_trayecto >= 0),
	constraint chk_trayecto_03 check (min_credito >= 0)	
);
comment on table sis.t_trayecto is 'Lista de trayectos, semestres o trimestres de un pensum';
comment on column sis.t_trayecto.codigo is 'Código único del trayecto';
comment on column sis.t_trayecto.cod_pensum is 'Código del pensum al que pertenece';
comment on column sis.t_trayecto.num_trayecto is 'Número de trayecto, año, semestre o trimestre del pensum';
comment on column sis.t_trayecto.certificado is 'Nombre del certificado que se obtiene al finalizar este trayecto';
comment on column sis.t_trayecto.min_credito is 'Mínima cantidad de unidades de créditos a obtener para aprobar el trayecto';
--alter table sis.t_trayecto owner to usuarioscn;

--tabla que almacena los tipos de unidades curriculares, ejemplo: electiva, obligatoria, acreditable
create table sis.t_tip_uni_curricular(
	codigo char not null,
	nombre varchar(40) not null,
	constraint cp_uni_cur_tipo primary key(codigo)
);
comment on table  sis.t_tip_uni_curricular is 'Almacena los distintos tipos de unidades curriculares';
comment on column sis.t_tip_uni_curricular.codigo is 'Código del tipo de unidad curricular';
comment on column sis.t_tip_uni_curricular.nombre is 'Nombre del tipo de unidad curricular';
--alter table sis.t_tip_uni_curricular owner to usuarioscn;


--creación de la tabla unidad curricular
create table sis.t_uni_curricular (
	codigo integer,
	cod_uni_ministerio varchar(20) not null,
	cod_trayecto integer not null,
	nombre varchar(100) not null,
	cod_tipo char not null,
	hta float not null,
	hti float,
	uni_credito smallint not null,
	dur_semanas smallint not null,
	not_min_aprobatoria smallint not null, 
	not_maxima smallint not null,
	constraint cp_uni_curricular primary key(codigo),
	constraint ca_uni_curricular unique (cod_uni_ministerio),
	constraint cf_uni_curicular__trayecto foreign key(cod_trayecto)
		references sis.t_trayecto(codigo),
	constraint cf_uni_curricular__tip_uni_curricular foreign key(cod_tipo)
		references sis.t_tip_uni_curricular(codigo),
	constraint chk_uni_curricular_01 check (codigo > 0),
	constraint chk_uni_curricular_02 check (hta >= 0),
	constraint chk_uni_curricular_03 check (hti >= 0),
	constraint chk_uni_curricular_04 check (uni_credito >= 0),
	constraint chk_uni_curricular_05 check (dur_semanas >= 0),
	constraint chk_uni_curricular_06 check (not_min_aprobatoria >= 0),
	constraint chk_uni_curricular_07 check (not_maxima >= not_min_aprobatoria)
);
comment on table sis.t_uni_curricular is 'Tabla que almacena las unidades curriculares de un pensum';
comment on column sis.t_uni_curricular.codigo is 'Código único de la unidad curricular';
comment on column sis.t_uni_curricular.nombre is 'Nombre de la unidad curricular';
comment on column sis.t_uni_curricular.cod_tipo is 'Tipo de la unidad, hace referencia a sis.t_tip_uni_curricular';
comment on column sis.t_uni_curricular.cod_uni_ministerio is 'Código de la unidad curricular según el ministerio';
comment on column sis.t_uni_curricular.cod_trayecto is 'Código del trayecto al que pertenece la unidad curricular';
comment on column sis.t_uni_curricular.uni_credito is 'Cantidad de unidades de crédito de la unidad curricular';
comment on column sis.t_uni_curricular.dur_semanas is 'Cantidad de semanas que dura la unidad curricular';
comment on column sis.t_uni_curricular.not_min_aprobatoria is 'Nota mínima con la que se aprueba la unidad curricular';
comment on column sis.t_uni_curricular.not_maxima is 'Nota máxima o escala de nota de la unidad curricular';
comment on column sis.t_uni_curricular.hta is 'Horas de Trabajo Acompañado por semana(horas de clase)';
comment on column sis.t_uni_curricular.hti is 'Horas de Trabajo Independiente por semana';
--alter table sis.t_uni_curricular owner to usuarioscn;

--tabla para almacenar las prelaciones entre unidades curriculares
create table sis.t_prelacion (
	codigo integer,
	cod_uni_curricular integer not null,
	cod_uni_cur_prelada integer not null,
	constraint cp_prelacion primary key (codigo),
	constraint ca_prelacion unique (cod_uni_curricular, cod_uni_cur_prelada),
	constraint cf_prelacion_01 foreign key (cod_uni_curricular)
		references sis.t_uni_curricular(codigo),
	constraint cf_prelacion_02 foreign key (cod_uni_cur_prelada)
		references sis.t_uni_curricular(codigo)
);
comment on table sis.t_prelacion is 'Tabla que almacena las prelaciones entre unidades curriculares';
comment on column sis.t_prelacion.codigo is 'Código único de la prelación';
comment on column sis.t_prelacion.cod_uni_curricular is 'Código de la unidad curricular a establecerle la prelación';
comment on column sis.t_prelacion.cod_uni_cur_prelada is 'Código de la unidad que no se puede cursar si no se ha aprobado esta';
--alter table sis.t_prelacion owner to usuarioscn;



--Tabla instituto                             AQUI
create table sis.t_instituto(
	codigo smallint,
	nom_corto varchar(20) not null,
	nombre varchar(100) not null,
	direccion varchar(200),
	constraint cp_instituto primary key (codigo),
	constraint ca_instituto unique(nom_corto)
);
--alter table sis.t_instituo owner to usuarioscn;
------------------------------------------------------------------------------------
create table sis.t_departamento(
	codigo smallint,
	nombre varchar(40) not null,
	cod_instituto smallint,
	constraint pk_departamento primary key (codigo),
	constraint fk_departamento_instituto foreign key (cod_instituto)
		references sis.t_instituto(codigo)
);



--Estado que determina si el periodo académico ha finalizado o no (abierto o cerrado)
create table sis.t_est_periodo (
	codigo char not null,
	nombre varchar(20) not null,
	constraint cp_est_periodo primary key(codigo)
);
--alter table sis.t_est_periodo owner to usuarioscn;
 
-- Tabla que almacena la información del período. instituto, pensum, fecha de inicio y fin
-- y el estado del período (abierto, cerrado)
create table sis.t_periodo (
	codigo integer, 
	nombre varchar(30),
	cod_departamento integer NOT NULL,
	cod_pensum integer NOT NULL,
	fec_inicio date not null,
	fec_final date not null,
	observaciones varchar(100),
	cod_estado char not null,  
	constraint cp_periodo primary key (codigo),
	constraint ca_periodo unique (cod_departamento, cod_pensum, fec_inicio),
	constraint fk_periodo__departamento foreign key (cod_departamento)
		references sis.t_departamento(codigo),
	constraint cf_periodo__pensum foreign key (cod_pensum)
		references sis.t_pensum(codigo),
	constraint cf_periodo__est_periodo foreign key(cod_estado)
		references sis.t_est_periodo(codigo),
	constraint chk_periodo_01 check (codigo > 0),
	constraint chk_periodo_02 check (fec_inicio < fec_final)
);
--alter table sis.t_periodo owner to usuarioscn;



--tabla persona, padre de t_estudiante y t_docente
create table sis.t_persona(
	codigo integer not null,
	cedula integer not null,
	rif varchar(20),
	nombre1 varchar(20) not null,
	nombre2 varchar(20),
	apellido1 varchar(20) not null,
	apellido2 varchar(20),
	sexo varchar(1) not null,
	fec_nacimiento date,
	tip_sangre varchar(8),
	telefono1 varchar(20),
	telefono2 varchar(20),
	cor_personal varchar(50),
	cor_institucional varchar(50),
	direccion varchar(200),
	constraint cp_persona primary key(codigo),
	constraint ca_persona_01 unique(cedula),
	constraint ca_persona_02 unique(rif),
	constraint ca_persona_03 unique(cor_personal),
	constraint ca_persona_04 unique (cor_institucional),
	constraint chk_persona_01 check (fec_nacimiento>='01/01/1940' and fec_nacimiento<= current_date),
	constraint chk_persona_02 check (sexo in ('M','F'))
);
--alter table sis.t_persona owner to usuarioscn;


--creacion de la tabla para el estado del docente: activo, retirado, jubilado... etc
create table sis.t_est_docente(
	codigo char not null,
	nombre varchar(40) not null,
	constraint cp_est_docente primary key(codigo)
);
--alter table sis.t_est_docente owner to usuarioscn;


--creación de la tabla docente (hija de persona)
create table sis.t_docente(
	codigo integer,  --referencia a t_persona.codigo
	cod_departamento integer,
	num_empleado smallint,
	cod_estado char not null,
	constraint cp_docente primary key(codigo),
	constraint cf_docente__persona foreign key(codigo)
		references sis.t_persona(codigo),
	constraint cf_docente__est_docente foreign key(cod_estado)
		references sis.t_est_docente(codigo),
	constraint fk_docente__departamento foreign key(cod_departamento)
		references sis.t_departamento(codigo)
);
--alter table sis.t_docente owner to usuarioscn;

--tabla para el manejo del estado de un estudiante: activo, retirado, graduado... etc 
create table sis.t_est_estudiante(
	codigo char not null,
	nombre varchar(20) not null,
	constraint cp_est_estudiante primary key(codigo)
);
--alter table sis.t_est_estudiante owner to usuarioscn;

--tabla estudiante (hija de persona)
create table sis.t_estudiante(
	codigo integer,  --referencia a t_persona.codigo
	cod_departamento integer,
	cod_pensum integer,
	num_carnet varchar(20),
	num_expediente varchar(30),
	cod_rusnies varchar(30),
	cod_estado char not null,
	constraint cp_estudiante primary key(codigo),
	constraint cf_estudiante__persona foreign key(codigo)
		references sis.t_persona(codigo),
	constraint cf_estudiante__est_estado foreign key(cod_estado)
		references sis.t_est_estudiante(codigo),
	constraint fk_estudiante__departamento foreign key(cod_departamento)
		references sis.t_departamento(codigo),
	constraint cf_estudiante__pensum foreign key(cod_pensum)
		references sis.t_pensum(codigo),
	constraint ca_estudiante_01 unique(num_carnet),
	constraint ca_estudiante_02 unique(num_expediente),
	constraint ca_estudiante_03 unique(cod_rusnies)
);
--alter table sis.t_estudiante owner to usuarioscn;

--tabla curso: un curso consta de un docente, una sección, una unidad curricular
-- y un período académico 
create table sis.t_curso(
	codigo serial,
	cod_periodo integer not null,
	cod_uni_curricular integer not null,
	cod_docente integer,
	seccion varchar(5) not null,
	fec_inicio date,
	fec_final date,
	capacidad smallint,
	observaciones varchar(300),
	constraint cp_curso primary key(codigo),
	constraint cf_curso__periodo foreign key(cod_periodo)
		references sis.t_periodo(codigo),
	constraint cf_curso__uni_curricular foreign key(cod_uni_curricular)
		references sis.t_uni_curricular(codigo),
	constraint cf_curso__docente foreign key(cod_docente)
		references sis.t_docente(codigo),
	constraint ca_curso_01 unique(cod_periodo,cod_uni_curricular,seccion),
	constraint chk_curso_01 check (fec_inicio < fec_final),
	constraint chk_curso_02 check (capacidad >= 0),
	constraint chk_curso_03 check (length(trim(seccion))>0)
);
--alter table sis.t_curso owner to usuarioscn;


--estado de un estudiante en un curso: preinscrito, inscrito, cursando, retirado, aprobado, reprobado, reprobado por inasistencia
create table sis.t_est_cur_estudiante(
	codigo char not null,
	nombre varchar(30) not null,
	constraint cp_est_cur_estudiante primary key(codigo)
);
--alter table sis.t_est_cur_estudiante owner to usuarioscn;

--lista de estudiantes de un curso conjuntamente con sus notas y porcentaje de asistencia
create table sis.t_cur_estudiante(
	codigo integer,
	cod_estudiante integer not null,
	cod_curso integer not null,
	por_asistencia float,
	nota integer,
	cod_estado char not null,
	observaciones varchar(300),
	constraint cp_est_curso primary key(codigo),
	constraint ca_est_curso unique(cod_estudiante,cod_curso),
	constraint cf_est_curso__estudiante foreign key(cod_estudiante)
		references sis.t_estudiante(codigo),
	constraint cf_est_curso__curso foreign key(cod_curso)
		references sis.t_curso(codigo),
	constraint cf_est_curso__est_cur_estado foreign key(cod_estado)
		references sis.t_est_cur_estudiante(codigo),
	constraint chk_cur_estudiante_01 check (por_asistencia >= 0),
	constraint chk_cur_estudiante_02 check (nota >= 0),
	constraint chk_cur_estudiante_03 check (por_asistencia <= 100)
);
--alter table sis.t_cur_estudiante owner to usuarioscn;

--tabla donde se almacena la fotografia de una persona
create table sis.t_fotografia(
	cod_persona integer not null,
	tipo varchar(20),
	imagen oid,
	constraint cp_fotografia primary key(cod_persona),
	constraint cf_fotografia__persona foreign key(cod_persona)
		references sis.t_persona(codigo)
);

--********* CREACIÓN DE VISTAS *****************************************
--vista de estudiantes
create view sis.v_estudiante as
	select 	p.cedula,
			p.codigo,
			p.rif,
			p.nombre1,
			p.nombre2,
			p.apellido1,
			p.apellido2,
			p.sexo,
			p.fec_nacimiento,
			p.tip_sangre,
			p.telefono1,
			p.telefono2,
			p.cor_personal,
			p.cor_institucional,
			p.direccion,
			e.cod_departamento,
			e.cod_pensum,
			e.num_carnet,
			e.num_expediente,
			e.cod_rusnies,
			e.cod_estado
	from sis.t_persona as p inner join
		sis.t_estudiante as e on p.codigo = e.codigo;

--vista de docentes
create view sis.v_docente as
	select 	p.codigo,
			p.cedula,
			p.rif,
			p.nombre1,
			p.nombre2,
			p.apellido1,
			p.apellido2,
			p.sexo,
			p.fec_nacimiento,
			p.tip_sangre,
			p.telefono1,
			p.telefono2,
			p.cor_personal,
			p.cor_institucional,
			p.direccion,
			d.cod_departamento,
			d.num_empleado,
			d.cod_estado
	from sis.t_persona as p inner join
		sis.t_docente as d on p.codigo = d.codigo;


--funcion que devuelve un texto invertido, ej: select reverse('prueba'); produce 'abeurp'
CREATE or REPLACE FUNCTION reverse(text) RETURNS text AS $$
	Select array_to_string(ARRAY(
		SELECT substring($1,s.i,1) from generate_series(length($1), 1, -1) as s(i)
		), '');
$$ LANGUAGE SQL IMMUTABLE STRICT;


-- CREACIÓN DEL ESQUEMA DE PERMISOLOGÍA Y DE TODAS SUS TABLAS *****************************************

create schema per;

--Tabla que contiene los módulos de la aplicación
create table per.t_modulo (
	codigo integer,
	nombre varchar(30),
	constraint cp_modulo primary key (codigo)
);
comment on table per.t_modulo is 'Tabla que contiene los módulos de la aplicación';
comment on column per.t_modulo.codigo is 'Código del módulo de la aplicación';
comment on column per.t_modulo.nombre is 'Nombre del módulo de la aplicación';
--ALTER TABLE per.t_modulo OWNER TO usuarioscn;


--Tabla que contiene los usuarios de base de datos de la aplicación
create table per.t_usuario (
	nombre varchar(30),
	codigo integer, 
	tipo char(1),
	constraint cp_usuario primary key (nombre),
	constraint ca_usuario unique (codigo),
	constraint cf_usuario__persona foreign key (codigo)
		references sis.t_persona(codigo),
	constraint chk_usuario_01 check (tipo in ('U','R'))
);
comment on table per.t_usuario is 'Tabla que contiene los usuarios de base de datos de la aplicación';
comment on column per.t_usuario.tipo is 'Indica si es un usuario o un rol(U,R)';
comment on column per.t_usuario.nombre is 'Indica el nombre del usuario';
comment on column per.t_usuario.codigo is 'Código de la persona, hace refercia a sis.t_persona.codigo';
--alter table per.t_usuario owner to usuarioscn;


--Tabla que contiene la lista de tablas de la aplicación, está hecha con la finalidad
-- de asociarlas a un módulo y agilizar el otorgamiento/revocamiento de permisología
create table per.t_tabla(
	nombre varchar(30),
	cod_modulo integer,
	constraint cp_tabla primary key (nombre),
	constraint cf_tabla__modulo foreign key (cod_modulo)
		references per.t_modulo(codigo)
);
comment on table per.t_tabla is 'Tabla que contiene la lista de tablas de la aplicación, está hecha con la finalidad de asociarlas a un módulo y agilizar el otorgamiento/revocamiento de permisología';
comment on column per.t_tabla.nombre is 'Nombre de la tabla del sistema';
comment on column per.t_tabla.cod_modulo is 'Código del módulo al que pertenece la tabla';
--alter table per.t_tabla owner to usuarioscn;


create table per.t_mod_usuario (
	codigo integer,
	cod_usuario integer not null,
	cod_modulo integer not null,
	permiso char(1) not null,
	valor smallint,
	constraint cp_mod_usuario primary key (codigo),
	constraint ca_mod_usuario unique (cod_usuario, cod_modulo),
	constraint cf_mod_usuario__usuario foreign key (cod_usuario)
		references per.t_usuario(codigo),
	constraint cf_mod_usuario__modulo foreign key (cod_modulo)
		references per.t_modulo(codigo),
	constraint chk_mod_usuario_01 check (permiso in ('S','I','D','U'))
);
comment on table per.t_mod_usuario is 'Tabla que almacena los permisos por usuarios';
comment on column per.t_mod_usuario.codigo      is 'Código del permiso usuario-módulo';
comment on column per.t_mod_usuario.cod_usuario is 'Código del usuario dueño del permiso';
comment on column per.t_mod_usuario.cod_modulo  is 'Código del módulo';
comment on column per.t_mod_usuario.permiso  is 'Permiso otorgado (I=insert, U=update, S=select, D=delete';
comment on column per.t_mod_usuario.valor is 'Indica si tiene el permiso o no (1=SI, 0=NO)';
--alter table per.t_mod_usuario owner to usuarioscn;


create table per.t_menu (
	codigo integer,
	nombre varchar(30),
	permiso char(1)


);
