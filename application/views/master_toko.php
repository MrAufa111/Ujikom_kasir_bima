<div class="container">
    <div class="card p-3">
        <form method="POST" action="<?= base_url("Master_toko/edit") ?>">
            <?php foreach ($master as $m) { ?>

                <div class="row">
                    <div class="col-4">
                        <label for="" class="form-label">Nama Toko</label>
                        <input value="<?=$m->nama_toko?>" name="nama_toko" type="text" class="form-control">
                        <input value="<?=$m->id?>" name="id" type="hidden" class="form-control">
                    </div>
                    <div class="col-4">
                        <label for="" class="form-label">No. HP</label>
                        <input value="<?=$m->no_hp?>" name="no_hp" type="number" class="form-control">
                    </div>
                    <div class="col-4">
                        <label for="" class="form-label">Email</label>
                        <input value="<?=$m->email?>"name="email" type="email" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <label for="" class="form-label">Alamat</label>
                        <textarea name="alamat" id="" cols="30" rows="3" class="form-control"><?=$m->alamat?></textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-center">

                    <button type="submit" style="width: 30%;" class="btn btn-success mt-4">Simpan</button>
                </div>
            <?php } ?>
        </form>
    </div>
</div>

<script>
    <?php
    if ($this->session->flashdata('status') == 'ok') { ?>
        $(window).bind("load", function() {
            notif("success", "Master Data Berhasil Ditambahkan")
        });
    <?php  } else if ($this->session->flashdata('status') == 'oke') {
    ?>
        notif("success", "Master Data Berhasil Diedit")
    <?php } else if ($this->session->flashdata('status') == 'okh') { ?>
        notif("success", "Master Data Berhasil Dihapus")
    <?php }  ?>
</script>