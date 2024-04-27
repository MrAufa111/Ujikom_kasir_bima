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
                        Email
                    </th>
                    <th style="width: 20%;">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($user as $u) {
                    $KEY = 'Biima';
                    $psw = $u->password;
                    $pw = openssl_decrypt(base64_decode($psw), 'aes-128-cbc', $KEY, 0, '8281929182918291');
                ?>
                    <tr>
                        <td>
                            <?= $no++ ?>
                        </td>
                        <td>
                            <?= $u->nama_lengkap ?>
                 
                        <td>
                            <?= $u->email ?>
                        </td>

                            <td class="text-center">
                                <button id="edit" data-id="<?= $u->id_user ?>" data-nama="<?= $u->nama_lengkap ?>" data-email="<?= $u->email ?>" data-password="<?= $pw ?>" data-role="<?= $u->role ?>" class="btn btn-primary edit"><i class="bi bi-gear"></i></button>
                                <button id="hapus" data-idh="<?= $u->id_user ?>" type="button" class="btn btn-danger hapus"><i class="bi bi-trash"></i></button>
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
                    Tambah User
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('User/tambah') ?>" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <label for="" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama_lengkap" required>
                        </div>
                        <div class="col-6">
                            <label for="" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <label for="" class="form-label">Password</label>
                            <input type="text" class="form-control" name="password" required>
                        </div>
                        <div class="col-6">
                            <label for="" class="form-label">Role</label>
                            <select required name="role" id="" class="form-select">
                                <option value="1">Admin</option>
                                <option value="2">Petugas</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan User</button>
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
                    Edit User
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('User/edit') ?>" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <label for="" class="form-label">Nama Lengkap</label>
                            <input id="nama" type="text" class="form-control" name="nama_lengkap" required>
                            <input type="hidden" id="id_user" name="id_user">
                        </div>
                        <div class="col-6">
                            <label for="" class="form-label">Email</label>
                            <input id="email" type="email" class="form-control" name="email" required>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <label for="" class="form-label">Password</label>
                            <input id="password" type="text" class="form-control" name="password" required>
                        </div>
                        <div class="col-6">
                            <label for="" class="form-label">Role</label>
                            <select required name="role" id="role" class="form-select">
                                <option value="1">Admin</option>
                                <option value="2">Petugas</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan User</button>
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
                        text: '<i class="bi bi-plus-square me-2"></i> Tambah User',

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
        $('#modalEdit').modal('show')
        $('#id_user').val($(this).data('id'))
        $('#nama').val($(this).data('nama'))
        $('#email').val($(this).data('email'))
        $('#password').val($(this).data('password'))
        $('#role').val($(this).data('role')).change()
    })
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
                window.location.href = "<?= base_url() ?>User/hapus/" + id
            }
        })
    })
</script>
<script>
    <?php
    if ($this->session->flashdata('status') == 'ok') { ?>
        $(window).bind("load", function () {
            notif("success", "User Berhasil Ditambahkan")
        });
    <?php } else if ($this->session->flashdata('status') == 'oke') {
        ?>
            notif("success", "User Berhasil Diedit")
    <?php } else if ($this->session->flashdata('status') == 'okh') { ?>
                notif("success", "User Berhasil Dihapus")
    <?php } else if ($this->session->flashdata('status') == 'ada') { ?>
                    notif("error", "Email Sudah Terdaftar")
    <?php } ?>
</script>