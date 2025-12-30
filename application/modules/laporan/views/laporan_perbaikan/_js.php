<script type="text/javascript">
  var tabel = null;
  $(document).ready(function() {
    tabel = $('#datatable-main').DataTable({
      "language": { url: '<?= base_url() ?>dist/libs/DataTables/id.json' },
      "autoWidth": false,
      "processing": true,
      "serverSide": true, // Wajib TRUE untuk helper DB::datatables_query
      "ordering": true,
      "order": [ [2, 'desc'] ], 
      "ajax": {
        // [PENTING] Tambahkan parameter n sesuai referensi
        "url": "<?= site_url($this->uri . '/ajax_datatables?n=' . _get('n')) ?>",
        "type": "POST",
        // Sertakan CSRF Token (untuk jaga-jaga jika security on)
        "data": function (d) {
            d.<?php echo $this->security->get_csrf_token_name(); ?> = '<?php echo $this->security->get_csrf_hash(); ?>';
        },
        "error": function (xhr, error, code) {
            console.log("Error Detail:", xhr.responseText);
        }
      },
      "columns": [
        {
          "data": "<?= $this->pk_id ?>",
          "sortable": false,
          "render": function(data, type, row, meta) { return meta.row + meta.settings._iDisplayStart + 1; }
        },
        {
          "data": "<?= $this->pk_id ?>",
          "sortable": false,
          "render": function(data, type, row, meta) {
            // Perbaikan URL Aksi agar sesuai URI modul
            var uri_edit = '<?= site_url($this->uri . '/form_modal/') ?>' + data;
            var uri_delete = '<?= site_url($this->uri . '/delete/') ?>' + data;
            return '' +
              '<div class="dropdown">' +
              '  <button class="btn btn-outline-primary btn-sm dropdown-toggle align-text-top" data-bs-toggle="dropdown">Aksi</button>' +
              '  <div class="dropdown-menu dropdown-menu-end">' +
              '    <a class="dropdown-item" href="javascript:void(0)" onclick="_modal(event, {uri: \'' + uri_edit + '\', size: \'modal-lg\'})"><i class="fas fa-edit me-2"></i> Edit</a>' +
              '    <a class="dropdown-item text-danger" href="javascript:void(0)" onclick=_delete("' + uri_delete + '")><i class="fas fa-trash me-2"></i> Hapus</a>' +
              '  </div>' +
              '</div>';
          }
        },
        {
          "data": "tgl_service",
          "render": function(data) { return data ? data.split('-').reverse().join('-') : '-'; }
        },
        {
          "data": "asset_nm",
          "render": function(data, type, row) {
              return '<div class="fw-bold">' + (data ? data : '-') + '</div><div class="small text-muted">' + (row.asset_kd ? row.asset_kd : '') + '</div>';
          }
        },
        {
          "data": "kilometer_saat_ini",
          "className": "text-left",
          "render": function(data) { return data ? parseInt(data).toLocaleString('id-ID') + ' KM' : '0 KM'; }
        },
        {
          "data": "biaya",
          "className": "text-left",
          "render": function(data) { return data ? 'Rp ' + parseInt(data).toLocaleString('id-ID') : 'Rp 0'; }
        },
        {
          "data": "bengkel_nm",
          "render": function(data, type, row) {
              return '<div>' + (data ? data : '-') + '</div><div class="small text-muted text-truncate" style="max-width:150px;">' + (row.keterangan_txt ? row.keterangan_txt : '') + '</div>';
          }
        },
        {
          "data": "tgl_berikutnya",
          "render": function(data) {
              if(!data) return '-';
              return '<span class="badge bg-warning-lt">' + data.split('-').reverse().join('-') + '</span>';
          }
        }
      ],
    });
  });
</script>