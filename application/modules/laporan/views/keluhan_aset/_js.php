<script type="text/javascript">
  $(document).ready(function() {
    $('#datatable-keluhan').DataTable({
      "language": { url: '<?= base_url() ?>dist/libs/DataTables/id.json' },
      "autoWidth": false,
      "ordering": true,
      "pageLength": 25,
      "order": [], 
      "columnDefs": [
        // Matikan sorting di kolom Foto (index 2) dan Aksi (index 7)
        { "orderable": false, "targets": [2, 7] }, 
        
        // Rata tengah untuk kolom No, Foto, Status, dan Aksi
        { "className": "dt-center", "targets": [0, 2, 5, 7] } 
      ]
    });
  });
</script>