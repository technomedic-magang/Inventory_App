<script>
$(document).ready(function() {
    var table = $('#datatables_keluhan').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?= site_url($uri_mod . '/ajax_datatables') ?>",
            "type": "POST"
        },
        "columns": [
            { 
                "data": null, 
                "render": function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            { 
                "data": "no_tiket",
                "render": function(data, type, row) {
                    // Jika no_tiket null, tampilkan '-'
                    var tiket = data ? data : '-';
                    return '<b>' + tiket + '</b><br><small>' + row.created_at + '</small>';
                }
            },
            { 
                "data": "asset_nm",
                "render": function(data, type, row) {
                    var kd = row.asset_kd ? row.asset_kd : '';
                    return data + '<br><small class="text-muted">' + kd + '</small>';
                }
            },
            { "data": "pelapor_nm" },
            { 
                "data": "deskripsi",
                "render": function(data, type, row) {
                    if(data && data.length > 50) return data.substr(0, 50) + '...';
                    return data;
                }
            },
            { 
                "data": "status_tiket",
                "render": function(data, type, row) {
                    if(data == 0) return '<span class="badge badge-danger">Baru</span>';
                    if(data == 1) return '<span class="badge badge-warning">Diproses</span>';
                    if(data == 2) return '<span class="badge badge-success">Selesai</span>';
                    return '-';
                }
            },
            { 
                "data": "keluhan_id",
                "render": function(data, type, row) {
                    // Tombol untuk membuka Modal
                    return '<button class="btn btn-sm btn-info btn-modal" data-url="<?= site_url($uri_mod.'/form_modal/') ?>' + data + '"><i class="fas fa-eye"></i> Detail</button>';
                }
            }
        ]
    });

    // Event Handler untuk membuka Modal
    $(document).on('click', '.btn-modal', function(e) {
        e.preventDefault();
        var url = $(this).data('url');
        // Asumsi div #modal_form ada di layout utama (main template)
        $('#modal_form').load(url, function() {
            $(this).modal('show');
        });
    });
});
</script>