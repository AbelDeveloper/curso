<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Modelos_model extends CI_Model {

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
        $sql = "SELECT * FROM MODELOS WHERE ESTADO=1 AND 1 = 1 " . $where . " " . $order;
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

    public function select_one($modelo_id){
      $sql = "SELECT * FROM MODELOS WHERE ID=".$modelo_id;
      $query = $this->db->query($sql);
      $row = $query->row_array();
      return $row;
    }

    public function selectCusto($modelo_id = ''){

        $where = '';
        if($modelo_id != ''){
           $where = " AND mo.id = " . $modelo_id;
        }

        $sql = "select
        ma.id marca_id,
        ma.marca,
        mo.id modelo_id,
        mo.modelo,
        mo.estado estado,
        ma.estado estado_marca
        from marcas ma
        inner join modelos mo on ma.id = mo.marca_id WHERE 1 = 1 " . $where . " order by marca, modelo_id ASC";
        //echo $sql;exit;
        $query = $this->db->query($sql);
        $rows = array();
        foreach ($query->result_array() as $row) {
                $rows[] = $row;
        }
        return $rows;
    }

    public function formatCusto($data){
       $array = array();
        foreach ($data as $value){
            $array[$value['MARCA_ID']]['marca'] = $value['MARCA'];
            //$array[$value['MARCA_ID']]['estado'] = $value['ESTADO'];
            $array[$value['MARCA_ID']]['estado_marca'] = $value['ESTADO_MARCA'];
            $array[$value['MARCA_ID']]['modelos'][$value['MODELO_ID']]['NAME'] = $value['MODELO'];
            $array[$value['MARCA_ID']]['modelos'][$value['MODELO_ID']]['ESTADO'] = $value['ESTADO'];
            //$array[$value['MARCA_ID']]['modelos'][$value['ESTADO']] = $value['ESTADO'];
        }
        return $array;
        //print_r($array);
    }

    public function insert($data) {
        $this->db->insert('MODELOS', $data);
        $this->session->set_flashdata('mensaje', 'Ingresado correctamente.');
    }

    public function update($data, $where, $mensaje = '') {
        $this->db->where('ID', $where);
        $this->db->update('MODELOS', $data);
        if ($mensaje == '') {
            $mensaje = 'Modificado correctamente.';
        }
        //echo $this->db->last_query();exit;
        $this->session->set_flashdata('mensaje', $mensaje);
    }

    public function filas(){
        $sql = "select count(ID) FILAS from MODELOS";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row['FILAS'];
    }

    ///////////////////// VALIDACION CONSULTA //////////////
    public function consulta_repeticion($obs,$estado_id){
       $sql = "SELECT * FROM MODELOS WHERE MODELO='".$obs."' AND MARCA_ID=".$estado_id;
       $query = $this->db->query($sql);
       $result = $query->result_array();
       return $result;
    }

    public function grabar_update($obs_id){
       $this->db->set('ESTADO',1);
       $this->db->where('ID',$obs_id);
       $this->db->update('MODELOS');
    }


}
