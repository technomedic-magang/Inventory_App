<script type="text/javascript">
  var tabel = null;
  
  $(document).ready(function() {
    tabel = $('#datatable-admin').DataTable({
      "language": { url: '<?= base_url() ?>dist/libs/DataTables/id.json' },
      "autoWidth": false,
      "processing": true,
      "serverSide": true,
      "ordering": true,
      "order": [ [6, 'desc'] ],
      "ajax": {
        "url": "<?= site_url('laporan/verifikasi_perbaikan/ajax_datatables?n=' . _get('n')) ?>",
        "type": "POST",
        "data": function (d) {
            d.filter_status = $('#filter_status').val();
        }
      },
      "columns": [
        // 0. No
        { 
            "data": null,
            "sortable": false,
            "className": "text-center",
            "render": function(data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            }
        },
        // 1. Aksi (UBAH STATUS)
        {
          "data": "<?= $this->pk_id ?>", 
          "sortable": false,
          "className": "text-center",
          "width": "10%",
          "render": function(data, type, row, meta) {
            var uri_proses = '<?= site_url("laporan/verifikasi_perbaikan/form_modal/") ?>' + data;
            
            var btnClass = 'btn-primary';
            var btnIcon = 'fa-cog';
            var btnText = 'Proses';

            if(row.status_tiket == '0') {
                btnClass = 'btn-danger'; 
                btnIcon = 'fa-gavel';
                btnText = 'Verifikasi';
            } else if (row.status_tiket == '1') {
                btnClass = 'btn-warning text-white';
                btnIcon = 'fa-check-double';
                btnText = 'Selesaikan';
            } else {
                btnClass = 'btn-secondary';
                btnIcon = 'fa-eye';
                btnText = 'Detail';
            }

            return `<button class="btn ${btnClass} " onclick="_modal(event, {uri: '${uri_proses}', size: 'modal-lg'})">
                      <i class="fas ${btnIcon} me-1"></i> ${btnText}
                    </button>`;
          }
        },
        // 2. No Tiket
        {
          "data": "tiket_perbaikan",
          "className": "text-left fw-bold",
          "width": "18%",
          "render": function(d) { return d ? d : '-'; }
        },
        // 3. Status (Badge)
        { 
            "data": "status_tiket", 
            "className": "text-left",
            "render": function(d) {
                if(d == '0') return '<span class="badge bg-red-lt">Menunggu</span>';
                if(d == '1') return '<span class="badge bg-yellow-lt">Sedang Proses</span>';
                if(d == '2') return '<span class="badge bg-green text-white">Selesai</span>';
                if(d == '9') return '<span class="badge bg-secondary text-white">Ditolak</span>';
                return '-';
            }
        },
        // 4. Nama Aset
        {
          "data": "asset_nm",
          "render": function(data, type, row) {
              var kd = row.asset_kd || '-';
              return '<div class="fw-bold">' + (data || '-') + '</div><div class="small text-muted">' + kd + '</div>';
          }
        },
        // 5. Pelapor
        { 
            "data": "pelapor_nm", 
            "className": "text-start",
            "render": function(d) { 
                return d ? '<i class="fas fa-user me-1 text-muted"></i> ' + d : '<span class="text-muted">-</span>'; 
            } 
        },
        // 6. Tgl Lapor
        { 
            "data": "created_at", 
            "className": "text-center",
            "render": function(d) { return d ? d.split(' ')[0].split('-').reverse().join('-') : '-'; } 
        },
        // 7. Keluhan (DIPERBAIKI: Handle Null)
        { 
            "data": "keluhan_deskripsi",
            "className": "text-end",
            "render": function(d) { 
                // [FIX] Cek jika d null atau undefined
                if (!d) return '-'; 
                // Baru cek length jika d aman
                return d.length > 50 ? d.substr(0, 50) + '...' : d; 
            }
        },
      ]
    });

    $('#filter_status').change(function() { tabel.ajax.reload(); });

  });
</script>