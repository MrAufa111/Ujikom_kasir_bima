<?php
class Dashboard extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        if(empty($this->session->userdata("id_user")))
        {
            redirect("Login");
        }
    }
    public function index()
    {
        $page = 'Dashboard';
        $data['title'] = 'Dashboard';

        $data['user'] = $this->DB->fetch("user")->num_rows();
        $data['produk'] = $this->DB->fetch("produk")->num_rows();

        $where = "id_petugas != 0";

        $data['penjualan'] = $this->DB->fetchWhere($where, "penjualan")->num_rows();
        
        $this->DB->loader($page, $data);
    }
}