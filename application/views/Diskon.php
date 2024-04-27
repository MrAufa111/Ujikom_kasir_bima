<div class="container">
    <div class="card border p-3">
        <table class="table table-striped table-bordered tadata">
            <thead>
                <tr class="mkyam">
                    <th>
                        #
                    </th>
                    <th>
                        Nominal
                    </th>
                    <th>
                        Persenan
                    </th>
                    <th style="width: 20%;">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($diskon as $d) { ?>
                    <tr>
                        <td>
                            <?= $no++ ?>
                        </td>
                        <td>
                            <?= $d->minimal ?>
                        </td>
                        <td>
                            <?= $d->persen ?>
                        </td>
                        <td class="text-center">
                            <button data-idd="<?= $d->id_diskon ?>" data-nom="<?= $d->minimal ?>" data-persen="<?= $d->persen ?>" id="edit" class="btn btn-primary edit"><i class="bi bi-gear"></i></button>
                            <button data-idh="<?=$d->id_diskon?>" id="hapus" type="button" class="btn btn-danger hapus"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                <?php } ?>


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
                    Tambah Diskon
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('Diskon/tambah') ?>" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <label for="" class="form-label">Minimal Nominal</label>
                            <input type="number" class="form-control" name="nominal" min=0 required>
                        </div>
                        <div class="col-6">
                            <label for="" class="form-label">Persen</label>
                            <div class="input-group">
                                <input type="number" class="form-control" min=0 name="persenan" required>
                                <span class="btn input-group-text"><i class="bi bi-percent"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan Diskon</button>
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
                    Edit Diskon
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('Diskon/edit') ?>" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <label for="" class="form-label">Minimal Nominal</label>
                            <input id="nom" type="number" class="form-control" name="nominal" min=0 required>
                            <input id="iddi" type="hidden" name="id_diskon">
                        </div>
                        <div class="col-6">
                            <label for="" class="form-label">Persen</label>
                            <div class="input-group">
                                <input id="per" type="number" class="form-control" min=0 name="persenan" required>
                                <span class="btn input-group-text"><i class="bi bi-percent"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan Diskon</button>
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
                        text: '<i class="bi bi-plus-square me-2"></i> Tambah Diskon',

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
    $('.edit').click(function() {
        $('#nom').val($(this).data('nom'))
        $('#per').val($(this).data('persen'))
        $('#iddi').val($(this).data('idd'))

        $('#modalEdit').modal('show')
    })
</script>

<script>
    <?php
    if ($this->session->flashdata('status') == 'ok') { ?>
        $(window).bind("load", function() {
            notif("success", "Diskon Berhasil Ditambahkan")
        });
    <?php  } else if ($this->session->flashdata('status') == 'oke') {
    ?>
        notif("success", "Diskon Berhasil Diedit")
    <?php } else if ($this->session->flashdata('status') == 'okh') { ?>
        notif("success", "Diskon Berhasil Dihapus")
    <?php }  ?>
</script>
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
                window.location.href = "<?= base_url() ?>Diskon/hapus/" + id
            }
        })
    })
</script>