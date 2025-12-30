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
        // [FIX] Site URL
        "url": "<?= site_url('formulir/kembali/ajax_datatables?n=' . _get('n')) ?>",
        "type": "POST"
      },
      "deferRender": true,
      "pageLength": 25,
      "columns": [
        {
          "data": "kembali_id",
          "sortable": false,
          "className": "text-center",
          "render": function(data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          "data": "kembali_id",
          "className": "text-center",
          "sortable": false,
          "render": function(data, type, row, meta) {
            var uri_delete = '<?= site_url("formulir/kembali/delete/") ?>' + data;
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
        // [FIX] FORMAT TANGGAL
        { 
            "data": "transaksi_tgl", 
            "className": "text-center",
            "render": function(data) {
                return data ? data.split('-').reverse().join('-') : '-';
            }
        },
        { "data": "transaksi_no", "className": "fw-bold" },
        { "data": "pemakaian_no" }, 
        { "data": "pegawai_nm" }, 
        { "data": "transaksi_ket" }
      ],
    });
  });
</script>