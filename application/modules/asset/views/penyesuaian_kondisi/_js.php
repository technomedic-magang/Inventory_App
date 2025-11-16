<script type="text/javascript">
  var tabel = null;
  $(document).ready(function() {
    tabel = $('#datatable-main').DataTable({
      "language": {
        url: '<?= base_url() ?>dist/libs/DataTables/id.json',
      },
      "autoWidth": false,
      "processing": true,
      "serverSide": true,
      "ordering": true,
      "order": [ [2, 'desc'] ],
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
          "sortable": false,
          "render": function(data, type, row, meta) {
            var uri_delete = '<?= $this->uri . '/delete/' ?>' + data;
            return '' +
              '<div class="btn-list btn-sm flex-nowrap">' +
              '  <div class="dropdown"> ' +
              '    <button class="btn btn-outline-primary btn-sm dropdown-toggle align-text-top" data-bs-toggle="dropdown">' +
              '        Aksi' +
              '    </button>' +
              '    <div class="dropdown-menu">' +
              '      <a class="dropdown-item p-1 text-danger" href="javascript:void(0)" onclick=_delete("' + uri_delete + '")>' +
              '          <?= _icon('trash') ?> Hapus Log' +
              '      </a>' +
              '    </div>' +
              '  </div>' +
              '</div>';
          }
        },
        { "data": "transaksi_tgl", "className": "text-left" },
        { "data": "transaksi_no", "className": "text-left fw-bold" },
        { "data": "asset_nm", "className": "text-left" },
        { "data": "kondisi_dari", "className": "text-left" },
        { 
          "data": "kondisi_ke", 
          "className": "text-center",
          "render": function(data) {
             var color = 'secondary';
             if(data == 'BAIK') color = 'success';
             if(data == 'RUSAK') color = 'danger';
             if(data == 'PERBAIKAN') color = 'warning';
             if(data == 'MUSNAH') color = 'dark';
             return `<span class="badge bg-${color}-lt">${data}</span>`;
          }
        },
        { "data": "transaksi_ket", "className": "text-left" }
      ],
    });
  });
</script>