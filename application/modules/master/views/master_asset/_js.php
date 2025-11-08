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
        [2, 'asc'] // Urutkan berdasarkan Kode Barang (Kolom ke-3)
      ],
      "ajax": {
          // HAPUS site_url(), cukup pakai $this->uri langsung
          "url": "<?= $this->uri . '/ajax_datatables?n=' . _get('n') ?>",
          "type": "POST"
      },
      "deferRender": true,
      "aLengthMenu": _datatableLengthMenu, // Pakai variabel global template jika ada
      "pageLength": 500,
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
          "className": "text-left",
          "sortable": false,
          "render": function(data, type, row, meta) {
            var uri_edit = '<?= $this->uri . '/form_modal/' ?>' + data;
            var uri_delete = '<?= $this->uri . '/delete/' ?>' + data;
            return '' +
              '<div class="btn-list btn-sm flex-nowrap">' +
              '  <div class="dropdown"> ' +
              '     <button class="btn btn-outline-primary btn-sm dropdown-toggle align-text-top" data-bs-toggle="dropdown">' +
              '          Aksi' +
              '     </button>' +
              '     <div class="dropdown-menu">' +
              '      <a class="dropdown-item p-1" href="javascript:void(0)" onclick="_modal(event, {uri: \'' + uri_edit + '\', size: \'modal-lg\', position: \'normal\'})">' +
              '          <?= _icon('edit') ?> Ubah' +
              '      </a>' +
              '      <a class="dropdown-item p-1 text-danger" href="javascript:void(0)" onclick=_delete("' + uri_delete + '")>' +
              '          <?= _icon('trash') ?> Hapus' +
              '      </a>' +
              '   </div>' +
              ' </div>' +
              '</div>';
          }
        },
        // --- KOLOM DATA MASTER ASSET ---
        { "data": "asset_kode", "className": "text-left" },
        { "data": "asset_nama", "className": "text-left" },
        { "data": "kategori_nama", "className": "text-left" }, // Dari JOIN
        { "data": "satuan_nama", "className": "text-center" },  // Dari JOIN
        { "data": "stok_minimal", "className": "text-center" },
        // --- KOLOM STATUS AKTIF (Sesuai Referensi) ---
        {
          "data": "active_st",
          "className": "text-center",
          "render": function(data, type, row, meta) {
            // Fungsi ifNull() mungkin bawaan template, kalau error hapus saja
            // var data = ifNull(data); 
            var result = data;
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