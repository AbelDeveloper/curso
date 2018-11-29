<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Egresados extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Lima');
        $this->load->model('colores_model');
        $this->load->model('operadores_model');
        $this->load->model('entidad_entregantes_model');
        $this->load->model('distritos_model');
        $this->load->model('entregantes_model');
        $this->load->model('equipos_model');
        $this->load->model('egresados_model');
        $this->load->model('usuarios_model');
        $this->load->model('cargas_model');
        $this->load->model('cajas_model');
        $this->load->model('ubicacion_fisicas_model');
        $this->load->model('tipo_documentos_model');
        $this->load->helper('url');
        $this->load->helper('ayuda');
    }

    public function insert(){
        $equipo_id = $this->uri->segment(3);
        $data['data_equipo'] = $this->equipos_model->select_custo($equipo_id);
        $data['tipo_documentos'] = $this->tipo_documentos_model->select(3);
        //var_dump($data['data_equipo']);exit;

        $longitud = strlen($data['data_equipo'][0]['ITEM']);
        $requerida = 6;

        if($longitud < $requerida){
            $ceros = $requerida - $longitud;
        }

        $cadena = $data['data_equipo'][0]['ITEM'];
        for($i=1; $i<=$ceros; $i++){
            $cadena = "0".$cadena;
        }
        $data['data_equipo']['item'] = $cadena;

        $data['entidad_entregante'] = $this->entidad_entregantes_model->select(3);
        $data['ubicacion_fisica'] = $this->ubicacion_fisicas_model->select(3);
        $data['distritos'] = $this->distritos_model->select(3);

        //ECHO $this->session->userdata('CARGA_OPERADOR_ID');EXIT;
        //echo $this->session->userdata('CARGA_ENTIDAD_ENTREGANTE_ID');exit;
        if($this->session->userdata('CARGA_ENTIDAD_ENTREGANTE_ID') != ''){
            $data['CARGA_ENTIDAD_ENTREGANTE_ID'] = $this->session->userdata('CARGA_ENTIDAD_ENTREGANTE_ID');
            $data['CARGA_ENTIDAD_ENTREGANTE'] = $this->entidad_entregantes_model->select(1, array('ENTIDAD'),array('ID' => $this->session->userdata('CARGA_ENTIDAD_ENTREGANTE_ID')));
        }else{
            $data['CARGA_ENTIDAD_ENTREGANTE_ID'] = '';
        }

        $this->usuarios_model->menuGeneral();
        $this->load->view('entregante/insert',$data);
        $this->load->view('templates/footer');
    }

    public function grabar(){

        /////DEVOLVER/////
        $egresado= $this->egresados_model->filas();
        $egresado_id = $egresado[0]['ID']+1;
        //print_r($egresado_id);exit;
        $equipo_id =$_GET['equipo_id'];

        $time = strtotime(date('d-m-Y'));
        $newformat = date('d/M/y',$time);

        $data = array(
            'ID' => $egresado_id,
            'EQUIPO_ID' => intval($equipo_id),
            'EMPLEADO_DEVOLUCION' => intval($this->session->userdata('empleado_id')),
            'TIPO_DEVOLUCION' => 1,
            'PERSONA_DEVOLUCION' => $egresado_id,
            'FECHA_DEVOLUCION' => $newformat,
            'OBS' => strtoupper($_GET['obs'])
        );
        $this->egresados_model->insert($data);
        $this->session->set_flashdata('mensaje', 'Equipo devuelto correctamente');

        //////QUITAR DE ALMACEN /////
        $caja = $this->cajas_model->select_one($equipo_id);
        //print_r($caja);exit;
        $this->cajas_model->quitar_caja($equipo_id);
        $this->cajas_model->update_full($caja['CAJA_ID']);

        //////CAMBIAR ESTADO = 3 DEVUELTO / ///
        $sql2 = "UPDATE EQUIPOS SET ESTADO_ALMACEN=3 WHERE ID=".$equipo_id;
        $this->db->query($sql2);

        redirect(base_url() . "index.php/equipos/verAlmacen");

    }

    public function validarExcelImei(){

        $array = [];
       if($_FILES['archivo']['type']!="application/vnd.ms-excel"){
          $array[0] = 0;
       }else{
         $array[0] = 1;

         $nombrearchivo = $_FILES['archivo']['name'];
         move_uploaded_file($_FILES['archivo']['tmp_name'],$nombrearchivo);
         /** Include READER */
         //require_once dirname(__FILE__) . '/../Classes/READERExcel/reader.php';
         $this->load->library('readexcel');

         //$nombrearchivo = 'prueba.xls';
         // Create new PHPExcel object
         $data = new Spreadsheet_Excel_Reader();
         $data->setOutputEncoding('CP1251');
         $data->read($nombrearchivo);

         $imeis = [];
         for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++){
             if(isset($data->sheets[0]['cells'][$i][1])){
                 $imeis[$i] = $data->sheets[0]['cells'][$i][1];
             }
         }

         $total_imeis = count($imeis);
         $i = 0;
         foreach($imeis as $imei){
           $row = $this->equipos_model->select_one_2($imei);

           $tipo = $_POST['devolucion'];
           if(isset($row)){
              if($tipo==2){
                 if($row['IMEI_FISICO_1']==$row['IMEI_LOGICO_1'] && $row['UBICACION']==1){
                   $i++;
                 }
              }else{
                $i++;
              }
           }
         }

         $array[1] = $total_imeis;
         $array[2] = $i;
       }

       echo json_encode($array);
    }

    public function grabarExcel(){

        if($_FILES['archivo']['type']!="application/vnd.ms-excel"){
            $this->session->set_flashdata('mensaje', 'Error : Solo se permíten archivos excel 97-2003');
            redirect(base_url() . "index.php/equipos/devolucionesExcel");
        }else if ($_FILES['archivo']["error"] > 0){
           echo "Error: " . $_FILES['archivo']['error'] . "<br>";
           redirect(base_url() . "index.php/equipos/devolucionesExcel");
        }else{
            $nombrearchivo = $_FILES['archivo']['name'];
            $_FILES['archivo']['type'];
           ($_FILES["archivo"]["size"] / 1024);
            $_FILES['archivo']['tmp_name'];
        }
        //print_r(base_url());
        move_uploaded_file($_FILES['archivo']['tmp_name'],$nombrearchivo);

        /** Include READER */
        //require_once dirname(__FILE__) . '/../Classes/READERExcel/reader.php';
        $this->load->library('readexcel');

        //$nombrearchivo = 'prueba.xls';
        // Create new PHPExcel object
        $data = new Spreadsheet_Excel_Reader();
        $data->setOutputEncoding('CP1251');
        $data->read($nombrearchivo);


        $imeis = [];
        for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++){
            if(isset($data->sheets[0]['cells'][$i][1])){
                $imeis[$i] = $data->sheets[0]['cells'][$i][1];
            }

        }

       $total_imeis = count($imeis);
       $i = 0;
       foreach($imeis as $imei){

        /////DEVOLVER/////
        $egresado= $this->egresados_model->filas();
        $egresado_id = $egresado[0]['ID']+1;

        $time = strtotime(date('d-m-Y'));
        $newformat = date('d/M/y',$time);

        $row = $this->equipos_model->select_one_2($imei);
        $tipo = $_POST['devolucion'];
        $equipo_id = $row['ID'];
        $data = array(
            'ID' => $egresado_id,
            'EQUIPO_ID' => intval($equipo_id),
            'EMPLEADO_DEVOLUCION' => intval($this->session->userdata('empleado_id')),
            'TIPO_DEVOLUCION' => $tipo,
            'PERSONA_DEVOLUCION' => $egresado_id,
            'FECHA_DEVOLUCION' => $newformat,
            'OBS' => strtoupper($_POST['OBS'])
        );

        if(isset($row)){
           if($tipo==2){
              if($row['IMEI_FISICO_1']==$row['IMEI_LOGICO_1'] && $row['UBICACION']==1){

                /////GUARDAR EN EGRESADOS
                $this->egresados_model->insert($data);

                //////QUITAR DE ALMACEN /////
                $caja = $this->cajas_model->select_one($equipo_id);
                $this->cajas_model->quitar_caja($equipo_id);
                $this->cajas_model->update_full($caja['CAJA_ID']);

                //////CAMBIAR ESTADO = 3 DEVUELTO / ///
                $sql2 = "UPDATE EQUIPOS SET ESTADO_ALMACEN=3 WHERE ID=".$equipo_id;
                $this->db->query($sql2);
                $i++;

              }
           }else{
             /////GUARDAR EN EGRESADOS
             $this->egresados_model->insert($data);

             //////QUITAR DE ALMACEN /////
             $caja = $this->cajas_model->select_one($equipo_id);
             $this->cajas_model->quitar_caja($equipo_id);
             $this->cajas_model->update_full($caja['CAJA_ID']);

             //////CAMBIAR ESTADO = 3 DEVUELTO / ///
             $sql2 = "UPDATE EQUIPOS SET ESTADO_ALMACEN=3 WHERE ID=".$equipo_id;
             $this->db->query($sql2);
             $i++;
           }
        }


      }

      $this->session->set_flashdata('mensaje', 'Devueltos correctamente : '.$i.' de '.$total_imeis);
      //redirect(base_url() . "index.php/equipos/verAlmacen");
      echo base_url()."index.php/equipos/verAlmacen";

    }

    public function editar(){
        $equipo_id = $this->uri->segment(4);
        $data['data_equipo'] = $this->equipos_model->select_custo($equipo_id);
        $data['tipo_documentos'] = $this->tipo_documentos_model->select(3);

        $longitud = strlen($data['data_equipo'][0]['ITEM']);
        $requerida = 6;

        if($longitud < $requerida){
            $ceros = $requerida - $longitud;
        }

        $cadena = $data['data_equipo'][0]['ITEM'];
        for($i=1; $i<=$ceros; $i++){
            $cadena = "0".$cadena;
        }
        $data['data_equipo']['item'] = $cadena;

        $entregante_id = $this->uri->segment(3);
        $data['data_entregante'] = $this->entregantes_model->select(2,'',array('ID'=>$entregante_id));
        $data['ubicacion_fisica'] = $this->ubicacion_fisicas_model->select(3);
        $data['data_entregante']['entregante_id'] = $entregante_id;

        $entidad_entregante_id = $this->entregantes_model->select(1,array('ENTIDAD_ENTREGANTE_ID'), array('ID' => $entregante_id));
        $data['entidad_entregante'] = $this->entidad_entregantes_model->select(3, '', array('ID' => $entidad_entregante_id));
        $data['distritos'] = $this->distritos_model->select(3);

        //ECHO $this->session->userdata('CARGA_OPERADOR_ID');EXIT;
        //echo $this->session->userdata('CARGA_ENTIDAD_ENTREGANTE_ID');exit;
        if($this->session->userdata('CARGA_ENTIDAD_ENTREGANTE_ID') != ''){
            $data['CARGA_ENTIDAD_ENTREGANTE_ID'] = $this->session->userdata('CARGA_ENTIDAD_ENTREGANTE_ID');
        }else{
            $data['CARGA_ENTIDAD_ENTREGANTE_ID'] = '';
        }

        $this->usuarios_model->menuGeneral();
        $this->load->view('entregante/editar',$data);
        $this->load->view('templates/footer');
    }

    public function editar_g(){
        $data = array(
            'TIPO_DOCUMENTO_ID' => $_POST['tipo_documento'],
            'NUMERO_DOCUMENTO' => trim($_POST['NUMERO_DOCUMENTO']),
            'NOMBRES' => strtoupper(trim($_POST['NOMBRES'])),
            'SEXO' => $_POST['SEXO'],
            'ANIO' => $_POST['ANIO'],
            'TELEFONO' => trim($_POST['TELEFONO']),
            'DISTRITO_ID' => $_POST['DISTRITOS'],
            'ENTIDAD_ENTREGANTE_ID' => $_POST['ENTIDAD_ENTREGANTE'],
            'UBICACION_FISICA_ID' => strtoupper(trim($_POST['UBICACION_FISICA'])),
            'MOTIVO_UPDATE' => $_POST['MOTIVO_UPDATE']
        );

        $this->entregantes_model->update($data, $_POST['entregante_id']);
        $this->session->set_flashdata('mensaje', 'Entregante modificado correctamente.');
        redirect(base_url() . "index.php/equipos/index");
    }

}
