<script type="text/javascript">
  var tabel = null;
  $(document).ready(function() {
    tabel = $('#datatable-main').DataTable({
      "language": { url: '<?= base_url() ?>dist/libs/DataTables/id.json' },
      "autoWidth": false,
      "processing": true,
      "responsive": true,
      "serverSide": true,
      "ordering": true,
      "order": [ [2, 'desc'] ], // Urut berdasarkan Tgl Pakai
      "ajax": {
        "url": "<?= $this->uri . '/ajax_datatables?n=' . _get('n') ?>", 
        "type": "POST"
      },
      "deferRender": true,
      "aLengthMenu": _datatableLengthMenu,
      "pageLength": 10, // Default 25 agar tidak terlalu panjang
      "columns": [
        // 0. NO
        {
          "data": "<?= $this->pk_id ?>",
          "sortable": false,
          "className": "text-center",
          "render": function(data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        // 1. AKSI
        {
          "data": "<?= $this->pk_id ?>",
          "className": "text-center",
          "sortable": false,
          "render": function(data, type, row, meta) {
            var uri_delete = '<?= $this->uri . '/delete/' ?>' + data;
            
            // Hanya tampilkan hapus jika status OPEN
            if (row.pemakaian_sts == 'OPEN') {
              return `
                <div class="dropdown">
                  <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    Aksi
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="_delete('${uri_delete}')">
                      <i class="fas fa-trash me-2"></i> Hapus
                    </a>
                  </div>
                </div>`;
            }
            return '<span class="text-muted medium"><i class="fas fa-lock"></i> Locked</span>';
          }
        },
        // 2. TGL PAKAI
        { "data": "transaksi_tgl", "className": "text-center" },
        // 3. NO TRANSAKSI
        { "data": "transaksi_no", "className": "fw-bold" },
        // 4. PENGGUNA
        { "data": "pegawai_nm" },
        // 5. DEADLINE
        { "data": "kembali_rencana_tgl", "className": "text-center" },
        // 6. STATUS
        {
          "data": "pemakaian_sts",
          "className": "text-center",
          "render": function(data, type, row, meta) {
            var color = (data == 'OPEN') ? 'warning' : 'success';
            return `<span class="badge bg-${color}-lt">${data}</span>`;
          }
        },
      ],
    });
  });
</script>