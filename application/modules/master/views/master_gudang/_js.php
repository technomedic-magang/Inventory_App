<script type="text/javascript">
    var tabel = null;
    $(document).ready(function() {
        tabel = $('#datatable-main').DataTable({
            "language": { url: '<?= base_url() ?>dist/libs/DataTables/id.json' },
            "processing": true,
            "serverSide": true,
            "ordering": true,
            "ajax": {
                "url": "<?= $this->uri . '/ajax_datatables?n=' . _get('n') ?>",
                "type": "POST"
            },
            "deferRender": true,
            "columns": [
                {
                    "data": "<?= $this->pk_id ?>",
                    "sortable": false,
                    "render": function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    "data": "<?= $this->pk_id ?>",
                    "sortable": false,
                    "className": "text-center",
                    "render": function(data, type, row, meta) {
                        var uri_edit = '<?= $this->uri . '/form_modal/' ?>' + data;
                        var uri_delete = '<?= $this->uri . '/delete/' ?>' + data;
                        return '<div class="dropdown">' +
                               '<button class="btn btn-outline-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">Aksi</button>' +
                               '<div class="dropdown-menu">' +
                               '<a class="dropdown-item" href="javascript:void(0)" onclick="_modal(event, {uri: \'' + uri_edit + '\', size: \'modal-lg\'})"><i class="fas fa-edit me-2"></i> Ubah</a>' +
                               '<div class="dropdown-divider"></div>' +
                               '<a class="dropdown-item text-danger" href="javascript:void(0)" onclick=_delete("' + uri_delete + '")><i class="fas fa-trash me-2"></i> Hapus</a>' +
                               '</div></div>';
                    }
                },
                // --- UPDATE NAMA KOLOM DI SINI ---
                { "data": "gudang_kd" },
                { "data": "gudang_nm" },
                { "data": "gudang_alm" },
                { "data": "pic_nm" },
                {
                    "data": "active_st",
                    "className": "text-center",
                    "render": function(data) {
                        return (data == 1) ? '<i class="fas fa-check-circle text-success"></i>' : '<i class="fas fa-times-circle text-danger"></i>';
                    }
                }
            ],
        });
    });
</script>