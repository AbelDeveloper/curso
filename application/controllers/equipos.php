<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Equipos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Lima');
        $this->load->model('usuarios_model');
        $this->load->model('conservacion_estados_model');
        $this->load->model('marcas_model');
        $this->load->model('operadores_model');
        $this->load->model('osiptel_estados_model');
        $this->load->model('departamentos_model');
        $this->load->model('distritos_model');
        $this->load->model('equipos_model');
        $this->load->model('entidad_entregantes_model');
        $this->load->model('colores_model');
        $this->load->model('cargas_model');
        $this->load->model('ubicacion_fisicas_model');
        $this->load->model('imei_comparativa_model');
        $this->load->model('modelos_model');
        $this->load->model('entregantes_model');
        $this->load->model('observacion_inoperatividades_model');
        $this->load->model('cajas_model');

        $this->load->model('caja_equipos_model');
        $this->load->helper('url');
        $this->load->helper('ayuda');
        $this->load->library('export_excel');
    }

    public function index() {

        $array = array();
        $condicion_fecha = '';
        $condicion_imei_comparativa = '';
        $envio_codigo = '';
        $usuario_seleccionado = $this->session->userdata('empleado_id');
        if ($_POST) {
            $array = ($_POST['IMEI_FISICO_1'] != '') ? array('IMEI_FISICO_1' => $_POST['IMEI_FISICO_1']) : array();
            if ($_POST['OPERADOR_REPORTANTE'] != '')
                $array = array_merge($array, array('OPERADOR_REPORTANTE_ID' => $_POST['OPERADOR_REPORTANTE']));
            if ($_POST['OSIPTEL_ESTADOS'] != '')
                $array = array_merge($array, array('OSIPTEL_ESTADO_ID' => $_POST['OSIPTEL_ESTADOS']));
            if ($_POST['color'] != '')
                $array = array_merge($array, array('COLOR_ID' => $_POST['color']));
            if ($_POST['MARCA'] != '')
                $array = array_merge($array, array('MARCA_ID' => $_POST['MARCA']));
            if ($_POST['UBICACION_FISICA'] != '')
                $array = array_merge($array, array('UBICACION_FISICA_ID' => $_POST['UBICACION_FISICA']));
            if ($_POST['CONSERVACION_ESTADO'] != '')
                $array = array_merge($array, array('CONSERVACION_ESTADO_ID' => $_POST['CONSERVACION_ESTADO']));
            if ($_POST['ENTIDAD_ENTREGANTES'] != '')
                $array = array_merge($array, array('ENTIDAD_ENTREGANTE_ID' => $_POST['ENTIDAD_ENTREGANTES']));
            if ($_POST['USUARIOS'] != '')
                $array = array_merge($array, array('USUARIO_ID' => $_POST['USUARIOS']));
            if ($_POST['USUARIOS_D'] != '')
                $array = array_merge($array, array('EMPLEADO_DEVOLUCION' => $_POST['USUARIOS_D']));
                $usuario_seleccionado = $_POST['USUARIOS'];
            if (($_POST['datetimepicker_inicio'] != '') && ($_POST['datetimepicker_fin'] != ''))
                $condicion_fecha = " eq.FECHA_INSERT BETWEEN TO_DATE ('" . $_POST['datetimepicker_inicio'] . "', 'dd/mm/yyyy HH24:MI:SS') AND TO_DATE ('" . $_POST['datetimepicker_fin'] . "', 'dd/mm/yyyy HH24:MI:SS')";
            if ($_POST['IMEI_COMPARATIVA'] != '')
                $condicion_imei_comparativa = $_POST['IMEI_COMPARATIVA'];
            if ($_POST['CODIGO'] != '')
                $envio_codigo = $_POST['CODIGO'];
            if ($_POST['datetimepicker_mininte'] != ''){
                $time = strtotime($_POST['datetimepicker_mininte']);
                $newformat = date('d/M/y',$time);
                $envio_mininte = $newformat;
            }else{
                $envio_mininte = '';
            }

            //////USUARIO SELECCIONADO////
            if ($_POST['USUARIOS'] != ''){
              $usuario_seleccionado = $_POST['USUARIOS'];
            }

             /*if (($_POST['fecha_carga'] != ''))
                $condicion_fecha_carga = " eq.FECHA_REPORTE_OPERADOR BETWEEN TO_DATE ('" . $_POST['fecha_carga'] . "', 'dd/mm/yyyy') AND TO_DATE ('" . $_POST['fecha_carga'] . "', 'dd/mm/yyyy')";*/
        }

        $data['equipos'] = array();
        if($_POST){
          // if ($this->session->userdata('nivel') == 1) {//administrador
                $data['equipos'] = $this->equipos_model->lista(3, '', $array, '', $condicion_fecha, $condicion_imei_comparativa, $envio_codigo,$envio_mininte);
                //print_r(count($data['equipos']));
                //var_dump($data['equipos']);exit;
           //} else {
          //      $array_basico = array('USUARIO_ID' => $this->session->userdata('empleado_id'));
          //     $array_where = (count($array) > 0) ? array_merge($array_basico, $array) : $array_basico;

          //      $data['equipos'] = $this->equipos_model->lista(3, '', $array_where, '', $condicion_fecha, $condicion_imei_comparativa, $envio_codigo,$envio_mininte);
                //var_dump($data['equipos']);exit;
          //  }

          //  $where = ($this->session->userdata('nivel') == 1) ? $array : $array_where;

          //$data['param1'] = base64_encode(serialize($where));
            $data['param2'] = $condicion_fecha;
            $data['param3'] = $condicion_imei_comparativa;
            $data['param4'] = $envio_codigo;
        }

        $data['carga_activa'] = $this->cargas_model->select(1, array('ID'), array('USUARIO_ID' => $this->session->userdata('empleado_id'), 'ACTIVO_ID' => 1));
        $data['operador_reportante'] = $this->operadores_model->select(3);
        $data['osiptel_estados'] = $this->osiptel_estados_model->select(3);
        $data['colores'] = $this->colores_model->select(3);
        $data['marcas'] = $this->marcas_model->select(3);
        $data['UBICACION_FISICA'] = $this->ubicacion_fisicas_model->select(3);
        $data['CONSERVACION_ESTADO'] = $this->conservacion_estados_model->select(3);
        $data['entidad_entregantes'] = $this->entidad_entregantes_model->select(3);
        $where = ($this->session->userdata('nivel') == 1) ? array('nivel' => 2) : array('ID' => $this->session->userdata('empleado_id'));
        //$data['usuarios'] = $this->usuarios_model->select(3, '', $where);
        $data['usuarios'] = $this->usuarios_model->select(3, '', '');
        $data['imei_comparativa'] = $this->imei_comparativa_model->select();
        //print_r($data['imei_comparativa']);
        if($data['carga_activa']!=''){
            $sql = "SELECT * FROM CARGAS WHERE ID=".$data['carga_activa'];
            $query = $this->db->query($sql);
            $row = $query->row_array();

            $time = strtotime($row['FECHA']);
            $newformat = date('d-m-Y',$time);
            $data['fecha_carga'] = $newformat;

        }else{
            $data['fecha_carga'] = '';
        }

        $this->session->set_userdata('menu',1);
        $data['usuario_seleccionado'] = $usuario_seleccionado;

        $this->usuarios_model->menuGeneral();
        $this->load->view('equipos/index', $data);
        $this->load->view('templates/footer');
    }

    public function generarCodigoAlmacen(){
        $pagina = $_POST['pagina'];

        $data['carga_activa'] = $this->cargas_model->select(1, array('ID'), array('USUARIO_ID' => $this->session->userdata('empleado_id'), 'ACTIVO_ID' => 1));

        $param1 = unserialize(base64_decode($_POST['param1']));
        $param1 = array_merge($param1, array('ESTADO_ALMACEN' => '0'));
        $param2 = $_POST['param2'];
        $param3 = $_POST['param3'];
        $param4 = $_POST['param4'];

        $data['equipos'] = $this->equipos_model->lista(3, '', $param1, '', $param2, $param3, $param4);

        $this->usuarios_model->menuGeneral();

        if($pagina=='1'){
            $this->load->view('equipos/verAlmacen', $data);
        }else if($pagina=='2'){
            $this->load->view('equipos/generarCodigoAlmacen', $data);
        }

        $this->load->view('templates/footer');
    }

    public function verAlmacen() {

        $array = array();
        $condicion_fecha = '';
        $condicion_imei_comparativa = '';
        $envio_codigo = '';
        $usuario_seleccionado = $this->session->userdata('empleado_id');
        if ($_POST) {
            $array = ($_POST['IMEI_FISICO_1'] != '') ? array('IMEI_FISICO_1' => $_POST['IMEI_FISICO_1']) : array();

            if (($_POST['datetimepicker_inicio'] != '') && ($_POST['datetimepicker_fin'] != ''))
                $condicion_fecha = " eq.FECHA_INSERT BETWEEN TO_DATE ('" . $_POST['datetimepicker_inicio'] . "', 'dd/mm/yyyy HH24:MI:SS') AND TO_DATE ('" . $_POST['datetimepicker_fin'] . "', 'dd/mm/yyyy HH24:MI:SS')";
            if ($_POST['USUARIOS'] != '')
                $array = array_merge($array, array('USUARIO_ID' => $_POST['USUARIOS']));

                if ($_POST['datetimepicker_mininte'] != ''){
                    $time = strtotime($_POST['datetimepicker_mininte']);
                    $newformat = date('d/M/y',$time);
                    $envio_mininte = $newformat;
                }else{
                    $envio_mininte = '';
                }

                //////USUARIO SELECCIONADO////
                if ($_POST['USUARIOS'] != ''){
                  $usuario_seleccionado = $_POST['USUARIOS'];
                }

        }

        $data['equipos'] = array();
        if($_POST){
            //if ($this->session->userdata('nivel') == 1) {//administrador
                $data['equipos'] = $this->equipos_model->lista(3, '', $array, '', $condicion_fecha, $condicion_imei_comparativa, $envio_codigo,$envio_mininte);
                //var_dump($data['equipos']);exit;
           // } else {
           //     $array_basico = array('USUARIO_ID' => $this->session->userdata('empleado_id'));
           //     $array_where = (count($array) > 0) ? array_merge($array_basico, $array) : $array_basico;

           //    $data['equipos'] = $this->equipos_model->lista(3, '', $array_where, '', $condicion_fecha, $condicion_imei_comparativa, $envio_codigo);
                //var_dump($data['equipos']);exit;
           // }

            //$where = ($this->session->userdata('nivel') == 1) ? $array : $array_where;

            //$data['param1'] = base64_encode(serialize($where));

            $data['param2'] = $condicion_fecha;
            $data['param3'] = $condicion_imei_comparativa;
            $data['param4'] = $envio_codigo;
        }

        $data['carga_activa'] = $this->cargas_model->select(1, array('ID'), array('USUARIO_ID' => $this->session->userdata('empleado_id'), 'ACTIVO_ID' => 1));
        $data['operador_reportante'] = $this->operadores_model->select(3);
        $data['osiptel_estados'] = $this->osiptel_estados_model->select(3);
        $data['colores'] = $this->colores_model->select(3);
        $data['marcas'] = $this->marcas_model->select(3);
        $data['UBICACION_FISICA'] = $this->ubicacion_fisicas_model->select(3);
        $data['CONSERVACION_ESTADO'] = $this->conservacion_estados_model->select(3);
        $data['entidad_entregantes'] = $this->entidad_entregantes_model->select(3);
        //$where = ($this->session->userdata('nivel') == 1) ? array('nivel' => 2) : array('ID' => $this->session->userdata('empleado_id'));
        //$data['usuarios'] = $this->usuarios_model->select(3, '', $where);
        $data['usuarios'] = $this->usuarios_model->select(3, '', '');
        $data['imei_comparativa'] = $this->imei_comparativa_model->select();

        $this->session->set_userdata('menu',2);
        $data['usuario_seleccionado'] = $usuario_seleccionado;

        $this->usuarios_model->menuGeneral();
        $this->load->view('equipos/verAlmacen', $data);
        $this->load->view('templates/footer');

    }

    public function devoluciones($id_equipo){
        $dato['equipo'] = $id_equipo;
        $this->usuarios_model->menuGeneral();
        $this->load->view('egresados/devolver_uno',$dato);
        $this->load->view('templates/footer');
    }

    public function devolucionesExcel(){
        $this->usuarios_model->menuGeneral();
        $this->load->view('egresados/devolver_excel');
        $this->load->view('templates/footer');
    }

    public function generarCodigoAlmacen_g(){
           $b = 0;
           //$this->session->set_userdata('empleado_id',1);
        $param1 = unserialize(base64_decode($_POST['param1']));
        //print_r(count($param1));exit;
        foreach ($param1 as $value){
        //for($o=1;$o<=count($param1);$o++){
            if(isset($_POST["che-".$value['EQUIPO_ID']]) && ($_POST["che-".$value['EQUIPO_ID']] == 1)){
               $b++;
                //print_r($_POST["che-".$value['EQUIPO_ID']]);exit;

                //echo "a<br>";
                $equipo_id =$value['EQUIPO_ID'];

                //echo $equipo_id."---";

                $caja = $this->cajas_model->ubicar_caja($equipo_id);
                //$caja['CAJA_ID'];
                //echo $caja_id. "xx";
                //echo $this->session->userdata('empleado_id')."yy";
//
                $FECHA_INSERT = "to_timestamp('" . substr(date("d-m-Y"), 0, 2) . "-" . listar_meses_ingles(substr(date("d-m-Y"), 3, 2)) . "-" . substr(date("d-m-Y"), 8, 2) . " " . date('h:i:s A') . "')";
//
                $equipo = $this->equipos_model->select_one($equipo_id);
                $marca = $this->modelos_model->select_one($equipo['MODELO_ID']); ////
                $entregantes = $this->entregantes_model->select_one($equipo_id);
                $ubicacion_fisica = $entregantes['UBICACION_FISICA_ID']; ////
                //print_r($entregantes);
                //print_r($equipo);exit;
                $est_conservacion = $this->equipos_model->select_estado($equipo_id);
                $cajas = $this->cajas_model->select_2();
                $q = 0;
                foreach($cajas as $caj){
                  if($caj['CANTIDAD']<$caj['FULL'] and $q == 0){
                        $caja_id = $caj['ID'];

                          ///PD ???
                          if($ubicacion_fisica==2){

                                if($caj['ESTADO_CAJA']==51 and ($marca==33 or $marca==28)){ ////NOKIA,MICROSOFT

                                }else if($caj['ESTADO_CAJA']==52 and ($marca==4 or $marca==24 or $marca==20)){ ///ALCATEL, LG , HUAWEI
                                  $sql = "INSERT INTO caja_equipos (CAJA_ID, EQUIPO_ID, EMPLEADO_INSERT, FECHA_INSERT) VALUES " . " ($caja_id, $equipo_id, " . $this->session->userdata('empleado_id') . ", " . $FECHA_INSERT . ")";
                                  $this->db->query($sql);

                                  $sql2 = "UPDATE EQUIPOS SET ESTADO_ALMACEN=1 WHERE ID=".$equipo_id;
                                  $this->db->query($sql2);
                                  $q++;
                                }else if($caj['ESTADO_CAJA']==54 and $marca==38){ /// SAMSUNG
                                  $sql = "INSERT INTO caja_equipos (CAJA_ID, EQUIPO_ID, EMPLEADO_INSERT, FECHA_INSERT) VALUES " . " ($caja_id, $equipo_id, " . $this->session->userdata('empleado_id') . ", " . $FECHA_INSERT . ")";
                                  $this->db->query($sql);

                                  $sql2 = "UPDATE EQUIPOS SET ESTADO_ALMACEN=1 WHERE ID=".$equipo_id;
                                  $this->db->query($sql2);
                                  $q++;
                                }else if($caj['ESTADO_CAJA']==55 and $marca==30){ /// MOTOROLA
                                  $sql = "INSERT INTO caja_equipos (CAJA_ID, EQUIPO_ID, EMPLEADO_INSERT, FECHA_INSERT) VALUES " . " ($caja_id, $equipo_id, " . $this->session->userdata('empleado_id') . ", " . $FECHA_INSERT . ")";
                                  $this->db->query($sql);

                                  $sql2 = "UPDATE EQUIPOS SET ESTADO_ALMACEN=1 WHERE ID=".$equipo_id;
                                  $this->db->query($sql2);
                                  $q++;
                                }else if($caj['ESTADO_CAJA']==56 and ($marca==39 or $marca==40 or $marca==7)){ ///SONY, SONY ERICSSON, APPLE
                                  $sql = "INSERT INTO caja_equipos (CAJA_ID, EQUIPO_ID, EMPLEADO_INSERT, FECHA_INSERT) VALUES " . " ($caja_id, $equipo_id, " . $this->session->userdata('empleado_id') . ", " . $FECHA_INSERT . ")";
                                  $this->db->query($sql);

                                  $sql2 = "UPDATE EQUIPOS SET ESTADO_ALMACEN=1 WHERE ID=".$equipo_id;
                                  $this->db->query($sql2);
                                  $q++;
                                }else if($caj['ESTADO_CAJA']==53){ /// OTRAS MARCAS
                                  $sql = "INSERT INTO caja_equipos (CAJA_ID, EQUIPO_ID, EMPLEADO_INSERT, FECHA_INSERT) VALUES " . " ($caja_id, $equipo_id, " . $this->session->userdata('empleado_id') . ", " . $FECHA_INSERT . ")";
                                  $this->db->query($sql);

                                  $sql2 = "UPDATE EQUIPOS SET ESTADO_ALMACEN=1 WHERE ID=".$equipo_id;
                                  $this->db->query($sql2);
                                  $q++;
                                }

                           ///ARMARIO ??
                          //}else if($ubicacion_fisicas==1){
                          }else{

                               if((($equipo['IMEI_FISICO_1']=='')?0:$equipo['IMEI_FISICO_1'])!=(($equipo['IMEI_LOGICO_1']=='')?0:$equipo['IMEI_LOGICO_1']) and $est_conservacion['CONSERVACION_ESTADO_ID']==1 and $equipo['OBSERVACION_INOPERATIVIDAD_ID']==2){
                                 if($caj['ESTADO_CAJA']==3){
                                   $sql = "INSERT INTO caja_equipos (CAJA_ID, EQUIPO_ID, EMPLEADO_INSERT, FECHA_INSERT) VALUES " . " ($caja_id, $equipo_id, " . $this->session->userdata('empleado_id') . ", " . $FECHA_INSERT . ")";
                                   $this->db->query($sql);

                                   $sql2 = "UPDATE EQUIPOS SET ESTADO_ALMACEN=1 WHERE ID=".$equipo_id;
                                   $this->db->query($sql2);
                                   $q++;
                                 }
                               }else if((($equipo['IMEI_FISICO_1']=='')?0:$equipo['IMEI_FISICO_1'])!=(($equipo['IMEI_LOGICO_1']=='')?0:$equipo['IMEI_LOGICO_1']) and $est_conservacion['CONSERVACION_ESTADO_ID']==2 and ($equipo['OBSERVACION_INOPERATIVIDAD_ID']>=18 and $equipo['OBSERVACION_INOPERATIVIDAD_ID']<=25)){
                                 if($caj['ESTADO_CAJA']==3){
                                   $sql = "INSERT INTO caja_equipos (CAJA_ID, EQUIPO_ID, EMPLEADO_INSERT, FECHA_INSERT) VALUES " . " ($caja_id, $equipo_id, " . $this->session->userdata('empleado_id') . ", " . $FECHA_INSERT . ")";
                                   $this->db->query($sql);

                                   $sql2 = "UPDATE EQUIPOS SET ESTADO_ALMACEN=1 WHERE ID=".$equipo_id;
                                   $this->db->query($sql2);
                                   $q++;
                                 }
                               }else if($equipo['OPERADOR_REPORTANTE_ID']==10){
                                 if($caj['ESTADO_CAJA']==4){
                                   $sql = "INSERT INTO caja_equipos (CAJA_ID, EQUIPO_ID, EMPLEADO_INSERT, FECHA_INSERT) VALUES " . " ($caja_id, $equipo_id, " . $this->session->userdata('empleado_id') . ", " . $FECHA_INSERT . ")";
                                   $this->db->query($sql);

                                   $sql2 = "UPDATE EQUIPOS SET ESTADO_ALMACEN=1 WHERE ID=".$equipo_id;
                                   $this->db->query($sql2);
                                   $q++;
                                 }
                               }else if($equipo['OPERADOR_REPORTANTE_ID']!=11 and $equipo['OPERADOR_REPORTANTE_ID']!=10){
                                 if($caj['ESTADO_CAJA']==1){
                                   $sql = "INSERT INTO caja_equipos (CAJA_ID, EQUIPO_ID, EMPLEADO_INSERT, FECHA_INSERT) VALUES " . " ($caja_id, $equipo_id, " . $this->session->userdata('empleado_id') . ", " . $FECHA_INSERT . ")";
                                   $this->db->query($sql);

                                   $sql2 = "UPDATE EQUIPOS SET ESTADO_ALMACEN=1 WHERE ID=".$equipo_id;
                                   $this->db->query($sql2);
                                   $q++;
                                 }
                               }else if($equipo['OPERADOR_REPORTANTE_ID']==11){
                                 if($caj['ESTADO_CAJA']==2){
                                   $sql = "INSERT INTO caja_equipos (CAJA_ID, EQUIPO_ID, EMPLEADO_INSERT, FECHA_INSERT) VALUES " . " ($caja_id, $equipo_id, " . $this->session->userdata('empleado_id') . ", " . $FECHA_INSERT . ")";
                                   $this->db->query($sql);

                                   $sql2 = "UPDATE EQUIPOS SET ESTADO_ALMACEN=1 WHERE ID=".$equipo_id;
                                   $this->db->query($sql2);
                                   $q++;
                                 }
                               }else{

                               }
                            }
                            $this->cajas_model->update_full($caja_id);

                  }

                }

            }

        }

         //print_r($b);exit;
         redirect(base_url() . "index.php/equipos/");
    }

    public function almacenar(){
        /*$id = $this->input->get('id');
        $equipos = jsson_decode($this->input->get('eqs'));
        $cajas = 'OBETENER CAJAS';
        $cant_cajas = count($cajas);
        foreach($equipos as $eq){
            $c = 0;
            for($i=1;$i<=$cant_cajas;$i){
                if($caj->CANTIDAD<$caj->FULL and $c == 0){
                    //GUARDAR EQUIPO
                    $c++;
                }
            }
        }*/

    }

    public function retornar($equipo_id){
        $sql = "UPDATE EQUIPOS SET ESTADO_ALMACEN=0 WHERE ID=".$equipo_id;
        $this->db->query($sql);

        $sql2 = "DELETE EGRESADOS WHERE EQUIPO_ID=".$equipo_id;
        $this->db->query($sql2);

        redirect(base_url() . "index.php/equipos/");
    }

    public function test(){
        $this->usuarios_model->menuGeneral();
        $this->load->view('equipos/test');
        $this->load->view('templates/footer');
    }

    public function detalle() {
        $data['detalle'] = $this->equipos_model->detalle($this->uri->segment(3));

        $this->load->view('templates/header_sin_menu');
        $this->load->view('equipos/detalle', $data);
        $this->load->view('templates/footer');
    }

    public function insert() {
        $data['conservacion_estado'] = $this->conservacion_estados_model->select(3);
        $data['marcas'] = $this->marcas_model->select(3);
        $data['operador_reportantes'] = $this->operadores_model->select(3);
        $data['osiptel_estados'] = $this->osiptel_estados_model->select(3);
        $data['colores'] = $this->colores_model->select(3);
        $data['departamentos'] = $this->departamentos_model->select(3);
        $data['ubicacion_fisica'] = $this->ubicacion_fisicas_model->select(3);

        if($this->session->userdata('CARGA_CANTIDAD') != ''){
            $mes = listar_meses_ingles_doy_numero(substr($this->session->userdata('CARGA_FECHA'), 3, 3));
            $fecha = substr($this->session->userdata('CARGA_FECHA'), 0, 2) . "-" . $mes . "-20" . substr($this->session->userdata('CARGA_FECHA'), 7, 2);
            $data['FECHA_INGRESO_MININTER'] = $fecha;
        }else{
            $data['FECHA_INGRESO_MININTER'] = '';
        }

        $this->usuarios_model->menuGeneral();
        $this->load->view('equipos/insert', $data);
        $this->load->view('templates/footer');
    }

    public function grabar() {

        $data_validation = $this->equipos_model->selectValidation($_POST['IMEI_FISICO_1']);

        if ($data_validation == ''){
            //$UBICACION_FISICA = $_POST['UBICACION_FISICA'];
            if ((($_POST['IMEI_LOGICO_1'] == '' && $_POST['IMEI_LOGICO_2'] == '' && $_POST['operador_reportantes']==10) || ($_POST['IMEI_LOGICO_1'] != $_POST['IMEI_LOGICO_2'])) && (($_POST['IMEI_FISICO_1'] == '' && $_POST['IMEI_FISICO_2'] == '' && $_POST['operador_reportantes']==10) || ( $_POST['IMEI_FISICO_1'] != $_POST['IMEI_FISICO_2']) || ( $_POST['IMEI_FISICO_1'] == '' && $_POST['operador_reportantes']==10))) {

                if ($_POST['FECHA_REPORTE_OPERADOR'] != '') {
                    $data = $_POST['FECHA_REPORTE_OPERADOR'];
                    $FECHA_REPORTE_OPERADOR = substr($data, 0, 2) . "-" . listar_meses_ingles(substr($data, 3, 2)) . "-" . substr($data, 8, 2);
                } else {
                    $FECHA_REPORTE_OPERADOR = '';
                }

                $FECHA_INGRESO_MININTER = (isset($_POST['FECHA_INGRESO_MININTER']) && ($_POST['FECHA_INGRESO_MININTER'] != '')) ? substr($_POST['FECHA_INGRESO_MININTER'], 0, 2) . "-" . listar_meses_ingles(substr($_POST['FECHA_INGRESO_MININTER'], 3, 2)) . "-" . substr($_POST['FECHA_INGRESO_MININTER'], 8, 2) : '';
                //$FECHA_INSERT = substr(date("d-m-Y"),0,2)."-". listar_meses_ingles(substr(date("d-m-Y"),3,2))."-".substr(date("d-m-Y"),8,2)." ". substr(date('d-m-Y H:i:s'),11);
                $FECHA_INSERT = "to_timestamp('" . substr(date("d-m-Y"), 0, 2) . "-" . listar_meses_ingles(substr(date("d-m-Y"), 3, 2)) . "-" . substr(date("d-m-Y"), 8, 2) . " " . date('h:i:s A') . "')";

                $celulares_id = $this->equipos_model->select_max_id() + 1;
                $OBS_INOPERATIVIDAD = isset($_POST['OBS_INOPERATIVIDAD']) ? strtoupper(trim($_POST['OBS_INOPERATIVIDAD'])) : '-';

                $IMEI_FISICO_2 = !empty($_POST['IMEI_FISICO_2']) ? $_POST['IMEI_FISICO_2'] : '';
                $IMEI_LOGICO_2 = !empty($_POST['IMEI_LOGICO_2']) ? $_POST['IMEI_LOGICO_2'] : '';
                $MODELO = !empty($_POST['MODELO']) ? $_POST['MODELO'] : "NULL";

                $sql = "INSERT INTO EQUIPOS (ID, ITEM, FECHA_REPORTE_OPERADOR, FECHA_INGRESO_MININTER, IMEI_FISICO_1, IMEI_LOGICO_1, IMEI_FISICO_2, IMEI_LOGICO_2, OBSERVACION_INOPERATIVIDAD_ID, MODELO_ID, OPERADOR_REPORTANTE_ID, OSIPTEL_ESTADO_ID, COLOR_ID, DEPARTAMENTO_ORIGEN_ID, USUARIO_ID, FECHA_INSERT, MOTIVO_UPDATE, CARGA_ID) VALUES " . " ($celulares_id, $celulares_id, '$FECHA_REPORTE_OPERADOR', '$FECHA_INGRESO_MININTER', '" . trim($_POST['IMEI_FISICO_1']) . "', '" . trim($_POST['IMEI_LOGICO_1']) . "', '" . $IMEI_FISICO_2 . "', '" . $IMEI_LOGICO_2 . "', '" . $_POST['OBSERVACION_INOPERATIVIDADES'] . "', $MODELO , " . $_POST['operador_reportantes'] . ", " . $_POST['OSIPTEL_ESTADOS'] . ", " . $_POST['COLORES'] . ", " . $_POST['DEPARTAMENTOS'] . ", " . $this->session->userdata('empleado_id') . ", " . $FECHA_INSERT . ", '', " . $this->session->userdata('CARGA_ID') . ")";
                //echo $sql;exit;
                $this->db->query($sql);

                $this->session->set_userdata('CELULARES_GUARDADOS', ($this->session->userdata('CELULARES_GUARDADOS') + 1));

                //$this->equipos_model->insert($data);
                $max_equipo_id = $this->equipos_model->select_max_id();
                redirect(base_url() . "index.php/entregantes/insert/" . $max_equipo_id);
            }else{
                $respuesta = '';
                if ($descripcion_IMEI_FISICO_1 == '')
                    $respuesta = 'IMEI FISICO 1 ya ingresado.';
                if ($descripcion_IMEI_FISICO_2 == '')
                    $respuesta = 'IMEI FISICO 2 ya ingresado.';
                if ($descripcion_IMEI_LOGICO_1 == '')
                    $respuesta = 'IMEI LOGICO 1 ya ingresado.';
                if ($descripcion_IMEI_LOGICO_2 == '')
                    $respuesta = 'IMEI LOGICO 2 ya ingresado.';
                if ($_POST['IMEI_FISICO_1'] == $_POST['IMEI_FISICO_2'])
                    $respuesta = 'Los IMEI FISICOS no pueden ser iguales';
                if ($_POST['IMEI_LOGICO_1'] == $_POST['IMEI_LOGICO_2'])
                    $respuesta = 'Los IMEI LOGICOS no pueden ser iguales';
                if ($_POST['IMEI_FISICO_1'] == '' && $_POST['operador_reportantes']!=10)
                    $respuesta = 'SI NO CUENTA CON IMEI FÍSICO DEBE SELECCIONAR OPERADOR REPORTANTE "ERRADICADO"';

                $this->session->set_flashdata('mensaje', $respuesta);
                redirect(base_url() . "index.php/equipos/insert");
            }
        }else{
            $this->session->set_flashdata('mensaje', 'IMEIS LOGICOS O FISICOS REPETIDOS');
            redirect(base_url() . "index.php/equipos/insert");
        }
    }

    public function editar() {

        $equipo_id = $this->uri->segment(3);
        $data['data_equipo'] = $this->equipos_model->select_custo($equipo_id);
        //var_dump($data['data_equipo']);exit;

        if ($data['data_equipo'][0]['FECHA_REPORTE_OPERADOR'] != '') {
            $fecha = $data['data_equipo'][0]['FECHA_REPORTE_OPERADOR'];
            $mes = listar_meses_ingles_doy_numero(substr($fecha, 3, 3));
            $data['data_equipo']['FECHA_REPORTE_OPERADOR'] = substr($fecha, 0, 2) . "-" . $mes . "-20" . substr($fecha, 7, 2);
        } else {
            $data['data_equipo']['FECHA_REPORTE_OPERADOR'] = '';
        }

        $fecha = $data['data_equipo'][0]['FECHA_INGRESO_MININTER'];
        $mes = listar_meses_ingles_doy_numero(substr($fecha, 3, 3));
        $data['data_equipo']['FECHA_INGRESO_MININTER'] = substr($fecha, 0, 2) . "-" . $mes . "-20" . substr($fecha, 7, 2);

        //var_dump($data['data_equipo']);exit;
        $data['conservacion_estado'] = $this->conservacion_estados_model->select(3);
        $data['obsevacion_inoperatividad'] = $this->observacion_inoperatividades_model->select(3,'',array('CONSERVACION_ESTADO_ID' => $data['data_equipo'][0]['CONSERVACION_ESTADO_ID']));
        $data['modelos'] = $this->modelos_model->select(3,'',array('MARCA_ID' => $data['data_equipo'][0]['MARCA_ID']));
        //var_dump($data['obsevacion_inoperatividad']);exit;
        $data['marcas'] = $this->marcas_model->select(3);
        $data['operador_reportantes'] = $this->operadores_model->select(3);
        $data['osiptel_estados'] = $this->osiptel_estados_model->select(3);
        $data['colores'] = $this->colores_model->select(3);
        $data['departamentos'] = $this->departamentos_model->select(3);

        //$this->load->view('templates/header_sin_menu');
        $this->usuarios_model->menuGeneral();
        $this->load->view('equipos/editar', $data);
        $this->load->view('templates/footer');
    }

    public function edit_grabar() {

        $data_validation = $this->equipos_model->selectValidation($_POST['EQUIPO_ID'], $_POST['IMEI_FISICO_1'], $_POST['IMEI_FISICO_2'], $_POST['IMEI_LOGICO_1'], $_POST['IMEI_LOGICO_2']);

        if ($data_validation == '') {
            if ((($_POST['IMEI_LOGICO_1'] == '' && $_POST['IMEI_LOGICO_2'] == '') || ($_POST['IMEI_LOGICO_1'] != $_POST['IMEI_LOGICO_2'])) && (($_POST['IMEI_FISICO_1'] == '' && $_POST['IMEI_FISICO_2'] == '') || ( $_POST['IMEI_FISICO_1'] != $_POST['IMEI_FISICO_2']))) {
                $data = $_POST['FECHA_REPORTE_OPERADOR'];
                $FECHA_REPORTE_OPERADOR = ($data == '') ? '' : substr($data, 0, 2) . "-" . listar_meses_ingles(substr($data, 3, 2)) . "-" . substr($data, 8, 2);

                $data = $_POST['FECHA_INGRESO_MININTER'];
                $FECHA_INGRESO_MININTER = ($data == '') ? '' : substr($data, 0, 2) . "-" . listar_meses_ingles(substr($data, 3, 2)) . "-" . substr($data, 8, 2);

                $data = array(
                    'FECHA_REPORTE_OPERADOR' => $FECHA_REPORTE_OPERADOR,
                    'FECHA_INGRESO_MININTER' => $FECHA_INGRESO_MININTER,
                    'IMEI_FISICO_1' => $_POST['IMEI_FISICO_1'],
                    'IMEI_LOGICO_1' => $_POST['IMEI_LOGICO_1'],
                    'IMEI_FISICO_2' => $_POST['IMEI_FISICO_2'],
                    'IMEI_LOGICO_2' => $_POST['IMEI_LOGICO_2'],
                    'OBSERVACION_INOPERATIVIDAD_ID' => $_POST['OBSERVACION_INOPERATIVIDADES'],
                    'MODELO_ID' => $_POST['MODELO'],
                    'OPERADOR_REPORTANTE_ID' => $_POST['operador_reportantes'],
                    'OSIPTEL_ESTADO_ID' => $_POST['OSIPTEL_ESTADOS'],
                    'COLOR_ID' => $_POST['COLORES'],
                    'DEPARTAMENTO_ORIGEN_ID' => $_POST['DEPARTAMENTOS'],
                    'MOTIVO_UPDATE' => $_POST['MOTIVO_UPDATE']
                );
                $this->equipos_model->update($data, $_POST['EQUIPO_ID']);
                $max_equipo_id = $this->equipos_model->select_max_id();
                //redirect(base_url() . "index.php/entregantes/insert/".$max_equipo_id);
                redirect(base_url() . "index.php/equipos/index");
            }else{
                $respuesta = '';
                if ($descripcion_IMEI_FISICO_1 == '')
                    $respuesta = 'IMEI FISICO 1 ya ingresado.';
                if ($descripcion_IMEI_FISICO_2 == '')
                    $respuesta = 'IMEI FISICO 2 ya ingresado.';
                if ($descripcion_IMEI_LOGICO_1 == '')
                    $respuesta = 'IMEI LOGICO 1 ya ingresado.';
                if ($descripcion_IMEI_LOGICO_2 == '')
                    $respuesta = 'IMEI LOGICO 2 ya ingresado.';
                if ($_POST['IMEI_FISICO_1'] == $_POST['IMEI_FISICO_2'])
                    $respuesta = 'Los IMEI no pueden ser iguales';
                if ($_POST['IMEI_LOGICO_1'] == $_POST['IMEI_LOGICO_2'])
                    $respuesta = 'Los IMEI no pueden ser iguales';

                $this->session->set_flashdata('mensaje', $respuesta);
                redirect(base_url() . "index.php/equipos/editar/" . $_POST['EQUIPO_ID']);
            }
        } else {
            $this->session->set_flashdata('mensaje', 'IMEIS LOGICOS O FISICOS REPETIDOS');
            redirect(base_url() . "index.php/equipos/editar");
        }
    }

    public function exportarExcel2() {
        //echo phpinfo();exit;

        $equipos = $this->equipos_model->lista(3, '');

        //$this->export_excel->to_excel($equipos, 'lista');



        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');

        /** Include PHPExcel */
        //require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';
        $this->load->library('excel');

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                ->setLastModifiedBy("Maarten Balliauw")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");


        // Add some data
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Hello')
                ->setCellValue('B2', 'world!')
                ->setCellValue('C1', 'Hello')
                ->setCellValue('D2', 'world!');

        // Miscellaneous glyphs, UTF-8
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A4', 'Miscellaneous glyphs')
                ->setCellValue('A5', 'al compas del tambor oquere tiquitiquitiqui ta');

        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('Simple');


        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);


        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="01simple.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        //$objWriter->save('php://output');
        //exit;
    }

    public function exportarExcel(){

        $campos = array();
        $campos = ( $this->uri->segment(3) == 'null') ? $campos : array_merge($campos, array('IMEI_FISICO_1' => $this->uri->segment(3)));
        $campos = ( $this->uri->segment(4) == 'null') ? $campos : array_merge($campos, array('OPERADOR_REPORTANTE_ID' => $this->uri->segment(4)));
        $campos = ( $this->uri->segment(5) == 'null') ? $campos : array_merge($campos, array('OSIPTEL_ESTADO_ID' => $this->uri->segment(5)));
        $campos = ( $this->uri->segment(6) == 'null') ? $campos : array_merge($campos, array('COLOR_ID' => $this->uri->segment(6)));
        $campos = ( $this->uri->segment(7) == 'null') ? $campos : array_merge($campos, array('DEPARTAMENTO_ORIGEN_ID' => $this->uri->segment(7)));
        $campos = ( $this->uri->segment(8) == 'null') ? $campos : array_merge($campos, array('ENTIDAD_ENTREGANTE_ID' => $this->uri->segment(8)));
        $campos = ( $this->uri->segment(9) == 'null') ? $campos : array_merge($campos, array('DISTRITO_ID' => $this->uri->segment(9)));
        $campos = ( $this->uri->segment(10) == 'null') ? $campos : array_merge($campos, array('USUARIO_ID' => $this->uri->segment(10)));
        $campos = ( $this->uri->segment(11) == 'null') ? $campos : array_merge($campos, array('NOMBRES' => $this->uri->segment(11)));
        //var_dump($campos);exit;

        $equipos = $this->equipos_model->lista(3, '', $campos);


        $this->load->library('excel');

        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
        date_default_timezone_set('Europe/London');

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                ->setLastModifiedBy("Maarten Balliauw")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");



        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', "Nr. Factura");
        $objPHPExcel->getActiveSheet()->setCellValue('B1', "Estado");
        $objPHPExcel->getActiveSheet()->setCellValue('C1', "Fecha de Emisi?n");
        $objPHPExcel->getActiveSheet()->setCellValue('D1', "Fecha de cancelaci?n");
        $objPHPExcel->getActiveSheet()->setCellValue('E1', "RUC");
        $objPHPExcel->getActiveSheet()->setCellValue('F1', "RAZON SOCIAL");
        $objPHPExcel->getActiveSheet()->setCellValue('G1', "TRANSFERENCIA TITULO GRATUITO");
        $objPHPExcel->getActiveSheet()->setCellValue('H1', "Vta. Libros");
        $objPHPExcel->getActiveSheet()->setCellValue('I1', "Base Imponible");
        $objPHPExcel->getActiveSheet()->setCellValue('J1', "IGV");
        $objPHPExcel->getActiveSheet()->setCellValue('K1', "TOTAL");
        $objPHPExcel->getActiveSheet()->setCellValue('L1', "DETRACCION");
        $objPHPExcel->getActiveSheet()->setCellValue('M1', "NUMERO DE DETRACCI?N");
        $objPHPExcel->getActiveSheet()->setCellValue('N1', "FECHA DE DETRACCI?N");
        $objPHPExcel->getActiveSheet()->setCellValue('O1', "TIPO DE CAMBIO");
        $objPHPExcel->getActiveSheet()->setCellValue('P1', "CONCEPTO");
        $objPHPExcel->getActiveSheet()->setCellValue('Q1', "MONEDA");
        $objPHPExcel->getActiveSheet()->setCellValue('R1', "Monto en letras");

        $objPHPExcel->getActiveSheet()->setCellValue('A' . 3, 'HOLA');

//
//        for ($i = 2; $i <= (count($equipos) + 1); $i++) {
//            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, '')
//                    ->setCellValue('B' . $i, '')
//
//            ;
//        }
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $filename = 'equipos---' . date("d-m-Y") . '---' . rand(1000, 9999) . '.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    public function exportar_excel_almacen(){

        $imei_fisico_1 = $this->input->get('IMEI_FISICO_1');
        $fecha_inicio = $this->input->get('FECHA_INICIO');
        $fecha_final = $this->input->get('FECHA_FINAL');

        $this->load->library('excel');
        $array = $this->equipos_model->lista_excel_almacen($imei_fisico_1,$fecha_inicio,$fecha_final);
        //print_r(json_encode($array));exit;
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
        date_default_timezone_set('Europe/London');

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                ->setLastModifiedBy("Maarten Balliauw")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");



        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', "Nr. Factura");
        $objPHPExcel->getActiveSheet()->setCellValue('B1', "Estado");
        $objPHPExcel->getActiveSheet()->setCellValue('C1', "Fecha de Emisi?n");
        $objPHPExcel->getActiveSheet()->setCellValue('D1', "Fecha de cancelaci?n");
        $objPHPExcel->getActiveSheet()->setCellValue('E1', "RUC");
        $objPHPExcel->getActiveSheet()->setCellValue('F1', "RAZON SOCIAL");
        $objPHPExcel->getActiveSheet()->setCellValue('G1', "TRANSFERENCIA TITULO GRATUITO");
        $objPHPExcel->getActiveSheet()->setCellValue('H1', "Vta. Libros");
        $objPHPExcel->getActiveSheet()->setCellValue('I1', "Base Imponible");
        $objPHPExcel->getActiveSheet()->setCellValue('J1', "IGV");
        $objPHPExcel->getActiveSheet()->setCellValue('K1', "TOTAL");
        $objPHPExcel->getActiveSheet()->setCellValue('L1', "DETRACCION");
        $objPHPExcel->getActiveSheet()->setCellValue('M1', "NUMERO DE DETRACCI?N");
        $objPHPExcel->getActiveSheet()->setCellValue('N1', "FECHA DE DETRACCI?N");
        $objPHPExcel->getActiveSheet()->setCellValue('O1', "TIPO DE CAMBIO");
        $objPHPExcel->getActiveSheet()->setCellValue('P1', "CONCEPTO");
        $objPHPExcel->getActiveSheet()->setCellValue('Q1', "MONEDA");
        $objPHPExcel->getActiveSheet()->setCellValue('R1', "Monto en letras");

        $objPHPExcel->getActiveSheet()->setCellValue('A' . 3, 'HOLA');

//
//        for ($i = 2; $i <= (count($equipos) + 1); $i++) {
//            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, '')
//                    ->setCellValue('B' . $i, '')
//
//            ;
//        }
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="01simple.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        $objWriter->save('php://output');

    }



    public function cargaObservaciones() {
        $observaciones = $this->observacion_inoperatividades_model->select(3, '', array('CONSERVACION_ESTADO_ID' => $this->uri->segment(3)));
        echo '<option value="">Seleccionar Observación</option>';
        foreach ($observaciones as $value) {
            echo '<option value="' . $value['ID'] . '">' . $value['OBSERVACION_INOPERATIVIDAD'] . '</option>';
        }
    }

    public function cargaModelos() {
        $modelos = $this->modelos_model->select(3, '', array('MARCA_ID' => $this->uri->segment(3)));
        echo '<option value="">Seleccionar Modelo</option>';
        foreach ($modelos as $value) {
            echo '<option value="' . $value['ID'] . '">' . $value['MODELO'] . '</option>';
        }
    }

    public function cargaOsiptel() {
        if(($this->uri->segment(3) == 10) || $this->uri->segment(3) == 11){
            $osiptel = $this->osiptel_estados_model->select(3, '', array('ID' => 6));
        }else{
            echo '<option value="">Seleccionar Modelo</option>';
            $osiptel = $this->osiptel_estados_model->select(3, '', array('ID' => 'IN (1,2,3,4,5)'));
        }
        foreach ($osiptel as $value) {
            echo '<option value="' . $value['ID'] . '">' . $value['OSIPTEL_ESTADO'] . '</option>';
        }
    }

    public function generarCodigoUnitarioAlmacen(){
        $equipo_id = $this->uri->segment(3);
        $caja = $this->cajas_model->ubicar_caja($equipo_id);

        $FECHA_INSERT = "to_timestamp('" . substr(date("d-m-Y"), 0, 2) . "-" . listar_meses_ingles(substr(date("d-m-Y"), 3, 2)) . "-" . substr(date("d-m-Y"), 8, 2) . " " . date('h:i:s A') . "')";

        $caja_id = $caja['id'];
        $sql = "INSERT INTO caja_equipos (CAJA_ID, EQUIPO_ID, EMPLEADO_INSERT, FECHA_INSERT) VALUES " . " ($caja_id, $equipo_id, " . $this->session->userdata('empleado_id') . ", " . $FECHA_INSERT . ")";
        $this->db->query($sql);
        exit;

        $this->caja_equipos_model->ingresar_equipo_caja($caja['id'], $this->uri->segment(3));
        echo json_encode($caja['caja']);
    }

}
