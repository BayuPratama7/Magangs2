<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AlterDb extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $this->db->query("ALTER TABLE mahasiswa ALTER COLUMN no_hp TYPE TEXT");
        $this->db->query("ALTER TABLE mahasiswa ALTER COLUMN kelas TYPE VARCHAR(255)");
        echo "Success";
    }
}
