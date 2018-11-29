<?php

class Variables_model extends CI_Model {

    public $constante_base_url = 'http://192.168.1.52:8080/celulares/';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();                
        
    }
    
   
}