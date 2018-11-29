<?php

class Usuarios_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function select($modo, $select = array(), $condicion = array(), $order = '') {

        if ($select == '')
            $select = array();
        if ($condicion == '')
            $condicion = array();

        $where = '';
        foreach ($condicion as $key => $value) {
            if ($value == 'IS NULL') {
                $where .= " AND $key " . $value;
            } else {
                $where .= " AND $key = '" . $value . "' ";
            }
        }

        $campos = ($select == array()) ? '*' : implode(", ", $select);
        $sql = "SELECT " . $campos . " FROM USUARIOS WHERE 1 = 1 " . $where . " " . $order;
        $query = $this->db->query($sql);

        switch ($modo) {
            case '1':
                $resultado = '';
                if ($query->num_rows() > 0) {
                    $row = $query->row_array();
                    $resultado = $row[$campos];
                }
                return $resultado;

            case '2':
                $row = array();
                if ($query->num_rows() > 0) {
                    $row = $query->row_array();
                }
                return $row;

            case '3':
                $rows = array();
                foreach ($query->result_array() as $row) {
                    $rows[] = $row;
                }
                return $rows;
        }
    }

    public function login($usuario, $password) {
            $this->db->where(array('USUARIO' => $usuario,
                                'PASSWORD' => $password))
                ->select('ID, NOMBRES, APELLIDO_PATERNO, APELLIDO_MATERNO, TELEFONO, NIVEL, USUARIO')
                ->from('USUARIOS');

        $consulta = $this->db->get();

        if ($consulta->num_rows() > 0) {
            $consulta_dato = $consulta->row();
            $data = array(
                'empleado_id' => $consulta_dato->ID,
                'nombres' => $consulta_dato->NOMBRES,
                'apellido_paterno' => $consulta_dato->APELLIDO_PATERNO,
                'apellido_materno' => $consulta_dato->APELLIDO_MATERNO,
                'telefono' => $consulta_dato->TELEFONO,
                'nivel' => $consulta_dato->NIVEL,
                'usuario' => $consulta_dato->USUARIO
            );
            $this->session->set_userdata($data);

            if($consulta_dato->NIVEL == 1){
                $nivel_descripcion = 'ADMINISTRADOR';
            }
            if($consulta_dato->NIVEL == 2){
                $nivel_descripcion = 'DIGITADOR';
            }



            $this->session->set_userdata('nivel_descripcion', $nivel_descripcion);

            $this->session->set_flashdata('mensaje', 'Datos Correctos');
            return $consulta_dato->ID;
        }else{
            $this->session->set_flashdata('mensaje', 'Datos Incorrectos o personal sin acceso');
            return FALSE;
        }

    }

    public function select_max_id(){
        //$sql = "select id from USUARIOS order by id DESC FETCH FIRST 1 ROWS ONLY";
        $sql = "select id from USUARIOS WHERE ROWNUM = 1 order by id DESC";
        $query = $this->db->query($sql);

        $resultado = '';
        $row = $query->row_array();
        $resultado = $row['ID'];
        return $resultado;
    }

    public function menuGeneral(){
        switch ($this->session->userdata('nivel')) {
            case 1:
                $this->load->view('templates/header_administrador');
                break;
            case 2:
                $this->load->view('templates/header_digitador');
                break;

            default:
                break;
        }
    }

}
