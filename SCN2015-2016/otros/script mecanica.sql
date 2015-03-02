/*Script para insertar data en la base de datos del Sistema de Control de Notas
--Creado por Johan Alamo
--Elaborado en febrero de 2014
--Dpto de informática del IUT-RC "Dr. Federico Rivero Palacio"
*/

\connect bd_scnfinal usuarioscn;

-- consulta para limpiar el buffer, no borrar.
select 'consulta para limpiar el buffer, no borrar.';


--************************************  LLENADO DE TABLAS BÁSICAS *******************************************
--insertar en t_uni_cur_tipo: electiva, obligatoria, acreditable
insert into sis.t_tip_uni_curricular(codigo,nombre) values ('O','Obligatoria');
insert into sis.t_tip_uni_curricular(codigo,nombre) values ('E','Electiva');
insert into sis.t_tip_uni_curricular(codigo,nombre) values ('A','Acreditable');
--insertar en t_est_periodo (abierto, cerrado), estado del periodo académcio
insert into sis.t_est_periodo(codigo,nombre) values ('A', 'Abierto');
insert into sis.t_est_periodo(codigo,nombre) values ('C', 'Cerrado');
--llenar tabla t_est_docente (activo, retirado, jubilado)
insert into sis.t_est_docente(codigo,nombre) values ('A', 'Activo');
insert into sis.t_est_docente(codigo,nombre) values ('R', 'Retirado');
insert into sis.t_est_docente(codigo,nombre) values ('J', 'Jubilado');
--insertar en t_est_estudiante
insert into sis.t_est_estudiante(codigo,nombre) values ('A', 'Activo');
insert into sis.t_est_estudiante(codigo,nombre) values ('R', 'Retirado');
insert into sis.t_est_estudiante(codigo,nombre) values ('C', 'Congelado');
insert into sis.t_est_estudiante(codigo,nombre) values ('G', 'Graduado');
--llenar est_cur_estudiante
insert into sis.t_est_cur_estudiante(codigo,nombre) values ('P','Preinscrito');
insert into sis.t_est_cur_estudiante(codigo,nombre) values ('I','Inscrito');
insert into sis.t_est_cur_estudiante(codigo,nombre) values ('C','Cursando');
insert into sis.t_est_cur_estudiante(codigo,nombre) values ('E','Retirado');
insert into sis.t_est_cur_estudiante(codigo,nombre) values ('A','Aprobado');
insert into sis.t_est_cur_estudiante(codigo,nombre) values ('R','Reprobado');
insert into sis.t_est_cur_estudiante(codigo,nombre) values ('N','Reprobado por inasistencia');
--llenar talba per.t_permiso
insert into per.t_permiso (codigo, nombre) values ('I','insert');
insert into per.t_permiso (codigo, nombre) values ('U','update');
insert into per.t_permiso (codigo, nombre) values ('S','select');
insert into per.t_permiso (codigo, nombre) values ('D','delete');
--lenar tabla per.modulo

insert into sis.t_instituto (codigo,nom_corto,nombre,direccion) values (11, 'IUTFRP', 'Instituto Universitario de Tecnología “Dr. Federico Rivero Palacio”', 'Km 8, Panamericana');
insert into sis.t_instituto (codigo,nom_corto,nombre,direccion) values (12, 'CUC', 'Colegio Universitario de Caracas', 'Chacao');
insert into sis.t_instituto (codigo,nom_corto,nombre,direccion) values (13, 'CULTCA', 'Colegio Universitario de Los Teques Cecilio Acosta', 'Km 23, Panamericana');
insert into sis.t_instituto (codigo,nom_corto,nombre,direccion) values (14, 'IUTAG', 'Instituto Universitario de Tecnología Alonso Gamero', 'Parque Los Orumos');
insert into sis.t_instituto (codigo,nom_corto,nombre,direccion) values (15, 'IUTOMS', 'Instituto Universitario de Tecnología del Oeste Mariscal Sucre', 'Antimano');

insert into sis.t_departamento (codigo,nombre,cod_instituto) values (1,'Mecanica',11);

insert into sis.t_pensum (codigo,nombre,observaciones,nom_corto) values (1, 'PROGRAMA NACIONAL DE FORMACIÓN EN MECÁNICA', '','PNFM');

insert into sis.t_periodo (codigo, nombre, cod_departamento, cod_pensum, fec_inicio, fec_final, observaciones, cod_estado) values (101,'2014',1,1,'17-02-2014','05-12-2015',null, 'C');

\c postgres;
