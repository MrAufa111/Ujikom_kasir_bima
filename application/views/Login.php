<script src="<?= base_url('assets/jquery-3.7.1.min.js') ?>"></script>

<link rel="stylesheet" href="<?= base_url('assets/bs5/css/bootstrap.min.css') ?>">
<script src="<?= base_url('assets/bs5/js/bootstrap.bundle.min.js') ?>"></script>

<link rel="stylesheet" href="<?= base_url('assets/bi/font/bootstrap-icons.min.css') ?>">

<link rel="stylesheet" href="<?= base_url('assets/datatables/datatables.min.css') ?>">
<script src="<?= base_url('assets/datatables/datatables.min.js') ?>"></script>

<link rel="stylesheet" href="<?= base_url('assets/sweetalert2.min.css') ?>">
<script src="<?= base_url('assets/sweetalert2.all.min.js') ?>"></script>

<div class="fd" data-flashdata=<?= $this->session->flashdata('notif') ?>></div>

<div class="container border" style="width: 40%; margin-top:6%">
    <h2 class="text-center">LOGIN</h2>
    <br>
    <div class="text-center mb-3">
        <img width="90px" src="<?=base_url('assets/gambar/person.png')?>" alt="">
    </div>
    <form action="<?= base_url('Login/auth') ?>" method="post">
        <div class="form-outline">
            <label for="" class="form-label">Email</label>
            <input type="email" required name="email" class="form-control">
        </div>
        <div class="form-outline mt-3">
            <label for="" class="form-label">Password</label>
            <div class="input-group">
                <input id="psw" type="password" required name="password" class="form-control">
                <span id="tggl" class="input-group-text"><i class="bi bi-eye" id="eye"></i></span>
            </div>

        </div>
        <div class="form-outline text-center mt-5">
            <button type="submit" class="btn btn-dark">LOGIN</button>
        </div>
    </form>
</div>



<script src="<?= base_url('assets/notiflogin.js') ?>"></script>

<script>
    $('#tggl').click(function() {
        if ($('#psw').is('input[type="password"]')) {
            $('#eye').removeClass('bi bi-eye')
            $('#eye').addClass('bi bi-eye-slash')
            $('#psw').prop('type', 'text')
        } else {
            $('#eye').removeClass('bi bi-eye-slash')
            $('#eye').addClass('bi bi-eye')
            $('#psw').prop('type', 'password')
        }
    })
</script>

<script>
    function notif(status, title) {
        Swal.fire({
            toast: true,
            icon: status,
            title: title,
            animation: true,
            position: 'top-right',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
    }
</script>

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