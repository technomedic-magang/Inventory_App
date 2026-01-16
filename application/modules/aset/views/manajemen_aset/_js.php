<script type="text/javascript">
  var tabel = null;

  $(document).ready(function() {
    // Inisialisasi DataTables
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
        [2, 'desc'] // Urut berdasarkan Tanggal (Kolom ke-3)
      ],
      "ajax": {
        "url": "<?= $this->uri . '/ajax_datatables?n=' . _get('n') ?>",
        "type": "POST",
        "data": function(data) {
          // Kirim parameter filter kategori ke server
          data.filter_kategori = $('#filter_kategori').val();
        }
      },
      "deferRender": true,
      "aLengthMenu": _datatableLengthMenu,
      "pageLength": 500,
      "columns": [{
          "data": "<?= $this->pk_id ?>",
          "sortable": false,
          "className": "text-left",
          "render": function(data, type, row, meta) {
            // Penomoran otomatis
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          "data": "<?= $this->pk_id ?>",
          "className": "text-left",
          "sortable": false,
          "width": "10%",
          "render": function(data, type, row, meta) {
            // Definisi URL
            var uri_edit = '<?= $this->uri . '/form_modal/' ?>' + data;
            var uri_delete = '<?= $this->uri . '/delete/' ?>' + data;

            // Render Tombol Aksi (Concatenation Style)
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
          "data": "asset_kd",
          "className": "text-start fw-bold"
        },
        {
          "data": "asset_nm",
          "className": "text-start",
          "render": function(data, type, row) {
            // Menampilkan Nama + Satuan
            var satuan = row.satuan_nm ? row.satuan_nm : '-';
            return data + ' <small class="text-muted ms-1">(' + satuan + ')</small>';
          }
        },
        {
          "data": "kategori_nm",
          "className": "text-start"
        },
        {
          "data": "beli_tgl",
          "className": "text-start",
          "render": function(data) {
            // Konversi Tanggal JS manual
            if (!data) return '-';
            var date = new Date(data);
            var day = ("0" + date.getDate()).slice(-2);
            var month = ("0" + (date.getMonth() + 1)).slice(-2);
            var year = date.getFullYear();
            return day + '-' + month + '-' + year;
          }
        },
        {
          "data": "asset_kondisi",
          "className": "text-center",
          "render": function(data) {
            // [LOGIC FIX] Penentuan Warna Badge
            var color = 'secondary'; // Default warna (abu-abu) jika tidak ada kondisi yang cocok

            if (data === 'BAIK') {
              color = 'success'; // Hijau
            } else if (data === 'PERBAIKAN') {
              color = 'warning'; // Kuning/Orange
            } else if (data === 'RUSAK' || data === 'HILANG') {
              color = 'danger'; // Merah
            }

            // Mengembalikan string HTML badge dengan class warna dinamis
            // Menggunakan suffix '-lt' (light) agar tampilan lebih modern/soft
            return '<span class="badge bg-' + color + '-lt">' + data + '</span>';
          }
        },
        {
          "data": "beli_nominal",
          "className": "text-end fw-bold",
          "render": function(data) {
            // Format Rupiah
            return 'Rp ' + parseFloat(data).toLocaleString('id-ID');
          }
        }
      ],
    });

    // Event Listener untuk Filter
    $('#filter_kategori').change(function() {
      tabel.ajax.reload();
    });
  });
</script>