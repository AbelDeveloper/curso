<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class estado_conservacion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Lima');
        $this->load->model('usuarios_model');
        $this->load->model('conservacion_estados_model');
        $this->load->model('observacion_inoperatividades_model');
        $this->load->helper('url');
        $this->load->helper('ayuda');
    }

    public function index(){
        $data['conservacion_estado'] = $this->conservacion_estados_model->select(3);

        $this->session->set_userdata('menu',8);

        $this->usuarios_model->menuGeneral();
        $this->load->view('estado_conservacion/index',$data);
        $this->load->view('templates/footer');
    }


    public function grabar(){

        $est_con = $this->observacion_inoperatividades_model->consulta_repeticion(strtoupper(trim($_POST['new'])),$_POST['estado']);
        if($_POST['estado']!=0){
          if(count($est_con)==0){
              $obs_id = $this->observacion_inoperatividades_model->filas_2() + 1;
              $data = array(
                  'ID' => $obs_id,
                  'OBSERVACION_INOPERATIVIDAD' => strtoupper(trim($_POST['new'])),
                  'CONSERVACION_ESTADO_ID' => $_POST['estado'],
                  'ESTADO' => 1
              );
              $this->observacion_inoperatividades_model->insert($data);
              redirect(base_url() . "index.php/estado_conservacion/index");
          }else{
            if($est_con[0]['ESTADO']==0){
              $this->observacion_inoperatividades_model->grabar_update($est_con[0]['ID']);
              $this->session->set_flashdata('mensaje', 'Observación restaurada.');
              redirect(base_url() . "index.php/estado_conservacion/index");
            }else{
              $this->session->set_flashdata('mensaje', 'Observación ya ingresado.');
              redirect(base_url() . "index.php/estado_conservacion/index");
            }
          }
        }else{
            $this->session->set_flashdata('mensaje', 'Seleccione estado de conservación.');
            redirect(base_url() . "index.php/estado_conservacion/index");
        }
    }




    public function listar(){
        $id = $this->input->get('id');
        $array = $this->observacion_inoperatividades_model->select_2($id);
        echo json_encode($array);
    }

    public function editar($obs_id){

        $sql = "SELECT * FROM OBSERVACION_INOPERATIVIDADES WHERE ID=".$obs_id;
        $query = $this->db->query($sql);
        $rows = $query->result_array();

        $datos['data'] =  $rows[0];


        $this->usuarios_model->menuGeneral();
        $this->load->view('estado_conservacion/editar', $datos);
        $this->load->view('templates/footer');
    }

    public function editar_g(){
        $obs = $_POST['obs'];
        $id = $_POST['id'];

        $sql = "UPDATE OBSERVACION_INOPERATIVIDADES SET OBSERVACION_INOPERATIVIDAD='".$obs."' WHERE ID=".$id;
        $this->db->query($sql);

        $this->session->set_flashdata('mensaje', 'Observación modificado correctamente.');
        redirect(base_url() . "index.php/estado_conservacion/index");

    }


    public function eliminar($obs_id){
        $sql = "UPDATE OBSERVACION_INOPERATIVIDADES SET ESTADO=0 WHERE ID=".$obs_id;
        $this->db->query($sql);

        $this->session->set_flashdata('mensaje', 'Observación eliminado correctamente.');
        redirect(base_url() . "index.php/estado_conservacion/index");
    }
}
