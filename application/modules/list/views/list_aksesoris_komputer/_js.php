<script type="text/javascript">
  var tabel = null;

  // Helper Format Tanggal (YYYY-MM-DD -> DD/MM/YYYY)
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
      "order": [[1, 'asc']], // Urut berdasarkan Kode Barang
      "scrollX": true, 
      "ajax": {
        "url": "<?= $this->uri . '/ajax_datatables?n=' . _get('n') ?>",
        "type": "POST"
      },
      "deferRender": true,
      "aLengthMenu": _datatableLengthMenu,
      "pageLength": 25,
      "columns": [
        // 0. NO
        {
          "data": "<?= $this->pk_id ?>",
          "sortable": false,
          "className": "text-center",
          "render": function(data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        
        // 1. Kode Barang (Link ke Detail)
        { 
            "data": "asset_kd", 
            "className": "fw-bold",
            "render": function(data, type, row) {
                 var uri_detail = '<?= $this->uri . '/detail_modal/' ?>' + row.asset_id;
                 return `<a href="javascript:void(0)" onclick="_modal(event, {uri: '${uri_detail}', size: 'modal-lg'})" class="text-primary text-decoration-none" title="Lihat Detail">${data}</a>`;
            }
        },
        
        // 2. Kategori
        { "data": "kategori_nm" },
        
        // 3. Nama Barang
        { "data": "asset_nm" },
        
        // 4. Merek & Tipe (Dari Atribut Kustom)
        { "data": "merek_tipe", "render": function(d){ return d || '-'; } },
        
        // 5. Kondisi
        {
          "data": "asset_kondisi",
          "className": "text-center",
          "render": function(data) {
            var color = (data == 'BAIK') ? 'success' : (data == 'RUSAK') ? 'danger' : 'warning';
            return `<span class="badge bg-${color}-lt">${data}</span>`;
          }
        },

        // 6. Tgl Pembelian (Dari Atribut Kustom)
        { 
            "data": "tgl_pembelian_kustom", 
            "className": "text-center",
            "render": function(data) {
                return formatTglIndo(data);
            }
        },

        // 7. [KOLOM BARU] Keterangan
        { "data": "asset_ket", "render": function(d){ return d || '-'; } },
        
        // 8. QR Code
        { 
            "data": "asset_kd", 
            "className": "text-center",
            "sortable": false,
            "render": function(data, type, row) {
                var d = row;
                var tgl = formatTglIndo(d.tgl_pembelian_kustom);
                
                // Format: SKU@KATEGORI@NAMA@MEREK@TANGGAL
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