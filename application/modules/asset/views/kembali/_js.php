<script type="text/javascript">
  var tabel = null;
  $(document).ready(function() {
    tabel = $('#datatable-main').DataTable({
      "language": { url: '<?= base_url() ?>dist/libs/DataTables/id.json' },
      "processing": true,
      "serverSide": true,
      "ordering": true,
      "order": [[1, 'desc']],
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
            var uri_del = '<?= $this->uri . '/delete/' ?>' + data;
            return '<button class="btn btn-sm btn-outline-danger" onclick=_delete("' + uri_del + '")><i class="fas fa-trash"></i></button>';
          }
        },
        { "data": "transaksi_tgl", "className": "text-center" },
        { "data": "transaksi_no", "className": "fw-bold" },
        { "data": "pinjam_no" },   // Dari JOIN trx_pinjam
        { "data": "pegawai_nm" },  // Dari JOIN mst_pegawai
        { "data": "transaksi_ket" }
      ],
    });
  });
</script>