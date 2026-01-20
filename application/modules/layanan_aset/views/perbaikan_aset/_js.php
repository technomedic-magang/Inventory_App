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
        "url": "<?= $this->uri . '/ajax_datatables?n=' . _get('n') ?>",
        "type": "POST",
        "data": function (d) {
            d.filter_kategori = $('#main_filter_kategori').val(); 
            d.<?= $this->security->get_csrf_token_name() ?> = '<?= $this->security->get_csrf_hash() ?>';
        }
      },
      "pageLength": 25, 
      "columns": [
        { 
            "data": null,
            "sortable": false,
            "className": "text-center",
            "render": function(data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            }
        },
        // KOLOM AKSI DROPDOWN
        {
          "data": "<?= $this->pk_id ?>", 
          "sortable": false,
          "className": "text-center", 
          "render": function(data, type, row, meta) {
            var uri_modal = '<?= $this->uri . '/form_modal/' ?>' + data;
            var uri_delete = '<?= $this->uri . '/delete/' ?>' + data;
            
            // Logic: 0=Baru (Boleh Edit/Hapus), Selain itu View Only
            var menuItems = '';
            if (row.status_tiket == '0') {
                menuItems += `<a class="dropdown-item" href="javascript:void(0)" onclick="_modal(event, {uri: '${uri_modal}', size: 'modal-lg', title: 'Edit Tiket'})"><i class="fas fa-edit me-2"></i> Edit</a>`;
                menuItems += `<a class="dropdown-item text-danger" href="javascript:void(0)" onclick="_delete('${uri_delete}')"><i class="fas fa-trash me-2"></i> Hapus</a>`;
            } else {
                menuItems += `<a class="dropdown-item" href="javascript:void(0)" onclick="_modal(event, {uri: '${uri_modal}', size: 'modal-lg', title: 'Detail Tiket'})"><i class="fas fa-eye me-2"></i> Detail</a>`;
            }

            return `
                <div class="dropdown">
                  <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">Aksi</button>
                  <div class="dropdown-menu dropdown-menu-end">${menuItems}</div>
                </div>
            `;
          }
        },
        {
          "data": "asset_kd",
          "className": "text-start fw-bold",
          "render": function(d) { return d ? d : '-'; }
        },
        {
          "data": "tiket_perbaikan",
          "className": "text-start",
          "render": function(data) { 
              return data ? '<span class="badge bg-blue-lt">' + data + '</span>' : '-'; 
          }
        },
        {
          "data": "asset_nm",
          "render": function(data, type, row) {
              var nama = data || '-';
              var merk = row.merk ? ' <span class="text-muted small">(' + row.merk + ')</span>' : '';
              return '<div class="fw-bold">' + nama + merk + '</div>';
          }
        },
        { 
            "data": "keluhan_deskripsi",
            "render": function(data, type, row) {
                var html = '<div>' + (data ? data : '-') + '</div>';
                if(row.keluhan_foto) {
                    var urlFoto = 'http://localhost/Project_Magang_API/uploads/keluhan/' + row.keluhan_foto;
                    html += '<div class="mt-1"><a href="'+urlFoto+'" target="_blank" class="text-primary small text-decoration-none"><i class="fas fa-image me-1"></i> Foto Bukti</a></div>';
                }
                return html;
            }
        },
        { 
            "data": "created_at", 
            "className": "text-center",
            "render": function(d) { 
                return d ? d.split(' ')[0].split('-').reverse().join('-') : '-'; 
            } 
        },
        { 
            "data": "tgl_rencana", 
            "className": "text-center",
            "render": function(d) { return d ? d.split('-').reverse().join('-') : '<span class="text-muted">-</span>'; } 
        },
        { 
            "data": "tgl_service", 
            "className": "text-center",
            "render": function(d) { return d ? d.split('-').reverse().join('-') : '<span class="text-muted">-</span>'; } 
        },
        { 
            "data": "pelapor_nm", 
            "className": "text-start",
            "render": function(d) { 
                return d ? '<i class="fas fa-user me-1 text-muted"></i> ' + d : '<span class="text-muted">-</span>'; 
            } 
        },
        { 
            "data": "status_tiket", 
            "className": "text-center",
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