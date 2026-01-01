<script type="text/javascript">
  var tabel = null;
  
  $(document).ready(function() {
    tabel = $('#datatable-main').DataTable({
      "language": { url: '<?= base_url() ?>dist/libs/DataTables/id.json' },
      "autoWidth": false,
      "processing": true,
      "serverSide": true,
      "ordering": true,
      "order": [ [2, 'desc'] ], 
      "ajax": {
        "url": "<?= site_url('laporan/pajak/ajax_datatables?n=' . _get('n')) ?>",
        "type": "POST"
      },
      "deferRender": true,
      "pageLength": 25,
      "columns": [
        // 0. NO
        {
          "data": "pajak_id",
          "sortable": false,
          "className": "text-center",
          "render": function(data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        // 1. AKSI
        {
          "data": "pajak_id",
          "sortable": false,
          "className": "text-center",
          "render": function(data, type, row, meta) {
            var uri_delete = '<?= site_url("laporan/pajak/delete/") ?>' + data;
            return `<a class="text-danger" href="javascript:void(0)" onclick="_delete('${uri_delete}')" title="Hapus Riwayat">
                      <i class="fas fa-trash"></i>
                    </a>`;
          }
        },
        // 2. TGL BAYAR
        { 
            "data": "transaksi_tgl", 
            "className": "text-center",
            "render": function(data) {
                return data ? data.split('-').reverse().join('-') : '-';
            }
        },
        // 3. NO TRANSAKSI & ASET
        { 
            "data": "transaksi_no", 
            "className": "text-left",
            "render": function(data, type, row) {
                return `<div class="fw-bold">${data}</div>
                        <div class="small text-muted">${row.asset_nm}</div>`;
            }
        },
        
        // --- [PERBAIKAN DISINI] ---
        // 4. PLAT NOMOR (Mengambil alias 'plat_nomor' dari Model)
        { 
            "data": "plat_nomor", 
            "className": "fw-bold text-center",
            "render": function(data) {
                // Tampilkan data (Nopol Master atau Nopol Baru)
                return (data && data !== '-') ? data : '<span class="text-muted">-</span>';
            }
        },
        // --------------------------
        
        // 5. JENIS PAJAK
        { 
            "data": "pajak_jenis", 
            "className": "text-center",
            "render": function(data) {
                var color = (data == '5_TAHUNAN') ? 'purple' : 'blue';
                var label = (data == '5_TAHUNAN') ? '5 Tahunan' : 'Tahunan';
                return `<span class="badge bg-${color}-lt">${label}</span>`;
            }
        },
        // 6. BERLAKU SAMPAI
        { 
            "data": "jatuh_tempo_tgl", 
            "className": "text-center",
            "render": function(data) {
                if(!data) return '-';
                var dateStr = data.split('-').reverse().join('-');
                return `<span class="text-success fw-bold">${dateStr}</span>`;
            }
        },
        // 7. TOTAL BAYAR
        { 
            "data": "nominal_total", 
            "className": "text-end fw-bold",
            "render": function(data) {
                return 'Rp ' + parseFloat(data).toLocaleString('id-ID');
            }
        }
      ],
    });
  });
</script>