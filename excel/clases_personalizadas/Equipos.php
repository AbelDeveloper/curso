<?PHP

class Equipos {

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
        if($condicion_imei_comparativa == '0') $where .= " AND ((IMEI_FISICO_1 IS NOT NULL AND eq.IMEI_LOGICO_1 IS NOT NULL) AND (IMEI_FISICO_1 != IMEI_LOGICO_1)) ";
        if($condicion_imei_comparativa == '1') $where .= " AND ((IMEI_FISICO_1 IS NOT NULL AND eq.IMEI_LOGICO_1 IS NOT NULL) AND (IMEI_FISICO_1 = IMEI_LOGICO_1)) ";
        if($condicion_imei_comparativa == '2') $where .= " AND ((IMEI_FISICO_1 IS NULL) OR (IMEI_LOGICO_1 IS NULL))";
        if($envio_codigo != '') $where .= " AND (de.CODIGO || '.' || op.CODIGO || '.' ||LPAD(eq.ITEM,6,'0')) = '" . $envio_codigo . "'";
        if($envio_mininte != '') $where .= " AND eq.FECHA_INGRESO_MININTER = '".$envio_mininte."'";
        //print_r($where);exit;
        $campos = ($select == array()) ? '*' : implode(", ", $select);
        $sql = "SELECT
                trunc(sysdate) - trunc(to_date(eq.FECHA_INGRESO_MININTER,'DD/MM/YY')) as diferencia_en_dias,
                eq.ID EQUIPO_ID,
                eq.USUARIO_ID,
                eq.ITEM,
                eq.IMEI_FISICO_1,
                eq.IMEI_FISICO_2,
                eq.IMEI_LOGICO_1,
                eq.IMEI_LOGICO_2,
                eq.ESTADO_ALMACEN ESTADO_ALMACEN,
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

        $conn = oci_connect('celulares', '12345', 'localhost/orcl');

        $stmt = oci_parse($conn,$sql);
        oci_execute($stmt, OCI_DEFAULT);

        $array = array();
        $i = 0;
        while ($row = oci_fetch_array($stmt, OCI_RETURN_NULLS+OCI_ASSOC)) {
            $array[$i] = $row;
            $i++;
        }
        return $array;
    }

    public function lista_almacen($modo, $select = array(), $condicion = array(), $order = '', $condicion_fecha = '', $condicion_imei_comparativa = '', $envio_codigo = '',$envio_mininte='') {

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
        if($condicion_imei_comparativa == '0') $where .= " AND ((IMEI_FISICO_1 IS NOT NULL AND eq.IMEI_LOGICO_1 IS NOT NULL) AND (IMEI_FISICO_1 != IMEI_LOGICO_1)) ";
        if($condicion_imei_comparativa == '1') $where .= " AND ((IMEI_FISICO_1 IS NOT NULL AND eq.IMEI_LOGICO_1 IS NOT NULL) AND (IMEI_FISICO_1 = IMEI_LOGICO_1)) ";
        if($condicion_imei_comparativa == '2') $where .= " AND ((IMEI_FISICO_1 IS NULL) OR (IMEI_LOGICO_1 IS NULL))";
        if($envio_codigo != '') $where .= " AND (de.CODIGO || '.' || op.CODIGO || '.' ||LPAD(eq.ITEM,6,'0')) = '" . $envio_codigo . "'";
        if($envio_mininte != '') $where .= " AND eq.FECHA_INGRESO_MININTER = '".$envio_mininte."'";
        //print_r($where);exit;
        $campos = ($select == array()) ? '*' : implode(", ", $select);
        $sql = "SELECT
                trunc(sysdate) - trunc(to_date(eq.FECHA_INGRESO_MININTER,'DD/MM/YY')) as diferencia_en_dias,
                eq.ID EQUIPO_ID,
                eq.USUARIO_ID,
                eq.ITEM,
                eq.IMEI_FISICO_1,
                eq.IMEI_FISICO_2,
                eq.IMEI_LOGICO_1,
                eq.IMEI_LOGICO_2,
                eq.ESTADO_ALMACEN ESTADO_ALMACEN,
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
                WHERE 1 = 1 and eq.ESTADO_ALMACEN=1 " . $where . " ORDER BY eq.ID DESC";

        $conn = oci_connect('celulares', '12345', 'localhost/orcl');

        $stmt = oci_parse($conn,$sql);
        oci_execute($stmt, OCI_DEFAULT);

        $array = array();
        $i = 0;
        while ($row = oci_fetch_array($stmt, OCI_RETURN_NULLS+OCI_ASSOC)) {
            $array[$i] = $row;
            $i++;
        }
        return $array;

    }

    public function lista_usuarios(){

      $sql = "SELECT * FROM USUARIOS";
      $conn = oci_connect('celulares', '12345', 'localhost/orcl');

      $stmt = oci_parse($conn,$sql);
      oci_execute($stmt, OCI_DEFAULT);

      $array = array();
      $i = 0;
      while ($row = oci_fetch_array($stmt, OCI_RETURN_NULLS+OCI_ASSOC)) {
          $array[$i] = $row;
          $i++;
      }
      return $array;


    }

    public function lista_2($imei_fisico_1,$condicion_fecha){
        $where = '';
        $select = array();
        if($condicion_fecha != '') $where .= " AND ".$condicion_fecha;
        if($imei_fisico_1 != '') $where .= " AND eq.IMEI_FISICO_1=".$imei_fisico_1;

        $campos = ($select == array()) ? '*' : implode(", ", $select);

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
                ubi.UBICACION_FISICA
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
                WHERE 1 = 1 " . $where . " ORDER BY eq.ID DESC";

        $conn = oci_connect('celulares', '12345', 'localhost/orcl');

        $stmt = oci_parse($conn,$sql);
        oci_execute($stmt, OCI_DEFAULT);

        $array = array();
        $i = 0;
        while ($row = oci_fetch_array($stmt, OCI_RETURN_NULLS+OCI_ASSOC)) {
            $array[$i] = $row;
            $i++;
        }
        return $array;
    }

}
