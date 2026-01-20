<script type="text/javascript">
  var tabel = null;

  $(document).ready(function() {
    tabel = $('#datatable-main').DataTable({
      "language": { url: '<?= base_url() ?>dist/libs/DataTables/id.json' },
      "autoWidth": false,
      "processing": true,
      "serverSide": true,
      "ordering": true,
      "order": [[2, 'asc']], // Urut berdasarkan Kode Aset (Kolom index 2)
      "ajax": {
        "url": "<?= $this->uri . '/ajax_datatables?n=' . _get('n') ?>",
        "type": "POST",
        "data": function(d) {
            d.<?= $this->security->get_csrf_token_name() ?> = '<?= $this->security->get_csrf_hash() ?>';
        }
      },
      "deferRender": true,
      "aLengthMenu": _datatableLengthMenu,
      "pageLength": 500,
      "columns": [
        // 0. NO
        {
          "data": null,
          "sortable": false,
          "className": "text-center",
          "render": function(data, type, row, meta) { return meta.row + meta.settings._iDisplayStart + 1; }
        },
        // 1. AKSI (DROPDOWN)
        { 
            "data": "asset_id", 
            "className": "text-center",
            "sortable": false,
            "render": function(data, type, row) {
                 var uri_detail = '<?= $this->uri . '/detail_modal/' ?>' + data;
                 
                 return `
                    <div class="dropdown">
                      <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Aksi
                      </button>
                      <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="javascript:void(0)" onclick="_modal(event, {uri: '${uri_detail}', size: 'modal-lg', title: 'Detail Kendaraan'})">
                            <i class="fas fa-eye me-2"></i> Detail
                        </a>
                      </div>
                    </div>
                 `;
            }
        },
        // 2. KODE ASET
        { 
            "data": "asset_kd", 
            "className": "fw-bold"
        },
        { "data": "kategori_nm" },
        { "data": "asset_nm" },
        { "data": "merk", "render": function(d){ return d || '-'; } },
        { "data": "seri", "render": function(d){ return d || '-'; } },
        { "data": "warna", "render": function(d){ return d || '-'; } },
        { 
            "data": "nopol", 
            "className": "fw-bold text-primary", 
            "render": function(d){ 
                return (d && d !== '-') ? d.toUpperCase() : '-'; 
            } 
        },
        
        // Bulan Beli
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

        // Tahun Beli
        { "data": "asset_thn_beli", "className": "text-center", "render": function(d) { return d || '-'; } },
        
        // Kondisi
        {
          "data": "asset_kondisi",
          "className": "text-center",
          "render": function(data) {
            var color = (data == 'BAIK') ? 'success' : (data == 'RUSAK') ? 'danger' : 'warning';
            return `<span class="badge bg-${color}-lt">${data}</span>`;
          }
        },
        { "data": "service_terakhir", "className": "text-center text-muted" },
        { "data": "pajak_kendaraan", "className": "text-center text-muted" },
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
                var baseUrl = "http://e-bphtb.kebumenkab.go.id/index.php/api_qrcode/index?text=";
                var finalUrl = baseUrl + encodeURIComponent(qrString);

                return `<a href="${finalUrl}" target="_blank" class="btn btn-sm btn-ghost-dark btn-icon" title="Scan QR"><i class="fas fa-qrcode"></i></a>`;
            }
        },
      ],
    });
  });
</script>