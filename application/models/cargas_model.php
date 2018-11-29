<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cargas_model extends CI_Model {

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
        $sql = "SELECT " . $campos . " FROM CARGAS WHERE 1 = 1 " . $where . " " . $order;
        //echo $sql."<br>";
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
                //var_dump($row);exit;
                return $row;

            case '3':
                $rows = array();
                foreach ($query->result_array() as $row) {
                    $rows[] = $row;
                }
                return $rows;
        }
    }
    
    public function select_custo(){
        $sql = "SELECT 
        CA.FECHA FECHA, CA.ID CANTIDAD_ID, CA.CANTIDAD, CA.USUARIO_ID, CA.ACTIVO_ID, 
        USU.NOMBRES, USU.APELLIDO_PATERNO, 
        ENT.ENTIDAD, 
        AC.ACTIVO 
        FROM CARGAS CA 
        JOIN USUARIOS USU ON CA.USUARIO_ID = USU.ID 
        JOIN ENTIDAD_ENTREGANTES ENT ON CA.ENTIDAD_ENTREGANTE_ID = ENT.ID 
        JOIN ACTIVOS AC ON CA.ACTIVO_ID = AC.ID 
        ORDER BY CA.FECHA DESC";
        $query = $this->db->query($sql);
        $rows = array();
        foreach ($query->result_array() as $row) {
            $rows[] = $row;
        }
        return $rows;        
    }

    public function insert($data) {
        $this->db->insert('CARGAS', $data);
        $this->session->set_flashdata('mensaje', 'Ingresado correctamente.');
    }

    public function update($data, $where, $mensaje = '') {
        $this->db->where('ID', $where);
        $this->db->update('CARGAS', $data);
        if ($mensaje == '') {
            $mensaje = 'Modificado correctamente.';
        }
        //echo $this->db->last_query();exit;
        $this->session->set_flashdata('mensaje', $mensaje);
    }
    
    public function filas(){
        $sql = "select count(ID) FILAS from CARGAS";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row['FILAS'];        
    }
    
    public function activarCarga($fecha, $usuario_id, $activo_id){
        //para activar
        if($activo_id == 0){
            //1ro todos desactivos
            $sql2 = "UPDATE CARGAS SET ACTIVO_ID = 0 WHERE USUARIO_ID = " . $usuario_id;
            $this->db->query($sql2);
            
            //2do activo el que me interesa
            $sql = "UPDATE CARGAS SET ACTIVO_ID = 1 WHERE FECHA = '" . $fecha . "' AND USUARIO_ID = " . $usuario_id;            
            $this->db->query($sql);            
        }
        //para desactivar
        if($activo_id == 1){
            $sql = "UPDATE CARGAS SET ACTIVO_ID = 0 WHERE FECHA = '" . $fecha . "' AND USUARIO_ID = " . $usuario_id;
            $this->db->query($sql);            
        }
        
    }

    
}
