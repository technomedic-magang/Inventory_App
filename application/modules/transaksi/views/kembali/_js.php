<script type="text/javascript">
  var tabel = null;

  $(document).ready(function() {
    tabel = $('#datatable-main').DataTable({
      "language": {
        url: '<?= base_url() ?>dist/libs/DataTables/id.json'
      },
      "autoWidth": false,
      "processing": true,
      "responsive": true,
      "serverSide": true,
      "ordering": true,
      "order": [
        [2, 'desc'] // Urut Tgl Kembali
      ],
      "ajax": {
        // [FIX] Gunakan variabel URI langsung
        "url": "<?= $this->uri . '/ajax_datatables?n=' . _get('n') ?>",
        "type": "POST"
      },
      "deferRender": true,
      "pageLength": 25,
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
          "className": "text-center",
          "sortable": false,
          "render": function(data, type, row, meta) {
            // [FIX] Gunakan variabel URI langsung
            var uri_delete = '<?= $this->uri . '/delete/' ?>' + data;

            return '' +
              '<div class="btn-list btn-sm flex-nowrap">' +
              '  <div class="dropdown"> ' +
              '    <button class="btn btn-outline-primary btn-sm dropdown-toggle align-text-top" data-bs-toggle="dropdown">' +
              '        Aksi' +
              '    </button>' +
              '    <div class="dropdown-menu dropdown-menu-end">' +
              '      <a class="dropdown-item p-1 text-danger" href="javascript:void(0)" onclick=_delete("' + uri_delete + '")>' +
              '          <?= _icon('trash') ?> Hapus Log' +
              '      </a>' +
              '    </div>' +
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
          "className": "fw-bold"
        },
        {
          "data": "pemakaian_no",
          "render": function(data) {
            return data ? '<span class="text-muted"><i class="fas fa-link me-1"></i>' + data + '</span>' : '-';
          }
        },
        {
          "data": "pegawai_nm"
        },
        {
          "data": "transaksi_ket",
          "className": "text-left small text-muted"
        }
      ],
    });
  });
</script>