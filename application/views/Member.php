<div class="container">
    <div class="card border p-3">
        <table class="table table-striped table-bordered tadata">
            <thead>
                <tr>
                    <th>
                        #
                    </th>
                    <th>
                        Nama Lengkap
                    </th>
                    <th>
                        No. HP
                    </th>
                    <th style="width: 20%;">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($member as $m) {
                ?>
                    <tr>
                        <td>
                            <?= $no++ ?>
                        </td>
                        <td>
                            <?= $m->nama_member ?>
                            </<td>
                        <td>
                            <?= $m->no_hp ?>
                        </td>

                        <td class="text-center">
                            <button data-nama="<?= $m->nama_member ?>" data-no="<?= $m->no_hp ?>" data-alamat="<?= $m->alamat ?>" data-idm="<?= $m->id_member ?>" id="edit" class="btn btn-primary edit"><i class="bi bi-gear"></i></button>
                            <button data-imem="<?= $m->id_member ?>" id="hapus" type="button" class="btn btn-danger hapus"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                <?php
                } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">
                    Tambah Member
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('Member/tambah') ?>" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <label for="" class="form-label">Nama Member</label>
                            <input type="text" class="form-control" name="nama_member" required>
                        </div>
                        <div class="col-6">
                            <label for="" class="form-label">No. HP</label>
                            <input type="number" class="form-control" name="no_hp" required>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <label for="" class="form-label">Alamat</label>
                            <textarea name="alamat" id="" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan Member</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">
                    Edit Member
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('Member/edit') ?>" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <label for="" class="form-label">Nama Member</label>
                            <input id="nama" type="text" class="form-control" name="nama_member" required>
                            <input type="hidden" id="id_member" name="id_member">
                        </div>
                        <div class="col-6">
                            <label for="" class="form-label">No. HP</label>
                            <input id="no" type="number" class="form-control" name="no_hp" required>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <label for="" class="form-label">Alamat</label>
                            <textarea name="alamat" id="alamat" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan Member</button>
                </div>
            </form>
        </div>
    </div>
</div>

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
                        text: '<i class="bi bi-plus-square me-2"></i> Tambah Member',

                        action: function() {
                            $('#modalTambah').modal('show')
                        }
                    }]
                }
            }
        })
    })
</script>



<script>
    $('#edit').click(function() {
        $('#modalEdit').modal('show')

        $('#id_member').val($(this).data('idm'))
        $('#nama').val($(this).data('nama'))
        $('#no').val($(this).data('no'))
        $('#alamat').html($(this).data('alamat'))
    })
</script>

<script>
    $('.hapus').click(function() {
        var id = $(this).data('imem')
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
                window.location.href = "<?= base_url() ?>Member/hapus/" + id
            }
        })
    })
</script>

<script>
    <?php
    if ($this->session->flashdata('status') == 'ok') { ?>
        $(window).bind("load", function () {
            notif("success", "Member Berhasil Ditambahkan")
        });
    <?php } else if ($this->session->flashdata('status') == 'oke') {
        ?>
            notif("success", "Member Berhasil Diedit")
    <?php } else if ($this->session->flashdata('status') == 'okh') { ?>
                notif("success", "Member Berhasil Dihapus")
    <?php } else if ($this->session->flashdata('status') == 'ada') { ?>
                    notif("error", "Member Sudah Ada")
    <?php } ?>
</script>