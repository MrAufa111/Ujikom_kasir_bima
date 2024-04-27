<?php
class Transaksi extends CI_Controller
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
        $data['title'] = 'Menu Transaksi';
        $page = 'Transaksi/index';

        // $tblJoinA = 'member';
        // $joinA = 'penjualan.id_member = member.id_member';

        // $tblJoinB = 'user';
        // $joinB = 'penjualan.id_petugas = user.id_user';

        if($this->session->userdata("role") == 1)
        {
            $where = "id_petugas != 0";
            $data['penjualan'] = $this->DB->fetchWhere($where, 'penjualan')->result();
        } else
        {
            $data['penjualan'] = $this->DB->fetch('penjualan')->result();
        }


        $this->DB->loader($page, $data);
    }
    public function setKode()
    {
        date_default_timezone_set('Asia/Jakarta');

        $time = date('Ymdhis');

        $KEY = 'kodePenjualan';

        $kode = base64_encode(openssl_encrypt($time, 'aes-128-cbc', $KEY, 0, '8392103930401295'));

        $data = [
            'kode_penjualan' => $kode,
            'tanggal_penjualan' => date('Y-m-d'),
        ];

        $this->DB->insert($data, 'penjualan');

        redirect('Transaksi/menu/' . $kode);
    }
    public function menu($id)
    {
        $data['kode'] = $id;
        $data['title'] = 'Menu Transaksi';
        $page = 'Transaksi/menu';

        $where = [
            'kode_penjualan' => $id
        ];
        $getTanggal = $this->DB->fetchWhere($where, 'penjualan')->result();

        $data['jumlahBarang'] = $this->DB->fetchWhere($where, 'detail_penjualan')->num_rows();

        $tblJoin = 'produk';
        $kodet = $this->input->post('kode_penjualan');
        $join = 'detail_penjualan.id_produk = produk.id_produk';

        $detail = $this->DB->fetchJoinWhere($where, $tblJoin, $join,  'detail_penjualan')->result();

        $totalsum = 0;

        foreach ($detail as $de) {
            $data['hartot'] = $totalsum += $de->sub_total;
        }

        foreach ($getTanggal as $g) {
            $data['tanggal'] = $g->tanggal_penjualan;
            $data['id_petugas'] = $g->id_petugas;
            $data['id_member'] = $g->id_member;
        }

        $data['produk'] = $this->DB->fetch('produk')->result();
        $data['member'] = $this->DB->fetch('member')->result();

        $this->DB->loader($page, $data);
    }
    public function tambahKeranjang()
    {
        $kode = $this->input->post('kode_penjualan');
        $tgl = $this->input->post('tanggal_penjualan');
        $idp = $this->input->post('id_produk');
        $hrg = $this->input->post('harga');
        $jml = $this->input->post('jumlah');

        $where = [
            'id_produk' => $idp
        ];
        $cek_stok = $this->DB->fetchWhere($where, 'produk')->result();

        foreach ($cek_stok as $c) {
            $stok = $c->stok;
        }



        if ($jml > $stok) {
            $this->session->set_flashdata('status', 'lebih');
            $par = "Lebih";
            echo $par;
        } else {
            $subtotal = $jml * $hrg;

            $where = [
                'kode_penjualan' => $kode,
                'id_produk' => $idp,
            ];
            $isAda = $this->DB->fetchWhere($where, 'detail_penjualan')->result();

            if (empty($isAda)) {
                $data = [
                    'kode_penjualan' => $kode,
                    'id_produk' => $idp,
                    'jumlah' => $jml,
                    'sub_total' => $subtotal,
                ];

                $this->DB->insert($data, 'detail_penjualan');
                $this->session->set_flashdata('status', 'ok');
                redirect("Transaksi/menu/" . $kode);
            } else {
                foreach ($isAda as $i) {
                    $nowJml = $i->jumlah;
                }

                $fixJml = $nowJml + $jml;

                if ($fixJml > $stok) {
                    $par = "Lebih";
                    echo $par;
                } else {
                    $fixSubtotal = $fixJml * $hrg;

                    $data = [
                        'jumlah' => $fixJml,
                        'sub_total' => $fixSubtotal
                    ];

                    $this->DB->update($where, $data, 'detail_penjualan');


                    $where = [
                        'id_produk' => $idp,
                    ];



                    $upjml = $stok - $jml;

                    $data = [
                        'stok' => $upjml
                    ];

                    $this->DB->update($where, $data, 'produk');

                    $this->session->set_flashdata('status', 'oke');
                    redirect("Transaksi/menu/" . $kode);
                }
            }
        }
    }
    public function getKeranjang()
    {
        $where = [
            'kode_penjualan' => $this->input->post('kode_penjualan')
        ];

        $cekId = $this->DB->fetchWhere($where, 'penjualan')->result();

        foreach ($cekId as $ci)
        {
            $idPetugas =  $ci->id_petugas;
        }

        $tblJoin = 'produk';
        $kodet = $this->input->post('kode_penjualan');
        $join = 'detail_penjualan.id_produk = produk.id_produk';

        $get = $this->DB->fetchJoinWhere($where, $tblJoin, $join,  'detail_penjualan')->result();


        $no = 1;
        foreach ($get as $g) { ?>

            <tr>
                <td>
                    <?= $no++ ?>
                </td>
                <td>
                    <?= $g->nama_produk ?>
                </td>
                <td>
                    <?= $g->harga ?>
                </td>
                <td style="width: 30%;">
                    <div class="input-group">
                        <input <?php if($idPetugas != NULL){echo "readonly";} ?> type="number" name="jumlah" id="" value="<?= $g->jumlah ?>" class="form-control">
<?php if($idPetugas == NULL){ ?>
                        <button data-harga="<?= $g->harga ?>" data-kode="<?= $kodet ?>" data-idp="<?= $g->id_produk ?>" type="button" class="btn btn-success quty">Ubah</button>
<?php } ?>
                    </div>
                </td>
                <td>
                    <?= $g->sub_total ?>
                </td>
                <?php if($idPetugas == NULL){ ?>
                <td>
                    <button data-kode="<?= $kodet ?>" data-idh="<?= $g->id_detail ?>" type="button" class="btn hapus"><i class="bi bi-trash"></i></button>
                </td>
<?php }?>
            </tr>

        <?php }
        ?>
        <script>
            $('.quty').click(function() {
                var jml = $(this).closest('.input-group').find('input[name="jumlah"]').val()

                $.ajax({
                    url: "<?= base_url() ?>Transaksi/setJumlah",
                    method: "POST",
                    data: {
                        kode_penjualan: $(this).data('kode'),
                        id_produk: $(this).data('idp'),
                        harga: $(this).data('harga'),
                        jumlah: jml
                    },
                    success: function(par) {
                        if (par == "Lebih") {
                            notif("error", "Jumlah Melebihi Stok")
                        } else {
                            location.reload(function() {
                                alert('dd')
                            })
                        }
                        getKeranjang()

                    },
                    error: function(e) {
                        console.log(e.responseText)
                    }
                })
            })
        </script>
        <script>
            $('.hapus').click(function() {
                var id = $(this).data('idh')
                var kd = $(this).data('kode')
                Swal.fire({
                    title: 'Yakin Menghapus?',
                    type: 'warning',
                    text: 'Data Akan Dihapus Permanen',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batalkan'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "<?= base_url() ?>Transaksi/hapusBrg/" + id + "/" + kd
                    }
                })
            })
        </script>
    <?php  }

    public function setJumlah()
    {
        $kode = $this->input->post('kode_penjualan');
        $idp = $this->input->post('id_produk');
        $jml = $this->input->post('jumlah');
        $hrg = $this->input->post('harga');

        $where = [
            'id_produk' => $idp
        ];
        $cek_stok = $this->DB->fetchWhere($where, 'produk')->result();

        foreach ($cek_stok as $c) {
            $stok = $c->stok;
        }

        $where = [
            'kode_penjualan' => $kode,
            'id_produk' => $idp,
        ];
        $cek = $this->DB->fetchWhere($where, 'detail_penjualan')->result();

        foreach ($cek as $ce) {
            $nowJumlah = $ce->jumlah;
        }

        $valid = $jml - $nowJumlah;




        if ($valid > $stok) {
            $par = "Lebih";
            echo $par;
        } else {
            $where = [
                'kode_penjualan' => $kode,
                'id_produk' => $idp,
            ];

            $subtotal = $jml * $hrg;

            $data = [
                'jumlah' => $jml,
                'sub_total' => $subtotal
            ];

            $this->DB->update($where, $data, 'detail_penjualan');

            if ($jml < $nowJumlah) {
                $hit = $nowJumlah - $jml;
                $fix = $stok + $hit;

                $where = [
                    'id_produk' => $idp
                ];
                $data = ['stok' => $fix];

                $this->DB->update($where, $data, 'produk');
            } else if ($jml > $nowJumlah) {

                $hit = $jml - $nowJumlah;
                $fix = $stok - $hit;

                $where = [
                    'id_produk' => $idp
                ];
                $data = ['stok' => $fix];

                $this->DB->update($where, $data, 'produk');
            }

            $this->session->set_flashdata('status', 'oke');
            redirect("Transaksi/menu/" . $kode);
        }
    }
    // public function cekStok()
    // {
    //     $jml = $this->input->post('jumlah');
    //     $idp = $this->input->post('id_produk');

    //     $where = [
    //         'id_produk' => $idp
    //     ];

    //     $getStok = $this->DB->fetchWhere($where, 'produk')->result();

    //     foreach($getStok as $g)
    //     {
    //         $stok = $g->stok;
    //     }

    //     if($jml > $getStok)
    // }
    public function hapusBrg($id, $kd)
    {
        $where = [
            'id_detail' => $id
        ];
        $this->DB->delete($where, 'detail_penjualan');
        $this->session->set_flashdata('status', 'okh');

        redirect('Transaksi/menu/' . $kd);
    }
    public function cekDiskon()
    {
        $where = [
            'kode_penjualan' => $this->input->post('kode_penjualan'),
        ];

        $cekBarang = $this->DB->fetchWhere($where, 'detail_penjualan')->num_rows();

        if ($cekBarang > 2) {
            $nom = $this->input->post('total');

            $getDiskon = $this->DB->hitungDiskon($nom)->result();

            if (empty($getDiskon)) {
                $data = [
                    "persen" => 0,
                    "hitung" => 0,
                    "akhir" => $nom
                ];
                echo json_encode($data);
            } else {
                foreach ($getDiskon as $gd) {
                    $persen = $gd->persen;
                }
                $hitung = $nom * ($persen / 100);

                $akhir = $nom - $hitung;

                $data = [
                    "persen" => $persen,
                    "hitung" => $hitung,
                    "akhir" => $akhir
                ];
                echo json_encode($data);
            }
        }
    }

    public function bayar()
    {

        date_default_timezone_set("Asia/Jakarta");

        $kode = $this->input->post('kode_penjualan');
        $total = $this->input->post('total_harga');
        $idm = $this->input->post('id_member');
        $idu = $this->session->userdata('id_user');
        $kembalian = $this->input->post('kembalian');
        $membayar = $this->input->post('membayar');

        $toko = $this->DB->fetch('master_toko')->result();

        $where = [
            'kode_penjualan' => $kode
        ];

        foreach ($toko as $t) {
            $nama = $t->nama_toko;
            $no_hp = $t->no_hp;
            $email = $t->email;
            $alamat = $t->alamat;
        }

        $tblJoin = "produk";

        $join = "detail_penjualan.id_produk = produk.id_produk";

        $produk = $this->DB->fetchJoinWhere($where, $tblJoin, $join, "detail_penjualan")->result();

        foreach ($produk as $pro) {
            $data = [
                'id_produk' => $pro->id_produk,
                'keterangan' => "Keluar",
                'jumlah_diubah' => $pro->jumlah,
                'waktu' => date('Y-m-d')
            ];

            $this->DB->insert($data, "log_stok");
        }

        $data = [
            'total_harga' => $total,
            'id_member' => $idm,
            'id_petugas' => $idu,
            'membayar' => $membayar,
            'kembalian' => $kembalian,
        ];

        $this->DB->update($where, $data, "penjualan");
    ?>
        <style>
            .garis {
                border-bottom: 4px dashed black;
                width: 100%;
            }
        </style>

        <div class="container">
            <div class="p-3 text-center">
                <h4><?= $nama ?></h4>
                <h4><?= $alamat ?></h4>
                <h4><?= $no_hp ?></h4>
                <h4><?= $email ?></h4>

                <h4 class="garis mt-2">
            </div>
        </div>
        <div class="container">
            <div class="p-3 text-center">
                <h6 style="float: left;"><?= date('Y-m-d h:i:s') ?></h6>
                <h6 style="float: right;"><?= $kode ?></h6>

                <h4 class="garis mt-5">
            </div>
        </div>
        <div class="container">
            <div class="p-3">
                <?php foreach ($produk as $p) { ?>
                    <div class="row">
                        <div class="col-12">
                            <h5><?= $p->nama_produk ?></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <h5><?= $p->jumlah ?> x <?= $p->harga ?>.00</h5>
                        </div>
                        <div class="col-6">
                            <h5 style="float: right;"><?= $p->sub_total ?></h5>
                        </div>
                    </div>
                <?php } ?>

                <h4 class="garis mt-2">
            </div>
        </div>
        <div class="container">
            <div class="p-3">
                <div class="row">
                    <div class="col-6">
                        <h5>Total Rp. </h5>
                    </div>
                    <div class="col-6">
                        <h5 style="float:right"><?= $total ?>.00 </h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <h5>Bayar Rp. </h5>
                    </div>
                    <div class="col-6">
                        <h5 style="float:right"><?= $membayar ?>.00 </h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <h5>Kembalian Rp. </h5>
                    </div>
                    <div class="col-6">
                        <h5 style="float:right"><?= $kembalian ?>.00 </h5>
                    </div>
                </div>
                <h4 class="garis mt-2">
            </div>
        </div>
        <div class="container">
            <div class="p-3 text-center">
                <h5>**Terima Kasih Telah Berbelanja**</h5>
            </div>
        </div>

<?php

    }
    public function struk()
    {
        $data = [
            'kode_penjualan' => $this->input->post('kode_penjualan'),
            'struk' => trim(preg_replace('/\s+/', ' ', $this->input->post('par')))
        ];

        $this->DB->insert($data, "struk");
    }
    public function hapusTran($id)
    {
        $where = [
            'kode_penjualan' => $id
        ];

        $cek = $this->DB->fetchWhere($where, 'detail_penjualan')->result();

        if (!empty($cek)) {
            $this->DB->delete($where, 'detail_penjualan');
        }

        $this->DB->delete($where, 'penjualan');

        $this->session->set_flashdata('status', 'okh');

        redirect('Transaksi/' . $id);
    }
    public function getStruk()
    {
        $kode = $this->input->post("kode_penjualan");

        $where = [
            'kode_penjualan' => $kode
        ];
        $get = $this->DB->fetchWhere($where, 'struk')->result();

        foreach($get as $g)
        {
            $par = $g->struk;
        }
        echo($par);
    }
}
