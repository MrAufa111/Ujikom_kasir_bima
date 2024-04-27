<div class="container">
    <div class="card p-3">

        <div class="row mb-5">
            <div class="col-5">
                <label for="" class="form-label">Tanggal Awal</label>
                <input id="awal" type="date" class="form-control">
            </div>
            <div class="col-5">
                <label for="" class="form-label">Tanggal Akhir</label>
                <input id="akhir" type="date" class="form-control">
            </div>
            <div class="col-2">
                <button type="button" id="klik" class="btn btn-primary" style="margin-top: 32px;"><i class="bi bi-search"> </i> Cari</button>
            </div>
        </div>



        <div id="eusi">

        </div>
        
    </div>
</div>

<script>
    $('#klik').click(function() {
        $.ajax({
            url: "<?= base_url() ?>Laporan/getTransaksi",
            method: "POST",
            data: {
                awal: $('#awal').val(),
                akhir: $('#akhir').val(),
            },
            success: function(par) {
                $('#eusi').html(par)
            },
            error: function(e) {
                console.log(e.responseText)
            }
        })
    })
</script>

