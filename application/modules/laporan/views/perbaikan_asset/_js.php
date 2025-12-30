<script type="text/javascript">
  var tabel = null;
  $(document).ready(function() {
    tabel = $('#datatable-main').DataTable({
      "language": { url: '<?= base_url() ?>dist/libs/DataTables/id.json' },
      "autoWidth": false,
      "processing": true,
      "serverSide": true,
      "ordering": true,
      "order": [ [2, 'desc'] ], 
      "ajax": {
        "url": "<?= site_url($this->uri . '/ajax_datatables?n=' . _get('n')) ?>",
        "type": "POST",
        "data": function (d) {
            d.<?php echo $this->security->get_csrf_token_name(); ?> = '<?php echo $this->security->get_csrf_hash(); ?>';
        },
        "error": function (xhr, error, code) {
            console.log("Error:", xhr.responseText);
        }
      },
      "columns": [
        {
          "data": "<?= $this->pk_id ?>",
          "sortable": false,
          "render": function(data, type, row, meta) { return meta.row + meta.settings._iDisplayStart + 1; }
        },
        {
          "data": "<?= $this->pk_id ?>",
          "sortable": false,
          "render": function(data, type, row, meta) {
            var uri_edit = '<?= site_url($this->uri . '/form_modal/') ?>' + data;
            var uri_delete = '<?= site_url($this->uri . '/delete/') ?>' + data;
            return '' +
              '<div class="dropdown">' +
              '  <button class="btn btn-outline-primary btn-sm dropdown-toggle align-text-top" data-bs-toggle="dropdown">Aksi</button>' +
              '  <div class="dropdown-menu dropdown-menu-end">' +
              '    <a class="dropdown-item" href="javascript:void(0)" onclick="_modal(event, {uri: \'' + uri_edit + '\', size: \'modal-lg\'})"><i class="fas fa-edit me-2"></i> Edit</a>' +
              '    <a class="dropdown-item text-danger" href="javascript:void(0)" onclick=_delete("' + uri_delete + '")><i class="fas fa-trash me-2"></i> Hapus</a>' +
              '  </div>' +
              '</div>';
          }
        },
        {
          "data": "tgl_service",
          "render": function(data) { return data ? data.split('-').reverse().join('-') : '-'; }
        },
        {
          "data": "asset_nm",
          "render": function(data, type, row) {
              return '<div class="fw-bold">' + data + '</div><div class="small text-muted">' + (row.asset_kd ? row.asset_kd : '') + '</div>';
          }
        },
        {
          "data": "keterangan_txt",
          "render": function(data) { return data ? data : '-'; }
        },
        {
          "data": "bengkel_nm",
          "render": function(data) { return data ? data : '-'; }
        },
        {
          "data": "biaya",
          "className": "text-end",
          "render": function(data) { return 'Rp ' + parseInt(data).toLocaleString('id-ID'); }
        }
      ],
    });
  });
</script>