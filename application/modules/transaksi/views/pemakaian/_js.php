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
        [2, 'desc'] 
      ],
      "ajax": {
        "url": "<?= $this->uri . '/ajax_datatables?n=' . _get('n') ?>",
        "type": "POST",
        "data": function (d) {
            d.<?= $this->security->get_csrf_token_name() ?> = '<?= $this->security->get_csrf_hash() ?>';
        }
      },
      "deferRender": true,
      "pageLength": 25,
      "columns": [{
          "data": "<?= $this->pk_id ?>",
          "sortable": false,
          "className": "text-center",
          "render": function(data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          "data": "<?= $this->pk_id ?>",
          "className": "text-center",
          "sortable": false,
          "render": function(data, type, row, meta) {
            var uri_detail = '<?= $this->uri . '/form_modal/' ?>' + data;
            var uri_delete = '<?= $this->uri . '/delete/' ?>' + data;

            // Tombol Detail
            var btnDetail = '<a class="dropdown-item" href="javascript:void(0)" onclick="_modal(event, {uri: \'' + uri_detail + '\', size: \'modal-lg\', position: \'normal\'})">' +
                            '   <i class="fas fa-eye me-2"></i> Detail' +
                            '</a>';

            // Tombol Hapus (Soft Delete & Return Stock)
            var btnDelete = '';
            if (row.deleted_st == 0) {
               btnDelete = '<a class="dropdown-item text-danger" href="javascript:void(0)" onclick="_delete(\'' + uri_delete + '\')">' +
                           '   <i class="fas fa-trash me-2"></i> Hapus' +
                           '</a>';
            }

            return '' +
              '<div class="dropdown">' +
              '  <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">' +
              '    Aksi' +
              '  </button>' +
              '  <div class="dropdown-menu dropdown-menu-end">' +
                   btnDetail +
                   btnDelete +
              '  </div>' +
              '</div>';
          }
        },
        {
          "data": "transaksi_tgl",
          "className": "text-center",
          "render": function(data) {
            if (!data) return '-';
            return data.split('-').reverse().join('-');
          }
        },
        {
          "data": "transaksi_no",
          "className": "fw-bold",
          "render": function(data, type, row) {
            if (row.deleted_st == 1) return '<span class="text-decoration-line-through text-muted">' + data + '</span>';
            return data;
          }
        },
        {
          "data": "pegawai_nm",
          "render": function(data) {
            return data ? data : '<span class="text-muted">-</span>';
          }
        },
        {
          "data": "kembali_rencana_tgl",
          "className": "text-center",
          "render": function(data) {
            if (!data) return '-';
            return data.split('-').reverse().join('-');
          }
        },
        {
          "data": "pemakaian_sts",
          "className": "text-center",
          "render": function(data) {
            var color = 'secondary';
            if (data == 'OPEN') color = 'warning';
            if (data == 'CLOSED' || data == 'SELESAI') color = 'success';
            if (data == 'DIBATALKAN') color = 'danger';
            
            return '<span class="badge bg-' + color + '-lt">' + data + '</span>';
          }
        }
      ],
    });
  });
</script>