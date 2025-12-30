<script type="text/javascript">
  var tabel = null;

  $(document).ready(function() {
    tabel = $('#datatable-main').DataTable({
      "language": { url: '<?= base_url() ?>dist/libs/DataTables/id.json' },
      "autoWidth": false,
      "processing": true,
      "serverSide": true,
      "ordering": true,
      "order": [[1, 'asc']], // Urut berdasarkan Kode Aset
      "scrollX": true, 
      "ajax": {
        "url": "<?= $this->uri . '/ajax_datatables?n=' . _get('n') ?>",
        "type": "POST"
      },
      "deferRender": true,
      "aLengthMenu": _datatableLengthMenu,
      "pageLength": 25,
      "columns": [
        {
          "data": "<?= $this->pk_id ?>",
          "sortable": false,
          "className": "text-center",
          "render": function(data, type, row, meta) { return meta.row + meta.settings._iDisplayStart + 1; }
        },
        { 
            "data": "asset_kd", 
            "className": "fw-bold",
            "render": function(data, type, row) {
                 var uri_detail = '<?= $this->uri . '/detail_modal/' ?>' + row.asset_id;
                 return `<a href="javascript:void(0)" onclick="_modal(event, {uri: '${uri_detail}', size: 'modal-lg'})" class="text-primary text-decoration-none" title="Lihat Detail">${data}</a>`;
            }
        },
        { "data": "kategori_nm" },
        { "data": "asset_nm" },
        { "data": "merk", "render": function(d){ return d || '-'; } },
        { "data": "seri", "render": function(d){ return d || '-'; } },
        { "data": "warna", "render": function(d){ return d || '-'; } },
        { "data": "nopol", "className": "fw-bold text-primary", "render": function(d){ return d ? d.toUpperCase() : '-'; } },
        
        // KOLOM BULAN BELI (Konversi Angka ke Nama Bulan)
        { 
            "data": "asset_bln_beli", 
            "className": "text-center",
            "render": function(data) {
                var namaBulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", 
                                 "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
                var idx = parseInt(data);
                return (idx && namaBulan[idx]) ? namaBulan[idx] : '-';
            }
        },

        // KOLOM TAHUN BELI
        { 
            "data": "asset_thn_beli", 
            "className": "text-center",
            "render": function(data) { return data || '-'; }
        },
        
        {
          "data": "asset_kondisi",
          "className": "text-center",
          "render": function(data) {
            var color = (data == 'BAIK') ? 'success' : (data == 'RUSAK') ? 'danger' : 'warning';
            return `<span class="badge bg-${color}-lt">${data}</span>`;
          }
        },
        { "data": "service_terakhir", "className": "text-left text-muted" },
        { "data": "pajak_kendaraan", "className": "text-left text-muted" },
        { "data": "bpkb", "render": function(d){ return d || '-'; } },
        { "data": "penanggungjawab", "className": "fw-bold" },
        { "data": "jabatan", "className": "small text-muted" },
        
        // QR Code Generator
        { 
            "data": "asset_kd", 
            "className": "text-center",
            "sortable": false,
            "render": function(data, type, row) {
                var thn = row.asset_thn_beli || '';
                var qrString = `${row.asset_kd}@${row.kategori_nm}@${row.asset_nm}@${thn}@${row.penanggungjawab}`;
                
                // Gunakan API QR Code Google Chart (Lebih stabil & umum)
                // var baseUrl = "https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=";
                
                // Atau gunakan API Kebumen (Sesuai kode asli Anda)
                var baseUrl = "http://e-bphtb.kebumenkab.go.id/index.php/api_qrcode/index?text=";
                
                var finalUrl = baseUrl + encodeURIComponent(qrString);

                return `<a href="${finalUrl}" target="_blank" class="btn btn-sm btn-ghost-dark btn-icon" title="Scan QR"><i class="fas fa-qrcode"></i></a>`;
            }
        },
      ],
    });
  });
</script>