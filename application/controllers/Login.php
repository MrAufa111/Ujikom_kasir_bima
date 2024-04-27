<?php
class Login extends CI_Controller
{
    public function index()
    {
        if (!empty($this->session->userdata("id_user"))) {
            redirect("Dashboard");
        } else {
            $this->load->view('Login');
        }
    }
    public function auth()
    {
        $eemail = $this->input->post('email');
        $password = $this->input->post('password');

        $KEY = 'Biima';

        $pw = base64_encode(openssl_encrypt($password, 'aes-128-cbc', $KEY, 0, '8281929182918291'));

        $where = [
            'email' => $eemail,
            'password' => $pw
        ];

        $cek_akun = $this->DB->fetchWhere($where, 'user');

        if ($cek_akun->num_rows() == 0) {
            redirect('Login');
            $this->session->set_flashdata('status', 'salah');
        } else {
            $akun = $cek_akun->result();

            foreach ($akun as $a) {
                $id_user = $a->id_user;
                $nama_lengkap = $a->nama_lengkap;
                $email = $a->email;
                $role = $a->role;
            }

            $this->session->set_userdata('id_user', $id_user);
            $this->session->set_userdata('email', $email);
            $this->session->set_userdata('nama_lengkap', $nama_lengkap);
            $this->session->set_userdata('role', $role);

            redirect('Dashboard');
        }
    }
    public function out()
    {
        $this->session->sess_destroy();
        redirect("Login");
    }
}