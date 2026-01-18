<script type="text/javascript">
  var tabel = null;
  
  $(document).ready(function() {
    tabel = $('#datatable-main').DataTable({
      "language": { url: '<?= base_url() ?>dist/libs/DataTables/id.json' },
      "autoWidth": false,
      "processing": true,
      "serverSide": true,
      "ordering": true,
      "order": [ [7, 'desc'] ], // Urut Tgl Bayar (Kolom ke-7)
      "ajax": {
        "url": "<?= $this->uri . '/ajax_datatables?n=' . _get('n') ?>",
        "type": "POST",
        "data": function (d) {
            // CSRF Token
            d.<?= $this->security->get_csrf_token_name() ?> = '<?= $this->security->get_csrf_hash() ?>';
        }
      },
      "deferRender": true,
      "pageLength": 25,
      "columns": [
        {
          "data": "pajak_id",
          "sortable": false,
          "className": "text-center",
          "render": function(data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        // AKSI


        {
          "data": "<?= $this->pk_id ?>",
          "className": "text-center",
          "sortable": false,
          "render": function(data, type, row, meta) {
            var uri_delete = '<?= $this->uri . "/delete/" ?>' + data;
            
            // Hanya tombol Hapus (Edit dikunci sesuai Controller)
            return `<div class="dropdown">
                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">Aksi</button>
                      </button>
                      <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="_delete('${uri_delete}')">
                            <i class="fas fa-trash me-2"></i> Hapus
                        </a>
                      </div>
                    </div>`;
          }
        },
        // KODE
        {
          "data": "asset_kd",
          "className": "text-start fw-bold"
        },
        // INFO TRANSAKSI
        { 
            "data": "transaksi_no", 
            "className": "text-start",
            "render": function(data, type, row) {
                return `<div class="fw-bold text-dark">${data}</div>
                        <div class="small text-muted text-truncate" style="max-width:200px;">${row.asset_nm}</div>`;
            }
        },
        // KATEGORI
        { "data": "kategori_nm" },
        // PLAT NOMOR
        { 
            "data": "plat_nomor", 
            "className": "fw-bold text-start",
            "render": function(data) {
                return (data && data !== '-') ? `<span class="badge bg-dark-lt">${data}</span>` : '<span class="text-muted">-</span>';
            }
        },
        // JENIS PAJAK
        { 
            "data": "pajak_jenis", 
            "className": "text-end",
            "render": function(data) {
                var color = (data == '5_TAHUNAN') ? 'purple' : 'blue';
                var label = (data == '5_TAHUNAN') ? '5 Tahunan' : 'Tahunan';
                return `<span class="badge bg-${color}-lt">${label}</span>`;
            }
        },
        // TGL BAYAR
        { 
            "data": "transaksi_tgl", 
            "className": "text-end",
            "render": function(data) {
                return data ? data.split('-').reverse().join('-') : '-';
            }
        },
        // BERLAKU SAMPAI
        { 
            "data": "jatuh_tempo_tgl", 
            "className": "text-end",
            "render": function(data) {
                if(!data) return '-';
                var dateStr = data.split('-').reverse().join('-');
                return `<span class="text-success fw-bold">${dateStr}</span>`;
            }
        },
        // TOTAL BAYAR
        { 
            "data": "nominal_total", 
            "className": "text-end fw-bold text-dark",
            "render": function(data) {
                return 'Rp ' + parseFloat(data).toLocaleString('id-ID');
            }
        }
      ],
    });
  });
</script>