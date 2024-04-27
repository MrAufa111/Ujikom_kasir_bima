<div class="card border">
    <table class="table table-striped table-bordered tadata">
        <thead>
            <tr>
                <th>
                    #
                </th>
                <th>
                    Kode Penjualan
                </th>
                <th>
                    Tanggal Penjualan
                </th>
                <th>
                    Total Harga
                </th>
                <th style="width: 20%;">
                    Aksi
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($penjualan as $u) {
            ?>
                <tr>
                    <td>
                        <?= $no++ ?>
                    </td>
                    <td>
                        <?= $u->kode_penjualan ?>
                        </<td>
                    <td>
                        <?= $u->tanggal_penjualan ?>
                    </td>
                    <td>
                        <?= $u->total_harga ?>
                    </td>

                    <td class="text-center">
                        <a href="<?= base_url('Transaksi/menu/' . $u->kode_penjualan) ?>" id="edit" class="btn btn-primary edit"><i class="bi bi-box-arrow-up-right"></i></a>
                 <?php if($u->total_harga == NULL){ ?>
                        <button id="hapus" data-idh="<?= $u->kode_penjualan ?>" type="button" class="btn btn-danger hapus"><i class="bi bi-trash"></i></button>
                        <?php } ?>
                    </td>
                </tr>
            <?php
            } ?>
        </tbody>
    </table>
</div>

<script>
    $('.hapus').click(function() {
        var id = $(this).data('idh')
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
                window.location.href = "<?= base_url() ?>Transaksi/hapusTran/" + id
            }
        })
    })
</script>

<?php if ($this->session->userdata('role') != 1) { ?>
    <script>
        $(document).ready(function() {
            $('.tadata').DataTable({
                columnDefs: [{
                    "defaultContent": "-",
                    "targets": "_all"
                }],
                layout: {
                    topStart: {
                        buttons: [{
                            text: '<i class="bi bi-plus-square me-2"></i> Tambah Transaksi',

                            action: function() {
                                window.location.replace("<?= base_url() ?>Transaksi/setKode")
                            }
                        }]
                    }
                }
            })
        })
    </script>
<?php } else { ?>
    <script>
        $(document).ready(function() {
            $('.tadata').DataTable({
                columnDefs: [{
                    "defaultContent": "-",
                    "targets": "_all"
                }],

            })
        })
    </script>
<?php } ?>

<script>
    <?php
    if ($this->session->flashdata('status') == 'ok') { ?>
        $(window).bind("load", function() {
            notif("success", "Member Berhasil Ditambahkan")
        });
    <?php  } else if ($this->session->flashdata('status') == 'oke') {
    ?>
        notif("success", "Member Berhasil Diedit")
    <?php } else if ($this->session->flashdata('status') == 'okh') { ?>
        notif("success", "Member Berhasil Dihapus")
    <?php }  ?>
</script>