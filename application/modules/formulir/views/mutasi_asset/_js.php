<script type="text/javascript">
  var tabel = null;
  $(document).ready(function() {
    tabel = $('#datatable-main').DataTable({
      "language": {
        url: '<?= base_url() ?>dist/libs/DataTables/id.json',
      },
      "autoWidth": false,
      "processing": true,
      "responsive": true,
      "serverSide": true,
      "ordering": true,
      "order": [ [2, 'desc'] ], // Urut berdasarkan Tgl Mutasi
      "ajax": {
<<<<<<< HEAD
        "url": "<?= $this->uri . '/ajax_datatables?n=' . _get('n') ?>", 
        "type": "POST"
      },
      "deferRender": true,
      "aLengthMenu": _datatableLengthMenu,
=======
        // [FIX] URL Absolut
        "url": "<?= site_url('formulir/mutasi_asset/ajax_datatables?n=' . _get('n')) ?>", 
        "type": "POST"
      },
      "deferRender": true,
>>>>>>> repoB/main
      "pageLength": 25,
      "columns": [
        // 0. NO
        {
<<<<<<< HEAD
          "data": "<?= $this->pk_id ?>",
=======
          "data": "mutasi_id", // Sesuaikan nama kolom primary key di model (tadi $pk_id='mutasi_id')
>>>>>>> repoB/main
          "sortable": false,
          "className": "text-center",
          "render": function(data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        // 1. AKSI
        {
<<<<<<< HEAD
          "data": "<?= $this->pk_id ?>",
          "sortable": false,
          "className": "text-center",
          "render": function(data, type, row, meta) {
            var uri_delete = '<?= $this->uri . '/delete/' ?>' + data;
=======
          "data": "mutasi_id",
          "sortable": false,
          "className": "text-center",
          "render": function(data, type, row, meta) {
            var uri_delete = '<?= site_url("formulir/mutasi_asset/delete/") ?>' + data;
>>>>>>> repoB/main
            return `
                <div class="dropdown">
                  <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    Aksi
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="_delete('${uri_delete}')">
                      <i class="fas fa-trash me-2"></i> Hapus Log
                    </a>
                  </div>
                </div>`;
          }
        },
        // 2. TGL MUTASI
<<<<<<< HEAD
        { "data": "transaksi_tgl", "className": "text-center" },
=======
        { 
            "data": "transaksi_tgl", 
            "className": "text-center",
            "render": function(data) {
                // [FIX] Format dd-mm-yyyy
                return data ? data.split('-').reverse().join('-') : '-';
            }
        },
>>>>>>> repoB/main
        
        // 3. NO DOKUMEN
        { "data": "transaksi_no", "className": "text-left fw-bold" },
        
        // 4. DARI PEGAWAI
        { 
            "data": "asal_nm", 
            "className": "text-left",
            "render": function(d) {
<<<<<<< HEAD
                // Tambahkan ikon panah merah (keluar) agar visual lebih jelas
=======
>>>>>>> repoB/main
                return `<span class="text-muted"><i class="fas fa-arrow-up text-danger me-1"></i> ${d}</span>`;
            }
        },
        
        // 5. KE PEGAWAI
        { 
            "data": "tujuan_nm",
            "className": "text-left",
            "render": function(d) {
<<<<<<< HEAD
                // Tambahkan ikon panah hijau (masuk)
=======
>>>>>>> repoB/main
                return `<span class="text-success fw-bold"><i class="fas fa-arrow-down me-1"></i> ${d}</span>`;
            }
        },
        
        // 6. KETERANGAN
        { "data": "keterangan", "className": "text-left" }
      ],
    });
  });
</script>