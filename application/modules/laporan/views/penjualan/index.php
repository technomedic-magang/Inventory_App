<h3 class="page-title">
    <?php echo $title ?? 'Laporan Penjualan'; ?>
</h3>

<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Filter Laporan</h4>
                <form id="form_filter" class="form-inline">
                    <div class="form-group me-2">
                        <label for="tgl_awal">Tanggal Awal:</label>
                        <input type="date" class="form-control ms-2" id="tgl_awal" name="tgl_awal" value="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="form-group me-2">
                        <label for="tgl_akhir">Tanggal Akhir:</label>
                        <input type="date" class="form-control ms-2" id="tgl_akhir" name="tgl_akhir" value="<?php echo date('Y-m-d'); ?>">
                    </div>
                    
                    <button type="button" id="btn_filter" class="btn btn-gradient-primary">
                        Tampilkan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Penjualan</h4>
                <div class="table-responsive mt-3">
                    <table id="table_laporan_penjualan" class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width: 5%;">No.</th>
                                <th>Tanggal</th>
                                <th>Invoice</th>
                                <th>Outlet</th>
                                <th>Kasir</th>
                                <th>Total (Rp)</th>
                                <th style="width: 10%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        
        // Inisialisasi DataTables
        var table = $('#table_laporan_penjualan').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                // Panggil fungsi ajax_datatables di controller Laporan
                "url": "<?php echo site_url('laporan/penjualan/ajax_datatables') ?>",
                "type": "POST",
                "data": function(d) {
                    // Kirim data filter ke backend
                    // (Nanti di backend, Anda ambil pakai _post('tgl_awal'))
                    d.tgl_awal = $('#tgl_awal').val();
                    d.tgl_akhir = $('#tgl_akhir').val();
                }
            },
            "columns": [
                { "data": null, "orderable": false, "searchable": false, 
                  "render": function (data, type, row, meta) {
                     return meta.row + meta.settings._iDisplayStart + 1;
                  }
                },
                { "data": "tanggal" }, // Sesuaikan dengan key di data dummy
                { "data": "invoice_no" },
                { "data": "outlet_nm" },
                { "data": "user_nm" },
                { "data": "total_akhir_rp" }, // Nanti bisa diformat jadi Rupiah
                { "data": "penjualan_id", "orderable": false, "searchable": false, 
                  "render": function (data, type, row) {
                    // Tombol Aksi (Contoh: Lihat Detail)
                    return '<button class="btn btn-info btn-xs">Detail</button>';
                  }
                }
            ]
        });

        // Aksi untuk tombol filter
        $('#btn_filter').on('click', function() {
            // Muat ulang data tabel
            table.ajax.reload();
        });

    });
</script>