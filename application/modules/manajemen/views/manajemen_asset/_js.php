<script type="text/javascript">
  var tabel = null;
  $(document).ready(function() {
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
        [2, 'asc'],
        [3, 'asc'],
      ],
      "ajax": {
        "url": "<?= site_url('manajemen/manajemen_asset/ajax_datatables?n=' . _get('n')) ?>",
        "type": "POST",
        "data": function(data) { data.filter_kategori = $('#filter_kategori').val(); }
      },
      "deferRender": true,
      "aLengthMenu": _datatableLengthMenu,
      "pageLength": 500,
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
  });
</script>