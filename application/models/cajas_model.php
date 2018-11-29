<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cajas_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->table = 'cajas';
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
    
    public function select_2(){
        $sql = "SELECT * FROM CAJAS ORDER BY ID ASC";
        $query = $this->db->query($sql);
        $rows = array();
                foreach ($query->result_array() as $row) {
                    $rows[] = $row;
                }
                return $rows;
        
    }

    public function insert($data) {
        $this->db->insert($this->table, $data);
        $this->session->set_flashdata('mensaje', 'Ingresado correctamente.');
    }
    
    /*public function insert_2() {
       
        $a=0;
        for($i=299;$i<=323;$i++){
            $a++;
            $sql = "INSERT INTO CAJAS VALUES($i,'Z-$a',0,4,6,34)";
            $this->db->query($sql);
        }
    }*/

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
        $sql = "select count(ID) FILAS from $this->table";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row['FILAS'];        
    }
    
    public function ubicar_caja($equipo_id){
        $sql = "SELECT id CAJA_ID FROM CAJAS WHERE FULL = 0 ORDER BY ID";
        $query = $this->db->query($sql);
        
        $row = array();
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
        }
        return $row;
    }
    
    public function update_full($caja_id){
        
        $sql = "SELECT * FROM CAJA_EQUIPOS WHERE CAJA_ID =".$caja_id;
        
        $query = $this->db->query($sql);
        $nueva_cantidad = $query->num_rows();
            
        $sql2 = "UPDATE CAJAS SET CANTIDAD =".$nueva_cantidad." WHERE ID =".$caja_id;
         $this->db->query($sql2);
         
    }
    
    public function update_full_2($nueva_cantidad,$caja_id){
       
 
         $sql2 = "UPDATE CAJAS SET CANTIDAD =".$nueva_cantidad." WHERE ID =".$caja_id;
         $this->db->query($sql2);
      
 
    }
    
    public function consulta_full($caja_id){
        $sql = "SELECT full FROM CAJAS WHERE ID=".$caja_id;
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row['FILAS'];    
    }
    
    public function quitar_caja($equipo_id){
        $sql = "DELETE FROM CAJA_EQUIPOS WHERE EQUIPO_ID=".$equipo_id;
        $query = $this->db->query($sql);
    }
    
    public function select_one($equipo_id){
         $sql = "SELECT * FROM CAJA_EQUIPOS WHERE EQUIPO_ID=".$equipo_id;
         $query = $this->db->query($sql);
         $row = $query->row_array();
         return $row;
         
    }
    
    
    
}