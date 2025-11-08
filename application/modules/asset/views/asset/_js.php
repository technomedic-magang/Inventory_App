<script type="text/javascript">
  var tabel = null;

  $(document).ready(function() {
    tabel = $('#datatable-main').DataTable({
      // 1. Perbaikan URL Bahasa (Typo 'libsS' -> 'libs')
      "language": {
        url: '<?= base_url() ?>dist/libs/DataTables/id.json',
      },
      "processing": true,
      "serverSide": true,
      "ordering": true,
      // 2. Perbaikan URL Ajax (Menambahkan Token '?n=' seperti referensi Pegawai)
      "ajax": {
        "url": "<?= $this->uri . '/ajax_datatables?n=' . _get('n') ?>",
        "type": "POST"
      },
      "deferRender": true,
      "columns": [
        // --- KOLOM 0: NOMOR URUT ---
        {
          "data": "<?= $this->pk_id ?>",
          "sortable": false,
          "render": function(data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        // --- KOLOM 1: TOMBOL AKSI ---
        {
          "data": "<?= $this->pk_id ?>",
          "sortable": false,
          "className": "text-center",
          "render": function(data, type, row, meta) {
            var uri_edit = '<?= $this->uri . '/form_modal/' ?>' + data;
            var uri_delete = '<?= $this->uri . '/delete/' ?>' + data;
            return '<div class="dropdown">' +
                   '<button class="btn btn-outline-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">Aksi</button>' +
                   '<div class="dropdown-menu">' +
                   '<a class="dropdown-item" href="javascript:void(0)" onclick="_modal(event, {uri: \'' + uri_edit + '\', size: \'modal-lg\'})"><i class="fas fa-edit me-2"></i> Ubah</a>' +
                   '<div class="dropdown-divider"></div>' +
                   '<a class="dropdown-item text-danger" href="javascript:void(0)" onclick=_delete("' + uri_delete + '")><i class="fas fa-trash me-2"></i> Hapus</a>' +
                   '</div></div>';
          }
        },
        // KEMBALIKAN KE NAMA LAMA SESUAI DATABASE
        { "data": "tanggal_masuk", "className": "text-center" },
        { "data": "no_transaksi" },
        { "data": "keterangan" }
      ],
    });
  });
</script>