<script type="text/javascript">
  var tabel = null;
  $(document).ready(function() {
    tabel = $('#datatable-main').DataTable({
      "language": { url: '<?= base_url() ?>dist/libs/DataTables/id.json' },
      "processing": true,
      "serverSide": true,
      "ordering": true,
      "order": [[2, 'desc']], // Urutkan berdasarkan Tanggal Transaksi terbaru
      "ajax": {
        "url": "<?= $this->uri . '/ajax_datatables?n=' . _get('n') ?>",
        "type": "POST"
      },
      "deferRender": true,
      "columns": [
        {
          "data": "<?= $this->pk_id ?>",
          "sortable": false,
          "render": function(data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          "data": "<?= $this->pk_id ?>",
          "sortable": false,
          "className": "text-center",
          "render": function(data, type, row, meta) {
            // Hanya tombol Hapus yang aman untuk sekarang
            var uri_delete = '<?= $this->uri . '/delete/' ?>' + data;
            return '<button class="btn btn-sm btn-outline-danger" onclick=_delete("' + uri_delete + '") title="Hapus"><i class="fas fa-trash"></i></button>';
          }
        },
        { "data": "transaksi_tgl", "className": "text-center" },
        { "data": "transaksi_no", "className": "fw-bold" },
        { "data": "gudang_nm" }, // Dari JOIN di Model
        { "data": "transaksi_ket" }
      ],
    });
  });
</script>