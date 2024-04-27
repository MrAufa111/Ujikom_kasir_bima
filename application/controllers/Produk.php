<?php
class Produk extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata("id_user"))) {
            redirect("Login");
        }
    }
    public function index()
    {
        $data['title'] = "Menu Produk";
        $page = 'Produk';

        $where = [
            'aktif' => 1
        ];

        $data['produk'] = $this->DB->fetchWhere($where, 'produk')->result();
        $data['kategori'] = $this->DB->fetch('kategori')->result();

        $this->DB->loader($page, $data);
    }
    public function getKategori()
    {
        $kate = $this->DB->fetch('kategori')->result();

        foreach ($kate as $k) { ?>
            <option value="<?= $k->kode_kategori ?>"><?= $k->nama_kategori ?></option>
        <?php }
    }
    public function tambah()
    {
        date_default_timezone_set('Asia/Jakarta');

        $where = [
            'nama_produk' => $this->input->post('nama_produk')
        ];

        $ceknama = $this->DB->fetchWhere($where, 'produk')->result();

        if (!empty($ceknama)) {
            $this->session->set_flashdata('status', 'ada');
        } else {
            $data = [
                'nama_produk' => $this->input->post('nama_produk'),
                'harga' => $this->input->post('harga'),
                'stok' => $this->input->post('stok'),
                'stok_awal' => $this->input->post('stok'),
                'kategori' => $this->input->post('kategori'),
                'oleh' => $this->session->userdata('id_user'),
                'pada' => date('Y-m-d'),
                'aktif' => 1,
            ];
            $this->DB->insert($data, 'produk');

            $this->session->set_flashdata('status', 'ok');
        }
    }
    public function edit()
    {
        date_default_timezone_set('Asia/Jakarta');
        $where = ['id_produk' => $this->input->post('idp')];

        $cek = $this->DB->fetchWhere($where, "produk")->result();

        foreach ($cek as $k) {
            $stok = $k->stok;
        }


        $data = [
            'nama_produk' => $this->input->post('nama_produk'),
            'harga' => $this->input->post('harga'),
            'kategori' => $this->input->post('kategori'),
        ];
        $this->DB->update($where, $data, 'produk');



        $this->session->set_flashdata('status', 'oke');
        redirect('Produk');
    }
    public function hapus($id)
    {
        $where = [
            'id_produk' => $id
        ];
        $data = [
            'aktif' => 2
        ];
        $this->DB->update($where, $data, 'produk');

        $this->session->set_flashdata('status', 'okh');
        redirect('Produk');
    }
    public function stok()
    {
        $id = $this->input->post('id_produks');
        $op = $this->input->post('operasi');
        $os = $this->input->post('ostok');

        $where = [
            'id_produk' => $id
        ];

        $getStok = $this->DB->fetchWhere($where, 'produk')->result();

        foreach ($getStok as $gs) {
            $stok = $gs->stok;
        }

        if ($os < 0) {
            $this->session->set_flashdata('status', 'min');
        } else if ($os == 0) {
            redirect('produk');
        } else {
            if ($op == "Tambah") {
                $data = [
                    'stok' => $stok + $os
                ];
                $this->DB->update($where, $data, 'produk');

                $data = [
                    'id_produk' => $id,
                    'keterangan' => "Masuk",
                    'jumlah_diubah' => $os,
                    'waktu' => date('Y-m-d')
                ];

                $this->DB->insert($data, "log_stok");
                $this->session->set_flashdata('status', 'add');
                redirect('Produk');
            } else if ($op == "Kurang") {
                $data = [
                    'stok' => $stok - $os
                ];
                $this->DB->update($where, $data, 'produk');

                $data = [
                    'id_produk' => $id,
                    'keterangan' => "Keluar",
                    'jumlah_diubah' => $os,
                    'waktu' => date('Y-m-d')
                ];
                $this->DB->insert($data, "log_stok");
                $this->session->set_flashdata('status', 'remove');
                redirect('Produk');
            }
        }
    }
}
