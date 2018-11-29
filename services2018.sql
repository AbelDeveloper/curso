--------------------------------------------------------
-- Archivo creado  - jueves-mayo-17-2018   
--------------------------------------------------------
--------------------------------------------------------
--  DDL for Sequence CONTROL_SEQUENCE
--------------------------------------------------------

   CREATE SEQUENCE  "SERVICES"."CONTROL_SEQUENCE"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 1 CACHE 20 NOORDER  NOCYCLE ;
--------------------------------------------------------
--  DDL for Table CONTROL
--------------------------------------------------------

  CREATE TABLE "SERVICES"."CONTROL" 
   (	"ID" NUMBER(*,0), 
	"DETALLE" VARCHAR2(100 BYTE), 
	"DIFERENCIA_DIAS" NUMBER(*,0), 
	"FECHA_ASIGNACION" DATE, 
	"FECHA_ATENDIDO" DATE, 
	"FECHA_CONFIRMACION" DATE, 
	"FECHA_DEATHLINE" DATE, 
	"FECHA_INGRESO" DATE, 
	"FLAGACTIVE" VARCHAR2(10 BYTE), 
	"OBSERVACIONES" VARCHAR2(100 BYTE), 
	"SOLICITANTE" VARCHAR2(100 BYTE), 
	"ID_SERVICIO_GENERAL" NUMBER(*,0), 
	"ID_SERVICIO_ESPECIFICO" NUMBER(*,0), 
	"ID_RESPONSABLE" NUMBER(*,0)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Table RESPONSABLES
--------------------------------------------------------

  CREATE TABLE "SERVICES"."RESPONSABLES" 
   (	"ID" NUMBER(*,0), 
	"NOMBRE" VARCHAR2(200 BYTE), 
	"CORREO" VARCHAR2(50 BYTE)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Table SERVICIO_ESPECIFICO
--------------------------------------------------------

  CREATE TABLE "SERVICES"."SERVICIO_ESPECIFICO" 
   (	"ID" NUMBER(*,0), 
	"DESCRIPCION_ESPECIFICO" VARCHAR2(200 BYTE), 
	"ID_GENERAL" NUMBER(*,0)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Table SERVICIO_GENERAL
--------------------------------------------------------

  CREATE TABLE "SERVICES"."SERVICIO_GENERAL" 
   (	"ID" NUMBER(*,0), 
	"DESCRIPCION_GENERAL" VARCHAR2(200 BYTE)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
REM INSERTING into SERVICES.CONTROL
SET DEFINE OFF;
REM INSERTING into SERVICES.RESPONSABLES
SET DEFINE OFF;
Insert into SERVICES.RESPONSABLES (ID,NOMBRE,CORREO) values ('1','Arturo Huanca','ahuanca@mininter.gob.pe');
Insert into SERVICES.RESPONSABLES (ID,NOMBRE,CORREO) values ('2','Carlos Ormeño','cormeno@mininter.gob.pe');
Insert into SERVICES.RESPONSABLES (ID,NOMBRE,CORREO) values ('3','Graciela Castro','gcastro@mininter.gob.pe');
Insert into SERVICES.RESPONSABLES (ID,NOMBRE,CORREO) values ('4','Hans Bürkli','opes_usuario05@mininter.gob.pe');
Insert into SERVICES.RESPONSABLES (ID,NOMBRE,CORREO) values ('5','Jhony Pacheco','ficher21@hotmail.com');
Insert into SERVICES.RESPONSABLES (ID,NOMBRE,CORREO) values ('6','Paul Avellaneda','pavellaneda@mininter.gob.pe');
REM INSERTING into SERVICES.SERVICIO_ESPECIFICO
SET DEFINE OFF;
Insert into SERVICES.SERVICIO_ESPECIFICO (ID,DESCRIPCION_ESPECIFICO,ID_GENERAL) values ('1','Apoyo en procesos de calidad Estadistica','1');
Insert into SERVICES.SERVICIO_ESPECIFICO (ID,DESCRIPCION_ESPECIFICO,ID_GENERAL) values ('2','Otros requerimientos','1');
Insert into SERVICES.SERVICIO_ESPECIFICO (ID,DESCRIPCION_ESPECIFICO,ID_GENERAL) values ('3','Bases de datos de los programas prespuestales ','2');
Insert into SERVICES.SERVICIO_ESPECIFICO (ID,DESCRIPCION_ESPECIFICO,ID_GENERAL) values ('4','Creación de reportes dinamicos o dashboards ','2');
Insert into SERVICES.SERVICIO_ESPECIFICO (ID,DESCRIPCION_ESPECIFICO,ID_GENERAL) values ('5','Información para boletines trimestrales y bimestrales ','2');
Insert into SERVICES.SERVICIO_ESPECIFICO (ID,DESCRIPCION_ESPECIFICO,ID_GENERAL) values ('6','Información sobre los accidentes de tránsito ','2');
Insert into SERVICES.SERVICIO_ESPECIFICO (ID,DESCRIPCION_ESPECIFICO,ID_GENERAL) values ('7','Otros requerimientos','2');
Insert into SERVICES.SERVICIO_ESPECIFICO (ID,DESCRIPCION_ESPECIFICO,ID_GENERAL) values ('8','Google forms','3');
Insert into SERVICES.SERVICIO_ESPECIFICO (ID,DESCRIPCION_ESPECIFICO,ID_GENERAL) values ('9','Mascaras (Excel)','3');
Insert into SERVICES.SERVICIO_ESPECIFICO (ID,DESCRIPCION_ESPECIFICO,ID_GENERAL) values ('10','PHP (Software libres)','3');
Insert into SERVICES.SERVICIO_ESPECIFICO (ID,DESCRIPCION_ESPECIFICO,ID_GENERAL) values ('11','Compendio Estadistico Anual','4');
Insert into SERVICES.SERVICIO_ESPECIFICO (ID,DESCRIPCION_ESPECIFICO,ID_GENERAL) values ('12','Compendio Series Estadisticas','4');
Insert into SERVICES.SERVICIO_ESPECIFICO (ID,DESCRIPCION_ESPECIFICO,ID_GENERAL) values ('13','Comisión de programa presupuesta','5');
Insert into SERVICES.SERVICIO_ESPECIFICO (ID,DESCRIPCION_ESPECIFICO,ID_GENERAL) values ('14','Participar en actividades de coordinación del CENACOM','5');
Insert into SERVICES.SERVICIO_ESPECIFICO (ID,DESCRIPCION_ESPECIFICO,ID_GENERAL) values ('15','Participar en actividades de coordinación del ENEVIC','5');
Insert into SERVICES.SERVICIO_ESPECIFICO (ID,DESCRIPCION_ESPECIFICO,ID_GENERAL) values ('16','Participar en actividades de coordinación para la Encuesta de Oficiales de Armas Femenino','5');
Insert into SERVICES.SERVICIO_ESPECIFICO (ID,DESCRIPCION_ESPECIFICO,ID_GENERAL) values ('17','Otros requerimientos','5');
Insert into SERVICES.SERVICIO_ESPECIFICO (ID,DESCRIPCION_ESPECIFICO,ID_GENERAL) values ('18','Formulación de Indicadores ','6');
Insert into SERVICES.SERVICIO_ESPECIFICO (ID,DESCRIPCION_ESPECIFICO,ID_GENERAL) values ('19','Supervisión de Indicadores ','6');
Insert into SERVICES.SERVICIO_ESPECIFICO (ID,DESCRIPCION_ESPECIFICO,ID_GENERAL) values ('20','Otros requerimientos','6');
Insert into SERVICES.SERVICIO_ESPECIFICO (ID,DESCRIPCION_ESPECIFICO,ID_GENERAL) values ('21','Formulación de lineamientos ','7');
Insert into SERVICES.SERVICIO_ESPECIFICO (ID,DESCRIPCION_ESPECIFICO,ID_GENERAL) values ('22','Llenar la Matriz de control','8');
Insert into SERVICES.SERVICIO_ESPECIFICO (ID,DESCRIPCION_ESPECIFICO,ID_GENERAL) values ('23','Otros requerimientos','9');
Insert into SERVICES.SERVICIO_ESPECIFICO (ID,DESCRIPCION_ESPECIFICO,ID_GENERAL) values ('24','Revisión de la normativa sobre estadistica','10');
Insert into SERVICES.SERVICIO_ESPECIFICO (ID,DESCRIPCION_ESPECIFICO,ID_GENERAL) values ('25','Validación de la información Estadistica ','11');
Insert into SERVICES.SERVICIO_ESPECIFICO (ID,DESCRIPCION_ESPECIFICO,ID_GENERAL) values ('26','Otros requerimientos','11');
REM INSERTING into SERVICES.SERVICIO_GENERAL
SET DEFINE OFF;
Insert into SERVICES.SERVICIO_GENERAL (ID,DESCRIPCION_GENERAL) values ('1','Apoyo en procesos de calidad Estadística');
Insert into SERVICES.SERVICIO_GENERAL (ID,DESCRIPCION_GENERAL) values ('2','Brindar información a otras entindades ');
Insert into SERVICES.SERVICIO_GENERAL (ID,DESCRIPCION_GENERAL) values ('3','Creación de data entry');
Insert into SERVICES.SERVICIO_GENERAL (ID,DESCRIPCION_GENERAL) values ('4','Elaborar Productos estadístico');
Insert into SERVICES.SERVICIO_GENERAL (ID,DESCRIPCION_GENERAL) values ('5','Emitir Opinión Técnica');
Insert into SERVICES.SERVICIO_GENERAL (ID,DESCRIPCION_GENERAL) values ('6','Evaluación de indicadores');
Insert into SERVICES.SERVICIO_GENERAL (ID,DESCRIPCION_GENERAL) values ('7','Formulación de lineamientos ');
Insert into SERVICES.SERVICIO_GENERAL (ID,DESCRIPCION_GENERAL) values ('8','Llenar la Matriz de control');
Insert into SERVICES.SERVICIO_GENERAL (ID,DESCRIPCION_GENERAL) values ('9','Otros requerimientos');
Insert into SERVICES.SERVICIO_GENERAL (ID,DESCRIPCION_GENERAL) values ('10','Revisión de la normativa sobre estadística ');
Insert into SERVICES.SERVICIO_GENERAL (ID,DESCRIPCION_GENERAL) values ('11','Validación de la información Estadística');
--------------------------------------------------------
--  DDL for Index XPKRESPONSABLES
--------------------------------------------------------

  CREATE UNIQUE INDEX "SERVICES"."XPKRESPONSABLES" ON "SERVICES"."RESPONSABLES" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index CONTROL_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "SERVICES"."CONTROL_PK" ON "SERVICES"."CONTROL" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index XPKDESCRIPCION_GENERAL
--------------------------------------------------------

  CREATE UNIQUE INDEX "SERVICES"."XPKDESCRIPCION_GENERAL" ON "SERVICES"."SERVICIO_GENERAL" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index SERVICIO_ESPECIFICO_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "SERVICES"."SERVICIO_ESPECIFICO_PK" ON "SERVICES"."SERVICIO_ESPECIFICO" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Trigger TD_DESCRIPCION_GENERAL
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "SERVICES"."TD_DESCRIPCION_GENERAL" AFTER DELETE ON SERVICIO_GENERAL for each row
-- erwin Builtin Trigger
-- DELETE trigger on descripcion_general 
DECLARE NUMROWS INTEGER;
BEGIN
    /* erwin Builtin Trigger */
    /* descripcion_general  servicio_especifico on parent delete restrict */
    /* ERWIN_RELATION:CHECKSUM="00020362", PARENT_OWNER="", PARENT_TABLE="descripcion_general"
    CHILD_OWNER="", CHILD_TABLE="servicio_especifico"
    P2C_VERB_PHRASE="", C2P_VERB_PHRASE="", 
    FK_CONSTRAINT="R_15", FK_COLUMNS="id_servicio_general" */
    SELECT count(*) INTO NUMROWS
      FROM servicio_especifico
      WHERE
        /*  %JoinFKPK(servicio_especifico,:%Old," = "," AND") */
        servicio_especifico.id_servicio_general = :old.id;
    IF (NUMROWS > 0)
    THEN
      raise_application_error(
        -20001,
        'Cannot delete descripcion_general because servicio_especifico exists.'
      );
    END IF;

    /* erwin Builtin Trigger */
    /* descripcion_general  control on parent delete restrict */
    /* ERWIN_RELATION:CHECKSUM="00000000", PARENT_OWNER="", PARENT_TABLE="descripcion_general"
    CHILD_OWNER="", CHILD_TABLE="control"
    P2C_VERB_PHRASE="", C2P_VERB_PHRASE="", 
    FK_CONSTRAINT="R_14", FK_COLUMNS="id_servicio_general" */
    SELECT count(*) INTO NUMROWS
      FROM control
      WHERE
        /*  %JoinFKPK(control,:%Old," = "," AND") */
        control.id_servicio_general = :old.id;
    IF (NUMROWS > 0)
    THEN
      raise_application_error(
        -20001,
        'Cannot delete descripcion_general because control exists.'
      );
    END IF;


-- erwin Builtin Trigger
END;

/
ALTER TRIGGER "SERVICES"."TD_DESCRIPCION_GENERAL" ENABLE;
--------------------------------------------------------
--  DDL for Trigger TD_RESPONSABLES
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "SERVICES"."TD_RESPONSABLES" AFTER DELETE ON responsables for each row
-- erwin Builtin Trigger
-- DELETE trigger on responsables 
DECLARE NUMROWS INTEGER;
BEGIN
    /* erwin Builtin Trigger */
    /* responsables  control on parent delete restrict */
    /* ERWIN_RELATION:CHECKSUM="0002c036", PARENT_OWNER="", PARENT_TABLE="responsables"
    CHILD_OWNER="", CHILD_TABLE="control"
    P2C_VERB_PHRASE="", C2P_VERB_PHRASE="", 
    FK_CONSTRAINT="R_19", FK_COLUMNS="id_responsable" */
    SELECT count(*) INTO NUMROWS
      FROM control
      WHERE
        /*  %JoinFKPK(control,:%Old," = "," AND") */
        control.id_responsable = :old.id;
    IF (NUMROWS > 0)
    THEN
      raise_application_error(
        -20001,
        'Cannot delete responsables because control exists.'
      );
    END IF;

    /* erwin Builtin Trigger */
    /* responsables  control on parent delete restrict */
    /* ERWIN_RELATION:CHECKSUM="00000000", PARENT_OWNER="", PARENT_TABLE="responsables"
    CHILD_OWNER="", CHILD_TABLE="control"
    P2C_VERB_PHRASE="", C2P_VERB_PHRASE="", 
    FK_CONSTRAINT="R_18", FK_COLUMNS="id_responsable" */
    SELECT count(*) INTO NUMROWS
      FROM control
      WHERE
        /*  %JoinFKPK(control,:%Old," = "," AND") */
        control.id_responsable = :old.id;
    IF (NUMROWS > 0)
    THEN
      raise_application_error(
        -20001,
        'Cannot delete responsables because control exists.'
      );
    END IF;

    /* erwin Builtin Trigger */
    /* responsables  control on parent delete restrict */
    /* ERWIN_RELATION:CHECKSUM="00000000", PARENT_OWNER="", PARENT_TABLE="responsables"
    CHILD_OWNER="", CHILD_TABLE="control"
    P2C_VERB_PHRASE="", C2P_VERB_PHRASE="", 
    FK_CONSTRAINT="R_17", FK_COLUMNS="id_responsable" */
    SELECT count(*) INTO NUMROWS
      FROM control
      WHERE
        /*  %JoinFKPK(control,:%Old," = "," AND") */
        control.id_responsable = :old.id;
    IF (NUMROWS > 0)
    THEN
      raise_application_error(
        -20001,
        'Cannot delete responsables because control exists.'
      );
    END IF;


-- erwin Builtin Trigger
END;

/
ALTER TRIGGER "SERVICES"."TD_RESPONSABLES" ENABLE;
--------------------------------------------------------
--  DDL for Trigger TU_DESCRIPCION_GENERAL
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "SERVICES"."TU_DESCRIPCION_GENERAL" AFTER UPDATE ON SERVICIO_GENERAL for each row
-- erwin Builtin Trigger
-- UPDATE trigger on descripcion_general 
DECLARE NUMROWS INTEGER;
BEGIN
  /* erwin Builtin Trigger */
  /* descripcion_general  servicio_especifico on parent update restrict */
  /* ERWIN_RELATION:CHECKSUM="00024a56", PARENT_OWNER="", PARENT_TABLE="descripcion_general"
    CHILD_OWNER="", CHILD_TABLE="servicio_especifico"
    P2C_VERB_PHRASE="", C2P_VERB_PHRASE="", 
    FK_CONSTRAINT="R_15", FK_COLUMNS="id_servicio_general" */
  IF
    /* %JoinPKPK(:%Old,:%New," <> "," OR ") */
    :old.id <> :new.id
  THEN
    SELECT count(*) INTO NUMROWS
      FROM servicio_especifico
      WHERE
        /*  %JoinFKPK(servicio_especifico,:%Old," = "," AND") */
        servicio_especifico.id_servicio_general = :old.id;
    IF (NUMROWS > 0)
    THEN 
      raise_application_error(
        -20005,
        'Cannot update descripcion_general because servicio_especifico exists.'
      );
    END IF;
  END IF;

  /* erwin Builtin Trigger */
  /* descripcion_general  control on parent update restrict */
  /* ERWIN_RELATION:CHECKSUM="00000000", PARENT_OWNER="", PARENT_TABLE="descripcion_general"
    CHILD_OWNER="", CHILD_TABLE="control"
    P2C_VERB_PHRASE="", C2P_VERB_PHRASE="", 
    FK_CONSTRAINT="R_14", FK_COLUMNS="id_servicio_general" */
  IF
    /* %JoinPKPK(:%Old,:%New," <> "," OR ") */
    :old.id <> :new.id
  THEN
    SELECT count(*) INTO NUMROWS
      FROM control
      WHERE
        /*  %JoinFKPK(control,:%Old," = "," AND") */
        control.id_servicio_general = :old.id;
    IF (NUMROWS > 0)
    THEN 
      raise_application_error(
        -20005,
        'Cannot update descripcion_general because control exists.'
      );
    END IF;
  END IF;


-- erwin Builtin Trigger
END;

/
ALTER TRIGGER "SERVICES"."TU_DESCRIPCION_GENERAL" ENABLE;
--------------------------------------------------------
--  DDL for Trigger TU_RESPONSABLES
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "SERVICES"."TU_RESPONSABLES" AFTER UPDATE ON responsables for each row
-- erwin Builtin Trigger
-- UPDATE trigger on responsables 
DECLARE NUMROWS INTEGER;
BEGIN
  /* erwin Builtin Trigger */
  /* responsables  control on parent update restrict */
  /* ERWIN_RELATION:CHECKSUM="00031263", PARENT_OWNER="", PARENT_TABLE="responsables"
    CHILD_OWNER="", CHILD_TABLE="control"
    P2C_VERB_PHRASE="", C2P_VERB_PHRASE="", 
    FK_CONSTRAINT="R_19", FK_COLUMNS="id_responsable" */
  IF
    /* %JoinPKPK(:%Old,:%New," <> "," OR ") */
    :old.id <> :new.id
  THEN
    SELECT count(*) INTO NUMROWS
      FROM control
      WHERE
        /*  %JoinFKPK(control,:%Old," = "," AND") */
        control.id_responsable = :old.id;
    IF (NUMROWS > 0)
    THEN 
      raise_application_error(
        -20005,
        'Cannot update responsables because control exists.'
      );
    END IF;
  END IF;

  /* erwin Builtin Trigger */
  /* responsables  control on parent update restrict */
  /* ERWIN_RELATION:CHECKSUM="00000000", PARENT_OWNER="", PARENT_TABLE="responsables"
    CHILD_OWNER="", CHILD_TABLE="control"
    P2C_VERB_PHRASE="", C2P_VERB_PHRASE="", 
    FK_CONSTRAINT="R_18", FK_COLUMNS="id_responsable" */
  IF
    /* %JoinPKPK(:%Old,:%New," <> "," OR ") */
    :old.id <> :new.id
  THEN
    SELECT count(*) INTO NUMROWS
      FROM control
      WHERE
        /*  %JoinFKPK(control,:%Old," = "," AND") */
        control.id_responsable = :old.id;
    IF (NUMROWS > 0)
    THEN 
      raise_application_error(
        -20005,
        'Cannot update responsables because control exists.'
      );
    END IF;
  END IF;

  /* erwin Builtin Trigger */
  /* responsables  control on parent update restrict */
  /* ERWIN_RELATION:CHECKSUM="00000000", PARENT_OWNER="", PARENT_TABLE="responsables"
    CHILD_OWNER="", CHILD_TABLE="control"
    P2C_VERB_PHRASE="", C2P_VERB_PHRASE="", 
    FK_CONSTRAINT="R_17", FK_COLUMNS="id_responsable" */
  IF
    /* %JoinPKPK(:%Old,:%New," <> "," OR ") */
    :old.id <> :new.id
  THEN
    SELECT count(*) INTO NUMROWS
      FROM control
      WHERE
        /*  %JoinFKPK(control,:%Old," = "," AND") */
        control.id_responsable = :old.id;
    IF (NUMROWS > 0)
    THEN 
      raise_application_error(
        -20005,
        'Cannot update responsables because control exists.'
      );
    END IF;
  END IF;


-- erwin Builtin Trigger
END;

/
ALTER TRIGGER "SERVICES"."TU_RESPONSABLES" ENABLE;
--------------------------------------------------------
--  Constraints for Table RESPONSABLES
--------------------------------------------------------

  ALTER TABLE "SERVICES"."RESPONSABLES" ADD CONSTRAINT "XPKRESPONSABLES" PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS"  ENABLE;
  ALTER TABLE "SERVICES"."RESPONSABLES" MODIFY ("ID" NOT NULL ENABLE);
--------------------------------------------------------
--  Constraints for Table SERVICIO_GENERAL
--------------------------------------------------------

  ALTER TABLE "SERVICES"."SERVICIO_GENERAL" ADD CONSTRAINT "XPKDESCRIPCION_GENERAL" PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS"  ENABLE;
  ALTER TABLE "SERVICES"."SERVICIO_GENERAL" MODIFY ("ID" NOT NULL ENABLE);
--------------------------------------------------------
--  Constraints for Table SERVICIO_ESPECIFICO
--------------------------------------------------------

  ALTER TABLE "SERVICES"."SERVICIO_ESPECIFICO" ADD CONSTRAINT "SERVICIO_ESPECIFICO_PK" PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS"  ENABLE;
  ALTER TABLE "SERVICES"."SERVICIO_ESPECIFICO" MODIFY ("ID_GENERAL" NOT NULL ENABLE);
  ALTER TABLE "SERVICES"."SERVICIO_ESPECIFICO" MODIFY ("ID" NOT NULL ENABLE);
--------------------------------------------------------
--  Constraints for Table CONTROL
--------------------------------------------------------

  ALTER TABLE "SERVICES"."CONTROL" ADD CONSTRAINT "CONTROL_PK" PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS"  ENABLE;
  ALTER TABLE "SERVICES"."CONTROL" MODIFY ("ID_RESPONSABLE" NOT NULL ENABLE);
  ALTER TABLE "SERVICES"."CONTROL" MODIFY ("ID_SERVICIO_ESPECIFICO" NOT NULL ENABLE);
  ALTER TABLE "SERVICES"."CONTROL" MODIFY ("ID_SERVICIO_GENERAL" NOT NULL ENABLE);
