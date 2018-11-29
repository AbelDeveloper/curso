<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Equipos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function select_custo($id = ''){

        $where = "";
        if($id != '') $where = " AND eq.id = " . $id;

        $sql = "SELECT
                eq.ID EQUIPO_ID,
                eq.USUARIO_ID,
                eq.ITEM,
                eq.IMEI_FISICO_1,
                eq.IMEI_FISICO_2,
                eq.IMEI_LOGICO_1,
                eq.IMEI_LOGICO_2,
                eq.FECHA_REPORTE_OPERADOR,
                eq.FECHA_INGRESO_MININTER,
                eq.OSIPTEL_ESTADO_ID,
                eq.DEPARTAMENTO_ORIGEN_ID,
                eq.OPERADOR_REPORTANTE_ID,
                eq.MOTIVO_UPDATE,
                mo.ID modelo_id,
                mo.MODELO MODELO,
                ma.ID marca_id,
                ma.MARCA MARCA,
                col.ID color_id,
                col.COLOR COLOR,
                op.id operado_id,
                op.OPERADOR OPERADOR,
                op.CODIGO CODIGO_OPERADOR,
                osi.OSIPTEL_ESTADO,
                de.DEPARTAMENTO DEPARTAMENTO,
                de.CODIGO CODIGO_DEPARTAMENTO,
                ino.CONSERVACION_ESTADO_ID,
                ino.OBSERVACION_INOPERATIVIDAD,
                ino.id OBSERVACION_INOPERATIVIDAD_ID
                FROM equipos eq
                INNER JOIN OBSERVACION_INOPERATIVIDADES ino
                ON ino.id = eq.OBSERVACION_INOPERATIVIDAD_ID
                INNER JOIN conservacion_estados co
                ON ino.CONSERVACION_ESTADO_ID = co.id
                INNER JOIN colores col
                ON eq.color_id = col.id
                INNER JOIN departamentos de
                ON de.id = eq.DEPARTAMENTO_ORIGEN_ID
                INNER JOIN MODELOS mo
                ON mo.id = eq.MODELO_ID
                INNER JOIN MARCAS ma
                ON ma.id = mo.MARCA_ID
                INNER JOIN OPERADORES op
                ON op.id = eq.OPERADOR_REPORTANTE_ID
                INNER JOIN osiptel_estados osi
                ON osi.id = eq.OSIPTEL_ESTADO_ID
                WHERE 1 = 1 " . $where;
//echo $sql;exit;
        $query = $this->db->query($sql);

        $rows = array();
        foreach ($query->result_array() as $row) {
            $rows[] = $row;
        }
      return $rows;
        //print_r($rows);
    }

    public function lista($modo, $select = array(), $condicion = array(), $order = '', $condicion_fecha = '', $condicion_imei_comparativa = '', $envio_codigo = '',$envio_mininte='') {

        if ($select == '')
            $select = array();
        if ($condicion == '')
            $condicion = array();

        $where = '';
        foreach ($condicion as $key => $value) {
            if ($value == 'IS NULL') {
                $where .= " AND $key " . $value;
            } else {
                $where .= " AND $key = '" . $value . "' ";
            }
        }

        if($condicion_fecha != '') $where .= " AND ".$condicion_fecha;
        if($condicion_imei_comparativa == '0') $where .= " AND ((IMEI_FISICO_1 IS NOT NULL AND IMEI_LOGICO_1 IS NOT NULL) AND (IMEI_FISICO_1 != IMEI_LOGICO_1)) ";
        if($condicion_imei_comparativa == '1') $where .= " AND ((IMEI_FISICO_1 IS NOT NULL AND IMEI_LOGICO_1 IS NOT NULL) AND (IMEI_FISICO_1 = IMEI_LOGICO_1)) ";
        if($condicion_imei_comparativa == '2') $where .= " AND ((IMEI_FISICO_1 IS NULL) OR (IMEI_LOGICO_1 IS NULL))";
        if($envio_codigo != '') $where .= " AND (de.CODIGO || '.' || op.CODIGO || '.' ||LPAD(eq.ITEM,6,'0')) = '" . $envio_codigo . "'";
        if($envio_mininte != '') $where .= " AND eq.FECHA_INGRESO_MININTER = '".$envio_mininte."'";

    //print_r($where);

        $campos = ($select == array()) ? '*' : implode(", ", $select);
        $sql = "SELECT
                CASE
                  when (ESTADO_ALMACEN = 0) then ''
                  when (ESTADO_ALMACEN = 1) then caj.caja
                  when (ESTADO_ALMACEN = 2) then 'SAL'
                END AS ESTADO_ALMACENAJE,
                eq.ESTADO_ALMACEN ESTADO_ALMACEN,
                trunc(sysdate) - trunc(to_date(eq.FECHA_INGRESO_MININTER,'DD/MM/YY')) as diferencia_en_dias,
                eq.ID EQUIPO_ID,
                eq.USUARIO_ID,
                eq.ITEM,
                eq.IMEI_FISICO_1,
                eq.IMEI_FISICO_2,
                eq.IMEI_LOGICO_1,
                eq.IMEI_LOGICO_2,
                TO_CHAR(eq.FECHA_REPORTE_OPERADOR, 'DD-MM-YYYY') as FECHA_REPORTE_OPERADOR,
                TO_CHAR(eq.FECHA_INGRESO_MININTER, 'DD-MM-YYYY') as FECHA_INGRESO_MININTER,
                TO_CHAR(eq.FECHA_INSERT, 'DD-MM-YYYY HH24:MI:SS') as FECHA_INSERT,
                eq.MOTIVO_UPDATE MOTIVO_UPDATE_EQUIPO,
                usu.APELLIDO_PATERNO,
                usu.APELLIDO_MATERNO,
                usu.NOMBRES,
                usu.USUARIO,
                de.CODIGO || '.' || op.CODIGO || '.' ||LPAD(eq.ITEM,6,'0') CODIGO,
                mo.ID MODELO_ID,
                mo.MODELO MODELO,
                ma.ID marca_id,
                ma.MARCA MARCA,
                co.ID color_id,
                co.COLOR COLOR,
                op.id operado_id,
                op.OPERADOR OPERADOR,
                osi.OSIPTEL_ESTADO,
                de.DEPARTAMENTO DEPARTAMENTO,
                ent.ID ENTREGANTE_ID,
                ent.NOMBRES,
                ent.NUMERO_DOCUMENTO,
                ent.TELEFONO,
                ent.ANIO,
                ent.SEXO,
                ent.MOTIVO_UPDATE MOTIVO_UPDATE_ENTREGANTE,
                ete.ENTIDAD ENTIDAD,
                dis.DISTRITO,
                ino.CONSERVACION_ESTADO_ID,
                ino.OBSERVACION_INOPERATIVIDAD,
                tdc.TIPO_DOCUMENTO,
                tdc.id TIPO_DOCUMENTO_ID,
                coe.CONSERVACION_ESTADO,
                ubi.UBICACION_FISICA,
                caj.CAJA CAJA,
                caj.ARMARIO_ID ARMARIO_ID,
                eg.TIPO_DEVOLUCION TIPO_DEVOLUCION,
                eg.EMPLEADO_DEVOLUCION EMPLEADO_DEVOLUCION,
                eg.FECHA_DEVOLUCION FECHA_DEVOLUCION,
                cae.FECHA_INSERT FECHA_ALMACENADO
                FROM equipos eq
                INNER JOIN OBSERVACION_INOPERATIVIDADES ino
                ON ino.id = eq.OBSERVACION_INOPERATIVIDAD_ID
                INNER JOIN usuarios usu
                ON usu.id = eq.USUARIO_ID
                INNER JOIN conservacion_estados coe
                ON ino.CONSERVACION_ESTADO_ID = coe.id
                INNER JOIN colores co
                ON eq.color_id = co.id
                INNER JOIN departamentos de
                ON de.id = eq.DEPARTAMENTO_ORIGEN_ID
                INNER JOIN MODELOS mo
                ON mo.id = eq.MODELO_ID
                INNER JOIN MARCAS ma
                ON ma.id = mo.MARCA_ID
                INNER JOIN OPERADORES op
                ON op.id = eq.OPERADOR_REPORTANTE_ID
                INNER JOIN osiptel_estados osi
                ON osi.id = eq.OSIPTEL_ESTADO_ID
                LEFT JOIN entregantes ent
                ON eq.id = ent.EQUIPO_ID
                LEFT JOIN UBICACION_FISICAS ubi
                ON ubi.ID = ent.UBICACION_FISICA_ID
                LEFT JOIN tipo_documentos tdc
                ON tdc.id = ent.tipo_documento_id
                LEFT JOIN ENTIDAD_ENTREGANTES ete
                ON ete.ID = ent.ENTIDAD_ENTREGANTE_ID
                LEFT JOIN DISTRITOS dis
                ON dis.ID = ent.DISTRITO_ID
                LEFT JOIN caja_equipos cae ON cae.equipo_id = eq.id
                LEFT JOIN cajas caj ON caj.id = cae.caja_id
                LEFT JOIN EGRESADOS eg ON eg.EQUIPO_ID = eq.ID
                WHERE 1 = 1 " . $where . " ORDER BY eq.ID DESC";
        //echo $sql;exit;
        $query = $this->db->query($sql);

        switch ($modo) {
            case '1':
                $resultado = '';
                if ($query->num_rows() > 0) {
                    $row = $query->row_array();
                    $resultado = $row[$campos];
                }
                return $resultado;

            case '2':
                $row = array();
                if ($query->num_rows() > 0) {
                    $row = $query->row_array();
                }
                return $row;

            case '3':
                $rows = array();
                foreach ($query->result_array() as $row) {
                    $rows[] = $row;
                }
                return $rows;
        }
    }

    public function lista_x_archivo($imeis){


        $sql = "SELECT
                CASE
                  when (ESTADO_ALMACEN = 0) then ''
                  when (ESTADO_ALMACEN = 1) then caj.caja
                  when (ESTADO_ALMACEN = 2) then 'SAL'
                END AS ESTADO_ALMACENAJE,
                trunc(sysdate) - trunc(to_date(eq.FECHA_INGRESO_MININTER,'DD/MM/YY')) as diferencia_en_dias,
                eq.ID EQUIPO_ID,
                eq.USUARIO_ID,
                eq.ITEM,
                eq.IMEI_FISICO_1,
                eq.IMEI_FISICO_2,
                eq.IMEI_LOGICO_1,
                eq.IMEI_LOGICO_2,
                TO_CHAR(eq.FECHA_REPORTE_OPERADOR, 'DD-MM-YYYY') as FECHA_REPORTE_OPERADOR,
                TO_CHAR(eq.FECHA_INGRESO_MININTER, 'DD-MM-YYYY') as FECHA_INGRESO_MININTER,
                TO_CHAR(eq.FECHA_INSERT, 'DD-MM-YYYY HH24:MI:SS') as FECHA_INSERT,
                eq.MOTIVO_UPDATE MOTIVO_UPDATE_EQUIPO,
                usu.APELLIDO_PATERNO,
                usu.APELLIDO_MATERNO,
                usu.NOMBRES,
                usu.USUARIO,
                de.CODIGO || '.' || op.CODIGO || '.' ||LPAD(eq.ITEM,6,'0') CODIGO,
                mo.ID MODELO_ID,
                mo.MODELO MODELO,
                ma.ID marca_id,
                ma.MARCA MARCA,
                co.ID color_id,
                co.COLOR COLOR,
                op.id operado_id,
                op.OPERADOR OPERADOR,
                osi.OSIPTEL_ESTADO,
                de.DEPARTAMENTO DEPARTAMENTO,
                ent.ID ENTREGANTE_ID,
                ent.NOMBRES,
                ent.NUMERO_DOCUMENTO,
                ent.TELEFONO,
                ent.ANIO,
                ent.SEXO,
                ent.MOTIVO_UPDATE MOTIVO_UPDATE_ENTREGANTE,
                ete.ENTIDAD ENTIDAD,
                dis.DISTRITO,
                ino.CONSERVACION_ESTADO_ID,
                ino.OBSERVACION_INOPERATIVIDAD,
                tdc.TIPO_DOCUMENTO,
                tdc.id TIPO_DOCUMENTO_ID,
                coe.CONSERVACION_ESTADO,
                ubi.UBICACION_FISICA,
                caj.CAJA CAJA
                FROM equipos eq
                INNER JOIN OBSERVACION_INOPERATIVIDADES ino
                ON ino.id = eq.OBSERVACION_INOPERATIVIDAD_ID
                INNER JOIN usuarios usu
                ON usu.id = eq.USUARIO_ID
                INNER JOIN conservacion_estados coe
                ON ino.CONSERVACION_ESTADO_ID = coe.id
                INNER JOIN colores co
                ON eq.color_id = co.id
                INNER JOIN departamentos de
                ON de.id = eq.DEPARTAMENTO_ORIGEN_ID
                INNER JOIN MODELOS mo
                ON mo.id = eq.MODELO_ID
                INNER JOIN MARCAS ma
                ON ma.id = mo.MARCA_ID
                INNER JOIN OPERADORES op
                ON op.id = eq.OPERADOR_REPORTANTE_ID
                INNER JOIN osiptel_estados osi
                ON osi.id = eq.OSIPTEL_ESTADO_ID
                LEFT JOIN entregantes ent
                ON eq.id = ent.EQUIPO_ID
                LEFT JOIN UBICACION_FISICAS ubi
                ON ubi.ID = ent.UBICACION_FISICA_ID
                LEFT JOIN tipo_documentos tdc
                ON tdc.id = ent.tipo_documento_id
                LEFT JOIN ENTIDAD_ENTREGANTES ete
                ON ete.ID = ent.ENTIDAD_ENTREGANTE_ID
                LEFT JOIN DISTRITOS dis
                ON dis.ID = ent.DISTRITO_ID
                LEFT JOIN caja_equipos cae ON cae.equipo_id = eq.id
                LEFT JOIN cajas caj ON caj.id = cae.caja_id
                WHERE 1 = 1 " . $where . " ORDER BY eq.ID DESC";

        $query = $this->db->query($sql);

                $rows = array();
                foreach ($query->result_array() as $row) {
                    $rows[] = $row;
                }
                return $rows;

    }

    public function lista_excel_almacen($imei_fisico_1,$fecha_inicio,$fecha_final) {

        $where= '';
        if($imei_fisico_1!=''){$where.= " AND eq.IMEI_FISICO_1=".$imei_fisico_1;}
        if($fecha_inicio!='' and $fecha_final!=''){$where.= " AND eq.FECHA_INSERT BETWEEN TO_DATE ('".$fecha_inicio."', 'dd/mm/yyyy HH24:MI:SS') AND TO_DATE ('".$fecha_final."', 'dd/mm/yyyy HH24:MI:SS')";}
        $sql = "SELECT

                trunc(sysdate) - trunc(to_date(eq.FECHA_INGRESO_MININTER,'DD/MM/YY')) as diferencia_en_dias,
                eq.ID EQUIPO_ID,
                eq.USUARIO_ID,
                eq.ITEM,
                eq.IMEI_FISICO_1,
                eq.IMEI_FISICO_2,
                eq.IMEI_LOGICO_1,
                eq.IMEI_LOGICO_2,
                TO_CHAR(eq.FECHA_REPORTE_OPERADOR, 'DD-MM-YYYY') as FECHA_REPORTE_OPERADOR,
                TO_CHAR(eq.FECHA_INGRESO_MININTER, 'DD-MM-YYYY') as FECHA_INGRESO_MININTER,
                TO_CHAR(eq.FECHA_INSERT, 'DD-MM-YYYY HH24:MI:SS') as FECHA_INSERT,
                eq.MOTIVO_UPDATE MOTIVO_UPDATE_EQUIPO,
                usu.APELLIDO_PATERNO,
                usu.APELLIDO_MATERNO,
                usu.NOMBRES,
                usu.USUARIO,
                de.CODIGO || '.' || op.CODIGO || '.' ||LPAD(eq.ITEM,6,'0') CODIGO,
                mo.ID MODELO_ID,
                mo.MODELO MODELO,
                ma.ID marca_id,
                ma.MARCA MARCA,
                co.ID color_id,
                co.COLOR COLOR,
                op.id operado_id,
                op.OPERADOR OPERADOR,
                osi.OSIPTEL_ESTADO,
                de.DEPARTAMENTO DEPARTAMENTO,
                ent.ID ENTREGANTE_ID,
                ent.NOMBRES,
                ent.NUMERO_DOCUMENTO,
                ent.TELEFONO,
                ent.ANIO,
                ent.SEXO,
                ent.MOTIVO_UPDATE MOTIVO_UPDATE_ENTREGANTE,
                ete.ENTIDAD ENTIDAD,
                dis.DISTRITO,
                ino.CONSERVACION_ESTADO_ID,
                ino.OBSERVACION_INOPERATIVIDAD,
                tdc.TIPO_DOCUMENTO,
                tdc.id TIPO_DOCUMENTO_ID,
                coe.CONSERVACION_ESTADO,
                ubi.UBICACION_FISICA,
                caj.CAJA CAJA
                FROM equipos eq
                INNER JOIN OBSERVACION_INOPERATIVIDADES ino
                ON ino.id = eq.OBSERVACION_INOPERATIVIDAD_ID
                INNER JOIN usuarios usu
                ON usu.id = eq.USUARIO_ID
                INNER JOIN conservacion_estados coe
                ON ino.CONSERVACION_ESTADO_ID = coe.id
                INNER JOIN colores co
                ON eq.color_id = co.id
                INNER JOIN departamentos de
                ON de.id = eq.DEPARTAMENTO_ORIGEN_ID
                INNER JOIN MODELOS mo
                ON mo.id = eq.MODELO_ID
                INNER JOIN MARCAS ma
                ON ma.id = mo.MARCA_ID
                INNER JOIN OPERADORES op
                ON op.id = eq.OPERADOR_REPORTANTE_ID
                INNER JOIN osiptel_estados osi
                ON osi.id = eq.OSIPTEL_ESTADO_ID
                LEFT JOIN entregantes ent
                ON eq.id = ent.EQUIPO_ID
                LEFT JOIN UBICACION_FISICAS ubi
                ON ubi.ID = ent.UBICACION_FISICA_ID
                LEFT JOIN tipo_documentos tdc
                ON tdc.id = ent.tipo_documento_id
                LEFT JOIN ENTIDAD_ENTREGANTES ete
                ON ete.ID = ent.ENTIDAD_ENTREGANTE_ID
                LEFT JOIN DISTRITOS dis
                ON dis.ID = ent.DISTRITO_ID
                LEFT JOIN caja_equipos cae ON cae.equipo_id = eq.id
                LEFT JOIN cajas caj ON caj.id = cae.caja_id
                WHERE 1 = 1 " . $where . " ORDER BY eq.ID DESC";
        //echo $sql;exit;
               $query = $this->db->query($sql);


                $rows = array();
                foreach ($query->result_array() as $row) {
                    $rows[] = $row;
                }

                return $rows;

    }

    public function lista__2($id = '', $usuario_id = ''){

        $where = "";
        if($id != '') $where = " AND eq.id = " . $id;
        if($usuario_id != '') $where = " AND eq.USUARIO_ID = " . $usuario_id;

        $sql = "SELECT
                eq.ID EQUIPO_ID,
                eq.MODELO MODELO,
                eq.USUARIO_ID,
                eq.ITEM,
                eq.IMEI_FISICO_1,
                eq.IMEI_FISICO_2,
                eq.IMEI_LOGICO_1,
                eq.IMEI_LOGICO_2,
                eq.FECHA_REPORTE_OPERADOR,
                eq.FECHA_INGRESO_MININTER,
                ma.ID marca_id,
                ma.MARCA MARCA,
                co.ID color_id,
                co.COLOR COLOR,
                op.id operado_id,
                op.OPERADOR OPERADOR,
                osi.OSIPTEL_ESTADO,
                de.DEPARTAMENTO DEPARTAMENTO,
                ent.ID ENTREGANTE_ID,
                ent.DNI,
                ent.NOMBRES,
                ent.TELEFONO,
                ent.ANIO,
                ete.ENTIDAD ENTIDAD,
                dis.DISTRITO
                FROM equipos eq
                INNER JOIN conservacion_estados co
                ON eq.CONSERVACION_ESTADO_ID = co.id
                INNER JOIN colores co
                ON eq.color_id = co.id
                INNER JOIN departamentos de
                ON de.id = eq.DEPARTAMENTO_ORIGEN_ID
                INNER JOIN MARCAS ma
                ON ma.id = eq.MARCA_ID
                INNER JOIN OPERADORES op
                ON op.id = eq.OPERADOR_REPORTANTE_ID
                INNER JOIN osiptel_estados osi
                ON osi.id = eq.OSIPTEL_ESTADO_ID
                INNER JOIN entregantes ent
                ON eq.id = ent.EQUIPO_ID
                INNER JOIN ENTIDAD_ENTREGANTES ete
                ON ete.ID = ent.ENTIDAD_ENTREGANTE_ID
                INNER JOIN DISTRITOS dis
                ON dis.ID = ent.DISTRITO_ID
                WHERE 1 = 1 " . $where . " ORDER BY eq.ID DESC";
//echo $sql;exit;
        $query = $this->db->query($sql);

        $rows = array();
        foreach ($query->result_array() as $row) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function detalle($ID){
        $sql = "SELECT
                eq.ID EQUIPO_ID,
                eq.USUARIO_ID,
                eq.ITEM,
                eq.IMEI_FISICO_1,
                eq.IMEI_FISICO_2,
                eq.IMEI_LOGICO_1,
                eq.IMEI_LOGICO_2,
                eq.FECHA_REPORTE_OPERADOR,
                eq.FECHA_INGRESO_MININTER,
                eq.FECHA_INSERT,
                de.CODIGO || '.' || op.CODIGO || '.' ||LPAD(eq.ITEM,6,'0') CODIGO,
                co.CONSERVACION_ESTADO CONSERVACION_ESTADO,
                mo.ID MODELO_ID,
                mo.MODELO MODELO,
                ma.ID marca_id,
                ma.MARCA MARCA,
                co.ID color_id,
                co.COLOR COLOR,
                op.id operado_id,
                op.OPERADOR OPERADOR,
                osi.OSIPTEL_ESTADO,
                de.DEPARTAMENTO DEPARTAMENTO,
                ent.ID ENTREGANTE_ID,
                ent.NUMERO_DOCUMENTO,
                ent.NOMBRES ENT_NOMBRES,
                ent.SEXO ENT_SEXO,
                ent.ANIO ENT_ANIO,
                ent.TELEFONO ENT_TELEFONO,
                een.ENTIDAD ENTIDAD,
                dis.DISTRITO,
                usu.APELLIDO_PATERNO,
                usu.APELLIDO_MATERNO,
                usu.NOMBRES,
                ino.CONSERVACION_ESTADO_ID,
                ino.OBSERVACION_INOPERATIVIDAD,
                ubi.UBICACION_FISICA,
                tdc.TIPO_DOCUMENTO,
                tdc.id TIPO_DOCUMENTO_ID
                FROM equipos eq
                INNER JOIN OBSERVACION_INOPERATIVIDADES ino
                ON ino.id = eq.OBSERVACION_INOPERATIVIDAD_ID
                INNER JOIN conservacion_estados co
                ON ino.CONSERVACION_ESTADO_ID = co.id
                INNER JOIN colores co
                ON eq.color_id = co.id
                INNER JOIN departamentos de
                ON de.id = eq.DEPARTAMENTO_ORIGEN_ID
                INNER JOIN MODELOS mo
                ON mo.id = eq.MODELO_ID
                INNER JOIN MARCAS ma
                ON ma.id = mo.MARCA_ID
                INNER JOIN OPERADORES op
                ON op.id = eq.OPERADOR_REPORTANTE_ID
                INNER JOIN osiptel_estados osi
                ON osi.id = eq.OSIPTEL_ESTADO_ID
                LEFT JOIN entregantes ent
                ON eq.id = ent.EQUIPO_ID
                LEFT JOIN tipo_documentos tdc
                ON tdc.id = ent.tipo_documento_id
                LEFT JOIN usuarios usu
                ON usu.id = eq.USUARIO_ID
                LEFT JOIN distritos dis
                ON dis.ID = ent.DISTRITO_ID
                LEFT JOIN entidad_entregantes een
                ON een.ID = ent.ENTIDAD_ENTREGANTE_ID
                LEFT JOIN UBICACION_FISICAS ubi
                ON ubi.ID = ent.UBICACION_FISICA_ID
                WHERE eq.ID = " . $ID . " ORDER BY eq.ID DESC";
        $query = $this->db->query($sql);

        return $query->row_array();

    }

    public function select_max_id(){
        $sql = "select max(id) id from equipos";
        //echo $sql;exit;
        $query = $this->db->query($sql);

        $resultado = '';
        $row = $query->row_array();
        $resultado = $row['ID'];
        return $resultado;
    }

    // $modo: 1 = campo (1 solo campo), 2 = registro (mas de un campo), 2 = tabla (mas de 1 registro)
    public function select($modo, $select = array(), $condicion = array(), $order = '') {

        if ($select == '')
            $select = array();
        if ($condicion == '')
            $condicion = array();

        $where = '';
        foreach ($condicion as $key => $value) {
            if ($value == 'IS NULL') {
                $where .= " AND $key " . $value;
            } else {
                $where .= " AND $key = '" . $value . "' ";
            }
        }

        $campos = ($select == array()) ? '*' : implode(", ", $select);
        $sql = "SELECT " . $campos . " FROM EQUIPOS WHERE 1 = 1 " . $where . " " . $order;
        $query = $this->db->query($sql);

        switch ($modo) {
            case '1':
                $resultado = '';
                if ($query->num_rows() > 0) {
                    $row = $query->row_array();
                    $resultado = $row[$campos];
                }
                return $resultado;

            case '2':
                $row = array();
                if ($query->num_rows() > 0) {
                    $row = $query->row_array();
                }
                return $row;

            case '3':
                $rows = array();
                foreach ($query->result_array() as $row) {
                    $rows[] = $row;
                }
                return $rows;
        }
    }

    public function insert($data) {
        $this->db->insert('EQUIPOS', $data);
        $this->session->set_flashdata('mensaje', 'Ingresado correctamente.');
    }

    public function update($data, $where, $mensaje = '') {
        $this->db->where('ID', $where);
        $this->db->update('EQUIPOS', $data);
        if ($mensaje == '') {
            $mensaje = 'Modificado correctamente.';
        }
        //echo $this->db->last_query();exit;
        $this->session->set_flashdata('mensaje', $mensaje);
    }

    public function filas(){
        $sql = "select count(id) FILAS from equipos";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row['FILAS'];
    }

    public function selectValidation($IMEI_FISICO = ''){

        $sql = "SELECT ID FROM equipos WHERE IMEI_FISICO_1 = '$IMEI_FISICO' OR IMEI_FISICO_2 = '$IMEI_FISICO'";
        $query = $this->db->query($sql);
        $resultado = '';
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            $resultado = $row['ID'];
        }
        return $resultado;

    }

    public function equiposPorCarga($carga_id){
            $sql = "SELECT COUNT(ID) FILAS FROM EQUIPOS WHERE CARGA_ID = " . $carga_id;
            //echo $sql;exit;
            $query = $this->db->query($sql);

            $row = $query->row_array();
            return $row['FILAS'];
    }

    public function updateCarga($condicion = array()) {
        $cadena = '';
        foreach ($condicion as $value) {
                $cadena .= $value.",";
        }
        $cadena = substr($cadena, 0, -1);
        $sql = "UPDATE EQUIPOS SET ESTADO_ALMACEN = 1 WHERE ID IN ( ". $cadena." ) ";
        $query = $this->db->query($sql);
    }

    public function generarCodigo(){
        $sql = "SELECT CAJA FROM CAJAS WHERE cantidad <=34 and rownum = 1 order by id";
        $query = $this->db->query($sql);

        $resultado = '';
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            $resultado = $row['CAJA'];
        }
        return $resultado;
    }

    public function select_one($equipo_id){
         $sql = "SELECT * FROM EQUIPOS WHERE ID=".$equipo_id;
         $query = $this->db->query($sql);
         $row = $query->row_array();
         return $row;
    }

    public function select_one_2($equipo_imei){
         $sql = "SELECT eq.ID ID,
                        eq.IMEI_FISICO_1 IMEI_FISICO_1,
                        eq.IMEI_LOGICO_1 IMEI_LOGICO_1,
                        caj.CAJA CAJA,
                        e.UBICACION_FISICA_ID UBICACION
                        FROM EQUIPOS eq
                        INNER JOIN ENTREGANTES e ON eq.ID=e.EQUIPO_ID
                        INNER JOIN CAJA_EQUIPOS ceq ON eq.ID=ceq.EQUIPO_ID
                        INNER JOIN CAJAS caj ON ceq.CAJA_ID=caj.ID

                        WHERE eq.IMEI_FISICO_1=".$equipo_imei;
         $query = $this->db->query($sql);
         $row = $query->row_array();
         return $row;
    }

    public function select_estado($equipo_id){
         $sql = "SELECT * FROM EQUIPOS e INNER JOIN OBSERVACION_INOPERATIVIDADES o ON o.ID=e.OBSERVACION_INOPERATIVIDAD_ID INNER JOIN CONSERVACION_ESTADOS c ON c.ID=o.CONSERVACION_ESTADO_ID WHERE e.ID=".$equipo_id;
         $query = $this->db->query($sql);
         $row = $query->row_array();
         return $row;
    }




}
