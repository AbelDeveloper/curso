<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Entregantes_model extends CI_Model {

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
        $sql = "SELECT " . $campos . " FROM ENTREGANTES WHERE 1 = 1 " . $where . " " . $order;
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

    public function select_custo($id = ''){

        $where = "";
        if($id != '') $where = " AND TRE.id = " . $id;

        $sql = "SELECT
                TRE.ID ENTREGANTE_ID,
                TRE.DNI,
                TRE.NOMBRES,
                TRE.SEXO,
                TRE.ANIO,
                TRE.TELEFONO,
                TRE.DISTRITO_ID,
                TRE.ANIO,
                TRE.UBICACION_FISICA,
                ENT.ID ENTIDAD_ENTREGANTE_ID
                FROM ENTREGANTES TRE
                INNER JOIN ENTIDAD_ENTREGANTES ENT
                ON ENT.ID = TRE.ENTIDAD_ENTREGANTE_ID
                INNER JOIN DISTRITOS DIS
                ON DIS.ID = TRE.DISTRITO_ID
                WHERE 1 = 1 " . $where;

        $query = $this->db->query($sql);

        $rows = array();
        foreach ($query->result_array() as $row) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function select_one($equipo_id){
      $sql = "SELECT * FROM ENTREGANTES WHERE EQUIPO_ID=".$equipo_id;
      $query = $this->db->query($sql);
      $row = $query->row_array();
      return $row;
    }

    public function insert($data) {
        $this->db->insert('ENTREGANTES', $data);
        $this->session->set_flashdata('mensaje', 'Ingresado correctamente.');
    }

    public function update($data, $where, $mensaje = '') {
        $this->db->where('ID', $where);
        $this->db->update('ENTREGANTES', $data);
        if ($mensaje == '') {
            $mensaje = 'Modificado correctamente.';
        }

        $this->session->set_flashdata('mensaje', $mensaje);
    }

    public function filas(){
        $sql = "select count(id) FILAS from ENTREGANTES";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row['FILAS'];
    }

    public function select_max_id(){
        $sql = "select id from ENTREGANTES WHERE ROWNUM = 1 order by id DESC";
        $query = $this->db->query($sql);

        $resultado = '';
        $row = $query->row_array();
        $resultado = $row['ID'];
        return $resultado;
    }


}
