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




--************************* LLENADO DE OTRAS TABLAS ***************************************************

--insertar institutos
insert into sis.t_instituto (codigo,nom_corto,nombre,direccion) values (11, 'IUTFRP', 'Instituto Universitario de Tecnología “Dr. Federico Rivero Palacio”', 'Km 8, Panamericana');
insert into sis.t_instituto (codigo,nom_corto,nombre,direccion) values (12, 'CUC', 'Colegio Universitario de Caracas', 'Chacao');
insert into sis.t_instituto (codigo,nom_corto,nombre,direccion) values (13, 'CULTCA', 'Colegio Universitario de Los Teques Cecilio Acosta', 'Km 23, Panamericana');
insert into sis.t_instituto (codigo,nom_corto,nombre,direccion) values (14, 'IUTAG', 'Instituto Universitario de Tecnología Alonso Gamero', 'Parque Los Orumos');
insert into sis.t_instituto (codigo,nom_corto,nombre,direccion) values (15, 'IUTOMS', 'Instituto Universitario de Tecnología del Oeste Mariscal Sucre', 'Antimano');
insert into sis.t_instituto (codigo,nom_corto,nombre,direccion) values (16,'CUFM','Colegio Universitario Francisco de Miranda','');
insert into sis.t_instituto (codigo,nom_corto,nombre,direccion) values (17,'CUJLPR','Colegio Universitario ProfesorJosé Lorenzo Pérez Rodríguez','');
insert into sis.t_instituto (codigo,nom_corto,nombre,direccion) values (18,'IUTAI','Instituto Universitario de Tecnología Agroindustrial','');
insert into sis.t_instituto (codigo,nom_corto,nombre,direccion) values (19,'IUTCABIMAS','Instituto Universitariode Tecnología de Cabimas','');
insert into sis.t_instituto (codigo,nom_corto,nombre,direccion) values (20,'IUTCARIPITO','Instituto Universitariode Tecnología de Caripito','');
insert into sis.t_instituto (codigo,nom_corto,nombre,direccion) values (21,'IUTCUMANA','Instituto Universitario de Tecnología de Cumaná','');
insert into sis.t_instituto (codigo,nom_corto,nombre,direccion) values (22,'IUTEB','Instituto Universitario de Tecnologíadel Estado Bolívar','');
insert into sis.t_instituto (codigo,nom_corto,nombre,direccion) values (23,'IUTEP','Instituto Universitario de Tecnologíadel Estado Portuguesa','');
insert into sis.t_instituto (codigo,nom_corto,nombre,direccion) values (24,'IUTET','Instituto Universitario de Tecnologíadel Estado Trujillo','');
insert into sis.t_instituto (codigo,nom_corto,nombre,direccion) values (25,'IUTL','Instituto Universitario de Tecnología de los Llanos','');
insert into sis.t_instituto (codigo,nom_corto,nombre,direccion) values (26,'IUTM','Instituto Universitario de Tecnología de Maracaibo','Maracaibo');
insert into sis.t_instituto (codigo,nom_corto,nombre,direccion) values (27,'IUTDELTA','Instituto Universitario de Tecnología Dr. Delfín Mendoza','Delta Amacuro');
insert into sis.t_instituto (codigo,nom_corto,nombre,direccion) values (28,'IUTJNV','Instituto Universitario de Tecnología Jacinto Navarro Vallenilla','Carupano');
insert into sis.t_instituto (codigo,nom_corto,nombre,direccion) values (29,'IUT-JAA','Instituto Universitario de Tecnología José Antonio Anzoategui','');
insert into sis.t_instituto (codigo,nom_corto,nombre,direccion) values (30,'IUTE','Instituto Universitario de Tecnología de Ejido','');
insert into sis.t_instituto (codigo,nom_corto,nombre,direccion) values (31,'IUTPC','Instituto Universitario de Tecnología de Puerto Cabello','Puerto Cabello');
insert into sis.t_instituto (codigo,nom_corto,nombre,direccion) values (32,'IUTVAL','Instituto Universitario de Tecnología de Valencia','Valencia');

insert into sis.t_departamento (codigo,nombre,cod_instituto) values (1,'Mecanica',11);
insert into sis.t_departamento (codigo,nombre,cod_instituto) values (2,'Informatica',11);

--insertar pensum PNFI ***** PROGRAMA NACIONAL DE FORMACIÓN EN INFORMÁTICA ************************************
insert into sis.t_pensum (codigo,nombre,observaciones,nom_corto) values (1, 'Programa Nacional de Formación Informática', 'implementado en 2008','PNFI');
--PNFI Trayecto 0
insert into sis.t_trayecto (codigo,num_trayecto,cod_pensum,certificado,min_credito) values (1, 0, 1, 'No Posee', 0);
insert into sis.t_uni_curricular (codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) values (1, 'MAC015', 1,'MATEMÁTICA','O',5,5,5,12,12,20);
insert into sis.t_uni_curricular (codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) values (2, 'PNS013', 1,'PROYECTO NACIONAL Y NUEVA CIUDADANÍA','O',2.5,4,3,12,12,20);
insert into sis.t_uni_curricular (codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) values (3, 'IPC012', 1,'INTRODUCCIÓN A LOS PROYECTOS Y AL PNF','O',2.5,2,2,12,12,20);
--PNFI Trayecto 1
insert into sis.t_trayecto (codigo,num_trayecto,cod_pensum,certificado,min_credito) values (2, 1, 1, 'Soporte tecnico', 0);
insert into sis.t_uni_curricular (codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) values (4, 'MAC139', 2, 'MATEMÁTICA I','O',1.5,5,9,36,12,20);
insert into sis.t_uni_curricular (codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) values (5, 'ACT139', 2, 'ARQUITECTURA DEL COMPUTADOR','O',1.5,5,9,36,12,20);
insert into sis.t_uni_curricular (codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) values (6, 'APT1312', 2, 'ALGORÍTMICA Y PROGRAMACIÓN I','O',2.5,6,12,36,12,20);
insert into sis.t_uni_curricular (codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) values (7, 'FCS133', 2, 'FORMACIÓN CRÍTICA I','O',0.5,2,3,36,12,20);
insert into sis.t_uni_curricular (codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) values (8, 'PTP139', 2, 'PROYECTO SOCIO TECNOLÓGICO I','O',0.5,6,9,36,12,20);
insert into sis.t_uni_curricular (codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) values (9, 'IDC133', 2, 'INGLÉS','O',0.5,2,3,36,12,20);
--PNFI Trayecto 2
insert into sis.t_trayecto (codigo,num_trayecto,cod_pensum,certificado,min_credito) values (3, 2, 1, 'TSU Informatica', 0);
insert into sis.t_uni_curricular (codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) values (10, 'MAC226', 3, 'MATEMÁTICA II','O',1.5,5,6,24,12,20);
insert into sis.t_uni_curricular (codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) values (11, 'RCT226', 3, 'REDES DE COMPUTADORAS','O',1.5,5,6,24,12,20);
insert into sis.t_uni_curricular (codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) values (12, 'POT2312', 3, 'PROGRAMACIÓN II','O',2.5,6,12,36,12,20);
insert into sis.t_uni_curricular (codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) values (13, 'ISC213', 3, 'INGENIERÍA DEL SOFTWARE I','O',2,5,3,12,12,20);
insert into sis.t_uni_curricular (codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) values (14, 'BDC213', 3, 'BASE DE DATOS','O',2,5,3,12,12,20);
insert into sis.t_uni_curricular (codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) values (15, 'FCS233', 3, 'FORMACIÓN CRÍTICA II','O',0.5,2,3,36,12,20);
insert into sis.t_uni_curricular (codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) values (16, 'PTP239', 3, 'PROYECTO SOCIO TECNOLÓGICO II','O',0.5,6,9,36,12,20);
--PNFI Trayecto 3
insert into sis.t_trayecto (codigo,num_trayecto,cod_pensum,certificado,min_credito) values (4, 3, 1, 'Desarrollador de aplicaciones', 0);
--PNFI Trayecto 4
insert into sis.t_trayecto (codigo,num_trayecto,cod_pensum,certificado,min_credito) values (5, 4, 1, 'Ingeniero en Informatica', 0);


--insertar unidades curriculares del PNFI



--INSERTAR PNFA :   PROGRAMA NACIONAL DE FORMACIÓN EN ADMINISTRACIÓN  ***********************************************
insert into sis.t_pensum (codigo,nombre,observaciones,nom_corto) values (2, 'Programa nacional de formacion en administracion(LICENCIATURA)', 'No Posee','PNFA');
--PNFA trayecto 0
insert into sis.t_trayecto (codigo,num_trayecto,cod_pensum,certificado,min_credito) values (6, 0, 2, 'No Posee', 0);
insert into sis.t_uni_curricular (codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) values (17, 'PRO6002', 6, 'LA ADMINISTRACIÓN EN EL NUEVO MODELO SOCIAL','O',30,30,2,12,12,20);
insert into sis.t_uni_curricular (codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) values (18, 'PNNC8003', 6, 'PROYECTO NACIONAL Y NUEVA CIUDADANIA','O',40,40,3,12,12,20);
insert into sis.t_uni_curricular (codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) values (19, 'DI6002', 6, 'DESARROLLO INTEGRAL','O',30,30,2,12,12,20);
insert into sis.t_uni_curricular (codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) values (20, 'MA6002', 6, 'MATEMATICA','O',30,30,2,12,12,20);
--PNFA trayecto 1
insert into sis.t_trayecto (codigo,num_trayecto,cod_pensum,certificado,min_credito) values (7, 1, 2, 'ASISTENTE ADMINISTRATIVO', 0);
insert into sis.t_uni_curricular (codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) values (21, 'PRO700124', 7, 'ANÁLISIS Y EJECUCIÓN DE LOS PROCESOS ADMINISTRATIVOS EN LAS ORGANIZACIONES','O',350,350,24,36,16,20);
insert into sis.t_uni_curricular (codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) values (22, 'APN15015', 7, 'ADMINISTRACIÓN PÚBLICA NACIONAL','O',175,175,5,36,12,20);
insert into sis.t_uni_curricular (codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) values (23, 'OF6012', 7, ' OPERACIONES FINANCIERAS','O',30,30,2,36,12,20);
insert into sis.t_uni_curricular (codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) values (24, 'CON18016', 7, 'CONTABILIDAD I','O',90,90,6,36,12,20);
insert into sis.t_uni_curricular (codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) values (25, 'TPM9013', 7, 'TEORÍA Y PRÁCTICA DEL MERCADEO','O',45,45,3,36,12,20);
--PNFA trayecto 2
insert into sis.t_trayecto (codigo,num_trayecto,cod_pensum,certificado,min_credito) values (8, 2, 2, 'TSU EN ADMINISTRACIÓN', 0);
insert into sis.t_uni_curricular (codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) values (26, 'PRO700224', 8, 'SUPERVISIÓN Y CONDUCCIÓN TÉCNICA DE PROCESOS ADMINISTRATIVOS','O',350,350,24,36,16,20);
insert into sis.t_uni_curricular (codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) values (27, 'ESMD15025', 8, 'ECONOMÍA, SUSTENTABILIDAD Y MODELOS DE DESARROLLO','O',175,175,5,36,12,20);
insert into sis.t_uni_curricular (codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) values (28, 'CON9023', 8, 'CONTABILIDAD II','O',45,45,3,36,12,20);
insert into sis.t_uni_curricular (codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) values (29, 'ADC6022', 8, 'ADMINISTRACIÒN DE COSTOS','O',30,30,2,36,12,20);
insert into sis.t_uni_curricular (codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) values (30, 'OM6022', 8, 'ORGANIZACIÓN Y MÉTODOS','O',30,30,2,36,12,20);
insert into sis.t_uni_curricular (codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) values (31, 'THAT9023', 8, 'TALENTO HUMANO Y AMBIENTE DE TRABAJO','O',45,45,3,36,12,20);
--PNFA trayecto 3
insert into sis.t_trayecto (codigo,num_trayecto,cod_pensum,certificado,min_credito) values (9, 3, 2, 'No posee', 0);
insert into sis.t_uni_curricular (codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) values (32, 'PRO700324', 9, 'DISEÑO, PLANIFICACIÓN, DESARROLLO E INNOVACIÓN DE SISTEMAS ADMINISTRATIVOS','O',350,350,24,36,16,20);
insert into sis.t_uni_curricular (codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) values (33, 'PSAPD15035', 9, 'PARTICIPACIÓN SOCIAL EN LA ADMINISTRACIÓN, PRODUCCIÓN Y DISTRIBUCIÓN','O',175,175,5,36,12,20);
insert into sis.t_uni_curricular (codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) values (34, 'ADP6032', 9, 'ADMINISTRACIÓN DE LA PRODUCCIÓN','O',30,30,2,36,12,20);
insert into sis.t_uni_curricular (codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) values (35, 'PPU4032', 9, 'PRESUPUESTO PÚBLICO','O',20,20,2,36,12,20);
insert into sis.t_uni_curricular (codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) values (36, 'PPR3031', 9, 'PRESUPUESTO PRIVADO','O',15,15,1,36,12,20);
insert into sis.t_uni_curricular (codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) values (37, 'ADM6032', 9, 'ADMINISTRACIÓN DEL MERCADEO','O',30,30,1,36,12,20);
insert into sis.t_uni_curricular (codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) values (38, 'FEP3031', 9, 'FORMULACIÓN Y EVALUACIÓN DE PROYECTOS','O',15,15,1,36,12,20);
--PNFA trayecto 4
insert into sis.t_trayecto (codigo,num_trayecto,cod_pensum,certificado,min_credito) values (10,4, 2, 'LICENCIADO EN ADMINISTRACIÓN', 0);
insert into sis.t_uni_curricular (codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) values (39, 'PRO700424', 10, 'DIRECCIÓN, CONTROL Y EVALUACIÓN DE SISTEMAS ADMINISTRATIVOS','O',350,350,24,36,16,20);
insert into sis.t_uni_curricular (codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) values (40, 'APUALC15045', 10, 'ADMINISTRACIÓN EN LOS PROCESOS DE UNIDAD DE AMÉRICA LATINA Y EL CARIBE EN EL NUEVO CONTEXTO MUNDIAL','O',175,175,5,36,12,20);
insert into sis.t_uni_curricular (codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) values (41, 'AIEF6042', 10, 'ANÁLISIS E INTERPRETACIÓN DE ESTADOS FINANCIEROS','O',30,30,2,36,12,20);
insert into sis.t_uni_curricular (codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) values (42, 'SFN6042', 10, 'SISTEMA FINANCIERO NACIONAL','O',30,30,2,24,12,20);
insert into sis.t_uni_curricular (codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) values (43, 'AF6042', 10, 'ADMINISTRACIÓN FINANCIERA','O',30,30,2,24,12,20);
insert into sis.t_uni_curricular (codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) values (44, 'PDETH9042', 10, 'PLANIFICACIÓN Y DESARROLLO ESTRATÉGICO DEL TALENTO HUMANO','O',45,45,3,36,12,20);
insert into sis.t_uni_curricular (codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) values (45, 'NPG9043', 10, 'NUEVOS PARADIGMAS PARA LA GESTIÓN DEL TALENTO HUMANO.','O',45,45,3,12,12,20);


-- llenar los periodos académicos ***************************
insert into sis.t_periodo (codigo, nombre, cod_departamento, cod_pensum, fec_inicio, fec_final, observaciones, cod_estado) values (100,'2013',1,1,'17-02-2013','05-12-2013',null, 'C');
insert into sis.t_periodo (codigo, nombre, cod_departamento, cod_pensum, fec_inicio, fec_final, observaciones, cod_estado) values (101,'2014',1,1,'17-02-2014','05-12-2014',null, 'A');

--************************* INSERCIÓN DE DATA FALSA, DATA DE PRUEBA. ******************************************************************
--insertar personas
insert into sis.t_persona(codigo, cedula, nombre1, apellido1, sexo) values (1,   16148116, 'Johan','Alamo','M');
insert into sis.t_persona(codigo, cedula, nombre1, apellido1, sexo) values (2,   10000000, 'Marco','Castro','M');
insert into sis.t_persona(codigo, cedula, nombre1, apellido1, sexo) values (3,   11000000, 'Alexis','Mola','M');
insert into sis.t_persona(codigo, cedula, nombre1, apellido1, sexo) values (101, 21000000, 'Geraldine','Castillo','F');
insert into sis.t_persona(codigo, cedula, nombre1, apellido1, sexo) values (102, 22000000, 'Jhonny','Vielma','M');
insert into sis.t_persona(codigo, cedula, nombre1, apellido1, sexo) values (103, 23000000, 'Rafael','Garcia','M');
insert into sis.t_persona(codigo, cedula, nombre1, apellido1, sexo) values (104, 24000000, 'Eleiny','Bello','F');
insert into sis.t_persona(codigo, cedula, nombre1, apellido1, sexo) values (105, 25000000, 'Edwin','García','M');
--insertar docentes
insert into sis.t_docente(codigo, cod_departamento, cod_estado) values (1, 1, 'A');
insert into sis.t_docente(codigo, cod_departamento, cod_estado) values (2, 1, 'A');
insert into sis.t_docente(codigo, cod_departamento, cod_estado) values (3, 1, 'A');
--insertar estudiantes
insert into sis.t_estudiante(codigo, cod_departamento, cod_pensum, cod_estado) values (101, 1, 1, 'A');
insert into sis.t_estudiante(codigo, cod_departamento, cod_pensum, cod_estado) values (102, 1, 1, 'A');
insert into sis.t_estudiante(codigo, cod_departamento, cod_pensum, cod_estado) values (103, 1, 1, 'A');
insert into sis.t_estudiante(codigo, cod_departamento, cod_pensum, cod_estado) values (104, 1, 1, 'A');
insert into sis.t_estudiante(codigo, cod_departamento, cod_pensum, cod_estado) values (105, 1, 1, 'A');



--llenar curso: crear tres cursos ************************************************************************************
--matematica secc. A, prof johan. Con tres estudiantes
insert into sis.t_curso(codigo, cod_periodo, cod_uni_curricular,cod_docente,seccion, fec_inicio, fec_final, capacidad,observaciones) values (21, 101, 1,1, 'A','01-03-2014','01-11-2014',10,null);
insert into sis.t_cur_estudiante(codigo,cod_estudiante,cod_curso,por_asistencia,nota,cod_estado,observaciones) values (10,101,21,75,16,'C',null);
insert into sis.t_cur_estudiante(codigo,cod_estudiante,cod_curso,por_asistencia,nota,cod_estado,observaciones) values (11,102,21,null,10,'C',null);
insert into sis.t_cur_estudiante(codigo,cod_estudiante,cod_curso,por_asistencia,nota,cod_estado,observaciones) values (12,103,21,93.8,null,'C',null);
--pnnc secc. A, prof marco. Con tres estudiantes
insert into sis.t_curso(codigo, cod_periodo, cod_uni_curricular,cod_docente,seccion, fec_inicio, fec_final, capacidad,observaciones) values (22, 101, 2,2, 'A','01-03-2014','01-11-2014',10,null);
insert into sis.t_cur_estudiante(codigo,cod_estudiante,cod_curso,por_asistencia,nota,cod_estado,observaciones) values (13,102,22,70,19,'C',null);
insert into sis.t_cur_estudiante(codigo,cod_estudiante,cod_curso,por_asistencia,nota,cod_estado,observaciones) values (14,103,22,80,11,'C',null);
insert into sis.t_cur_estudiante(codigo,cod_estudiante,cod_curso,por_asistencia,nota,cod_estado,observaciones) values (15,104,22,100,null,'C',null);
--Introducción a los proyectos y al pnf secc. A, prof alexis. Con dos estudiantes
insert into sis.t_curso(codigo, cod_periodo, cod_uni_curricular,cod_docente,seccion, fec_inicio, fec_final, capacidad,observaciones) values (23, 101, 3,3, 'A','01-03-2014','01-11-2014',10,null);
insert into sis.t_cur_estudiante(codigo,cod_estudiante,cod_curso,por_asistencia,nota,cod_estado,observaciones) values (16,103,23,40,19,'C',null);
insert into sis.t_cur_estudiante(codigo,cod_estudiante,cod_curso,por_asistencia,nota,cod_estado,observaciones) values (17,104,23,null,11,'C',null);

--llenar fotografia



\c postgres;

