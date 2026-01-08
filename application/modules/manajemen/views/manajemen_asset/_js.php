<script type="text/javascript">
  var tabel = null;
  $(document).ready(function() {
    tabel = $('#datatable-main').DataTable({
      "language": {
<<<<<<< HEAD
        url: '<?= base_url() ?>dist/libs/DataTables/id.json',
=======
        url: '<?= base_url() ?>dist/libs/DataTables/id.json'
>>>>>>> repoB/main
      },
      "autoWidth": false,
      "processing": true,
      "responsive": true,
      "serverSide": true,
      "ordering": true,
      "order": [
<<<<<<< HEAD
        [2, 'asc']
      ], 
      "ajax": {
        "url": "<?= $this->uri . '/ajax_datatables?n=' . _get('n') ?>",
        "type": "POST",
        // [UPDATE] Kirim data filter ke server
        "data": function(data) {
            data.filter_kategori = $('#filter_kategori').val();
        }
=======
        [2, 'asc'],
        [3, 'asc'],
      ],
      "ajax": {
        "url": "<?= site_url('manajemen/manajemen_asset/ajax_datatables?n=' . _get('n')) ?>",
        "type": "POST",
        "data": function(data) { data.filter_kategori = $('#filter_kategori').val(); }
>>>>>>> repoB/main
      },
      "deferRender": true,
      "aLengthMenu": _datatableLengthMenu,
      "pageLength": 500,
<<<<<<< HEAD
      "columns": [{
          "data": "<?= $this->pk_id ?>",
          "sortable": false,
          "render": function(data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
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
              '    <button class="btn btn-outline-primary btn-sm dropdown-toggle align-text-top" data-bs-toggle="dropdown">' +
              '        Aksi' +
              '    </button>' +
              '    <div class="dropdown-menu">' +
              '      <a class="dropdown-item p-1" href="javascript:void(0)" onclick="_modal(event, {uri: \'' + uri_edit + '\', size: \'modal-lg\', position: \'normal\'})">' +
              '          <?= _icon('edit') ?> Ubah' +
              '      </a>' +
              '      <a class="dropdown-item p-1" href="javascript:void(0)" onclick=_delete("' + uri_delete + '")>' +
              '          <?= _icon('trash') ?> Hapus' +
              '      </a>' +
              '    </div>' +
              '  </div>' +
              '</div>';
          }
        },
        {
          "data": "asset_kd",
          "className": "text-left",
        },
        {
          "data": "asset_nm",
          "className": "text-left",
        },
        {
          "data": "kategori_nm",
          "className": "text-left",
        },
        {
          "data": "satuan_nm",
          "className": "text-left",
        },
        {
          "data": "stok_min_qty",
          "className": "text-left",
          "render": $.fn.dataTable.render.number('.', ',', 0)
        },
        {
          "data": "active_st",
          "className": "text-center",
          "render": function(data, type, row, meta) {
            var data = ifNull(data); 
            var result = data;
            if (row['active_st'] == 1) {
              result = '<i class="fas fa-check-circle text-success "></i>';
            } else {
              result = '<i class="fas fa-times-circle text-danger"></i>';
            }
            return result;
          }
        },
      ],
    });
    
    // [UPDATE] Event listener jika filter berubah
    $('#filter_kategori').change(function() {
        tabel.ajax.reload();
    });
=======
      "columns": [
        // 1. NO
        { 
          "data": "<?= $this->pk_id ?>", "sortable": false, "className": "text-left",
          "render": function(data, type, row, meta) { return meta.row + meta.settings._iDisplayStart + 1; } 
        },
        
        // 2. AKSI (GAYA ASLI / ORIGINAL STYLE)
        { 
          "data": "<?= $this->pk_id ?>", "className": "text-left", "sortable": false, "width": "10%",
          "render": function(data, type, row, meta) {
            var uri_edit = '<?= site_url("manajemen/manajemen_asset/form_modal/") ?>' + data;
            var uri_delete = '<?= site_url("manajemen/manajemen_asset/delete/") ?>' + data;
            return `<div class="btn-list btn-sm flex-nowrap">
                      <div class="dropdown">
                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">Aksi</button>
                        <div class="dropdown-menu">
                          <a class="dropdown-item p-1" href="javascript:void(0)" onclick="_modal(event, {uri: '${uri_edit}', size: 'modal-lg'})"><i class="fas fa-edit me-1"></i> Ubah</a>
                          <a class="dropdown-item p-1 text-danger" href="javascript:void(0)" onclick="_delete('${uri_delete}')"><i class="fas fa-trash me-1"></i> Hapus</a>
                        </div>
                      </div>
                    </div>`;
          }
        },

        // 3. KODE ASSET
        { 
            "data": "asset_kd", "className": "text-start fw-bold" 
        },

        // 4. NAMA ASSET
        { 
            "data": "asset_nm", "className": "text-start",
            "render": function(data, type, row) {
                // Nama Aset + Satuan kecil
                return data + ` <small class="text-muted ms-1">(${row.satuan_nm || '-'})</small>`;
            }
        },

        // 5. KATEGORI
        { "data": "kategori_nm", "className": "text-start" },
        
        // 6. TGL BELI (FORMAT INDONESIA)
        { 
            "data": "beli_tgl", "className": "text-start",
            "render": function(data) {
                if(!data) return '-';
                var date = new Date(data);
                var day = ("0" + date.getDate()).slice(-2);
                var month = ("0" + (date.getMonth() + 1)).slice(-2);
                var year = date.getFullYear();
                return day + '-' + month + '-' + year;
            }
        },
        
        // 7. KONDISI (BADGE WARNA)
        { 
            "data": "asset_kondisi", "className": "text-center",
            "render": function(data) {
                var color = 'success'; // Default Baik
                if(data === 'RUSAK RINGAN') color = 'warning';
                if(data === 'RUSAK BERAT' || data === 'HILANG') color = 'danger';
                return `<span class="badge bg-${color}-lt">${data}</span>`;
            }
        },

        // 8. HARGA BELI
        { 
          "data": "beli_nominal", "className": "text-end fw-bold",
          "render": function(data) { return 'Rp ' + parseFloat(data).toLocaleString('id-ID'); }
        }
      ],
    });
    
    $('#filter_kategori').change(function() { tabel.ajax.reload(); });
>>>>>>> repoB/main
  });
</script>