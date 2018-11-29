<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class entidad_entregantes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Lima');
        $this->load->model('usuarios_model');
        $this->load->model('entidad_entregantes_model');

        $this->load->helper('url');
        $this->load->helper('ayuda');
    }

    public function index(){
        $data['entidades'] = $this->entidad_entregantes_model->select(3);
        
        $this->session->set_userdata('menu',4);
        
        $this->usuarios_model->menuGeneral();
        $this->load->view('entidad_entregantes/index', $data);
        $this->load->view('templates/footer');
    }

    public function guardar(){
        $this->usuarios_model->menuGeneral();
        $this->load->view('entidad_entregantes/guardar');
        $this->load->view('templates/footer');
    }

    public function grabar(){
        $entidad_id = $this->entidad_entregantes_model->filas() + 1;
        $descripcion_entidad = $this->entidad_entregantes_model->select(1 , array('ENTIDAD'), array('ENTIDAD' => strtoupper(trim($_POST['entidad']))));
        if($descripcion_entidad == ''){
            $data = array(            
                'ID' => $entidad_id,
                'ENTIDAD' => strtoupper(trim($_POST['entidad']))
            );
            $this->entidad_entregantes_model->insert($data);        
            redirect(base_url() . "index.php/entidad_entregantes/index");
        }else{
            $this->session->set_flashdata('mensaje', 'Entidad entregable ya ingresada.');
            redirect(base_url() . "index.php/entidad_entregantes/guardar");
        }
    }
    
    public function editar(){
        $entidad_entregante_id = $this->uri->segment(3);
        $datos['data'] = $this->entidad_entregantes_model->select(2,'',array('ID' => $entidad_entregante_id));
                
        $this->usuarios_model->menuGeneral();
        $this->load->view('entidad_entregantes/editar', $datos);
        $this->load->view('templates/footer');
    }
    
    public function editar_g(){
        $entidad_id = $_POST['id'];
        $descripcion_entidad = $this->entidad_entregantes_model->select(1 , array('ENTIDAD'), array('ENTIDAD' => strtoupper(trim($_POST['entidad']))));
        if($descripcion_entidad == ''){
            $data = array(
                'ENTIDAD' => strtoupper(trim($_POST['entidad']))
            );
            $this->entidad_entregantes_model->update($data, $entidad_id);        
            $this->session->set_flashdata('mensaje', 'Entidad modificada correctamente.');
            redirect(base_url() . "index.php/entidad_entregantes/index");
        }else{
            $this->session->set_flashdata('mensaje', 'Entidad entregable ya ingresada.');
            redirect(base_url() . "index.php/entidad_entregantes/editar/".$entidad_id);
        }        
    }
}