<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Entregantes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Lima');
        $this->load->model('colores_model');
        $this->load->model('operadores_model');
        $this->load->model('entidad_entregantes_model');
        $this->load->model('distritos_model');
        $this->load->model('entregantes_model');
        $this->load->model('equipos_model');
        $this->load->model('usuarios_model');
        $this->load->model('cargas_model');
        $this->load->model('ubicacion_fisicas_model');
        $this->load->model('tipo_documentos_model');
        $this->load->helper('url');
        $this->load->helper('ayuda');
    }

    public function insert(){
        $equipo_id = $this->uri->segment(3);
        $data['data_equipo'] = $this->equipos_model->select_custo($equipo_id);
        //print_r($data['data_equipo']);
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

        $entregante_id = $this->entregantes_model->filas() + 1;
        $equipo = $this->equipos_model->select_one($_POST['equipo_id']);
        $data = array(
            'ID' => $entregante_id,
            'TIPO_DOCUMENTO_ID' => $_POST['tipo_documento'],
            'NUMERO_DOCUMENTO' => trim($_POST['NUMERO_DOCUMENTO']),
            'NOMBRES' => strtoupper(trim($_POST['NOMBRES'])),
            'SEXO' => $_POST['SEXO'],
            'ANIO' => $_POST['ANIO'],
            'TELEFONO' => trim($_POST['TELEFONO']),
            'DISTRITO_ID' => $_POST['DISTRITOS'],
            'ENTIDAD_ENTREGANTE_ID' => $_POST['ENTIDAD_ENTREGANTE'],
            'EQUIPO_ID' => $_POST['equipo_id'],
            'UBICACION_FISICA_ID' => strtoupper(trim($_POST['UBICACION_FISICA']))
            //'UBICACION_FISICA_ID' => $equipo['UBICACION_FISICA']
        );

        $this->entregantes_model->insert($data);

        if($this->session->userdata('CELULARES_GUARDADOS') >= $this->session->userdata('CARGA_CANTIDAD')){

            $this->session->set_flashdata('mensaje', 'Entregante guardado correctamente !!!!SUPERO LIMITE DE CARGA.');
            $this->cargas_model->update(array('ACTIVO_ID' => 0), $this->session->userdata('CARGA_ID'));
            //echo $this->db->last_query();exit;
            redirect(base_url() . "index.php/equipos/index");
        }else{
            $this->session->set_flashdata('mensaje', 'Entregante guardado correctamente.');
            redirect(base_url() . "index.php/equipos/insert");
        }
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
