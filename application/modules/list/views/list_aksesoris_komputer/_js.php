<script type="text/javascript">
  var tabel = null;

  // Helper: Format Tanggal (YYYY-MM-DD to DD/MM/YYYY)
  function formatTglIndo(rawDate) {
      if(!rawDate || rawDate === '0000-00-00') return '-';
      var date = new Date(rawDate);
      if (isNaN(date.getTime())) return rawDate;
      var day = String(date.getDate()).padStart(2, '0');
      var month = String(date.getMonth() + 1).padStart(2, '0');
      var year = date.getFullYear();
      return `${day}/${month}/${year}`;
  }

  $(document).ready(function() {
    tabel = $('#datatable-main').DataTable({
      "language": { url: '<?= base_url() ?>dist/libs/DataTables/id.json' },
      "autoWidth": false,
      "processing": true,
      "serverSide": true,
      "ordering": true,
      "order": [[2, 'asc']], // Urut berdasarkan Kode Aset (Index 2)
      "ajax": {
        "url": "<?= $this->uri . '/ajax_datatables?n=' . _get('n') ?>",
        "type": "POST",
        "data": function (d) {
            // [PENTING] CSRF Token untuk keamanan
            d.<?= $this->security->get_csrf_token_name() ?> = '<?= $this->security->get_csrf_hash() ?>';
        }
      },
      "deferRender": true,
      "aLengthMenu": _datatableLengthMenu,
      "pageLength": 25,
      "columns": [
        // 0. NO
        {
          "data": null,
          "sortable": false,
          "className": "text-start",
          "render": function(data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        // 1. AKSI (DROPDOWN STANDARD)
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
        // 2. KODE BARANG (LINK CLICKABLE)
        { 
            "data": "asset_kd", 
            "className": "fw-bold"
        },
        // 3. KATEGORI
        { "data": "kategori_nm" },
        // 4. NAMA BARANG
        { "data": "asset_nm" },
        // 5. MEREK & TIPE
        { "data": "merek_tipe", "render": function(d){ return d || '-'; } },
        // 6. KONDISI (BADGE WARNA STANDAR)
        {
          "data": "asset_kondisi",
          "className": "text-center",
          "render": function(data) {
            var color = 'secondary';
            if(data == 'BAIK') color = 'green';
            if(data == 'RUSAK') color = 'red';
            if(data == 'SEDANG') color = 'yellow';
            
            return `<span class="badge bg-${color}-lt">${data}</span>`;
          }
        },
        // 7. BULAN BELI
        { 
            "data": "asset_bln_beli", 
            "className": "text-center",
            "render": function(data) {
                var namaBulan = ["", "Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des"];
                var idx = parseInt(data);
                return (idx && namaBulan[idx]) ? namaBulan[idx] : '-';
            }
        },
        // 8. TAHUN BELI
        { 
            "data": "asset_thn_beli", 
            "className": "text-center",
            "render": function(data) { return data || '-'; }
        },
        // 9. KETERANGAN
        { "data": "asset_ket", "render": function(d){ return d || '-'; } },
        
        // 10. QR CODE
        { 
            "data": "asset_kd", 
            "className": "text-center",
            "sortable": false,
            "render": function(data, type, row) {
                var d = row;
                var tgl = formatTglIndo(d.tgl_pembelian_kustom);
                var qrString = `${d.asset_kd}@${d.kategori_nm}@${d.asset_nm}@${d.merek_tipe}@${tgl}`;
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