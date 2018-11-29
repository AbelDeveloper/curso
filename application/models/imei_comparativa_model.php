<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Imei_comparativa_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function select(){
        return array(
            '0' => 'NO COINCIDE',
            '1' => 'COINCIDE',
            '2' => 'NULO'
        );
    }
}