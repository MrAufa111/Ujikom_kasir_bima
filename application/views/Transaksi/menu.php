<div class="container">
    <?php if ($id_petugas == NULL) { ?>
        <div class="card p-3">
            <form id="formPen">
                <div class="row mb-5">
                    <div class="col-6">
                        <label for="" class="form-label">Kode Penjualan</label>
                        <input required class="form-control" id="kode" type="text" readonly name="kode_penjualan"
                            value="<?= $kode ?>">
                    </div>
                    <div class="col-6">
                        <label for="" class="form-label">Tanggal Penjualan</label>
                        <input required id="tanggal" class="form-control" type="text" readonly name="tanggal_penjualan"
                            value="<?= $tanggal ?>">
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-4">
                        <label for="" class="form-label">Produk</label>
                        <select required name="produk" id="produk" class="form-select select2">
                            <option value="Pilih Produk">--Pilih Produk--</option>

                            <?php

                            foreach ($produk as $p) { ?>
                                <option data-harga="<?= $p->harga ?>" value="<?= $p->id_produk ?>"><?= $p->nama_produk ?>
                                </option>
                            <?php }

                            ?>
                        </select>
                    </div>
                    <div class="col-4">
                        <label for="" class="form-label">Harga Produk</label>
                        <input readonly required min=0 type="number" name="harga" id="harga" class="form-control">
                    </div>
                    <div class="col-4">
                        <label for="" class="form-label">Jumlah</label>
                        <input required min=0 type="number" name="jumlah" id="jumlah" class="form-control">
                    </div>
                </div>

                <div class="text-center">

                    <button type="button" id="keranjang" style="width:40%" class="btn btn-success">
                        Tambah Ke Keranjang
                    </button>
                </div>
            </form>
        </div>
    <?php } else { ?>
        <input required class="form-control" id="kode" type="hidden" readonly name="kode_penjualan" value="<?= $kode ?>">
    <?php } ?>
    <div class="card border mt-3 p-3 d-flex flex-row">
        <table class="table table border table striped">
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
                    Jumlah
                </th>
                <th>
                    Sub Total
                </th>
                <?php if ($id_petugas == NULL) { ?>
                    <th>
                        Opsi
                    </th>
                <?php } ?>
            </tr>
            <tbody id="row">

            </tbody>
        </table>
        <div id="cardDetail" style="width: 50%;" class="card ms-3 p-3">

            <h4 class="text-center mb-2">DETAIL</h4>
            <select <?php if ($id_petugas != NULL) {
                echo "disabled";
            } ?> name="member" id="member" class="form-select">
                <option selected value="-">--Pilih Member--</option>
                <?php foreach ($member as $m) { ?>
                    <option <?php if ($id_member == $m->id_member) {
                        echo "selected";
                    } ?> value="<?= $m->id_member ?>">
                        <?= $m->nama_member ?></option>
                <?php } ?>
            </select>
            <h5 class="mt-3">Barang Yang Dibeli : <?= $jumlahBarang ?></h5>
            <h5>Total Harga : <span id="toha"></span></h5>
            <h5>Diskon : <span id="dsk"></span></h5>
            <h5>Potongan Harga : <span id="pohar"></span></h5>
            <h5>Total Akhir: Rp. <span id="toa"></span></h5>

        </div>
        <div id="cardDetail" style="width: 50%;" class="card ms-3 p-3">

            <?php if ($id_petugas == NULL) { ?>

                <h4 class="text-center mb-2">PEMBAYARAN</h4>

                <h5 class="mt-4">Nominal Pembayaran : </h5>

                <div class="input-group">
                    <input type="number" placeholder="Masukkan Nominal" name="" id="nomBayar" class="form-control">
                    <button id="bayar" class="btn btn-success">Bayar</button>
                </div>

                <h5 id="kembalian" class="mt-4"></h5>
            <?php } else { ?>
                <button id="cetStruk" style="margin-top: auto; margin-bottom: auto" class="btn btn-success">Struk</button>
            <?php } ?>

        </div>
    </div>
</div>

<?php if ($id_petugas != NULL) { ?>
    <script>
        $('#cetStruk').click(function () {
            $.ajax({
                url: "<?= base_url() ?>Transaksi/getStruk",
                method: "POST",
                data: {
                    kode_penjualan: $('#kode').val()
                },
                success: function (par) {
                    document.body.innerHTML = par
                    window.print()
                    location.reload()
                }
            })
        })
    </script>
<?php } ?>

<script>
    function set_notif() {
        <?php
        if ($this->session->flashdata('status') == 'ok') { ?>

            notif("success", "Barang Berhasil Ditambahkan")

        <?php } else if ($this->session->flashdata('status') == 'oke') {
            ?>
                notif("success", "Barang Berhasil Diedit")
        <?php } else if ($this->session->flashdata('status') == 'okh') { ?>
                    notif("success", "Barang Berhasil Dihapus")
        <?php } ?>
    }
</script>

<script>
    $('#nomBayar').on('input', function () {
        var toha = $('#toa').html()

        var hitung = $('#nomBayar').val() - toha

        if (hitung > 0) {
            $('#kembalian').html("Kembalian : Rp. " + hitung)
        } else if (hitung < 0) {
            $('#kembalian').html("kekurangan : Rp. " + hitung)
        } else if (hitung == 0) {
            $('#kembalian').html("Kembalian : Rp. " + 0)
        }
    })
</script>

<script>
    $('#bayar').click(function () {
        var toha = "<?= $hartot ?>"
        var kode_penjualan = $('#kode').val()
        var member = $('#member').val()
        var bayar = $('#nomBayar').val()
        var hitung = $('#nomBayar').val() - toha
        if ($('#nomBayar').val() >= parseInt(toha)) {
            $.ajax({
                url: "<?= base_url() ?>Transaksi/bayar",
                method: "POST",
                data: {
                    total_harga: toha,
                    kode_penjualan: kode_penjualan,
                    id_member: member,
                    membayar: bayar,
                    kembalian: hitung
                },
                success: function (par) {
                    document.body.innerHTML = par;

                    $.ajax({
                        url: "<?= base_url() ?>Transaksi/struk",
                        method: "POST",
                        data: {
                            par: par,
                            kode_penjualan: kode_penjualan,
                        },
                        success: function () {
                            window.print();
                            window.location.href = "<?= base_url() ?>Transaksi"
                        },
                        error: function (e) {
                            console.log(e.responseText)
                        }
                    })
                },
                error: function (e) {
                    console.log(e.responseText)
                }
            })
        } else {
            notif("error", "Nominal Kurang Dari Jumlah Total")
        }
    })
</script>

<script>
    function getDetail() {
        var toha = "<?= $hartot ?>"
        $('#toha').html(toha)
        $('#toa').html(toha)
    }
</script>
<script>
    function getKeranjang() {
        $.ajax({
            url: "<?= base_url() ?>Transaksi/getKeranjang",
            method: "POST",
            data: {
                'kode_penjualan': $('#kode').val()
            },
            success: function (par) {
                $('#row').html(par)

            },
            error: function (e) {
                console.log(e.responseText)
            }
        })
    }
</script>

<script>
    function cekDiskon() {
        var hartot = "<?= $hartot ?>"
        $.ajax({
            url: "<?= base_url() ?>Transaksi/cekDiskon",
            method: "POST",
            data: {
                kode_penjualan: $('#kode').val(),
                total: hartot,
            },
            success: function (r) {

                var json = JSON.parse(r);
                $('#dsk').html(json.persen + "%")
                $('#pohar').html("Rp. " + json.hitung)
                $('#toa').html(json.akhir)
            }
        })
    }
</script>

<script>
    $(document).ready(function () {
        getKeranjang(),
            getDetail(),
            set_notif()
    })
</script>




<!-- <script>
    $('#jumlah').on('input', function()
{
    var jml = $('#jumlah').val()

    $.ajax({
        url:"<?= base_url() ?>Transaksi/cekStok",
        method:"POST",
        data:{
            jumlah: jml,
            id_produk: $('#produk').val()
        },
        success: function(par)
        {
            alert(par)
        },
        error: function(e)
        {
            console.log(e.responseText)
        }
    })
})
</script> -->



<script>
    $(document).ready(function () {
        $('.select2').select2()
    })
</script>

<script>
    $('#produk').change(function () {
        var harga = $('#produk option:selected').data('harga')
        if ($('#produk').val() == "Pilih Produk") {
            $('#harga').val("")
        } else {
            $('#harga').val(harga)
        }
    })
</script>

<script>
    $('#jumlah').keyup(function () {
        $('#jumlah').val($('#jumlah').val().replace("-", ""))
        $('#jumlah').val($('#jumlah').val().replace("e", ""))
    })
</script>

<script>
    $('#keranjang').click(function () {

        var kode_penjualan = $('#kode').val()
        var tanggal_penjualan = $('#tanggal').val()
        var produk = $('#produk').val()
        var harga = $('#harga').val()
        var jumlah = $('#jumlah').val()

        if (produk == "Pilih Produk" || harga == "" || jumlah == "") {
            notif('error', 'Lengkapi Semua Kolom')
        } else {
            $.ajax({
                url: "<?= base_url() ?>Transaksi/tambahKeranjang",
                method: "POST",
                data: {
                    kode_penjualan: kode_penjualan,
                    tanggal_penjualan: tanggal_penjualan,
                    id_produk: produk,
                    harga: harga,
                    jumlah: jumlah,
                },
                success: function (par) {
                    if (par == "Lebih") {
                        notif('error', 'Jumlah Melebihi Stok')

                    } else {

                        location.reload()


                    }

                    getDetail(),
                        cekDiskon(),

                        $('#formPen').trigger('reset')

                },
                error: function (e) {
                    console.log(e.responseText)
                }

            })
        }


    })
</script>
<script>
    $('#member').change(function () {

        if ($('#member').val() == "-") {
            location.reload()
        } else {
            cekDiskon()
        }
    })
</script>

<?php if ($id_member != NULL || $id_member != 0) { ?>
    <script>
        cekDiskon()
    </script>
<?php } ?>