<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Observacion_inoperatividades_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // $modo: 1 = campo (1 solo campo), 2 = registro (mas de un campo), 2 = tabla (mas de 1 registro)
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
        $sql = "SELECT " . $campos . " FROM OBSERVACION_INOPERATIVIDADES WHERE ESTADO=1 AND 1 = 1 " . $where . " " . $order;
        //echo $sql;exit;
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



    public function insert($data) {
        $this->db->insert('OBSERVACION_INOPERATIVIDADES', $data);
        $this->session->set_flashdata('mensaje', 'Ingresado correctamente.');
    }

    public function update($data, $where, $mensaje = '') {
        $this->db->where('ID', $where);
        $this->db->update('OBSERVACION_INOPERATIVIDADES', $data);
        if ($mensaje == '') {
            $mensaje = 'Modificado correctamente.';
        }
        //echo $this->db->last_query();exit;
        $this->session->set_flashdata('mensaje', $mensaje);
    }

    public function filas(){
        $sql = "select count(ID) FILAS from OBSERVACION_INOPERATIVIDADES";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row['FILAS'];
    }

    public function filas_2(){
        $sql = "select max(ID) FILAS from OBSERVACION_INOPERATIVIDADES";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row['FILAS'];
    }

   public function select_2($estado_id){
        $sql = "SELECT * FROM OBSERVACION_INOPERATIVIDADES WHERE ESTADO=1 AND CONSERVACION_ESTADO_ID=".$estado_id." ORDER BY ID DESC";
        $query = $this->db->query($sql);
        $result = $query->result_array();

        return $result;
    }


    ///////////////////// VALIDACION CONSULTA //////////////
    public function consulta_repeticion($obs,$estado_id){
       $sql = "SELECT * FROM OBSERVACION_INOPERATIVIDADES WHERE OBSERVACION_INOPERATIVIDAD='".$obs."' AND CONSERVACION_ESTADO_ID=".$estado_id;
       $query = $this->db->query($sql);
       $result = $query->result_array();
       return $result;
    }

    public function grabar_update($obs_id){
       $this->db->set('ESTADO',1);
       $this->db->where('ID',$obs_id);
       $this->db->update('OBSERVACION_INOPERATIVIDADES');
    }


}
