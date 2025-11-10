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
            if(row.pinjam_sts == 'OPEN') {
                 return '<button class="btn btn-sm btn-outline-danger" onclick=_delete("' + uri_del + '")><i class="fas fa-trash"></i></button>';
            }
            return '';
          }
        },
        // Pastikan nama kolom ini SAMA dengan di database 'trx_pinjam'
        { "data": "transaksi_tgl", "className": "text-center" }, // DULU: pinjam_tgl
        { "data": "transaksi_no", "className": "fw-bold" },      // DULU: pinjam_no
        { "data": "pegawai_nm" }, // Dari JOIN mst_pegawai
        { "data": "kembali_rencana_tgl", "className": "text-center" },
        { 
            "data": "pinjam_sts",
            "className": "text-center",
            "render": function(data) {
                var color = (data == 'OPEN') ? 'warning' : 'success';
                return '<span class="badge bg-' + color + '-lt">' + data + '</span>';
            }
        }
      ],
    });
  });
</script>