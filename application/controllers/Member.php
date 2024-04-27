<?php
class Member extends CI_Controller
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
        $data['title'] = 'Menu Member';
        $page = 'Member';
        $data['member'] = $this->DB->fetch('member')->result();

        $this->DB->loader($page, $data);
    }
    public function tambah()
    {
        $data = [
            'nama_member' => $this->input->post('nama_member'),
            'no_hp' => $this->input->post('no_hp'),
            'alamat' => $this->input->post('alamat'),
        ];

        $this->DB->insert($data, 'member');

        $this->session->set_flashdata('status', 'ok');

        redirect('Member');
    }
    public function edit()
    {
        $where = [
            'id_member' => $this->input->post('id_member'),
        ];
        $data = [
            'nama_member' => $this->input->post('nama_member'),
            'alamat' => $this->input->post('alamat'),
            'no_hp' => $this->input->post('no_hp'),
        ];

        $this->DB->update($where, $data, 'member');
        $this->session->set_flashdata('status', 'oke');

        redirect('Member');
    }
    public function hapus($id)
    {
        $where = ['id_member' => $id];

        $this->DB->delete($where,'member');

        $this->session->set_flashdata('status', 'okh');

        redirect('Member');
    }
}
