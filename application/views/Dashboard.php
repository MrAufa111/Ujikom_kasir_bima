<?php if ($this->session->userdata('id_user') != 1) { ?>
    <div style="width: 50%; background-color: white" class="top-50 start-50 position-absolute translate-middle border-0">
        <div style="background-color: white;" class="card border-0">
            <div style="margin-bottom: 100px;" class="row">
                <div class="col-12">
                    <button onclick="location.href='<?= base_url() ?>Transaksi'" style="width: 100%; height: 200%" class="btn btn-outline-success border">
                        <h3><i class="bi bi-cart"> </i> PENJUALAN</h3>
                    </button>
                </div>
            </div>
            <div style="margin-bottom: 100px;" class="row">
                <div class="col-6">
                    <button onclick="location.href='<?= base_url() ?>Produk'" style="width: 100%; height: 200%" class="btn btn-outline-primary border">
                        <h3><i class="bi bi-boxes"> </i> PRODUK</h3>
                    </button>
                </div>
                <div class="col-6">
                    <button onclick="location.href='<?= base_url() ?>Member'" style="width: 100%; height: 200%" class="btn btn-outline-info border">
                        <h3><i class="bi bi-person-vcard"> </i> MEMBER</h3>
                    </button>
                </div>
            </div>

        </div>
    </div>
<?php } else if ($this->session->userdata('id_user') == 1) { ?>
    <div class="container  d-flex flex-row">
        <div style="width: 40%" class="card me-4 border border-1 border-info">
            <div class="card-header border border-1 border-info bg-info">
                <h5><i class="bi bi-person"></i> USER TERDAFTAR</h5>
            </div>
            <div class="card-body border border-1 border-info">
                <h2 class="text-center"><?=$user?></h2>
            </div>
            <div onclick="location.href='<?= base_url() ?>User'" class="card-footer user btn btn-outline-info">
                Tabel User>>>>>>
            </div>
        </div>
        <div style="width: 40%" class="card me-4 border border-1 border-primary">
            <div  class="card-header bg-primary">
                <h5><i class="bi bi-boxes"></i> PRODUK TERDATA</h5>
            </div>
            <div class="card-body border border-1 border-primary">
                <h2 class="text-center"><?=$produk?></h2>
            </div>
            <div onclick="location.href='<?= base_url() ?>Produk'" class="card-footer btn btn-outline-primary produk">
                Tabel Produk>>>>>>
            </div>
        </div>
        <div style="width: 40%" class="card border border-1 border-success">
            <div  class="card-header bg-success">
                <h5><i class="bi bi-cart"></i> PENJUALAN SELESAI</h5>
            </div>
            <div class="card-body border border-1 border-success">
                <h2 class="text-center"><?=$penjualan?></h2>
            </div>
            <div onclick="location.href='<?= base_url() ?>Transaksi'" class="card-footer penjualan btn btn-outline-success">
                Tabel Penjualan>>>>>>
            </div>
        </div>
    </div>
    <script>
        $('.user').css("cursor", "pointer")
        $('.produk').css("cursor", "pointer")
        $('.penjualan').css("cursor", "pointer")
    </script>
<?php } ?>
