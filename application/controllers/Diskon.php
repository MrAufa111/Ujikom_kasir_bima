<?php
class Diskon extends CI_Controller
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
        $data['title']  = "Menu Diskon";
        $page = 'Diskon';
        $data['diskon'] = $this->DB->fetch('diskon')->result();

        $this->DB->loader($page, $data);
    }
    public function tambah()
    {
        $nom = $this->input->post('nominal');
        $per = $this->input->post('persenan');

        $data = [
            'minimal' => $nom,
            'persen' => $per,
        ];
        $this->DB->insert($data, 'diskon');

        $this->session->set_flashdata('status', 'ok');

        redirect('Diskon');
    }
    public function edit()
    {
        $nom = $this->input->post('nominal');
        $per = $this->input->post('persenan');
        $id = $this->input->post('id_diskon');

        $where = [
            'id_diskon' => $id
        ];

        $data = [
            'minimal' => $nom,
            'persen' => $per,
        ];
        $this->DB->update($where, $data, 'diskon');

        $this->session->set_flashdata('status', 'oke');

        redirect('Diskon');
    }
    public function hapus($id)
    {
        $where = [
            'id_diskon' => $id
        ];
        $this->DB->delete($where, 'diskon');
        $this->session->set_flashdata('status', 'okh');

        redirect('Diskon');
    }
}
