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
      "order": [
        [2, 'asc'] 
      ],
      "ajax": {
        // [MODIFIKASI 4] Gunakan site_url() agar konsisten
        "url": "<?= site_url('manajemen/manajemen_gudang/ajax_datatables?n=' . _get('n')) ?>",
        "type": "POST"
      },
      "deferRender": true,
      "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]], // Contoh perbaikan format menu
      "pageLength": 10, // Default jangan 500 biar ringan
      "columns": [{
          "data": "<?= $this->pk_id ?>",
          "sortable": false,
          "render": function(data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          "data": "<?= $this->pk_id ?>",
          "className": "text-left",
          "sortable": false,
          "render": function(data, type, row, meta) {
            var uri_edit = '<?= site_url("manajemen/manajemen_gudang/form_modal/") ?>' + data;
            var uri_delete = '<?= site_url("manajemen/manajemen_gudang/delete/") ?>' + data;
            
            return '' +
              '<div class="btn-list btn-sm flex-nowrap">' +
              '  <div class="dropdown"> ' +
              '    <button class="btn btn-outline-primary btn-sm dropdown-toggle align-text-top" data-bs-toggle="dropdown">' +
              '        Aksi' +
              '    </button>' +
              '    <div class="dropdown-menu">' +
              '      <a class="dropdown-item p-1" href="javascript:void(0)" onclick="_modal(event, {uri: \'' + uri_edit + '\', size: \'modal-lg\', position: \'normal\'})">' +
              '          <i class="fas fa-edit me-1"></i> Ubah' +
              '      </a>' +
              '      <a class="dropdown-item p-1 text-danger" href="javascript:void(0)" onclick="_delete(\'' + uri_delete + '\')">' +
              '          <i class="fas fa-trash me-1"></i> Hapus' +
              '      </a>' +
              '    </div>' +
              '  </div>' +
              '</div>';
          }
        },
        { "data": "gudang_kd", "className": "text-left" },
        { "data": "gudang_nm", "className": "text-left fw-bold" }, // Tebalkan nama
        { "data": "gudang_alm", "className": "text-left" },
        // [PENTING] Ini akan ambil dari alias 'pic_nm' hasil join di model
        { "data": "pic_nm", "className": "text-left" }, 
        {
          "data": "active_st",
          "className": "text-center",
          "render": function(data) {
            return (data == 1) 
                ? '<i class="fas fa-check-circle text-success" title="Aktif"></i>' 
                : '<i class="fas fa-times-circle text-danger" title="Non-Aktif"></i>';
          }
        },
      ],
    });
  });
</script>