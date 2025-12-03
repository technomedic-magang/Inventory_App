<script type="text/javascript">
  var tabel = null;
  $(document).ready(function() {
    tabel = $('#datatable-main').DataTable({
      "language": { url: '<?= base_url() ?>dist/libs/DataTables/id.json' },
      "autoWidth": false,
      "processing": true,
      "responsive": true,
      "serverSide": true,
      "ordering": true,
      "order": [ [2, 'desc'] ], // Urut Tgl Kembali
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
        // 1. AKSI
        {
          "data": "<?= $this->pk_id ?>",
          "className": "text-center",
          "sortable": false,
          "render": function(data, type, row, meta) {
            var uri_delete = '<?= $this->uri . '/delete/' ?>' + data;
            return `
                <div class="dropdown">
                  <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    Aksi
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="_delete('${uri_delete}')">
                      <i class="fas fa-trash me-2"></i> Hapus
                    </a>
                  </div>
                </div>`;
          }
        },
        // 2. TGL KEMBALI
        { "data": "transaksi_tgl", "className": "text-center" },
        // 3. NO KEMBALI
        { "data": "transaksi_no", "className": "fw-bold" },
        // 4. REF PEMAKAIAN
        { "data": "pemakaian_no" }, 
        // 5. PEMINJAM
        { "data": "pegawai_nm" }, 
        // 6. KETERANGAN
        { "data": "transaksi_ket" }
      ],
    });
  });
</script>