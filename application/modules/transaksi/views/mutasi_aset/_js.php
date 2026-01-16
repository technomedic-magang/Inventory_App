<script type="text/javascript">
  var tabel = null;

  $(document).ready(function() {
    // Inisialisasi DataTable
    tabel = $('#datatable-main').DataTable({
      "language": {
        url: '<?= base_url() ?>dist/libs/DataTables/id.json',
      },
      "autoWidth": false,
      "processing": true,
      "responsive": true,
      "serverSide": true,
      "ordering": true,
      "order": [
        [2, 'desc'] // Urut berdasarkan Tgl Mutasi
      ],
      "ajax": {
        // Gunakan $this->uri langsung
        "url": "<?= $this->uri . '/ajax_datatables?n=' . _get('n') ?>",
        "type": "POST"
      },
      "deferRender": true,
      "pageLength": 500,
      "columns": [{
          "data": "<?= $this->pk_id ?>",
          "sortable": false,
          "className": "text-center",
          "render": function(data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          "data": "<?= $this->pk_id ?>",
          "sortable": false,
          "className": "text-center",
          "render": function(data, type, row, meta) {
            // Gunakan $this->uri langsung
            var uri_delete = '<?= $this->uri . "/delete/" ?>' + data;

            return '' +
              '<div class="dropdown">' +
              '  <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">' +
              '    Aksi' +
              '  </button>' +
              '  <div class="dropdown-menu">' +
              '    <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="_delete(\'' + uri_delete + '\')">' +
              '      <?= _icon("trash") ?> Hapus Log' +
              '    </a>' +
              '  </div>' +
              '</div>';
          }
        },
        {
          "data": "transaksi_tgl",
          "className": "text-center",
          "render": function(data) {
            if (!data) return '-';
            // Format YYYY-MM-DD -> DD-MM-YYYY
            return data.split('-').reverse().join('-');
          }
        },
        {
          "data": "transaksi_no",
          "className": "text-left fw-bold"
        },
        {
          "data": "asal_nm",
          "className": "text-left",
          "render": function(d) {
            if (!d) return '-';
            return '<span class="text-muted"><i class="fas fa-arrow-up text-danger me-1"></i> ' + d + '</span>';
          }
        },
        {
          "data": "tujuan_nm",
          "className": "text-left",
          "render": function(d) {
            if (!d) return '-';
            return '<span class="text-success fw-bold"><i class="fas fa-arrow-down me-1"></i> ' + d + '</span>';
          }
        },
        {
          "data": "keterangan",
          "className": "text-left"
        }
      ],
    });
  });
</script>