<div class="container">
    <div class="card border p-3">
        <table class="table table-striped table-bordered tadata">
            <thead>
                <tr>
                    <th>
                        #
                    </th>
                    <th>
                        Nama Produk
                    </th>
                    <th>
                        Harga Satuan
                    </th>
                    <th>
                        Stok
                    </th>
                    <th>
                        Kategori
                    </th>
                    <?php if ($this->session->userdata('role') == 1) { ?>
                        <th style="width: 20%;">
                            Aksi
                        </th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($produk as $p) {

                    ?>
                    <tr>
                        <td>
                            <?= $no++ ?>
                        </td>
                        <td>
                            <?= $p->nama_produk ?>
                            </<td>
                        <td>
                            <?= $p->harga ?>
                        </td>
                        <td>
                            <?= $p->stok ?>
                        </td>
                        <td>
                            <?= $p->kategori ?>
                        </td>
                        <?php if ($this->session->userdata('role') == 1) { ?>
                            <td class="text-center">
                                <button data-nama="<?= $p->nama_produk ?>" data-harga="<?= $p->harga ?>"
                                    data-stok="<?= $p->stok ?>" data-kategori="<?= $p->kategori ?>"
                                    data-idp="<?= $p->id_produk ?>" class="btn btn-primary edit"><i
                                        class="bi bi-gear"></i></button>
                                <button data-ipro="<?= $p->id_produk ?>" id="hapus" type="button"
                                    class="btn btn-danger hapus"><i class="bi bi-trash"></i></button>
                            </td>
                        <?php } ?>
                    </tr>
                    <?php
                } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah -->

<div class="modal fade modalForm" id="modalTambah" tabindex="-1" data-bs-keyboard="false" role="dialog"
    aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">
                    Tambah Produk
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <label for="" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="nama_produk" required>
                        </div>
                        <div class="col-6">
                            <label for="" class="form-label">Harga</label>
                            <input type="text" class="form-control" id="harga" required>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <label for="" class="form-label">Stok</label>
                            <input type="text" class="form-control" id="stok" required>
                        </div>
                        <div class="col-6">
                            <label for="" class="form-label">Kategori</label>
                            <div class="input-group">
                                <select required id="kategori" class="form-select kateg">

                                </select>
                                <div class="btn btn-success taka"><i class="bi bi-plus-circle mt-3"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="addProduk" type="button" class="btn btn-primary">Simpan Produk</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->

<div class="modal fade modalForm" id="modalEdit" tabindex="-1" data-bs-keyboard="false" role="dialog"
    aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">
                    Edit Produk
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('Produk/edit/') ?>" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <label for="" class="form-label">Nama Produk</label>
                            <input name="idp" type="hidden" id="id_produk">
                            <input name="nama_produk" type="text" class="form-control" id="nama_produke" required>
                        </div>
                        <div class="col-6">
                            <label for="" class="form-label">Harga</label>
                            <input name="harga" type="text" class="form-control" id="hargae" required>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <label for="" class="form-label">Stok</label>
                            <div class="input-group">
                                <input readonly name="stok" type="text" class="form-control" id="stoke" required>
                                <div onclick="$('#modalStok').modal('show')" class="btn btn-success estok input-group-text"><i class="bi bi-gear"></i></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="" class="form-label">Kategori</label>
                            <div class="input-group">
                                <select required name="kategori" id="kategorie" class="form-select kateg">

                                </select>
                                <div class="btn btn-success taka input-group-text"><i class="bi bi-plus-circle"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="editProduk" type="submit" class="btn btn-primary">Simpan Produk</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Kategori -->
<div class="modal fade" id="modalKat" tabindex="-1" data-bs-keyboard="false" role="dialog"
    aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">
                    Tambah Kategori
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <label for="" class="form-label">Kode Kategori</label>
                            <input oninput="this.value = this.value.toUpperCase()" id="koka" type="text" maxlength="3"
                                class="form-control" name="kode_kategori" required>
                        </div>
                        <div class="col-6">
                            <label for="" class="form-label">Nama Kategori</label>
                            <input id="naka" type="text" class="form-control" name="nama_kategori" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="sika" type="button" class="btn btn-primary">Simpan kategori</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Stok -->
<div class="modal fade" id="modalStok" tabindex="-1" data-bs-keyboard="false" role="dialog"
    aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">
                    Edit Stok
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?=base_url()?>Produk/stok" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <label for="" class="form-label">Operasi</label>
                            <input type="hidden" name="id_produks" id="id_produks">
                            <select name="operasi" id="" class="form-select">
                                <option value="Tambah">Tambah</option>
                                <option value="Kurang">Kurang</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" name="ostok" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="sika" type="submit" class="btn btn-primary">Set</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php if ($this->session->userdata('role') == 1) { ?>
    <script>
        $(document).ready(function () {
            $('.tadata').DataTable({
                columnDefs: [{
                    "defaultContent": "-",
                    "targets": "_all"
                }],
                layout: {
                    topStart: {
                        buttons: [{
                            text: '<i class="bi bi-plus-square me-2"></i> Tambah Produk',

                            action: function () {
                                $('#modalTambah').modal('show')
                            }
                        }]
                    }
                }
            })
        })
    </script>
<?php } else { ?>
    <script>
        $(document).ready(function () {
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
    $('.edit').click(function () {
        $('#modalEdit').modal('show')
        $('#id_produk').val($(this).data('idp'))
        $('#nama_produke').val($(this).data('nama'))
        $('#stoke').val($(this).data('stok'))
        $('#hargae').val($(this).data('harga'))
        $('#kategorie').val($(this).data('kategorie')).change()
        $('#id_produks').val($(this).data('idp'))

    })
</script>

<script>
    $('.hapus').click(function () {
        var id = $(this).data('ipro')
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
                window.location.href = "<?= base_url() ?>Produk/hapus/" + id
            }
        })
    })
</script>

<script>
    $('.taka').click(function () {
        $('#modalKat').modal('show')
    })
</script>

<script>
    $('.modalForm').on('show.modal.bs', function () {
        $.ajax({
            url: "<?= base_url() ?>Produk/getKategori",
            type: 'POST',
            success: function (data) {
                $('.kateg').html(data)
            }
        })
    })
</script>

<script>
    $('#modalKat').on('show.bs.modal', function () {
        $('#modalTambah').modal('hide')


    })
</script>
<script>
    $('#modalKat').on('hidden.bs.modal', function () {
        $('#modalTambah').modal('show')
    })
</script>
<script>
    $('#sika').click(function () {
        $.ajax({
            url: "<?= base_url() ?>Kategori/tambah",
            type: 'POST',
            data: {
                kode_kategori: $('#koka').val(),
                nama_kategori: $('#naka').val()
            },
            success: function () {
                $('#modalKat').modal('hide')
                notif("success", "Berhasil Menambahkan Kategori")
            }
        })
    })
</script>

<script>
    $('#addProduk').click(function () {

        if ($('#nama_barang').val() == '' || $('#kategori').val() == '' || $('#harga').val() == '' || $('#stok').val() == '') {
            notif('error', 'Harap isi semua kolom')
        }

        $.ajax({
            url: "<?= base_url() ?>Produk/tambah",
            type: 'POST',
            data: {
                nama_produk: $('#nama_produk').val(),
                kategori: $('#kategori').val(),
                harga: $('#harga').val(),
                stok: $('#stok').val(),
            },
            success: function () {
                $('#modalTambah').modal('hide')
                location.reload()



            }
        })
    })


    <?php
    if ($this->session->flashdata('status') == 'ok') { ?>
        $(window).bind("load", function () {
            notif("success", "Produk Berhasil Ditambahkan")
        });
    <?php } else if ($this->session->flashdata('status') == 'oke') {
        ?>
            notif("success", "Produk Berhasil Diedit")
    <?php } else if ($this->session->flashdata('status') == 'okh') { ?>
                notif("success", "Produk Berhasil Dihapus")
    <?php } else if ($this->session->flashdata('status') == 'ada') { ?>
                    notif("error", "Produk Sudah Ada")
    <?php } else if ($this->session->flashdata('status') == 'min') { ?>
                    notif("error", "Jumlah kurang dari 0")
    <?php } else if ($this->session->flashdata('status') == 'add') { ?>
                    notif("success", "Berhasil Ditambah")
    <?php } else if ($this->session->flashdata('status') == 'remove') { ?>
                    notif("success", "Berhasil Dikurang")
    <?php } ?>
</script>