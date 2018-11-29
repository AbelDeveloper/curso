<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Colores extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Lima');
        $this->load->model('usuarios_model');
        $this->load->model('colores_model');

        $this->load->helper('url');
        $this->load->helper('ayuda');
    }

    public function index(){
        $data['colores'] = $this->colores_model->select(3);
        
        $this->session->set_userdata('menu',7);
        
        $this->usuarios_model->menuGeneral();
        $this->load->view('colores/index', $data);
        $this->load->view('templates/footer');
    }

    public function guardar(){
        $this->usuarios_model->menuGeneral();
        $this->load->view('colores/guardar');
        $this->load->view('templates/footer');
    }

    public function grabar(){
        $carga_digitador_id = $this->colores_model->filas() + 1;
        
        $descripcion_color = $this->colores_model->select(1 , array('COLOR'), array('COLOR' => strtoupper(trim($_POST['color']))));
        if($descripcion_color == ''){
            $data = array(
                'ID' => $carga_digitador_id,
                'COLOR' => strtoupper(trim($_POST['color'])),
                'ESTADO' => 1
            );
            $this->colores_model->insert($data);
            redirect(base_url() . "index.php/colores/index");
        } else {
            $this->session->set_flashdata('mensaje', 'Color ya ingresada.');
            redirect(base_url() . "index.php/colores/guardar");
        }        
    }
    
    public function editar(){
        $datos['data'] = $this->colores_model->select(2,'',array('ID'=> $this->uri->segment(3)));
        
        $this->usuarios_model->menuGeneral();
        $this->load->view('colores/editar', $datos);
        $this->load->view('templates/footer');
    }
    
    public function editar_g(){
        $color_id = $_POST['id'];
        $descripcion_color = $this->colores_model->select(1 , array('COLOR'), array('COLOR' => strtoupper(trim($_POST['color']))));
        if($descripcion_color == ''){
            $data = array(
                'COLOR' => strtoupper(trim($_POST['color']))
            );
            $this->colores_model->update($data, $color_id);        
            $this->session->set_flashdata('mensaje', 'Color modificado correctamente.');
            redirect(base_url() . "index.php/colores/index");
        }else{
            $this->session->set_flashdata('mensaje', 'Color ya ingresado.');
            redirect(base_url() . "index.php/colores/editar/".$color_id);
        }        
    }

    public function lista(){
        $data['colores'] = $this->colores_model->select_custo();

        $this->usuarios_model->menuGeneral();
        $this->load->view('colores/lista', $data);
        $this->load->view('templates/footer');
    }
    
    public function eliminar($color_id){
        $sql = "UPDATE COLORES SET ESTADO=0 WHERE ID=".$color_id;
        $this->db->query($sql);
        
        $this->session->set_flashdata('mensaje', 'Color eliminado correctamente.');
         redirect(base_url() . "index.php/colores/index");
    }
}