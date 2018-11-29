<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Egresados_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->table = 'egresados';
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
        $sql = "SELECT " . $campos . " FROM $this->table WHERE 1 = 1 " . $where . " " . $order;
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
        $this->db->insert('EGRESADOS', $data);
        $this->session->set_flashdata('mensaje', 'Ingresado correctamente.');
    }

    public function update($data, $where, $mensaje = '') {
        $this->db->where('ID', $where);
        $this->db->update($this->table, $data);
        if ($mensaje == '') {
            $mensaje = 'Modificado correctamente.';
        }
        //echo $this->db->last_query();exit;
        $this->session->set_flashdata('mensaje', $mensaje);
    }
    
    public function filas(){
        
        $this->db->select_max('ID'); 
        $consulta = $this->db->get('EGRESADOS'); 
        return $consulta->result_array();         
    }
    
}