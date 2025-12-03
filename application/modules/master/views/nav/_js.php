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
        [0, 'asc']
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
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          "data": "<?= $this->pk_id ?>",
          "className": "text-left",
          "render": function(data, type, row, meta) {
            var uri_edit = '<?= $this->uri . '/form_modal/' ?>' + data;
            var uri_delete = '<?= $this->uri . '/delete/' ?>' + data;
            var all_link = '';

            <?php if ($this->nav['all_data_st'] == 1): ?>
              var uri_access = '<?= $this->uri . '/full_access/' ?>' + data;
              all_link = '      <a class="dropdown-item p-1" href="javascript:void(0)" onclick=_confirm("' + uri_access + '")>' +
                '          <i class="fas fa-users me-2 text-primary"></i> Akses Semua Pegawai' +
                '      </a>';
            <?php endif; ?>

            return '' +
              '<div class="btn-list btn-sm flex-nowrap">' +
              '  <div class="dropdown"> ' +
              '     <button class="btn btn-outline-primary btn-sm dropdown-toggle align-text-top" data-bs-toggle="dropdown">' +
              '          Aksi' +
              '     </button>' +
              '     <div class="dropdown-menu">' + all_link +
              '      <a class="dropdown-item p-1" href="javascript:void(0)" onclick="_modal(event, {uri: \'' + uri_edit + '\', size: \'modal-md\', position: \'normal\'})">' +
              '          <?= _icon('edit') ?> Ubah Data' +
              '      </a>' +
              '      <a class="dropdown-item p-1" href="javascript:void(0)" onclick=_delete("' + uri_delete + '")>' +
              '          <?= _icon('trash') ?> Hapus Data' +
              '      </a>' +
              '   </div>' +
              ' </div>' +
              '</div>';
          }
        },
        {
          "data": "nav_id",
          "className": "text-left",
          "render": function(data, type, row, meta) {
            var data = ifNull(data);
            var result = data;

            return result;
            result = data;
          }
        },
        {
          "data": "nav_parent",
          "className": "text-left",
          "render": function(data, type, row, meta) {
            var data = ifNull(data);
            var result = data;

            return result;
            result = data;
          }
        },
        {
          "data": "nav_nm",
          "className": "text-left",
          "render": function(data, type, row, meta) {
            var data = ifNull(data);
            var result = data;
            result = '<span class="">' + data + '</span>';
            return result;
          }
        },
        {
          "data": "nav_url",
          "className": "text-left",
          "render": function(data, type, row, meta) {
            var data = ifNull(data);
            var result = data;

            result = data;
            return result;
          }
        },
        {
          "data": "icon",
          "className": "text-left",
          "render": function(data, type, row, meta) {
            var data = ifNull(data);
            var result = data;

            result = '<span class="fw-bold">' + data + '</span>';
            return result;
          }
        },
        {
          "data": "active_st",
          "className": "text-center",
          "render": function(data, type, row, meta) {
            var data = ifNull(data);
            var result = data;
            if (row['active_st'] == 1) {
              result = '<i class="fas fa-check-circle text-success "></i>';
            } else {
              result = '<i class="fas fa-times-circle text-danger"></i>';
            }
            return result;
          }
        },
      ],
    });
    // tabel.draw();
  });
</script>