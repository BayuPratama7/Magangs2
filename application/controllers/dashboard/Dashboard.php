<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        check_login();

        // HANYA SEKRETARIS PRODI & KETUA PRODI
        check_role([1, 3]);
    }

    public function index()
    {
        $this->load->view('dashboard/index');
    }
}
