<?php
class Master_toko extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata("id_user"))) {
            redirect("Login");
        } else if ($this->session->userdata("role") != 1) {
            redirect("Dashboard");
        }
    }
    public function index()
    {
        $data['title'] = 'Master Toko';
        $page = 'master_toko';

        // $tblJoinA = 'member';
        // $joinA = 'penjualan.id_member = member.id_member';

        // $tblJoinB = 'user';
        // $joinB = 'penjualan.id_petugas = user.id_user';

        $data['master'] = $this->DB->fetch('master_toko')->result();

        $this->DB->loader($page, $data);
    }
    public function edit()
    {
        $where = ['id' => $this->input->post('id')];

        $data = [
            'nama_toko' => $this->input->post('nama_toko'),
            'email' => $this->input->post('email'),
            'no_hp' => $this->input->post('no_hp'),
            'alamat' => $this->input->post('alamat'),
        ];

        $this->DB->update($where, $data, "master_toko");

        $this->session->set_flashdata('status', 'oke');

        redirect('Master_toko');
    }
}
