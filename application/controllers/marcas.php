<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class marcas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Lima');
        $this->load->model('usuarios_model');
        $this->load->model('marcas_model');

        $this->load->helper('url');
        $this->load->helper('ayuda');
    }

    public function index(){
        $data['marcas'] = $this->marcas_model->select(3, '', '', ' ORDER BY ID ASC ');
        
        $this->session->set_userdata('menu',5);
        
        $this->usuarios_model->menuGeneral();
        $this->load->view('marcas/index', $data);
        $this->load->view('templates/footer');
    }

    public function guardar(){
        $this->usuarios_model->menuGeneral();
        $this->load->view('marcas/guardar');
        $this->load->view('templates/footer');
    }

    public function grabar(){
        $carga_digitador_id = $this->marcas_model->filas() + 1;
        
        $descripcion_marca = $this->marcas_model->select(1 , array('MARCA'), array('MARCA' => strtoupper(trim($_POST['marca']))));
        if($descripcion_marca == ''){
            $data = array(            
                'ID' => $carga_digitador_id,
                'MARCA' => strtoupper(trim($_POST['marca'])),
                'ESTADO' => 1
            );
            $this->marcas_model->insert($data);        
            redirect(base_url() . "index.php/marcas/index");
        }else{
            $this->session->set_flashdata('mensaje', 'Marca ya ingresada.');
            redirect(base_url() . "index.php/marcas/guardar");
        }                
        
    }
    
    
    public function lista(){
        $data['cargas'] = $this->cargas_model->select_custo();        
        
        $this->usuarios_model->menuGeneral();
        $this->load->view('cargas/lista', $data);
        $this->load->view('templates/footer');         
    }
    
    public function editar(){
        $datos['data'] = $this->marcas_model->select(2,'',array('ID'=> $this->uri->segment(3)));
        
        $this->usuarios_model->menuGeneral();
        $this->load->view('marcas/editar', $datos);
        $this->load->view('templates/footer');
    }
    
    public function editar_g(){
        $marca_id = $_POST['id'];
        $descripcion_marca = $this->marcas_model->select(1 , array('MARCA'), array('MARCA' => strtoupper(trim($_POST['marca']))));
        if($descripcion_marca == ''){
            $data = array(
                'MARCA' => strtoupper(trim($_POST['marca']))
            );
            $this->marcas_model->update($data, $marca_id);        
            $this->session->set_flashdata('mensaje', 'Marca modificada correctamente.');
            redirect(base_url() . "index.php/marcas/index");
        }else{
            $this->session->set_flashdata('mensaje', 'Marca ya ingresada.');
            redirect(base_url() . "index.php/marcas/editar/".$marca_id);
        }        
    }
    
    public function eliminar($marca_id){
        $sql = "UPDATE MARCAS SET ESTADO=0 WHERE ID=".$marca_id;
        $this->db->query($sql);
        
        $this->session->set_flashdata('mensaje', 'Marca eliminado correctamente.');
         redirect(base_url() . "index.php/marcas/index");
    }
    
}