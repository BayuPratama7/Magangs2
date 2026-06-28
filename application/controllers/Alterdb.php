<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alterdb extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $this->db->query("UPDATE dosen SET is_dpl = true, is_penguji = true");
        echo "Success updating dosen to DPL and Penguji";
    }
}
