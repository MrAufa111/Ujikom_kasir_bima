<?php
class User extends CI_Controller
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
        $page = 'User';
        $data['title'] = 'Menu User';

        $data['user'] = $this->DB->fetch('user')->result();

        $this->DB->loader($page, $data);
    }

    public function tambah()
    {

        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $KEY = 'Biima';

        $pw = base64_encode(openssl_encrypt($password, 'aes-128-cbc', $KEY, 0, '8281929182918291'));

        $where = [
            'email' => $email
        ];
        $cek = $this->DB->fetchWhere($where, 'user')->num_rows();

        if ($cek == 0) {
            $data = [
                'nama_lengkap' => $this->input->post('nama_lengkap'),
                'email' => $email,
                'password' => $pw,
                'role' => $this->input->post('role'),
               
            ];

            $this->DB->insert($data, 'user');

            $this->session->set_flashdata('status', 'ok');
            redirect('User');
        } else {
            $this->session->set_flashdata('status', 'ada');

            redirect('User');
        }
    }

    public function edit()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $KEY = 'Biima';

        $pw = base64_encode(openssl_encrypt($password, 'aes-128-cbc', $KEY, 0, '8281929182918291'));

        $where = [
            'id_user' => $this->input->post('id_user')
        ];
        $ceka = $this->DB->fetchWhere($where, 'user')->result();

        foreach ($ceka as $ca) {
            $emailu  = $ca->email;
        }
        if ($email == $emailu) {
            $where = [
                'id_user' => $this->input->post('id_user')
            ];

            $data = [
                'nama_lengkap' => $this->input->post('nama_lengkap'),
                'email' => $email,
                'password' => $pw,
                'role' => $this->input->post('role'),
            ];

            $this->DB->update($where, $data, 'user');
            
            $this->session->set_flashdata('status', 'oke');

            redirect('User');
        } else {

            $where = [
                'email' => $email,
            ];
            $cek = $this->DB->fetchWhere($where, 'user')->num_rows();

            if ($cek == 0) {
                $where = [
                    'id_user' => $this->input->post('id_user')
                ];

                $data = [
                    'nama_lengkap' => $this->input->post('nama_lengkap'),
                    'email' => $email,
                    'password' => $pw,
                    'role' => $this->input->post('role'),
                ];

                $this->DB->update($where, $data, 'user');
                $this->session->set_flashdata('status', 'oke');

                redirect('User');
            } else {
            $this->session->set_flashdata('status', 'ada');

                redirect('User');
            }
        }
    }
    public function hapus($id)
    {
        $where = [
            'id_user' => $id
        ];
        $this->DB->delete($where, 'user');
        $this->session->set_flashdata('status', 'okh');

        redirect('User');
    }
}
