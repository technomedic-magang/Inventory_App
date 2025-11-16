<script type="text/javascript">
  var tabel = null;

  // Fungsi Helper untuk format tanggal (YYYY-MM-DD -> DD/MM/YYYY)
  function formatTanggalIndo(tglStr) {
      if (!tglStr || tglStr === '0000-00-00') return '-';
      var date = new Date(tglStr);
      if (isNaN(date.getTime())) return tglStr; // Kembalikan asli jika bukan tanggal valid
      
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
      "order": [[1, 'asc']], 
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
        
        // 1. Kode Barang
        { "data": "asset_kd", "className": "fw-bold" },
        
        // 2. Kategori
        { "data": "kategori_nm" },
        
        // 3. Nama Barang
        { "data": "asset_nm" },
        
        // 4. [UPDATE] Tanggal Beli Lengkap (Atribut Kustom)
        { 
            "data": "tgl_beli_lengkap", 
            "className": "text-center",
            "render": function(data) {
                return formatTanggalIndo(data);
            }
        },
        
        // 5. Alamat
        { 
            "data": "alamat",
            "render": function(data) {
                return data ? data : '<span class="text-muted text-italic">-</span>';
            }
        },
        
        // 6. QR Code Link Otomatis
        { 
            "data": "asset_kd", 
            "className": "text-center",
            "sortable": false,
            "render": function(data, type, row) {
                var kode = row.asset_kd || '-';
                var kat  = row.kategori_nm || '-';
                var nama = row.asset_nm || '-';
                var almt = row.alamat || '-';
                
                // Gunakan helper format tanggal untuk QR juga
                var tgl  = formatTanggalIndo(row.tgl_beli_lengkap);

                // Format: KODE@KATEGORI@NAMA@TANGGAL@ALAMAT
                var qrString = `${kode}@${kat}@${nama}@${tgl}@${almt}`;

                var baseUrl = "http://e-bphtb.kebumenkab.go.id/index.php/api_qrcode/index?text=";
                var finalUrl = baseUrl + encodeURIComponent(qrString);

                return `<a href="${finalUrl}" target="_blank" class="btn btn-sm btn-ghost-dark btn-icon" title="Lihat QR Code">
                          <i class="fas fa-qrcode fa-lg"></i>
                        </a>`;
            }
        },
      ],
    });
  });
</script>