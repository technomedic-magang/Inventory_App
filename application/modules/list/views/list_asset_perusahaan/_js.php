<script type="text/javascript">
  var tabel = null;

  $(document).ready(function() {
    tabel = $('#datatable-main').DataTable({
      "language": { url: '<?= base_url() ?>dist/libs/DataTables/id.json' },
      "autoWidth": false,
      "processing": true,
      "serverSide": true,
      "ordering": true,
      "order": [[6, 'asc']],
      "ajax": {
        "url": "<?= $this->uri . '/ajax_datatables?n=' . _get('n') ?>",
        "type": "POST",
        // [TAMBAHAN PENTING] Kirim data filter ke controller/model
        "data": function (d) {
            d.filter_kategori = $('#main_filter_kategori').val();
        }
      },
      "deferRender": true,
      "aLengthMenu": _datatableLengthMenu,
      "pageLength": 500, // Sesuai gaya Parameter
      "columns": [
        // KOLOM 0: NO
        {
          "data": "<?= $this->pk_id ?>",
          "sortable": false,
          "className": "text-center",
          "render": function(data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        // KOLOM 1: KODE ASET
        { 
          "data": "asset_kd", 
          "className": "fw-bold",
          "width": "5%",
          "render": function(data, type, row) {
                var uri_detail = '<?= $this->uri . '/detail_modal/' ?>' + row.asset_id;
                return `<a href="javascript:void(0)" onclick="_modal(event, {uri: '${uri_detail}', size: 'modal-lg'})" class="text-primary text-decoration-none" title="Lihat Detail">${data}</a>`;
            }
        },
        // KOLOM 2: KATEGORI
        { "data": "kategori_nm" },
        
        // KOLOM 3: NAMA BARANG & SPEK
        { 
            "data": "nama_lengkap",
            "render": function(data, type, row) {
                return data ? data : '-'; 
            }
        },

        // KOLOM 4: LOKASI / PJ (MODIFIKASI DI SINI)
        { 
            "data": "lokasi_pj",
            "render": function(data) {
                // Default: Ikon Lokasi (Map Marker)
                var iconClass = "fas fa-map-marker-alt me-1";
                
                // Logika: Jika data mengandung kata 'Dipakai', berarti itu Pegawai/PJ
                if (data && data.toString().indexOf('Dipakai') !== -1) {
                    // Gunakan class yang Anda minta untuk pegawai
                    iconClass = "fas fa-user me-1 text-muted";
                }

                // Render HTML
                return `<span class="text-muted small"><i class="${iconClass}"></i> ${data}</span>`;
            }
        },

        // KOLOM 5: TAHUN
        { 
            "data": "tahun", 
            "className": "text-center"
        },

        // KOLOM 6: KONDISI
        {
          "data": "asset_kondisi",
          "className": "text-center",
          "render": function(data) {
            var color = (data == 'BAIK') ? 'success' : (data == 'RUSAK') ? 'danger' : 'warning';
            return `<span class="badge bg-${color}-lt">${data}</span>`;
          }
        },
        
        // KOLOM 7: QR CODE
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
    // [TAMBAHAN PENTING] Event Listener saat Dropdown Filter Berubah
    $('#main_filter_kategori').change(function(){
        tabel.draw(); // Refresh tabel otomatis
    });
  });
</script>