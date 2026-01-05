<script type="text/javascript">
  var tabel = null;
  
  $(document).ready(function() {
    tabel = $('#datatable-main').DataTable({
      "language": { url: '<?= base_url() ?>dist/libs/DataTables/id.json' },
      "autoWidth": false,
      "processing": true,
      "serverSide": false, 
      "ordering": true,
      "order": [], 
      "ajax": {
        "url": "<?= site_url($this->uri_mod . '/ajax_datatables?n=' . _get('n')) ?>",
        "type": "POST",
        "data": function (d) {
            d.filter_kategori = $('#filter_kategori').val(); 
            // CSRF Token Check
            d.<?php echo $this->security->get_csrf_token_name(); ?> = '<?php echo $this->security->get_csrf_hash(); ?>';
        }
      },
      "columns": [
        { title: "No", className: "text-center" },
        { title: "Aksi", className: "text-center" },
        { title: "Kode Aset" },
        { title: "Tgl Beli" },
        { title: "Umur Aset" },
        { title: "Harga Beli", className: "text-end" },
        { title: "Metode", className: "text-center" },
        { title: "Nilai Buku", className: "text-end" },
        { title: "Status", className: "text-center" }
      ]
    });

    $('#filter_kategori').change(function() {
        tabel.ajax.reload();
    });
  });

  // Fungsi Panggil Modal Konfirmasi
  function konfirmasiTutupBuku(periode) {
      // Panggil Helper Modal (sesuai sistem Anda)
      _modal(null, {
          uri: '<?= site_url($this->uri_mod . "/form_modal_tutup_buku") ?>',
          size: 'modal-md', 
          title: 'Konfirmasi Tutup Buku Periode',
          position: 'normal'
      });
  }

  
</script>