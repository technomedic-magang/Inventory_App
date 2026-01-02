<script type="text/javascript">
  var tabel = null;
  $(document).ready(function() {
    tabel = $('#datatable-main').DataTable({
      "language": { url: '<?= base_url() ?>dist/libs/DataTables/id.json' },
      "autoWidth": false,
      "processing": true,
      "serverSide": true,
      "ordering": true,
      "order": [ [5, 'desc'] ], // Sort by Tanggal (Index 5)
      "ajax": {
        "url": "<?= site_url($this->uri . '/ajax_datatables?n=' . _get('n')) ?>",
        "type": "POST",
        "data": function (d) {
            d.<?php echo $this->security->get_csrf_token_name(); ?> = '<?php echo $this->security->get_csrf_hash(); ?>';
            
            // [MODIFIKASI] Kirim data filter ke server
            d.filter_kategori = $('#main_filter_kategori').val(); 
        }
      },
      "columns": [
        { "data": "<?= $this->pk_id ?>", "sortable": false, "render": function(data, type, row, meta) { return meta.row + meta.settings._iDisplayStart + 1; } },
        {
          "data": "<?= $this->pk_id ?>", "sortable": false,
          "render": function(data, type, row, meta) {
            var uri_edit = '<?= site_url($this->uri . '/form_modal/') ?>' + data;
            var uri_delete = '<?= site_url($this->uri . '/delete/') ?>' + data;
            return '<div class="dropdown"><button class="btn btn-outline-primary btn-sm dropdown-toggle align-text-top" data-bs-toggle="dropdown">Aksi</button><div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item" href="javascript:void(0)" onclick="_modal(event, {uri: \'' + uri_edit + '\', size: \'modal-lg\'})"><i class="fas fa-edit me-2"></i> Edit</a><a class="dropdown-item text-danger" href="javascript:void(0)" onclick=_delete("' + uri_delete + '")><i class="fas fa-trash me-2"></i> Hapus</a></div></div>';
          }
        },
        { "data": "asset_kd", "render": function(d) { return '<div class="fw-bold">' + (d||'-') + '</div>'; } },
        
        // [MODIFIKASI] RENDER NAMA + MERK + SPEK
        {
          "data": "asset_nm",
          "render": function(data, type, row) {
              var nama = data || '-';
              var merk = row.merk ? ' - ' + row.merk : '';
              
              // Baris 1: Nama Aset - Merk (Tebal)
              var html = '<div class="fw-bold">' + nama + merk + '</div>';
              
              // Baris 2: Spesifikasi (Kecil)
              if(row.spesifikasi) {
                  html += '<div class="small text-muted">' + row.spesifikasi + '</div>';
              }
              return html;
          }
        },
        
        { "data": "kategori_nm", "render": function(d) { return d||'-'; } },
        { "data": "tgl_service", "render": function(d) { return d ? d.split('-').reverse().join('-') : '-'; } },
        { "data": "keterangan_txt", "render": function(d) { return d||'-'; } },
        { "data": "bengkel_nm", "render": function(d) { return d||'-'; } },
        { "data": "biaya", "className": "text-center", "render": function(d) { return 'Rp ' + parseInt(d || 0).toLocaleString('id-ID'); } }
      ]
    });

    // [MODIFIKASI] Event Listener Filter
    $('#main_filter_kategori').change(function() {
        tabel.ajax.reload();
    });
  });
</script>