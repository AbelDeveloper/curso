<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Acceso extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Lima');
        $this->load->model('usuarios_model');
        $this->load->model('cargas_model');
        $this->load->model('equipos_model');
        $this->load->helper('url');
        $this->load->helper('ayuda');
    }

    public function index(){         
        $this->load->view('templates/header_sin_menu');
        $this->load->view('login/index');
        $this->load->view('templates/footer');        
    }
    
    public function login(){                
        $login = $this->usuarios_model->login($_POST['usuario'],$_POST['password']);
        
        if($login){
                        
            switch ($this->session->userdata('nivel')) {
            case 1://administradores
                redirect(base_url() . "index.php/cargas/index");
                break;
            case 2://digitadores
                $carga = $this->cargas_model->select(2,'', array('ACTIVO_ID' => 1, 'USUARIO_ID' => $this->session->userdata('empleado_id')));                
                $celulares_guardados = (count($carga) > 0) ? $this->equipos_model->equiposPorCarga($carga['ID']) : '';

                $data = array(
                    'CARGA_ID' => $carga['ID'],
                    'CARGA_CANTIDAD' => $carga['CANTIDAD'],
                    'CARGA_FECHA' => $carga['FECHA'],
                    'CARGA_ENTIDAD_ENTREGANTE_ID' => $carga['ENTIDAD_ENTREGANTE_ID'],
                    'CELULARES_GUARDADOS' => $celulares_guardados
                );                                                
                $this->session->set_userdata($data);
                
                if((count($carga) == 0) || ($this->session->userdata('CELULARES_GUARDADOS') >= $this->session->userdata('CARGA_CANTIDAD'))){
                    redirect(base_url() . "index.php/equipos/index");
                }else{
                    redirect(base_url() . "index.php/equipos/insert");    
                }                                
                break;            

            default:
                break;
            }                        
        }else{
            redirect(base_url() . "index.php/acceso/index");
        }                
    }
    
    function logout() {     
        $this->session->sess_destroy();
        redirect(base_url());
    }
    
    public function ingreso(){         
        $this->load->view('templates/header_sin_menu');
        $this->load->view('login/ingreso');
        $this->load->view('templates/footer');        
    }
        
}