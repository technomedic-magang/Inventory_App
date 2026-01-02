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
          "data": "<?= $this->pk_id ?>",
          "className": "text-left",
          "sortable": false,
          "render": function(data, type, row, meta) {
            var uri_edit = '<?= site_url("laporan/pajak/form_modal/") ?>' + data;
            var uri_delete = '<?= site_url("laporan/pajak/delete/") ?>' + data;
            return `<div class="btn-list btn-sm flex-nowrap">
                      <div class="dropdown">
                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">Aksi</button>
                        <div class="dropdown-menu">
                          <a class="dropdown-item p-1" href="javascript:void(0)" onclick="_modal(event, {uri: '${uri_edit}', size: 'modal-lg'})"><i class="fas fa-edit me-1"></i> Ubah</a>
                          <a class="dropdown-item p-1 text-danger" href="javascript:void(0)" onclick="_delete('${uri_delete}')"><i class="fas fa-trash me-1"></i> Hapus</a>
                        </div>
                      </div>
                    </div>`;
          }
        },

        // 2. KODE ASET
        {
          "data": "asset_kd",
          "className": "text-left fw-bold"
        },

        // 4. NO TRANSAKSI & ASET
        { 
            "data": "transaksi_no", 
            "className": "text-left",
            "render": function(data, type, row) {
                return `<div class="fw-bold">${data}</div>
                        <div class="small text-muted">${row.asset_nm}</div>`;
            }
        },
        
        // 3 KATEGORI
        {
          "data": "kategori_nm",
          "className": "text-left"
        },

        // --------------------------
        // 6. PLAT NOMOR (Mengambil alias 'plat_nomor' dari Model)
        { 
            "data": "plat_nomor", 
            "className": "fw-bold text-left",
            "render": function(data) {
                // Tampilkan data (Nopol Master atau Nopol Baru)
                return (data && data !== '-') ? data : '<span class="text-muted">-</span>';
            }
        },
        // --------------------------
        
        // 7. JENIS PAJAK
        { 
            "data": "pajak_jenis", 
            "className": "text-end",
            "render": function(data) {
                var color = (data == '5_TAHUNAN') ? 'purple' : 'blue';
                var label = (data == '5_TAHUNAN') ? '5 Tahunan' : 'Tahunan';
                return `<span class="badge bg-${color}-lt">${label}</span>`;
            }
        },
        // 5. TGL BAYAR
        { 
            "data": "transaksi_tgl", 
            "className": "text-end",
            "render": function(data) {
                return data ? data.split('-').reverse().join('-') : '-';
            }
        },
        // 8. BERLAKU SAMPAI
        { 
            "data": "jatuh_tempo_tgl", 
            "className": "text-end",
            "render": function(data) {
                if(!data) return '-';
                var dateStr = data.split('-').reverse().join('-');
                return `<span class="text-success fw-bold">${dateStr}</span>`;
            }
        },
        // 9. TOTAL BAYAR
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