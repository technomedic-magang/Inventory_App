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
        // [PERBAIKAN 1]: Gunakan site_url() agar alamat tidak dobel
        "url": "<?= site_url($this->uri . '/ajax_datatables?n=' . _get('n')) ?>", 
        "type": "POST",
        "data": function (d) {
            // Tambahkan CSRF Token jika framework menggunakannya
            d.<?php echo $this->security->get_csrf_token_name(); ?> = '<?php echo $this->security->get_csrf_hash(); ?>';
        }
      },
      "deferRender": true,
      "aLengthMenu": [[10, 25, 50], [10, 25, 50]], // Definisi Length Menu standar
      "pageLength": 10,
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
            // [PERBAIKAN 2]: Gunakan site_url() pada tombol hapus juga
            var uri_edit = '<?= site_url($this->uri . '/form_modal/') ?>' + data;
            var uri_delete = '<?= site_url($this->uri . '/delete/') ?>' + data;
            
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
        // 2. TGL PAKAI (Format dd-mm-yyyy)
        { 
            "data": "transaksi_tgl", 
            "className": "text-center",
            "render": function(data) {
                return data ? data.split('-').reverse().join('-') : '';
            }
        },
        // 3. NO TRANSAKSI
        { "data": "transaksi_no", "className": "fw-bold" },
        // 4. PENGGUNA
        { "data": "pegawai_nm" },
        // 5. DEADLINE (Format dd-mm-yyyy)
        { 
            "data": "kembali_rencana_tgl", 
            "className": "text-center",
            "render": function(data) {
                return data ? data.split('-').reverse().join('-') : '';
            }
        },
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