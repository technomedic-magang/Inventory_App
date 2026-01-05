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
        "url": "<?= site_url($this->uri . '/ajax_datatables?n=' . _get('n')) ?>", 
        "type": "POST",
        "data": function (d) {
            d.<?php echo $this->security->get_csrf_token_name(); ?> = '<?php echo $this->security->get_csrf_hash(); ?>';
        }
      },
      "deferRender": true,
      "aLengthMenu": [[10, 25, 50], [10, 25, 50]], 
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
            var uri_delete = '<?= site_url($this->uri . '/delete/') ?>' + data;
            
            // [LOGIKA TOMBOL AKSI]
            // Jika sudah dibatalkan atau dihapus, kunci tombol
            if (row.deleted_st == 1 || row.pemakaian_sts == 'DIBATALKAN') {
                return '<span class="badge bg-red-lt"><i class="fas fa-ban me-1"></i> Dibatalkan</span>';
            }

            // Jika status OPEN, boleh dihapus
            if (row.pemakaian_sts == 'OPEN') {
              return `
                <div class="dropdown">
                  <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    Aksi
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="_delete('${uri_delete}')">
                      <i class="fas fa-trash me-2"></i> Batalkan / Hapus
                    </a>
                  </div>
                </div>`;
            }
            
            // Default Locked (Misal sudah closed/kembali)
            return '<span class="text-muted medium"><i class="fas fa-lock"></i> Selesai</span>';
          }
        },
        // 2. TGL PAKAI
        { 
            "data": "transaksi_tgl", 
            "className": "text-center",
            "render": function(data) {
                return data ? data.split('-').reverse().join('-') : '';
            }
        },
        // 3. NO TRANSAKSI
        { 
            "data": "transaksi_no", 
            "className": "fw-bold",
            "render": function(data, type, row) {
                // Beri coret jika dibatalkan
                if(row.deleted_st == 1) return '<span class="text-decoration-line-through text-muted">' + data + '</span>';
                return data;
            }
        },
        // 4. PENGGUNA
        { "data": "pegawai_nm" },
        // 5. DEADLINE
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
            // [LOGIKA WARNA BADGE]
            var color = 'secondary';
            if(data == 'OPEN') color = 'warning';
            if(data == 'CLOSED' || data == 'SELESAI') color = 'success';
            if(data == 'DIBATALKAN') color = 'danger'; // Merah

            return `<span class="badge bg-${color}-lt">${data}</span>`;
          }
        },
      ],
    });
  });
</script>