<?php
class Kategori extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        if(empty($this->session->userdata("id_user")))
        {
            redirect("Login");
        }
    }
    public function tambah()
    {
        $data = [
            'kode_kategori' => $this->input->post('kode_kategori'),
            'nama_kategori' => $this->input->post('nama_kategori'),
        ];

        $this->DB->insert($data, 'kategori');
    }
}
