<script type="text/javascript">
  var tabel = null;

  $(document).ready(function() {
    // Inisialisasi DataTables
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
        [2, 'asc'] // Urutkan berdasarkan Kode Gudang (kolom ke-3)
      ],
      "ajax": {
        "url": "<?= $this->uri . '/ajax_datatables?n=' . _get('n') ?>",
        "type": "POST"
      },
      "deferRender": true,
      "aLengthMenu": _datatableLengthMenu,
      "pageLength": 500,
      "columns": [{
          "data": "<?= $this->pk_id ?>",
          "sortable": false,
          "render": function(data, type, row, meta) {
            // Membuat penomoran urut otomatis (1, 2, 3...)
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          "data": "<?= $this->pk_id ?>",
          "className": "text-left",
          "sortable": false,
          "render": function(data, type, row, meta) {
            // Definisi URL untuk tombol Edit dan Hapus
            var uri_edit = '<?= $this->uri . '/form_modal/' ?>' + data;
            var uri_delete = '<?= $this->uri . '/delete/' ?>' + data;

            // Render tombol Aksi menggunakan String Concatenation
            return '' +
              '<div class="btn-list btn-sm flex-nowrap">' +
              '  <div class="dropdown"> ' +
              '    <button class="btn btn-outline-primary btn-sm dropdown-toggle align-text-top" data-bs-toggle="dropdown">' +
              '        Aksi' +
              '    </button>' +
              '    <div class="dropdown-menu">' +
              '      <a class="dropdown-item p-1" href="javascript:void(0)" onclick="_modal(event, {uri: \'' + uri_edit + '\', size: \'modal-lg\', position: \'normal\'})">' +
              '          <?= _icon('edit') ?> Ubah' +
              '      </a>' +
              '      <a class="dropdown-item p-1" href="javascript:void(0)" onclick="_delete(\'' + uri_delete + '\')">' +
              '          <?= _icon('trash') ?> Hapus' +
              '      </a>' +
              '    </div>' +
              '  </div>' +
              '</div>';
          }
        },
        {
          "data": "gudang_kd",
          "className": "text-left",
        },
        {
          "data": "gudang_nm",
          "className": "text-left fw-bold", // Menebalkan nama gudang
        },
        {
          "data": "gudang_alm",
          "className": "text-left",
        },
        {
          "data": "pic_nm",
          "className": "text-left",
        },
        {
          "data": "active_st",
          "className": "text-center",
          "render": function(data, type, row, meta) {
            // Logika render status menggunakan IF/ELSE klasik
            var result = '';
            if (row['active_st'] == 1) {
              result = '<i class="fas fa-check-circle text-success" title="Aktif"></i>';
            } else {
              result = '<i class="fas fa-times-circle text-danger" title="Non-Aktif"></i>';
            }
            return result;
          }
        },
      ],
    });
  });
</script>