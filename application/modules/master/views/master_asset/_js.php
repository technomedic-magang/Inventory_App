<script type="text/javascript">
  var tabel = null;
  $(document).ready(function() {
    tabel = $('#datatable-main').DataTable({
      "language": { url: '<?= base_url() ?>dist/libs/DataTables/id.json' },
      "processing": true,
      "serverSide": true,
      "ordering": true,
      "order": [[2, 'asc']], // Urutkan berdasarkan Kode Asset
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
            var uri_edit = '<?= $this->uri . '/form_modal/' ?>' + data;
            var uri_delete = '<?= $this->uri . '/delete/' ?>' + data;
            return '<div class="dropdown">' +
                   '<button class="btn btn-sm btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">Aksi</button>' +
                   '<div class="dropdown-menu">' +
                   '<a class="dropdown-item" href="javascript:void(0)" onclick="_modal(event, {uri: \'' + uri_edit + '\', size: \'modal-lg\'})"><i class="fas fa-edit me-2"></i> Ubah</a>' +
                   '<div class="dropdown-divider"></div>' +
                   '<a class="dropdown-item text-danger" href="javascript:void(0)" onclick=_delete("' + uri_delete + '")><i class="fas fa-trash me-2"></i> Hapus</a>' +
                   '</div></div>';
          }
        },
        // --- SESUAIKAN DENGAN NAMA KOLOM BARU ---
        { "data": "asset_kd" },
        { "data": "asset_nm" },
        { "data": "kategori_nm" },      // Dari JOIN
        { "data": "satuan_nm" },        // Dari JOIN
        { 
            "data": "stok_min_qty",     // Nama baru untuk stok minimal
            "className": "text-end",    // Rata kanan untuk angka
            "render": $.fn.dataTable.render.number('.', ',', 0) // Format angka (opsional)
        },
        {
            "data": "active_st",
            "className": "text-center",
            "render": function(data) {
                return (data == 1) ? '<i class="fas fa-check-circle text-success" title="Aktif"></i>' : '<i class="fas fa-times-circle text-danger" title="Non-Aktif"></i>';
            }
        }
      ],
    });
  });
</script>