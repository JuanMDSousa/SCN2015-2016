create user bazor password 'mecanica'

grant all privileges on table sis.t_curso,
				sis.t_uni_curricular,
				sis.t_curso,
				sis.t_departamento,				
				sis.t_docente,						
				sis.t_cur_estudiante,
				sis.t_est_cur_estudiante,
				sis.t_est_estudiante,
				sis.t_est_periodo,
				sis.t_estudiante,
				sis.t_fotografia,
				sis.t_instituto,
				sis.t_pensum,
				sis.t_periodo,
				sis.t_persona,
				sis.t_prelacion,
				sis.t_tip_uni_curricular,
				sis.t_trayecto,
				sis.t_uni_curricular,				
				per.t_menu,
				per.t_mod_usuario,
				per.t_modulo,
				per.t_tabla,
				sis.t_est_estudiante,
				sis.v_estudiante,
				sis.v_docente,		
				sis.t_est_docente,		
				per.t_usuario to bazor
				
grant all privileges on schema sis,per to bazor;
grant all privileges on sequence sis.t_curso_codigo_seq to bazor;



----------hay que agregar por tabla en persona,docente y usuario los datos de login












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




--insertar institutos
insert into sis.t_instituto (codigo,nom_corto,nombre,direccion) values (11, 'IUTFRP', 'Instituto Universitario de Tecnología “Dr. Federico Rivero Palacio”', 'Km 8, Panamericana');



insert into sis.t_departamento (codigo,nombre,cod_instituto) values (1,'Mecanica',11);
insert into sis.t_departamento (codigo,nombre,cod_instituto) values (2,'Informatica',11);




--INSERTAR PNFA :   PROGRAMA NACIONAL DE FORMACIÓN EN ADMINISTRACIÓN  ***********************************************
insert into sis.t_pensum (codigo,nombre,observaciones,nom_corto) values (1, 'Programa nacional de formacion en Mecanica)', 'No Posee','PNFM');


insert into sis.t_periodo (codigo, nombre, cod_departamento, cod_pensum, fec_inicio, fec_final, observaciones, cod_estado) values (101,'2014',1,1,'17-02-2014','05-12-2014',null, 'A');

select * from sis.t_departamento

