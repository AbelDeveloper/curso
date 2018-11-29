<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modelos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Lima');
        $this->load->model('usuarios_model');
        $this->load->model('modelos_model');
        $this->load->model('marcas_model');

        $this->load->helper('url');
        $this->load->helper('ayuda');
    }

    public function index(){
        $modelos = $this->modelos_model->selectCusto();
        $data['modelos'] = $this->modelos_model->formatCusto($modelos);

        $this->session->set_userdata('menu',6);

        $this->usuarios_model->menuGeneral();
        $this->load->view('modelos/index', $data);
        $this->load->view('templates/footer');
    }

    public function guardar(){
        $this->usuarios_model->menuGeneral();
        $data['marcas'] = $this->marcas_model->select(3);

        $this->load->view('modelos/guardar', $data);
        $this->load->view('templates/footer');
    }

    public function grabar(){


        $descripcion_marca = $this->modelos_model->consulta_repeticion(strtoupper(trim($_POST['modelo'])),$_POST['marca']);

          if(count($descripcion_marca)==0){
                $modelo_id = $this->modelos_model->filas() + 1;
              $data = array(
                'ID' => $modelo_id,
                'MODELO' => strtoupper(trim($_POST['modelo'])),
                'MARCA_ID' => $_POST['marca'],
                'ESTADO' => 1
              );
              $this->modelos_model->insert($data);
              redirect(base_url() . "index.php/modelos/index");
          }else{
            if($descripcion_marca[0]['ESTADO']==0){
              $this->modelos_model->grabar_update($descripcion_marca[0]['ID']);
              $this->session->set_flashdata('mensaje', 'Modelo restaurada.');
              redirect(base_url() . "index.php/modelos/index");
            }else{
              $this->session->set_flashdata('mensaje', 'Modelo ya ingresado.');
              redirect(base_url() . "index.php/modelos/index");
            }
          }

    }

    public function editar(){
        $datos['data'] = $this->modelos_model->selectCusto($this->uri->segment(3));
        $datos['marcas'] = $this->marcas_model->select(3);
        //var_dump($data['marcas']);exit;

        $this->usuarios_model->menuGeneral();
        $this->load->view('modelos/editar', $datos);
        $this->load->view('templates/footer');
    }

    public function editar_g(){
        $modelo_id = $_POST['MODELO_ID'];
        $marca_id = $_POST['MARCA'];
        $descripcion_modelo = $this->modelos_model->select(1 , array('MODELO'), array('MODELO' => strtoupper(trim($_POST['modelo']))));
        if($descripcion_modelo == ''){
            $data = array(
                'MODELO' => strtoupper(trim($_POST['MODELO'])),
                'MARCA_ID' => $marca_id
            );
            $this->modelos_model->update($data, $modelo_id);
            $this->session->set_flashdata('mensaje', 'Modelo modificado correctamente.');
            redirect(base_url() . "index.php/modelos/index");
        }else{
            $this->session->set_flashdata('mensaje', 'Modelo ya ingresado.');
            redirect(base_url() . "index.php/modelos/editar/".$modelo_id);
        }
    }

    public function eliminar($modelo_id){
        $sql = "UPDATE MODELOS SET ESTADO=0 WHERE ID=".$modelo_id;
        $this->db->query($sql);

        $this->session->set_flashdata('mensaje', 'Modelo eliminado correctamente.');
        redirect(base_url() . "index.php/modelos/index");
    }
}
