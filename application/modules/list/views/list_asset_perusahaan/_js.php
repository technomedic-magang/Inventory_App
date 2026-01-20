<script type="text/javascript">
  var tabel = null;

  $(document).ready(function() {
    tabel = $('#datatable-main').DataTable({
      "language": { url: '<?= base_url() ?>dist/libs/DataTables/id.json' },
      "autoWidth": false,
      "processing": true,
      "serverSide": true,
      "ordering": true,
      "order": [[2, 'asc']], // Urut berdasarkan Kode Aset (Index 2)
      "scrollX": true, 
      "scrollCollapse": true,
      "ajax": {
        "url": "<?= $this->uri . '/ajax_datatables?n=' . _get('n') ?>",
        "type": "POST",
        "data": function (d) {
            d.filter_kategori = $('#main_filter_kategori').val();
            // [STANDAR] CSRF Token
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
          "render": function(data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
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
        // 3. KATEGORI
        { "data": "kategori_nm" },
        
        // 4. NAMA LENGKAP
        { 
            "data": "nama_lengkap",
            "render": function(data) { return `<div class="text-wrap" style="min-width:200px;">${data || '-'}</div>`; }
        },

        // 5. LOKASI / PJ
        { 
            "data": "lokasi_pj",
            "render": function(data) {
                var iconClass = "fas fa-map-marker-alt me-1 text-danger";
                if (data && data.toString().indexOf('Dipakai') !== -1) {
                    iconClass = "fas fa-user me-1 text-blue";
                }
                return `<span class="text-muted"><i class="${iconClass}"></i> ${data}</span>`;
            }
        },

        // 6. TAHUN
        { "data": "tahun", "className": "text-center" },

        // 7. KONDISI
        {
          "data": "asset_kondisi",
          "className": "text-center",
          "render": function(data) {
            var color = 'secondary';
            if(data == 'BAIK') color = 'green';
            if(data == 'RUSAK') color = 'red';
            if(data == 'SEDANG' || data == 'PERBAIKAN') color = 'yellow';
            return `<span class="badge bg-${color}-lt">${data}</span>`;
          }
        },
        
        // 8. QR CODE
        { 
            "data": "asset_kd", 
            "className": "text-end",
            "sortable": false,
            "render": function(data, type, row) {
                var d = row;
                var safeName = (d.nama_lengkap || '').replace(/[^a-zA-Z0-9 -]/g, '');
                var safeLoc = (d.lokasi_pj || '').replace(/[^a-zA-Z0-9 -]/g, '');
                var qrString = `${d.asset_kd}@${d.kategori_nm}@${safeName}@${safeLoc}@${d.tahun}`;
                var baseUrl = "http://e-bphtb.kebumenkab.go.id/index.php/api_qrcode/index?text=";
                
                return `<a href="${baseUrl + encodeURIComponent(qrString)}" target="_blank" class="btn btn-sm btn-ghost-dark btn-icon" title="Cetak QR">
                          <i class="fas fa-qrcode fa-lg"></i>
                        </a>`;
            }
        },
      ],
    });

    // Event Filter
    $('#main_filter_kategori').change(function(){
        tabel.ajax.reload();
    });
  });
</script>