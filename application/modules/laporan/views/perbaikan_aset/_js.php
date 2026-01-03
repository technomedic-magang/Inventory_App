<script type="text/javascript">
  var tabel = null;
  
  $(document).ready(function() {
    tabel = $('#datatable-main').DataTable({
      "language": { url: '<?= base_url() ?>dist/libs/DataTables/id.json' },
      "autoWidth": false,
      "processing": true,
      "serverSide": true,
      "ordering": true,
      "order": [ [6, 'desc'] ], 
      "ajax": {
        "url": "<?= site_url($this->uri_mod . '/ajax_datatables?n=' . _get('n')) ?>",
        "type": "POST",
        "data": function (d) {
            d.filter_kategori = $('#main_filter_kategori').val(); 
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
        // 1. Aksi (REVISI: LOGIKA TOMBOL)
        {
          "data": "<?= $this->pk_id ?>", 
          "sortable": false,
          "className": "text-center", // Center agar rapi
          "width": "5%",
          "render": function(data, type, row, meta) {
            var uri_edit = '<?= site_url($this->uri_mod . '/form_modal/') ?>' + data;
            var uri_delete = '<?= site_url($this->uri_mod . '/delete/') ?>' + data;
            
            // LOGIKA: Jika Status 0 (Baru) -> Tampilkan Dropdown Edit/Hapus
            if (row.status_tiket == '0') {
                return '' +
                  '<div class="dropdown">' +
                  '  <button class="btn btn-outline-primary btn-sm dropdown-toggle align-text-top" data-bs-toggle="dropdown">Aksi</button>' +
                  '  <div class="dropdown-menu dropdown-menu-end">' +
                  '    <a class="dropdown-item" href="javascript:void(0)" onclick="_modal(event, {uri: \'' + uri_edit + '\', size: \'modal-lg\'})"><i class="fas fa-edit me-2"></i> Edit</a>' +
                  '    <a class="dropdown-item text-danger" href="javascript:void(0)" onclick=_delete("' + uri_delete + '")><i class="fas fa-trash me-2"></i> Hapus</a>' +
                  '  </div>' +
                  '</div>';
            } else {
                // LOGIKA: Jika Status != 0 -> Tampilkan Tombol "Lihat" saja (Terkunci)
                return '<button class="btn btn-sm btn-icon btn-secondary" title="Sudah Diproses (Terkunci)" onclick="_modal(event, {uri: \'' + uri_edit + '\', size: \'modal-lg\'})"><i class="fas fa-eye"></i></button>';
            }
          }
        },
        // 2. Kode Aset
        {
          "data": "asset_kd",
          "className": "text-start fw-bold",
          "render": function(d) { return d ? d : '-'; }
        },
        // 3. Tiket Perbaikan
        {
          "data": "tiket_perbaikan",
          "className": "text-start",
          "render": function(data) { 
              return data ? '<span class="badge bg-blue-lt">' + data + '</span>' : '-'; 
          }
        },
        // 4. Nama Aset
        {
          "data": "asset_nm",
          "render": function(data, type, row) {
              var nama = data || '-';
              var merk = row.merk ? ' <span class="text-muted small">(' + row.merk + ')</span>' : '';
              var html = '<div class="fw-bold">' + nama + merk + '</div>';
              if(row.spesifikasi) html += '<div class="small text-muted text-truncate" style="max-width:200px;">' + row.spesifikasi + '</div>';
              return html;
          }
        },
        // 5. Keluhan / Masalah
        { 
            "data": "keluhan_deskripsi",
            "render": function(data, type, row) {
                var html = '<div>' + (data ? data : '-') + '</div>';
                if(row.keluhan_foto) {
                    var urlFoto = '<?= base_url("uploads/service/") ?>' + row.keluhan_foto;
                    html += '<div class="mt-1"><a href="'+urlFoto+'" target="_blank" class="text-primary small text-decoration-none"><i class="fas fa-image me-1"></i> Foto Bukti</a></div>';
                }
                return html;
            }
        },
        // 6. Tgl Lapor
        { 
            "data": "created_at", 
            "className": "text-center",
            "render": function(d) { 
                return d ? d.split(' ')[0].split('-').reverse().join('-') : '-'; 
            } 
        },
        // 7. Rencana Perbaikan
        { 
            "data": "tgl_rencana", 
            "className": "text-center",
            "render": function(d) { return d ? d.split('-').reverse().join('-') : '<span class="text-muted">-</span>'; } 
        },
        // 8. Realisasi Selesai
        { 
            "data": "tgl_service", 
            "className": "text-center",
            "render": function(d) { return d ? d.split('-').reverse().join('-') : '<span class="text-muted">-</span>'; } 
        },
        // 9. Pelapor
        { 
            "data": "pelapor_nm", 
            "className": "text-start",
            "render": function(d) { 
                return d ? '<i class="fas fa-user me-1 text-muted"></i> ' + d : '<span class="text-muted">-</span>'; 
            } 
        },
        // 10. Status
        { 
            "data": "status_tiket", 
            "className": "text-center",
            "size": "100",
            "render": function(d) {
                if(d == '0') return '<span class="badge bg-red text-white">Baru</span>';
                if(d == '1') return '<span class="badge bg-yellow text-white">Proses</span>';
                if(d == '2') return '<span class="badge bg-green text-white">Selesai</span>';
                if(d == '9') return '<span class="badge bg-secondary text-white">Ditolak</span>';
                return '<span class="badge bg-secondary">Draft</span>';
            }
        },
      ]
    });

    $('#main_filter_kategori').change(function() {
        tabel.ajax.reload();
    });
  });
</script>