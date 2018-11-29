<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cargas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Lima');
        $this->load->model('usuarios_model');
        $this->load->model('cargas_model');
        $this->load->model('operadores_model');
        $this->load->model('activos_model');
        $this->load->model('entidad_entregantes_model');

        $this->load->helper('url');
        $this->load->helper('ayuda');
    }
    
    public function index(){
        $data['cargas'] = $this->cargas_model->select_custo();        
        
        $this->session->set_userdata('menu',3);
        
        
        
        $this->usuarios_model->menuGeneral();
        $this->load->view('cargas/index', $data);
        $this->load->view('templates/footer');         
    }

    public function nuevo(){
        $data['entidad_entregante'] = $this->entidad_entregantes_model->select(3);
        
        $data['usuarios'] = $this->usuarios_model->select(3,'',array('NIVEL' => 2));
        $data['fecha_actual'] = date("d-m-Y");

        $this->usuarios_model->menuGeneral();
        $this->load->view('cargas/nuevo', $data);
        $this->load->view('templates/footer');
    }

    public function grabar(){
        $carga_digitador_id = $this->cargas_model->filas() + 1;
        
        $data = $_POST['FECHA'];
        $fecha_carga = substr($data,0,2)."-". listar_meses_ingles(substr($data,3,2))."-".substr($data,8,2);
        
        $where = array(
            'USUARIO_ID' => $_POST['usuarios'],
            'FECHA' => $fecha_carga);
        $filas = $this->cargas_model->select(2, '',$where);
        
        if(count($filas) == 0){
            $data = array(
                'ID' => $carga_digitador_id,
                'CANTIDAD' => $_POST['cantidad_celulares'],
                'ENTIDAD_ENTREGANTE_ID' => $_POST['entidad_entregante'],
                'FECHA' => $fecha_carga,
                'USUARIO_ID' => $_POST['usuarios'],
                'ACTIVO_ID' => 0
            );
            $this->cargas_model->insert($data);
            redirect(base_url() . "index.php/cargas/index");
        }else{
            $this->session->set_flashdata('mensaje', 'Usuario ya tiene carga para esta fecha.');
            redirect(base_url() . "index.php/cargas/nuevo");
        }        
        
    }
    
    public function activar(){
        $fecha = $this->uri->segment(3);
        $usuario_id = $this->uri->segment(4);
        $activo_id = $this->uri->segment(5);

        $this->cargas_model->activarCarga($fecha, $usuario_id, $activo_id);        
        $data['cargas'] = $this->cargas_model->select_custo();

        $this->usuarios_model->menuGeneral();
        $this->load->view('cargas/index', $data);
        $this->load->view('templates/footer');
    }    

}