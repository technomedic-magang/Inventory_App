<script type="text/javascript">
  var tabel = null;

  $(document).ready(function() {
    
    // Helper Format Tanggal
    var formatTglIndo = function(rawDate) {
        if(!rawDate || rawDate === '0000-00-00') return '-';
        var date = new Date(rawDate);
        if (isNaN(date.getTime())) return rawDate; 
        
        var day = String(date.getDate()).padStart(2, '0');
        var month = String(date.getMonth() + 1).padStart(2, '0');
        var year = date.getFullYear();
        return day + '/' + month + '/' + year;
    };

    tabel = $('#datatable-main').DataTable({
      "language": { url: '<?= base_url() ?>dist/libs/DataTables/id.json' },
      "autoWidth": false,
      "processing": true,
      "serverSide": true,
      "ordering": true,
      "order": [[2, 'asc']],
      "ajax": {
        "url": "<?= $this->uri . '/ajax_datatables?n=' . _get('n') ?>",
        "type": "POST",
        "data": function (d) {
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
                        <a class="dropdown-item" href="javascript:void(0)" onclick="_modal(event, {uri: '${uri_detail}', size: 'modal-lg', title: 'Detail Aset'})">
                            <i class="fas fa-eye me-2"></i> Detail
                        </a>
                      </div>
                    </div>
                 `;
            }
        },
        // 2. KODE ASET (LINK)
        { 
            "data": "asset_kd", 
            "className": "fw-bold"
        },
        // 3. KATEGORI
        { "data": "kategori_nm" },
        // 4. NAMA BARANG
        { "data": "asset_nm" },
        // 5. MEREK/TIPE
        { "data": "merek_tipe", "render": function(d){ return d || '-'; } },
        // 6. KONDISI
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
        // 7. PJ
        { "data": "penanggungjawab", "className": "fw-bold" },
        // 8. JABATAN
        { "data": "jabatan", "className": "small text-muted" },
        // 9. LOKASI
        { "data": "lokasi" },
        
        // 10. BULAN BELI
        { 
            "data": "asset_bln_beli", 
            "className": "text-center",
            "render": function(data) {
                var namaBulan = ["", "Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des"];
                var idx = parseInt(data);
                return (idx && namaBulan[idx]) ? namaBulan[idx] : '-';
            }
        },

        // 11. TAHUN BELI
        { 
            "data": "asset_thn_beli", 
            "className": "text-center",
            "render": function(data) { return data || '-'; }
        },
        
        // 12. KETERANGAN
        { "data": "asset_ket", "render": function(d){ return d || '-'; } },

        // 13. QR CODE
        { 
            "data": "asset_kd", 
            "className": "text-center",
            "sortable": false,
            "render": function(data, type, row) {
                var qrString = `${row.asset_kd}@${row.kategori_nm}@${row.asset_nm}@${row.merek_tipe}@${row.lokasi}@${row.penanggungjawab}`;
                var baseUrl = "http://e-bphtb.kebumenkab.go.id/index.php/api_qrcode/index?text=";
                var finalUrl = baseUrl + encodeURIComponent(qrString);

                return `<a href="${finalUrl}" target="_blank" class="btn btn-sm btn-ghost-dark btn-icon" title="Cetak QR">
                          <i class="fas fa-qrcode fa-lg"></i>
                        </a>`;
            }
        },
      ],
    });
  });
</script>