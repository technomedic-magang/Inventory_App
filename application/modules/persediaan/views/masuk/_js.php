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
        [2, 'desc'] // Urut berdasarkan Tanggal
      ],
      "ajax": {
        // [FIX ERROR] Gunakan $this->uri langsung karena sudah FULL URL dari controller
        "url": "<?= $this->uri . '/ajax_datatables?n=' . _get('n') ?>",
        "type": "POST"
      },
      "deferRender": true,
      "aLengthMenu": (typeof _datatableLengthMenu !== 'undefined') ? _datatableLengthMenu : [
        [10, 25, 50, -1],
        [10, 25, 50, "All"]
      ],
      "pageLength": 25,
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
            // [FIX ERROR] Gunakan $this->uri langsung tanpa site_url()
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
          "data": "beli_tgl",
          "className": "text-left",
          "render": function(data) {
            if (!data) return '-';
            // Format dd-mm-yyyy manual
            var parts = data.split('-');
            return parts[2] + '-' + parts[1] + '-' + parts[0];
          }
        },
        {
          "data": "struk_no",
          "className": "text-left",
          "render": function(data) {
            if (!data) return '<span class="text-muted">-</span>';
            var color = 'blue';
            if (data.indexOf('AUTO') !== -1) {
                color = 'secondary';
            }
            return '<span class="badge bg-' + color + '-lt">' + data + '</span>';
          }
        },
        {
          "data": "barang_nm",
          "className": "text-left fw-bold"
        },
        {
          "data": "kategori_nm",
          "className": "text-left",
          "render": function(data) {
            return data ? data : '<span class="text-muted">-</span>';
          }
        },
        {
          "data": "masuk_qty",
          "className": "text-left fw-bold",
          "render": function(data) {
            return parseFloat(data).toLocaleString('id-ID');
          }
        },
        {
          "data": "satuan_nm",
          "className": "text-left"
        },
        {
          "data": "keterangan_txt",
          "className": "text-left small text-muted"
        }
      ],
    });
  });
</script>