<?php
class Laporan extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        if(empty($this->session->userdata("id_user")))
        {
            redirect("Login");
        }else if ($this->session->userdata("role") != 1) {
            redirect("Dashboard");
        }
    }
    public function stok()
    {
        $data['title'] = 'Laporan Stok';
        $page = 'Laporan/stok';

        $this->DB->loader($page, $data);
    }
    public function getStok()
    {
        error_reporting(0);
        $awal = $this->input->post('awal');
        $akhir = $this->input->post('akhir');

        $awal = $this->DB->getStok($awal, $akhir, "produk")->result();



        if (!empty($awal)) { ?>

            <table class="table table-striped table-border tadata">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Keterangan</th>
                        <th>Jumlah</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($awal as $m) {
                    ?>



                        <tr>
                            <td>
                                <?= $m->nama_produk ?>
                            </td>
                            <td>
                                Baru Ditambahkan
                            </td>
                            <td>
                                <?= $m->stok_awal ?>
                            </td>
                            <td>
                                <?= $m->pada ?>
                            </td>
                        </tr>



                    <?php
                    } ?>



                    <?php   } else {
                    echo "<td></td>";
                }



                $tblJoin = "produk";
                $join = "log_stok.id_produk = produk.id_produk";
                $after = $this->DB->getStokJoin($tblJoin, $join, $awal, $akhir, "log_stok")->result();

                if (!empty($after)) {
                    foreach ($after as $a) { ?>
                        <tr>
                            <td><?= $a->nama_produk ?>
                            <td><?= $a->keterangan ?>
                            <td><?= $a->jumlah_diubah ?>
                            <td><?= $a->waktu ?>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>

            <script>
                var awal = $('#awal').val()
                var akhir = $('#akhir').val()
                $(".tadata").DataTable({
                    layout: {
                        topStart: {
                            buttons: [{
                                extend: 'excel',
                                text: 'Export Ke Excel',
                                filename: 'Laporan Transaksi' + awal + ' - ' + akhir,
                                exportOptions: {
                                    modifier: {
                                        page: 'current'
                                    }
                                }
                            }]
                        }
                    }
                })
            </script>

        <?php
                } else {
                    echo "<td></td>";
                }
            }
            public function transaksi()
            {
                $data['title'] = 'Laporan Transaksi';
                $page = 'Laporan/transaksi';

                $this->DB->loader($page, $data);
            }

            public function getTransaksi()
            {
                $awal = $this->input->post('awal');
                $akhir = $this->input->post('akhir');

                $get = $this->DB->getTransaksi($awal, $akhir, 'penjualan')->result();

                if (!empty($get)) { ?>

            <table class="table table-striped table-border tadata">
                <thead>
                    <tr>
                        <th>
                            Kode Penjualan
                        </th>
                        <th>
                            Tanggal Penjualan
                        </th>
                        <th>
                            Total Harga
                        </th>
                    </tr>
                </thead>
                <tbody id="isi">



                    <?php
                    foreach ($get as $g) { ?>
                        <tr>
                            <td>
                                <?= $g->kode_penjualan ?>
                            </td>
                            <td>
                                <?= $g->tanggal_penjualan ?>
                            </td>
                            <td>
                                <?= $g->total_harga ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <script>
                var awal = $('#awal').val()
                var akhir = $('#akhir').val()
                $(".tadata").DataTable({
                    layout: {
                        topStart: {
                            buttons: [{
                                extend: 'excel',
                                text: 'Export Ke Excel',
                                filename: 'Laporan Transaksi' + awal + ' - ' + akhir,
                                exportOptions: {
                                    modifier: {
                                        page: 'current'
                                    }
                                }
                            }]
                        }
                    }
                })
            </script>
<?php
                }
            }
        }
